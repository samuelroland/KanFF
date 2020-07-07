<?php
/**
 *  Project: KanFF
 *  File: restore-db.php script started with the bat file "restore-db-kanff.bat" in the same folder, that restore entirely the database kanff.
 *  Author: Samuel Roland
 *  Creation date: 12.06.2020
 */


require '../../app/.const.php';  //get login informations for db in the app folder

//Drop and create again the database kanff:
$cmdCreate = "mysql -u $user -p$pass < create-db-kanff.sql";  //system command for execute sql queries or sql file
exec($cmdCreate);
echo "\n\nDatabase kanff dropped and created again !";

//Fill the db with the data
$cmdFill = "mysql -u $user -p$pass < fill-data-db-kanff.sql";  //system command for execute sql queries or sql file
echo "\n\nDatabase kanff filled with data !";
exec($cmdFill);

echo "\n\nEND...";
?>