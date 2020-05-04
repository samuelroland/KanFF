<?php
/**
 *  Project: KanFF
 *  File: CRUDModel Function: getall, getone, getbycritere, updateone, deleteone, createone
 *  Author: Benoit Pierrehumbert
 *  Creation date: 04/05/2020
 */

//TODO: change the informations of the cartouche !!!!!!!

function getPDO()
{
    require ".const.php";
    $res = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
    return $res;
}
function Query($table,$query,$params,$manyrecords){
    $params[]=['table'=>$table];
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
    $query='SELECT * FROM :table';
    $params='';
   return Query($table,$query,$params,true);
}
//Get one specific element of one Table
function getByCondition($table,$params,$condition)
{
    $query='SELECT * FROM :table'.$where;
    return Query($table,$query,$params,true);
}
//Get
?>
