<?php
/**
 *  Project: KanFF
 *  File: limitedAccess.php view of the page access limited to show informations to users that have a limited access
 *  Author: Samuel Roland
 *  Creation date: 06.10.2020
 */
$title = "Accès limité";
ob_start();
?>
    <h1><?= $title ?></h1>
    <h4>Etat du compte: <?= convertUserState($user['state']) ?></h4>
<span><em><strong>Pourquoi ai-je un accès limité aux données internes ?</strong></em></span><br>
<p class="">
    <?= $message ?>
</p>
<?php

if ($user['state_modification_date'] != null || $user['state_modifier_id'] != null) {
    echo "État du compte défini comme <em>" . convertUserState($user['state'])."</em>";
    if ($user['state_modification_date'] != null) {
        echo " le <strong>" . DTToHumanDate($user['state_modification_date'], "simpletime")."</strong>";
    }
    if ($user['state_modifier_id'] != null) {
        echo " par " . mentionUser($user['state_modifier']);
    }
    echo ".";
}
?>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>