<?php
/**
 *  Project: KanFF
 *  File: importData.php file to importe the data for example generated and stored in json files in a specific folder.
 *  Author: Samuel Roland
 *  Creation date: 09.05.2020
 */

function getPDO()
{
    require "../app/.const.php";
    return new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
}

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

function importTableData($table, $items)
{
        $query = queryInsertConstructor($items, $table);

        //Delete table records before insert
        $statement = getPDO()->prepare("delete from $table");
        $statement->execute();   //éxecuter la requête

        //Finally insert data!
        insertItemsInDB($query, $items);
        echo "Imported successfully! \n";
}


?>