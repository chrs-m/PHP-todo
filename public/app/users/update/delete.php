<?php

declare(strict_types=1);

require __DIR__ . '/../../autoload.php';


// DELETE USER + ALL TASKS AND LISTS FROM DB
if (isLoggedIn() && isset($_POST['delete-account'])) {
    $id = (int) $user['id'];

    $statement = $database->prepare('DELETE FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM tasks WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM lists WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

unset($_SESSION['user']);
session_destroy();

redirect('/');
