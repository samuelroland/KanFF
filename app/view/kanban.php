<?php
/**
 *  Project: KanFF
 *  File: kanban.php view of the kanban of a project
 *  Author: Samuel Roland
 *  Creation date: 12.10.2020
 */

/*
 * Function to display a work:
 * */

function printAnIcon($iconname, $title, $alt, $defaultClasses = "icon-small ml-2 mr-2")
{
    echo "<img title=\"" . $title . "\" class='$defaultClasses' src='view/medias/icons/$iconname' alt='$alt'>";
}

function printAWork($work)
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
    <div class="divWork" style="border: 2px solid <?= $borderAndPastilleColor ?>; border-radius: 5px;">
        <div class="divWorkHeader box-verticalaligncenter" style="background-color: <?= $bgCssColor ?> !important;">
            <div class="flex-1 flexdiv box-verticalaligncenter">
                <h5 class="nomargin pr-2 pl-2"><?= $work['name'] ?></h5>
                <div class="divWorkIconsLeft flexdiv box-verticalaligncenter">
                    <?php
                    if ($work['inbox'] != 1) {
                        echo "<span class='ml-4 mr-5'>" . getHTMLPastille($borderAndPastilleColor) . "<strong>" . convertWorkState($work['state'], true) . "</strong></span>";
                    }
                    //Display the archive icon if the project is archived
                    if ($work['open'] == 1) {
                        printAnIcon("open.png", "Ce travail est ouvert (accessible en modification aux personnes extérieures au projet", "padlock icon");
                    }
                    //Display the invisible icon if the project is invisible
                    if ($work['visible'] == 0) {
                        printAnIcon("hiddeneye.png", "Ce travail est invisible pour les personnes extérieures au projet", "hidden eye icon");
                        echo "<span class='text-info mr-2'>Invisible</span>";
                    }
                    if ($work['need_help'] == 1) {
                        //TODO: display differents icons depending on the level of need help
                        printAnIcon("help_orange.png", "Ce travail a besoin d'aide. WIP", "H letter for help icon");
                        echo "<span class='text-danger mr-2'>Besoin d'aide</span>";
                    }
                    if ($work['repetitive'] == 1) {
                        printAnIcon("repetitive.png", "Ce travail est répétitif", "arrows in circle repetitive icon");
                    }
                    ?>
                </div>
            </div>
            <div class="divWorkIconsRight box-verticalaligncenter">
                <span class="ml-3 mr-3">Effort: <?= $work['effort'] ?> - Valeur: <?= $work['value'] ?></span>
                <span class="ml-3 mr-3"><?= DTToHumanDate($work['start']) ?> - <?= DTToHumanDate($work['end']) ?></span>
                <?php
                //TODO: display icons of the work
                ?>
            </div>
        </div>
        <div class="divWorkContent flexdiv" <?= ($work['state'] == WORK_STATE_DONE) ? "hidden" : "" ?>>
            <div class="flex-1 leftcolumn divWorkOneState">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_TODO) {
                        printATask($task);
                    }
                }
                ?>
                <?php
                echo "<div class='divTaskPlusButton cursorpointer'>";
                printAnIcon("plus.png", "Créer une tâche", "plus icon", "divTaskPlusButtonIcon");
                echo "</div>";
                ?>
            </div>
            <div class="flex-1 middlecolumn divWorkOneState">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_INRUN) {
                        printATask($task);
                    }
                }
                ?>
            </div>
            <div class="flex-1 rightcolumn divWorkOneState">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_DONE) {
                        printATask($task);
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    echo ob_get_clean();
}

function printATask($task)
{
    ob_start();
    switch ($task['type']) {
        case 1:
            $color = "green";
            break;
        //TODO: choose the right color depending on the type
    }
    ?>
    <div class="divTask cursorgrab" id="divTask-<?= $task['id'] ?>" data-id="<?= $task['id'] ?>">
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
                if ($task['responsible_id'] != null && $task['responsible_id'] == $_SESSION['user']['id']) {
                    printAnIcon("removeuser.png", "Relâcher la tache", "remove user icon", "icon-task cursorpointer");
                } else {
                    printAnIcon("adduser3.png", "Prendre la tâche", "add user icon", "icon-task cursorpointer");
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
                <span class="dropdown-item divTaskDropdownOption">Prendre</span>
                <span class="dropdown-item divTaskDropdownOption">Passer à En cours</span>
                <span class="dropdown-item divTaskDropdownOption">Passer à Fini</span>
                <span class="dropdown-item divTaskDropdownOption text-danger">Supprimer</span>
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
    <div class="divKanbanHeader flexdiv p-3">
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
    <hr class="hryellowproject nomargin">

    <div class="divKanbanHeaderColumns flexdiv">
        <div class="flex-1 box-verticalaligncenter justify-content-center leftcolumn"><h4 class="nomargin">A faire</h4>
        </div>
        <div class="flex-1 box-verticalaligncenter justify-content-center middlecolumn"><h4 class="nomargin">En
                cours</h4></div>
        <div class="flex-1 box-verticalaligncenter justify-content-center rightcolumn"><h4 class="nomargin">Fini</h4>
        </div>
    </div>
    <hr class="hryellowproject nomargin">

    <!-- List of works -->
<?php foreach ($works as $work) {
    if ($work['state'] != WORK_STATE_TODO) {
        printAWork($work);
    }
}

if (count($works) == 1) {
    echo "<div class='statebanner bg-transparent mt-2 mb-2'>Tous les travaux sont 'A faire'</div>";
}
?>
    <hr class="hryellowproject nomargin">
<?php
displaydebug($project);
$contenttype = "full";
$content = ob_get_clean();
require "gabarit.php";
?>