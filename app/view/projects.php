<?php
function printAProject($project)
{
    ob_start();
    ?>
    <div class="divProject breakword thinBorder <?= (($project['visible'] == 0) ? "notVisibleToAll" : "") ?>">
        <div class="divProjectFirstLine">
            <h3 title="<?= $project['name'] ?>"><?php
                if (strlen($project['name']) > 26) {
                    echo createToolTip(createElementWithFixedLines($project['name'], 1), $project['name']);
                } else {
                    echo(createElementWithFixedLines($project['name'], 1));
                }
                ?></h3>
            <div class="flexdiv">
                <div class="flex-2 divParticipate mb-4">
                    <?php
                    $listOfGroups = "";
                    $nbGroups = 0;
                    $notAllDisplayed = false;
                    foreach ($project['participate'] as $participate) {
                        if ($nbGroups < 4) {
                            $listOfGroups .= "· <span class='clickable linkInternal cursorpointer ' data-href='?action=group&id={$participate['group']['id']}' title='{$participate['group']['name']}'>" . $participate['group']['name'] . "</span><br>";
                        } else {
                            $notAllDisplayed = true;
                        }
                        $listOfGroupsRawText .= " - " . $participate['group']['name'];
                        $nbGroups++;
                    }
                    echo "<span title='" . htmlentities($listOfGroupsRawText) . "'><strong>Réalisé par:</strong></span>";
                    echo createElementWithFixedLines($listOfGroups, 4);
                    if ($notAllDisplayed) {
                        echo "...";
                    }
                    ?>
                </div>
                <div class="flex-4 pl-2">
                    <p title="<?= $project['description'] ?>"><?= createElementWithFixedLines($project['description'], 5) ?></p>
                </div>
            </div>
        </div>
        <div class="flexdiv fullwidth divProjectLastLine">
            <div class="box-verticalaligncenter flex-2">
                <div class="box-verticalaligncenter" title="Importance du projet (1 à 5)">
                    <img src="view/medias/icons/exclamationmark.png" alt="email logo" class="icon-small nomargin">
                    <span class="pr-2 bigvalue"><?= $project['importance'] ?></span>
                </div>
                <div class="box-verticalaligncenter" title="Urgence du projet (1 à 5)">
                    <img src="view/medias/icons/clock.png" alt="email logo" class="icon-small nomargin">
                    <span class="pl-2 pr-1 bigvalue"><?= $project['urgency'] ?></span>
                </div>
                <?php if ($project['visible'] == 0) { ?>
                    <div class="box-verticalaligncenter">
                        <img title="Ce projet est invisible pour les personnes extérieures au projet"
                             src="view/medias/icons/hiddeneye.png" alt="email logo" class="icon-simple">
                    </div>
                <?php } ?>

            </div>
            <div class="flex-4 box-verticalaligncenter">
                <span>État: <strong><?= convertProjectState($project['state']) ?></strong></span>
            </div>

        </div>
        <div class="position-bottom-right">
            <button class="btn btn-info clickable" data-href="?action=project&id=<?= $project['id'] ?>">
                Détails
            </button>
        </div>
    </div>
    <?php
    echo ob_get_clean();
}

//Start of the view:
ob_start();
$title = "Projets";

?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-1">
            <button data-href="?action=projects&option=1"
                    class="clickable btn <?= ($option == 1) ? 'active' : 'btn-info' ?>">Tous
            </button>
            <button data-href="?action=projects&option=2"
                    class="clickable btn <?= ($option == 2) ? 'active' : 'btn-info' ?>">Contribués
            </button>
        </div>
        <div class="box-alignright flex-1">
            <a href="?action=createAProject">
                <button class="btn btn-primary newproject">Nouveau projet</button>
            </a>
        </div>
    </div>
    <div class="">
        <?php
        $noProjectDisplayed = true;
        echo '<h2 class="mt-3">En cours</h2>
        <div class="divGroups margin-5px">';
        foreach ($projects as $project) {
            if (isAtLeastEqual($project['state'], [PROJECT_STATE_SEMIACTIVEWORK, PROJECT_STATE_ACTIVEWORK, PROJECT_STATE_UNDERREFLECTION, PROJECT_STATE_UNDERPLANNING])) {
                printAProject($project);
                $noProjectDisplayed = false;
            }
        }
        if ($noProjectDisplayed) {
            echo "<p class='marginplus5px'>Aucun projet de cette catégorie...</p>";
        }
        echo "</div>";

        $noProjectDisplayed = true;
        echo "<hr class='hryellowproject'>";
        echo '<h2 class="mt-3">En pause</h2>
        <div class="divGroups margin-5px">';
        foreach ($projects as $project) {
            if (isAtLeastEqual($project['state'], [PROJECT_STATE_ONBREAK, PROJECT_STATE_REPORTED])) {
                printAProject($project);
                $noProjectDisplayed = false;
            }
        }
        if ($noProjectDisplayed) {
            echo "<p class='marginplus5px'>Aucun projet de cette catégorie...</p>";
        }
        echo "</div>";

        $noProjectDisplayed = true;
        echo "<hr class='hryellowproject'>";
        echo '<h2 class="mt-3">Terminés</h2>
        <div class="divGroups margin-5px">';
        foreach ($projects as $project) {
            if (isAtLeastEqual($project['state'], [PROJECT_STATE_DONE])) {
                printAProject($project);
                $noProjectDisplayed = false;
            }
        }
        if ($noProjectDisplayed) {
            echo "<p class='marginplus5px'>Aucun projet de cette catégorie...</p>";
        }
        echo "</div>";

        $noProjectDisplayed = true;
        echo "<hr class='hryellowproject'>";
        echo '<h2 class="mt-3">Autres</h2>
        <div class="divGroups margin-5px">';
        foreach ($projects as $project) {
            if (isAtLeastEqual($project['state'], [PROJECT_STATE_ABANDONNED, PROJECT_STATE_CANCELLED])) {
                printAProject($project);
                $noProjectDisplayed = false;
            }
        }
        if ($noProjectDisplayed) {
            echo "<p class='marginplus5px'>Aucun projet de cette catégorie...</p>";
        }
        echo "</div>";
        ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>