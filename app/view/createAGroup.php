<?php
ob_start();
$title = "Créer un groupe"
?>
<h1>Créer un groupe</h1>
<?php
$content = ob_get_clean();
require "gabarit.php";
?>