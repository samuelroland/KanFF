<?php
/**
 *  Project: KanFF
 *  File: generationData.php file to generate data for fill the database with the tables of the MCD v1.1
 *  Author: Samuel Roland
 *  Creation date: 08.05.2020
 */

//TODO: Fonctions for generate users data
function dataUsers()
{
    //Get all users basic data generated with generatedata.com (firstname, lastname, bio)
    $users = json_decode(file_get_contents("data-ressources/basic-data-users.json"), true);

    //For each user generate the other data
    foreach ($users as $user) {

        $userinrun = $user;
        if (strlen($userinrun['biography']) > 500) {
            $userinrun['biography'] = substr($userinrun['biography'], 0, 500);
        }
        $firstname = $userinrun['firstname'];
        $lastname = $userinrun['lastname'];

        $username = strtolower($firstname) . rand(10, 99);
        $initials = substr($firstname, 0, 1) . substr($lastname, 0, 1) . substr($lastname, strlen($lastname));

        //half the time, email is set to "firstname.lastname@example.com" and if not the email is null
        if (rand(0, 1)) {
            $email = strtolower($firstname) . strtolower($lastname) . "@example.com";
        } else {
            $email = null;
        }

        //Generate phonenumber with 4 numbers between 100 and 999
        $phonenumber = rand(100, 999) . rand(100, 999) . rand(10, 99) . rand(10, 99);

        //Generate a password with the firstname hashed
        $password = password_hash($firstname, PASSWORD_DEFAULT);

        //Generate inscription date in timestamp format, between 01.01.2019 and today.
        $inscription = rand(1546300800, time());

        //Status is by default 0, so yyyyy
        $status = 0;

        //Save data
        $userinrun['email'] = $email;
        $userinrun['initials'] = $initials;
        $userinrun['username'] = $username;
        $userinrun['inscription'] = $inscription;
        $userinrun['status'] = $status;
    }
}

dataUsers();

?>
