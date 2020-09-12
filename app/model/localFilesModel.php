<?php
/**
 *  Project: KanFF
 *  File: localFilesModel.php functions of the model about local files (version.php, settings.json, ...)
 *  Author: Samuel Roland
 *  Creation date: 11.05.2020
 */

function getVersionsApp()
{
    require "version.php";
    return $versions;
}

function getInstanceInfos()
{
    $data = json_decode(file_get_contents("instance.json"), true);
    return $data;
}

function getFlashMessageById($id)
{
    $data = json_decode(file_get_contents("flashmessages.json"), true);

    if ($data == null){ //if there is no flashmessage, there is a problem with the formatting of the json file
        return "Error in the code: File flashmessages.json is not properly formatted or is empty ! (For devs: Did you leave a comma or miss a \" ?)";
    }
    if (isset($data[$id])) {
        return $data[$id];
    } else {
        return "MsgID $id for a flashmessage doesn't exists!";
    }
}

?>
