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
<?php if($debug){ ?>


    <h2>Résultat de la requète:</h2><br>
    <h3>
        <?php
        displaydebug(getUsersFromAGroup(1));
        ?>
    </h3>
<?php }?>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>