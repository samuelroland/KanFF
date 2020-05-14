<?php
/**
 *  Project: KanFF
 *  File: generationData.php file to generate data for fill the database with the tables of the MCD v1.1
 *  Author: Samuel Roland
 *  Creation date: 08.05.2020
 */

function getPDO()
{
    require "../app/.const.php";
    return new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
}

function insertItemsInDB($query, $items)
{
    foreach ($items as $val) // execute it many times for each item
    {
        try {
            $statement = getPDO()->prepare($query);//prepare query once
            $statement->execute($val);   //éxecuter la requête
        } catch (PDOException $e) { //en cas d'erreur dans le try
            echo "Error!: " . $e->getMessage() . "\n";
        }
    }
}

//Build the string of the query with parameters according to the data.
function queryInsertConstructor($items, $tablename)
{
    //Create the lists of the keys of an item of the list. Take the first item shouldn't create problem.
    foreach ($items[0] as $key => $fieldOfOneItem) {
        $listofkeys[] = $key;
    }
    $query = "INSERT INTO $tablename (" . implode(", ", $listofkeys) . ") VALUES (:" . implode(", :", $listofkeys) . ");";
    return $query;
}

function importTableData($table, $items)
{
    $query = queryInsertConstructor($items, $table);

    //Delete table records before insert
    $statement = getPDO()->prepare("delete from $table");
    $statement->execute();   //éxecuter la requête

    //Finally insert data!
    insertItemsInDB($query, $items);
    echo "Imported successfully! \n";
}

function getRandomDateFormated($start = 1546300800)
{
    //Generate a date between 01.01.2019 and today formated in DATETIME format.
    return date("Y-m-d H:i:s", rand($start, time()));
}

function dataUsers()
{
    //Get all users basic data generated with generatedata.com (firstname, lastname, bio)
    $usersressources = json_decode(file_get_contents("data-ressources/basic-data-users.json"), true);

    echo "\n-----------------------------\n Generating Users \n-----------------------------\n ";
    $id = 0;
    $users = [];    //array for the users generated

    $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ğ' => 'G', 'İ' => 'I', 'Ş' => 'S', 'ğ' => 'g', 'ı' => 'i', 'ş' => 's', 'ü' => 'u');

    //For each user generate the other data
    foreach ($usersressources as $ressource) {
        $id += 1;
        $userinrun = $ressource;
        //Truncate the biography field if longer than 500 chars
        if (strlen($userinrun['biography']) > 500) {
            $userinrun['biography'] = substr($userinrun['biography'], 0, 500);
        }
        //Take the names as normal
        $firstname = $userinrun['firstname'];
        $lastname = $userinrun['lastname'];

        //Generate username with firstname and a number after
        $username = $firstname . rand(10, 99);
        $username = strtr($username, $unwanted_array);
        $username = strtolower($username);

        //Generate initials
        $initials = substr($firstname, 0, 1) . substr($lastname, 0, 1) . substr($lastname, strlen($lastname) - 1);
        $initials = strtoupper($initials);
        //half the time, email is set to "firstname.lastname@assoc.com" and if not the email is null
        if (rand(0, 1)) {
            $email = $firstname . "." . $lastname . "@assoc.ch";    //create the email with the raw firstname and lastname
            $email = strtr($email, $unwanted_array);    //replace accent with corresponding char
            $email = strtolower($email);    //put the string to lower cases.
        } else {
            $email = null;
        }

        //Generate phonenumber of 10 number
        $phonenumber = rand(100, 999) . rand(100, 999) . rand(10, 99) . rand(10, 99);

        //Generate a password with the firstname hashed
        $password = password_hash($firstname, PASSWORD_DEFAULT);

        //Generate inscription date,
        $inscription = getRandomDateFormated();

        //Status is by default 0, so yyyyy
        $status = 0;

        //Save data not already present in $userinrun
        $userinrun['id'] = $id; //fix id in prevision of foreign keys later
        $userinrun['email'] = $email;
        $userinrun['initials'] = $initials;
        $userinrun['username'] = $username;
        $userinrun['inscription'] = $inscription;
        $userinrun['status'] = $status;
        $userinrun['phonenumber'] = $phonenumber;
        $userinrun['password'] = $password;

        //Save the userinrun in the lists:
        $users[] = $userinrun;
        echo "\n" . $userinrun['id'] . " " . $userinrun['firstname'] . " " . $userinrun['lastname'] . " " . $userinrun['initials'] . " " . $userinrun['username'] . " " . $userinrun['email'] . " " . $userinrun['inscription'] . " " . $userinrun['status'] . " " . $userinrun['phonenumber'] . " " . $userinrun['password'];
    }

    var_dump($users[2]);
    importTableData("users", $users);
}

function dataGroups()
{
    $groupsressources = json_decode(file_get_contents("data-ressources/basic-data-groups.json"), true);

    echo "\n-----------------------------\n Generating Groups \n-----------------------------\n ";
    $id = 0;
    $groups = [];    //array for the users generated

    //For each user generate the other data
    foreach ($groupsressources as $ressource) {
        $id += 1;
        $group = $ressource;

        //Half time, email is the last word of the name of the group with @assoc.ch
        if (rand(0, 1)) {
            $wordsOfName = explode(" ", $group['name']);
            $group['email'] = strtolower($wordsOfName[count($wordsOfName) - 1]) . "@assoc.ch";
        } else {
            //The other time it's null
            $group['email'] = null;
        }
        $group['image'] = uniqid("group_", true) . ".png";

        //Generating "visible" and "restrict_access". The groups are in most cases visible and not access restricted . just in 1/5 of cases the groups are considered sensitive so restric_access is 1 (true) and sometimes not visible.

        $group['visible'] = 1;  //visible by default

        //Generate parameters for sensitive groups in 1/5 of cases.
        if (rand(1, 5) == 1) {
            $group['restrict_access'] = 1;
            if (rand(0, 1)) {
                $group['visible'] = 0;
            }
        } else {
            $group['restrict_access'] = 0;
        }

        //Generate chat and drive link that seem like a real like
        $group['chat_link'] = "chat.link/join?v=" . generateRandomString(rand(10, 15));
        $group['drive_link'] = "drive.link/open?f=" . generateRandomString(rand(50, 70));

        //Foreign key of the user creator
        $group['creator_id'] = rand(1, 100);

        $group['creation_date'] = getRandomDateFormated();

        print_r("\n" . $group['name']);
        print_r("\n" . $group['email'] . "\n");
        $groups[] = $group;
    }

    importTableData("groups", $groups);
}

function data_user_join_group()
{
    $joins = [];
    $id = 0;
    //For the 100 users
    for ($i = 1; $i <= 100; $i++) {
        $join['user_id'] = $i;


        //Generate for the most majority of users but not for a minority of people that will not be in any groups.
        if (rand(1, 50) != 1) {

            //Generate the number of groups the user has joined.
            $nbOfGroups = rand(2, 10);
            $listOfGroupsJoinedByTheUser = [];

            //For the number of groups decided, generate the other data.
            for ($j = 1; $j <= $nbOfGroups; $j++) {
                $id++;
                $join['$id'] = $id;

                //Generate the groups joined randomly:
                $lastLeftDate = null;
                $groupid = rand(0, 11);
                if (in_array($groupid, $listOfGroupsJoinedByTheUser) == true) {
                    foreach ($joins as $onejoin) {
                        //Take the last join with user_id and groupid that are managed:
                        if ($onejoin['user_id'] == $i && $onejoin['group_id'] == $groupid) {
                            if ($onejoin['end'] != null) {
                                //If the user has joined and left the group, he has the right to join again.
                                $lastLeftDate = $onejoin['end'];
                            } else {
                                //If the user has joined and not left the group, he hasn't not the right to join again before he left the group. So the groupid need to be changed:

                                //Generate a new group id that is not in the table.
                                while (in_array($groupid, $listOfGroupsJoinedByTheUser) == true) {
                                    $groupid = rand(1, 11);
                                }
                            }
                        }
                    }
                }

                //Save groupid value
                $join['group_id'] = $groupid;

                //Add to the list of the groups joined by the user
                $listOfGroupsJoinedByTheUser[] = $groupid;

                //If the lastLeftDate is not null, the user has already joined and left, so the start must be after the end of the last join.
                if ($lastLeftDate != null) {
                    $join['start'] = getRandomDateFormated(strtotime($lastLeftDate));
                } else {
                    $join['start'] = getRandomDateFormated();
                }

                echo " \n";
                if (rand(0, 10) == 0) {
                    $join['end'] = getRandomDateFormated(strtotime($join['start']));
                } else {
                    $join['end'] = null;
                }

                //In most of cases the user is accepted.
                if (rand(0, 20) == 0) {
                    $join['accepted'] = 0;
                } else {
                    $join['accepted'] = 1;
                }
                echo $join['group_id'] . " \n";
                echo $join['start'] . " \n";
                echo $join['end'] . " \n";
                $joins[] = $join;
            }
        }
        die();
    }
    importTableData("user_join_group", $joins);
}

//Source: https://stackoverflow.com/questions/4356289/php-random-string-generator#answer-4356295
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

dataUsers();
dataGroups();
data_user_join_group();

?>