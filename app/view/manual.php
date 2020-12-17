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
$title = "Mode d'emploi";
?>
    <div id="top"></div>
    <div class="mdstyle">
        <div class="flexdiv thinBlackBorderForTitle">
            <h1 class="flex-1" id="mode-d-emploi"><?= $title ?></h1>
            <span class="flexdiv align-items-end versiontextformanual font-size-1"><?php echo createToolTip("v" . $docVersion . ", <em>le " . $docVersionDate . "</em>", "Ce mode d'emploi est mis à jour plus fréquemment que l'application (selon les retours). Actuellement en version " . $docVersion . " sortie le " . $docVersionDate . ".", false, "bottom"); ?></span>
        </div>
        <h2 id="table-des-matieres">Table des matières</h2>
        <?php
        echo $doc;
        echo $msg;
        ?></div>
<?php if ($doc != "") { ?>
    <div class="clickablebanner box-aligncenter box-verticalaligncenter clickable" data-href="#top">
        <h4 class="nomargin">Retour en haut ^</h4>
    </div>
    <?php
}
$contenttype = "restricted";
$content = ob_get_clean();
require "gabarit.php";
?>