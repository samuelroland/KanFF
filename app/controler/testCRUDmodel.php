<?php
/**
 *  Project: KanFF
 *  File: testCRUDmodel.php file for tesing CRUDmodel
 *  Author: Benoît Pierrehumbert
 *  Creation date: 15.05.2020
 */


//Get all elements of one Table
function getAll()
{}
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
    //Example for $criterions: id=:id AND name=:name
    //$params=["id"=>$id,"name"=>$name]
    $query='SELECT * FROM '.$table.' WHERE '.$criterions;
    return Query($query,$params,false);
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
    $params="['id'=>.$id.]";
    return Query($query,$params,false);
}
?>