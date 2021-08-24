<form method="POST">

    <div class="form-group">
        <label>Titre</label>
        <input value="<?= $titre ?>" style="max-width:300px" name="titre" type="text" class="form-control" placeholder="Titre de l'offre (ex : 'Développeur')">
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control" placeholder="Descrition de l'offre (ex : 'Une offre trop top !')"><?= $description ?></textarea>
    </div>

    <?php if ($modification) { ?>
        <ul>
            <?php
            foreach ($listeCompetenceOffre as $competence) {
            ?>
                <li>
                    <span><?= $competence->getDesignation() ?></span>
                    <a class=" btn btn-danger" href="<?= Config::$baseUrl ?>/offre/supprimerCompetence/<?= $id ?>/<?= $competence->getId() ?>">
                        supprimer
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    <?php } ?>

    <div class="form-group">
        <label>Ajouter une compétence</label>
        <select name="competence" style="max-width: 400px;" class="form-select">
            <option value="">Selectionner une compétence</option>
            <?php
            foreach ($listeCompetence as $competence) {
            ?>
                <option value="<?= $competence->getId() ?>">
                    <?= $competence->getDesignation() ?>
                </option>
            <?php
            }
            ?>
        </select>
    </div>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="<?php echo $modification ? "Modifier l'offre" : "Ajouter l'offre" ?>">

</form>