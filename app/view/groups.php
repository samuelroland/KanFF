<?php
ob_start();
$title = "Groupes"
?>
    <h1>Groupes</h1>
    <a href="?action=createAGroup">
        <button class="justify-content-end justify">Créer un nouveau groupe</button>
    </a>
<?php
$content = ob_get_clean();
require "gabarit.php";
?>