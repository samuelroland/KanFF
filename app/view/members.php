<?php
ob_start();
$title = "Membres";

?>
    <h1><?= $title ?></h1>
    <div class="headView row">
        <div class="col-md-6 col-sm-12">
            <button class="btn active">Actif.ves</button>
            <button class="btn btn-info">Non-actif.ves</button>
            <button class="btn btn-info">Archivés</button>
        </div>
        <div class="box-alignright col-md-6 col-sm-12">
            <a href="?action=asjkdlf">
                <button class="btn btn-primary newgroup">yyyyy</button>
            </a>
        </div>
    </div>

    <div class="divGroups row pt-3">
        <table class="table">
            <thead>
            <tr>
                <th>Initiales</th>
                <th>Nom d'utilisateur.ice</th>
                <th>Nom complet</th>
                <th>Biographie</th>
                <th>Inscription instance</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $test = 0;
            foreach ($members as $member) {
                ?>
                <tr class="clickableasdf" data-href="?action=user&id=<?= $member['id'] ?>">
                    <td><?= $member['initials'] ?></td>
                    <td><?= $member['username'] ?></td>
                    <td><?= $member['firstname'] . " " . $member['lastname'] ?></td>
                    <td><?= "<em>" . substrText($member['biography'], 77) . "</em>" ?></td>
                    <td><?= DTToHumanDate($member['inscription'], "simpleday") ?></td>
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