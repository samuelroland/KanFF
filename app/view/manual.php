<?php
/**
 *  Project: KanFF
 *  File: manual.php view of the page user manual
 *  Author: Samuel Roland
 *  Creation date: 09.12.2020
 */
$instanceinfos = getInstanceInfos();
$collective = $instanceinfos['collective'];
$instance = $instanceinfos['instance'];
$versions = getVersionsApp();
$lastVersion = $versions[count($versions) - 1];
ob_start();
$title = "Manuel";
?>
    <!--<h1 class="aligncenter"><?= $title ?></h1>-->
    <div id="top"></div>
    <div class="mdstyle"><?= $doc ?></div>
    <div class="clickablebanner box-aligncenter box-verticalaligncenter clickable" data-href="#top">
        <h4 class="nomargin">Retour en haut ^</h4>
    </div>
<?php
$contenttype = "restricted";
$content = ob_get_clean();
require "gabarit.php";
?>