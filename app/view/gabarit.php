<?php
$versions = getVersionsApp();
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
<header></header>
<div class="left"><img src="view/medias/logos/temp-logo.jpg" alt="logo" class="logo"> <br><span class="versiontext">v<?= $versions[count($versions)-1]['version'] ?></span>
    <span class="versiontext"><em> le <?= date("d.m.Y", strtotime($versions[count($versions)-1]['date'])) ?></em></span></div>
<div class="center"></div>
<div class="right"></div>

<div class="appbody">

    <?= $content; ?>
</div>
</body>
</html>
