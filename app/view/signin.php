<?php
ob_start();
$title = "Créer un compte";
$instanceinfos = getInstanceInfos();

//Define css classes for repetitives markups, to change it quickly
$cssForSpan = "col-md-5 col-sm-5 box-verticalaligncenter";
$cssForInput = "col-md-5 col-sm-7 form-control";
$cssForDivZone = "pl-3";
$cssForDivField = "row pt-1";
?>
<p class="aligncenter"><?= $instanceinfos['collective']['msg'] ?></p>
<div class="box-aligncenter pt-4"></div>
<div class="form-group">
    <h1 class="aligncenter pt-4"><?= $title ?></h1>
    <form style="align-self: auto" class="pt-3" action="?action=signin" method="post">
        <h5 class="pt-3">Informations principales:</h5>
        <div class="<?= $cssForDivZone ?>">
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Prénom</span>
                <input class="<?= $cssForInput ?>" minlength="2" maxlength="254" type="text" name="name"
                       placeholder="Josette"
                       required/>
            </div>
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Nom</span>
                <input class="<?= $cssForInput ?>" minlength="2" maxlength="254" type="text" name="surname"
                       placeholder="Richard" required/>
            </div>
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Initiales </span>
                <input class="<?= $cssForInput ?>" type="text" placeholder="JRD" readonly/>
                <img title="Les initiales sont uniques et générées automatiquement.
                Format: première lettre du prénom + la première lettre
                du nom + la dernière lettre du nom/2ème lettre du nom
                (en cas de conflit)."
                     src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">
            </div>
        </div>
        <h5 class="pt-3">Identification:<span title="Inserer le text volu"
                                              class="glyphicon glyphicon-question-sign"></span>
        </h5>
        <div class="<?= $cssForDivZone ?>">
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Nom d'utilisateur/trice</span>
                <input class="<?= $cssForInput ?>" minlength="4" maxlength="20" type="text" name="user"
                       placeholder="josette27" required/>
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Mot de passe</span>
                <input class="<?= $cssForInput ?>" type="password" name="password" placeholder="" required/>
                <img title="Les critères de sécurité du mot de passe sont:
                - yy caractères
                - caractères minuscules, majuscules, spéciaux, chiffres.
                - ... TBD" src="view/medias/icons/point.png" alt="50px" width="35" height="35" class="">
                            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Confirmation</span>
                <input class="<?= $cssForInput ?>" type="password" name="passwordc" placeholder="" required
                       title="Confirmation du mot de passe"/>
                <span title="Inserer le text volu" class=" glyphicon-question-sign"></span>
            </div>
        </div>

        <h5 class="pt-3">Champs facultatifs:</h5>
        <div class="<?= $cssForDivZone ?>">
            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Email</span>
                <input class="<?= $cssForInput ?>" type="email" name="email" placeholder="josette.richard@assoc.ch"/>
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">N°téléphone</span>
                <input class="<?= $cssForInput ?>" type="number" name="nb_phone" placeholder="Phone"/>
            </div>

            <div class="<?= $cssForDivField ?>">
                <span class="<?= $cssForSpan ?>">Biographie</span>
                <span class="fullwidth"><textarea name="biography" id="txtBiography" rows="2" placeholder="tbd"
                                                  class="fullwidth form-control"
                                                  title="Votre biographie"></textarea></span>

                <?php
                if (isset($_SESSION['error'])) {
                    if ($_SESSION['error'] == 1) {
                        echo "<br><p class='alert-warning'>Les mots de passe introduits ne se correspondent pas</p>";
                    }
                    if ($_SESSION["error"] == 2) {
                        echo "<br><p class='alert-warning'>Les initiales introduites sont déjà existantes</p>";
                    }

                    unset($_SESSION['error']);
                }
                ?>
            </div>
        </div>
        <div class="vertical-center box-alignright pt-3">
            <button type="submit" class="btn btn-primary">Création du compte</button>
        </div>

    </form>
    <p>Déjà un compte ? <a href="/?action=login">Connexion.</a></p>
</div>

<?php
$contenttype = "restricted";
$content = ob_get_clean();

require "gabarit.php";
?>


