<?php
ob_start();


?>

    <form class="formlog" action="index.php?action=login" method="post">
        <div>
            <a>Bienvenue sur l'instance Blason. L'instance KanFF de GdC pour toute la Romandie.</a>
            <div class="left"><img src="view/medias/logos/temp-logo.png" alt="logoLog" class="logoLog"> <br><span class="versiontext"></span>
                <span class="versiontext"></span></div>
        </div>
        <h1>Connexion:</h1>
        <div class="form-group" style="text-align: left">
            <label  for="infoLogin">Utilisateur ,Email ou Initials :</label>
            <input type="text"  class="form-control" name="infoLogin" id="infoLogin" aria-describedby="emailHelp" placeholder="Email, username ou initials" required="required">
        </div>
        <div class="form-group" style="text-align: left">
            <label for="password"> Mot de passe : </label>
           <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
        </div>
        <div>
        <button type="submit" class="btn btn-primary btn-block ">Login</button>
        <p>Pas encore de compte sur cette instance Blason?</p>
        <a href="index.php?action=signin"><p>Créer un compte</p></a>
        </div>
    </form>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>