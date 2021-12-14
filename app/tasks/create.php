<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we create new tasks and assign them to lists.
if (isset($_POST['task-title'])) {
    $userId = $_SESSION['user']['id'];
    $taskTitle = trim(filter_var($_POST['task-title'], FILTER_SANITIZE_SPECIAL_CHARS));
    $taskList = trim(filter_var($_POST['task-list'], FILTER_SANITIZE_SPECIAL_CHARS));
    $taskDeadline =  trim(filter_var($_POST['task-deadline'], FILTER_SANITIZE_SPECIAL_CHARS));


    // die(var_dump($taskTitle));


    $statement = $database->prepare("INSERT INTO tasks(user_id, list_id, title, deadline, created) VALUES(:userId, :listID, :taskTitle, :taskDeadline, :taskCreated)");

    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':listId', $listId, PDO::PARAM_INT);
    $statement->bindParam(':taskTitle', $taskTitle, PDO::PARAM_STR);
    $statement->bindParam(':taskList', $taskList, PDO::PARAM_STR);
    $statement->bindParam(':taskDeadline', $taskDeadline, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['message'] = 'Your list has been created successfully!';
    redirect('/create.php');
} elseif (!isset($_POST['task-title'])) {
    $_SESSION['message'] = 'You have to give your list a name!';
    redirect('/create.php');
}
