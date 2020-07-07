# KanFF

![kanff logo](https://raw.githubusercontent.com/samuelroland/KanFF/master/ressources/logo/exports/KanFF_Logo.svg)

### Une application web de gestion de projets, de tâches, et d'organisation du travail, conçue pour le milieu militant et associatif.

## Gestion du projet:
[Repository GitHub](https://github.com/samuelroland/KanFF) | [Projet IceScrum](https://cloud.icescrum.com/p/PWB2AGDC)
<br>Le repository GitHub est public, mais le projet IceScrum est privé.

## Contexte d'utilisation
L'application est prévue pour être utilisée par des membres d'associations, d'organisations, de mouvemements, de collectifs, ou de simples groupes militants,... L'application se veut polyvalente et devrait permettre d'être utilisée dans des groupes de différentes tailles et structures, ayant différentes organisations du travail et réalisant des projets différents, ...

## Objectif de l'application
L'objectif est de pouvoir gérer: différents projets, des tâches, la répartition du travail, la planification des projets, les réunions, les membres, les groupes, les événéments, ... Afin de permettre de mieux répartir la charge de travail, d'inclure les personnes nouvelles dans des groupes, d'inclure les personnes moins engagées. Mais aussi permettre de récolter du feedback, de mieux connaître d'un groupe et leur niveau d'activité, ou encore prendre les avis pour prendre des décisions rapidement.

## Installation (pour une instance KanFF)
Résumé:
1. Récupération du repos et installation des dépendances
1. 



## Installation (pour développement)
### Résumé:
- Avoir un service php et mysql installé et pouvoir les atteindre dans un shell (tester `php -v` et `mysql -v` pour vérifier. Vérification réussie si la commande est reconnue... Cela sera utile pour la mise à jour de la base de données et l'éxecution des tests unitaires).

1. Récupération du repos et installation des dépendances
1. Configuration pour la base de données
1. Configuration pour le serveur PHP
1. Gestion de la base de donnée
1. Vérification

### Détails des opérations:

1. Récupérer le repository depuis GitHub (clone ou téléchargement `.zip`) (exemple de clone dans un shell dans le dossier `C:/Alice/Documents/GitHub/`)
        
        cd C:/Alice/Documents/GitHub/
        git clone https://github.com/samuelroland/KanFF


1. Ouvrir un shell et installer les dépendances avec `npm` (téléchargement de npm depuis [npmjs.com](https://www.npmjs.com/get-npm)) dans le dossier `app` !

        cd app
        npm install

1. Démarrer le service MySQL. Se connecter (avec un client SQL par ex.) en compte `root`. Lancer le fichier `db/db-manage/create-db-kanff.sql`, ce qui a pour effet de créer la base de données `kanff` et ses tables. Créer ensuite un nouvel utilisateur (nommé dans ce document `kanffApp` avec `Pa$$w0rd` pour mot de passe) et lui donner accès à la base de données `kanff` précédemment créée. Se connecter au nouvel utilisateur afin de vérifier qu'il a bien été créé et qu'il accède à la base de données `kanff`.
1. Aller dans `app`. Dupliquer le fichier `.const.php.example` et renommer le en `.const.php`.
1. Démarrer un IDE à la racine du serveur.


## Beta tests
**L'ouverture public des tests officiels pour la version 2.0-beta seront disponibles vers fin 2020.**
Durant le projet il sera demandé à des membres de mouvements ou personnes extérieures au projets, d'aller tester l'application sur différentes versions.
Le site est uploadé toutes les 2 semaines (en fin de sprint) à l'adresse suivante: [kanff.mycpnv.ch](https://kanff.mycpnv.ch)
L'indication de la version de l'application (ainsi que la date de publicaiton) se trouve à coté du logo sur la page, ou dans le fichier `app/version.php`.