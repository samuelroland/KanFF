<?php
$versions = getVersionsApp();
$action = $_GET['action'];
$instanceinfos = getInstanceInfos();
require ".const.php";
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>


    <!-- Bootstrap files -->

    <link href="node_modules/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="node_modules/bootstrap/dist/css/bootstrap-grid.css" rel="stylesheet">
    <link href="node_modules/bootstrap/dist/css/bootstrap-reboot.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Jquery files -->
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>

    <!-- CSS files -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/groups.css" rel="stylesheet">
    <!-- Js files  -->
    <script src="js/global.js"></script>
    <script src="js/groups.js"></script>

</head>


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
<body>
<header class="bg-header <?php if ($debug==false){echo "header-fixed";} ?>">
    <div class="logodiv row lineheigthsmall">
        <div class="col-5">
            <a href="/"><img src="view/medias/logos/KanFF_Logo.svg" alt="logo KanFF" class="logo"></a>
            <br><span class="versiontext">v<?= $versions[count($versions) - 1]['version'] ?></span>
            <span class="versiontext"><em> le <?= date("d.m.Y", strtotime($versions[count($versions) - 1]['date'])) ?></em></span>
        </div>
        <div data-href="?action=about"
             class="col-7 collectivename flexdiv clickable <?= ($action == "about") ? 'active' : '' ?>">
            <div class="align-items-center flexdiv"><?= $instanceinfos['collective']['name'] ?></div>
        </div>
    </div>

    <!-- login form -->
    <?php if (isset($_SESSION['user'])) { ?>
    <div class="user row justify-content-end flexdiv">
        <div class="pr-3 box-verticalaligncenter"><img src="view/medias/icons/bell.png" class="bell" alt="bell icon">
        </div>
        <div class="fullname pr-2 justify-content-end box-verticalaligncenter">
            <?= $_SESSION['user']['firstname'] ?> <?= $_SESSION['user']['lastname'] ?>
        </div>
        <!-- logo user https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_js_dropdown for the dropdown -->
        <div class="box-alignright pr-4 nomargin">
            <div class="usericon ">
                <div class="circle-usericon"><p class="marginauto"><?= $_SESSION['user']['initials'] ?></p></div>
            </div>
        </div>
        <?php } else { ?>
        <div class="user row col-2">
            <div class="col-10 box-verticalaligncenter header-height">
                <a href="/?action=login"><span class="">Connexion</span></a>
            </div>
            <?php
            } ?>
        </div>

        <!-- Menu of navigation-->
        <div class="menu">
            <ul>
                <?php
                if (isset($_SESSION['user'])){  //display the buttons only if the user is logged
                ?>
                <li><a class="<?= ($action == null) ? 'active' : '' ?>" href="/">Dashboard</a></li>
                <li><a class="<?= ($action == "tasks") ? 'active' : '' ?>" href="/?action=tasks">Tâches</a></li>
                <li><a class="<?= ($action == "projects") ? 'active' : '' ?>" href="/?action=projects">Projets</a></li>
                <li><a class="<?= ($action == "groups") ? 'active' : '' ?>" href="/?action=groups">Groupes</a></li>
                <li><a class="<?= ($action == "members") ? 'active' : '' ?>" href="/?action=members">Membres</a></li>
                <li><a class="<?= ($action == "calendar") ? 'active' : '' ?>" href="/?action=calendar">Calendrier</a>
                </li>
            </ul>
            <?php
            }
            ?>
        </div>

</header>
<div class="bg-danger margintopforheader flashmessage"><?php
    $msg = flashMessage(true);
    echo $msg;
    ?></div>
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
            <div class="appbody appbodyrestrict col-lg-7 col-md-8 col-sm-11 marginauto p-3"><?= $content; ?></div>
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

</div>
</body>
</html>
