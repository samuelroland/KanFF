<?php
/**
 *  Project: KanFF
 *  File: testCRUDmodel.php file for tesing CRUDmodel
 *  Author: Benoît Pierrehumbert
 *  Creation date: 15.05.2020
 */
$BENOIT=true;
require_once 'model/CRUDModel.php';
function displaydebug(){}
//Get all elements of one Table
function test_getAll()
{
    echo "getAll: ";
    $array= getAll("users");
    if (count($array)==100){
        echo "OK";
    }else{
        echo "BUG
";
    }
    echo "
    
    ";
}
//Get one element by his id
function test_getOne(){
    echo "getOne: ";
    $array= getOne("users",56);
    if ($array['username']=="orli82"){
        echo "OK";
    }else{
        echo "BUG
";
        if (isset($array)){
            echo "Array isn't null:";
        }else{
            echo "\$array=null";
        }
    }
    echo "
    
    ";
}
//Get some specific elements of one Table
function test_getAllByCriterion()
{
    echo "getAllByCriterion: ";
    $criterions="email IS NULL";
    $params=null;
    $array= getByCondition("users",$params,$criterions,true);
    if (count($array)==52){
        echo "OK";
    }else{
        echo "BUG
";
        if (isset($array)){
            echo "Array isn't null:";
        }else{
            echo "\$array=null";
        }
    }
    echo "
    
    ";
}
//Get only one specific element of one Table
function test_getOneByCriterion()
{
    echo "getOneByCriterion: ";
    $criterions=' initials = "JRD" ';
    $params=null;
    $array= getByCondition("users",$params,$criterions,false);
    if ($array['phonenumber']==7565739989){
        echo "OK";
    }else{
        echo "BUG
";
        if (isset($array)){
            echo "Array isn't null:";
        }else{
            echo "\$array=null";
        }
    }
    echo "
    
    ";
}

//Create one element
function test_createOne(){
    echo "crateOne: 
    ";
    $name="Test";
    $category="unitTest1";
    $params = ['name'=>$name,'category'=>$category];
    $test=createOne("users",$params);
    $array=getOne("competences",1);
    if ($array['category']=="unitTest1"){
        echo "OK";
    }else{
        echo "BUG
";
        if (isset($test)){
            echo "Array isn't null:";
            echo $test;
        }else{
            echo "\$array=null";
        }
    }
    echo "

";
}
//Update one element
function test_updateOne($table,$id,$elementForUpdate,$params){
    echo "updateOne: ";

    $array= updateOne("users",101);
    if ($array['phonenumber']==6221542889){
        echo "OK";
    }else{
        echo "BUG
";
        if (isset($array)){
            echo "Array isn't null:";
        }else{
            echo "\$array=null";
        }
    }
    echo "

";
}
//Detlete one element by his id
function test_deleteOne($table,$id){

}
function test_unitaire(){

}
///cd C:\Users\benoit.pierrehumbert\Documents\GitHub\KanFF\app
///php -f .\unitTests\testCRUDmodel.php
test_getAll();
test_getOne();
test_getAllByCriterion();
test_getOneByCriterion();
test_createOne();
?>