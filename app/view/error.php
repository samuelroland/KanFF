<?php
/**
 *  Project: KanFF
 *  File: error.php view for error message
 *  Author: Benoît Pierrehumbert
 *  Creation date: 21.01.2021
 */
$title = "Erreur dans l'URL";
ob_start();
?>
    <h1><?= $title ?></h1>
    <h4><?= $subject ?></h4>
    <p class="">
        <?= $message ?>
    </p>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>