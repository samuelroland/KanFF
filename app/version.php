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
        "version" => "1.1-beta",
        "date" => "2020-09-10",
        "changelog" => "- Create an account is possible!
        - Login is finished (you can login with space at start and end of the username, email or initials)
        - Design of the gabarit "
    ]
];

?>
