<?php
/**
 *  Project: KanFF
 *  File: testCRUDmodel.php file for tesing CRUDmodel
 *  Author: Benoît Pierrehumbert
 *  Creation date: 15.05.2020
 */

require_once '../model/CRUDModel.php';
//Get all elements of one Table
function test_getAll()
{
    echo "getAll: ";
    $array= getAll("users");
    if (count($array)==100){
        echo "OK";
    }else{
        echo "BUG";
    }
    echo "<br>";
}
//Get one element by his id
function test_getOne(){
    echo "getOne: ";
    $array= getOne("users",56);
    if ($array['username']=="orli22"){
        echo "OK";
    }else{
        echo "BUG";
        if (isset($array)){
             var_dump($array);
        }else{
            echo "\$array=null";
        }
    }
    echo "<br>";
}
//Get one specific element of one Table
function test_getByCriterion()
{
    echo "getByCriterion: ";
    $id=56;
    $criterions="name IS NULL";
    $params=null;
    $array= getByCriterion("users",$params,$criterions);
    if (count($array)==41){
        echo "OK";
    }else{
        echo "BUG";
        if (isset($array)){
            echo "<br>Le retour de la requète :";
            var_dump($array);
        }else{
            echo "\$array=null";
        }
    }
    echo "<br>";
}
//Update one element
function test_updateOne($table,$id,$elementForUpdate,$params){

}
//Create one element
function test_createOne($table,$params,$values,$field){

}
//Detlete one element by his id
function test_deleteOne($table,$id){

}
function test_unitaire(){

}
test_getAll();
test_getOne();
test_getByCriterion();
?>