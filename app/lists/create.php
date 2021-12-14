<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we create new lists and tasks.
if (isset($_POST['list-description'])) {
    $listDescription = trim(filter_var($_POST['list-description'], FILTER_SANITIZE_SPECIAL_CHARS));
    $userId = $_SESSION['user']['id'];

    $statement = $database->prepare("INSERT INTO lists(user_id, description) VALUES(:userId, :listDescription)");

    $statement->bindParam(':userId', $userId, PDO::PARAM_STR);
    $statement->bindParam(':listDescription', $listDescription, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
}
