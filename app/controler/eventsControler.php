<?php
/**
 *  Project: KanFF
 *  File: eventsControler.php controler functions for the events
 *  Author: Samuel Roland
 *  Creation date: 22.07.2020
 */

//require_once "model/projectsModel.php";

//display the page groups
function calendar()
{
    /*
    $groups = getAllEvents();
    $fieldsToConvert = ["name", "description", "context", "status"];
    $groups = specialCharsConvertFromAnArray($groups, $fieldsToConvert);
    displaydebug($groups);
    */
    require_once "view/calendar.php";
}

//display the page create a group or create the group (depends on the data sent)
function createAnEvent($event)
{

}

?>