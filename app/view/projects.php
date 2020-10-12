<?php
//Print a project with all its informations
function printAProject($project)
{
    ob_start();
    ?>
    <div class="divProject breakword thinBorder <?= (($project['visible'] == 0) ? "notVisibleToAll" : "") ?>">
        <div class="divProjectFirstLine">
            <div class="divProjectTitleLine flexdiv">
                <h3 title="<?= $project['name'] ?>" class="flex-1"><?php
                    if (strlen($project['name']) > 26) {
                        echo createToolTip(createElementWithFixedLines($project['name'], 1), $project['name']);
                    } else {
                        echo(createElementWithFixedLines($project['name'], 1));
                    }
                    ?>
                </h3>

                <?php
                //divIcons management (display or not, and the content):
                $divIconsIsDisplayed = false;
                if (isAtLeastEqual(1, [$project['archived'], $project['visible'] + 1])) {   //if at least one icon will be displayed
                    echo "<div class='ml-3 divIcons box-alignright'>";  //create the div
                    $divIconsIsDisplayed = true;
                }
                //Display the archive icon if the project is archived
                if ($project['archived'] == 1) { ?>
                    <img title="Projet archivé" class="icon-small" src="view/medias/icons/archive.png"
                         alt="archive icon">
                <?php }
                //Display the invisible icon if the project is invisible
                if ($project['visible'] == 0) { ?>
                    <img title="Ce projet est invisible pour les personnes extérieures au projet"
                         src="view/medias/icons/hiddeneye.png" alt="email logo" class="icon-simple">
                <?php }
                if ($divIconsIsDisplayed) echo "</div>";    //close divIcons if previously created
                ?>
            </div>
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
            </div>
            <div class="flex-4 box-verticalaligncenter">
                <div>
                    <span>État: <strong><?= convertProjectState($project['state'], true) ?></strong></span><br>
                    <?php if ($project['state'] == PROJECT_STATE_DONE) { ?>
                        <span>Date fin: <strong><?= DTToHumanDate($project['end']) ?></strong></span>
                    <?php } else if (compare2DatesWithDayPrecision($project['start'], timeToDT(time())) == 1) { ?>
                        <span>Date début: <strong><?= DTToHumanDate($project['start']) ?></strong></span>
                    <?php } ?>
                </div>
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

//Print the category HTML and filter projects depeding on the category (states and archived or not)
function printACategoryOfProjects($name, $projects, $authorizedStates, $archivedProjectsAuthorized = false)
{
    $noProjectDisplayed = true; //default value
    echo '<h2 class="mt-4">' . $name . '</h2>
        <div class="divGroups margin-5px">';    //name of category and start of div
    foreach ($projects as $project) {
        if (isAtLeastEqual($project['state'], $authorizedStates)) { //accept only project with states authorized by the category
            if ($project['archived'] == 1) {    //if project is archived
                if ($archivedProjectsAuthorized) {  //display only if authorized
                    printAProject($project);
                }
            } else {
                printAProject($project);
            }
            $noProjectDisplayed = false;    //at least one project has been display (so no msg to say "no project in this category")
        }
    }
    //If no project has been displayed, display a information message
    if ($noProjectDisplayed) {
        echo "<p class='marginplus5px'>Aucun projet de cette catégorie...</p>";
    }

    echo "</div>";
    echo "<hr class='hryellowproject'>";    //horizontal separator line
}

//Start of the view:
ob_start();
$title = "Projets";

?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-1">
            <button data-href="?action=projects&option=1"
                    class="clickable btn <?= ($option == 1) ? 'active' : 'btn-info' ?>">Actuels
            </button>
            <button data-href="?action=projects&option=2"
                    class="clickable btn <?= ($option == 2) ? 'active' : 'btn-info' ?>">Contribués
            </button>
            <button data-href="?action=projects&option=3"
                    class="clickable btn <?= ($option == 3) ? 'active' : 'btn-info' ?>">Archivés
            </button>
        </div>
        <div class="box-alignright flex-1">
            <a href="?action=createAProject">
                <button class="btn btn-primary newproject">Nouveau projet</button>
            </a>
        </div>
    </div>
    <div class="divProjectCategory">
        <?php
        if ($option != 3) { //not display in run and on break category for option 3 (archived projects)
            printACategoryOfProjects("En cours", $projects, [PROJECT_STATE_SEMIACTIVEWORK, PROJECT_STATE_ACTIVEWORK, PROJECT_STATE_UNDERREFLECTION, PROJECT_STATE_UNDERPLANNING]);
            printACategoryOfProjects("En pause", $projects, [PROJECT_STATE_ONBREAK, PROJECT_STATE_REPORTED]);
        }
        printACategoryOfProjects("Terminés", $projects, [PROJECT_STATE_DONE], (isAtLeastEqual($option, [2, 3])));   //archived projects are visible in contributed and archived projects options
        printACategoryOfProjects("Autres", $projects, [PROJECT_STATE_ABANDONNED, PROJECT_STATE_CANCELLED], (isAtLeastEqual($option, [2, 3])));  //archived projects are visible in contributed and archived projects options
        ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>