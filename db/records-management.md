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
    - Values: 0 = not approuved. 1 = approuved. 2 = archived. 3 = admin. 

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
- image: name of the image stored in folder "/data/groups". Format: "group_" + random string of 30 chars +".jpg" 
- status: status written by members of the group
- state: technical state of the group:
    - Values: 0 = on start-up. 1 = active. 2 = in break. 3 = archived. 

### user_join_group:
Depends on the random.

every user should be in minimal in one group (perhaps 0 group in rare cases).
every user are in 10 groups in maximum. 

- start: date of subscription
- end: date of when the user has left the group/or has been banned, of has been refused 

a user can join, leave, and join again a group.

accepted: state of the subscription. The state is influenced by the group type (restricted access or not)

If access restricted:
1 = want to join the group but not yet accepted or not
2 = in wait before the choice of the members (they decide to accept or not)
3 = not accepted/refused
4 = banned of the group
5 = accepted

invitation ? sensible group ? !!! user quit a group himself!

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
    - Values: 0 = under reflection, 1 = planned, 2 = in run, 3 = on break, 4 = reported, 5 = abandoned, 6 = cancelled, 7 = completed, 8 = archived.
- importance and urgency: values 1 to 5 to mesure importance and urgency of the project.
- visible: boolean value. visible or not outside of the group.
- logbook_visible: boolean value. can make the logbook visible or note. (The logbook make a group of log: user_log_project).

### Works:
- name: name of the work
- description: simple description of what will be done in this work
- start and end: date of start and of the work. Is useful to make a planing.
- state: technical state of the work (independant of dates about the work. changes are only manual)
    - Values: 1 = to do, 2 = in run, 3 = completed.
- importance and urgency: values 1 to 5 to mesure importance and urgency of the project.
- visible: boolean value. visible or not outside of the group.
- effort: value between 1 and 10 about the effort to bring to achieve this work.
- creation_date: date of creation of the work.

### Tasks:
- number: unique identifier to identify a task. equal to id ? !!how to generate an unique number ?
- name: name of the task
- description: what you should do in this task, if name is not clear of unprecise
- deadline: date where the date should be done
- importance and urgency: values 1 to 5 to mesure importance and urgency of the project.
- state: technical state of the task (independant of dates about the task. changes are only manual)
    - Values: 1 = to do, 2 = in run, 3 = completed.
