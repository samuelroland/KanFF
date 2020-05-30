<?php
ob_start();
$title = "Créer un groupe"
?>

<?php
$content = ob_get_clean();
require "gabarit.php";
?>