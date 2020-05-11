<?php
/**
 *  Project: KanFF
 *  File: importData.php file to importe the data for example generated and stored in json files in a specific folder.
 *  Author: Samuel Roland
 *  Creation date: 09.05.2020
 */

define("DATAFOLDER", "data_generated_general");

function getPDO()
{
    require "../.const.php";
    return new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
}

/**
 * Insère toutes les données contenues dans le tableau $batch dans la db au moyen de la requête $query
 * @param $query
 * @param $batch
 */
function insertItemsInDB($query, $items)
{
    foreach ($items as $val) // execute it many times for each item
    {
        try {
            $statement = getPDO()->prepare($query);//prepare query once
            $statement->execute($val);   //éxecuter la requête
        } catch (PDOException $e) { //en cas d'erreur dans le try
            echo "Error!: " . $e->getMessage() . "\n";
        }
    }
}

//Build the string of the query with parameters according to the data.
function queryInsertConstructor($items, $tablename)
{
    //Create the lists of the keys of an item of the list. Take the first item shouldn't create problem.
    foreach ($items[0] as $key => $fieldOfOneItem) {
        $listofkeys[] = $key;
    }
    $query = "INSERT INTO $tablename (" . implode(", ", $listofkeys) . ") VALUES (:" . implode(", :", $listofkeys) . ");";
    return $query;
}

//General function to import table data by a table name
function importTableData($table)
{
    echo "\n----------------------------------------------------------
    Importing $table 
----------------------------------------------------------\n ";
    if (file_exists(DATAFOLDER . "/$table.json")) {
        $items = json_decode(file_get_contents(DATAFOLDER . "/$table.json"), true);
        $query = queryInsertConstructor($items, $table);

        //Delete table records before insert
        $statement = getPDO()->prepare("delete from $table");//prepare query once
        $statement->execute();   //éxecuter la requête

        //Finally insert data!
        insertItemsInDB($query, $items);
        echo "Imported successfully! \n";
    } else {
        echo "error: json file not found in " . DATAFOLDER . "/$table.json\n";
    }
}

// --------------------------------------------
// Execution for the tables choosed.
// --------------------------------------------

//List of tables to import (the order is important!) in the database. Every table need a json file (table users: users.json)
$tablestoimport = [
    "users",
    "groups",
    "...",
];

//Import each table of the list
foreach ($tablestoimport as $table) {
    importTableData($table);
}


?>