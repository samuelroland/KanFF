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
    return getOne("projects", $id);
}

//Get all projects
function getAllProjects()
{
    return getAll("projects");

}

//Get one projects whith conditions
function getOneByConditionProject($conditions, $params)
{
    return getByCondition("projects", $params, $conditions, false);
}

//Get more than one projects whith conditions
function getAllByConditionProjects($conditions, $params)
{
    return getByCondition("projects", $params, $conditions, true);
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

//Get all visible groups by the logged user's id
function getAllProjectsVisible($id)
{
    $query = "SELECT (importance*2+urgency) as priority, projects.* FROM projects 
INNER	join participate ON projects.id = participate.project_id
INNER	join `groups` ON `groups`.id = participate.group_id
INNER join `join` ON `join`.group_id = `groups`.id
INNER	join users ON users.id = `join`.user_id
WHERE	users.id = 1 AND participate.state IN (2, 3)
UNION	
SELECT (importance*2+urgency) as priority, projects.* FROM projects 
INNER	join participate ON projects.id = participate.project_id
INNER	join `groups` ON `groups`.id = participate.group_id
INNER join `join` ON `join`.group_id = `groups`.id
WHERE	projects.visible = 1
ORDER BY (importance*2+urgency) desc, importance desc, urgency DESC, end;";
    $params = ["id" => $id];
    return Query($query, $params, true);
}

//Get all projects where the logged user has finish a task
function getAllProjectsContributed($id)
{
    $query = "SELECT projects.* FROM	projects
INNER join works ON works.project_id = projects.id
INNER	join tasks ON tasks.work_id = works.id
WHERE	tasks.responsible_id = :id AND tasks.state = :state
GROUP BY projects.name;";
    $params = ["id" => $id, "state" => TASK_STATE_DONE];
    return Query($query, $params, true);
}

function getAllArchivedProjects($id)
{
    $projects = getAllProjectsVisible($id);
    foreach ($projects as $key => $project) {
        if ($project['archived'] != 1) {
            unset($projects[$key]);
        }
    }
    return $projects;
}

//Get all groups participations to a project where the groups are joined by the member
function getGroupsParticipatingToAProjectByMember($projectid, $userid)
{
    $query = "SELECT participate.* FROM projects
INNER join participate ON participate.project_id = projects.id
INNER join `groups` ON participate.group_id = `groups`.id
INNER join `join` ON `join`.group_id = `groups`.id
INNER join users ON `join`.user_id = users.id
WHERE users.id = :userid AND participate.state IN (" . PARTICIPATE_STATE_INVITATION_ACCEPTED . "," . PARTICIPATE_STATE_CREATOR . ") AND `join`.state IN (7, 8) AND projects.id = :projectid";

    $params = ["userid" => $userid, "projectid" => $projectid];
    return Query($query, $params, true);
}

//Get project's id by task's id
function getProjectIdByTask($idTask){
    $query="SELECT projects.id AS project_id,works.state AS work_state	FROM projects
INNER join 	works ON	projects.id = works.project_id
INNER	join tasks ON works.id = tasks.work_id
WHERE	tasks.id = :id;";
    $params = ["id" => $idTask];
    $result = Query($query, $params, false);
    return $result['project_id'];
}

?>
