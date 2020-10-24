<?php
/**
 *  Project: KanFF
 *  File: worksControler.php controler functions for the works
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

require_once "model/worksModel.php";

//display the page groups
function works()
{

}

function createAWork($work)
{

}

//Return true or false, if the user has writing right on tasks of a work depending on the settings of the work
function hasWritingRightOnTasksOfAWork($isInTheProject, $work)
{
    $open = $work['open'];
    $visible = $work['visible'];

    if ($isInTheProject) {
        return true;
    }
    if ($visible == 1) {
        if ($open == 1) {
            return true;
        }
    }
    return false;
}

?>