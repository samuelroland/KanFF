<?php
ob_start();
$title = "Connexion";
$instanceinfos = getInstanceInfos();
$instance = $instanceinfos['instance'];
$versions = getVersionsApp();
$lastVersion = $versions[count($versions) - 1];
?>

    <form class="formlog" action="?action=login" method="post">
        <div>
            <p class="aligncenter"><?= $instanceinfos['collective']['msg'] ?></p>
            <?php if (contains($lastVersion['version'], "beta") == true) {
                echo "<p class='text-primary statebanner'><strong>Une version bêta est installée. Cette version est donc instable, contient des bugs et des fonctionnalités à moitié implémentée... Elle ne doit pas être utilisée en conditions réelles (que dans un but de tests).</strong></p>";
            } ?>
            <?php if ($instance['testinstance'] == true) {
                echo "<p class='text-danger'><strong>Vous êtes sur une instance de test et les données sont fictives. Elles doivent le rester car elles sont accessibles publiquement! (Ne créez pas de compte, projet, travail, tâche, groupe, ... réel).</strong></p>";
            } ?>
            <div class="box-aligncenter pt-4"><img src="view/medias/logos/KanFF_Logo.svg" alt="logoLog" class="logoLog">
                <br><span class="versiontext"></span>
                <span class="versiontext"></span></div>
        </div>
        <h1 class="aligncenter pt-4"><?= $title ?></h1>
        <div class="form-group">
            <label for="infoLogin">Nom d'utilisateur·ice, initiales ou email</label>
            <input type="text" width="auto" class="form-control" name="infoLogin" id="infoLogin" autofocus
                   placeholder="josette27 ou JRD/jrd ou josette.richard@assoc.ch"
                   minlength="3" required>
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
            <br>
            <p class="flex-1">Pas encore de compte sur cette instance ? <a href="?action=signin">Créer un compte.</a>
            </p>
            <?php //<p class="alignright"><a href="link" target="_blank">En savoir plus sur KanFF.</a></p> ?>
        </div>

    </form>
<?php
$contenttype = "restricted";
$content = ob_get_clean();

require "gabarit.php";
?>