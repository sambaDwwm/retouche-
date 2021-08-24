<?php

namespace Dao;

use Connexion;
use Model\Competence;
use Model\Domaine;
use Model\Utilisateur;

class OffreDao extends BaseDao
{
    public function ajouterOffre($titre, $description)
    {

        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "INSERT INTO offre (titre, description)
             VALUES (?,?)"
        );

        $requete->execute(
            [
                $titre,
                $description
            ]
        );
    }

    public function modifierOffre($id, $titre, $description)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "UPDATE offre 
             SET titre = ?, description = ? 
             WHERE id = ?"
        );

        $requete->execute(
            [
                $titre,
                $description,
                $id
            ]
        );
    }

    public function recherche($mot)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "SELECT o.id, o.titre, o.description, o.id_utilisateur, u.pseudo, o.id_domaine, d.designation
             FROM offre o
             JOIN utilisateur u ON o.id_utilisateur = u.id 
             LEFT JOIN domaine d ON o.id_domaine = d.id
             WHERE titre LIKE :mot 
             OR description LIKE :mot
             OR pseudo LIKE :mot
             OR d.designation LIKE :mot"
        );

        $requete->execute(
            [":mot" => "%" . $mot . "%"]
        );

        $listeOffre = [];

        foreach ($requete->fetchAll() as $ligneOffre) {
            $offre = $this->transformeTableauEnObjet($ligneOffre);

            $utilisateur = new Utilisateur();
            $utilisateur->setId($ligneOffre['id_utilisateur']);
            $utilisateur->setPseudo($ligneOffre['pseudo']);
            $offre->setUtilisateur($utilisateur);

            $domaine = new Domaine();
            $domaine->setId($ligneOffre['id_domaine']);
            $domaine->setDesignation($ligneOffre['designation']);
            $offre->setDomaine($domaine);

            $listeOffre[] = $offre;
        }

        return $listeOffre;
    }

    public function findAllAvecInfo()
    {
        $connexion = new Connexion();

        $resultat = $connexion->query(
            "SELECT o.id, o.titre, o.description, 
                    co.id_competence, c.designation as 'designation_competence', 
                    o.id_utilisateur, u.pseudo, 
                    o.id_domaine, d.designation
             FROM offre o
             JOIN utilisateur u ON o.id_utilisateur = u.id
             LEFT JOIN domaine d ON o.id_domaine = d.id
             LEFT JOIN competence_offre co ON co.id_offre = o.id
             LEFT JOIN competence c ON co.id_competence = c.id
             "
        );

        $listeOffre = [];

        foreach ($resultat->fetchAll() as $ligneOffre) {
            $offre = $this->transformeTableauEnObjet($ligneOffre);

            $utilisateur = new Utilisateur();
            $utilisateur->setId($ligneOffre['id_utilisateur']);
            $utilisateur->setPseudo($ligneOffre['pseudo']);
            $offre->setUtilisateur($utilisateur);

            $domaine = new Domaine();
            $domaine->setId($ligneOffre['id_domaine']);
            $domaine->setDesignation($ligneOffre['designation']);
            $offre->setDomaine($domaine);

            $competence = new Competence();
            $competence->setId($ligneOffre['id_competence']);
            $competence->setDesignation($ligneOffre['designation_competence']);

            //si on a déjà ajouté une offre ayant cet ID
            //on se contente d'ajouter la compétence à l'offre déja créée
            if (isset($listeOffre[$offre->getId()])) {

                $ancienneOffre = $listeOffre[$offre->getId()];
                $ancienneOffre->ajoutCompetence($competence);

                //sinon on ajoute l'offre à la liste
            } else {
                $offre->ajoutCompetence($competence);
                $listeOffre[$offre->getId()] = $offre;
            }
        }

        return $listeOffre;
    }

    function ajouterCompetence($idOffre, $idCompetence)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "INSERT INTO competence_offre (id_competence, id_offre)
             VALUES (:id_competence, :id_offre)"
        );

        $requete->execute([
            ":id_competence" => $idCompetence,
            ":id_offre" => $idOffre
        ]);
    }

    function supprimerCompetence($idOffre, $idCompetence)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "DELETE FROM competence_offre 
             WHERE id_competence = :id_competence
             AND id_offre = :id_offre"
        );

        $requete->execute([
            ":id_competence" => $idCompetence,
            ":id_offre" => $idOffre
        ]);
    }

    //retourne l'id de l'utilisateur de l'offre
    public function findIdUtilisateurOffre($idOffre)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "SELECT id_utilisateur
             FROM offre 
             WHERE id = :id_offre"
        );

        $requete->execute([
            ":id_offre" => $idOffre
        ]);

        $offre = $requete->fetch();

        return $offre["id_utilisateur"];
    }
}
