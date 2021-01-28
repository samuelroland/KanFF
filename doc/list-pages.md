# Liste des pages
Liste de toutes les pages de l'application KanFF (et si elles sont réalisées ou pas).

<!-- MDTOC maxdepth:6 firsth1:1 numbering:0 flatten:0 bullets:1 updateOnSave:1 -->

- [Liste des pages](#liste-des-pages)   
      - [Définition](#définition)   
   - [Prévues pour la v1.0 :](#prévues-pour-la-v10)   
      - [Divers](#divers)   
      - [Membres](#membres)   
      - [Groupes](#groupes)   
      - [Projets](#projets)   
      - [Dashboard](#dashboard)   
   - [Abandonné pour la v1.0 :](#abandonné-pour-la-v10)   
      - [Tâches](#tâches)   
      - [Événements](#événements)   
      - [Compétences](#compétences)   
      - [Dashboard](#dashboard)   
      - [Notifications](#notifications)   

<!-- /MDTOC -->

### Définition
- Page: une page entière accessible par un bouton (ou un lien). Exemple: *Page Projets*, Page *Détails d'un projet*.
- Vue: une partie/section/zone d'une page. Exemples: *Groupes participants* dans la page *Détails d'un projet*

## Prévues pour la v1.0 :

### Divers
- [x] **Page A propos**: informations du collectif, de l'instance et sur KanFF, informations en partie tirée de `instance.json`.
- [x] **Gabarit**: Logo + menu + compte connecté.
  - [x] **Vue Panneau déroulant de session**: lors d'un clic sur le cercle initiales en haut à droite, apparaît un petit panneau avec quelques informations du compte et les liens pour page `Mon compte` et pour la Déconnexion.
  - [x] **Vue Formulaire de feedback**: formulaire pour envoyer un feedback au sein de l'application (pour les instances de test).
- [x] **Page Mode d'emploi**: Mode d'emploi permettant d'apprendre à utiliser toutes les fonctionnalités de KanFF.

### Membres
- [x] **Page Login**: se connecter.
- [x] **Page Créer un compte**: se créer un compte sur l'instance.
- [x] **Page Mon compte**: gestion de son compte.
- [x] **Page Supprimer son compte**: page permettant de supprimer son compte.
- [x] **Page Archiver son compte**: page permettant d'archiver son compte.
- [x] **Page Membres**: liste de tous les membres de l'instance.
- [ ] **Page Détails d'un·e membre**: affichage des informations visibles d'un·e seul·e membre**
    - [x] **Vue Informations**: les informations d'un·e membre et ses informations de contact
    - [x] **Vue Groupes rejoints**: ses groupes rejoints
    - [x] **Vue Contributions en cours**: les travaux contribués qui sont en cours
    - [x] **Vue Contributions antérieures**: les travaux contribués qui sont terminés

### Groupes
- [ ] **Page Groupes**: tous les groupes visibles affichés + tous les groupes rejoints affichés.
- [ ] **Page Détails d'un groupe**: informations sur le groupe, liste des membres, listes des projets réalisé par ce groupe, futures événements visible qui concernent le groupe.
- [ ] **Page Gestion d'un groupe**: Vue d'édition de la page `Détails d'un groupe`.
- [ ] **Page Accès à un groupe**: état de l'accès à un groupe, permet de rejoindre un groupe, de le quitter et de voir l'état de l'adhésion (ainsi que les anciennes adhésions à ce groupe)
- [ ] **Page Créer un groupe**: formulaire pour créer un groupe.

### Projets
- [x] **Page Créer un projet**: formulaire pour créer un projet
- [x] **Page Projets**: tous les projets visibles de l'instance (options permettant d'afficher les actuels, ceux contribués et les archivés)
- [ ] **Page Détails d'un projet**: informations du projet + groupes réalisant (historique?) + événements + gestion du journal de bord + gestion des travaux.
    - [ ] **Vue Gestion d'un projet**: la page `Détails d'un projet` en mode éditable (seulement pour les membres autorisés)
    - [ ] **Vue Gestion des travaux**: la partie `Travaux` de `Détails d'un projet` en mode éditable (seulement pour les membres autorisés)
    - [ ] **Vue Gestion des groupes participants**: la partie `Groupes participants` de `Détails d'un projet` en mode éditable (seulement pour les membres autorisés)
    - [ ] **Vue Gestion des entrées**: la partie `Journal de bord` de `Détails d'un projet` en mode éditable (seulement pour les membres autorisés et selon les contraintes appliquées aux log)
- [ ] **Page Kanban**: kanban d'un seul projet avec tous les travaux visibles contenant toutes les tâches: 2 vues = 1 éditable et 1 autre non éditable, selon autorisations.
    - [x] **Vue Créer une tâche**: (dans Page Kanban) donner les informations minimum (nom tâche + travail) pour créer une tâche.
    - [x] **Vue Détails d'une tâche**: (dans Page Kanban) gérer et afficher les informations d'une tâche, ...
    - [ ] **Vue Détails d'un travail**: (dans Page Kanban et dans Détails d'un projet) gérer et afficher les informations d'une tâche, ...

### Dashboard
- [ ] **Vue Bienvenue**: (En haut de la page Dashboard). Petit encadré qui s'affiche durant les 10 jours après l'inscription. Donne quelques ressources et premières informations pour guider la personne inscrite à bien comprendre l'application.

## Abandonné pour la v1.0 :
### Tâches
- **Page Mes tâches**: toutes les tâches à faire pour l'utilisateur·ice connecté durant les 7 jours à venir. Gestion des tâches rapides (leur état) et visualisation ordrée par priorité.

### Événements
- **Page Calendrier**: tous les événements visibles affichés dans un calendrier sur le mois, la semaine ou le jour.
    - **Vue Créer un événement**: popup sur page Calendrier pour créer un événement dans le calendrier.
    - **Vue Détails d'un événement**: popup sur page Calendrier pour créer un événement dans le calendrier.

### Compétences
- **Page Compétences**: tableaux des compétences pour utilisateur·ices.
- **Page Gestion des compétences**: idem que `Page Compétences` mais avec la possibilité d'éditer la liste des compétences.

### Dashboard
- **Page Dashboard**: contenu directement en lien avec l'utilisateur·ice connecté·e: notifications + tâches urgentes et du jour + travaux urgents + événements du jour et proches + derniers éléments du journal de bord + nouvelles personnes=comptes récents.

### Notifications
- **Vue Dropdown Notifications**: petit panneau pour afficher les notifications.
