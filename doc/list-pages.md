# Listes de toutes les pages du site:

- **Gabarit**: Logo + menu + membre connecté.

## Divers:
- **Page A propos**: informations du collectif, de l'instance et sur KanFF, informations en partie tirée de `instance.json`.

## Users:
- **Page Login**: se connecter.
- **Page Créer un compte**: se créer un compte sur l'instance.
- **Page Mon compte**: gestion de son compte.
- **Page Membres**: liste de tous les membres de l'instance.
- **Page Détails d'un membre**: affichage des informations visibles d'un seul membre**: infos du compte, groupes rejoints (attention visibilité), compétences où le niveau est > 0.
- **Vue Dropdown User**: lors d'un clic sur le cercle initiales en haut à droite, apparaît un petit panneau avec quelques informations du compte et les liens pour page `Mon compte` et pour la Déconnexion.
- **Vue Dropdown Notifications**: petit panneau pour afficher les notifications.

## Groups:
- **Page Groupes**: tous les groupes visibles affichés + tous les groupes rejoints affichés.
- **Page Détails d'un groupe**: informations sur le groupe, liste des membres, listes des projets réalisé par ce groupe, futures événements visible qui concernent le groupe.
- **Page Gestion d'un groupe**: Vue d'édition de la page `Détails d'un groupe`.
- **Page Accès à un groupe**: état de l'accès à un groupe. (vraiment utile ?)
- **Page Créer un groupe**: formulaire pour rentrer toutes les informations du groupe afin de le créer.

## Projects:
- **Page Créer un projet**: formulaire pour créer un projet
- **Page Liste des projets**: tous les projets visibles de l'instance + tous les projets auquels on a contribué.
	- Tri personnalisé par catégorie d'état:
		- En cours: priorité décroissant, importance décroissant, urgence décroissant.
		- En pause: priorité décroissant, importance décroissant, urgence décroissant.
		- Terminés: par date de fin décroissant, par importance.
- **Page Détails du projet**: informations du projet + groupes réalisant (historique?) + événements + gestion du journal de bord + gestion des travaux.
- **Page Gestion du projet**: la page `Détails du projet` en mode éditable (seulement pour les membres autorisés)
- **Page Kanban du projet**: kanban d'un seul projet avec tous les travaux visibles contenant toutes les tâches: 2 vues = 1 éditable et 1 autre non éditable, selon autorisations.
- **Vue Créer une tâche**: donner les informations minimum (nom tâche + travail) pour créer une tâche.
- **Vue Gérer une tâche**: gérer ses informations, ...

## Tasks:
- **Page Tâches de la semaine**: toutes les tâches à faire pour le user connecté durant les 7 jours à venir. Gestion des tâches rapides (leur état) et visualisation ordrée par priorité.

## Events:
- **Page Calendrier**: tous les événements visibles affichés dans un calendrier sur le mois, la semaine ou le jour.
- **Page Créer un événement**: popup sur page Calendrier pour créer un événement dans le calendrier.

## Competences:
- **Page Compétences**: tableaux des compétences pour users.
- **Page Gestion des compétences**: idem que `Page Compétences` mais avec la possibilité d'éditer la liste des compétences.

## Dashboard:
- **Page Dashboard**: contenu directement en lien avec le user connecté: notifications + tâches urgentes et du jour + travaux urgents + événéments du jour et proches + derniers éléments du journal de bord + nouvelles personnes=comptes récents.

