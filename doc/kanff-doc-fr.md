
# KanFF  - Documentation

## Table des matières

   1. Introduction
       1.   Cadre, description et motivation
       1.   Organisation
       1.   Objectifs
   1. Analyse
       1. Modèle Conceptuel de Données
       1. Stratégie de test
   1. Implémentation
       1. Vue d’ensemble
       1. Points techniques spécifiques
           1. Point 1
           1. Point 2
           1. Point …
       1. Livraisons
       1. Erreurs restantes
   1. Conclusions
   1. Annexes
       1. Sources – Bibliographie
       1. Journal de bord du projet


## Introduction



### Cadre, description et motivation

**Le projet KanFF consiste à réaliser une application web.** Celle-ci permettrait de gérer des projets, des tâches et l'organisation du travail en général au sein des collectifs, mouvements, associations ou simples groupes de personnes réalisant des projets. Ce projet est destiné à une utilisation réelle par un nombre important de personnes.

Le projet part de zéro. Le projet est réalisé à l'école pour tout le monde et à la maison pour les personnes qui le veulent.



Ce projet a beaucoup plus de sens et d'utilité que d'autres projets fait durant les cours, puisqu'il est censé apporter une solution à de nombreux problèmes dans la gestion des projets au sein de collectifs ne bénéficiant pas d'outil adapté et étant soumis à diverses contraintes d'investissements des membres et de niveaux de compétences de leurs membres, contrairement au monde professionnel.

Ce projet est réalisé dans le cadre du cours** Projet Web+BDD** au CPNV en informatique en fin de 2ème et début de 3ème année. Le projet sera terminé dans le cadre du cours **Projet à choix en binôme**. C'est un projet assez long en comparaison aux autres projets fait au CPNV.



Mais d'où vient le nom "KanFF" ??

Bonne question... "Kan" vient de "kanban" car c'est un élément majeur de l'application. et "FF" est l'acronyme de "For Future", en référence au mouvement "Fridays For Future" et à tous les noms dérivés "Strike For Future", "Teachers For Future", "Parents For Future", ... On peut donc quasiment traduire par Kanban For Future.

D'ailleurs le logo inclut un vu dans la lettre "K" car le vu est le symbole de la tâche terminée.



### Organisation

L'équipe travaille sous les principes de la méthode Agile Scrum. Ainsi sont découpés les rôles pour chaque personnes participant à ce projet.

#### 6 participant.e.s:

Élève 1 : Samuel Roland: **Product Owner** et Dev

Élève 2 : Benoît Pierrehumbert: Dev

Élève 3 : Simon Cuany: Dev

Élève 4 : Kevin Vaucher: Dev

Élève 5 : Luís Pinheiro: Dev

Élève 6 : Miguel Soares: Dev

Prof 1: Julien Ithurbide: **Scrum Master**

Prof 2: Xavier Carrel: Aide technique et conseils

Responsable de projet : ???



#### Découpage

Le projet étant relativement long, il est découpé en 3 parties. L'unité de temps est le sprint qui correspond à un cycle de 2 semaines pour nous, étant une petite équipe.

   1. **6 semaines** (3 sprints) de travail à 6 personnes pour le cours "Projet Web+BDD" entre le 27.04.2020 et le 05.06.2020 pour une release significative "**Beta 1.0**".
   1. **8 semaines** (4 sprints) de travail à 4 personnes pour le cours "Projet Web+BDD" entre le 22.06.2020 et le 13.11.2020 pour une release significative "**Beta 2.0**".
   1. **8 semaines** (4 sprints) de travail à 2 personnes pour le cours "Projet à choix en binôme" entre le 16.11.2020 et le YYYYYY pour une release significative "**1.0**" qui sera une version officielle et utilisable.
Ces parties correspondent au temps de cours. Durant les vacances et à d'autres moments, du travail est également fourni par une partie des participant.e.s.



### Objectifs

Ce chapitre énumère les objectifs généraux du projet. A ce stade, ces objectifs ne sont pas nécessairement SMART  Il est par exemple acceptable d’avoir un objectif du genre « L’application doit être très réactive » ; un tel objectif n’est pas mesurable mais il indique qu’une attention particulière doit être portée à la performance.

Les objectifs pourront éventuellement être revus après l'analyse

Ces éléments peuvent être repris et complétés à partir de la fiche signalétique ou du cahier des charges.



L'application doit pouvoir **gérer des projets, gérer des tâches**, la répartition du travail, planifier des projets, **des réunions et des événéments**, gérer les **membres** et les **groupes**, ... afin de **collaborer à plusieurs sur des projets**, avoir une **vision d'ensemble large** (de tous les projets, travaux, tâches, événements, groupes et utilisateurs du collectif), de mieux répartir la charge de travail, d'inclure de nouvelles personnes et les personnes moins engagées.

Toute la gestion des tâches se fait à l'aide de grands kanban. Chaque projet a son propre kanban qui est découpé horizontalement en travaux et verticalement en 3 colonnes (A faire, En cours, Terminé). Chaque travail contient des tâches qui sont dans une des 3 colonnes.



L'application se veut **polyvalente** et devrait pouvoir être utilisée dans des groupes de différentes tailles, structures et objectifs, organisation du travail et réalisant des projets de nature différente, ...



## Analyse

L’analyse détaille ce qui va être fait. A quoi va ressembler le produit fini. Comment il va fonctionner.

Elle doit faire l’objet d’une revue avec le client ; on s’assure que l’on a bien compris ce qu’il attend du projet.



L'application doit être compatible avec l'ensemble des navigateurs standards : Mozilla Firefox, Safari,  Google Chrome, Microsoft Edge.



### Modèle Conceptuel de Données

En français:

![MCD GitHub]([https://raw.githubusercontent.com/samuelroland/KanFF/master/ressources/logo/exports/KanFF\_Logo.svg)](https://raw.githubusercontent.com/samuelroland/KanFF/master/ressources/logo/exports/KanFF\_Logo.svg))



### Modèle Logique de Données

En anglais:

![MLD GitHub]([https://raw.githubusercontent.com/samuelroland/KanFF/master/ressources/logo/exports/KanFF\_Logo.svg)](https://raw.githubusercontent.com/samuelroland/KanFF/master/ressources/logo/exports/KanFF\_Logo.svg))



## Stratégie de test

Décrire la stratégie globale de test: 

·         Types de tests et ordre dans lequel ils seront effectués.

·         les moyens à mettre en œuvre.

·         données de test à prévoir (données réelles fournies par le client ?).

·         les testeurs extérieurs éventuels.

Afin de récolter des retours et idées d'améliorations, il sera demandé à un maximum de personnes extérieures.



## Implémentation

### Vue d’ensemble

Cette section décrit comment le système à réaliser interagit avec son entourage, en termes :

·         D’utilisateur(s) humain(s)

·         D’utilisateur(s) logiciel(s) (clients d’une API, par exemple)

·         De réseau

·         De ressources externes

Pour l'instant, une instance KanFF ne peut contenir qu'un seul collectif. Chaque membre du collectif sur une instance doivent se créer un compte pour accéder au collectif. Aucune donnée de projet, tâches, groupes, membres, ... n'est publique.

L'application web s'utilise avec un navigateur via l'url du serveur sur lequel est installé l'application. Une connexion internet active est requise pour charger les pages et effectuer des actions. L'application est adaptée à une utilisation sur ordinateur mais pas sur smartphone ni tablette. Le site n'est pas assez responsive et aucun test ne sera fait pour les navigateurs web mobile.



### Description technique

KanFF est une application web développée **en PHP** (HTML + CSS + Javascript + Ajax) **en MVC (Model View Controler)** avec une **base de données MySQL**. Les dépendances [npm](npmjs.com) utilisées sont bootstrap et jquery.



### Points techniques spécifiques

Cette section contient au minimum deux sous-sections qui décrivent chacune un élément technique précis, qui n’est pas évident et qui sert à comprendre le détail de fonctionnement du système.

Il peut s’agir de :

·         Découpage modulaire

·         Entrées-sorties

·         Pseudo-code ou organigramme (d’application ou de scripts).

·         Diagramme de navigation des pages (site web)

·         Diagramme de séquence

·         Diagramme d’état



   1. **Stockage des dates:** Dans la base de données toutes les dates sont stockées en format timestamp, peut importe si ce qui est affiché est précis à la minute ou la seconde (format naturel Date/Heure) ou alors précis au jour (format naturel Date).
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
   1. **Fichier help.php:** fichier contrôleur pour générer du contenu commun à plusieurs pages. Voici un détail des fonctions créées:
       * checkUserPassword($id, $password): return true/false
           * N'est pas utilisé pour le login
           * Sert à vérifier le mot de passe envoyé, si celui ci correspond bien au mot de passe de l'utilisateur connecté.
           * Est utilisé pour des actions importantes et à grandes conséquences afin de valider l'action.
       * chkLength($string, $max): return true/false
           * Vérifie que la longueur de la chaine envoyée n'est pas plus grande que le maximum donné.
       * chkToTinyint($value) : return 0 ou 1
           * Converti la valeur "on" envoyée par dans un formulaire contenant une case à cocher, en une valeur TINYINT. Si null alors 0 et sinon alors 1.
       * flshmsg($number)
           * Défini le prochain flashmessage avec son numéro


**Attention : Tout ce qui précède doit permettre à une autre personne de maintenir et modifier votre projet sans votre aide!**



### Livraisons

Identification, date et raison de chaque livraison formelle effectuée au cours du projet.

Il y a 3 publications majeures et d'autres petites entre deux. Une publication est faite à la fin de 2 sprints.



### Erreurs restantes  

S'il reste encore des erreurs: 

·         Description détaillée

·         Conséquences sur l'utilisation du produit

·         Actions envisagées ou possibles



## Conclusions

Développez en tous cas les points suivants:

·         Objectifs atteints / non-atteints

·         Comparaison entre ce qui avait prévu et ce qui s’est passé, en termes de planning et (éventuellement) de budget

·         Points positifs / négatifs

·         Difficultés particulières

·         Suites possibles pour le projet (évolutions \& améliorations)



## Annexes

### Sources – Bibliographie

Liste des livres utilisés (Titre, auteur, date), des sites Internet (URL) consultés, des articles (Revue, date, titre, auteur)… Et de toutes les aides externes (noms)   

## 

### Journal de bord du projet

Référence au journal dans le repo Git




