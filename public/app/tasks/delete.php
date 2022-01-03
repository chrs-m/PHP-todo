<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_POST['task_id'];

// DELETE TASK FROM DB
$statement = $database->prepare(
    'DELETE FROM tasks WHERE id = :id'
);
$statement->bindParam(':id', $id, PDO::PARAM_INT);

$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
redirect($_SERVER['HTTP_REFERER']);
