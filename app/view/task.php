<?php
/**
 *  Project: KanFF
 *  File: task.php view functions to print one task (only) in kanban.php
 *  Author: Samuel Roland
 *  Creation date: 23.10.2020
 */

//print a task in a kanban
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
    <div draggable="<?= (($hasWritingRightOnTasks) ? "true" : "false") ?>"
         class="divTask <?= (($hasWritingRightOnTasks) ? "borderformodifiabletask " : "") ?>"
         id="Task-<?= $task['id'] ?>"
         data-id="<?= $task['id'] ?>"
         data-canedit="<?= (($hasWritingRightOnTasks) ? "true" : "false") ?>"
        <?= ($hidden) ? "hidden" : "" ?>>
        <div class="flexdiv divTaskNumber">
            <div class="flex-1"><?php if ($task['responsible_id'] != null) {
                    echo "<span class='divTaskUserMentionEllipsis'>" . mentionUser($task['responsible'], "txtMentionOnTask responsible") . "</span>";
                } ?></div>
            <div class=""><em class="number"><?= $task['number'] ?></em></div>
        </div>
        <div class="divTaskName"><strong><?= createElementWithFixedLines($task['name'], 4, "name") ?></strong></div>
        <div class="divTaskBottomLine flexdiv" hidden>
            <span class="flex-1 box-verticalaligncenter">
                <span>
                <?php
                if ($hasWritingRightOnTasks) {
                    if ($task['responsible_id'] != null && $task['responsible_id'] == $_SESSION['user']['id']) {
                        printAnIcon("removeuser.png", "Relâcher la tache", "remove user icon", "icon-task iconresponsible removeresponsible " . (($hasWritingRightOnTasks) ? "cursorpointer" : ""));
                    } else {
                        printAnIcon("adduser3.png", "Prendre la tâche", "add user icon", "icon-task iconresponsible addresponsible " . (($hasWritingRightOnTasks) ? "cursorpointer" : ""));
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
                        <span class="dropdown-item divTaskDropdownOption text-danger optTaskDelete">Supprimer</span>
                    <?php } ?>
                </div>
            </span>

        </div>
    </div>
    <?php
    echo ob_get_clean();
}

?>
