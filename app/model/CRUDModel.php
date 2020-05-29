<?php
/**
 *  Project: KanFF
 *  File: CRUDModel Function: getall, getone, getbycriterions, updateone, deleteone, createone
 *  Author: Benoit Pierrehumbert
 *  Creation date: 04/05/2020
 */

function getPDO()
{
    require "../.const.php";
    $res = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
    return $res;
}
function Query($query,$params,$manyrecords){

    try {
        $dbh = getPDO();
        $statement = $dbh->prepare($query);//prepare query
        if (isset($params)){
            $statement->execute($params);//execute query
        }else{
            $statement->execute();//execute query
        }

        if ($manyrecords){
        $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);//prepare result for client
        }else{
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
    $query='SELECT * FROM '.$table;
    $params=null;
   return Query($query,$params,true);
}
//Get one element by his id
function getOne($table,$id){
    $query='SELECT * FROM '.$table.' WHERE id=:id';
    $params=['id'=>"$id"];
    return Query($query,$params,false);
}
//Get one specific element of one Table
function getByCondition($table,$params,$conditions,$manyrecords)
{
    //$criterions need the complete where condition with AND / OR write in SQL
    //Example for $criterions= id=:id AND name=:name
    //$params=["id"=>$id,"name"=>$name]
    //$manyrecords=boolean (true/false)
    $query='SELECT * FROM '.$table.' WHERE '.$conditions;
    return Query($query,$params,$manyrecords);
}
//Update one element
function updateOne($table,$id,$elementForUpdate,$params){
    //$elementForUpdate = 'department'=:department
    //$params = ["department"=>$department]
    $query='UPDATE '.$table.' SET '.$elementForUpdate.' WHERE id='.$id;
    return Query($query,$params,false);
}
//Create one element
function createOne($table,$params,$values,$field){
    //$field = (department, name, code)
    //$values = '('.:department.','.:name.','.:code.')'
    //$params = ['department'=>$department,'name'=>$name,'code'=>$code]
    $query='INSERT INTO '.$table.' ( '.$field.') VALUES ('.$values.')';
    return Query($query,$params,false);
}
//Detlete one element by his id
function deleteOne($table,$id){
    $query='DELETE FORM '.$table.' WHERE id=:id';
    $params=['id'=>"$id"];
    return Query($query,$params,false);
}
?>
