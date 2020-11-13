<?php
/**
 *  Project: KanFF
 *  File: tasks.php list of all personnal tasks that are urgent
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */
$title = "Tâches";
ob_start();
?>
    <h1><?= $title ?></h1>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>