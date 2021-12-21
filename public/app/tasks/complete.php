<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// IF A TASK IS UNDONE, SET IT TO COMPLETED
if (isset($_POST['task_id_done'])) {
    $id = $_POST['task_id_done'];
    $completed = 'true';
    $date = date('Y-m-d H:i');

    // die(var_dump($_POST));

    $statement = $database->prepare(
        'UPDATE tasks SET completed = :completed, updated = :updated WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':completed', $completed, PDO::PARAM_STR);
    $statement->bindParam(':updated', $date, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);



    // IF A TASK IS COMPLETED, SET IT TO UNDONE
} else if (isset($_POST['task_id_undone'])) {
    $id = $_POST['task_id_undone'];
    $completed = 'false';
    $date = date('Y-m-d H:i');

    // die(var_dump($_POST));

    $statement = $database->prepare(
        'UPDATE tasks SET completed = :completed, updated = :updated WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':completed', $completed, PDO::PARAM_STR);
    $statement->bindParam(':updated', $date, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);
}
