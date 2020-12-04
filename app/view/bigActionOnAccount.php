<?php
/**
 *  Project: KanFF
 *  File: bigActionOnAccount.php page for the 2 big actions on accounts: archive and delete account
 *  Author: Samuel Roland
 *  Creation date: 29.11.2020
 */

//Choose texts depending on the action choosed:
switch ($option) {
    case "delete":
        $textChosen = USER_SENTENCES_DELETE;
        break;
    case "archive":
        $textChosen = USER_SENTENCES_ARCHIVE;
        break;
    default:
        die("Dev Error in the \$option for bigActionOnAccount.php");
}
$cssForSpan = "box-verticalaligncenter spanForForm";
$cssForInput = "form-control inputForForm nomargin";

ob_start();
?>
    <div class="<?= $cssForDivZone ?>">
        <div class="flexdiv">
            <h1 class="flex-1"><?= $textChosen["title"] ?></h1>
        </div>
        <?php printPageWIPTextInfo(); ?>
        <p><?= $textChosen["introduction"] ?></p>
        <div class="">
            <hr class="hrlight">
            <h5>Conséquences détaillées</h5>
            <p><?= $textChosen["consequences"] ?></p>
        </div>
        <hr class="hrlight">
        <form action="?action=<?=  ?>Account" method="POST">
            <div id="divDeleteValidation" class="">
                <p id="pDeleteValidationText" class="txtdarkbluelogo font-italic">
                    <?= $textChosen["textToCopy"] ?>
                </p>
                <textarea name="sentence" id="txtSentenceDeleteValidation" rows="4"
                          class="fullwidth form-control nomargin"
                          placeholder="Veuillez accepter et recopier le texte ci-dessus."
                required></textarea>
            </div>
            <hr class="hrlight">
            <div class="">
                <h5 class="<?= $cssForSpan ?>">Confirmation</h5>
                <input id="inpPassword" class="<?= $cssForInput ?> d-inline" type="password" name="password" required
                       title="Mot de passe de validation"/>
                <!--<p class="errormsg" id="pErrorUsername" hidden>Le nom d'utilisateur/trice doit être alphanumérique
                    (lettre et nombres, tirets du bas acceptés).</p>-->
                <?= createToolTipWithPoint($textChosen["verb"] . " étant une action très importante, nous avons besoin de
            votre confirmation pour valider l'action. Pour ceci rentrer le mot de passe de votre compte.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                <div class="divBtnCreate pt-4">
                    <input type="submit" class="btn btn-light" value="Annuler">
                    <input type="submit" class="btn btn-danger" value="<?= $textChosen["button"] ?>">
                </div>
            </div>
        </form>
    </div>


<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>