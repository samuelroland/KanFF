<?php
ob_start();
$title = "Membres";
$isAdmin = false;
if ($_SESSION['user']['state'] == USER_STATE_ADMIN) {
    $isAdmin = true;
}

?>
    <h1><?= $title ?></h1>
    <div class="headView flexdiv">
        <div class="flex-4">
            <button data-href="?action=members&option=1" class="clickable btn <?= ($option == 1) ? 'active' : 'btn-info' ?>">Actif.ves</button>
            <button data-href="?action=members&option=2" class="clickable btn <?= ($option == 2) ? 'active' : 'btn-info' ?>">En pause</button>
            <button data-href="?action=members&option=3" class="clickable btn <?= ($option == 3) ? 'active' : 'btn-info' ?>">Archivés</button>
            <button data-href="?action=members&option=4" class="clickable btn <?= ($option == 4) ? 'active' : 'btn-info' ?>">Admins</button>
            <?php
            if ($isAdmin) { ?>
                <button data-href="?action=members&option=5" class="clickable btn <?= ($option == 5) ? 'active' : 'btn-info' ?>">Non approuvés (<strong><?= $nbUnapprovedUsers ?></strong>)</button>
                <?php
            }
            ?>

        </div>
        <div class="box-alignright flex-1">
            <a href="?action=asjkdlf">
                <button class="btn btn-primary newgroup">yyyyy</button>
            </a>
        </div>
    </div>

    <div class="divMembers pt-3 flexdiv">
        <table class="table">
            <thead class="yellowligthheader">
            <tr>
                <th>Initiales</th>
                <th>Nom d'utilisateur.ice</th>
                <th>Nom complet</th>
                <th>Statut</th>
                <th>Inscription</th>
                <?php
                if ($isAdmin) {
                    echo "<th>Etat du compte</th>
                <th>Supprimer</th>";
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $test = 0;
            foreach ($members as $member) {
                ?>
                <tr class="userline clickable  <?= ($member['id'] == $_SESSION['user']['id']) ? "yellowveryligthheader" : "" ?>"
                    data-href="?action=user&id=<?= $member['id'] ?>">
                    <td><?= $member['initials'] ?></td>
                    <td><?= $member['username'] ?></td>
                    <td><?= $member['firstname'] . " <strong>" . $member['lastname'] . "</strong>" ?></td>
                    <td><?= "<em>" . substrText($member['status'], 77) . "</em>" ?></td>
                    <td><?= DTToHumanDate($member['inscription'], "simpleday") ?></td>
                    <?php
                    if ($isAdmin) {
                        echo "<th><select name='' id='' class='sltAccountState'>";
                        foreach (USER_LIST_STATE as $onestate) {
                            echo "<option value='$onestate'" . (($member['state'] == $onestate) ? "selected" : '') . ">" . convertUserState($onestate) . "</option>";
                        }
                        echo "</select></th>
                <th>Supprimer</th>";
                    }
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