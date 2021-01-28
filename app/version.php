<?php
/**
 *  Project: KanFF
 *  File: version.php store informations of the versions. The actual version is the last one.
 *  Author: Team
 *  Creation date: 07.05.2020
 */

//Store the list of the differents versions with a version number, a date of the version and a changelog text about what is new in the app.
$versions = [
    [
        "version" => "v0.1-beta",
        "date" => "2020-05-11",
        "changelog" => "Start of gabarit, start of the view of signin et create an account. logo temporary."
    ],
    [
        "version" => "v0.2-beta",
        "date" => "2020-05-25",
        "changelog" => "The login is functional (login and logout). The account creation page, login page, account editing page and gabarit are in progress. The logo is temporary."
    ],
    [
        "version" => "v1.0-beta",
        "date" => "2020-06-19",
        "changelog" => "- KanFF Logo finished! (and favicon created too)\n
- Continuation of the gabarit with the menu, the design and the colors.\n
- CRUDModel unit tests in progress.\n
- Create a group and display the list of the groups, in progress.\n
- Create an account in progress."
    ],
    [
        "version" => "v1.1-beta",
        "date" => "2020-09-11",
        "changelog" => "- **Create an account** is possible!
- **Login** is finished (you can login with space at start and end of the username, email or initials)
- **Design of the gabarit** is finished too. The user logged can now see his basic information on a dropdown (appear on click on initials) and access to his account or logout. Some of enhancements on the logo position and the version text. The general look of the menu has been updated.
- **Flashmessages** can now be displayed (in the gabarit or wherever you want in a view).
- \"**Manage account**\" and \"**Model CRUD**\" are Work In Progress yet.
- Lots of reflexion have been made on the big feature \"Project management\". Next release will contain project management stories.
- Work on **technical documentation** have started. Some stories (like Groups page or Create a group) are just on break and not finished unfortunately. This is not our priority now.
        "
    ],
    [
        "version" => "v1.2-beta",
        "date" => "2020-10-08",
        "changelog" => "- **Limited access** enabled for users not approved or not admin, so the users with state non-approved, archived or banned don't have access to internal data.
\n- **Model CRUD general** is finished ! Units tests are well written and all tests return \"Success\" without PHP errors.
\n- **Model CRUD for projects** is done too. Basic and advanced model functions on projects are available.
\n
\n**Others:**
\n- **MCD and MLD v1.3** published. Contains a lot of adjustments for project management, users and groups.
\n- **Database updated** with a new pack of cleverly generated data. For tables: projects, works, log and participate.
\n- **Page My account** is work in progress... design of the view fixed.
\n- **Details of a projet** is in progress. Logbook display is pretty advanced.
\n- **Create a project** and **Page projects** are in progress.
\n- ..."
    ],
    [
        "version" => "v2.0-beta",
        "date" => "2020-11-15",
        "changelog" => "- **Feedback form finished** (it can be activated with variables in `.const.php`)
\n- **Page Kanban** work in progress (create tasks, display their details and delete them is possible)
\n- Page Projects, Details of a project, Create a project, are in progress.
\n- **Technical documentation** (about the app and the project) is up to date (main doc: `kanff-doc-fr.md` and linked documentations: `helpers-functions.md`, `db-specifications.md`, `list-pages.md`, `structure-ajax-calls.md`)
\n
\nOthers:
\n- **My account** always in progress. The model is respected.
\n- **Start of demanding feedback** to external persons and fixing bugs
"],
    [
        "version" => "v2.1-beta",
        "date" => "2020-12-03",
        "changelog" => "New features:
\n- **Technical documentation** (list pages, structure ajax calls, helpers functions, database specifications, are done but global documentation is in progress).
\n- **Page My account** is finally done. Update general information and password are now possible.
\n- **CRUD model for users** is done.
\n- **Page Members** is alsmost finished (change the account state is possible).
\n
\nOthers:
\n- **Page Delete/Archive account** is in progress.
\n- **User manual** is still a draft.
"], [
        "version" => "v2.2-beta",
        "date" => "2020-12-18",
        "changelog" => "New features:
\n- **Technical documentation** is done for trimester 9.
\n- **Page Archive/Delete account** is done. Archive and delete his own account is now possible.
\n- **User manual** structure is done. The manual is accessible from each page with anchors and the content can be written. There is an automatic table of contents and version information.
\n- **Generation data** script is done. Package `Collectif Assoc Vaud` in `v2.5` published.
\n
\nOthers:
\n- **Page Member details** is in progress. Design is finished and contributions are displayed. Visibility parameters are not managed yet.
"],
    [
        "version" => "v2.3-beta",
        "date" => "2021-01-08",
        "changelog" => "New features:
\n- **Addings on Page Members** are done. Delete unapproved users is possible. Last change of state displayed is useful when updating a user's state.
\n- **Page Delete/Archive account** that had an issue with flashmessages, is fixed.
\n- **Page Create a project** is done. Validations at server-side are better (empty string values and int values, invalid dates, ...)
\n- **User manual**. Little fixes and adjustements of images design. The error that occurs when the image is not found, is also fixed.
\n- **CRUD Models** for Projects management are done.
\n
\nOthers:
\n- **Page Projects** is almost finished. The order for projects in categories `Completed` and `Others` has been fixed (based on end date, not on priority like the 2 other categories). Some little design is needed yet for the progress bar and the access icon.
\n- **Page Member details** is in progress. Visibility parameters are managed for groups but not for contributions.
\n- **Tasks management in the Kanban** is advanced. The tasks can change columns.
"],
    [
        "version" => "v2.4-beta",
        "date" => "2021-01-28",
        "changelog" => "New features:
\n- **Page Member details** is done. Visibility management is fixed.
\n- **Tasks management** has well progressed. General information, responsible and state can be updated. But there are still a lot of bugs in the display after the updates.
\n- **Page Projects**: design fixed and progress bar algorithm enhanced (tasks are included in the calculation).
\n- **Documentations** for trimester 10 well completed (not completly done).
\n
\nOthers:
\n- **Page Kanban**, **Tasks management**, **Details/Management of a project**, **Works management**, **Groups participatings management**, have not progressed."]
];

?>
