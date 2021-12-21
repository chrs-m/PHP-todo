<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_POST['dropdown-list-id'];
$desc = $_POST['new-list-description'];

// CHECKS IF A NEW NAME WAS GIVEN, IF NOT, THE LIST WILL BE GIVEN A RANDOM NUMBER
if (isset($_POST['update-list-button']) && empty($_POST['new-list-description'])) {
    $desc = "List" . "-" . random_int(0, 999);
    $statement = $database->prepare(
        'UPDATE lists SET description = :desc WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':desc', $desc, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);

    // IF A NEW NAME AS GIVEN, THE LIST GETS THE NEW NAME
} else if (isset($_POST['update-list-button'])) {
    $statement = $database->prepare(
        'UPDATE lists SET description = :desc WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':desc', $desc, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);

    // IF THE DELETE BUTTON WAS PRESSED, DELETE LIST FROM DB
} else if (isset($_POST['delete-list-button'])) {
    $statement = $database->prepare(
        'DELETE FROM lists WHERE id = :id'
    );
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);
}
