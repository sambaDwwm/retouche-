<h1>listes des offres</h1>

<?php

foreach ($listeOffres as $offre) {
?>

    <div class="card border-primary mb-3" style="max-width: 20rem;">
        <div class="card-header">
            <div>Publier par : <?php echo $offre->getUtilisateur()->getPseudo(); ?></div>

            <?php
            if ($offre->getDomaine()->getDesignation()) {
            ?>
                <span class="badge rounded-pill bg-info">
                    <?php echo $offre->getDomaine()->getDesignation(); ?>
                </span>
            <?php
            }

            foreach ($offre->getListeCompetence() as $competence) {
            ?>
                <span class="badge rounded-pill bg-info">
                    <?php echo $competence->getDesignation(); ?>
                </span>
            <?php
            }

            ?>
        </div>
        <div class="card-body">
            <h4 class="card-title"><?php echo $offre->getTitre(); ?></h4>
            <p class="card-text"><?php echo substr($offre->getDescription(), 0, 100); ?>...</p>
            <?php
            if (isset($_SESSION["utilisateur"])) {
                $utilisateurConnecte = unserialize($_SESSION["utilisateur"]);

                //si l'utilisateur connecté est le propriétaire de l'offre,
                // alors on affiche les boutons "modifier" et "supprimer"
                $idUtilisateurOffre = $offre->getUtilisateur()->getId();
                if ($idUtilisateurOffre == $utilisateurConnecte->getId()) {
            ?>
                    <a href="<?= Config::$baseUrl ?>/offre/modifier/<?php echo $offre->getId(); ?>" class="btn btn-info">Modifier l'offre</a>

                    <a href="<?= Config::$baseUrl ?>/offre/supprimer/<?php echo $offre->getId(); ?>" class="btn btn-danger">Supprimer l'offre</a>
            <?php
                }
            }
            ?>
            <a href="<?= Config::$baseUrl ?>/offre/detail/<?php echo $offre->getId(); ?>" class="btn btn-primary">Voir les details de l'offre</a>
        </div>
    </div>

<?php
}
?>