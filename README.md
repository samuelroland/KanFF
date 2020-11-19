# KanFF

![kanff logo](https://raw.githubusercontent.com/samuelroland/KanFF/master/app/view/medias/logos/KanFF_Logo_background.png)


### Une application web (opensource) de gestion de projets, de tâches, et d'organisation du travail, conçue pour le milieu militant et associatif.
#### Structure de l'application
Quand un collectif utilise l'application, les membres du collectif ont un compte et rejoignent des groupes. Les groupes réalisent 0, 1 ou plusieurs projets (les projets sont réalisés par un ou plusieurs groupes).

Chaque projet a un kanban et est divisé en parties appelées "travaux". Ceux-ci contiennent des tâches relatives à ce travail.
La gestion de toutes ces tâches dans les différents travaux et projets se fait collaborativement à travers le kanban et les détails du projet. Les événements importants relatifs à un projet sont consignés par les membres dans un journal de bord.

## Contexte d'utilisation
L'application est pensée pour être utilisée par **des membres de collectifs, d'organisations, de mouvements, d'associations ou de simples groupes ayant des projets communs.**  
L'application se veut **polyvalente** et devrait pouvoir être utilisée dans des groupes de différentes tailles, structures et objectifs, organisation du travail et réalisant des projets de nature différente, ...
*Pour l'instant, une instance KanFF ne peut pas encore héberger plusieurs collectifs mais qu'un seul. Peut-être cela changera sur des versions suivantes à v1.0.*

## Objectif de l'application
L'application doit pouvoir **gérer des projets, gérer des tâches**, la répartition du travail, planifier des projets, **des réunions et des événements**, gérer les **membres** et les **groupes**, ... afin de **collaborer à plusieurs sur des projets**, avoir une **vision d'ensemble large** (de tous les projets, travaux, tâches, groupes et membres du collectif), de mieux répartir la charge de travail, d'inclure de nouvelles personnes et aussi les personnes moins engagées.

### Publications (releases)
- KanFF Beta v1.0, le 19.06.2020
- KanFF Beta v2.0, le 13.11.2020
- **KanFF v1.0**, le 15.12.2020
D'autres petites publications sont faites entre ces grosses publications à la fin de chaque sprint.

## Installation (pour une instance)
Cette procédure s'applique pour une instance à distance.
A venir.
<!--
### Prérequis:
1. Accès SSH
1. Accès FTP
1. Accès MySQL à distance (facultatif)

### Procédure:
1. Récupérer les fichiers de l'application du dossier app.
TBD.

### Sécurité
TBD. fichiers.
-->
## Installation locale (pour développement)
### Prérequis:
- Avoir un service php et mysql installé et pouvoir les atteindre dans un shell (tester `php -v` et `mysql -v` pour vérifier. Vérification réussie si la commande est reconnue... Cela sera utile pour la mise à jour de la base de données et l'exécution des tests unitaires). 
- Avoir l'extension PDO activée sur le serveur Php (changer `;extension=pdo_mysql` par `extension=pdo_mysql` dans le fichier `php.ini` ou vérifier que c'est déjà fait).

### Procédure:
1. **Récupérer le repository** depuis GitHub (clone ou téléchargement `.zip`) (exemple de clone dans un shell dans le dossier `C:/Alice/Documents/GitHub/`)


        C:
        cd C:/Alice/Documents/GitHub/
        git clone https://github.com/samuelroland/KanFF


1. Ouvrir un shell et **installer les dépendances** avec [`npm`](https://www.npmjs.com/get-npm) dans le dossier `app` ! Un dossier `node_modules` et un fichier `package-lock.json` apparaissent.

        cd app
        npm install

1. Démarrer le service MySQL. Se connecter (avec un client SQL par ex.) en compte `root`. Executer le fichier `db/db-manage/create-db-kanff.sql`, ce qui a pour effet de **créer la base de données** `kanff` et ses tables. Ensuite **créer un nouvel utilisateur** (nommé dans ici `kanffApp` avec `Pa$$w0rd` pour mot de passe) et lui donner accès à la base de données `kanff` précédemment créée. Se connecter au nouvel utilisateur afin de vérifier qu'il a bien été créé et qu'il accède à la base de données `kanff`.
1. Aller dans `app`. Dupliquer le fichier `.const.php.example` et renommer le en `.const.php`.
1. Démarrer un IDE à la racine du repository. Modifier les valeurs du fichier `.const.php` afin d'**inscrire les identifiants** de connexion à la base de donnée (4 valeurs + un cartouche).

        $user = "kanffApp";
        $pass = "Pa\$\$w0rd";   //Caractères spéciaux php doivent être précédé de \
        $dbhost = "localhost";
        $dbname = "kanff";

1. Lancer le fichier `db/db-manage/restore-db-kanff.bat` (ou alors lancer la commande `php -f restore-db.php` dans `db/db-manage/`) afin d'**insérer les données** du pack "Collective Assoc Vaud". La base de données est maintenatn créée. Ce script .bat est utile pour restaurer très rapidement la base de données lors du développement ou de tests.
1. Démarrer un serveur PHP **dans le dossier `app`** (pas le dossier racine du repository!) sur un port libre (ici 8080).
1. **Ouvrir un navigateur web** sur l'adresse localhost et le port choisi: `localhost:8080`.
1. **Validation**: L'installation est terminée lorsque le site s'affiche correctement dans le navigateur (page de login affichée et style CSS semblable à la version du [serveur de tests](https://kanff.mycpnv.ch)) et lorsque que le login fonctionne. Tester avec les identifiants suivants:
       
        initiales: JRD
        mot de passe: Josette

 Voilà. Si vous êtes bien connecté avec le compte de Josette Richard, l'installation est réussie et vous pouvez maintenant commencer à développer !  
(Si vous tombez sur l'erreur: `Could not find the driver` alors c'est probablement parce que l'extension PDO n'a pas été activé).

## Beta tests
**L'ouverture public des tests officiels pour la version 2.0-beta seront disponibles vers fin 2020.**
Durant le projet il sera demandé à des membres de mouvements ou personnes extérieures au projets, d'aller tester l'application sur différentes versions.
Le site est uploadé toutes les 2 semaines (en fin de sprint) à l'adresse suivante: [kanff.mycpnv.ch](https://kanff.mycpnv.ch)
L'indication de la version de l'application (ainsi que la date de publication) se trouve à coté du logo sur la page, ou dans le fichier `app/version.php`.

## Contact
Ce projet vous intéresse ? Vous avez une question, des encouragements, une suggestion, une remarque, un retour, une critique constructive, sur l'application ou le projet ? Ecrivez nous un email à kanff [ate] protonmail.com en français ou en anglais! *(OpenPGP: `de52d839a9baf0486f6049761500b58971c1047f`)*. Si vous avez un compte GitHub mettez-nous une étoile si vous pensez que le projet en vaut la peine.

## Informations sur le projet
## Gestion du projet
[Repository GitHub](https://github.com/samuelroland/KanFF) | [Projet IceScrum](https://cloud.icescrum.com/p/PWB2AGDC)  
Le repository GitHub est public, mais le projet IceScrum est privé.

## Objectif du projet
Réaliser l'application KanFF afin d'atteindre l'objectif de l'application décrit ci-dessus pour une version `KanFF v1.0` publiée sur GitHub d'ici au **31.12.2020**.
