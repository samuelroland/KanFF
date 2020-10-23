# Structure of Ajax calls
## Definition of the structure and the content in Ajax calls (including request data and response data) 
This is based on [JSend specification](https://github.com/omniti-labs/jsend/blob/master/README.md) for web services. (Description: *JSend is a specification for a simple, no-frills, JSON based format for application-level communication.*)

### Main principles:
- Request and response data are in **JSON**
- Request data sent by POST are a JSON array in **1** dimension
- Request that delete an element must contain POST data, to make the request incomplete with GET parameters only (to avoid CRSF vulnerability)
- Response data returned contain in all cases a `status` index with the status. It must contain a `data` index if status is success or fail, or contain a `message` index if status is error.
- 3 types of status:
    - "**success**": the request have succeed
    - "**fail**": the request has failed because data sent are invalid or missing, or because the action is prohibited
    - "**error**": the request has been stopped because of internal errors (database connexion failed, JSON config file unreadable, others internal errors or exceptions)
- `data` index doesn't contain directly the information of an element but an array with the information of an element. This array in `data` is named depending its content.

        This structure of data is accepted:
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
        
        This version not:
        {
          "status": "success",
          "data": {
            "id": 153,
            "name": "créer doc",
            "description": null
          }
        }
        

## Examples for Success queries:
### Query GET
- Get one element (`?action=getTask&id=153`) return the task with all its informations:

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

- Get multiples elements (`?action=getTasks&project=2`) return an array `tasks` of task:

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

    - Response (the entire task created):

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

    - Response (the entire task updated):
    
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

    - Response (no data because task has been deleted):

            {
              "status": "success",
              "data": null
            }

## Examples for Failed queries:

- Get one element (GET, `?action=getTask&id=900`) return the error information in `data` index:

        {
          "status": "failed",
          "data": {
            "error": "Task not found with this id.",
            "code": 16,
            "position": "inline"
          }
        }

- Delete one element:
    - Request `?action=deleteTask` (forgot POST values):
   
            {
              
            }

    - Response (the error information in `data` index):

            {
              "status": "failed",
              "data": {
                "error": "No task deleted. Id not provided.",
                "code": 3,
                "position": "inline"
              }
            }

## Examples for queries with errors:

- Get one element (`?action=getTask&id=153`) but MySQL server is down so return the internal error:

             {
               "status": "error",
               "message": "Connexion to database failed. Please contact the instance admin."
             }
