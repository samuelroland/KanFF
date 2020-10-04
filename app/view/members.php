<?php
ob_start();
$title = "Membres";
$isAdmin = checkAdmin();

?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-4">
            <button data-href="?action=members&option=1"
                    class="clickable btn <?= ($option == 1) ? 'active' : 'btn-info' ?>">Actif
            </button>
            <button data-href="?action=members&option=2"
                    class="clickable btn <?= ($option == 2) ? 'active' : 'btn-info' ?>">En pause
            </button>
            <button data-href="?action=members&option=3"
                    class="clickable btn <?= ($option == 3) ? 'active' : 'btn-info' ?>">Archivé
            </button>
            <button data-href="?action=members&option=4"
                    class="clickable btn <?= ($option == 4) ? 'active' : 'btn-info' ?>">Admin
            </button>
            <?php
            if ($isAdmin) { ?>
                <button data-href="?action=members&option=5"
                        class="clickable btn <?= ($option == 5) ? 'active' : 'btn-info' ?>">Non approuvé
                    (<strong><?= $nbUnapprovedUsers ?></strong>)
                </button>
                <button data-href="?action=members&option=6"
                        class="clickable btn <?= ($option == 6) ? 'active' : 'btn-info' ?>">Banni
                </button>
                <?php
            }
            ?>
        </div>
        <div class="box-alignright flex-1">
            <?php if ($isAdmin) { ?>
                <button class="btn btn-primary" id="btnEditMode">Mode édition</button>
            <?php } ?>
        </div>
    </div>

    <div class="flexdiv">
        <p class="pt-2 flex-2">La liste ci-dessous contient <strong><?= count($members) ?></strong> membres.</p>
        <div class="box-alignright flex-1">
            <input type="password" id="inpPassword" class="form-control" placeholder="Mot de passe" hidden>
        </div>
    </div>

    <div class="divMembers pt-0 flexdiv">
        <table class="table">
            <thead class="yellowligthheader">
            <tr>
                <th>Initiales</th>
                <th>Nom <br>d'utilisateur.ice</th>
                <th>Nom <br>complet</th>
                <th>Statut</th>
                <th>Inscription</th>
                <?php
                if ($isAdmin) {
                    echo "<th>Etat du<br> compte</th>";
                }
                ?>
                <?= ($isAdmin == false && ($option == 1 || $option == 2)) ? "" : "<th>En<br>pause</th>" ?>

            </tr>
            </thead>
            <tbody>
            <?php
            $test = 0;
            foreach ($members as $member) {
                ?>
                <tr class="userline clickable  <?= ($member['id'] == $_SESSION['user']['id']) ? "yellowveryligthheader" : "" ?>"
                    data-href="?action=member&id=<?= $member['id'] ?>">
                    <td><?= $member['initials'] ?></td>
                    <td><?= $member['username'] ?></td>
                    <td><?= $member['firstname'] . " <strong>" . $member['lastname'] . "</strong>" ?></td>
                    <td><?= "<em>" . substrText($member['status'], 77) . "</em>" ?></td>
                    <td><?= DTToHumanDate($member['inscription'], "simpleday") ?></td>
                    <?php //State account cell
                    if ($isAdmin) {
                        echo "<th><select name='' id='' class='sltAccountState' disabled>";
                        foreach (USER_LIST_STATE as $onestate) {
                            echo "<option value='$onestate'" . (($member['state'] == $onestate) ? "selected" : '') . ">" . convertUserState($onestate) . "</option>";
                        }
                    }
                    ?>
                    <?php //On break cell:
                    //$cellOnBreak = '<td><input type="checkbox" disabled ' . (($member['on_break'] == 1) ? "checked" : "") . '></td>';
                    $cellOnBreak = '<td>' . (($member['on_break'] == 1) ? "Oui" : "Non") . '</td>';
                    echo ($isAdmin == false && ($option == 1 || $option == 2)) ? "" : $cellOnBreak
                    ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>