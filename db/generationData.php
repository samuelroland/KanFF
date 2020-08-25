<?php
/**
 *  Project: KanFF
 *  File: generationData.php file to generate data for fill the database with the tables of the MLD v1.1
 *  Author: Samuel Roland
 *  Creation date: 08.05.2020
 */

/// ----------------------------
///  Useful functions
/// ----------------------------
function getPDO()
{
    require "../app/.const.php";
    return new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
}

require_once "../app/view/helpers.php";
//Build the string of the SQL query with SQL parameters according to the data sent
function queryInsertConstructor($items, $tablename)
{
    require "../app/.const.php";
    //Create the lists of the keys of an item of the array. Take the first item shouldn't create problem. (items are not manually indexed)
    foreach ($items[0] as $key => $fieldOfOneItem) {
        $listofkeys[] = $key;
    }
    $query = "INSERT INTO `$tablename` (" . implode(", ", $listofkeys) . ") VALUES (:" . implode(", :", $listofkeys) . ");";
    return $query;
}

//Import data of an array in the database in a given table and delete the table records before
function importTableData($table, $items)
{
    $error = false; //no error by default

    //Build the query:
    $query = queryInsertConstructor($items, $table);

    //Delete table records before insert
    require "../app/.const.php";
    $statement = getPDO()->prepare("DELETE FROM `$table`");
    $statement->execute();   //éxecuter la requête

    //Finally insert data!
    $statement = getPDO()->prepare($query);//prepare query once instead of for each item.
    foreach ($items as $val) // for each item it will execute the sql query
    {
        try {
            $statement->execute($val);   //execute query with data for parameters
        } catch (PDOException $e) { //en cas d'erreur dans le try
            echo "Error!: " . $e->getMessage() . "\n";
            $error = true;
        }
    }

    //Display the end message after inserting the table in run. If it's successful or if errors have been occured.
    if ($error) {
        echo "Some errors have been occured with inserting...\n";
    } else {
        echo "Imported successfully! \n";
    }
}

//Generate a date between 01.01.2019 (as default, or the date given if parameter exists) and today formated in DATETIME format ("Y-m-d H:i:s")
function getRandomDateFormated($start = 1546300800)
{
    return date("Y-m-d H:i:s", rand($start, time()));
}

//Get all the items of a table with the table name
function getAllItems($tablename)
{
    try {
        $dbh = getPDO();
        $statement = $dbh->prepare("SELECT * FROM `$tablename`;");//prepare query
        $statement->execute();//execute query
        $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);//prepare result for client
        $dbh = null;
        $items = [];
        foreach ($queryResult as $item) {
            $items[$item['id']] = $item;
        }
        return $items;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

/// ----------------------------
///  Generate data functions
/// ----------------------------

//Generate data for users
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

        if (isset($ressource['email']) == false) {
            //half the time, email is set to "firstname.lastname@assoc.com" and if not the email is null
            if (rand(0, 1)) {
                $email = $firstname . "." . $lastname . "@assoc.ch";    //create the email with the raw firstname and lastname
                $email = strtr($email, $unwanted_array);    //replace accent with corresponding char
                $email = strtolower($email);    //put the string to lower cases.
            } else {
                $email = null;
            }
        } else {
            $email = $ressource['email'];
        }

        //Generate phonenumber of 10 number
        $phonenumber = rand(100, 999) . rand(100, 999) . rand(10, 99) . rand(10, 99);

        //Generate a password with the firstname hashed
        $password = password_hash($firstname, PASSWORD_DEFAULT);

        //Generate inscription date,
        $inscription = getRandomDateFormated();

        //Status is by default null but taken from ressource if exists.
        if (isset($ressource['status'])) {
            $status = $ressource['status'];
        } else {
            $status = null;
        }

        //Generate the state: the technical state of the account:
        $state = USER_STATE_APPROVED;   //default is approved
        if (rand(1, 15) == 1) {
            $state = USER_STATE_UNAPPROVED;
        } else if (rand(1, 8) == 1) {
            $state = USER_STATE_ONBREAK;
        } else if (rand(1, 20) == 1) {
            $state = USER_STATE_ARCHIVED;
        } else if (rand(1, 10) == 1) {
            $state = USER_STATE_ADMIN;
        }

        //Generate chat_link:
        $userinrun['chat_link'] = "";
        if (rand(0, 1) == 0) {
            $userinrun['chat_link'] = "chat.link/user?t=" . generateRandomString(rand(10, 15));
        }
        //Save data not already present in $userinrun
        $userinrun['id'] = $id; //fix id in prevision of foreign keys later
        $userinrun['email'] = $email;
        $userinrun['initials'] = $initials;
        $userinrun['username'] = $username;
        $userinrun['inscription'] = $inscription;
        $userinrun['status'] = $status;
        $userinrun['state'] = $state;
        $userinrun['phonenumber'] = $phonenumber;
        $userinrun['password'] = $password;

        //Save the userinrun in the lists:
        $users[] = $userinrun;
        echo "\n" . $userinrun['id'] . " " . $userinrun['firstname'] . " " . $userinrun['lastname'] . " " . $userinrun['initials'] . " " . $userinrun['username'] . " " . $userinrun['email'] . " " . $userinrun['inscription'] . " " . $userinrun['status'] . " " . $userinrun['phonenumber'] . " " . $userinrun['password'];
    }

    var_dump($users[2]);
    importTableData("users", $users);
}

//Generate data for groups
function dataGroups()
{
    $groupsressources = json_decode(file_get_contents("data-ressources/basic-data-groups.json"), true);

    echo "\n-----------------------------\n Generating Groups \n-----------------------------\n ";
    $id = 0;
    $groups = [];    //array for the users generated

    //For each user generate the other data
    foreach ($groupsressources as $ressource) {
        $id++;
        $group = $ressource;

        //Half time, email is the last word of the name of the group with @assoc.ch
        if (rand(0, 1)) {
            $wordsOfName = explode(" ", $group['name']);
            $group['email'] = strtolower($wordsOfName[count($wordsOfName) - 1]) . "@assoc.ch";
        } else {
            //The other time it's null
            $group['email'] = null;
        }

        //INFO: finally named by hand with format "group_blwt3uw94psz9n8xtmy1fym3exo8b2.jpg" (see doc for more details)
        //$group['image'] = group_". generateRandomString(30) . ".jpg";
        //If not set manually in the json file, set to null
        if (isset($group['image']) == false) {
            $group['image'] = null;
        }

        //Generating "visible" and "restrict_access". The groups are in most cases visible and not access restricted . just in 1/5 of cases the groups are considered sensitive so restric_access is 1 (true) and sometimes not visible.

        $group['visibility'] = 1;  //visible by default

        //Generate parameters for sensitive groups in 1/5 of cases.
        if (rand(1, 5) == 1) {
            $group['restrict_access'] = 1;
            if (rand(0, 1)) {
                $group['visibility'] = 0;
            }
        } else {
            $group['restrict_access'] = 0;
        }

        //Generate chat and drive link that seem like a real one
        $group['chat_link'] = "chat.link/join?v=" . generateRandomString(rand(10, 15));
        $group['drive_link'] = "drive.link/open?f=" . generateRandomString(rand(50, 70));

        //Foreign key of the user creator
        $group['creator_id'] = rand(1, 100);

        $group['creation_date'] = getRandomDateFormated();

        $group['id'] = $id; //set id

        //Generate state:
        $state = GROUP_STATE_ACTIVE;    //default state is active
        if (rand(1, 4) == 1) {
            $state = GROUP_STATE_ONBREAK;
        } else if (rand(1, 5) == 1) {
            $state = GROUP_STATE_ARCHIVED;
        } else if (rand(1, 5) == 1) {
            $state = GROUP_STATE_ONSTARTUP;
        }
        $group['state'] = $state;

        //Status is by default null but taken from ressource if exists.
        if (isset($ressource['status'])) {
            $status = $ressource['status'];
        } else {
            $status = null;
        }
        $group['status'] = $status;

        print_r("\n" . $group['name']);
        print_r("\n" . $group['image'] . "\n");
        $groups[] = $group;
    }
    var_dump($groups);
    importTableData("groups", $groups);
}

//Generate data for join
function data_join()
{
    //Take the group list
    $groups = getAllItems("groups");
    //Declare variables
    $joins = [];
    $id = 0;

    //Choose the groups joined for the 100 users (id 1 to 100)
    for ($i = 1; $i <= 100; $i++) {
        $join['user_id'] = $i;

        //Generate for the most majority of users but not for a minority of people that will not be in any groups.
        if (rand(1, 50) != 1) {

            //Generate the number of groups the user has joined.
            $nbOfGroups = rand(2, 10);
            $listOfGroupsJoinedByTheUser = [];  //set to an empty array for each user

            //For the number of groups decided, generate the other data.
            for ($j = 1; $j <= $nbOfGroups; $j++) {
                $id++;
                $join['id'] = $id;

                //Generate the groups joined randomly:
                $lastLeftDate = null;
                $groupid = rand(1, 11);
                if (in_array($groupid, $listOfGroupsJoinedByTheUser) == true) {
                    foreach ($joins as $onejoin) {
                        //Take the last join with user_id and groupid that are managed:
                        if ($onejoin['user_id'] == $i && $onejoin['group_id'] == $groupid) {
                            if ($onejoin['end'] != null) {
                                //If the user has joined and left the group, he has the right to join again.
                                $lastLeftDate = $onejoin['end'];
                            } else {
                                //If the user has joined and not left the group, he hasn't the right to join again. Generate a new group id that is not in the list.
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
                if (rand(0, 7) == 0) {
                    $join['end'] = getRandomDateFormated(strtotime($join['start']));
                } else {
                    $join['end'] = null;
                }

                //INFO: Accepted field depend on the field restrict_access of the groups. (see records-management.txt for explanations).

                //Generate accepted for access restricted group
                if ($groups[$groupid]['restrict_access'] == 1) {
                    $join['accepted'] = 4;  //accepted by default

                    //Others special states that not concerns the majority of cases
                    if (rand(0, 10) == 0) {
                        $join['accepted'] = 1;  //want to join the group but not yet accepted or not
                    } else if (rand(0, 10) == 0) {
                        $join['accepted'] = 2;  //not accepted/refused
                    } else if (rand(0, 20) == 0) {
                        $join['accepted'] = 3;  //banned of the group
                    }
                } else {    //With groups not restricted, the value 1 and 2 are not possible and the value 4 is by default
                    $join['accepted'] = 4;  //automatically accepted by default

                    //In rare case the user has been banned of the group
                    if (rand(0, 20) == 0) {
                        $join['accepted'] = 3;  //banned of the group
                    }
                }
                echo $join['group_id'] . " \n";
                echo $join['start'] . " \n";
                echo $join['end'] . " \n";
                $joins[] = $join;
            }
        }
    }
    var_dump($joins);
    importTableData("join", $joins);
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
//data_join();

?>