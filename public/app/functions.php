<?php

declare(strict_types=1);

// Redirect function
/**
 * @param string $path
 * @return never
 */
function redirect(string $path)
{
    header("Location: ${path}");

    exit;
}


// Checks if user is logged in
/** @return bool  */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

if (isLoggedIn()) {
    $user = $_SESSION['user'];
}

// QUERY TO GET ALL LISTS AND TASKS FOR THE USER
/**
 * @param mixed $database
 * @param mixed $userId
 * @return mixed
 */
function getAllListsAndTasks(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT
    lists.id AS list_id,
    lists.description AS list_desc,
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
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
    return $userListsAndTasks;
}

// QUERY TO GET ALL TASKS BELONGING TO LIST_ID ($_GET)
/**
 * @param mixed $database
 * @param mixed $id
 * @return mixed
 */
function getAllTasksFromList(PDO $database, string $id): array
{
    $statement = $database->prepare('SELECT
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM tasks
    WHERE task_list_id = :list_id
    ORDER BY task_completed ASC');
    $statement->bindParam(':list_id', $id, PDO::PARAM_INT);
    $statement->execute();
    $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $tasks;
}

//QUERY TO GET THE LIST NAME FOR THE SELECTED LIST
/**
 * @param mixed $database
 * @param mixed $id
 * @return mixed
 */
function getListNameFromId(PDO $database, string $id): array
{
    $statement = $database->prepare('SELECT
    lists.id AS list_id,
    lists.description AS list_desc,
    lists.user_id AS list_user_id
    FROM lists
    WHERE list_id = :list_id');
    $statement->bindParam(':list_id', $id, PDO::PARAM_INT);
    $statement->execute();
    $listFromId = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $listFromId;
}
