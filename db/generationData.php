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
require_once "../app/controler/help.php";

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
    var_dump($query);
    //Finally insert data!
    foreach ($items as $val) // for each item it will execute the sql query
    {
        Query($query, $val, false);
    }

}

//Copy of CRUDModel.php with little adaptations:
function Query($query, $params, $manyrecords)
{
    try {
        $dbh = getPDO();
        $statement = $dbh->prepare($query);//prepare query
        //If there are parameter, include them in the request:
        if (is_null($params) == false) {
            $statement->execute($params);//execute query
        } else {    //else don't include them
            $statement->execute();//execute query
        }
        //If it must have many records, use fetchAll()
        if ($manyrecords) {
            $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);//prepare result for client
        } else {    //if not, use fetch()
            $queryResult = $statement->fetch(PDO::FETCH_ASSOC);//prepare result for client

        }
        if (substr(strtoupper(trimIt($query)), 0, 11) == "INSERT INTO") {
            $queryResult = $dbh->lastInsertId();
        }
        if ($statement->errorInfo()[2] != null) {
            var_dump($statement->errorInfo()[2]);
        }

        $dbh = null;
        return $queryResult;
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>";
        var_dump($statement->errorInfo()[2]);
        return null;
    }
}

//Generate a date between 01.01.2019 (as default, or the date given if parameter exists) and today formatted in DATETIME format ("Y-m-d H:i:s")
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

        $items = indexAnArrayById($queryResult);
        return $items;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

function getLoremIpsum($length = 100)
{
    return substr(file_get_contents("https://loripsum.net/api/short/1/long/plaintext"), 0, $length - 2);
}

/// ----------------------------
///  Generate data functions
/// ----------------------------
///
define("UNWANTED_CHARS_ARRAY", array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'Ğ' => 'G', 'İ' => 'I', 'Ş' => 'S', 'ğ' => 'g', 'ı' => 'i', 'ş' => 's', 'ü' => 'u')
);

//Generate data for users
function dataUsers()
{
    //Get all users basic data generated with generatedata.com (firstname, lastname, bio)
    $usersressources = json_decode(file_get_contents("data-ressources/basic-data-users.json"), true);

    echo "\n-----------------------------\n Generating Users \n-----------------------------\n ";
    $id = 0;
    $users = [];    //array for the users generated
    $adminsIds[0] = 1;  //id of JRD that is an admin in all cases

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
        $username = strtr($username, UNWANTED_CHARS_ARRAY);
        $username = strtolower($username);
        if (isset($ressource['username'])) {
            $username = $ressource['username'];
        }

        //Generate initials
        $initials = substr($firstname, 0, 1) . substr($lastname, 0, 1) . substr($lastname, strlen($lastname) - 1);
        $initials = strtoupper($initials);

        if (isset($ressource['email']) == false) {
            //half the time, email is set to "firstname.lastname@assoc.com" and if not the email is null
            if (rand(0, 1)) {
                $email = $firstname . "." . $lastname . "@assoc.ch";    //create the email with the raw firstname and lastname
                $email = strtr($email, UNWANTED_CHARS_ARRAY);    //replace accent with corresponding char
                $email = strtolower($email);    //put the string to lower cases.
                $email = str_replace(" ", "", $email);    //remove spaces for big name with spaces
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
            $status = "Arrivé.e le " . DTToHumanDate(strtotime($inscription), "simpleday", true);;
            if (rand(1, 3) == 1) {
                $status = getLoremIpsum(200);
            }
            if (rand(1, 10) == 1) {
                $status = null;
            }
        }

        //Generate the state: the technical state of the account:
        $state = USER_STATE_APPROVED;   //default is approved
        if (rand(1, 15) == 1) {
            $state = USER_STATE_UNAPPROVED;
        } else if (rand(1, 70) == 1) {
            $state = USER_STATE_BANNED;
        } else if (rand(1, 20) == 1) {
            $state = USER_STATE_ARCHIVED;
        } else if (rand(1, 10) == 1) {
            $state = USER_STATE_ADMIN;
            $adminsIds[] = $id;
        }

        if (isset($ressource['state'])) {   //take value from pack if exists
            $state = $ressource['state'];
        }

        //Generate on_break:
        if (rand(1, 20) == 1) {
            $onbreak = 1;
        } else {
            $onbreak = 0;
        }

        //Generate state_modifier_id: take the id of a random admin
        if ($state != USER_STATE_UNAPPROVED) {  //only if the state has changed
            $statemodifierid = $adminsIds[rand(0, count($adminsIds) - 1)];
        } else {
            $statemodifierid = null;  //else value is just null
        }

        //Generate state_modification_date: take a random date after inscription to simulate change of state made by an admin
        if ($state != USER_STATE_UNAPPROVED) {  //only if the state has changed
            $statemodificationdate = getRandomDateFormated(strtotime($inscription));
        } else {
            $statemodificationdate = null;  //else value is just null
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
        $userinrun['on_break'] = $onbreak;
        $userinrun['phonenumber'] = $phonenumber;
        $userinrun['password'] = $password;
        $userinrun['password'] = $password;
        $userinrun['state_modifier_id'] = $statemodifierid;
        $userinrun['state_modification_date'] = $statemodificationdate;

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

        //Generate prerequisite:
        if (isset($group['prerequisite']) == false) {
            $group['prerequisite'] = getLoremIpsum(500);
            if (rand(1, 5) == 1) {
                $group['prerequisite'] = null;
            }
        }

        //Half time, email is the last word of the name of the group with @assoc.ch
        if (rand(0, 1)) {
            $wordsOfName = explode(" ", $group['name']);
            $startEmail = strtr($wordsOfName[count($wordsOfName) - 1], UNWANTED_CHARS_ARRAY);    //replace accent with corresponding char
            $group['email'] = strtolower($startEmail) . "@assoc.ch";    //concat start email with domain name
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

        if (!isset($group['restrict_access'])) { //if not defined in basic-data-groups.json,
            $group['restrict_access'] = 0;   //choose the default option
        }
        if (!isset($group['visibility'])) { //if not defined in basic-data-groups.json,
            $group['visibility'] = 3;   //choose the default option
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
                $groupid = rand(1, count($groups));
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
                                    $groupid = rand(1, count($groups));
                                }
                            }
                        }
                    }
                }

                //Save groupid value
                $join['group_id'] = $groupid;

                //Add to the list of the groups joined by the user
                $listOfGroupsJoinedByTheUser[] = $groupid;


                //INFO: state field depend on the field restrict_access of the groups. (see records-management.txt for explanations).

                //Generate state for access restricted group
                if ($groups[$groupid]['restrict_access'] == 1) {
                    $join['state'] = JOIN_STATE_APPROVED;  //accepted by default

                    //Others special states that not concerns the majority of cases
                    if (rand(0, 10) == 0) {
                        $join['state'] = JOIN_STATE_UNAPPROVED;
                    } else if (rand(0, 10) == 0) {
                        $join['state'] = JOIN_STATE_REFUSED;
                    } else if (rand(0, 30) == 0) {
                        $join['state'] = JOIN_STATE_BANNED;
                    } else if (rand(0, 15) == 0) {
                        $join['state'] = JOIN_STATE_INVITATION;
                    } else if (rand(0, 15) == 0) {
                        $join['state'] = JOIN_STATE_INVITATION_ACCEPTED;
                    } else if (rand(0, 25) == 0) {
                        $join['state'] = JOIN_STATE_INVITATION_REFUSED;
                    } else if (rand(0, 15) == 0) {
                        $join['state'] = JOIN_STATE_LEFT;
                    }
                } else {    //With groups not restricted, the value 1 and 2 are not possible and the value 4 is by default
                    $join['state'] = JOIN_STATE_APPROVED;  //accepted by default

                    //Others special states that not concerns the majority of cases
                    if (rand(0, 35) == 0) {
                        $join['state'] = JOIN_STATE_BANNED;
                    } else if (rand(0, 20) == 0) {
                        $join['state'] = JOIN_STATE_INVITATION;
                    } else if (rand(0, 10) == 0) {
                        $join['state'] = JOIN_STATE_INVITATION_ACCEPTED;
                    } else if (rand(0, 25) == 0) {
                        $join['state'] = JOIN_STATE_INVITATION_REFUSED;
                    } else if (rand(0, 15) == 0) {
                        $join['state'] = JOIN_STATE_LEFT;
                    }
                }

                //If the lastLeftDate is not null, the user has already joined and left, so the start must be after the end of the last join.
                if ($lastLeftDate != null) {
                    $join['start'] = getRandomDateFormated(strtotime($lastLeftDate));
                } else {
                    $join['start'] = getRandomDateFormated();
                }

                $join['end'] = null;    //null by default
                if ($join['state'] != JOIN_STATE_INVITATION_ACCEPTED && $join['state'] != JOIN_STATE_APPROVED) {    //if the user is not in the group
                    $join['end'] = getRandomDateFormated(strtotime($join['start']));
                }

                //Generate admin:
                $join['admin'] = 0; //not admin by default
                if ($groups[$join['group_id']]['creator_id'] == $i) {  //if the user is the creator of the group, the user is admin
                    $join['admin'] = 1;
                } else if (rand(0, 30) == 0) { //randomly users are admins
                    $join['admin'] = 1;
                }

                echo $join['group_id'] . " \n";
                echo $join['start'] . " \n";
                echo $join['end'] . " \n";
                $joins[] = $join;
            }
        }
    }
    importTableData("join", $joins);
}

function dataProjects()
{
    $projectsress = json_decode(file_get_contents("data-ressources/basic-data-projects.json"), true);

    echo "\n-----------------------------\n Generating Projects \n-----------------------------\n ";
    $id = 0;
    $projects = [];    //array for the users generated
    var_dump($projectsress);
    //For each project generate the other data
    foreach ($projectsress as $ressource) {
        $id++;
        $project = $ressource;

        //Generating start and end (end must be after start):
        $project['start'] = getRandomDateFormated(strtotime("2018-08-01")); //random date after 2018-08-01
        $project['end'] = getRandomDateFormated(strtotime($project['start']));  //random date after start

        //Generate state:
        $state = PROJECT_STATE_ACTIVEWORK;    //default state is active work
        if (rand(1, 15) == 1) {
            $state = PROJECT_STATE_UNDERREFLECTION;
        } else if (rand(1, 6) == 1) {
            $state = PROJECT_STATE_DONE;
        } else if (rand(1, 5) == 1) {
            $state = PROJECT_STATE_SEMIACTIVEWORK;
        } else if (rand(1, 6) == 1) {
            $state = PROJECT_STATE_ONBREAK;
        } else if (rand(1, 7) == 1) {
            $state = PROJECT_STATE_REPORTED;
        } else if (rand(1, 8) == 1) {
            $state = PROJECT_STATE_ABANDONNED;
        } else if (rand(1, 9) == 1) {
            $state = PROJECT_STATE_CANCELLED;
        } else if (rand(1, 10) == 1) {
            $state = PROJECT_STATE_UNDERPLANNING;
        }
        $project['state'] = $state;

        //Generate logbook_content:
        $project['logbook_content'] = "Contient les décisions importantes, rencontres formelles, changements importants et publications de nouvelles version de document.
Important, signifie que ce qui est décrit dans l'enregistrement, a un impact sur le travail de plusieurs personnes du projet."; //default value
        if (rand(1, 2) == 1) {
            if (rand(1, 2) == 1) {
                $project['logbook_content'] = getLoremIpsum(500);
            } else {
                $project['logbook_content'] = null;
            }
        }

        //Generate archived:
        $project['archived'] = 0;
        if ($state == PROJECT_STATE_CANCELLED || $state == PROJECT_STATE_ABANDONNED || $state == PROJECT_STATE_DONE) {
            if (rand(1, 2)) {   //project can be finished but not yet archived
                $project['archived'] = 1;
            }
        }

        //Generate repsonsible_id
        $project['responsible_id'] = null;
        if (rand(1, 3) == 1) {
            $project['responsible_id'] = rand(1, 100);
        }

        $project['id'] = $id;
        $projects[] = $project;
    }
    print_r($project);
    importTableData("projects", $projects);
    printAllChoosenFields($projects, "manager_id");
}

function dataParticipate()
{
    $projects = getAllItems("projects");
    $groups = getAllItems("groups");
    $participateres = json_decode(file_get_contents("data-ressources/basic-data-participate.json"), true);

    echo "\n-----------------------------\n Generating Participate \n-----------------------------\n ";
    $id = 0;
    $participates = [];    //array for the users generated
    //For each participate generate the other data
    foreach ($participateres as $ressource) {
        $id++;
        $participate = $ressource;

        //Generate state:
        if ($participate['group_id'] == $projects[$participate['project_id']]['manager_id']) {   //if the group is the creator (in our basic data it's the manager too).
            $participate['state'] = PARTICIPATE_STATE_CREATOR;    //it's the creator group
        } else {
            if (!isset($participate['state'])) {
                $participate['state'] = PARTICIPATE_STATE_INVITATION_ACCEPTED;  //if not defined in basic data and not the creator, so default state is invitation accepted
            } else {
                //if already defined in basic data, do nothing
            }
        }

        //Generating start and end (end must be after start):
        if ($participate['state'] == PARTICIPATE_STATE_CREATOR) {
            $participate['start'] = $projects[$participate['project_id']]['start']; //same date as the project start
            $participate['end'] = null; //in this data pack we say that the creator can not leave the group
        } else {
            $participate['start'] = getRandomDateFormated(strtotime($projects[$participate['project_id']]['start'])); //date after the project start
            if ($participate['state'] != PARTICIPATE_STATE_INVITATION_ACCEPTED) {
                $participate['end'] = getRandomDateFormated(strtotime($participate['start']));  //random date after start because the group is not here overthere
            } else {
                $participate['end'] = null; //null because invitation accepted means that the group is currently participating
            }
        }


        $participate['id'] = $id;
        $participates[] = $participate;
    }

    importTableData("participate", $participates);
}

function dataLog()
{
    $projects = getAllItems("projects");
    $logsres = json_decode(file_get_contents("data-ressources/basic-data-log.json"), true);

    echo "\n-----------------------------\n Generating Log \n-----------------------------\n ";
    $id = 0;
    $logs = [];    //array for the users generated
    //For each log generate the other data
    foreach ($logsres as $ressource) {
        $id++;
        $log = $ressource;

        //Convert date in datetime format:
        $log['date'] = timeToDT(strtotime($log['date']));

        //Generate creation_date:
        $log['creation_date'] = timeToDT(strtotime($log['date']) + rand(0, 260000));  //set the date of when it happened + a random time between 0 and 3 days (approximately).

        //Generate modification_date:
        if (rand(1, 4) == 1) {  //if the log has been modified
            $log['modification_date'] = timeToDT(strtotime($log['creation_date']) + rand(0, 350000));   //set the date of when the log was created + a random time between 0 and 4 days (approximately).
        } else {
            $log['modification_date'] = null;
        }

        //Generate visible:
        $log['visible'] = 1;
        if (rand(1, 7) == 1) {
            $log['visible'] = 0;
        }

        //Generate user_id:
        $log['user_id'] = rand(1, 100);

        $log['id'] = $id;
        $logs[] = $log;
    }
    print_r($logs);
    importTableData("log", $logs);
}

function dataWorks()
{
    $projects = getAllItems("projects");
    $worksres = json_decode(file_get_contents("data-ressources/basic-data-works.json"), true);

    echo "\n-----------------------------\n Generating Works \n-----------------------------\n ";
    $id = 0;
    $works = [];    //array for the users generated
    //For each work generate the other data
    foreach ($worksres as $ressource) {
        $id++;
        $work = $ressource;

        //Convert date in datetime format:
        $work['start'] = timeToDT(strtotime($work['start']));
        $work['end'] = timeToDT(strtotime($work['end']));

        //Generate visible if is not already defined
        if (!isset($work['visible'])) {
            $work['visible'] = 1;
        }

        //Generate open if is not already defined
        if (!isset($work['open'])) {
            $work['open'] = 0;
        }

        //Generate inbox if is not already defined
        if (!isset($work['inbox'])) {
            $work['inbox'] = 0;
        }

        //Generate repetitive if is not already defined
        if (!isset($work['repetitive'])) {
            $work['repetitive'] = 0;
        }

        //Generate need_help if is not already defined
        if (!isset($work['need_help'])) {
            $work['need_help'] = 0;
        }

        //Generate creation_date:
        $work['creation_date'] = timeToDT(strtotime($projects[$work['project_id']]['start']) + rand(0, 1000000) - rand(0, 1000000));  //set the date of when it happened +- a random time between -11 and 11 days (approximately).

        //Generate responsible_id:
        $work['responsible_id'] = null;
        if (rand(1, 3) == 1) {
            $work['responsible_id'] = rand(1, 100);
        }

        //Generate creator_id:
        $work['creator_id'] = rand(1, 100);

        $work['id'] = $id;
        $works[] = $work;
    }

    //Generate one inbox work for each project
    $inboxWorks = [];  //empty array for inbox works
    foreach ($projects as $oneproject) {
        $id++;
        //Define directly all fields with configuration for an inbox work:
        $inboxWork = [
            "id" => $id,
            "name" => "Boîte de réception",
            "description" => "(Créé automatiquement à la création du projet). Ce travail fait office de boîte de réception pour les tâches envoyés n'ayant pas de travail lié. Plus d'infos dans le mode d'emploi.",
            "start" => $oneproject['start'],
            "end" => $oneproject['end'],
            "state" => 2,   //always in run
            "value" => 5,
            "effort" => 5,
            "visible" => 1,
            "open" => 1,    //open by default
            "inbox" => 1,   //obviously set as inbox
            "repetitive" => 0,
            "need_help" => 0,
            "creation_date" => $oneproject['start'],    //automatically created with the project
            "project_id" => $oneproject['id'],
            "creator_id" => rand(1, 100),
            "responsible_id" => ((rand(1, 3) == 1) ? rand(1, 100) : null)
        ];
        $inboxWorks[] = $inboxWork;
    }

    importTableData("works", array_merge($works, $inboxWorks)); //import the 2 arrays in the database
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

//Display the choosen field in each array that is in an array of associative array:
function printAllChoosenFields($array, $fieldname)
{
    echo "\n---- printAllChoosenFields() -----\n Field: $fieldname\n";
    foreach ($array as $item) {
        echo "\n{$item[$fieldname]}";
    }
}

//EXECUTION - Here is the code and functions that will be started:
define("CREATE_DB_BEFORE_INSERTION", false);    //if can recreate the db before insertion or not

if (CREATE_DB_BEFORE_INSERTION) {
//Total creation of the database before insertion. (drop database before the creation)
    require_once "../app/.const.php";
    $filename = "db-manage/create-db-kanff.sql";

//Drop and create again the database kanff:
    $cmdCreate = "mysql -u $user -p$pass < $filename -h $dbhost";  //system command for execute sql queries or sql file
    exec($cmdCreate);
    echo "\n\nDatabase kanff dropped and created again !";
}

//Comment or uncomment the functions that you need (be aware of foreign keys and if the creation of db before insertion is enabled):
//dataUsers();
//dataGroups();
//data_join();
//dataProjects();
//dataParticipate();
//dataLog();
dataWorks();
?>