<?php
/**
 *  Project: KanFF
 *  File: help.php controler for generating common contents
 *  Author: Samuel Roland
 *  Creation date: 26.04.2020
 */

function checkUserPassword($id, $password)
{
    require_once "controler/loginControler.php";
    $user = getUserById($id);
    return password_verify($password, $user['password']);
}

//Check length of a string that must not be greater than the max given but less or equal
function chkLength($string, $max)
{
    return (strlen($string) <= $max);
}

//Convert the value "on" or null sent with a checkbox in a form, to a tinyint value
function chkToTinyint($value)
{
    return (is_null($value)) ? "0" : "1";
}

//Declare the flashmessage with his number
function flshmsg($number)
{
    $_SESSION['flashmsg'] = $number;
}

//Convert a timestamp in the DATETIME format
function timeToDT($timestamp)
{
    return date("Y-m-d H:i:s", $timestamp);
}

function DTToHumanDate($datetime, $mode)
{
    switch ($mode) {
        case "simpleday":
            return date("d.m.Y", strtotime($datetime));
            break;
        case "simpletime":
            return date("d.M.Y à H:i", strtotime($datetime));
            break;
        case "completeday":
            return date("j F Y", strtotime($datetime));
            break;
        case "completetime":
            return date("j F Y à H:i:S", strtotime($datetime));
            break;
        default:
            return "ERROR!";
            break;
    }
}

//Convert special chars from values of an array of array, to html entities:
function specialCharsConvertFromAnArray($items, $fields)
{
    //INFO: $fields is the list of the field to convert
    foreach ($items as $index => $item) {
        //For each item scan each value
        foreach ($item as $key => $value) {
            //If the key is in the fields list
            if (in_array($key, $fields)) {
                //Convert it to an html entity
                $item[$key] = htmlentities($value, ENT_QUOTES);
            }
        }
        $items[$index] = $item;
    }
    return $items;
}

?>