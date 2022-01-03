<?php

declare(strict_types=1);

require __DIR__ . '/../../autoload.php';


// HERE WE UPDATE THE PASSWORD IN THE DATABASE

if ((isset($_POST['new-password']) && $_POST['new-password'] === $_POST['confirm-new-password'])) {
    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
    $confirmNewPassword = password_hash($_POST['confirm-new-password'], PASSWORD_DEFAULT);
    $id = $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];

    $statement = $database->prepare('SELECT password FROM users WHERE id = :id AND username = :username');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $database->prepare('UPDATE users SET password = :password WHERE id = :id');
    $statement->bindParam(':password', $confirmNewPassword, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['message'] = 'Your password has been changed!';
    redirect('/profile.php');
}
