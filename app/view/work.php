<?php
/**
 *  Project: KanFF
 *  File: work.php view functions to print one work (only) in kanban.php
 *  Author: Samuel Roland
 *  Creation date: 23.10.2020
 */

//print a work in a kanban
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
                        $description = convertWorkNeedhelp($work['need_help']);
                        $iconname = convertWorkNeedhelpIcon($work['need_help']);
                        $icontitle = convertWorkNeedhelp($work['need_help']);
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
                <?php if ($work['inbox'] != 1) { ?><span class="ml-3 mr-3"><?= DTToHumanDate($work['start']) ?>
                    - <?= DTToHumanDate($work['end']) ?></span><?php } ?>
            </div>
        </div>
        <div class="divWorkContent flexdiv" <?= ($work['state'] == WORK_STATE_DONE) ? "hidden" : "" ?>>
            <div class="flex-1 leftcolumn divWorkOneState" id="workstate-<?= $work['id'] ?>-1" data-id="<?= $work['state'] ?>">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_TODO) {
                        printATask($task, $work['hasWritingRightOnTasks']);
                    }
                }
                ?>
                <?php
                displaydebug($work['hasWritingRightOnTasks']);
                if ($work['hasWritingRightOnTasks']) {
                    echo "<div id='divTaskPlusButton' class='divTaskPlusButton borderformodifiabletask cursorpointer' data-work='{$work['id']}'>";
                    printAnIcon("plus.png", "Créer une tâche", "plus icon", "divTaskPlusButtonIcon");
                    echo "</div>";
                }
                ?>
            </div>
            <div class="flex-1 middlecolumn divWorkOneState" id="workstate-<?= $work['id'] ?>-2" data-id="<?= $work['state'] ?>">
                <?php
                foreach ($work['tasks'] as $task) {
                    if ($task['state'] == TASK_STATE_INRUN) {
                        printATask($task, $work['hasWritingRightOnTasks']);
                    }
                }
                ?>
            </div>
            <div class="flex-1 rightcolumn divWorkOneState" id="workstate-<?= $work['id'] ?>-3" data-id="<?= $work['state'] ?>">
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

?>
