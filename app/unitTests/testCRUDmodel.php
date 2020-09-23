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
function createAllUser()
{
//first user
    $criterions = ' initials = "666" ';
    $user1 = getByCondition("users", null, $criterions, false);
    if ($user1 != 0) {
        deleteOne("users", $user1["id"]);
    }
    $user1 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state)
 VALUES ('Username', '666', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3);";
    $user2 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state)
 VALUES ('Username2', '667', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3);";
    $user3 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state)
 VALUES ('Username4', '668', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3);";
    $user4 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state)
 VALUES ('Username3', '669', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3);";
    Query($user1, null, false);
    Query($user2, null, false);
    Query($user3, null, false);
    Query($user4, null, false);
}

//Get one element by his id
function test_getOne()
{

    echo "getOne
     get one items from users with his id, Initials = '666' : ";

    $array = getOne("users", 1);
    if ($array['initials'] == "JRD") {
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
}//ok

//Get some specific elements of one Table
function test_getAllByCondition()
{
    echo "getAllByCriterion
     get all items where phonenumber begins with 1 AND firstname OR lastname begins with R : ";
    $criterions = '	phonenumber LIKE	"166666%"
	AND firstname LIKE "R%" 
	OR
	phonenumber LIKE	"166666%"
	AND lastname LIKE "R%"';
    $params = null;
    $array = getByCondition("users", $params, $criterions, true);

    if (count($array)==4) {
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

function deleteAllCreatedUser(){
    $user1 = getByCondition("users", null, ' initials = "666" ', false);
    $user2 = getByCondition("users", null, ' initials = "667" ', false);
    $user3 = getByCondition("users", null, ' initials = "668" ', false);
    $user4 = getByCondition("users", null, ' initials = "669" ', false);

    deleteOne("users",$user1["id"]);
    deleteOne("users",$user2["id"]);
    deleteOne("users",$user3["id"]);
    deleteOne("users",$user4["id"]);
}

///cd C:\Users\benoit.pierrehumbert\Documents\GitHub\KanFF\app |cls | php -f .\unitTests\testCRUDmodel.php
createAllUser();
test_getAll();
test_getOne();
test_getOneByCondition();
test_getAllByCondition();
test_createOneCompetences();
test_updateOne();
test_deleteOne();
deleteAllCreatedUser();
/*



test_getAllByCondition();

test_createOneCompetences();
test_updateOne();
test_deleteOne();*/
?>