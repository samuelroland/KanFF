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
function printAWork($work)
{
    ob_start();
    ?>
    <div class="divWork">
        <div class="divWorkHeader box-verticalaligncenter">
            <div class="flex-1 flexdiv">
                <h5 class="nomargin"><?= $work['name'] ?></h5>
                <div class="divWorkIconsLeft">
                    <?php
                    if ($work['inbox'] != 1) {
                        echo "<span class='ml-4'>". convertWorkState($work['state'], true)."</span>";
                    }
                    //TODO: display icons of the work
                    ?>
                </div>
            </div>
            <div class="divWorkIconsRight">
                <?php
                //TODO: display icons of the work
                ?>
            </div>
        </div>
        <div class="divWorkContent">

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
    printAWork($work);
} ?>
    <hr class="hryellowproject nomargin">
<?php
displaydebug($project);
$contenttype = "full";
$content = ob_get_clean();
require "gabarit.php";
?>