<?php

namespace Controller;

use Config;
use Dao\CompetenceDao;
use Dao\UtilisateurDao;
use Model\Utilisateur;

class UtilisateurController extends BaseController
{

    public function profil()
    {
        $erreurAvatar = "";
        $erreurPseudo = "";

        $utilisateur = unserialize($_SESSION["utilisateur"]);
        $idUtilisateurConnecte = $utilisateur->getId();

        //si l'utilisateur valide le formulaire 
        if (isset($_POST["pseudo"])) {

            $utilisateurDao = new UtilisateurDao();

            if (strlen($_POST["pseudo"]) < 3) {
                $erreurPseudo = "Votre pseudo doit contenir au moins 3 caractères";
            }

            if ($_POST["competence"] != "") {
                $utilisateurDao->ajouterCompetenceUtilisateur(
                    $idUtilisateurConnecte,
                    $_POST["competence"]
                );
            }

            $nomAvatar = "";

            //si l'utilisateur à selectionné une image
            if ($_FILES['avatar']['name'] != "") {

                //on recupere le nom original de l'image (sur l'ordinateur local)
                $nomOrigine = $_FILES['avatar']['name'];

                //on decoupe le nom par le caractère "." 
                $decoupageNomOrigine = explode(".", $nomOrigine);

                //on recupere la dernière partie du nom (cad l'extension) 
                //la fonction "end" retourne le dernier élément d'un tableau
                //sinon : $extension = $decoupageNomOrigine[count($decoupageNomOrigine) - 1];
                $extension = strtolower(end($decoupageNomOrigine));
                $listeExtensionValides = ["jpg", "png", "jpeg"];

                if (in_array($extension, $listeExtensionValides)) {

                    //on recupere le nom que apache a donné à l'image temporaire
                    $nomTemporaireAvatar = $_FILES['avatar']['tmp_name'];

                    //on change le nom de l'avatar pour un nom unique 
                    $nomAvatar = $_POST["pseudo"] . "_" . $nomOrigine;

                    //on deplace l'image temporaire vers notre dossier d'upload
                    move_uploaded_file(
                        $nomTemporaireAvatar,
                        "./upload/" . $nomAvatar
                    );
                } else {
                    $erreurAvatar = "L'extension doit être jpg, jpeg ou png";
                }
            }

            //si il n'y a aucune erreur
            if ($erreurPseudo == "" && $erreurAvatar == "") {

                //on va enregistrer le nom de l'image renommée dans la bdd
                $utilisateurDao->modifierUtilisateur(
                    $idUtilisateurConnecte,
                    $_POST["pseudo"],
                    $nomAvatar
                );

                //on met l'utilisateur à jour dans la session
                $nouvelUtilisateur = new Utilisateur();
                $nouvelUtilisateur->setId($idUtilisateurConnecte);
                $nouvelUtilisateur->setPseudo($_POST["pseudo"]);

                //on met à jour l'avatar dans la session uniquement si il a été changé, 
                // sinon on garde celui sauvegarder à l'origine dans la session
                $nouvelUtilisateur->setNomAvatar(
                    $nomAvatar == "" ? $utilisateur->getNomAvatar() : $nomAvatar
                );

                $_SESSION["utilisateur"] = serialize($nouvelUtilisateur);

                $this->afficherMessage("Votre profil a bien été mis à jour");
            } else {
                $this->afficherMessage("Certains champs comportent des erreurs", "warning");
            }
        }

        $dao = new CompetenceDao();
        $listeCompetenceUtilisateur =
            $dao->findByIdUtilisateur($idUtilisateurConnecte);

        $listeCompetence = $dao->findAll();

        $listeCompetenceNonAttribuee = [];

        //pour chaque competence de la table competence
        foreach ($listeCompetence as $competence) {

            $dejaAttribue = false;

            //on vérifie si l'utilisateur a deja cette competenceparmis toutes ses competences
            foreach ($listeCompetenceUtilisateur as $competenceUtilisateur) {


                if ($competence->getId() == $competenceUtilisateur->getId()) {
                    $dejaAttribue = true;
                    //on sort de ce foreach, il est inutile de chercher plus loin
                    // puisque le doublon a été trouvé
                    break;
                }
            }

            if (!$dejaAttribue) {
                $listeCompetenceNonAttribuee[] = $competence;
            }
        }

        $donnees = compact(
            "listeCompetenceNonAttribuee",
            "listeCompetenceUtilisateur",
            "utilisateur",
            "erreurAvatar",
            "erreurPseudo"
        );

        $this->afficherVue("profil", $donnees);
    }

    public function connexion()
    {
        $pseudo = "";

        //si l'utilisateur a validé le formulaire
        if (isset($_POST['pseudo'])) {

            $pseudo = $_POST['pseudo'];
            $dao = new UtilisateurDao();
            $utilisateur = $dao->findByPseudo($_POST['pseudo']);

            //si le pseudo existe et que le mot de passe correspond
            if ($utilisateur && password_verify($_POST['motDePasse'], $utilisateur->getMotDePasse())) {
                $_SESSION["utilisateur"] = serialize($utilisateur);
                $this->afficherMessage("Vous êtes connecté");
                $this->redirection();
            } else {
                $this->afficherMessage("mauvais pseudo / mot de passe", "danger");
            }
        }

        $donnees = compact("pseudo");
        $this->afficherVue("connexion", $donnees);
    }

    public function deconnexion()
    {
        session_destroy();
        session_start();
        $this->afficherMessage("Vous êtes deconnecté");
        $this->redirection();
    }

    public function inscription()
    {
        $pseudo = "";
        $entreprise = false;

        //si l'utilisateur a valider le formulaire
        if (isset($_POST["pseudo"])) {

            $pseudo = $_POST["pseudo"];
            $entreprise = isset($_POST['entreprise']);

            if ($_POST["motDePasse"] == $_POST["confirmeMotDePasse"]) {

                $dao = new UtilisateurDao();

                //si l'utilisateur a coché la case "entreprise"
                /*if (isset($_POST['entreprise'])) {
                    $entreprise = 1;
                } else {
                    $entreprise = 0;
                }*/

                //$entreprise = isset($_POST['entreprise']) ? 1 : 0;

                $dao->ajoutUtilisateur(
                    $_POST['pseudo'],
                    $_POST['motDePasse'],
                    isset($_POST['entreprise']) ? 1 : 0
                );

                $this->afficherMessage("Vous êtes bien inscrit, veuillez vous connecter", "success");
                $this->redirection("utilisateur/connexion");
            } else {

                $this->afficherMessage("Les mots de passes sont différents", "danger");
            }
        }

        $donnees = compact('pseudo', 'entreprise');

        $this->afficherVue("inscription", $donnees);
    }

    public function supprimerCompetence($parametres)
    {
        $idCompetence = $parametres[0];

        $utilisateur = unserialize($_SESSION['utilisateur']);
        $idUtilisateur = $utilisateur->getId();

        $dao = new UtilisateurDao();
        $dao->supprimerCompetenceUtilisateur($idCompetence, $idUtilisateur);

        $this->afficherMessage("La competence a bien été supprimée", "success");
        $this->redirection("utilisateur/profil");
    }
}
