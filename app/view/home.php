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
//INFO dev zone: to force displaydebug without debug mode, write displaydebug($var, true, true);
if ($dev == true) { //dev zone

    //Benoit en haut
    echo "<h4>=============Séparation des zones===============</h4>";
    //Samuel en bas

    //Tests for updateTask()
    $data = [
        "id" => 288,
        "state" => 3
    ];
    var_dump($data);

    ob_start();
    updateATask($data);
    $result = ob_get_clean();
    var_dump(json_decode($result, true));
    //---
    $data = [
        "id" => 153,
        "responsible_id" => 1
    ];
    var_dump($data);
    ob_start();
    updateATask($data);
    $result = ob_get_clean();
    var_dump(json_decode($result, true));
    //---
    $data = [
        "id" => 1,
        "name" => "super nom!    d   ",
        "description" => "description vide asdf asf    \t    \n",
        "type" => TASK_TYPE_IDEA,
        "urgency" => 5,
        "deadline" => "2020-05-01 05:09:02",
        "link" => "mon lien.com   "
    ];
    var_dump($data);
    ob_start();
    updateATask($data);
    $result = ob_get_clean();
    var_dump(json_decode($result, true));
}
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>
