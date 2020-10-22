# Response Structure to Ajax calls
## Explanation of the structure of JSON response to all types of Ajax calls.


### 3 types of status:
- "success": the request have succeed
- "fail": the request have failed because data are not valid or missing or the action was prohibited
- "error": internal error (database connexion impossible, )

### GET data
On GET `?action=getTask&id=153` return:

    {
      "status": "success",
      "data": {
        "task": {
          "name": "créer doc",
          "description": null
        }
      }
    }

{
  "status": "success",
  "data": {
    "tasks": [
      {
        "name": "créer doc",
        "description": null
      },
      {
        "name": "acheter du pain",
        "description": null
      },
      {
        "name": "chercher des biscuits doc",
        "description": "chez le voisin"
      }
    ]
  }
}