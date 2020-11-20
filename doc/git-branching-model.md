# Git branching model
Here is information about the branching model used with Git, to declare the strategy for creating, using, merging and deleting of branches.
For the management of branches (create, merge and delete branch) we will use Git flow. Other actions like commit, log, show, status, restore, push, pull, clone, ... will be with Git "normal".

Feature branches names will be named with lower kebab case (like `my-account`, `technical-documentation` or `conventions`).
Release branches names will be named with same name as the tag name (like `v1.2` or `v1.6-beta`).

## List of branches
- `master`: main branch that will be equal to the production last version
- `develop`: branch to merge different features and make them work together, where the next release code will be
- Foreach story, one feature branch will be created. The name must be the name of the story in english.
- Foreach release, one release branch with the name of the tag of the release (like `v2.5`) will be created.

### Commands:
#### Creation:
- At feature branch creation for a new story: Example with `my-account` story: `git flow feature start my-account`.
- At release branch creation for a new release `v1.1-beta`: `git flow release start v1.1-beta`.

#### Publish branches on remote:
This command will be proposed when you will try to push. It will return something like `fatal: The current branch feature/myfee has no upstream branch. To push the current branch and set the remote as upstream, use git push --set-upstream origin feature/myfee`
- Feature branch: Example with `my-account` story: `git push --set-upstream origin feature/my-account`.
- Release branch: Example with `v1.1-beta`: `git push --set-upstream origin release/v1.1-beta`.

#### Finish:
- At feature finishing : Example with `my-account` story: `git flow feature finish my-account`.
- At release finishing `v1.1-beta`: `git flow release finish v1.1-beta`.
