<?php
$versions = getVersionsApp();
$action = $_GET['action'];
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

<body>
<header class="bg-grey-header">
    <div class="logodiv row lineheigthsmall">
        <div class="col-5">
            <a href="/"><img src="view/medias/logos/KanFF_Logo.svg" alt="logo KanFF" class="logo"></a>
            <br><span class="versiontext">v<?= $versions[count($versions) - 1]['version'] ?></span>
            <span class="versiontext"><em> le <?= date("d.m.Y", strtotime($versions[count($versions) - 1]['date'])) ?></em></span>
        </div>
        <div class="col-7 collectivename flexdiv">
            <div class="align-items-center flexdiv">Grève du Climat Vaud</div>
        </div>
    </div>


    <?php if (isset($_SESSION['user'])) { ?>
    <div class="user row justify-content-end flexdiv">
        <div class="pr-3 box-verticalaligncenter"><img src="view/medias/icons/bell.png" class="bell" alt="bell icon"></div>
        <div class="fullname pr-2 justify-content-end box-verticalaligncenter">
            <?= $_SESSION['user']['firstname'] ?> <?= $_SESSION['user']['lastname'] ?>
        </div>
        <div class="box-alignright pr-4 nomargin">
            <div class="usericon ">
                <div class="circle-usericon"><p class="marginauto"><?= $_SESSION['user']['initials']?></p></div>
            </div>
        </div>
        <?php } else { ?>
        <div class="user row col-2">
            <div class="col-10 box-verticalaligncenter header-height">
                <a href="/?action=logout"><span class="">Connexion</span></a>
            </div>
            <?php
            } ?>
        </div>
        <div class="menu">
            <ul>
                <li><a class="<?= ($action == null) ? 'active' : '' ?>" href="/">Dashboard</a></li>
                <li><a class="<?= ($action == "tasks") ? 'active' : '' ?>" href="/?action=tasks">Tâches</a></li>
                <li><a class="<?= ($action == "projects") ? 'active' : '' ?>" href="/?action=projects">Projets</a></li>
                <li><a class="<?= ($action == "groups") ? 'active' : '' ?>" href="/?action=groups">Groupes</a></li>
                <li><a class="<?= ($action == "members") ? 'active' : '' ?>" href="/?action=members">Membres</a></li>
                <li><a class="<?= ($action == "calendar") ? 'active' : '' ?>" href="/?action=calendar">Calendrier</a>
                </li>
            </ul>

        </div>
</header>

<?php

//Depending on the content type choosed in the view, the appbody will change. 3 types are available: full, large, restrict.
switch ($contenttype){
case "full":
?>
<div class="appbody p-1"><?php
    break;
    case "large":
    ?>
    <div class="appbody p-3"><?php
        break;
        case "restricted":
        ?>
        <div class="appbody appbodyrestrict col-lg-7 col-md-8 col-sm-11 marginauto p-3"><?php
            break;
            default:
            ?>
            <div class="appbody p-1"><?php
                }

                ?>

                <?= $content; ?>
            </div>
</body>
</html>
