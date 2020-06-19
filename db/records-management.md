/**
 *  Project: KanFF
 *  File: records-management.txt Informations about the records of the database
 *  Author: Samuel Roland
 *  Creation date: 08.05.2020
 */

This file define:
- the number of records for each tables of the db
- what is the possibilities of specifics value (like status and their meaning if not clear)


Tables:

- Users:
100 records.

phonenumber: 10 numbers
biography: replaced with lorum ipsum
password: firstname hashed with password_hash()
inscription: date between 01.01.2019 and date of generation
status: status of the account
    - Values: 0 = not approuved. 1 = approuved. 2 = archived. 3 = admin. 

- Groups:
11 records.

context: why or in wich context, the group has been created.
email: mean of contact of a entire group
restrict_access: boolean field (in tinyint). is the access of the group totally free or the group want to manage the new members of the group ? set 1 if yes. This is useful for sensitive groups.

visibility: The visibility field is the level of visibility of the group's details, for people of the instance that are not member of the group. (The members of the group can see all details about the group). 
Here is the differents values that are stored and their meanings:

1: Totally invisible
2: Only title visible
3: Fast all visible: name, description, context, email, image, restrict_access value, status, creator, creation_date. And members too. (3 is the defaut choice).
4: Totally visible: All field of the table "groups" (without the id). And members too.

These parameters are useful for sensitive or semi-sensitive groups.

status: (varchar) a little text about what is the state of the group (if it's active, if it's on break, what is the occurence of the meetings, other informations about the status) 
image: name of the image stored in folder "/data/groups". Format: "group_" + random string of 30 chars +".jpg" 

- user_join_group:
Depends on the random. result=

every user should be in minimal in one group (perhaps 0 group in rare cases).
every user are in 10 groups in maximum. 

start: date of subscription
end: date of when the user has left the group/or has been banned, of has been refused 

a user can join, leave, and join again a group.

accepted: state of the subscription. The state is influenced by the group type (restricted access or not)

If access restricted:
1 = want to join the group but not yet accepted or not
2 = not accepted/refused
3 = banned of the group
4 = accepted

If access not restricted:
3 = banned of the group
4 = accepted

--> automatically accepted (4) because free access. no value 1 or 2.

- Projects:
x records wroten by hand.
name: name of the group
description: description of the project
goal: goal/mission of the project
start and end: start and end dates of the project
status????: state of the project. Values: under reflection, planned, in run, on break, reported, abandoned, cancelled, completed, archived.
importance and urgency: values 1 to 5 to mesure importance and urgency of the project.
visible: boolean value. visible or not outside of the group.
logboo_visible: boolean value. can make the logbook visible or note. (The logbook make a group of log: user_log_project).