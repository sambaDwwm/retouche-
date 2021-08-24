<?php

namespace Model;

class Offre
{

    protected $id;
    protected $titre;
    protected $description;
    protected $utilisateur;
    protected $domaine;
    protected $listeCompetence = [];

    public function ajoutCompetence($competence)
    {
        $this->listeCompetence[] = $competence;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set the value of utilisateur
     *
     * @return  self
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get the value of domaine
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * Set the value of domaine
     *
     * @return  self
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;

        return $this;
    }

    /**
     * Get the value of listeCompetence
     */
    public function getListeCompetence()
    {
        return $this->listeCompetence;
    }

    /**
     * Set the value of listeCompetence
     *
     * @return  self
     */
    public function setListeCompetence($listeCompetence)
    {
        $this->listeCompetence = $listeCompetence;

        return $this;
    }
}
