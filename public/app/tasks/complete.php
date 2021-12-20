<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_POST['task_id'];
$completed = 'true';
$date = date('Y-m-d H:i');


$statement = $database->prepare(
    'UPDATE tasks SET completed = :completed, updated = :updated WHERE id = :id'
);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->bindParam(':completed', $completed, PDO::PARAM_STR);
$statement->bindParam(':updated', $date, PDO::PARAM_STR);

$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
redirect($_SERVER['HTTP_REFERER']);
