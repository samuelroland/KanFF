# KanFF
Une application web de gestion de projets, de tâches, et d'organisation du travail, conçu pour le milieu militant et associatif.

## Gestion du projet:
[Repository GitHub](https://github.com/samuelroland/KanFF) | [Projet IceScrum](https://cloud.icescrum.com/p/PWB2AGDC)
Le repository GitHub est public, mais le projet IceScrum est privé.

## Contexte d'utilisation
L'application est prévue pour être utilisée par des membres d'associations, d'organisations, de mouvemements, de collectifs, ou de simples groupes militants,... L'application se veut polyvalente et devrait permettre d'être utilisée dans des groupes de différentes tailles et structures, ayant différentes organisations du travail et réalisant des projets différents, ...

## Objectif de l'application
L'objectif est de pouvoir gérer: différents projets, des tâches, la répartition du travail, la planification des projets, les réunions, les membres, les groupes, les événéments, ... Afin de permettre de mieux répartir la charge de travail, d'inclure les personnes nouvelles dans des groupes, d'inclure les personnes moins engagées. Mais aussi permettre de récolter du feedback, de mieux connaître d'un groupe et leur niveau d'activité, ou encore prendre les avis pour prendre des décisions rapidement.

## Installation (pour une instance KanFF)
Sous le dossier `Ressources` il y a un `server-setup.cmd` qui permet de copier le template `.const.php.example` dans le dossier `app`.

### Matériel et logiciels nécessaires:
1. Un serveur Php
1. Un serveur MySQL

Procédure d'installation et de configuration:
1. Lancer le `server-setup.cmd`
1. Lancer un serveur php en local dans le dossier `app` sur un port non occupé. Par exemple en faisant `php -S localhost:8080` ou créer un "Php builtin server" dans un IDE.
1. Démarrer un service MySQL.
1. Créer un utilisateur pour la base de donnée nommée `kanff` avec les droits dont il a besoin. 
1. Aller dans `app` et remplissez les valeurs dans le `.const.php` (le mode debug et les identifiants de connexion à la base de données avec l'utilisateur précèdemment créé).
1. Lancer le `npm install.cmd` pour installer les packages de npm. ou alors tapez la commande `npm install` dans le dossier `app`.
1. Ouvrez un navigateur web à l'adresse: `localhost:8080`. Le site est accessible et fonctionne.

## Installation (pour développement)


## Beta tests
Durant le projet il sera demandé à des membres de mouvements d'aller tester l'application sur différentes versions.
Le site est uploadé toutes les 2 semaines (en fin de sprint) à l'adresse suivante: [kanff.mycpnv.ch](kanff.mycpnv.ch)
L'indication de la version de l'application (ainsi que sa date de version) se trouve à coté du logo sur la page, ou dans le fichier `app/VERSION.php`.