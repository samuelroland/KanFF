<?php
ob_start();
$title = "Membres";
$isAdmin = checkAdmin();

?>
    <h1><?= $title ?></h1>
<?php printPageWIPTextInfo(); ?>
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
                <div class="btn btn-primary" id="btnMembersEditMode">Mode édition</div>
            <?php } ?>
        </div>
    </div>

    <div class="flexdiv pt-2 pb-2 divMembersSecondLine">
        <span class="pt-2 flex-2">La liste ci-dessous contient <strong><?= count($members) ?></strong> membres.</span>
        <?php if ($isAdmin) { ?>
            <div class="box-alignright flex-1 box-verticalaligncenter" id="inpDivPassword" hidden>
                <?= createToolTipWithPoint("Pour activer le mode édition, vous devez rentrer votre mot de passe.", "icon-xsmall ml-2 mr-2", false, "left") ?>
                <input type="password" id="inpPassword" class="form-control width-min-content"
                       placeholder="Mot de passe">

            </div>
        <?php } ?>
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
                    if ($option != 5) {
                        echo "<th>Changement état</th>";
                    }
                }
                ?>
                <?php
                $onbreakColumn = ($isAdmin == false && ($option == 1 || $option == 2) || ($isAdmin == true && $option == 5));
                echo($onbreakColumn ? "" : "<th>En<br>pause</th>")
                ?>
                <?php
                $deletionColumn = ($isAdmin == false || ($isAdmin == true && $option != 5));
                echo($deletionColumn ? "" : "<th>Suppression</th>");
                ?>

            </tr>
            </thead>
            <tbody>
            <?php
            $test = 0;
            foreach ($members as $member) {
                ?>
                <tr id="tr-member-<?= $member['id'] ?>"
                    class="userline clickable  <?= ($member['id'] == $_SESSION['user']['id']) ? "yellowveryligthheader" : "" ?>"
                    data-href="?action=member&id=<?= $member['id'] ?>">
                    <td><?= $member['initials'] ?></td>
                    <td><?= $member['username'] ?></td>
                    <td class="memberfullname"><?= $member['firstname'] . " <strong>" . $member['lastname'] . "</strong>" ?></td>
                    <td><?= "<em>" . createElementWithFixedLines(substrText($member['status'], 150), 1) . "</em>" ?></td>
                    <td><?= DTToHumanDate($member['inscription'], "simpleday") ?></td>
                    <?php //State account cell
                    if ($isAdmin) {
                        echo "<td class='box-verticalaligncenter'><select name='' id='' class='sltAccountState' data-user='" . $member['id'] . "' disabled data-startstate='" . $member['state'] . "'>";
                        foreach (USER_LIST_STATE as $onestate) {
                            if (canChangeUserState($member['state'], $onestate)) {
                                echo "<option value='$onestate'" . (($member['state'] == $onestate) ? "selected" : '') . ">" . convertUserState($onestate, true) . "</option>";
                            }
                        }
                        echo "</select></td>";
                        if ($option != 5) {
                            echo "<td>" . buildSentenceAccountStateLastChange($member, true, false) . "</td>";
                        }
                    }
                    ?>
                    <?php //On break cell:
                    //$cellOnBreak = '<td><input type="checkbox" disabled ' . (($member['on_break'] == 1) ? "checked" : "") . '></td>';
                    $cellOnBreak = '<td class="">' . (($member['on_break'] == 1) ? printAnIcon("break.svg", "En pause", "break icon", "flexdiv align-content-center icon-middlesmall marginauto", false) : "") . '</td>';
                    echo ($onbreakColumn) ? "" : $cellOnBreak
                    ?>

                    <?php //Deletion column
                    $cellDeletion = '<td class=""><span data-userid="' . $member['id'] . '" class="membersTrashIcons cursorforbidden" id="membertrash-' . $member['id'] . '">' . printAnIcon("trash.png", "Supprimer ce compte", "trash icon", " flexdiv icon-middlesmall marginauto", false) . '</span></td>';
                    echo ($deletionColumn) ? "" : $cellDeletion
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