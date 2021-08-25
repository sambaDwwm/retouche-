<?php

namespace Controller;

use Config;


abstract class BaseController
{


    public function afficherVue($fichier = "index", $donnees = [])
    {
        extract($donnees);

        if (isset($_SESSION['message'])) {

            $typeMessage = isset($_SESSION['type-message']) ? $_SESSION['type-message'] : "info";

            include("View/message.php");

            unset($_SESSION['message']);
        }

        $dossier =  substr(get_class($this), 11, -10);

        include("./View/" . $dossier . "/" . $fichier . ".php");
    }

    public function afficherMessage($message, $typeMessage = "info")
    {
        $_SESSION['message'] = $message;
        $_SESSION['type-message'] = $typeMessage; //warning, danger, info, success
    }

    public function redirection($chemin = "")
    {
        header("Location: " . Config::$baseUrl . "/" . $chemin);
        die();
    }
}
