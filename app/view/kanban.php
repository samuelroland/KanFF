<?php
/**
 *  Project: KanFF
 *  File: kanban.php view of the kanban of a project
 *  Author: Samuel Roland
 *  Creation date: 12.10.2020
 */
$panelRight = 2;    //for dev: which main div is displayed in the panelRight ? 1 = task details and 2 = create a task
/*
 * Function to display a work:
 * */

function printAnIcon($iconname, $title, $alt, $defaultClasses = "icon-small ml-2 mr-2", $echo = true)
{
    $html = "<img title=\"" . $title . "\" class='$defaultClasses' src='view/medias/icons/$iconname' alt='$alt'>";
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
}

function printAWork($work, $isInsideTheProject)
{
    ob_start();
    switch ($work['state']) {
        case WORK_STATE_INRUN:
            $borderAndPastilleColor = "#00b7ffaa;";//default x with transparent
            $bgCssColor = "#00b7ff12";
            break;
        case WORK_STATE_ONBREAK:
            $borderAndPastilleColor = "#ffa500aa";//default orange with transparent
            $bgCssColor = "#ffa50012";
            break;
        case WORK_STATE_DONE:
            $borderAndPastilleColor = "#008000aa";   //default green with transparent
            $bgCssColor = "#00800012";
            break;
    }
    if ($work['inbox'] == 1) {
        $borderAndPastilleColor = "lightgrey";
        $bgCssColor = "";
    }
    ?>
    <div class="divWork" style="border: 2px solid <?= $borderAndPastilleColor ?>; border-radius: 5px;"
         data-id="<?= $work['id'] ?>" id="Work-<?= $work['id'] ?>">
        <div class="divWorkHeader box-verticalaligncenter" style="background-color: <?= $bgCssColor ?> !important;">
            <div class="flex-1 flexdiv box-verticalaligncenter">
                <h5 class="nomargin pr-2 pl-2"><?= $work['name'] ?></h5>
                <div class="divWorkIconsLeft flexdiv box-verticalaligncenter">
                    <?php
                    if ($work['inbox'] != 1) {
                        echo "<span class='ml-4 mr-5'>" . getHTMLPastille($borderAndPastilleColor) . "<strong>" . convertWorkState($work['state'], true) . "</strong></span>";
                    } else {
                        printAnIcon("inbox.png", "Ce travail est la boîte de réception du projet", "inbox icon", "icon-inbox ml-4 mr-5");
                    }
                    //Display the archive icon if the project is archived
                    if ($work['open'] == 1) {
                        printAnIcon("padlock2.png", "Ce travail est ouvert (accessible en modification aux personnes extérieures au projet", "padlock icon");
                    }
                    //Display the invisible icon if the project is invisible
                    if ($work['visible'] == 0) {
                        printAnIcon("hiddeneye.png", "Ce travail est invisible pour les personnes extérieures au projet", "hidden eye icon");
                        echo "<span class='text-info mr-2'>Invisible</span>";
                    }
                    if ($work['need_help'] != 0) {
                        $iconname = "help_orange.png";
                        $icontitle = "Ce travail a besoin d'aide. (Voir si interne et/ou externe).";
                        $description = "Besoin d'aide";
                        switch ($work['need_help']) {
                            case 1:
                                $iconname = "help_orange.png";
                                $description = "Besoin d'aide interne";
                                break;
                            case 2:
                                $iconname = "help_yellow.png";
                                $description = "Besoin d'aide externe";
                                break;
                            case 3:
                                $iconname = "help_orangeyellow.png";
                                $description = "Besoin d'aide interne et externe";
                                break;
                        }
                        if ($isInsideTheProject) {  //inside the project, the icon is in all cases displayed (even if don't need help from members inside the project)
                            printAnIcon($iconname, $icontitle, "H letter for help icon");
                            echo "<span class=' mr-2'>$description</span>";
                        } else {
                            if (isAtLeastEqual($work['need_help'], [2, 3])) {   //icon is displayed only if visible by outside members
                                printAnIcon($iconname, $icontitle, "H letter for help icon");
                                echo "<span class='text-danger mr-2'>$description</span>";
                            }
                        }

                    }
                    if ($work['repetitive'] == 1) {
                        printAnIcon("repetitive.png", "Ce travail est répétitif", "arrows in circle repetitive icon");
                    }
                    ?>
                </div>
            </div>
            <div class="divWorkIconsRight box-verticalaligncenter">
                <?= ($work['state'] == WORK_STATE_DONE) ? "<button class='btnSeeMoreOrLessWorks borderformodifiabletask'>Afficher contenu</button>" : "" ?>
                <span class="ml-3 mr-3">Effort: <?= $work['effort'] ?> - Valeur: <?= $work['value'] ?></span>
                <span class="ml-3 mr-3"><?= DTToHumanDate($work['start']) ?> - <?= DTToHumanDate($work['end']) ?></span>
            </div>
        </div>
        <div class="divWorkContent flexdiv" <?= ($work['state'] == WORK_STATE_DONE) ? "hidden" : "" ?>>
            <div class="flex-1 leftcolumn divWorkOneState">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_TODO) {
                        printATask($task, $work['hasWritingRightOnTasks']);
                    }
                }
                ?>
                <?php
                displaydebug($work['hasWritingRightOnTasks']);
                if ($work['hasWritingRightOnTasks'] && $work['state']!= WORK_STATE_DONE) {
                    echo "<div id='divTaskPlusButton' class='divTaskPlusButton borderformodifiabletask cursorpointer' data-work='{$work['id']}'>";
                    printAnIcon("plus.png", "Créer une tâche", "plus icon", "divTaskPlusButtonIcon");
                    echo "</div>";
                }
                ?>
            </div>
            <div class="flex-1 middlecolumn divWorkOneState">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_INRUN) {
                        printATask($task, $work['hasWritingRightOnTasks']);
                    }
                }
                ?>
            </div>
            <div class="flex-1 rightcolumn divWorkOneState">
                <?php
                $nbtasks = 0;
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_DONE) {
                        $nbtasks++;
                        if ($nbtasks <= 6) {
                            printATask($task, $work['hasWritingRightOnTasks']);
                        } else {
                            printATask($task, $work['hasWritingRightOnTasks'], true);
                        }
                    }
                }
                if ($nbtasks > 6) {
                    echo "<div class='divSeeMoreOrLessTasks box-verticalaligncenter box-aligncenter'><button class='btnSeeMoreOrLessTasks borderformodifiabletask' >Voir plus</button></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    echo ob_get_clean();
}

function printATask($task, $hasWritingRightOnTasks, $hidden = false)
{
    ob_start();
    switch ($task['type']) {
        case 1:
            $color = "green";
            break;
        //TODO: choose the right color depending on the type
    }
    ?>
    <div class="divTask <?= (($hasWritingRightOnTasks) ? "cursorgrab borderformodifiabletask " : "") ?>"
         id="Task-<?= $task['id'] ?>"
         data-id="<?= $task['id'] ?>" <?= ($hidden) ? "hidden" : "" ?>>
        <div class="flexdiv divTaskNumber">
            <div class="flex-1"><?php if ($task['responsible_id'] != null) {
                    echo "<span class='divTaskUserMentionEllipsis'>" . mentionUser($task['responsible'], "txtMentionOnTask") . "</span>";
                } ?></div>
            <div class=""><em><?= $task['number'] ?></em></div>
        </div>
        <div class="divTaskName"><strong><?= createElementWithFixedLines($task['name'], 4) ?></strong></div>
        <div class="divTaskBottomLine flexdiv" hidden>
            <span class="flex-1 box-verticalaligncenter">
                <span>
                <?php
                if ($hasWritingRightOnTasks) {
                    if ($task['responsible_id'] != null && $task['responsible_id'] == $_SESSION['user']['id']) {
                        printAnIcon("removeuser.png", "Relâcher la tache", "remove user icon", "icon-task " . (($hasWritingRightOnTasks) ? "cursorpointer" : ""));
                    } else {
                        printAnIcon("adduser3.png", "Prendre la tâche", "add user icon", "icon-task " . (($hasWritingRightOnTasks) ? "cursorpointer" : ""));
                    }
                }
                ?>
                </span>
            </span>
            <?php
            //No comments on tasks for v1.0 so the icon is not displayed:
            //printAnIcon("chat.png", "x Commentaires", "triangle bottom icon", "icon-task");
            ?>
            <span class="dropdown">
                <span class='' data-toggle="dropdown">
                    <?php printAnIcon("trianglebottom.png", "Options supplémentaires", "triangle bottom icon", "icon-task-triangle cursorpointer"); ?>
                </span>
                <div class="dropdown-menu dropdown-menu-right divTaskDropdownOptions">
                <span class="dropdown-item divTaskDropdownOption">Détails</span>
                    <?php if ($hasWritingRightOnTasks) { ?>
                        <?php if ($task['state'] != TASK_STATE_DONE) { ?>
                            <span class="dropdown-item divTaskDropdownOption">Prendre</span>
                        <?php } ?>
                        <?php
                        $optionsToChangeState = [];
                        switch ($task['state']) {
                            case TASK_STATE_TODO:
                                $optionsToChangeState = [TASK_STATE_INRUN, TASK_STATE_DONE];
                                break;
                            case TASK_STATE_INRUN:
                                $optionsToChangeState = [TASK_STATE_DONE, TASK_STATE_TODO];
                                break;
                            case TASK_STATE_DONE:
                                $optionsToChangeState = [TASK_STATE_INRUN];
                                break;
                        }
                        foreach ($optionsToChangeState as $option) {
                            echo "<span class='dropdown-item divTaskDropdownOption'>Passer à " . convertTaskState($option, true) . "</span>";
                        }
                        ?>
                        <span class="dropdown-item divTaskDropdownOption text-danger">Supprimer</span>
                    <?php } ?>
                </div>
            </span>

        </div>
    </div>
    <?php
    echo ob_get_clean();
}

$title = "Kanban de " . $project['name'];
ob_start();
?>
    <div class="divHeader flexdiv p-1 pr-2 pl-2">
        <div class="flex-1 flexdiv box-verticalaligncenter">
            <h1 class="nomargin"><?= $project['name'] ?></h1>
            <h4 class="pl-5 pr-2 nomargin"><?= convertProjectState($project['state'], true) ?></h4>
            <h5 class="pl-5 pr-2 nomargin">Effort (fourni/total): <?= "3/34" ?></h5>
            <h5 class="pl-5 pr-2 nomargin">Valeur (générée/total): <?= "3/34" ?></h5>
        </div>
        <div class="box-verticalaligncenter">
            <button class="btn btn-info clickable" data-href="?action=project&id=<?= $project['id'] ?>">Détails</button>
        </div>
    </div>
    <div class="divKanban flexdiv <?= (isAtLeastEqual($opt, ["1", "2"])) ? "" : "withoutdetails" ?>" id="divKanban">
        <div class="divKanbanHeaderAndContent flex-1">
            <div class="divKanbanHeader flexdiv">
                <div class="flex-1 box-verticalaligncenter justify-content-center leftcolumn">
                    <h4 class="nomargin"><?= convertTaskState(TASK_STATE_TODO, true) ?></h4>
                </div>
                <div class="flex-1 box-verticalaligncenter justify-content-center middlecolumn">
                    <h4 class="nomargin"><?= convertTaskState(TASK_STATE_INRUN, true) ?></h4>
                </div>
                <div class="flex-1 box-verticalaligncenter justify-content-center rightcolumn">
                    <h4 class="nomargin"><?= convertTaskState(TASK_STATE_DONE, true) ?></h4>
                </div>
            </div>
            <hr class="hrgrey nomargin">

            <div class="divKanbanContent flexdiv">
                <div class="divWorks flex-1">
                    <!-- List of works -->
                    <?php
                    foreach ($project['works'] as $work) {
                        if ($work['state'] != WORK_STATE_TODO) {
                            printAWork($work, $isInsideTheProject);
                        }
                        displaydebug($work['name']);
                        displaydebug($work['hasWritingRightOnTasks']);
                    }

                    if (count($works) == 1) {
                        echo "<div class='statebanner bg-transparent mt-2 mb-2'>Tous les travaux sont '" . convertWorkState(WORK_STATE_DONE) . "'</div>";
                    }
                    ?>
                    <hr class="hryellowproject nomargin">
                </div>
            </div>
        </div>
        <div class="divRightPanel" id="divRightPanel" <?= (isAtLeastEqual($opt, ["1", "2"])) ? "" : "hidden" ?>>
            <?php
            $spanCSS = "";
            $divCSS = "mt-2";
            ?>
            <!-- divTaskDetails Details of a task -->
            <div id="divTaskDetails" class="divInRightPanel" style="display: none;" >
                <div class="panelRightStandardHeader flexdiv box-verticalaligncenter middlecolumn">
                    <span class="flex-1">Détails tâche n. <strong><span id="number"></span></strong></span>
                    <div class="mr-3">
                        <div id="state" class="alignright fullwidth font-weight-bold"></div>
                        <div class="smallinfotext alignright" id="spancompletion"></div>
                    </div>
                    <span class="circle-redcross onclickCloseDetails"><?php printAnIcon("redcross.png", "Fermer le panneau de détails", "red cross icon", "icon-redcross") ?></span>
                </div>
                <div class="divTaskDetailsContent" id="divTaskDetailsContent">
                    <div class="divTaskDetailsFirstLine flexdiv box-verticalaligncenter">
                        <h5 id="spanname" class="flex-1 nomargin"></h5>
                        <?php printAnIcon("chevrondown.png", "Options", "chevron down icon"); ?>
                    </div>
                    <hr class="hrgrey nomargin">
                    <div class="divTaskDetailsInformations">
                        <div class="flexdiv  <?= $divCSS ?>">
                            <div class="flex-2">
                                <div class="flexdiv">
                                    <span class="flex-1 <?= $spanCSS ?>">Nom:</span>
                                    <span id="pCounterName"></span>
                                </div>
                                <input id="inputname" name="name" type="text"
                                       class="form-control textFieldToCheck counterVisibleOnlyIfFastMaxLength"
                                       placeholder="Nom de la tâche" maxlength="100">
                            </div>
                            <div class="flex-1 ml-2">
                                <span class="<?= $spanCSS ?>">Travail:</span>
                                <input type="text" id="workname" class="form-control" disabled readonly>
                            </div>
                        </div>
                        <div class=" <?= $divCSS ?>">
                            <span class="<?= $spanCSS ?>">Description:</span>
                            <textarea id="description" name="description" type="text" rows="4"
                                      class="form-control textFieldToCheck counterVisibleOnlyIfFastMaxLength"
                                      placeholder="Description de la tâche" maxlength="2000"></textarea>
                            <div class="alignright"><span id="pCounterDescription"></span></div>
                        </div>
                        <div class="flexdiv <?= $divCSS ?>">
                            <div class="">
                                <span class="<?= $spanCSS ?>">Type:</span>
                                <select class="form-control" name="type" id="type">
                                    <option value="null">(Aucun)</option>
                                    <option value="1">Question</option>
                                    <option value="2">Information</option>
                                    <option value="3">Proposition</option>
                                    <option value="4">Idée</option>
                                    <option value="5">Réflexion</option>
                                </select>
                            </div>
                            <div class="flex-1 ml-3">
                                <span class="<?= $spanCSS ?>">Responsable:</span>
                                <div class="flexdiv divResponsible box-verticalaligncenter">
                                    <div class="circle-responsible mr-2">
                                        <p class="marginauto" id="initials"></p>
                                    </div>
                                    <input type="text" id="responsible" class="form-control"
                                           value="" disabled readonly>
                                </div>
                                <div class="alignright smallinfotext"><span id="creator"></span></div>
                            </div>
                        </div>
                        <div class="flexdiv <?= $divCSS ?>">
                            <div class="flex-1">
                                <span class="<?= $spanCSS ?>">Date limite:</span>
                                <input id="deadline" type="date" value="" name="deadline"
                                       class="form-control inputtypedate">
                            </div>
                            <div class="flex-1 flexdiv">
                                <div class="ml-3">
                                    <span class="<?= $spanCSS ?>">Urgence:</span>
                                    <input type="number" id="urgency" class="form-control inputtypenumber"
                                           value="" min="0" max="5">
                                </div>
                                <div class="mt-4">
                                    <?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-xsmall m-2", false), "Notez l'urgence de la tâche de 0 à 5 (0 = aucun, 1 = min et 5 = max)", false) ?>
                                </div>
                            </div>
                        </div>
                        <div class="<?= $divCSS ?>">
                            <div class="flexdiv">
                                <span class="flex-1">Lien:</span>
                                <span class="alignright">Ouvrir le lien</span>
                            </div>
                            <input type="text" placeholder="Lien relatif à la tâche" name="link" id="link"
                                   class="form-control textFieldToCheck counterVisibleOnlyIfFastMaxLength"
                                   maxlength="2000">
                            <div class="alignright">
                                <span id="pCounterLink">asfd</span>
                            </div>
                        </div>
                        <div class="<?= $divCSS ?>">
                            <span class="<?= $spanCSS ?>">Projet:</span>
                            <input id="projectname" type="text" value="<?= $project['name'] ?>" class="form-control"
                                   disabled readonly>
                        </div>
                        <div class="panelRightStandardBottomLine">
                            <div class="flexdiv box-alignright">
                                <button class="btnSaveCancel btn colorCancel">Annuler</button>
                                <button class="btnSaveCancel btn colorSave">Enregistrer</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- divTaskCreate Form to create a task -->
            <div id="divTaskCreate" class="divInRightPanel" style="display: none;">
                <div class="panelRightStandardHeader flexdiv box-verticalaligncenter middlecolumn">
                    <span class="flex-1"><strong>Créer une tâche</strong></span>
                    <span class="circle-redcross onclickCloseDetails"><?php printAnIcon("redcross.png", "Fermer le panneau de détails", "red cross icon", "icon-redcross") ?></span>
                </div>
                <div class="" id="divTaskCreateContent">
                    <div class="divTaskDetailsFirstLine flexdiv box-verticalaligncenter">
                        <h5 id="spannamecreate" class="flex-1 nomargin"></h5>
                    </div>
                    <hr class="hrgrey nomargin">
                    <span class="smallinfotext">Une tâche est une activité courte réalisée par une personne parmi d'autres tâches dans le but d'effectuer entièrement le travail. </span>
                    <div class="flexdiv mt-2">
                        <div class="flex-1">
                            <div class="flexdiv">
                                <span class="flex-1">Nom:</span>
                                <span class="" id="pCounterName2"></span>
                            </div>
                            <input type="text" id="inputnamecreate" name="name2" maxlength="100" autofocus
                                   class="textFieldToCheck counterVisibleOnlyIfFastMaxLength form-control"
                                   placeholder="Nom de la tâche">
                        </div>
                        <div class="ml-2 ">
                            <span class="">Type:</span>
                            <select class="form-control" name="type" id="type">
                                <option value="null">(Aucun)</option>
                                <option value="1">Question</option>
                                <option value="2">Information</option>
                                <option value="3">Proposition</option>
                                <option value="4">Idée</option>
                                <option value="5">Réflexion</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="">Travail:</span>
                        <select class="form-control" name="work" id="work">
                            <?php
                            //TODO: add conditions to not include invisible and done, and sort the list cleverly
                            foreach ($project['works'] as $work) {
                                if ($work['state'] != WORK_STATE_DONE && $work['hasWritingRightOnTasks']) {
                                    ?>
                                    <option class="" value="<?= $work['id'] ?>" data-work="<?= $work['id'] ?>"><?= $work['name'] ?><?php echo ($work['inbox'] != 1) ? " (".convertWorkState($work['state'], true).")" : "" ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mt-2">
                        <span class="smallinfotext">Les autres informations de la tâche peuvent être complété par la suite...</span>
                    </div>
                    <div class="mt-2 flexdiv">
                        <div class="flex-1 box-verticalaligncenter">
                            <input type="checkbox" id="chkSerialCreation">
                            <label for="chkSerialCreation" class="ml-2 noverticalmargin">Mode Création en série</label>
                        </div>
                        <div class="box-alignright">
                            <span><?= createToolTip(printAnIcon("point.png", "", "question mark icon", "icon-xsmall m-2", false), "Ce mode vous permet de créer plusieurs tâches à la suite en restant sur ce formulaire. Par défaut quand le mode est désactivé, les détails de la tâche apparaissent directement après la création.", false, "bottom") ?></span>
                        </div>
                    </div>
                    <div class="panelRightStandardBottomLine ">
                        <div class="flexdiv mb-3">
                            <div class="box-verticalaligncenter">
                                <?= printAnIcon("point.png", "", "question mark icon", "icon-xsmall m-2", false) ?>
                            </div>
                            <div class="smallinfotext text-decoration-none">
                                <strong>Astuce: </strong><br>
                                Pour rentrer les informations plus rapidement, utilisez les touches Tab et Maj+Tab pour
                                changer de champ, les flèches du clavier pour choisir un type, ainsi que la touche Enter
                                (pour créer la tâche).<br>Vous n'avez donc pas besoin de la souris.
                            </div>
                        </div>
                        <div class="flexdiv box-alignright">
                            <button class="btnSaveCancel btn colorCancel">Annuler</button>
                            <button class="btnSaveCancel btn colorSave">Créer la tâche</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php
displaydebug($project);
$contenttype = "full";
$content = ob_get_clean();
require "gabarit.php";
?>