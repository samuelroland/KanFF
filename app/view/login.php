<?php
ob_start();


?>

    <form class="formlog" action="index.php?action=tryLogIn" method="post">
        <div>
        <a>Bienvenue sur l'instance Blason. L'instance KanFF de GdC pour toute la Romandie.</a>
        </div>
        <div class="form-group" action="index.php?action=tryLogIn" method="post">
            <label for="exampleInputEmail1">Utilisateur ou Email :</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email or Username" required="required">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1"> Mot de passe : </label>
           <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required="required">
        </div>
        <button type="submit" class="btn btn-primary btn-block ">Login</button>
        <p>Pas encore de compte sur cette instance Blason?</p>
        <a href="index.php?action=signin"><p>Créez un copte et rejoignez ensuite un collectif!</p></a>
    </form>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>