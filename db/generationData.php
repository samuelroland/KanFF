<?php
/**
 *  Project: KanFF
 *  File: generationData.php file to generate data for fill the database with the tables of the MCD v1.1
 *  Author: Samuel Roland
 *  Creation date: 08.05.2020
 */

//TODO: Functions for generate users data
function dataUsers()
{
    //Get all users basic data generated with generatedata.com (firstname, lastname, bio)
    $usersressources = json_decode(file_get_contents("data-ressources/basic-data-users.json"), true);

    echo "\n-----------------------------\n Generating Users \n-----------------------------\n ";
    $id = 0;
    $users = [];    //array for the users generated

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
        $username = strtolower($firstname) . rand(10, 99);
        //Generate initials
        $initials = substr($firstname, 0, 1) . substr($lastname, 0, 1) . substr($lastname, strlen($lastname) - 1);
        $initials = strtoupper($initials);
        //half the time, email is set to "firstname.lastname@example.com" and if not the email is null
        if (rand(0, 1)) {
            $email = strtolower($firstname) . "." . strtolower($lastname) . "@example.com";
        } else {
            $email = null;
        }

        //Generate phonenumber of 10 number
        $phonenumber = rand(100, 999) . rand(100, 999) . rand(10, 99) . rand(10, 99);

        //Generate a password with the firstname hashed
        $password = password_hash($firstname, PASSWORD_DEFAULT);

        //Generate inscription date in timestamp format, between 01.01.2019 and today.
        $inscription = date("Y-m-d H:i:s", rand(1546300800, time()));

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
        echo "\n" . $userinrun['id'] ." ". $userinrun['firstname'] . " " . $userinrun['lastname'] . " " . $userinrun['initials'] . " " . $userinrun['username'] . " " . $userinrun['email'] . " " . $userinrun['inscription'] . " " . $userinrun['status'] . " " . $userinrun['phonenumber'] . " " . $userinrun['password'];
    }
    file_put_contents("data_generated/users.json", json_encode($users));
}


dataUsers();

?>
