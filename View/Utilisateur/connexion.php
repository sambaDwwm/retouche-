<form method="POST">

    <div class="form-group">
        <label for="inputDefault">Email</label>
        <input style="max-width:300px" value="<?= $email ?>" name="email" type="email" class="form-control" placeholder="email">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Mot de passe</label>
        <input style="max-width:300px" name="motDePasse" type="password" class="form-control" placeholder="Mot de passe">
    </div>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="Connexion">

    
    <a class="nav-link" href="<?= Config::$baseUrl ?>/utilisateur/inscription">Créer un compte</a>
                            
</form>