<!--/**
 *  Project: KanFF
 *  File: kanff-doc-fr.md technical doc of KanFF (export from Framapad file)
 *  Author: Samuel Roland
 *  Relecture: Benoît Pierrehumbert
 *  Creation date: 24.06.2020
 */ -->
# KanFF
![kanff logo](https://raw.githubusercontent.com/samuelroland/KanFF/master/app/view/medias/logos/KanFF_Logo_background.png)

## Une application web (opensource) de gestion de projets, de tâches, et d'organisation du travail, conçue pour le milieu militant et associatif.
### Structure de l'application
Quand un collectif utilise KanFF, les membres du collectif ont un compte et rejoignent des groupes. Les groupes réalisent 0, 1 ou plusieurs projets (les projets sont réalisés par 1 ou plusieurs groupes).

Chaque projet a un kanban et est divisé en parties appelées "travaux". Ceux-ci contiennent des tâches relatives à ce travail.
La gestion de toutes ces tâches et travaux dans les différents projets se fait collaborativement à travers le kanban et les détails du projet. Les événements importants relatifs à un projet sont consignés par les membres dans un journal de bord.

Le kanban du projet `Crowdfunding Festival 2020` pour le collective fictif `Collectif Assoc Vaud`.  
![readme-kanban-example.PNG](doc/img/readme-kanban-example.PNG)

Les détails d'une tâche 1 sur le kanban du projet `Crowdfunding Festival 2020` pour le collective fictif `Collectif Assoc Vaud`.  
![readme-task-details-example.png](doc/img/readme-task-details-example.PNG)

## Contexte d'utilisation
L'application est pensée pour être utilisée par **des membres de collectifs, d'organisations, de mouvements, d'associations ou de simples groupes ayant des projets communs.**  
L'application se veut **polyvalente** et devrait pouvoir être utilisée dans des groupes de différentes tailles, structures, objectifs et organisation du travail, et réalisant des projets de nature différente, ...
*Pour l'instant, une instance KanFF ne peut pas héberger plusieurs collectifs*.

## Objectif de l'application
L'application doit permettre de **gérer des projets, gérer des tâches**, la répartition du travail, planifier des projets, gérer les **membres** et les **groupes**, ... afin de **collaborer à plusieurs sur des projets**, avoir une **vision d'ensemble large** (de tous les projets, travaux, tâches, groupes et membres du collectif), de mieux répartir la charge de travail, d'inclure de nouvelles personnes et aussi les personnes moins engagées.

### Publications prévues (releases)
- KanFF Beta v1.0, le 19.06.2020
- KanFF Beta v2.0, le 13.11.2020
- **KanFF v1.0**, le 15.12.2020
D'autres petites publications sont faites entre ces grosses publications à la fin de chaque sprint (0.1-beta, 0.2-beta, 1.1-beta, 1.2-beta, 2.1-beta, 2.2-beta).

<p style="color: #f66232"><em>L'application n'est pas responsive pour le moment, alors utilisez la en plein écran sur ordinateur.</em></p>
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
- Avoir un service `Php` et `MySQL` installé et pouvoir les atteindre dans un shell (tester `php -v` et `mysql -v` pour vérifier. Vérification réussie si la commande est reconnue... Cela sera utile pour la mise à jour de la base de données et l'exécution des tests unitaires). 
- Avoir l'extension **PDO** et **OpenSSL** activée sur le serveur Php (changer `;extension=pdo_mysql` par `extension=pdo_mysql` et `;extension=openssl` par `extension=openssl` dans le fichier `php.ini` ou vérifier que c'est déjà fait).
- Avoir [`NPM`](https://www.npmjs.com/get-npm) installé

### Procédure:
1. **Récupérer le repository** depuis GitHub (clone ou téléchargement `.zip`) (exemple de clone dans un shell dans le dossier `C:/Alice/Documents/GitHub/`)

        C:
        cd C:/Alice/Documents/GitHub/
        git clone https://github.com/samuelroland/KanFF

1. Ouvrir un shell et **installer les dépendances** avec NPM  dans le dossier `app` ! Un dossier `node_modules` et un fichier `package-lock.json` apparaissent.

        cd app
        npm install

1. Démarrer le service MySQL. Se connecter (avec un client SQL par ex.) en compte `root`. Executer le fichier `db/db-manage/create-db-kanff.sql`, ce qui a pour effet de **créer la base de données** `kanff` et ses tables. Ensuite **créer un nouvel utilisateur** (nommé dans ici `kanffApp` avec `Pa$$w0rd` pour mot de passe) et lui donner accès à la base de données `kanff` précédemment créée. Se connecter au nouvel utilisateur afin de vérifier qu'il a bien été créé et qu'il accède à la base de données `kanff`.
1. Aller dans `app`. Dupliquer le fichier `.const.php.example` et renommer le en `.const.php`.
1. Démarrer un IDE à la racine du repository. Modifier les valeurs du fichier `.const.php` afin d'**inscrire les identifiants** de connexion à la base de donnée (4 valeurs + un cartouche).

        $user = "kanffApp";
        $pass = "Pa\$\$w0rd";   //Caractères spéciaux php doivent être précédé de \
        $dbhost = "localhost";
        $dbname = "kanff";

1. Lancer le fichier `db/db-manage/restore-db-kanff.bat` (ou alors lancer la commande `php -f restore-db.php` dans `db/db-manage/`) afin d'**insérer les données** du pack "Collective Assoc Vaud". La base de données est maintenant créée. Ce script .bat est utile pour restaurer très rapidement la base de données lors du développement ou de tests.
1. Démarrer un serveur PHP **dans le dossier `app`** (pas le dossier racine du repository!) sur un port libre (ici 8080).
1. **Ouvrir un navigateur web** sur l'adresse localhost et le port choisi: `localhost:8080`.
1. **Validation**: L'installation est terminée lorsque le site s'affiche correctement dans le navigateur (page de login affichée et style CSS semblable à la version du [serveur de tests](https://kanff.mycpnv.ch)) et lorsque que le login fonctionne. Tester avec les identifiants suivants:
       
        initiales: JRD
        mot de passe: Josette

Voilà. Si vous êtes bien connecté avec le compte de Josette Richard, l'installation est réussie et vous pouvez maintenant commencer à développer !  
(Si vous tombez sur l'erreur semblable à celle-ci: `Could not find the driver` alors c'est probablement parce que l'extension PDO n'a pas été activé).

## Beta tests
Durant le projet il sera demandé à des membres de différentes organisations ou personnes extérieures au projets, d'aller tester l'application sur différentes versions.
L'application est mise à jour toutes les 2 semaines (en fin de sprint) sur l'instance de tests : [kanff.mycpnv.ch](https://kanff.mycpnv.ch)
L'indication de la version de l'application (ainsi que la date de publication) se trouve à côté du logo sur la page, ou dans le fichier `app/version.php`.

## Contact
**Cette application vous intéresse ?** Vous avez des questions, des suggestions, des remarques, des critiques constructives, sur l'application ou le projet ? Vos idées nous intéressent ! Écrivez-nous à kanff[ate]pm.me en français ou en anglais. *(OpenPGP: `de52d839a9baf0486f6049761500b58971c1047f`)*. Si vous avez un compte GitHub mettez-nous une étoile !

## Informations sur le projet
### Documentations
Les documentations sont pour certaines en cours d'écriture ou incomplète...
#### Documentation utilisateur
- [Documentation utilisateur](doc/kanff-doc-user-fr.md)

#### Documentation technique
- [Documentation technique globale](doc/kanff-doc-fr.md)
- [Liste des pages (prévues et réalisées)](list-pages.md)
- [Fonctions d'aide](helpers-functions.md)
- [Spécifications de la base de données](db-specifications.md)
- [Structure des appels Ajax](structure-ajax-calls.md)

### Avancement du projet
Le projet a commencé le 23.04.2020 et est toujours en cours. Il n'y a pas encore de version assez complète pour être utilisable (uniquement des versions bêta). La première version utilisable (`v1.0`) est prévue pour le 29.01.2020 (il est possible qu'il y ait du retard). Il y a actuellement beaucoup de petits bogues et de fonctionnalités commencées et non terminées.

### Contributions
Si vous êtes intéressé·e à contribuer, nous nous en réjouissons. Nous n'avons pas encore de lignes directrices pour les contributions, alors n'hésitez pas à nous envoyer un email pour nous motiver à les écrire (et nous dire au passage sur quoi vous aimeriez aider : code, documentation, design, autres) ... Vous pouvez sans hésiter ouvrir une issue également.

### Feuille de route
Fonctionnalité prévues pour la version `v1.0` (~29.01.2020) :
- Gestion des membres
- Gestion des groupes
- Gestion des projets (inclut projets, travaux, tâches, groupes participants et journaux de bord)

Fonctionnalité prévues pour les versions **après** la `v1.0` (pas de date définie pour l'instant) :
- Gestion des collectifs (plusieurs collectifs par instance)
- Gestion des événements (dans un calendrier)
- Gestion notifications
- Gestion des compétences

### Gestion du projet
[Repository GitHub](https://github.com/samuelroland/KanFF) | [Projet IceScrum](https://cloud.icescrum.com/p/PWB2AGDC)  
Le repository GitHub est public, mais le projet IceScrum est privé. Le projet est géré selon la méthodologie Scrum et des sprints sont fait toutes les 2-3 semaines (une publication est faite aussi à la fin des sprints).

### Objectif du projet
Réaliser l'application KanFF permettant la gestion des membres, groupes et projets, pour une version `KanFF v1.0` publiée sur GitHub.
