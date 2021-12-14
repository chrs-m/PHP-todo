<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

$statement = $database->prepare('SELECT * FROM lists WHERE user_id = :id');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();

$userLists = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement = $database->prepare('SELECT * FROM tasks INNER JOIN lists ON lists.id = tasks.list_id');
// $statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();

$userTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $database->prepare('SELECT * FROM tasks WHERE user_id = :id');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();

$allUserTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

// die(var_dump($userLists));
?>

<article>
    <h1><?php echo $config['title']; ?></h1>



    <?php if (isset($_SESSION['user'])) : ?>
        <p>Hi, <?php echo $_SESSION['user']['name']; ?>! What do you need to do today?</p>
    <?php else : ?>
        <a href="/signup.php">No account? Sign up here!</a>
    <?php endif; ?>

</article>

<div>
    <h2>My lists</h2>
    <!-- HERE WE LOOP ALL LISTS AVAILABLE FOR THE USER -->
    <?php
    foreach ($userLists as $userList) { ?>
        <details>
            <summary><?= $userList['description'] ?></summary>
            <?php foreach ($userTasks as $userTask) { ?>
                <input type="checkbox" id="<?= $userTask['title'] ?>" name="<?= $userTask['title'] ?>" <label for="<?= $userTask['title'] ?>"><?= $userTask['title'] ?></label>
            <?php } ?>
        </details>
    <?php } ?>
    <details>
        <summary class="all-tasks">All my tasks</summary>
        <?php foreach ($allUserTasks as $allUserTask) { ?>
            <input type="checkbox" id="<?= $allUserTask['title'] ?>" name="<?= $allUserTask['title'] ?>" <label for="<?= $allUserTask['title'] ?>"><?= $allUserTask['title'] ?></label>
        <?php } ?>
    </details>
</div>


<a href="/create.php" class="btn btn-primary">Create new list!</a>
<a href="/create.php" class="btn btn-primary">Add task!</a>


<?php require __DIR__ . '/views/footer.php'; ?>
