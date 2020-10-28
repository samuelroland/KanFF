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


$title = "Kanban de " . $project['name'];
ob_start();
?>
    <!-- divHeader Header of the page with information about the project -->
    <div class="divHeader flexdiv p-1 pr-2 pl-2">
        <div class="flex-1 flexdiv box-verticalaligncenter">
            <h1 class="nomargin"><?= $project['name'] ?></h1>
            <h4 class="pl-5 pr-2 nomargin"><?= convertProjectState($project['state'], true) ?></h4>

        </div>
        <div class="box-verticalaligncenter">
            <h5 class="pl-2 pr-4 nomargin" title="Effort fourni/total pour tous les travaux">
                Effort: <?= $providedEffort . "/" . $totalEffort ?></h5>
            <h5 class="pl-2 pr-4 nomargin" title="Valeur généré/total pour tous les travaux">
                Valeur: <?= $generatedValue . "/" . $totalValue ?></h5>
            <button class="btn btn-info clickable" data-href="?action=project&id=<?= $project['id'] ?>">Détails</button>
        </div>
    </div>

    <!-- divKanban All the kanban is in this div -->
    <div class="divKanban flexdiv <?= (isAtLeastEqual($opt, ["1", "2"])) ? "" : "withoutdetails" ?>" id="divKanban">

        <!-- divKanbanHeaderAndContent The kanban header and the content -->
        <div class="divKanbanHeaderAndContent flex-1">

            <!-- divKanbanHeader Header of the kanban (3 task states at the top of the kanban)-->
            <div class="divKanbanHeader">
                <div class="flexdiv divKanbanHeader">
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
                <div id="templates" hidden>
                    <template id="templateTask"><?php printATask([], true); ?></template>
                </div>

            </div>
            <hr class="hrgrey nomargin">

            <!-- divKanbanContent Content of the kanban (the list of the work with tasks inside) -->
            <div class="divKanbanContent">
                <?php
                foreach ($project['works'] as $work) {
                    if ($work['state'] != WORK_STATE_TODO) {
                        printAWork($work, $isInsideTheProject);
                    }
                    displaydebug($work['name']);
                    displaydebug($work['hasWritingRightOnTasks']);
                }

                //If there is no other work that the inbox work (all the time in run)
                if (count($works) == 1) {
                    echo "<div class='statebanner bg-transparent mt-2 mb-2'>Tous les travaux sont '" . convertWorkState(WORK_STATE_TODO) . "'</div>";
                }
                ?>
                <hr class="hryellowproject nomargin">
            </div>
        </div>

        <!-- divRightPanel for the right panel -->
        <div class="divRightPanel" id="divRightPanel" <?= (isAtLeastEqual($opt, ["1", "2"])) ? "" : "hidden" ?>>
            <?php printDivTaskDetails($project); ?>
            <?php printDivTaskCreate($project); ?>
        </div>
    </div>
<?php
displaydebug($project);
$contenttype = "full";
$content = ob_get_clean();
require "gabarit.php";
?>