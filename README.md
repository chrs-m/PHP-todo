<img src="https://media2.giphy.com/media/GcSqyYa2aF8dy/giphy.gif?cid=ecf05e47wqfjw3967kyupppy6l0l317voa7baayzxxx319dc&rid=giphy.gif&ct=g" width="100%">

# What to-do?!

A simple to-do applictaion built in PHP (with some help from other languages).
The assigment was to create a full functioning to-do app where the user can:

-   Create an account.

-   Login.

-   Logout.

-   Edit account email and password.

-   Upload a profile avatar image.

-   Create new tasks with title, description and deadline date.

-   Edit my tasks.

-   Delete my tasks.

-   Mark tasks as completed.

-   Mark tasks as uncompleted.

-   Create new task lists with title.

-   Edit my task lists.

-   Delete my task lists along with all tasks.

-   Add a task to a list.

-   View all tasks.

-   View all tasks within a list.

-   View all tasks which should be completed today.

-   **Extra:** Users are able to delete their accounts along with all tasks and lists.

-   **Extra:** Users are able to remove a task from a list _(but still see them under 'all tasks')_.

# Installation

-   Clone repo via the terminal or GitHub desktop.
-   Run the application in localhost.

`If you have problems with the application looking weird, please do the following:`

1. Make sure you have Node installed (brew install node)
2. Go to root-folder in the terminal and write:
    - npm install (wait for it to be installed)
    - npm build (wait for it to be done)
3. Try launching the application again.

# Code Review

Code review written by [Nelly Svarvare Petrén](https://github.com/NellySP).

1. signup.php 17, 23, 29, 35. Below the inlog and signup-form it says: please provide the your password/email/name. An extremely minor thing!

2. It seems you can create tasks without adding it to a list. Is this intentional? Otherwise this could be fixed with a -> elseif (!isset($\_POST[‘list-title'])) { $\_SESSION['message'] = 'You have to assign your task to a list!’; _\*\*Yes this is a feature, you can have all your tasks under "All tasks" if you want._

3. Reset-password.php 23. Misspelled remember. A missing b. An extremely minor thing!

4. The file reset-password seems to be empty. Is this where a function not yet implemented is supposed to go? If you decide to not add the function, you could remove the file for a cleaner look!

5. Login.php. You could add an unset for the password, just so that it doesn’t save or is able to reach during the session. Unless you have already solved this in another way! -> unset($password). On line 29, before the redirect!

6. Good idea to split up the update in to the different files. Makes It easier to find!

7. Since the delete-function is irreversible you could add that the user also how to write in their password to be able to delete. So that no one other than the user itself can delete the account.

8. Lists/edit.php here you have a feature that gives the list a random number if a new name is not given. It is nicely done! But might be a bit confusing in the long run if the user have many lists. Especially if the user updates lists multiple lists in that way.

9. In lists/edit.php and delete.php you have the same code for deleting lists. You could maybe delete one of the code-passages. To stay DRY.

10. In tasks/edit.php and delete.php you have the same code for deleting lists. You could maybe delete one of the code-passages. To stay DRY.

All in all very good structure, it is easy to find the code you’re looking for!

# Testers

Tested by the following people:

1. Theo Sandell
2. Patrik Staaf

# Wunderlist+
Link to Wunderlist+ PR's:
[See pull requests here](https://github.com/chrs-m/PHP-todo/commits/wunderlistPlus)

**New features:**
- Reset password
- Mark all tasks complete
