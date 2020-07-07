<?php
/**
 *  Project: KanFF
 *  File: restore-db.php script started with the bat file "restore-db-kanff.bat" in the same folder, that restore entirely the database kanff.
 *  Author: Samuel Roland
 *  Creation date: 12.06.2020
 */


require '../.const.php';  //get login informations for db

//Drop and create again the database kanff:
$cmd = "mysql -u $user -p$pass < create-db-kanff.sql";  //system command for execute sql queries or sql file
exec($cmd);
echo "\n\nDatabase kanff dropped and created again !";

//Fill the db with the data
$cmd2 = "mysql -u $user -p$pass < fill-data-db-kanff.sql";  //system command for execute sql queries or sql file
echo "\n\nDatabase kanff filled with data !";
exec($cmd2);

echo "\n\nEND...";
?>
