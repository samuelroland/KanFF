<?php
/**
 *  Project: KanFF
 *  File: calendar.php calendar with all visible events
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */
$title = "Calendrier";
ob_start();
?>
    <h1><?= $title ?></h1>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>