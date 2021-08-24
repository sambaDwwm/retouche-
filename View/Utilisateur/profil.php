<form method="POST" enctype="multipart/form-data">

    <?php

    use View\ViewUtil;

    ViewUtil::ajouterChamps($utilisateur->getPseudo(), "pseudo", "Pseudo", $erreurPseudo, "Votre pseudo");
    ?>

    <ul>
        <?php
        foreach ($listeCompetenceUtilisateur as $competence) {
        ?>
            <li style="margin-bottom: 10px">
                <span style="display:inline-block; min-width: 200px;"><?= $competence->getDesignation() ?></span>
                <a href="<?= Config::$baseUrl ?>/utilisateur/supprimerCompetence/<?= $competence->getId() ?>" class=" btn btn-danger">
                    supprimer
                </a>
            </li>
        <?php
        }
        ?>
    </ul>

    <div style="display:flex; align-items: baseline;" class="form-group">
        <select id="select-competence" onchange="onChangeCompetence()" name="competence" style="max-width: 400px;" class="form-select">
            <option value="">Selectionnez une compétence à ajouter</option>
            <?php
            foreach ($listeCompetenceNonAttribuee as $competence) {
            ?>
                <option value="<?= $competence->getId() ?>">
                    <?= $competence->getDesignation() ?>
                </option>
            <?php
            }
            ?>
        </select>
        <script>
            function onChangeCompetence() {

                const idCompetence = document.querySelector("#select-competence").value;
                const bouton = document.querySelector("#bouton-ajout-competence");

                /*if (idCompetence != "") {
                    bouton.disabled = false;
                } else {
                    bouton.disabled = true;
                }*/

                bouton.disabled = idCompetence == "";

            }
        </script>
        <input id="bouton-ajout-competence" disabled style="margin-top:20px;" type="submit" class="btn btn-success" value="Ajouter">
    </div>

    <?php
    ViewUtil::ajouterChamps("", "avatar", "Photo de profil", $erreurAvatar, "", "file", 600);
    ?>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="Modifier le profil">

</form>