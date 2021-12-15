<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

//QUERY TO GET ALL AVAILABLE LISTS FOR THE USER
// $statement = $database->prepare('SELECT * FROM lists WHERE user_id = :id');
// $statement->bindParam(':id', $userId, PDO::PARAM_INT);
// $statement->execute();
// $userLists = $statement->fetchAll(PDO::FETCH_ASSOC);

//QUERY TO GET ALL AVAILABLE TASKS WIHTIN CHOOSEN LIST
// $statement = $database->prepare('SELECT * FROM tasks INNER JOIN lists ON lists.id = tasks.list_id');
// $statement->execute();
// $userTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

// QUERY TO GET ALL LISTS AND TASKS FOR THE USER
$statement = $database->prepare('SELECT
lists.id AS list_id,
lists.description AS list_desc,
tasks.title AS task_title,
tasks.description as task_description,
tasks.user_id AS task_user_id,
tasks.id AS task_id,
tasks.deadline AS task_deadline,
tasks.created AS task_created,
tasks.updated AS task_updated,
tasks.list_id AS task_list_id,
tasks.completed AS task_completed
FROM
lists
INNER JOIN users ON lists.user_id = users.id
LEFT JOIN tasks ON lists.id = tasks.list_id
WHERE lists.user_id = :id
GROUP BY task_list_id
ORDER BY list_desc ASC;');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();
$userListsAndTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

// die(var_dump($userListsAndTasks));



// QUERY TO GET ALL AVAILABLE TASKS FOR THE USER
// $statement = $database->prepare('SELECT * FROM tasks WHERE user_id = :id');
// $statement->bindParam(':id', $userId, PDO::PARAM_INT);
// $statement->execute();
// $allUserTasks = $statement->fetchAll(PDO::FETCH_ASSOC);


// die(var_dump($userTasks));
?>

<article>
    <h1><?php echo $config['title']; ?></h1>



    <?php if (isset($_SESSION['user'])) : ?>
        <p>Hi, <?php echo $_SESSION['user']['name']; ?>! What do you need to do today?</p>
    <?php else : ?>
        <a href="/signup.php">No account? Sign up here!</a>
    <?php endif; ?>

</article>

<div class="container">
    <h2>My lists</h2>
    <!-- HERE WE LOOP ALL LISTS AVAILABLE FOR THE USER -->

    <?php foreach ($userListsAndTasks as $userListAndTask) : ?>
        <details class="">
            <summary><?= $userListAndTask['list_desc'] ?></summary>
            <?php if ($userListAndTask['list_id'] === $userListAndTask['task_id']) : ?>
            <?php endif; ?>
        </details>
    <?php endforeach; ?>



    <!-- <?php
            foreach ($userLists as $userList) { ?>
        <details class="">
            <summary class="mt-2"><?= $userList['description'] ?></summary>
            <?php foreach ($userTasks as $userTask) { ?>
                <!-- HERE WE CHECK IF THE LISTS CONTAIN ANY TASKS WITH THE SAME ID -->
    <?php if ($userTask['list_id'] == $userList['id']) : ?>
        <input type="checkbox" id="<?= $userTask['title'] ?>" name="<?= $userTask['title'] ?>" <label for="<?= $userTask['title'] ?>"><?= $userTask['title'] ?></label>
    <?php endif; ?>
<?php } ?>
</details>
<?php } ?>
<details>
    <summary class="all-tasks mt-2">All my tasks</summary>
    <?php foreach ($userTasks as $allUserTasks) { ?>
        <input type="checkbox" id="<?= $allUserTasks['title'] ?>" name="<?= $allUserTasks['title'] ?>" <label for="<?= $allUserTasks['title'] ?>"><?= $allUserTasks['title'] ?></label>
    <?php } ?>
</details> -->
</div>


<a href="/create.php" class="btn btn-primary">Create new list!</a>
<a href="/create.php" class="btn btn-primary">Add task!</a>


<?php require __DIR__ . '/views/footer.php'; ?>
