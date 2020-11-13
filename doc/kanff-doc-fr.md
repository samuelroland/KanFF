
# KanFF  - Documentation technique

## **Table des matières**

## Introduction
TBD

### Cadre, description et motivation

**Le projet KanFF consiste à réaliser une application web.** Celle-ci permettrait de gérer des projets, des tâches et l'organisation du travail en général au sein des collectifs, mouvements, associations ou simples groupes de personnes réalisant des projets. Ce projet est destiné à une utilisation réelle par un nombre important de personnes.

Le projet part de zéro. Le projet est réalisé à l'école pour tout le monde et à la maison pour les personnes qui le veulent.



Ce projet a beaucoup plus de sens et d'utilité que d'autres projets fait durant les cours, puisqu'il est censé apporter une solution à de nombreux problèmes dans la gestion des projets au sein de collectifs ne bénéficiant pas d'outil adapté et étant soumis à diverses contraintes d'investissements des membres et de niveaux de compétences de leurs membres, contrairement au monde professionnel.

Ce projet est réalisé dans le cadre du cours** Projet Web+BDD** au CPNV en informatique en fin de 2ème et début de 3ème année. Le projet sera terminé dans le cadre du cours **Projet à choix en binôme**. C'est un projet assez long en comparaison des autres projets fait au CPNV.



**Mais d'où vient le nom "KanFF" ??**

Bonne question... "Kan" vient de "kanban" car c'est un élément majeur de l'application et "FF" est l'acronyme de "For Future", en référence au mouvement "Fridays For Future" et à tous les noms dérivés "Strike For Future", "Teachers For Future", "Parents For Future", ... D'ailleurs le logo inclut un vu dans la lettre "K" car le vu est le symbole de la tâche terminée.



### Organisation

L'équipe travaille sous les principes de **la méthode Agile Scrum**. Ainsi les rôles pour chaque personne participant à ce projet, il y a un rôle attribué, selon les trimestres:


**Team Trimestre 8 (Projet Web BDD, 7 * 45min par semaine):**

   * Samuel: Product Owner et développeur
   * Simon: développeur et Scrum Master remplaçant
   * Luis: développeur
   * Benoît: développeur
   * Miguel: développeur
   * Kevin: développeur
   * M. Ithurbide: Scrum Master + aide technique et conseils
   * M. Carrel: Aide technique et conseils


**Team Trimestre 9 (Projet Web BDD, 5 * 45min par semaine):**

   * Samuel: Product Owner et développeur
   * Luis: développeur
   * Benoît: développeur
   * Miguel: développeur
   * M. Ithurbide: Scrum Master + aide technique et conseils
   * M. Carrel: Aide technique et conseils


**Team Trimestre 10 (Projet à choix en binôme, 9 * 45min par semaine):**

   * Samuel: Product Owner et développeur
   * Benoît: développeur




#### Découpage

Le projet étant relativement long, il est découpé en 3 parties. L'unité de temps est le sprint qui correspond à un cycle de 2 semaines pour nous, étant une petite équipe.

   1. **Trimestre 8: 6 semaines** (3 sprints) de travail à 6 personnes pour le cours "Projet Web+BDD" entre le 27.04.2020 et le 05.06.2020 pour une release significative "**Beta 1.0**".
   1. **Trimestre 9: 8 semaines** (4 sprints) de travail à 4 personnes pour le cours "Projet Web+BDD" entre le 22.06.2020 et le 13.11.2020 pour une release significative "**Beta 2.0**".
   1. **Trimestre 10: 8 semaines** (4 sprints) de travail à 2 personnes pour le cours "Projet à choix en binôme" entre le 16.11.2020 et 31.01.2021 pour une release significative "**1.0**" qui sera une version de rproduction donc utilisable.
Ces parties correspondent au temps de cours. Durant les vacances et à d'autres moments, du travail est également fourni par une partie des participants.



### Objectifs



L'application doit pouvoir **gérer des projets, gérer des tâches**, la répartition du travail, planifier des projets, **des réunions et des événéments**, gérer les **membres** et les **groupes**, ... afin de **collaborer à plusieurs sur des projets**, avoir une **vision d'ensemble large** (de tous les projets, travaux, tâches, événements, groupes et utilisateurs du collectif), de mieux répartir la charge de travail, d'inclure de nouvelles personnes et les personnes moins engagées.

Toute la gestion des tâches se fait à l'aide d'un kanban. Chaque projet a son propre kanban qui est découpé horizontalement en travaux et verticalement en 3 colonnes (A faire, En cours, Terminé). Chaque travail contient des tâches qui sont dans une des 3 colonnes.



L'application se veut **polyvalente** et devrait pouvoir être utilisée dans des collectifs de différentes tailles, structures et objectifs, organisation du travail et réalisant des projets de nature différente, ... Elle doit être **simple d'utilisation** mais ne doit pas être basique. Elle doit être **intuitive **et compréhensible avec le moins possible de documentation. L'accent est mis sur la page Kanban puisque c'est la page principale.



## Analyse



Quand un collectif utilise l'application, les membres du collectif ont un compte et rejoignent des groupes. Les groupes réalisent 0, 1 ou plusieurs projets (les projets sont réalisés par un ou plusieurs groupes).



Chaque projet a un kanban et est divisé en parties appelées "travaux". Ceux-ci contiennent des tâches relatives à ce travail.

La gestion de toutes ces tâches dans les différents travaux et projets se fait collaborativement à travers le kanban et les détails du projet. Les événements importants relatifs à un projet sont consignés par les membres dans un journal de bord.



L'application doit être compatible avec l'ensemble des navigateurs standards : Mozilla Firefox, Safari, Google Chrome.



### Modèle Conceptuel de Données

En français:

![MCD GitHub](https://raw.githubusercontent.com/samuelroland/KanFF/master/doc/MCD-KanFF-official.png)

### Modèle Logique de Données

En anglais:
![MLD GitHub](https://raw.githubusercontent.com/samuelroland/KanFF/master/doc/MLD-KanFF-official.png)



## Stratégie de test

Afin de récolter des retours et idées d'améliorations, il sera demandé à des personnes extérieures dans la familles et les ami-e-s, ainsi qu'à des membres de collectifs, d'aller tester l'application et de faire un retour.

Moyens mis en place:

   * **Un formulaire de feedback intégré** à l'application est implémenté permettant de donner un retour relatif à une page. Ce formulaire peut être désactivé ou activé dans le .const.php. A chaque feedback envoyé, le texte ainsi que d'autres information sur le navigateur, la page et l'application sont envoyées par email.
[formulaire de feedback]

   * **Un pack de données "Collectif Assoc Vaud"** (nom d'un collectif imaginaire aux objectifs vagues) est créé ayant des membres, groupes, projets, logs, travaux et tâches (ainsi que les tables join et participate). Ces données sont fictives (tout comme le collectif) mais doivent être en partie réaliste (cela pourrait être un cas réel). Le reste des données peut être générés de manière moins réalistes avec de l'aléatoire plus ou moins intelligent (avec diverses conditions rendant plus réalistes), et également du texte de remplissage (lorem ipsum) afin de simuler des petites et grandes quantités de textes (avec le moindre effort).
       * Dans ce pack, les membres données en exemple et pour tester l'application sont les 3 suivants: "Josette Richard (JRD)" admin, "Mégane Blan (MBN)" membre approuvée et "Vincent Rigot (VRT)" membre banni. Le projet contenant des données réalistes est le projet "**Crowdfunding Festival 2020**". Josette Richard est dans le projet et Mégane Blan est à l'extérieur (permettant ainsi de tester les différences entre l'intérieur et l'extérieur d'un projet)
       * Ce pack est chargeable en lançant le fichier `KanFF\db\db-manage\restore-db-kanff.bat` (ou en lancant les 2 fichiers SQL (voir readme.md), mais ne fonctionnent que si la base de donnée s'appelle "kanff"). Le fichier bat prend en compte d'autres noms de base de données.
       * Ce pack est généré à l'aide du script de génération **generationData.php** et se base sur les données écrites à la main dans les fichiers **basic-data-*.json** (* = nom de la table. Fichiers dit "basiques".). Le script de génération complète les données manquantes de celles fournies dans les fichiers de données basiques et en génère d'autres complétement aléatoire parfois (notamment pour les tâches). (Pour créer un pack pour un autre collectif imaginaire, il suffirait de changer ces fichiers basiques et de relancer le script, puis d'exporter la base de données en SQL).
       * Le pack contient 100 membres, 13 groupes, 16 projets, 300 tâches (36 réalistes et le reste en lorem ipsum), 25 travaux (9 réalistes et le reste en lorem ipsum), 12 logs, et un nombre aléatoire de join et de participate.
   * Des tests rapides des fonctionnalités sont fait durant le développement par les développeur·euse·s et durant les sprint review pour les tests d'acceptation. Les fonctionnalités sont testées dans un cadre normal (utilisation standard) et aussi un peu en modifiant du code HTML et les requêtes HTTP, afin d'y insérer des valeurs qui doivent être validées et refusées si invalides (le javascript empêchant de le faire directement sur le formulaire parfois).
   * Test unitaires des fonctions du CRUDModel.php: testé avec `testCRUDmodel` dans différents contextes.


**Tests et demandes de feedback extérieurs.**

       * **L'instance de test**: Afin de montrer et faire tester l'application, KanFF sera déployé sur une instance chez SwissCenter prêtée par le CPNV.  Le pack Collectif Assoc Vaud y est chargé. A chaque release l'instance est mise à jour et la base de données également. Un sous dossier temp est créé pour y uploader une version temporaire de l'application mise à jour fréquemment durant les périodes de tests pour permettre aux personnes qui testent de tester la version la plus récente (même si cela peut ne pas être stable, il est profitable de faire tester avec les toutes dernières améliorations qui ont été effectuées après la dernière release).
           * Instance: kanff.mycpnv.ch
           * Version plus récente temporaire: kanff.mycpnv.ch/temp/.


Cela se passe en 3 phases:

       * 1ère phase: 2 semaines avant la version 2.0 beta des premiers retours sont demandés à 6 personnes dans l'entourage proche, afin de ne pas réaliser des fonctionnalités inutiles ou de faire des grosses erreurs de conception quand à la gestion des projets et le reste des features.
       * 2 ème phase: 1 semaine après la bêta 2.0, il sera demandé de faire à 10-15 personnes un retour approfondi de chaque page avec un accent sur la conception (en posant notamment des questions précises et plus vagues). Il y aura un moment pour corriger et améliorer selon les retours, avant de passer à la phase 3.
       * 3 ème phase: Début décembre 2020, plusieurs collectifs seront informés de l'existence de l'application, de l'état du projet et pourront aller tester dans le but de voir si elle est adaptée à leur collectif et également faire des retours plus courts.
   *

## Implémentation

### Vue d’ensemble

Cette section décrit comment le système à réaliser interagit avec son entourage, en termes :

·         D’utilisateur(s) humain(s)

·         D’utilisateur(s) logiciel(s) (clients d’une API, par exemple)

·         De réseau

·         De ressources externes

Pour l'instant, une instance KanFF ne peut contenir qu'un seul collectif. Chaque membre du collectif sur une instance doit se créer un compte pour accéder au collectif. Aucune donnée de projet, tâches, groupes, membres, ... n'est publique. Seule la page A propos est publique et contient des informations à propos du collectif, de l'instance et de KanFF.

L'application web s'utilise avec un navigateur via l'url du serveur sur lequel est installé l'application. Une connexion internet active est requise pour charger les pages et effectuer des actions. L'application est adaptée à une utilisation sur ordinateur mais pas sur smartphone ni tablette. Le site n'est pas assez responsive et aucun test ne sera fait pour les navigateurs web mobile.



### Description technique

KanFF est une application web développée **en PHP** (HTML + CSS + Javascript + Ajax) **en MVC (Model View Controler)** avec une **base de données MySQL**. Les dépendances [npm](npmjs.com) utilisées sont bootstrap et jquery.



### Points techniques spécifiques
   1. **Stockage des dates:** Dans la base de données toutes les dates sont stockées en format DateTIme, peut importe si ce qui est affiché est précis à la minute ou la seconde (format naturel Date/Heure) ou alors précis au jour (format naturel Date).
   1. **Structure du repos:** Le [repository GitHub](github.com/samuelroland/KanFF) contient les éléments suivants
   * **PVs**: Procès Verbaux des réunions (pour les sprints reviews mais pas pour les sprints retrospectives)
   * **app**: le dossier contenant l'application, c'est le dossier racine du serveur
   * **db**: fichiers concernant la structure de la base de données (sources du MCD et MLD), la génération de données et les packs de données, ainsi qu'une documentation technique sur la base de données (signification des champs) appelée "records-management.md".
   * **doc**: les fichiers de documentations les plus importants (MCD + MLD + kanff-doc-fr.md + list-pages.md)
   * **ressources**: création et export des maquettes, fichiers du logo, réflexion en cours.
   * **.gitignore**: fichier standardisé par git qui contient la liste des fichiers ignorés
   * **Journal.md**: Journal de bord du projet qui contient tous les événements importants et également les conclusions des sprints retrospectives.
       1. **README.md**: fichier "Lisez-moi" expliquant ce qu'est KanFF, qui contient le logo, ainsi que des informations pour l'installation pour le développement et pour une instance de production.
   1. **Validation des actions importantes**: Afin de valider les actions importantes, comme la création ou la suppression d'un projet, d'un groupe, d'un compte, ... (liste non exhaustive), il est demandé, pour effectuer ces actions, de saisir son mot de passe. Ceci afin d'empêcher une action involontaire, une action d'une personne malveillante sur une session laissée ouverte sans surveillance, ou l'action de personnes malveillantes sur à un vol de cookies (identification possible avec les cookies mais mot de passe inconnu). Voir fonction checkUserPassword() ci-dessous.
   1. **Valeurs booléennes**: le type BOOL n'était pas pris en charge par MySQL, toutes les valeurs booléennes sont manipulées en type TINYINT (1bit donc valeurs possibles sont 0 ou 1) et ne sont pas converties (il n'y a pas de changement de type TINYINT vers BOOL et inversément). Dans toute l'application toutes les valeurs en TINYINT valant 0 signifie false et celles valant 1 signifient true. (Attention à ne pas mélanger avec les valeurs INT, par ex. users.state qui peut valoir de 0 à 8).
   1. **3 fichiers de fonctions d'aides (fichier help): **helpers.php (fonctions générant du contenu commun), help.php (fonctions contrôleur communes), global.js (fonctions JS communes). Toutes ces fonctions sont décrites dans un document séparé [ici](doc/helpers-functions.md).
   1. **Login**: il est possible de se connecter avec un email, un nom d'utilisateur ou des initiales. Ces 3 valeurs sont donc uniques dans la base de données.
   1. **Génération unique des initiales**: Les initiales sont toujours stockées en majuscules. Le premier format est "première lettre du prénom + première lettre du nom + dernière lettre du nom" et le deuxième est "première lettre du prénom + première lettre du nom + deuxième lettre du nom". Si le premier format ne permet pas l'unicité, alors le 2ème format est appliqué. Si ce n'est toujours pas unique, il y a n'a pas d'autres formats prévus et la création du compte ne peut pas se faire... Cest la fonciton `getUniqueInitials($firstname, $lastname)`qui s'en occupe.
   1. **Champs INT et constantes: **La base de données contenant de nombreux champs de type INT stockant diverses valeurs ayant une signification, il est indispensable de prévoir un moyen pratique pour développer sans connaître les valeurs INT mais uniquement en s'adaptant à leur signification, et pouvoir changer ou rajouter une nouvelle valeur en changeant uniquement le code dans un fichier help. Ceci concerne les champs state, type, visibility et need\_help notamment.  
       1. On définit des constantes PHP dans le fichier helpers.php:
       * define("TASK\_STATE\_TODO", 1);
       * define("TASK\_STATE\_INRUN", 2);
       * define("TASK\_STATE\_DONE", 3);
       1. Puis on définit une autre constante liste: `define("TASK\_LIST\_STATE", [*TASK\_STATE\_TODO*, *TASK\_STATE\_INRUN*, *TASK\_STATE\_DONE*]);`
       1. Puis on crée aussi une fonction qui va permettre de traduire les valeurs dans leur signification en français: `function convertTaskState($int, $needFirstCharToUpper = false)`
       1. Ainsi quand on reçoit les valeurs de la base de données ou d'ailleurs en INT et qu'on veut avoir la significatione en français (pour l'afficher par ex), on appelle `convertTaskState($task['state'])`pour avoir "en cours" par ex.
       1. Dans le code on utilise jamais les valeurs brut (1, 2, 3, ...) on utilise uniquement les constantes (par ex. un if `if ($task['state'] == TASK\_STATE\_DONE)` et pas `if ($task['state'] == 3)`).
   1. **Mode debug:** le mode debug permet d'afficher les var\_dump() lancés par un remplacement `function displaydebug($var, $needPrint\_r = false)`. la variable $debug dans .const.php doit être définie à true pour que les var\_dump() s'affichent. Ce qui est très pratique pour faire du debug sans impacter le code utile pour tout le monde et pour la production.
   1. **CRUDModel.php: **ce fichier implémente une série de fonctions permettant d'effectuer des actions CRUD (Create Read Update Delete) avec la base de données. Des fonctions getAll(), getOne(), Query(), getByCondition, createOne(), updateOne(), deleteOne() sont implémentées afin de ne plus devoir gérer PDO dans d'autres fichiers model et pouvoir souvent éviter d'écrire du SQL quand la requête est "standard".
   1. Le fichier .const.php des informations pour la base de données ainsi que d'autres configurations propres aux machines.
   1. L'extension PDO est utilisée pour faire les requêtes SQL sur la base de données MySQL. L'extension doit être activée dans le fichier php.ini. (voir installation).


### Livraisons

Identification, date et raison de chaque livraison formelle effectuée au cours du projet.

Il y a 3 publications majeures et d'autres petites entre deux. Une publication est faite à la fin de chaque sprint sur GitHub.

[livraisons]



### Erreurs restantes  

Les erreurs décrites ci-dessous concernent la version actuellement implémentée uniquement sur les stories terminées. (Les stories en cours contenant des tonnes d'erreurs dû au manque de temps):

   * Les initiales devraient avoir d'autres formats possible et mieux avertir l'utilisateur du problème.
   * Il y a des erreurs dans la console JS dû à une déclaration des événements sur chaque page au lieu de pages ciblées.
   * Le texte d'explications des fonctionnalités est parfois trop long et mal écrit. Il faudrait le réécrire en demandant des avis extérieurs.
   * Le menu n'est pas responsive et ne s'adapte pas sur écran restreint. Il est cassé et la plupart des boutons deviennent invisible. Il faudrait gérer les options et l'affichage du menu pour les écrans moins larges.

## Conclusions

Cette conclusion est faite à la fin du module Projet Web+BDD et l'état des lieux ne concerne donc que ce moment là.

Développez en tous cas les points suivants:

### Objectifs atteints:
* Gestion des membres basiques (création compte, connexion, changement d'état),
* Début de la gestion des projets (kanban, détails d'un projet)

### Objectifs non-atteints:

   * Gestion des groupes (juste liste des groupes en cours et créer un groupe encore en cours) manquant.
   * Gestion complète des membres (édition du compte, détails d'un membre, ...) pas terminés.
   * Gestion des projets (projets, travaux et tâches).
--> slt possible pour 1 collectif.


## Annexes

### Sources – Bibliographie

Liste des livres utilisés (Titre, auteur, date), des sites Internet (URL) consultés, des articles (Revue, date, titre, auteur)… Et de toutes les aides externes (noms)

- php.net

- stackoverflow.com

- w3schools.com

- M. Carrel pour aide et conseils

- M. Ithurbide pour les conseils en gestion de projet.


### Journal de bord du projet

Le journal de bord se trouve sur GitHub à l'adresse suivante: [https://github.com/samuelroland/KanFF/blob/master/Journal.md](https://github.com/samuelroland/KanFF/blob/master/Journal.md)
