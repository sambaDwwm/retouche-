<form method="POST">

    <div class="form-group">
        <label for="inputDefault">Pseudo</label>
        <input style="max-width:300px" value="<?= $pseudo ?>" name="pseudo" type="text" class="form-control" placeholder="Pseudo">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Mot de passe</label>
        <input style="max-width:300px" name="motDePasse" type="password" class="form-control" placeholder="Mot de passe">
    </div>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="Connexion">

</form>