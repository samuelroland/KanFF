<?php
/**
 *  Project: KanFF
 *  File: testCRUDmodel.php file for tesing CRUDmodel
 *  Author: Benoît Pierrehumbert
 *  Creation date: 15.05.2020
 */
$BENOIT = true;
require_once 'model/CRUDModel.php';
function displaydebug($var)
{
//do nothing
}

//Get all elements of one Table
function test_getAll()
{
    echo "getAll: ";
    $array = getAll("users");
    if (count($array) == 100) {
        echo "OK";
    } else {
        echo "BUG
";
    }
    echo "
    
    ";
}

//Get one element by his id
function test_getOne()
{
    echo "getOne: ";
    $array = getOne("users", 56);
    if ($array['username'] == "orli82") {
        echo "OK";
    } else {
        echo "BUG
";
        if (isset($array)) {
            echo "Array isn't null:";
        } else {
            echo "\$array=null";
        }
    }
    echo "
    
    ";
}

//Get some specific elements of one Table
function test_getAllByCriterion()
{
    echo "getAllByCriterion: ";
    $criterions = "email IS NULL";
    $params = null;
    $array = getByCondition("users", $params, $criterions, true);
    if (count($array) == 52) {
        echo "OK";
    } else {
        echo "BUG
";
        if (isset($array)) {
            echo "Array isn't null:";
        } else {
            echo "\$array=null";
        }
    }
    echo "
    
    ";
}

//Get only one specific element of one Table
function test_getOneByCriterion()
{
    echo "getOneByCriterion: ";
    $criterions = ' initials = "JRD" ';
    $params = null;
    $array = getByCondition("users", $params, $criterions, false);
    if ($array['phonenumber'] == 7565739989) {
        echo "OK";
    } else {
        echo "BUG
";
        if (isset($array)) {
            echo "Array isn't null:";
        } else {
            echo "\$array=null";
        }
    }
    echo "
    
    ";
}

//Create one element
function test_createOne()
{
    echo "crateOne: ";
    $name = "Test";
    $params = ['name' => $name];
    $test = createOne("competences", $params);
    $criterions = ' name = "Test" ';
    $params = null;
    $array = getByCondition("competences", $params, $criterions, false);

    if ($array['name'] == "Test") {
        echo "OK";
    } else {
        echo "
        BUG Create
        ";
        echo $array["name"];
        if (isset($array)) {
            echo "Array isn't null:";
        } else {
            echo "\$array=null";
        }
    }
    echo "

";
}

//Update one element
function test_updateOne()
{
    echo "updateOne: ";
    $criterions = ' name = "Test" ';
    $params = null;
    $element = getByCondition("competences", $params, $criterions, false);

    $name = "Updated-Test";
    $params = ['name' => $name];
    updateOne("competences", $element["id"], $params);

    $criterions = ' name = "' . $name . '" ';
    $params = null;
    $array = getByCondition("competences", $params, $criterions, false);

    if ($array['name'] == $name) {
        echo "OK";
    } else {
        echo "BUG
";
        if (isset($array)) {
            echo "Array isn't null:";
        } else {
            echo "\$array=null";
        }
    }
    echo "

";
}

//Detlete one element by his id
function test_deleteOne()
{
    echo "delteOne : ";
    $criterions = ' name = "Updated-Test" ';
    $params = null;
    $element = getByCondition("competences", $params, $criterions, false);

    $total = count(getAll("competences"));

    deleteOne("competences", $element["id"]);

    $test = getOne("competences", $element["id"]);

    if ((empty($test)) && ($total == count(getAll("competences")) + 1)) {

        echo "OK";
    } else {
        echo "BUG
        ";
        if (isset($test)) {
            echo "Array isn't null:";
        } else {
            echo "\$array=null";
        }
    }
    echo "

";
}

///cd C:\Users\benoit.pierrehumbert\Documents\GitHub\KanFF\app
///cls | php -f .\unitTests\testCRUDmodel.php
test_getAll();
test_getOne();
test_getAllByCriterion();
test_getOneByCriterion();
test_createOne();
test_updateOne();
test_deleteOne();
?>