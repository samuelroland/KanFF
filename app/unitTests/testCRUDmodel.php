<?php
/**
 *  Project: KanFF
 *  File: testCRUDmodel.php file for tesing CRUDmodel
 *  Author: Benoît Pierrehumbert
 *  Creation date: 15.05.2020
 */


require_once 'model/CRUDModel.php';
require_once 'controler/help.php';
require_once 'view/helpers.php';


//Get all elements of one Table
function test_getAll()
{
    $array = getAll("users");
    if (count($array) == 100) {
        echo "    OK     ";
    } else {
        echo "    BUG     ";
    }
    echo "getAll: get all users (100) 
    ";
}

//Create all users i need below
function createAllUser()
{
//first user

    $user1 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break)
 VALUES ('Username', '666', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0);";
    $user2 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break)
 VALUES ('Username2', '667', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0);";
    $user3 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break)
 VALUES ('Username4', '668', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0);";
    $user4 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break)
 VALUES ('Username3', '669', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0);";
    $idUser1 = Query($user1, null, false);
    Query($user2, null, false);
    Query($user3, null, false);
    Query($user4, null, false);
    return $idUser1;
}

//Get one element by his id
function test_getOne($idUser1)
{
    $array = getOne("users", $idUser1);
    if ($array['initials'] == "666") {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo " getOne: get one items from users with his id, Initials = '666' 
    ";

    $array = getOne("users", 600);
    if (empty($array)) {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "getOneEmpty: get one users with a wrong id, ids goes from 0 to 100, test with 600 
    ";
}//OK     

//Get some specific elements of one Table
function test_getAllByCondition()
{

    $criterions = '	phonenumber LIKE	"166666%"
	AND firstname LIKE "R%" 
	OR
	phonenumber LIKE	"166666%"
	AND lastname LIKE "R%"';
    $params = null;
    $array = getByCondition("users", $params, $criterions, true);

    if (count($array)==4) {
        echo "OK    ";
    } else {
        echo "BUG    ";

        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo " getAllByCriterion: get all items where phonenumber begins with 1 AND firstname OR lastname begins with R 
    ";
}

//Get only one specific element of one Table
function test_getOneByCondition()
{
    $criterions = ' initials = "666" ';
    $params = null;
    $array = getByCondition("users", $params, $criterions, false);
    $arrayToCompare = getOne("users", $array["id"]);
    if ($array == $arrayToCompare) {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "getOneByCriterion: get one item whith the \"666\" initials 
    ";
    return $array["id"];
}

//Create one element
function test_createOneCompetences()
{

    $name = "Test";
    $params = ['name' => $name];
    createOne("competences", $params);
    $criterions = ' name = "Test" ';
    $params = null;
    $array = getByCondition("competences", $params, $criterions, false);

    if ($array['name'] == "Test") {
        echo "OK     ";
    } else {
        echo "BUG     ";
        echo $array["name"];
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "crateOne: create one competences whith name=>\"Test\" 
    ";

}

//Update one element
function test_updateOne()
{

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
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "updateOne: update one items where name =\"Test\", replace name by \"Updated-Test\"
    ";
    $criterions = ' name = "Updated-Test" ';
    $params = null;
    $element = getByCondition("competences", $params, $criterions, false);

    $name = 1000000;
    $params = ['id' => $name];
    updateOne("competences", $element["id"], $params);


    if ($array['id'] == $element["id"]) {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "updateOneID: trying to update an id with the \$debug = \"false\",the id should not be updated
    ";

}

//Detlete one element by his id
function test_deleteOne()
{
    $criterions = ' name = "Updated-Test" ';
    $params = null;
    $element = getByCondition("competences", $params, $criterions, false);

    $total = count(getAll("competences"));

    deleteOne("competences", $element["id"]);

    $test = getOne("competences", $element["id"]);

    if ((empty($test)) && ($total == count(getAll("competences")) + 1)) {

        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($test)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "delteOne: delete one item whith name = \"Updated-Test\", if item is deleted, the test return OK      
    ";

}

//Delete all created users in this file for testing function
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

//Lunch all tests
function StartTests(){
    $_SESSION["debugUnitTests"]="BugRelou";
    test_getAll();
    $idUser1 = createAllUser();
    test_getOne($idUser1);
    test_getOneByCondition();
    test_getAllByCondition();
    test_createOneCompetences();
    test_updateOne();
    test_deleteOne();
    deleteAllCreatedUser();
}
//cd C:\Users\benoit.pierrehumbert\Documents\GitHub\KanFF\app |cls | php -f .\unitTests\testCRUDmodel.php
StartTests();
?>