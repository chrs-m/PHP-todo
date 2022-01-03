<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


$userId = $_SESSION['user']['id'];

// QUERY TO GET ALL AVAILABLE LISTS FOR THE USER
$statement = $database->prepare('SELECT * FROM lists WHERE user_id = :id');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();
$userLists = $statement->fetchAll(PDO::FETCH_ASSOC);

// HERE WE CREATE NEW TASKS AND ASSIGN THEM TO LISTS
if (isset($_POST['task-title'])) {
    $userId = $_SESSION['user']['id'];
    $listId = trim(filter_var($_POST['task-list'], FILTER_SANITIZE_SPECIAL_CHARS));
    $taskTitle = trim(filter_var($_POST['task-title'], FILTER_SANITIZE_SPECIAL_CHARS));
    $taskDescription = trim(filter_var($_POST['task-description'], FILTER_SANITIZE_SPECIAL_CHARS));
    $taskDeadline =  trim(filter_var($_POST['task-deadline'], FILTER_SANITIZE_SPECIAL_CHARS));
    $taskCreated = date("Y-m-d H:i:s");
    $taskCompleted = trim(filter_var("false", FILTER_SANITIZE_SPECIAL_CHARS));

    $statement = $database->prepare("INSERT INTO tasks(user_id, list_id, title, description, deadline, created, completed) VALUES(:userId, :listId, :taskTitle, :taskDescription, :taskDeadline, :taskCreated, :taskCompleted)");

    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':listId', $listId, PDO::PARAM_INT);
    $statement->bindParam(':taskTitle', $taskTitle, PDO::PARAM_STR);
    $statement->bindParam(':taskDescription', $taskDescription, PDO::PARAM_STR);
    $statement->bindParam(':taskDeadline', $taskDeadline, PDO::PARAM_STR);
    $statement->bindParam(':taskCreated', $taskCreated, PDO::PARAM_STR);
    $statement->bindParam(':taskCompleted', $taskCompleted, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['message'] = 'Your list has been created successfully!';
    redirect('/create.php');
} elseif (!isset($_POST['task-title'])) {
    $_SESSION['message'] = 'You have to give your list a name!';
    redirect('/create.php');
}
