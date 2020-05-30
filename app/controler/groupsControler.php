<?php
/**
 *  Project: KanFF
 *  File: groupsControler.php function controler for the groups
 *  Author: Samuel Roland
 *  Creation date: 30.05.2020
 */

//display the page groups
function groups(){
    //getAllGroups();
    require_once "view/groups.php";
}

//display the page groups or create the groupe (depends on the data sent)
function createAGroup()
{
    require_once "view/createAGroup.php";
}

?>