<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// CHECKS IF A NEW NAME WAS GIVEN, IF NOT, THE LIST WILL BE GIVEN A RANDOM NUMBER
if (isset($_POST['update-task-button'])) {
    $id = $_POST['dropdown-task-id'];
    $title = $_POST['new-task-title'];
    $desc = $_POST['new-task-description'];
    $taskList = $_POST['new-task-list'];
    $deadline = $_POST['new-task-deadline'];
    $date = date('Y-m-d H:i');


    $statement = $database->prepare(
        'UPDATE tasks SET title = :title, description = :desc, deadline = :deadline, updated = :date, list_id = :list_id WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':desc', $desc, PDO::PARAM_STR);
    $statement->bindParam(':deadline', $deadline, PDO::PARAM_STR);
    $statement->bindParam(':list_id', $taskList, PDO::PARAM_STR);
    $statement->bindParam(':date', $date, PDO::PARAM_STR);


    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);

    // IF A NEW NAME AS GIVEN, THE LIST GETS THE NEW NAME
} else if (isset($_POST['delete-task-button'])) {
    $id = $_POST['dropdown-task-id'];

    $statement = $database->prepare(
        'DELETE FROM tasks WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);
}
