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

    //Benoit en haut
    echo "<h1>=============Séparation des zones===============</h1>";
    //Samuel en bas

    echo createManualLink("membres");
var_dump(checkStringLengthNotEmpty("", 5));
echo convertProjectState(10);
}
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
