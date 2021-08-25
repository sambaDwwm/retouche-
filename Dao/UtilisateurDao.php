<?php

namespace Dao;

use Connexion;

class UtilisateurDao extends BaseDao
{

    public function ajoutUtilisateur($nom, $prenom, $email, $phone, $motDePasse, $admin)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "INSERT INTO utilisateur (nom, prenom, email, phone,  mot_de_passe, admin)
             VALUES (?,?,?,?,?,?)"
        );

        $requete->execute(
            [
                $nom,
                $prenom,
                $email,
                $phone,
                password_hash($motDePasse, PASSWORD_BCRYPT),
                $admin
            ]
        );
    }

    public function findByEmail($email)
    {
        $connexion = new Connexion();

        $requete = $connexion->prepare(
            "SELECT * FROM utilisateur WHERE email = ?"
        );

        $requete->execute([$email]);

        $tableauUtilisateur = $requete->fetch();

        //si un utilisateur a bien ce email
        if ($tableauUtilisateur) {
            return $this->transformeTableauEnObjet($tableauUtilisateur);
        } else {
            return false;
        }
    }


    

    public function modifierUtilisateur($id, $email, $nomAvatar)
    {
        $connexion = new Connexion();

        if ($nomAvatar != "") {
            $requete = $connexion->prepare(
                "UPDATE utilisateur 
                SET email = ?, nom_avatar = ?
                WHERE id = ?"
            );
            $requete->execute(
                [$email, $nomAvatar, $id]
            );
        } else {
            $requete = $connexion->prepare(
                "UPDATE utilisateur 
                SET email = ?
                WHERE id = ?"
            );
            $requete->execute(
                [$email, $id]
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
