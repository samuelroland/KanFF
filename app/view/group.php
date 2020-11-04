<?php
/**
 *  Project: KanFF
 *  File: group.php details about a group
 *  Author: Samuel Roland
 *  Creation date: 31.10.2020
 */
$title = "Détails " . $group['name'];
ob_start();
?>
    <h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>

<?php
displaydebug($user);
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>