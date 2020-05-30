<?php
ob_start();
$title = "Créer un groupe"
?>
    <h1>Créer un groupe</h1>
    <p>Cette page vous permet de créer un nouveau groupe sur cette instance. Vous rentrez ici les informations de base
        pour un groupe qui sont modifiables par la suite, et les autres informations pourront être rentrées dans les
        paramètres une fois le groupe créé.</p>

    <form action="?action=createAGroup" method="POST" class="pt-5">
        <h4>Nom du groupe</h4>
        <div class="divDescription row pt-5">
        <input type="text" class="smalltextinput textFieldToCheck" name="name" id="txtName" placeholder="GT mail"
               maxlength="50" required>
        <p id="pCounterName">0/50</p>
            <div class="col-lg-3 col-md-12"><h4>Description du groupe</h4></div>
            <div class="col-lg-9 col-md-12 infotext">Ce champ permet de décrire le but et ce qu'il se passera dans ce
                groupe. On
                peut aussi y mettre une indication sur la fréquence de travail et des réunions ou d'autres événements,
                ainsi que quelques dates importantes si nécessaire.
            </div>
            <div class="col-12"><textarea class="fullwidth" name="description" id="txtDescription" rows="5"
                                          maxlength="200" minlength="3" placeholder="tbd"></textarea>
            </div>

        </div>
        <p id="pCounterDescription" data-max="200">0/200</p>
        <div class="divContext row pt-5">
            <div class="col-lg-3 col-md-12"><h4>Contexte</h4></div>
            <div class="col-lg-9 col-md-12 infotext">Le contexte répond aux questions suivantes:
                Pourquoi ce groupe a été créé, dans quelles circonstances/contexte ?
            </div>
            <div class="col-12"><textarea class="fullwidth" name="context" id="txtContext" rows="5" maxlength="200"
                                          minlength="3" placeholder="tbd"></textarea></div>
        </div>
        <p id="pCounterContext" data-max="200">0/200</p>
        <div class="divVisibility row pt-5">
            <div class="col-lg-4 col-md-12 marginauto">
                <h4>Niveau de visibilité</h4>
                <select class="fullwidth" name="visibility" id="selVisibility">
                    <option value="1">Invisible</option>
                    <option value="2">Titre visible</option>
                    <option value="3">Image visible</option>
                    <option value="4">Statut visible</option>
                    <option value="5">Email visible</option>
                    <option value="6">Description et contexte visible</option>
                    <option value="7">Date de création visible</option>
                    <option value="8">Créateur/Créatrice visible</option>
                    <option value="9" selected>Membres visibles</option>
                    <option value="10">Lien du drive visible</option>
                    <option value="11">Lien du chat visible</option>
                    <option value="12">Totalement visible</option>
                </select></div>
            <div class="col-lg-8 col-md-12 infotext">Cette option permet de gérer le niveau de visibilité des
                informations du groupe pour les personnes non-membres. Chaque niveau inclut les précédents. (Image
                visible inclut que le titre est également visible, par exemple. Et "Email visible" inclut l'email
                évidemment mais également le statut, l'image et le titre qui seront visibles).

                La visibilité ou au contraire l'invisibilité des projets, travaux, tâches, événements, journaux de bord,
                ... se gère sur chaque élément en question. (Ainsi un projet peut-être visible alors que d'autres pas).
            </div>
        </div>
        <div class="divVisibility row pt-5">
            <div class="col-lg-4 col-md-12 marginauto ">
                <h4>Type d'accès</h4>
                <input type="checkbox" id="chkRestrictAccess"><label class="" for="chkRestrictAccess">Accès
                    restreint</label></div>
            <div class="col-lg-8 col-md-12 infotext">L'accès restreint permet de modérer l'entrée des personnes dans un
                groupe. Les personnes devront attendre d'être acceptée avant de réelement rejoindre le groupe.
            </div>
        </div>
        <p class="mt-5 infotext">Les 2 paramètres "Visible" et "Accès restreint" n'interfèrent pas entre eux. Ils
            donnent différents niveaux de sécurité des groupes et permettent plus de sécurité ou de confidentialité pour
            les groupes sensibles.</p>
        <div class="divPassword row pt-5">
            <div class="col-lg-4 col-md-12 marginauto ">
                <h4>Confirmation de l'action</h4>
                <input class="fullwidth" type="password" name="password" placeholder="Mot de passe">
            </div>
            <div class="col-lg-8 col-md-12 infotext">Créer un groupe étant une action importante, nous avons besoin de
                votre confirmation pour valider l'action. Pour ceci rentrer le mot de passe de votre compte.
            </div>
        </div>
        <div class="divBtnCreate row pt-5">
            <input type="submit" value="Créer le groupe">
        </div>
    </form>
<?php
$contenttype = "large";
$content = ob_get_clean();
require "gabarit.php";
?>