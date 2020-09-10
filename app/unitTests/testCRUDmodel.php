<?php
/**
 *  Project: KanFF
 *  File: testCRUDmodel.php file for tesing CRUDmodel
 *  Author: Benoît Pierrehumbert
 *  Creation date: 15.05.2020
 */

$debug = false;
require_once 'model/CRUDModel.php';
function displaydebug($var)
{
//do nothing
}

//Get all elements of one Table
function test_getAll()
{
    echo "    getAll 
     get all users (100) : ";
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
    echo "getOne
     get one items from users with his id users[56] => id=56, username=orli82 : ";
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
    echo "getOneEmpty
     get one users with a wrong id, ids goes from 0 to 100, test with 600 : ";
    $array = getOne("users", 600);
    if (empty($array)) {
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
    echo "getAllByCriterion
     get all items where phonenumber begins with 1 AND firstname OR lastname begins with R : ";
    $criterions = '	phonenumber LIKE	"1%"
	AND firstname LIKE "R%" 
	OR
	phonenumber LIKE	"1%"
	AND lastname LIKE "R%"';
    $params = null;
    $array = getByCondition("users", $params, $criterions, true);
    $return1=getOne("users",18);
    $return2=getOne("users",26);
    $return3=getOne("users",75);
    $return4=getOne("users",98);

    if (($return1==$array[0])&&($return2==$array[1])&&($return3==$array[2])&&($return4==$array[3])) {
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
    echo "getOneByCriterion 
     get one item whith the \"JRD\" initials : ";
    $criterions = ' initials = "JRD" ';
    $params = null;
    $array = getByCondition("users", $params, $criterions, false);
    $arrayToCompare= getOne("users", 1);
    if ($array==$arrayToCompare) {
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

    echo "crateOne 
     create one competences whith name=>\"Test\" : ";
    $name = "Test";
    $params = ['name' => $name];
    createOne("competences", $params);
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
    echo "    updateOne 
     update one items where name =\"Test\", replace name by \"Updated-Test\"";
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
    echo "    updateOneID 
     trying to update an id with the \$debug = \"false\",the id should not be updated";
    $criterions = ' name = "Updated-Test" ';
    $params = null;
    $element = getByCondition("competences", $params, $criterions, false);

    $name = 1000000;
    $params = ['id' => $name];
    updateOne("competences", $element["id"], $params);


    if ($array['id'] == $element["id"]) {
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
    echo "    delteOne 
     delete one item whith name = \"Updated-Test\", if item is deleted, the test return OK : ";
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

///cd C:\Users\benoit.pierrehumbert\Documents\GitHub\KanFF\app |cls | php -f .\unitTests\testCRUDmodel.php
test_getAll();
test_getOne();
test_getAllByCriterion();
test_getOneByCriterion();
test_createOne();
test_updateOne();
test_deleteOne();
?>