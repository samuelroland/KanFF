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
function Query($query,$params,$manyrecords){

    try {
        $dbh = getPDO();
        $statement = $dbh->prepare($query);//prepare query
        $statement->execute($params);//execute query
        if ($manyrecords){
        $queryResult = $statement->fetchAll();//prepare result for client
        }else{
            $queryResult = $statement->fetch();//prepare result for client
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
    $query='SELECT * FROM '.$table;
    $params='';
   return Query($query,$params,true);
}
//Get one element by his id
function getOne($table,$id){
    $query='SELECT * FROM '.$table.' WHERE id=:id';
    $params="['id'=>.$id.]";
    return Query($query,$params,false);
}
//Get one specific element of one Table
function getByCriterion($table,$params,$criterions)
{
    //$criterions need the complete where condition with AND / OR write in SQL
    $query='SELECT * FROM '.$table.' WHERE '.$criterions;
    return Query($query,$params,false);
}
//Update one element
function updateOne($table,$id,$elementForUpdate,$params){
    $query='UPDATE '.$table.' SET '.$elementForUpdate.' WHERE id='.$id;
    return Query($query,$params,false);
}
//Create one element
function createOne($table,$elementForCreate,$params,$criterions){
    $query='INSERT INTO '.$table.' WHERE '.$criterions;
}
?>
