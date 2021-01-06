<?php
$versions = getVersionsApp();
$action = $_GET['action'];
$instanceinfos = getInstanceInfos();
require ".const.php";

function displayManualIconIfActionIsNotManual($action, $title)
{
    if ($action != "manual") {  //displayed on every page except the manual itself
        echo '<div class="fullname alignright pl-3 justify-content-end box-verticalaligncenter">';
        echo createManualLink($title, true, "icon-small");
        echo "</div>";
    }
}

?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

    <!-- Bootstrap files -->
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="node_modules/bootstrap/dist/css/bootstrap-grid.min.css" rel="stylesheet">
    <link href="node_modules/bootstrap/dist/css/bootstrap-reboot.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Jquery files -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS files -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/groups.css" rel="stylesheet">
    <link href="css/projects.css" rel="stylesheet">
    <link href="css/works.css" rel="stylesheet">
    <link href="css/tasks.css" rel="stylesheet">
    <link href="css/members.css" rel="stylesheet">

    <!-- Js files  -->
    <script src="js/global.js"></script>
    <script src="js/gabarit.js"></script>
    <script src="js/groups.js"></script>
    <script src="js/members.js"></script>
    <script src="js/users.js"></script>
    <script src="js/projects.js"></script>
    <script src="js/tasks.js"></script>
    <script src="js/manual.js"></script>

</head>
<body>
<?php
//EasterEgg:
echo "<!-- ----------------------------------------------
            Save together the planet !

              ,,ggddY\"\"\"Ybbgg,,
          ,agd888b,_ \"Y8, ___`\"\"Ybga,
       ,gdP\"\"88888888baa,.\"\"8b    \"888g,
     ,dP\"     ]888888888P'  \"Y     `888Yb,
   ,dP\"      ,88888888P\"  db,       \"8P\"\"Yb,
  ,8\"       ,888888888b, d8888a           \"8,
 ,8'        d88888888888,88P\"' a,          `8,
,8'         88888888888888PP\"  \"\"           `8,
d'          I88888888888P\"                   `b
8           `8\"88P\"\"Y8P'                      8
8            Y 8[  _ \"                        8
8              \"Y8d8b  \"Y a                   8
8                 `\"\"8d,   __                 8
Y,                    `\"8bd888b,             ,P
`8,                     ,d8888888baaa       ,8'
 `8,                    888888888888'      ,8'
  `8a                   \"8888888888I      a8'
   `Yba                  `Y8888888P'    adP'
     \"Yba                 `888888P'   adY\"
       `\"Yba,             d8888P\" ,adP\"'
          `\"Y8baa,      ,d888P,ad8P\"'
               ``\"\"YYba8888P\"\"''

----------------------------------------------- -->";
?>

<!-- The full header -->
<header class="bg-header <?= ($debug == false) ? "header-fixed" : "" //the header is not fixed in debug mode because else devs can't see var_dump() results printed under the menu.
?>">

    <!-- Zone Logo with logo image + version texts -->
    <div class="divZoneLogo flexdiv">
        <div class="divLogo lineheigthsmall">
            <img src="view/medias/logos/KanFF_Logo.svg" alt="logo KanFF" class="logo clickable cursorpointer"
                 data-href="?">
            <div class="divVersion ">
                <span class="versiontext "><?= $versions[count($versions) - 1]['version'] ?></span>
                <span class="versiontext alignright"><em>le <?= date("d.m.Y", strtotime($versions[count($versions) - 1]['date'])) ?></em></span>
            </div>
        </div>
        <div data-href="?action=about"
             class="flex-3 collectivename flexdiv overflow-hidden borderleftorange borderrightorange clickable cursorpointer <?= ($action == "about") ? 'active' : '' //button active or not
             ?>">
            <div class="align-items-center flexdiv"><?= $instanceinfos['collective']['name'] ?></div>
        </div>
    </div>

    <!-- Zone User with user firstname+lastname and circle with initials, the dropdown and the bell -->
    <?php if (isset($_SESSION['user']['id'])) { //if user is logged?>
        <div class="borderleftorange user row justify-content-end flexdiv borderrightorange">
            <!-- The bell and the fullname-->
            <!--<div class="pr-2 pl-2 box-verticalaligncenter"><img src="view/medias/icons/bell.png" class="bell"
                                                                alt="bell icon">
            </div> -->
            <?php displayManualIconIfActionIsNotManual($action, $title); ?>

            <!-- Circle for user initials and dropdown -->
            <div class="box-alignright pl-3 pr-4 nomargin">
                <div class="usericon">
                    <div class="dropdown">
                        <form action="" class="nomargin">
                            <!-- form tag ? -> thanks to https://stackoverflow.com/questions/25089297/avoid-dropdown-menu-close-on-click-inside#answer-34216265 -->
                            <!-- The circle -->
                            <div class="circle-usericon cursorpointer <?= (checkAdmin()) ? "innerbordercircle" : "" ?>"
                                 data-toggle="dropdown" aria-expanded="false">
                                <p class="marginauto"><?= $_SESSION['user']['initials'] ?></p>
                            </div>
                            <!-- The dropdown -->
                            <div class="divDropDown dropdown-menu yellowheader" style="">
                                <div>
                                    <p><strong>Statut <br></strong><em
                                                id="pStatus" class="breakword"><?= $_SESSION['user']['status'] ?></em>
                                        <span id="spChangeStatusIcon">
                                            <?= printAnIcon("modify.png", "Modifier le statut", "modify icon", "yellowdarkonhover p-1 icon-small justify-content-end icnChangeStatus modify", false) ?>
                                            <?= printAnIcon("checkmark.png", "Enregistrer le statut", "check mark icon", "yellowdarkonhover p-1 icon-small justify-content-end icnChangeStatus checkmark", false, "", true) ?>
                                        </span>
                                    </p>
                                    <?= ($_SESSION['user']['on_break'] == 1) ? "<p class='lightbluelogo p-2'><strong>En pause</strong></p>" : "" ?>
                                    <!-- The 2 buttons for "my account" and "logout" -->
                                    <div class="clickable cursorpointer yellowdarkonhover"
                                         data-href="?action=editAccount">
                                        <img src="view/medias/icons/settings.png" alt="settings icon"
                                             class="icon-small">
                                        <strong>Mon compte</strong></div>
                                    <div class="clickable cursorpointer yellowdarkonhover fullwidth"
                                         data-href="?action=logout">
                                        <img src="view/medias/icons/logout.png" alt="settings icon" class="icon-small">
                                        <strong>Déconnexion</strong>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { //if user is not logged display only a login button?>
        <div class="user row col-2 borderleftorange txtblack nomargin nopadding">
            <?php
            displayManualIconIfActionIsNotManual($action, $title); ?>
            <div class="pr-3 pl-3 box-verticalaligncenter header-height">
                <a href="?action=login"><span class="btn btn-info">Connexion</span></a>
            </div>
        </div>
    <?php } ?>

    <!-- Zone Menu -->
    <div class="menu">
        <ul>
            <?php
            if (isset($_SESSION['user']['id']) && checkLimitedAccess() == false){  //display the buttons only if the user is logged
            ?>
            <li><a class="<?= ($action == null) ? 'active' : '' ?>" href="?">Dashboard</a></li>
            <!--<li><a class="<?= ($action == "tasks") ? 'active' : '' ?>" href="?action=tasks">Tâches</a></li>
            -->
            <li><a class="<?= ($action == "projects") ? 'active' : '' ?>" href="?action=projects">Projets</a></li>
            <li><a class="<?= ($action == "groups") ? 'active' : '' ?>" href="?action=groups">Groupes</a></li>
            <li><a class="<?= ($action == "members") ? 'active' : '' ?>" href="?action=members">Membres</a></li>
            <!--<li><a class="<?= ($action == "calendar") ? 'active' : '' ?>" href="?action=calendar">Calendrier</a>
            --></li>
        </ul>
        <?php
        }
        ?>
    </div>
</header>

<!-- Flashmessage div if the flashmessage is set-->
<div class="margintopforheader"><?php
    $msg = flashMessage(true); //get flashmessage with Html included
    echo $msg;  //$msg that store the message can now be displayed. the value of $msg isn't lost (useful for appbody).
    ?></div>
<!-- Zone appbody with the content of the view generated -->
<?php
//Depending on the content type choosed in the view, the appbody will change. 3 types are available: full, large, restrict.
switch ($contenttype) {
    case "full":
        ?>
        <div class="appbody <?= ($msg != "") ? "" : "margintopforheader" ?> p-1"><?= $content; ?></div><?php
        break;
    case "large":
        ?>
        <div class="appbody <?= ($msg != "") ? "" : "margintopforheader" ?> p-3"><?= $content; ?></div><?php
        break;
    case "restricted":
        ?>
        <div class="flexdiv <?= ($msg != "") ? "" : "margintopforheader" ?> justify-content-center">
            <div class="appbody appbodyrestrict marginauto p-3"><?= $content; ?></div>
        </div>
        <?php
        break;
    default:
        ?>
        <div class="appbody p-1">$contenttype must be correctly defined...</div>
        <?php
        break;
}
?>

<?php
if ($feedbackForm == true && isEmailFormat($emailSourceForFeedback) && isEmailFormat($emailForFeedback)) { ?>
    <!-- feedback form -->
    <div class="dropdown position-fixed">
        <form>
            <!-- form tag ? -> thanks to https://stackoverflow.com/questions/25089297/avoid-dropdown-menu-close-on-click-inside#answer-34216265 -->
            <!-- The circle -->
            <div class="divFeedback cursorpointer" data-toggle="dropdown" aria-expanded="false">
                <?php
                printAnIcon("feedback.svg", "Envoyer un feedback sur la page", "feedback icon", "icon-small iconFeedback");
                ?>
            </div>

            <!-- The dropdown -->
            <div id="frmFeedback" class="divDropUpFeedback dropdown-menu" style="">
                <div>
                    <div class="box-verticalaligncenter height-min-content">
                        <div class="flex-1"><strong>Formulaire de feedback</strong></div>
                        <div>
                            <?php
                            echo createToolTipWithPoint("Ce formulaire vous permet d'envoyer un feedback à propos de la page actuelle. \nIl s'affiche uniquement sur les instances de tests.", "icon-xsmall m-1", false, "right");
                            ?>
                        </div>
                    </div>

                    <span class="small cursorpointer" id="txtFeedbackInfos">Informations automatiques
                    <?php printAnIcon("trianglebottom.png", "Afficher", "triangle bottom icon", "icon-task-triangle"); ?>
                    </span>
                    <div id="divFeedbackInfos" hidden>
                        <span class="small">URL complet: <span class="littleinfotext">Inclus</span></span>
                        <br><span class="small">Cookies d'interface: <span class="littleinfotext">Inclus</span></span>
                        <br><span class="small">Version: <span class="littleinfotext">
                            <?= $versions[count($versions) - 1]['version'] ?>
                        </span></span>
                        <br><span class="small">Informations sur le navigateur: <span
                                    class="littleinfotext">Inclus</span></span>
                    </div>
                    <hr class="hrlight nomargin">
                    <div class="flexdiv box-verticalaligncenter">
                        <div class="flex-1">
                            <span id="spanFeedbackEmail" class="cursorpointer">
                            <input type="checkbox"
                                   id="chkFeedbackEmail"
                                   class="cursorpointer" <?= ((isset($_SESSION['feedback']['email']) == true) ? "checked" : "") ?>>
                                <label for="chkFeedbackEmail"
                                       class="nomargin small cursorpointer">Réponse souhaitée</label>
                                <?php //printAnIcon("trianglebottom.png", "Afficher", "triangle bottom icon", "icon-task-triangle"); ?>
                            </span>
                        </div>
                        <?php
                        echo createToolTipWithPoint("Si vous souhaitez recevoir une réponse à votre retour, vous pouvez noter votre adresse email et cocher la case. L'email reste en mémoire si vous restez connecté·e avec le même compte.", "icon-xsmall m-1", false, "right");
                        ?>
                    </div>
                    <div id="divFeedbackEmail" <?= ((isset($_SESSION['feedback']['email']) == true) ? "" : "hidden") ?>>
                        <input id="txtFeedbackEmail" type="email" maxlength="254" name="email"
                               placeholder="email@example.com"
                               class="thinblackborder mb-1 mt-1 fullwidth small"
                               value="<?= ((isset($_SESSION['feedback']['email']) == true) ? $_SESSION['feedback']['email'] : "") ?>">
                    </div>

                    <hr class="hrlight nomargin">
                    <div class="mt-2 box-verticalaligncenter">
                        <strong class="flex-1">Votre retour:</strong>
                        <div>
                            <?php
                            echo createToolTipWithPoint("Ne rentrez aucune information personnelle sensibles (mot de passe, secrets, ...). Vous pouvez faire votre retour en plusieurs fois si besoin.", "icon-xsmall m-1", false, "right");
                            ?>
                        </div>
                    </div>
                    <div id="frmFeedback">
                        <input id="txtFeedbackSubject" type="text" maxlength="100" name="subject"
                               placeholder="Sujet du retour" class="thinblackborder mb-1 mt-1 fullwidth">
                        <textarea name="content" id="txtFeedback" rows="10" class="thinblackborder"
                                  placeholder="Concernant les fonctionnalités présentes sur cette page, bogues trouvés, le design, la simplicité (ou non) d'utilisation, suggestions, la cohérence, la clarté des informations, ... tout commentaire constructif à propos de cette page est le bienvenu!"
                                  maxlength="6000"></textarea>
                    </div>
                    <div class="box-alignright">
                        <div id="btnCancelFeedback" class="btn btn-light littleinfotext mr-2">Annuler</div>
                        <div id="btnSendFeedback" class="btn btn-light thinBorder">Envoyer</div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php } ?>
<!-- JS messages at the top right. Invisible if empty. -->
<div id="divTempMessages"></div>

<div hidden id="userloggedid"><?= $_SESSION['user']['id']; ?></div>

<!-- templates -->
<div id="templates">
    <template id="templateMsg">
        <div class="jsTempMsg flexdiv">
            <div class="box-verticalaligncenter checkmark"><?= printAnIcon("checkmark.png", "", "check mark icon", "icon-task m-1", false) ?></div>
            <div class="box-verticalaligncenter redcross"
                 hidden><?= printAnIcon("redcross.png", "", "redcross icon", "icon-task m-1", false) ?></div>
            <div class="jsTempMsgText flex-1 ml-1 mr-1 box-verticalaligncenter"><?php echo createElementWithFixedLines("", 3, "msgText", true); ?></div>
            <?= printAnIcon("blackcross.png", "", "question mark icon", "icon-tempmsg m-1", false) ?>
        </div>
    </template>
    <?php require_once "view/task.php";  //to have declare printATask (require once because is already declared if page is kanban ?>
    <template id="templateTask"><?php printATask([], true); ?></template>
</div>


</body>
</html>
