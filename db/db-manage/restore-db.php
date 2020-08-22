<?php
/**
 *  Project: KanFF
 *  File: restore-db.php script started with the bat file "restore-db-kanff.bat" in the same folder, that restore entirely the database kanff.
 *  Author: Samuel Roland
 *  Creation date: 12.06.2020
 */

$path = "../../app/.const.php";
if (file_exists($path) == false) {
    $path = ".const.php";
}
echo "path is " . $path . " !!\n\n";
require_once $path;  //get login informations for db in the app folder

$filename = "create-db-kanff.sql";
if ($dbname != "kanff") {
//Prepare data before creation: replace "kanff" by the right dbname.
    $queriesCreate = file_get_contents("create-db-kanff.sql");
    $queriesCreate = str_replace("kanff", $dbname, $queriesCreate);
    $queriesCreate = str_replace("VISIBLE", "", $queriesCreate);
    file_put_contents("create-db-kanff-ok.sql", $queriesCreate);
    echo "file create-db-kanff-ok.sql created!!";
    $filename = "create-db-kanff-ok.sql";
}
//Drop and create again the database kanff:
$cmdCreate = "mysql -u $user -p$pass < $filename -h $dbhost";  //system command for execute sql queries or sql file
exec($cmdCreate);
echo "\n\nDatabase kanff dropped and created again !";

$filename = "fill-data-db-kanff.sql";
if ($dbname != "kanff") {
//Prepare data before creation: replace "kanff" by the right dbname.
    $queriesFill = file_get_contents("fill-data-db-kanff.sql");
    $queriesFill = str_replace("kanff", $dbname, $queriesFill);
    $queriesFill = str_replace("VISIBLE", "", $queriesFill);
    file_put_contents("fill-data-db-kanff-ok.sql", $queriesFill);
    echo "file fill-data-db-kanff-ok.sql created!!";
    $filename = "fill-data-db-kanff-ok.sql";
}

//Fill the db with the data
$cmdFill = "mysql -u $user -p$pass < $filename -h $dbhost";  //system command for execute sql queries or sql file
echo "\n\nDatabase kanff filled with data !";
exec($cmdFill);

echo "\n\nEND...";
?>