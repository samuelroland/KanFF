<?php
/**
 *  Project: KanFF
 *  File: home.php firstpage of the website
 *  Author: Samuel Roland
 *  Creation date: 25.05.2020
 */
$title = "KanFF - Dashboard";
ob_start();
?>
<h1>Dashboard... (en construction)</h1>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>