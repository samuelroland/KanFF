# Database specifications
This is the documentation of the database of the KanFF.

## Informations
- MCD and MLD
- List of all tables
- List of all fields for each table
- Pack "Collectif Assoc Vaud" 
- How to generate another pack ?

## MCD and MLD
MCD (`Modèle Conceptuel de Données` in french is the `Conceptual Data Model` in english)

![MCD picture](MCD-KanFF-official.png)

MLD (`Modèle Logique de Données` in french is the `Logical Data Model` in english)

![MCD picture](MLD-KanFF-official.png)

## List of all tables:
- `users`: list of users on the instance
- `groups`: list of groups
- `join`: joining table between users and groups, says who join which group
- `projects`: list of projects
- `works`: list of works (works are part of projects and a group of tasks)
- `tasks`: list of tasks
- `participate`: list of participations of groups to projects
- `log`: joining table representing a list of logs (not technical but project log, displayed in a logbook)

Other tables exist in the data model but are abandoned for v1.0...

## List of all fields for each table:
### Information about the whole database:
- **All tables contain an `id`** field that is the unique technical identifier for each entry in the database. To make this documentation lighter, this field isn't mentioned for each table below.
- **All the dates are stored in DATETIME format** (even if the hours, minutes, seconds level of precision is not displayed).
- **All the links are 2000 chars max long**.
- All TINYINT value are representing boolean value (MySQL doesn't support BOOL type). 0 = false and 1 = true.
- All fields representing a technical state of an element are called `state` and are always in INT type. (Example: look at users.state below). This information has an impact on the use and the permissions on the app.
- All fields given an information about the state with a text (content of this text is free) are called `status` and are always in VARCHAR type. (Example for users.status: `I'm in holiday. I'll be back the 10th. Leave me an SMS if you really need me...`). This information is not technically linked to state and has no impact on the use of the app.

### Users:
- `username`: a simple username of a maximum of 15 characters
- `initials`: initials built with firstname and lastname (first letter of firstname + first and last letter of lastname (default format)) always in uppercase. It's a unique identifier.
- `firstname`: firstname of the user
- `lastname`: lastname of the user
- `chat_link`: link to an external messaging app internal to the collective, to write in private to the user (first contact mean)
- `email`: an facultative email that can useful for other users of the collective (second contact mean, not technically used)
- `phonenumber`: a string of 20 digits for the phonenumber (third contact mean, not technically used)
- `biography`: a biography text
- `password`: the password to login hashed with password_hash() and DEFAULT_PASSWORD mode
- `inscription`: date of creation of the account
- `on_break`: if you are on break or not (of your work in the collective)
- `status`: status written by the user
- `state`: technical state of the account:
    - Values: 
        - 0 = unapproved
        - 1 = approved
        - 2 = archived
        - 3 = banned
        - 4 = admin
    - Effect:
        - unapproved, archived and banned: the user has no access to internal data. The user can run these actions only: login, signin, about, sendFeedback, editAccount.
        - approved: access to internal data like a normal user (most common state)
        - admin: access to internal data and the management of members (management of their state only)
- `state_modifier_id`: As only admins can change state of users, this field store the id of the admin that change the user state for the last time
- `state_modification_date`: date of last modification of the state of the user by an admin

### Groups:
11 records.
- `name`: name of the group
- `description`: description of what is the group, what is its goal and how it is organized
- `context`: why and in which context/circumstances, the group has been created.
- `prerequisite`: prerequisite to have before joining the group
- `email`: email as mean of contact for the entire group
- `image`: image name (ex: `group_2fg2k8ip25uujr77t4tfyegn4puusp.jpg`). The images are stored in folder `/data/groups/`. Naming format: `group_` + random string of 30 chars + `.jpg`
- `restrict_access`: boolean value (in tinyint). Says if the access to the group is restricted (anyone that want to join need to be moderated). This is useful for sensitive groups.
- `chat_link`: link to join the group in the internal messaging app
- `drive_link`: link of the drive or of the folder in the drive where the group store its files 
- `status`: status written by members of the group
- `state`: technical state of the group:
    - Values:
        - 0 = on start-up
        - 1 = active
        - 2 = on break
        - 3 = archived
- `visibility`: This is the level of visibility of the group's details, for members of the collective external to the group. (The members of the group have access to all information about the group).
    - Values:
        - 1 = Invisible: totally invisible
        - 2 = Title visible: only name is visible
        - 3 = Standard: Fast all visible: only `chat_link` and `drive_link` are not visible. And members too. (3 is the defaut choice)
        - 4 = Totally visible: All fields of the table "groups" (without the id). And members too.
- `creator_id`: id of the user that have created the group
- `creation_date`: date of the creation of the group

### join:
- `user_id`: the foreign key linked users.id
- `group_id`: the foreign key linked groups.id
- `start`: date of subscription (if not yet inside the group, the date is when the entry is created, then when the user is accepted, the start is updated to the date of joining)
- `end`: date of when the user has left the group or has been refused (for any reason)
- `state`: technical state of the joining:
    - A user is member of a group if state is "invitation accepted" or "approved".
    - Possible values if access is restricted:
        - 1 = unapproved
        - 2 = refused
        - 3 = invitation
        - 4 = left
        - 5 = invitation refused
        - 6 = banned
        - 7 = invitation accepted
        - 8 = approved
    - Possible values if access is not restricted:
        6 = banned
        8 = approved
- `admin`: level of admin: 0 = not an admin, 1 = is an normal admin. (no others values now).

### Projects:
- `name`: name of the group
- `description`: description of the project
- `goal`: goal/mission of the project
- `start` and `end`: start and end dates of the project (end is facultative, start can be set in the past at creation)
- `state`: technical state of the project:
    - Values:
        - 0 = under reflection
        - 1 = under planning
        - 2 = semi-active work
        - 3 = active work
        - 4 = on break
        - 5 = reported
        - 6 = abandoned
        - 7 = cancelled
        - 8 = done
- `archived`: boolean value. if the project is archived or not. A project can be archived only if his state is abandoned, cancelled or completed (6, 7 or 8)
- `importance` and `urgency`: values 1 to 5 to mesure importance and urgency of the project. (1=min and 5=max)
- `visible`: boolean value. visible or not outside of the group.
- `logbook_visible`: boolean value. can make the logbook visible or note. (The logbook make a group of log: user_log_project).
- `logbook_content`: text about the content of the logbook. The members should write a very short text to say wich content should be saved in the logbook. And the text have to describe the definition of important. For example:
    >Contains the important decisions, formal meetings, important change and publications of new versions of documents. 
    ><br>Important means that what is described in the log, has an impact on the work of severals persons in the project.
- `needhelp`: boolean value. Add a little icon "help" if the project need help of externals persons (to join the group or to help without join)
- 

### Works:
- name: name of the work
- description: simple description of what will be done in this work
- start and end: date of start and of the work. Is useful to make a planning.
- state: technical state of the work (independant of dates about the work. changes are only manual)
    - Values: 1 = to do, 2 = in run, 3 = on break, 4 = completed.
- value: value of the "work" made in this work. INT value: 1 to 10.
- effort: value between 1 and 10 about the effort to bring to achieve this work.
- visible: boolean value. visible or not outside of the group.
- creation_date: date of creation of the work.

### Tasks:
- number: unique identifier to identify a task. equal to id ? !!how to generate an unique number ?
- name: name of the task
- description: what you should do in this task, if name is not clear or unprecise
- deadline: date where the task should be done
- state: technical state of the task (independant of dates about the task. changes are only manual)
    - Values: 1 = to do, 2 = in run, 3 = completed.
- urgency: how the task is urgent (1=min and 5=max)
- link: can contains a link that is related to the task
- completion_date: date of the completion of the task


## Pack "Collectif Assoc Vaud":
This pack of data in french is about a fictive collective called "Collectif Assoc Vaud"

### Content:
- 100 users
- 13 groups
- 16 projects
- 25 works (9 real works written by hand + 16 works inbox (16 because 1 for each project))
- 336 tasks (36 real tasks written by hand + 300 in lorem ipsum)
- 538 join
- 12 log
- 24 participate (association of group_id and project_id written by hand)

### How to use it ?
//import db

Passwords are the firstname of the user...

Examples users (often used in user doc and other examples) to login:
- Josette Richard (JRD - josette.richard@assoc.ch)
- Vincent Rigot (VRT - vincent.rigot@assoc.ch)
- Mégane Blan (MBN - megane.blan@assoc.ch)

## How to generate another pack ?
If you know how to execute php and write a file in JSON format, you are able to create another pack. This can be useful for demonstration purposes when you need other data than the pack "Collectif Assoc Vaud" because you want to have more realistic data corresponding to your collective.