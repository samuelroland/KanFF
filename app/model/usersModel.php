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

// Fonction qui va chercher les sessions dans la base de données
function getLogs()
{
    {
        try {
            $dbh = getPDO();
            // TODO: Query à faire
            // $query =
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
// Fonction qui va créer les sessions dans la base de données
function createLogs($data)
{
    try {
        $dbh = getPDO();
        // TODO: Query à faire
        // $query =
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
