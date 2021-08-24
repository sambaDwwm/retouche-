<?php

namespace Controller;

use Controller\BaseController;
use Dao\CompetenceDao;
use Dao\OffreDao;

class OffreController extends BaseController
{

    public function afficherTout()
    {
        $dao = new OffreDao();

        if (isset($_POST["recherche"])) {
            $listeOffres = $dao->recherche($_POST["recherche"]);
        } else {

            $listeOffres = $dao->findAllAvecInfo();
        }

        //note equivaut à faire :
        /*$donnees = [
            'listeOffres' => $listeOffres
        ];*/
        $donnees = compact('listeOffres');

        $this->afficherVue("liste-offres", $donnees);
    }

    //ex, si l'url est : localhost/.../offre/detail/42
    //alors parametre[0] contiendra "42" (l'id de l'offre à afficher)
    public function detail($parametres)
    {
        $id = $parametres[0];

        $dao = new OffreDao();

        $offre = $dao->findById($id);

        $donnees = compact('offre');

        $this->afficherVue("detail-offre", $donnees);
    }

    public function ajouter()
    {
        $modification = false;
        $titre = "";
        $description = "";

        if (isset($_POST["titre"])) {

            $dao = new OffreDao();

            $dao->ajouterOffre($_POST['titre'], $_POST['description']);

            $this->afficherMessage("Votre annonce a bien été ajoutée", "success");
            $this->redirection("offre/afficherTout");
        }

        $donnees = compact("modification", "titre", "description");
        $this->afficherVue("editer-offre", $donnees);
    }

    public function supprimer($parametres)
    {
        $id = $parametres[0];

        if (isset($_POST["confirmation"])) {

            $dao = new OffreDao();
            $dao->deleteById($id);
            $this->afficherMessage("L'offre a bien été supprimée");
            $this->redirection("offre/afficherTout");
        }

        $this->afficherVue("confirmation-suppression");
    }

    public function modifier($parametres)
    {
        $modification = true;
        $id = $parametres[0];
        $titre = "";
        $description = "";

        $daoOffre = new OffreDao();
        $daoCompetence = new CompetenceDao();

        $listeCompetence = $daoCompetence->findAllNonAttribueOffre($id);

        if (isset($_POST["titre"])) {

            $daoOffre->modifierOffre($id, $_POST['titre'], $_POST['description']);

            $this->afficherMessage("L'offre a bien été modifiée");

            //si l'utilisateur a selectionné une compétence dans la liste déroulante
            if ($_POST["competence"] != "") {
                $daoOffre->ajouterCompetence($id, $_POST["competence"]);
            }
        }

        $offre = $daoOffre->findById($id);
        $titre = $offre->getTitre();
        $description = $offre->getDescription();

        $listeCompetenceOffre = $daoCompetence->findAllByIdOffre($id);


        $donnees = compact(
            "id",
            "modification",
            "titre",
            "description",
            "listeCompetence",
            "listeCompetenceOffre"
        );

        $this->afficherVue("editer-offre", $donnees);
    }

    public function supprimerCompetence($parametres)
    {
        $idOffre = $parametres[0];
        $idCompetence = $parametres[1];

        $daoOffre = new OffreDao();

        //On vérifie que l'utilisateur connecté est bien le propriétaire de l'offre
        $idUtilisateurOffre = $daoOffre->findIdUtilisateurOffre($idOffre);
        $utilisateur = unserialize($_SESSION["utilisateur"]);
        $idUtilisateurConnecte = $utilisateur->getId();

        if ($idUtilisateurOffre == $idUtilisateurConnecte) {
            $daoOffre->supprimerCompetence($idOffre, $idCompetence);
            $this->afficherMessage("La compétence a bien été supprimé", "success");
        } else {
            $this->afficherMessage("Vous ne pouvez pas modifier cette offre", "danger");
        }

        $this->redirection("offre/modifier/" . $idOffre);
    }
}
