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
        <div class="flexdiv thinBlackBorderForTitle flexwrap">
            <h1 class="flex-1 keepentire" id="mode-d-emploi"><?= $title ?></h1>
            <span class="flexdiv keepentire  align-items-end justify-content-end versiontextformanual font-size-1"><?php echo createToolTip("v" . $docVersion . ", <em>le " . ((compare2DatesWithDayPrecision(substr($docVersionDate, 0, strpos($docVersionDate, " ")), timeToDT(time())) == 0) ? "<strong>$docVersionDate</strong>" : $docVersionDate) . "</em>", "Ce mode d'emploi est mis à jour plus fréquemment que l'application (selon les retours). Actuellement en version " . $docVersion . " sortie le " . $docVersionDate . ".", false, "bottom"); ?></span>
        </div>
        <h2 id="table-des-matieres" class="width-max-content">Table des matières</h2>
        <?php
        echo $doc;
        echo $msg;
        ?></div>
<?php if ($doc != "") { ?>
    <div class="clickablebanner linkOfTOC box-aligncenter box-verticalaligncenter clickable" data-href="#top">
        <h4 class="nomargin linkOfTOC">Retour en haut ^</h4>
    </div>
    <?php
}
$contenttype = "restricted";
$content = ob_get_clean();
require "gabarit.php";
?>