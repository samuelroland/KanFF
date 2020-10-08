<?php
/**
 *  Project: KanFF
 *  File: home.php firstpage of the website
 *  Author: Samuel Roland
 *  Creation date: 25.05.2020
 */
$title = "Dashboard";
ob_start();
?>
<h1><?= $title ?></h1>
<h1>Test</h1>
<h3><?php displaydebug(getAllProjectsContributed(2)); ?></h3>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>