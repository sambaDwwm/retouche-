<form method="POST">

    <div class="form-group">
        <label for="inputDefault">Pseudo</label>
        <input style="max-width:300px" value="<?= $pseudo ?>" name="pseudo" type="text" class="form-control" placeholder="Pseudo">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Mot de passe</label>
        <input style="max-width:300px" name="motDePasse" type="password" class="form-control" placeholder="Mot de passe">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Confirmer le mot de passe</label>
        <input style="max-width:300px" name="confirmeMotDePasse" type="password" class="form-control" placeholder="Mot de passe">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Etes-vous une entreprise ?</label>
        <input name="entreprise" type="checkbox" <?php if ($entreprise) echo "checked"; ?>>
    </div>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="Inscription">

</form>