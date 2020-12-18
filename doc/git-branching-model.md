# Git branching model
Here is information about the git branching model, to declare the strategy for creating, using, merging and deleting of branches.
For the management of branches (create, merge and delete branch) we will use Git flow for most actions. Other actions like commit, log, show, status, restore, push, pull, clone, ... will be with Git "normal".

Feature branches names will be named with lower kebab case (like `my-account`, `technical-documentation` or `conventions`).
Release branches names will be named with same name as the tag name (like `v1.2` or `v1.6-beta`).

## List of branches
- `master`: main branch that will be equal to the production last version
- `develop`: branch to merge different features and make them work together, where the next release code will be. (this branch is defined as default branch on GitHub). It represents the internal progress of the project (because it contains only completed features).
- Foreach story, one feature branch will be created. The name must be the name of the story in english.
- Foreach release, one release branch with the name of the tag of the release (like `v2.5`) will be created.

### Commits
- No commit must be pushed to `master`
- No commit related to a feature must be pushed to `develop`
- Merge between different feature branches are authorized. This is useful for functions concerning several files. These functions must be written in common files in the `common-files` branch. With these rule, we should need only merge the `common-files` branch to another feature branch (or in `develop` obviously). 


### Commands:
#### Creation:
- At feature branch creation for a new story: Example with `my-account` story: `git flow feature start my-account`.
- At release branch creation for a new release `v1.1-beta`: `git flow release start v1.1-beta`.

#### Publish branches on remote:
This command will be proposed when you will try to push. It will return something like `fatal: The current branch feature/myfee has no upstream branch. To push the current branch and set the remote as upstream, use git push --set-upstream origin feature/myfee`.
- Feature branch: Example with `my-account` story: `git push --set-upstream origin feature/my-account`.
- Release branch: Example with `v1.1-beta`: `git push --set-upstream origin release/v1.1-beta`.

#### Finish:
- At feature finishing : Example with `my-account` story: `git flow feature finish my-account`.
- At release finishing `v1.1-beta`: `git flow release finish v1.1-beta`.

### Specialities
- Branch `common-files` should always exist unlike other feature branches.
- Common files are `js/global.js`, `controler/help.php` and `view/helpers.php` and these files must be committed only in `common-files` if possible.

what about bugfixes and hotfixes ? écrit plus tard quand v1.0 ?