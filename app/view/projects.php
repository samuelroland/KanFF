<?php
//Print a project with all its informations
function printAProject($project)
{
    ob_start();
    ?>
    <div class="divProject breakword thinBorder <?= (($project['visible'] == 0) ? "notVisibleToAll" : "") ?>">
        <?php if ($project['isUserLoggedInside'] == true) { ?>
            <div class="topRightForProjectKey borderradius">
                <div class="p-1 pl-3 pr-3 "><?= printAnIcon("key.png", "", "", "icon-small") ?></div>
            </div>
        <?php } ?>
        <div class="divProjectFirstLine">
            <div class="divProjectTitleLine flexdiv">
                <h3 title="<?= $project['name'] ?>" class="flex-1"><?php
                    if (strlen($project['name']) > 26) {
                        echo createToolTip(createElementWithFixedLines($project['name'], 1), htmlspecialchars($project['name']));
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
        <div class="positionBottomRightForProjectsDetailsBtn">
            <button class="btn nopadding btn-yellow clickable" data-href="?action=kanban&id=<?= $project['id'] ?>"><?php printAnIcon("kanban.png", "Kanban du projet", "kanban icon", "icon-small") ?></button>
            <button class="btn nopadding btn-yellow clickable" data-href="?action=project&id=<?= $project['id'] ?>"><?php printAnIcon("details.svg", "Détails du projet", "details icon", "icon-small") ?></button>
        </div>
        <?php
        //TODO: refactor the code in a function to avoid duplicate. Make a more clever calcul with data progression.
        //Calculate effort provided/total and value generated/total
        $totalEffort = 0;
        $totalValue = 0;
        $providedEffort = 0;
        $generatedValue = 0;
        foreach ($project['works'] as $work) {
            $totalEffort += $work['effort'];
            $totalValue += $work['value'];
            if ($work['state'] == WORK_STATE_DONE) {
                $providedEffort += $work['effort'];
                $generatedValue += $work['value'];
            }
        }
        $percentageEffort = round($providedEffort * 100 / $totalEffort, 1); //with the rule of 3, calculate the percentage and round it to one digit
        ?>
        <div class="positionBottomForProgressBar fullwidth heightProgressBar">
            <div class="heightProgressBar progressBar" style="width: <?= $percentageEffort ?>%"></div>
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
                    $noProjectDisplayed = false;    //at least one project has been display (so no msg to say "no project in this category")
                }
            } else {
                printAProject($project);
                $noProjectDisplayed = false;    //at least one project has been display (so no msg to say "no project in this category")
            }

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
<?php printPageWIPTextInfo(); ?>
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
        if (empty($projects) == false) {
            if ($option != 3) { //not display in run and on break category for option 3 (archived projects)
                printACategoryOfProjects("En cours", $projects, [PROJECT_STATE_SEMIACTIVEWORK, PROJECT_STATE_ACTIVEWORK, PROJECT_STATE_UNDERREFLECTION, PROJECT_STATE_UNDERPLANNING]);
                printACategoryOfProjects("En pause", $projects, [PROJECT_STATE_ONBREAK, PROJECT_STATE_REPORTED]);
            }
            printACategoryOfProjects("Terminés", $projects, [PROJECT_STATE_DONE], (isAtLeastEqual($option, [2, 3])));   //archived projects are visible in contributed and archived projects options
            printACategoryOfProjects("Autres", $projects, [PROJECT_STATE_ABANDONNED, PROJECT_STATE_CANCELLED], (isAtLeastEqual($option, [2, 3])));  //archived projects are visible in contributed and archived projects options
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