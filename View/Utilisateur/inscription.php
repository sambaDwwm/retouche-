<form method="POST">



    <div class="form-group">
        <label class="form-label mt-4">Nom</label>
        <input style="max-width:300px" name="nom" type="text" class="form-control" placeholder="Nom">
    </div>
    <div class="form-group">
        <label class="form-label mt-4">Prenom</label>
        <input style="max-width:300px" name="prenom" type="text" class="form-control" placeholder="Prenom">
    </div>
    <div class="form-group">
        <label for="inputDefault">Email</label>
        <input style="max-width:300px" value="<?= $email ?>" type="email" id="email"
       class="form-control" placeholder="Email">
    </div>
   
    <div class="form-group">
        <label class="form-label mt-4">Enter your phone number:</label>
        <input style="max-width:300px" name="phone" type="tel" class="form-control" required>
    </div>
    <div class="form-group">
        <label class="form-label mt-4">Mot de passe</label>
        <input style="max-width:300px" name="mot_de_passe" type="password" class="form-control" placeholder="Mot de passe">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Confirmer le mot de passe</label>
        <input style="max-width:300px" name="confirm_mot_de_passe" type="password" class="form-control" placeholder="Mot de passe">
    </div>

    <div class="form-group">
        <label class="form-label mt-4">Etes-vous un Administrateur ?</label>
        <input name="admin" type="checkbox" <?php if ($admin) echo "checked"; ?>>
    </div>

    <input style="margin-top:20px" type="submit" class="btn btn-success" value="Inscription">

</form>