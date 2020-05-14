<?php
ob_start();


?>


    <form class="formlog" action="index.php?action=tryLogIn" method="post">
        <div>
            <h1 style="text-align: left ">Connexion:</h1>
            <div class="left"><img src="view/medias/logos/temp-logo.png" alt="logo" class="logo"> <br><span class="versiontext">v<?= $versions[count($versions)-1]['version'] ?></span>
                <span class="versiontext"><em> le <?= date("d.m.Y", strtotime($versions[count($versions)-1]['date'])) ?></em></span></div>
            <a>Bienvenue sur l'instance Blason. L'instance KanFF de GdC pour toute la Romandie.</a>

        </div>
        <div class="form-group" style="text-align: left" action="index.php?action=tryLogIn" method="post">
            <label  for="exampleInputEmail1">Utilisateur ou Email :</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email ou username" required="required">
        </div>
        <div class="form-group" style="text-align: left">
            <label for="exampleInputPassword1"> Mot de passe : </label>
           <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required="required">
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