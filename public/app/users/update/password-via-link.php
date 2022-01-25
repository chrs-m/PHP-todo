<?php

declare(strict_types=1);

require __DIR__ . '/../../autoload.php';

// HERE WE UPDATE THE PASSWORD IN THE DATABASE
if ((isset($_POST['new-password'], $_POST['email']) && $_POST['new-password'] === $_POST['confirm-new-password'])) {
    $newPassword = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
    $confirmNewPassword = password_hash($_POST['confirm-new-password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $statement = $database->prepare('UPDATE users SET password = :password WHERE email = :email');
    $statement->bindParam(':password', $confirmNewPassword, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['message'] = 'Your password has been changed!';
    redirect('/index.php');
}
