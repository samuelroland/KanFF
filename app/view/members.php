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
                <?php
            }
            ?>
        </div>
        <div class="box-alignright flex-1">
            <button class="btn btn-primary" id="btnEditMode">Mode édition</button>
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
                        echo "<th><select name='' id='' class='sltAccountState' disabled>";
                        foreach (USER_LIST_STATE as $onestate) {
                            echo "<option value='$onestate'" . (($member['state'] == $onestate) ? "selected" : '') . ">" . convertUserState($onestate) . "</option>";
                        }
                        echo "</select></th>
                <th class='imgTrash justify-content-center flexdiv'><img src='view/medias/icons/trash.png' class='icon-small' alt='trash icon' data-userid='{$member['id']}' ></th>";
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