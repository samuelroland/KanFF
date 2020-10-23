# Response Structure to Ajax calls
## Explanation of the structure and content of JSON requests and responses to all types of Ajax calls.
This is based on [JSend standard](https://github.com/omniti-labs/jsend/blob/master/README.md) for web services.

### 3 types of status:
- "**success**": the request have succeed
- "**fail**": the request have failed because data are not valid or missing or the action was prohibited
- "**error**": internal error (database connexion impossible, )

## Examples for Success queries:
### Query GET
- Get one element (GET, `?action=getTask&id=153`) return:

        {
          "status": "success",
          "data": {
            "task": {
              "id": 153,
              "name": "créer doc",
              "description": null
            }
          }
        }

- Get multiples elements  (GET, `?action=getTasks&project=2`) return:

        {
          "status": "success",
          "data": {
            "tasks": [
              {
                "id": 15,
                "name": "créer doc",
                "description": null
              },
              {
                "id": 45,
                "name": "acheter du pain",
                "description": null
              },
              {
                "id": 74,
                "name": "chercher des biscuits doc",
                "description": "chez le voisin"
              }
            ]
          }
        }

### Query POST
- Create one element:
    - Request `?action=createTask`:
    
            {
              "name": "Take a picture of the cat",
              "type": 0,
              "work": 15,
              "project": 26
            }

    - Response:

            {
              "status": "success",
              "data": {
                "task": {
                  "id": 621,
                  "name": "Take a picture of the cat",
                  "type": 0,
                  "deadline": null
                }
              }
            }


- Update one element:
    - Request `?action=updateTask&id=290`:

            {
              "name": "Updated name",
              "description": null
            }

    - Response:
    
            {
              "status": "success",
              "data": {
                "task": {
                  "id": 290,
                  "name": "Updated name",
                  "description": null
                }
              }
            }
    

- Delete one element:
    - Request `?action=deleteTask`:
   
            {
              "id": 651
            }

    - Response:

            {
              "status": "success",
              "data": null
            }

## Examples for Failed queries:

- Get one element (GET, `?action=getTask&id=900`) return:

        {
          "status": "failed",
          "data": {
            "error": "Task not found with this id.",
            "code": 16,
            "position": "inline"
          }
        }
        
- Delete one element:
    - Request `?action=deleteTask`:
   
            {
              
            }

    - Response:

            {
              "status": "failed",
              "data": {
                "error": "No task deleted. Id not provided.",
                "code": 3,
                "position": "inline"
              }
            }