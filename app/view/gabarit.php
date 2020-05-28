<?php
$versions = getVersionsApp();

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
    <!-- Js files  -->
    <script src="js/global.js"></script>

</head>

<body>
<header>
    <div class="logodiv">
        <a href="/"><img src="view/medias/logos/temp-logo.png" alt="logo" class="logo"></a>
        <span class="versiontext">v<?= $versions[count($versions) - 1]['version'] ?></span>
        <span class="versiontext"><em> le <?= date("d.m.Y", strtotime($versions[count($versions) - 1]['date'])) ?></em></span>
    </div>
    <div class="user row">
        <?php if (isset($_SESSION['user'])) { ?>
            <div class="col-2 usericon">
                <a href="?action=editAccount">
                    <img src="view/medias/logos/User_JRD_Temp.png" alt="logo user" class="usericon">
                </a>
            </div>
            <div class="col-10 logout">
                <?= $_SESSION['user']['firstname'] ?> <?= $_SESSION['user']['lastname'] ?><br><a href="/?action=logout"><span
                            class="small">Déconnexion</span></a>
            </div>
        <?php } else { ?>
            <div class="col-2 usericon">
                <a href="?action=login">
                    <img src="view/medias/logos/User_Unknown_Temp.png" alt="logo user" class="usericon">
                </a>
            </div>
            <div class="col-10 logout">
                <span class="small">Non connecté</span>
                <br><a href="/?action=logout"><span class="small">Connexion</span></a>
            </div>
            <?php
        } ?>
    </div>
    <div class="menu">
        <ul>
            <li><a class="active" href="/">Dashboard</a></li>
            <li><a href="/?action=groups">Groupes</a></li>
            <li><a href="/?action=projects">Projets</a></li>
            <li><a href="/?action=works">Travaux</a></li>
            <li><a href="/?action=...">...</a></li>
        </ul>

    </div>
</header>
<div class="appbody">
    <?= $content; ?>
</div>
</body>
</html>
