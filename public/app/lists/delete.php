<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_POST['dropdown-list-id'];


$statement = $database->prepare(
    'DELETE FROM lists WHERE id = :id'
);
$statement->bindParam(':id', $id, PDO::PARAM_INT);



$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
redirect($_SERVER['HTTP_REFERER']);
