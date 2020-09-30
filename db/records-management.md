# Management of the records and generate the data

This file define:
- the number of records for each tables of the db
- what is the possibilities of specifics value (like states and their meanings if not clear)


## Tables:

### Users:
- 100 records.

- phonenumber: 10 numbers
- biography: replaced with lorum ipsum
- password: firstname hashed with password_hash()
- inscription: date between 01.01.2019 and date of generation
- status: status written by the user
- state: technical state of the account:
    - Values: 0 = unapproved. 1 = approved. 2 = archived. 3 = banned. 4 = admin.
        - unapproved, archived and banned: the user can not see internal data. He can login, logout, change his account informations and see the message "you are not approved yet" or "you're account has been archived. contact an admin."
        - approved and on break: access to internal data like normal users
        - admin: access to internal data and the members management (management of their state only, and delete if needed).

### Groups:
11 records.

- context: why or in wich context, the group has been created.
- email: mean of contact of a entire group
- restrict_access: boolean field (in tinyint). is the access of the group totally free or the group want to manage the new members of the group ? set 1 if yes. This is useful for sensitive groups.

- visibility: The visibility field is the level of visibility of the group's details, for people of the instance that are not member of the group. (The members of the group can see all details about the group). 
Here is the differents values that are stored and their meanings:

1: Totally invisible
2: Only title visible
3: Fast all visible: name, description, context, email, image, restrict_access value, status, state, creator, creation_date. And members too. (3 is the defaut choice).
4: Totally visible: All field of the table "groups" (without the id). And members too.

These 2 parameters are useful for sensitive or semi-sensitive groups!

Others fields:
- image: name of the image stored in folder `/data/groups/`. Format: `group_` + random string of 30 chars + `.jpg`
- status: status written by members of the group
- state: technical state of the group:
    - Values: 0 = on start-up. 1 = active. 2 = on break. 3 = archived.

### join:
Depends on the random.

every user should be in minimal in one group (perhaps 0 group in rare cases).
every user are in 10 groups in maximum. 

- start: date of subscription
- end: date of when the user has left the group/or has been banned, of has been refused 

a user can join, leave, and join again a group.

accepted: state of the subscription. The state is influenced by the group type (restricted access or not)

If access restricted:
1 = non approuved
2 = refused
3 = ask for invitation
4 = invitation accepted
5 = invitation refused
4 = banned of the group
5 = accepted

invitation ? sensible group ? !!! user quit a group himself!
admin of a group ??
date for accepted ? (last modification) ???

If access not restricted:
4 = banned of the group
5 = accepted

--> automatically accepted (5) because free access. no value 1, 2 or 3.

So a user is member of a group if: there is no end date and accepted = 5

### Projects:
x records wroten by hand.

- name: name of the group
- description: description of the project
- goal: goal/mission of the project
- start and end: start and end dates of the project
- state: technical state of the project:
    - Values: 0 = under reflection, 1 = under planning, 2 = semi-active work, 3 = active work, 4 = on break, 5 = reported, 6 = abandoned, 7 = cancelled, 8 = completed.
- archived: boolean value. if the project is archived or not. A project can be archived only if his state is abandoned, cancelled or completed (6, 7 or 8)
- importance and urgency: values 1 to 5 to mesure importance and urgency of the project. (1=min and 5=max)
- visible: boolean value. visible or not outside of the group.
- logbook_visible: boolean value. can make the logbook visible or note. (The logbook make a group of log: user_log_project).
- logbook_content: text about the content of the logbook. The members should write a very short text to say wich content should be saved in the logbook. And the text have to describe the definition of important. For example:
    >Contains the important decisions, formal meetings, important change and publications of new versions of documents. 
    ><br>Important means that what is described in the log, has an impact on the work of severals persons in the project.
- needhelp: boolean value. Add a little icon "help" if the project need help of externals persons (to join the group or to help without join)
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

