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
        $title = "Suppression du compte";
        $verb = "Supprimer définitivement son compte";
        $button = "Supprimer définitivement mon compte";
        $introduction = "Attention cette action est irréversible !
            Si vous souhaitez quitter le collectif et disparaître entièrement, supprimer son compte est la bonne
            option. Si vous voulez rester dans les archives du collectif (sous les comptes archivés) et garder les
            références à votre compte tel quel, archiver son compte est une meilleure option.";
        $consequences = 'A part votre compte, rien ne sera supprimé... Seul les références à votre compte (permettant de savoir qui a créé une tâche, un travail, un groupe, ou une entrée de journal de bord) ou permettant
                de savoir qui est responsable de quelque chose (une tâche, un travail ou un projet) ainsi que les
                références vous liant à une adhésion à un groupe, seront supprimées (à les place, il sera affiché
                "Compte supprimé").';
        $textToCopy = "J'ai compris les conséquences de la suppression de mon compte sur les informations liées à mon
                compte, et je confirme vouloir supprimer mon compte de cette instance Blason de manière
                irréversible.";
        break;
    case "archive":
        $title = "Archivage du compte";
        $verb = "Archiver son compte";
        $button = "Archiver mon compte";
        $introduction = "asdfsdaf";
        $consequences = "asdfsdaf";
        $textToCopy = "asdfsdaf";
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
            <h1 class="flex-1"><?= $title ?></h1>
        </div>
        <?php printPageWIPTextInfo(); ?>
        <p><?= $introduction ?></p>
        <div class="">
            <hr class="hrlight">
            <h5>Conséquences détaillées</h5>
            <p><?= $consequences ?></p>
        </div>
        <hr class="hrlight">
        <form action="?action=deleteAccount" method="POST">
            <div id="divDeleteValidation" class="">
                <p id="pDeleteValidationText" class="txtdarkbluelogo font-italic">
                    <?= $textToCopy ?>
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
                <?= createToolTipWithPoint($verb . " étant une action très importante, nous avons besoin de
            votre confirmation pour valider l'action. Pour ceci rentrer le mot de passe de votre compte.", "icon-middlesmall ml-2 mr-2 m-2", false, "right") ?>
                <div class="divBtnCreate pt-4">
                    <input type="submit" class="btn btn-light" value="Annuler">
                    <input type="submit" class="btn btn-danger" value="<?= $button ?>">
                </div>
            </div>
        </form>
    </div>


<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>