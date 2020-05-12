<?php
/**
 * File : json2db.php
 * Author : X. Carrel
 * Created : 2020-04-30
 * Modified last :
 **/

function getPDO()
{
    require ".const.php";
    $dbh = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $user, $pass);
    return $dbh;
}

/**
 * Insère toutes les données contenues dans le tableau $batch dans la db au moyen de la requête $query
 * @param $query
 * @param $batch
 */
function insertBatch($query, $batch)
{
    require ".const.php";
    $statement = getPDO()->prepare($query);//prepare query once
    foreach ($batch as $val) // execute it many times
    {
        $statement->execute($val);
    }
}

$query = "INSERT INTO groups (name, creation) VALUES (:name, :creation, :maxsize);";
$groups=[
    ["username" => "A", "initials" => "xxx", "firstname" => "Albert", "lastname" => "Rösti", "password" => "xxx", "inscription" => "2020-02-02", "status" => 1],
    ["username" => "B", "initials" => "yyy", "firstname" => "Céline", "lastname" => "du Château", "password" => "xxx", "inscription" => "2020-02-02", "status" => 1]
];

insertBatch($query,$groups);



?>
