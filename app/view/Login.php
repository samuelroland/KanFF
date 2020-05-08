<?php
ob_start();


?>

    <form class="formlog" action="index.php?action=tryLogIn" method="post">
        <div>
        <a>Bienvenue sur l'instance Blason. L'instance KanFF de GdC pour toute la Romandie.</a>
            <img src="medias/logos/vuLogoLogin.png" alt="" width="301" height="167">
        </div>
        <div class="form-group" action="index.php?action=tryLogIn" method="post">
            <label for="exampleInputEmail1">Utilisateur ou Email :</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter or Username">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1"> Mot de passe : </label>
           <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary btn-block ">Login</button>
        <p>Pas encore de compte sur cette instance Blason?</p>
        <a href="index.php?action=displaySignin"><p>Créez un copte et rejoignez ensuite un collectif!</p></a>
    </form>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>