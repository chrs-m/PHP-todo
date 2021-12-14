<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

$statement = $database->prepare('SELECT * FROM lists WHERE user_id = :id');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();

$userLists = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<?= $_SESSION['message']; ?>

<section>
    <h2>Create list</h2>
    <div class="create-list">
        <form class="create-post-container" action="/app/lists/create.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <label for="list-description">Please give your list a name</label>
                <br>
                <input class="description-field" type="text" name="list-description" required placeholder="List name"></input>
                <br>
                <button class="btn btn-primary submit" type="submit" name="button">Create</button>
            </div>
        </form>
    </div>
</section>

<section>
    <h2>Create task</h2>
    <div class="create-task">
        <form class="create-post-container" action="/app/tasks/create.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <label for="task-title">Title</label>
                <br>
                <input class="task-title" type="text" name="task-title" required placeholder="Whats your task?"></input>
                <br>
                <!-- LOOPS OUT EVERY LIST CONNECTED TO THE USER -->
                <select class="task-list" name="task-list" required>
                    <option value="">--Please choose a list--</option>
                    <?php
                    foreach ($userLists as $userList) { ?>
                        <option value="<?= $userList['id'] ?>"><?= $userList['description'] ?></option>
                    <?php } ?>
                </select>
                <br>
                <label for="task-deadline">Do you have a deadline?</label>
                <input class="task-deadline" type="datetime-local" name="task-deadline"></input>
                <br>
                <button class="btn btn-primary submit" type="submit" name="button">Create</button>
            </div>
        </form>
    </div>
</section>


<?php require __DIR__ . '/views/footer.php'; ?>
