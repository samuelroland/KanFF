<?php
//Print a project with all its informations
function printAProject($project, $progressionsByProject)
{
    ob_start();
    ?>
    <div class="divProject breakword thinBorder <?= (($project['visible'] == 0) ? "notVisibleToAll" : "") ?>">
        <?php if ($project['isUserLoggedInside'] == true) { ?>
            <div class="topRightForProjectKey borderradius">
                <?= '<div class="p-1 pl-2 pr-2">' . createToolTip(printAnIcon("key.png", "", "", "icon-small", false), "Vous êtes dans ce projet.") . "</div>" ?>
            </div>
        <?php } ?>
        <div class="divProjectFirstLine">
            <div class="divProjectTitleLine flexdiv">
                <h3 class="flex-1">
                    <?php //Display the project name and add a tooltip with if the name is long (to be able to read it without changing browser size or look at details)
                    if (strlen($project['name']) >= 27) {
                        echo createToolTip(createElementWithFixedLines($project['name'], 1), htmlspecialchars($project['name']));
                    } else {
                        echo(createElementWithFixedLines($project['name'], 1));
                    }
                    ?>
                </h3>
                <?php //Hidden key icon to imitate a right padding to the first line (to avoid the overlaying of the icon above of the project name)
                if ($project['isUserLoggedInside'] == true) {
                    echo '<div class="p-1 pl-2 pr-2 m-right--10 visibilityhidden">' . printAnIcon("key.png", "", "", "icon-small", false) . "</div>";
                } ?>
            </div>
            <div class="flexdiv">
                <div class="flex-2 divParticipate mb-4">
                    <?php
                    $listOfGroups = "";
                    $nbGroups = 0;
                    $notAllDisplayed = false;
                    $listOfGroupsRawText = "";  //initialize as empty
                    foreach ($project['participate'] as $participate) {
                        //Define em markup or not, depending on the manager group (project.manager_id):
                        $emOrNotStart = (($project['manager_id'] == $participate['group']['id'] && count($project['participate']) > 1) ? "<em>" : "");
                        $emOrNotEnd = (($project['manager_id'] == $participate['group']['id'] && count($project['participate']) > 1) ? "</em>" : "");

                        $listOfGroups .= "· <span class='clickable linkInternal cursorpointer ' data-href='?action=group&id={$participate['group']['id']}' title='{$participate['group']['name']}'>$emOrNotStart" . $participate['group']['name'] . "$emOrNotEnd</span><br>";   //add a group to the list

                        $listOfGroupsRawText .= " - " . $participate['group']['name'];
                        $nbGroups++;
                    }
                    echo "<span title='" . htmlentities($listOfGroupsRawText) . "'><strong>Réalisé par:</strong></span>";
                    echo createElementWithFixedLines($listOfGroups, 4);
                    if ($notAllDisplayed) {
                        echo "...";
                    }

                    if ($project['responsible'] != null) {
                        echo "<span><strong>Responsable:</strong></span> ";
                        echo mentionUser($project['responsible']);
                    }
                    ?>
                </div>
                <div class="flex-4 pl-2">
                    <span title="<?= $project['description'] ?>"><?= createElementWithFixedLines($project['description'], 5) ?></span>
                    <div>
                        <span>État: <strong><?= convertProjectState($project['state'], true) ?></strong>.</span>
                        <?php if ($project['state'] == PROJECT_STATE_DONE) { ?>
                            <span>Fin: <strong><?= DTToHumanDate($project['end']) ?></strong>.</span>
                        <?php } else if (compare2DatesWithDayPrecision($project['start'], timeToDT(time())) == 1) { ?>
                            <span>Début: <strong><?= DTToHumanDate($project['start']) ?></strong>.</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="flexdiv fullwidth divProjectLastLine">
            <div class="box-verticalaligncenter flex-2">
                <div class="box-verticalaligncenter" title="Importance du projet (1 à 5)">
                    <img src="view/medias/icons/exclamationmark.png" alt="email logo" class="icon-small nomargin">
                    <span class="pr-2 bigvalue"><?= $project['importance'] ?></span>
                </div>
                <?php if (isAtLeastEqual($project['state'], [PROJECT_STATE_ABANDONNED, PROJECT_STATE_CANCELLED, PROJECT_STATE_DONE]) == false) { ?>
                    <div class="box-verticalaligncenter" title="Urgence du projet (1 à 5)">
                        <img src="view/medias/icons/clock.png" alt="email logo" class="icon-small nomargin">
                        <span class="pl-2 pr-1 bigvalue"><?= $project['urgency'] ?></span>
                    </div>
                    <?php
                }
                $helptype = null;
                if ($project['needInternalHelp'] == true) {
                    $helptype = WORK_NEEDHELP_INNER;
                }
                if ($project['needExternalHelp'] == true) {
                    $helptype = WORK_NEEDHELP_OUTER;
                }
                if ($project['needExternalHelp'] == true && $project['needInternalHelp'] == true) {
                    $helptype = WORK_NEEDHELP_BOTH;
                }
                $concernedByNeedHelp = ($project['needExternalHelp'] == true && $project['isUserLoggedInside'] == false || $project['needInternalHelp'] == true && $project['isUserLoggedInside'] == true);
                $addCssIfConcerned = "";
                if ($concernedByNeedHelp) {
                    $addCssIfConcerned = "borderForConcernedNeedhelp";
                }
                if ($project['isUserLoggedInside'] == true) {
                    ?>
                    <div class="box-verticalaligncenter pl-2 pr-1">
                        <?php
                        if ($helptype != null) {
                            printAnIcon(convertWorkNeedhelpIcon($helptype), convertWorkNeedhelp($helptype, true), "need external help icon", "icon-small nomargin $addCssIfConcerned");
                        } ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="box-verticalaligncenter pl-2 pr-1">
                        <?php
                        if ($helptype != null && $helptype != WORK_NEEDHELP_INNER) {
                            printAnIcon(convertWorkNeedhelpIcon($helptype), convertWorkNeedhelp($helptype, true), "need external help icon", "icon-small nomargin $addCssIfConcerned");
                        } ?>
                    </div>
                    <?php
                } ?>
            </div>

            <div class="flex-4 box-verticalaligncenter">

            </div>

        </div>

        <div class="positionBottomRightForProjectsDetailsBtn">
            <?php
            //Display the archive icon if the project is archived
            if ($project['archived'] == 1) { ?>
                <img title="Projet archivé" class="icon-small" src="view/medias/icons/archive.png"
                     alt="archive icon"><?php }
            //Display the invisible icon if the project is invisible
            if ($project['visible'] == 0) { ?>
                <img title="Ce projet est invisible pour les personnes extérieures au projet"
                     src="view/medias/icons/hiddeneye.png" alt="email logo" class="icon-small">
            <?php }
            ?>
            <button class="btn nopadding btn-yellow clickable"
                    data-href="?action=project&id=<?= $project['id'] ?>"><?php printAnIcon("details.svg", "Détails du projet", "details icon", "icon-small") ?></button>
            <button class="btn nopadding btn-yellow clickable"
                    data-href="?action=kanban&id=<?= $project['id'] ?>"><?php printAnIcon("kanban.png", "Kanban du projet", "kanban icon", "icon-small") ?></button>
        </div>
        <?php
        //TODO: refactor the code in a function to avoid duplicate. Make a more clever calcul with data progression.
        //Calculate effort provided/total and value generated/total
        $totalEffort = 0;
        $totalValue = 0;
        $providedEffort = 0;
        $generatedValue = 0;

        $providedEffort = $progressionsByProject[$project['id']]['providedEffort'];
        $totalEffort = $progressionsByProject[$project['id']]['totalEffort'];
        $percentageEffort = $progressionsByProject[$project['id']]['percentageEffort'];

        ?>
        <div title="<?= $percentageEffort . "% du projet réalisé (" . $providedEffort . "/" . $totalEffort . " points d'effort)" ?>"
             class="positionBottomForProgressBar fullwidth heightProgressBar">
            <div class="heightProgressBar progressBar"
                 style="width: <?= $percentageEffort ?>%"></div>
        </div>
    </div>
    <?php
    echo ob_get_clean();
}

//Print the category HTML and filter projects depeding on the category (states and archived or not)
function printACategoryOfProjects($name, $projects, $progressionsByProject, $authorizedStates, $archivedProjectsAuthorized = false)
{
    $noProjectDisplayed = true; //default value
    echo '<h2>' . $name . '</h2>
        <div class="divGroups margin-5px">';    //name of category and start of div
    foreach ($projects as $project) {
        if (isAtLeastEqual($project['state'], $authorizedStates)) { //accept only project with states authorized by the category
            if ($project['archived'] == 1) {    //if project is archived
                if ($archivedProjectsAuthorized) {  //display only if authorized
                    printAProject($project, $progressionsByProject);
                    $noProjectDisplayed = false;    //at least one project has been display (so no msg to say "no project in this category")
                }
            } else {
                printAProject($project, $progressionsByProject);
                $noProjectDisplayed = false;    //at least one project has been display (so no msg to say "no project in this category")
            }

        }
    }
    //If no project has been displayed, display a information message
    if ($noProjectDisplayed) {
        echo "<p class='marginplus5px'>Aucun projet de cette catégorie...</p>";
    }

    echo "</div>";
    echo "<hr class='hryellowproject mb-4 mt-3'>";    //horizontal separator line
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
            <p class="pt-2 nomargin"><?= $description ?></p>
        </div>

        <div class="box-alignright">
            <a href="?action=createAProject">
                <button class="btn btn-primary newproject">Nouveau projet</button>
            </a>
        </div>
    </div>
    <div class="divProjectCategory">
        <?php
        $progressionsByProject = calculateProgressionOfProjects(getAllProjects(), getAllWorks(), getAllTasks());
        if (empty($projects) == false) {
            if ($option != 3) { //not display in run and on break category for option 3 (archived projects)
                printACategoryOfProjects("En cours", $projects, $progressionsByProject, [PROJECT_STATE_SEMIACTIVEWORK, PROJECT_STATE_ACTIVEWORK, PROJECT_STATE_UNDERREFLECTION, PROJECT_STATE_UNDERPLANNING]);
                printACategoryOfProjects("En pause", $projects, $progressionsByProject, [PROJECT_STATE_ONBREAK, PROJECT_STATE_REPORTED]);
            }
            printACategoryOfProjects("Terminés", $projects, $progressionsByProject, [PROJECT_STATE_DONE], (isAtLeastEqual($option, [2, 3])));   //archived projects are visible in contributed and archived projects options
            printACategoryOfProjects("Autres", $projects, $progressionsByProject, [PROJECT_STATE_ABANDONNED, PROJECT_STATE_CANCELLED], (isAtLeastEqual($option, [2, 3])));  //archived projects are visible in contributed and archived projects options
        } else {
            echo "<h5 class='marginplus5px mt-3'>Aucun projet sous cette option...</h5>";
        }
        ?>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>