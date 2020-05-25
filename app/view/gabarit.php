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
<header>
    <div class="logodiv">
        <a href="/"><img src="view/medias/logos/temp-logo.png" alt="logo" class="logo"></a>
        <span class="versiontext">v<?= $versions[count($versions) - 1]['version'] ?></span>
        <span class="versiontext"><em> le <?= date("d.m.Y", strtotime($versions[count($versions) - 1]['date'])) ?></em></span>
    </div>
    <div class="user">

        <a href="?action=editAccount">
            <img src="view/medias/logos/User_JRD_Temp.png" alt="logo user" class="usericon"></a>
        <?= $_SESSION['user']['firstname'] ?> <?= $_SESSION['user']['lastname'] ?>
    </div>
    <div class="menu">
        <ul>
            <li><a class="active" href="#home">Home</a></li>
            <li><a href="#news">News</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#about">About</a></li>
        </ul>

    </div>
</header>
<body>
<div class="appbody">
    <?= $content; ?>
</div>
</body>
</html>
