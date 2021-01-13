# Conventions

## Définitions
- ***CamelCase*** : C'est une façon d'écrire un mot composé sans espaces, on met une majuscule au début des mots: `TryANameHere`
- ***LowerCamelCase*** : C'est une façon d'écrire un mot composé sans espaces, on met une majuscule au début des mots, sauf le premier: `tryANameHere`
## Noms de commits :

- Le titre des commits est fait en anglais.
- Au début du commit il y a [le nom du fichier que l'ont a modifié]:, pour autant qu'on en aie modifier qu'un seul.
- Si nous avons modifié plus d'un fichier, on met [le nom de la fonctionnalité modifiée]: ce que l'on a fait
- Si nous devons énumerer plusieurs actions, nous les séparons avec un pipe `|`.
## Noms de fonctions :

- Le verbe au début du nom de la fonction est en minuscule.
- Les mots suivants on tous une majuscule comme première lettre.
- Il n'y a pas de "_" entre les mots.
#### Pour les fonction **`Ajax`** :
- Lors de l'utilisation d'une fonction avec **`Ajax`**, nous utilisons un *try* pour le premier appel de la fonction.
- Le *try* appel la fonction qui porte son nom; *try*`deleteTask()` appel `deleteTask()`.
- La fonction appelée par le *try* appel une fonction `sendRequest()`.
- Après l'appel de la fonction principale il y a un *callback*, qui est appelé par `sendRequest()`.
## Noms des constantes-messages 
- Utiliser des tirets-bas "_" pour séparer les mots.
1) Utiliser l'action dans la querystring comme premier mot.
2) Définir ce dont parle le message
- Exemple : `ACTION_JE_FAIT_QUOI`

## Noms des objets HTML
#### Nom des id
- Le nom de l'objet est contenu au début de id, un diminutif est utilisé dans le cas où l'objet dépasse 4 caractères.
- Les mots suivants on tous une majuscule comme première lettre.
- Il n'y a pas de "_" entre les mots.
## Nom de classe CSS
- WIP
## Nom des paramètres de fonction
- Nous utilisons du ***LowerCamelCase***.
- Les données provenant d'une requète **`Ajax`** sont toutes contenue dans la variable : **$data** .

## Conditions exclusive de validation
- Permet qu'une validation de donnée ne soie pas impactée par une éventuelle modification de la structure de la base de donnée.