<?php
ob_start();


?>

    <form class="formlog" action="index.php?action=login" method="post">
        <div>
            <a>Bienvenue sur l'instance Blason. L'instance KanFF de Assoc pour toute la Romandie.</a>
            <div class="left"><img src="view/medias/logos/temp-logo.png" alt="logoLog" class="logoLog"> <br><span class="versiontext"></span>
                <span class="versiontext"></span></div>
        </div>
        <h1>Connexion</h1>
        <div class="form-group" style="text-align: left">
            <label  for="infoLogin">Nom d'utilisateur, Email ou Initials</label>
            <input type="text"  class="form-control" name="infoLogin" id="infoLogin" aria-describedby="emailHelp" placeholder="nom d'utilisateur ou email" required="required">
        </div>
        <div class="form-group" style="text-align: left">
            <label for="password">Mot de passe</label>
           <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
        </div>
        <div>
            <div class="vertical-center" >
        <button type="submit" class="btn btn-primary btn-block button1 ">Login</button>
            </div>
        <p>Pas encore de compte sur cette instance Blason? <a href="/?action=signin">Créer un compte</a></p>

        </div>
        <?php if ($_SESSION['error'] = 1) {
            echo "<br><p class='alert-warning'>Les Donnés introduits ne sont pas correctes</p>";
        }?>
    </form>


y
<?php
$content = ob_get_clean();
require "gabarit.php";
?>