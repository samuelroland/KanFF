<?php
/**
 *  Project: KanFF
 *  File: projectsModel.php functions model for the projects
 *  Author: Benoit Pierrehumbert
 *  Creation date: 24.09.2020
 */

//Get one projects with his id
function getOneProject($id)
{
    require getOne("projects", $id);
}

//Get all projects
function getAllProjects()
{
    return getAll("projects");

}

//Get one projects whith conditions
function getOneByConditionProject($criterions,$params){
    return getByCondition("projects", $params, $criterions, false);
}

//Get more than one projects whith conditions
function getAllByConditionProjects($criterions,$params){
    return getByCondition("projects", $params, $criterions, true);
}

//Create projects
function createProjects($projects)
{
    createOne("projects", $projects);
}

//Update one projects with his id
function updateProjects($projects, $id)
{
    updateOne("projects", $id, $projects);
}

//Delete one projects with his id
function deleteProjects($id)
{
    deleteOne("projects", $id);
}

//Get all the projects in which a group participates, for a person that is a member of this group or not (can see invisible projects only if is a member)
function getAllProjectsByGroup($id, $isMember)
{
    $query = "SELECT projects.* FROM projects
INNER join participate ON projects.id = participate.project_id
INNER join `groups` ON `groups`.id = participate.group_id
WHERE `groups`.id = :id" . (($isMember == false) ? " AND projects.visible = 1;" : ";");
    $params = ["id" => $id];
    return Query($query, $params, true);
}

?>
