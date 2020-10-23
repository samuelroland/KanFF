<?php
/**
 *  Project: KanFF
 *  File: kanban.php view of the kanban of a project
 *  Author: Samuel Roland
 *  Creation date: 12.10.2020
 */
$panelRight = 2;    //for dev: which main div is displayed in the panelRight ? 1 = task details and 2 = create a task

require_once "view/task.php";
require_once "view/work.php";
require_once "view/formsForRightPanel.php";

function printAnIcon($iconname, $title, $alt, $defaultClasses = "icon-small ml-2 mr-2", $echo = true)
{
    $html = "<img title=\"" . $title . "\" class='$defaultClasses' src='view/medias/icons/$iconname' alt='$alt'>";
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
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
            <?php printDivTaskDetails(); ?>
            <?php printDivTaskCreate($project); ?>
        </div>
    </div>
<?php
displaydebug($project);
$contenttype = "full";
$content = ob_get_clean();
require "gabarit.php";
?>