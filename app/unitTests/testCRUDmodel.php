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
    if (count($array) == 101) {
        echo "OK";
    } else {
        echo "BUG
";
    }
    echo "
    
    ";
}

//Create all users i need below
function createAllUser1()
{
//first user
    $criterions = ' initials = "666" ';
    $user1 = getByCondition("users", null, $criterions, false);
    if ($user1 != 0) {
        deleteOne("users", $user1["id"]);
    }
    $user1 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state)
 VALUES ('Username', '666', 'Prenom','Nom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 101626654,NULL, '2020-09-17 06:12:47', null, 3);";
    $res = Query($user1, null, false);
    return $res;
}

//Get one element by his id
function test_getOne($id)
{

    echo "getOne
     get one items from users with his id users[LastInstertedID] => id=LastInsertId, Initials = '666' : ";

    $array = getOne("users", $id);
    if ($array['initials'] == "666") {
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
function test_getAllByCondition()
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
    $return1 = getOne("users", 18);
    $return2 = getOne("users", 26);
    $return3 = getOne("users", 75);
    $return4 = getOne("users", 98);

    if (($return1 == $array[0]) && ($return2 == $array[1]) && ($return3 == $array[2]) && ($return4 == $array[3])) {
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
function test_getOneByCondition()
{
    echo "getOneByCriterion 
     get one item whith the \"666\" initials : ";
    $criterions = ' initials = "666" ';
    $params = null;
    $array = getByCondition("users", $params, $criterions, false);
    $arrayToCompare = getOne("users", $array["id"]);
    if ($array == $arrayToCompare) {
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
    return $array["id"];
}

//Create one element
function test_createOneCompetences()
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
$id=createAllUser1();
test_getAll();
test_getOne($id);
test_getOneByCondition();
/*



test_getAllByCondition();

test_createOneCompetences();
test_updateOne();
test_deleteOne();*/
?>