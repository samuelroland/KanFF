<?php
/**
 *  Project: KanFF
 *  File: usersModel.php model for the users
 *  Author: YOU
 *  Creation date: DATE
 */

//TODO: change the informations of the cartouche !!!!!!!

function getPDO()
{

    require ".const.php";
    $dbh = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
    return $dbh;
}

//fonction qui va chercher les sessions dans la base de données
function getLogs()
{
    {
        require ".const.php";
        try {
            $dbh = getPDO();
            //Encore en attente
            //$query = "SELECT * FROM users";
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
//fonction qui va créer les sessions dans la base de données
function createLogs($data)
{
    require ".const.php";
    try {
        $dbh =getPDO();
        //Query a comleter
        //$query = "INSERT INTO   ";
        $statement = getPDO()->prepare($query);//prepare query
        $statement->execute($users);//execute query
        // $filmMakers['id']=$dbh -> lastIsertId();
        $dbh = null;
        return true;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

?>
