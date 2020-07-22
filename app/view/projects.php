<?php
/**
 *  Project: KanFF
 *  File: projects.php list of all visible projects
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */
$title = "Projets";
ob_start();
?>
<h1><?= $title ?></h1>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>