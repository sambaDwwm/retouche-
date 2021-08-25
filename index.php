<?php
session_start();

//initialisation de l'autoloader (il permet lors du l'utilisation du mot clé "use" d'effectuer un include du fichier correspondant)
include("Autoloader.php");

use App\Autoloader;

Autoloader::register();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        
                    
                       
                        <?php
                        if (isset($_SESSION["utilisateur"])) {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Config::$baseUrl ?>/utilisateur/deconnexion">Deconnexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Config::$baseUrl ?>/utilisateur/profil">
                                    <?php
                                    if (isset($_SESSION["utilisateur"])) {
                                        $utilisateur = unserialize($_SESSION["utilisateur"]);
                                        $urlAvatar = Config::$baseUrl . "/upload/" . $utilisateur->getNomAvatar();
                                    ?>
                                        <img src="<?= $urlAvatar ?>" style="width:32px;height:32px;border-radius: 16px;">
                                    <?php
                                    }
                                    ?>
                                </a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= Config::$baseUrl ?>/utilisateur/connexion">Connexion</a>
                            </li>
                            

                        <?php
                        }
                        ?>

                        
                </div>
            </div>
        </nav>

    </header>

    <?php

    Application::demarrer();

    ?>
</body>

</html>