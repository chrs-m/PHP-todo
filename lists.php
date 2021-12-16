<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

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
ORDER BY list_desc ASC;');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();
$userListsAndTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    <!-- HERE WE LOOP ALL LISTS AND TASKS AVAILABLE FOR THE USER -->
    <!-- IF LIST DESCRIPTION IS THE SAME, PRINT THE TASKS. IF NOT, PRINT NEW LIST NAME AND FIRST TASK. -->
    <?php $listName = '';
    foreach ($userListsAndTasks as $userListAndTask) :
        if ($userListAndTask['list_desc'] !== $listName) : ?>
            <h1><?= $userListAndTask['list_desc'] ?></h1>
            <p><?= $userListAndTask['task_title'] ?></p>
        <?php else : ?>
            <p><?= $userListAndTask['task_title'] ?></p>
        <?php endif; ?>
        <?php $listName = $userListAndTask['list_desc']; ?>
    <?php endforeach; ?>


    <details>
        <summary class="all-tasks mt-2">All my tasks</summary>
        <?php foreach ($userListsAndTasks as $userListAndTask) { ?>
            <input type="checkbox" id="<?= $userListAndTask['task_title'] ?>" name="<?= $userListAndTask['task_title'] ?>" <label for="<?= $userListAndTask['task_title'] ?>"><?= $userListAndTask['task_title'] ?></label>
        <?php } ?>
    </details>

    <a href="/create.php" class="btn btn-success">Create new list!</a>
    <a href="/create.php" class="btn btn-success">Add task!</a>


    <?php require __DIR__ . '/views/footer.php'; ?>
