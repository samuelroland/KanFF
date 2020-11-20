# Git branching model
Here is information about the branching model used with Git, to declare the strategy for creating, using, merging and deleting of branches.

# List of branches
- `master`: main branch that will be equal to the production last version
- `develop`: branch to merge different features and make them work together, where the next release code will be
Foreach story, one feature branch will be created.
Foreach release a release branch with the name of the tag of the release (like v1.1-beta) will be created.

Commands:

Creation:
- At feature creation for a new story: Example with `myaccount` story: `git flow feature start myaccount`.
- At release creation for a new release `v1.1-beta`: Example with `myaccount` story: `git flow release start v1.1-beta`.

Finish:
- At feature finishing for a new story: Example with `myaccount` story: `git flow feature finish myaccount`.
- At release finishing for a new release `v1.1-beta`: Example with `myaccount` story: `git flow release finish v1.1-beta`.