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

echo "Unit tests for CRUDModel.php functions:\n\n";
//Get all elements of one Table
function test_getAll()
{
    $array = getAll("users");
    if (count($array) == 100) {
        echo "    OK     ";
    } else {
        echo "    BUG     ";
    }
    echo "getAll() - take all items of a table: then count items in the users array must be 100 
    ";
}

//Create 4 users to have known data to test
function createAllUser()
{
//first user

    $user1 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break, state_modifier_id, state_modification_date)
 VALUES ('Username', '666', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0, null , null );";
    $user2 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break, state_modifier_id, state_modification_date)
 VALUES ('Username2', '667', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0, null , null );";
    $user3 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break, state_modifier_id, state_modification_date)
 VALUES ('Username4', '668', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0, null , null );";
    $user4 = "INSERT INTO `users` 
(username, initials, firstname, lastname, password, chat_link, email, phonenumber, biography, inscription, status, state, on_break, state_modifier_id, state_modification_date)
 VALUES ('Username3', '669', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0, null , null );";
    $idUser1 = Query($user1, null, false);
    Query($user2, null, false);
    Query($user3, null, false);
    Query($user4, null, false);
    return $idUser1;
}

//Get one element by his id
function test_getOne($idUser1)
{
//    'Username', '666', 'Rrenom','Rom', '$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta', null , null, 16666654,NULL, '2020-09-17 06:12:47', null, 3, 0);";
    $userCreatedBefore = [
        "id" => $idUser1,
        "username" => "Username",
        "initials" => "666",
        "firstname" => "Rrenom",
        "lastname" => "Rom",
        "password" => "$2y$10\$oVjU8nF3fDyx0LfLyoj.h.SIekzNWTJ3whFw/yDFfTkpPBGnQD0Ta",
        "chat_link" => null,
        "email" => null,
        "phonenumber" => "16666654",
        "biography" => null,
        "inscription" => "2020-09-17 06:12:47",
        "status" => null,
        "state" => 3,
        "on_break" => 0,
        "state_modifier_id" => null,
        "state_modification_date" => null
    ];
    $array = getOne("users", $idUser1);
    if ($array['initials'] == "666" && empty(array_diff($array, $userCreatedBefore)) == true) {
        echo "OK     ";
    } else {
        echo "BUG    ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "getOne() - by id: get one item from users with his id, then check that Initials = '666' 
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
    echo "getOne() - by inexistant id (should return null): get one user with a wrong id, ids goes from 1 to 100, test with id=600 
    ";
}

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

    if (count($array) == 4) {
        echo "OK    ";
    } else {
        echo "BUG    ";

        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo " getByCondition() - Severals elements expected: get all items where phonenumber begins with 166666 AND firstname OR lastname begins with R
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
    echo "getByCondition() - One element expected: get one item whith the \"666\" initials 
    ";
    return $array["id"];
}

//Create one element
function test_createOneCompetences()
{
    $countbefore = count(getAll("competences"));
    $tryId = 1000000000;
    $name = "Lire très vite";
    $category = "Littérature";
    $params = ['id' => $tryId, 'name' => $name, "category" => $category];
    $id = createOne("competences", $params);

    $array = getOne("competences", $id);

    $countafter = count(getAll("competences"));

    if ($array['category'] == $category && $array['name'] == $name && $countbefore + 1 == $countafter && $id != $tryId) {
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
    echo "createOne() - create one competence (2 fields): create one competence (values: $tryId, $name and $category), then check: id has been unset, read the item fields and countbefore + 1 = countafter 
    ";
    return $id;
}

//Update one element
function test_updateOne($id)
{
    $name = "Updated-Test";
    $params = ['name' => $name];
    updateOne("competences", $id, $params);
    $array = getOne("competences", $id);

    if ($array['name'] == $name && $array['category'] == "Littérature") {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "updateOne() - update the name only: update one item with a new name: \"Updated-Test\"
    ";

    $newId = 1000000;
    $params = ['id' => $newId];
    updateOne("competences", $id, $params);
    $array = Query("Select * from competences where name='$name'", [], false);
    if ($array['id'] == $id) {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($array)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "updateOne() - try to update an id (fail expected): update the id of the competence to $newId. the id must not be updated.
    ";
}

//Detlete one element by his id
function test_deleteOne($id)
{
    $countbefore = count(getAll("competences"));

    deleteOne("competences", $id);

    $test = getOne("competences", $id);

    if ($countbefore == count(getAll("competences")) + 1 && getOne("competences", $id) == null) {
        echo "OK     ";
    } else {
        echo "BUG     ";
        if (isset($test)) {
            echo "A!=0    ";
        } else {
            echo "A=0    ";
        }
    }
    echo "deleteOne() - delete one competence, then check if there is one element less than before deletion and that getOne with id return empty
    ";
}

//Delete all created users in this file for testing function
function deleteAllCreatedUser()
{
    $user1 = getByCondition("users", null, ' initials = "666" ', false);
    $user2 = getByCondition("users", null, ' initials = "667" ', false);
    $user3 = getByCondition("users", null, ' initials = "668" ', false);
    $user4 = getByCondition("users", null, ' initials = "669" ', false);

    deleteOne("users", $user1["id"]);
    deleteOne("users", $user2["id"]);
    deleteOne("users", $user3["id"]);
    deleteOne("users", $user4["id"]);
}

//Launch all tests
function StartTests()
{
    $_SESSION["debugUnitTests"] = "BugRelou";
    test_getAll();
    $idUser1 = createAllUser();
    test_getOne($idUser1);
    test_getOneByCondition();
    test_getAllByCondition();
    $id = test_createOneCompetences();
    test_updateOne($id);
    test_deleteOne($id);
    deleteAllCreatedUser();
}

//CMD INFO: go in the app folder in a shell, then type "php -f .\unitTests\testCRUDmodel.php"
StartTests();
?>