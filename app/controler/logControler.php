<?php
/**
 *  Project: KanFF
 *  File: logControler.php controler functions for the log
 *  Author: Samuel Roland
 *  Creation date: 05.10.2020
 */

require_once "model/logModel.php";

// Display the page create a project or create the project (depends on the data sent)
function createALog($newLog)
{
    //TODO make validations
    createLog($newLog);
}

function updateALog($editLog)
{
    //TODO make validations
    updateLog($editLog, $id);
}

?>