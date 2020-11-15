# Liste des pages de l'application

<!-- MDTOC maxdepth:6 firsth1:1 numbering:0 flatten:0 bullets:1 updateOnSave:1 -->

- [Liste des pages de l'application](#liste-des-pages-de-lapplication)   
   - [Définition](#définition)   
   - [Divers](#divers)   
   - [Membres](#membres)   
   - [Groupes](#groupes)   
   - [Projets](#projets)   
   - [Tâches](#tâches)   
   - [Events](#events)   
   - [Compétences](#compétences)   
   - [Dashboard](#dashboard)   

<!-- /MDTOC -->

## Définition
- Page: une page entière accessible par un bouton (et un lien)
- Vue: une partie d'une page.

## Divers
- **Page A propos**: informations du collectif, de l'instance et sur KanFF, informations en partie tirée de `instance.json`.
- **Gabarit** Logo + menu + membre connecté.

## Membres
- **Page Login**: se connecter.
- **Page Créer un compte**: se créer un compte sur l'instance.
- **Page Mon compte**: gestion de son compte.
- **Page Membres**: liste de tous les membres de l'instance.
- **Page Détails d'un membre**: affichage des informations visibles d'un seul membre**: infos du compte, groupes rejoints (attention visibilité), compétences où le niveau est > 0.
- **Vue Dropdown User**: lors d'un clic sur le cercle initiales en haut à droite, apparaît un petit panneau avec quelques informations du compte et les liens pour page `Mon compte` et pour la Déconnexion.
- **Vue Dropdown Notifications**: petit panneau pour afficher les notifications. (**Abandonné pour la v1.0**)

## Groupes
- **Page Groupes**: tous les groupes visibles affichés + tous les groupes rejoints affichés.
- **Page Détails d'un groupe**: informations sur le groupe, liste des membres, listes des projets réalisé par ce groupe, futures événements visible qui concernent le groupe.
- **Page Gestion d'un groupe**: Vue d'édition de la page `Détails d'un groupe`.
- **Page Accès à un groupe**: état de l'accès à un groupe, permet de rejoindre un groupe, de le quitter et de voir l'état de l'adhésion (ainsi que les anciennes adhésions à ce groupe)
- **Page Créer un groupe**: formulaire pour créer un groupe.

## Projets
- **Page Créer un projet**: formulaire pour créer un projet
- **Page Projets**: tous les projets visibles de l'instance + tous les projets auquels on a contribué.
	- Tri personnalisé par catégorie d'état:
		- En cours: priorité décroissant, importance décroissant, urgence décroissant.
		- En pause: priorité décroissant, importance décroissant, urgence décroissant.
		- Terminés: par date de fin décroissant, par importance.
- **Page Détails du projet**: informations du projet + groupes réalisant (historique?) + événements + gestion du journal de bord + gestion des travaux.
- **Vue Gestion du projet**: la page `Détails du projet` en mode éditable (seulement pour les membres autorisés)
- **Vue Gestion des travaux**: la partie `Travaux` de `Détails du projet` en mode éditable (seulement pour les membres autorisés)
- **Page Kanban**: kanban d'un seul projet avec tous les travaux visibles contenant toutes les tâches: 2 vues = 1 éditable et 1 autre non éditable, selon autorisations.
- **Vue Créer une tâche**: (dans Page Kanban) donner les informations minimum (nom tâche + travail) pour créer une tâche.
- **Vue Détails d'une tâche**: (dans Page Kanban) gérer et afficher les informations d'une tâche, ...
- **Vue Détails d'un travail**: (dans Page Kanban et dans Détails du projet) gérer et afficher les informations d'une tâche, ...

## Tâches
- **Page Mes tâches**: toutes les tâches à faire pour le user connecté durant les 7 jours à venir. Gestion des tâches rapides (leur état) et visualisation ordrée par priorité. (**Abandonné pour la v1.0**)

## Events
- **Page Calendrier**: tous les événements visibles affichés dans un calendrier sur le mois, la semaine ou le jour. (**Abandonné pour la v1.0**)
- **Vue Créer un événement**: popup sur page Calendrier pour créer un événement dans le calendrier. (**Abandonné pour la v1.0**)

## Compétences
- **Page Compétences**: tableaux des compétences pour users. (**Abandonné pour la v1.0**)
- **Page Gestion des compétences**: idem que `Page Compétences` mais avec la possibilité d'éditer la liste des compétences. (**Abandonné pour la v1.0**)

## Dashboard
- **Page Dashboard**: contenu directement en lien avec le user connecté: notifications + tâches urgentes et du jour + travaux urgents + événéments du jour et proches + derniers éléments du journal de bord + nouvelles personnes=comptes récents. (**Abandonné pour la v1.0**)
- **Vue Bienvenue**: (En haut de la page Dashboard). Petit encadré qui s'affiche durant les 10 jours après l'inscription. Donne quelques ressources et premières informations pour guider la personne inscrite à bien comprendre l'application.
