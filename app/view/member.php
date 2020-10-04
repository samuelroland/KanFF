<?php
/**
 *  Project: KanFF
 *  File: home.php firstpage of the website
 *  Author: Samuel Roland
 *  Creation date: 25.05.2020
 */
$title = "Détails de " . $user['firstname'] . " " . $user['lastname'];
ob_start();
?>
    <h1><?= $title ?></h1>
Page en construction.

<?php
displaydebug($user);
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>