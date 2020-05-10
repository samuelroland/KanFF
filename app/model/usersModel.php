<?php
/**
 *  Project: KanFF
 *  File: usersModel.php model for the users
 *  Author: LPO
 *  Creation date: 01.05.2020
 */

// TODO: change the informations of the cartouche !!!!!!!

function getPDO()
{

    require ".const.php";
    $dbh = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
    return $dbh;
}

// Gets the logs in the database and return them
function getLogs()
{
    {
        try {
            $dbh = getPDO();
            // TODO: Query à faire
            // $query = "SELECT ... FROM ..."
            $statment = getPDO()->prepare($query);//prepare query
            $statment->execute();//execute query
            $queryResult = $statment->fetchAll(pdo::FETCH_ASSOC);//prepare result for client
            $dbh = null;
            return $queryResult;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            return null;
        }
    }
}

// Creates the logs in the database
function createLogs($data)
{
    try {
        $dbh = getPDO();
        // TODO: Query à faire
        // $query = "INSERT INTO ..."
        $statement = getPDO()->prepare($query);//prepare query
        $statement->execute();//execute query
        $dbh = null;
        return true;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

// Add the new user in the database
function addUser($user)
{
    try {
        $dbh = getPDO();
        // TODO: Query à faire
        // $query = "INSERT INTO ... "
        $statement = getPDO()->prepare($query);//prepare query
        $statement->execute([$user]);//execute query
        $dbh = null;
        return true;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

?>
