<?php
ob_start();
$title = "Connexion";
$instanceinfos = getInstanceInfos();
?>

    <form class="formlog" action="?action=login" method="post">
        <div>
            <p class="aligncenter"><?= $instanceinfos['collective']['msg'] ?></p>
            <div class="box-aligncenter pt-4"><img src="view/medias/logos/KanFF_Logo.svg" alt="logoLog" class="logoLog"> <br><span class="versiontext"></span>
                <span class="versiontext"></span></div>
        </div>
        <h1 class="aligncenter pt-4"><?= $title ?></h1>
        <div class="form-group">
            <label  for="infoLogin">Nom d'utilisateur, initiales ou email</label>
            <input type="text" width="auto" class="form-control" name="infoLogin" id="infoLogin" autofocus aria-describedby="emailHelp" placeholder="josette27 ou JRD/jrd ou josette.richard@assoc.ch" minlength="3" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
           <input type="password" class="form-control" name="password" id="password" placeholder="" required>
        </div>
        <?php echo flashMessage(); ?>
        <div>
            <div class="box-alignright">
        <button type="submit" class="btn btn-primary mt-2">Se connecter</button>
            </div>
            <br><p>Pas encore de compte sur cette instance ? <a href="/?action=signin">Créer un compte.</a></p>
        </div>

    </form>
<?php
$contenttype = "restricted";
$content = ob_get_clean();

require "gabarit.php";
?>