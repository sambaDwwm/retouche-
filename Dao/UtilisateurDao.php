<?php

namespace Dao;

use Connexion;

class UtilisateurDao extends BaseDao
{

    public function ajoutUtilisateur($pseudo, $motDePasse, $entreprise)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "INSERT INTO utilisateur (pseudo, mot_de_passe, entreprise)
             VALUES (?,?,?)"
        );

        $requete->execute(
            [
                $pseudo,
                password_hash($motDePasse, PASSWORD_BCRYPT),
                $entreprise
            ]
        );
    }

    public function findByPseudo($pseudo)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "SELECT * FROM utilisateur WHERE pseudo = ?"
        );

        $requete->execute([$pseudo]);

        $tableauUtilisateur = $requete->fetch();

        //si un utilisateur a bien ce pseudo
        if ($tableauUtilisateur) {
            return $this->transformeTableauEnObjet($tableauUtilisateur);
        } else {
            return false;
        }
    }


    public function supprimerCompetenceUtilisateur($idCompetence, $idUtilisateur)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "DELETE FROM competence_utilisateur
             WHERE id_competence = ? AND id_utilisateur = ?"
        );

        $requete->execute(
            [
                $idCompetence,
                $idUtilisateur
            ]
        );
    }

    public function modifierUtilisateur($id, $pseudo, $nomAvatar)
    {
        $connexion = new Connexion();

        if ($nomAvatar != "") {
            $requete = $connexion->prepare(
                "UPDATE utilisateur 
                SET pseudo = ?, nom_avatar = ?
                WHERE id = ?"
            );
            $requete->execute(
                [$pseudo, $nomAvatar, $id]
            );
        } else {
            $requete = $connexion->prepare(
                "UPDATE utilisateur 
                SET pseudo = ?
                WHERE id = ?"
            );
            $requete->execute(
                [$pseudo, $id]
            );
        }
    }

    public function ajouterCompetenceUtilisateur($idUtilisateur, $idCompetence)
    {

        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "INSERT INTO competence_utilisateur (id_competence, id_utilisateur)
             VALUES(? , ?)"
        );

        $requete->execute(
            [
                $idCompetence,
                $idUtilisateur
            ]
        );
    }
}
