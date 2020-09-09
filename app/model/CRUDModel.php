<?php
/**
 *  Project: KanFF
 *  File: CRUDModel Function: getall, getone, getbycriterions, updateone, deleteone, createone
 *  Author: Benoit Pierrehumbert
 *  Creation date: 04/05/2020
 */

function getPDO()
{
    require ".const.php";

    $res = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
    return $res;
}

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
        $dbh = null;
        return $queryResult;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        return null;
    }
}

//Get all elements of one Table
function getAll($table)
{
    //$table = "users" OR "competences" ...
    $query = "SELECT * FROM `$table`";
    $params = null;
    return Query($query, $params, true);
}

//Get one element by his id
function getOne($table, $id)
{
    //$table = "users" OR "competences" ...
    //$id = 55 OR 96556 OR 1 ...
    $query = "SELECT * FROM `$table` WHERE id=:id";
    $params = ['id' => $id];
    return Query($query, $params, false);
}

//Get one specific element of one Table
function getByCondition($table, $params, $conditions, $manyrecords)
{
    //$table = "users" OR "competences" ...
    //$conditions need the complete where condition with AND / OR write in SQL
    //Example for $conditions => id=:id AND name=:name
    //$params = ["id"=>$id,"name"=>$name,"NPA"=>94654]
    //$manyrecords = if the query will return more than 1 items (true/false)

    $query = "SELECT * FROM `$table` WHERE " . $conditions;
    return Query($query, $params, $manyrecords);
}

//Update one element
function updateOne($table, $id, $params)
{
    //$table = "users" OR "competences" ...
    //$id = 55 OR 96556 OR 1 ...
    //$params = ["id"=>$id,"name"=>$name,"NPA"=>94654]

    unset($params['id']);   //destroy id because update the id is prohibited
    $query = "UPDATE `$table` SET " . buildStringForUpdateValues($params) . " WHERE id=" . $id;
    displaydebug($query);
    displaydebug($params);
    return Query($query, $params, false);
}

//Create one element
function createOne($table, $params)
{
    //$table = "users" OR "competences" ...
    //$params = ["name"=>$name,"NPA"=>94654]
    if($debug==false){
        unset($params["id"]);
    }
    $query = "INSERT INTO `$table` " . buildStringForInsertValues($params);
    displaydebug($query);
    displaydebug($params);
    return Query($query, $params, false);
}

//Delete one element by his id
function deleteOne($table, $id)
{
    //$table = "users" OR "competences" ...
    //$id = 55 OR 96556 OR 1 ...

    $query = "DELETE FROM `$table` WHERE id=:id";
    $params = ['id' => $id];
    return Query($query, $params, false);
}

//build the string for the SQL Query for insert values with parameters, after string "INSERT INTO table ". Ex: "(firstname, lastname) VALUES (:firstname, :lastname)"
function buildStringForInsertValues($values)
{
    $fieldsList = implode(", ", array_keys($values));
    $valuesList = implode(", :", array_keys($values));
    return "($fieldsList) VALUES (:$valuesList);";
}

//build the string for the SQL Query for update values with parameters, after string "UPTATE table SET ". Ex: "firstname=:firstname, lastname=:lastname"
function buildStringForUpdateValues($values)
{
    $keys = array_keys($values);    //get the keys of the array that are the fields names
    //Prepare keys before implode()
    foreach ($keys as $i => $onekey) {
        $keys[$i] = $onekey . "=:" . $onekey;   //create string "description=:description" and save it in place of "description"
    }
    return implode(", ", $keys);
}

?>
