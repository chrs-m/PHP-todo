<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_POST['dropdown-list-id'];
$desc = $_POST['new-list-description'];

$statement = $database->prepare(
    'UPDATE lists SET description = :desc WHERE id = :id'
);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->bindParam(':desc', $desc, PDO::PARAM_STR);


$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
redirect($_SERVER['HTTP_REFERER']);
