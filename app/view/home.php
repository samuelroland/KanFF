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
<?php printPageWIPTextInfo(); ?>

<?php
require ".const.php";
if ($dev == true) { //dev zone
    ?>
    <h2>
        <p>Résultat de la requète:</p><br>
        <?php
        displaydebug(getContributionsByUsers(20,true));
        ?>
    </h2>
    <?php
}
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
