<?php

namespace View;

class ViewUtil
{

    public static function ajouterChamps(
        $valeur,
        $name,
        $label,
        $erreur = "",
        $placeholder = "",
        $type = "text",
        $largeur = 300,
        $classeDiv = "form-group",
        $classeInput = "form-control",
        $classeErreur = "invalid-feedback"
    ) {
?>
        <div class="<?= $classeDiv ?> <?= $erreur != "" ? "has-danger" : "" ?>">
            <label for="inputDefault"><?= $label ?></label>
            <input style="max-width:<?= $largeur ?>px" value="<?= $valeur ?>" name="<?= $name ?>" type="<?= $type ?>" class="<?= $classeInput ?> <?= $erreur != "" ? "is-invalid" : "" ?>" placeholder="<?= $placeholder ?>">

            <?php
            if ($erreur != "") {
            ?>
                <div class="<?= $classeErreur ?>"><?= $erreur ?></div>
            <?php
            }
            ?>
        </div>
<?php
    }
}
