<?php
ob_start();
$title = "Groupes"
?>
    <h1><?= $title ?></h1>
    <a href="?action=createAGroup">
        <button class="justify-content-end">Créer un nouveau groupe</button>
    </a>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>