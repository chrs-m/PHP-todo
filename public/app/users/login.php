<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// HERE WE LOG IN THE USERS AND SET SESSION VARIABLES

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');

    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($email === $user['email'] && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            "id" => $user['id'],
            "name" => $user['name'],
            "username" => $user['username'],
            "email" => $user['email'],
            "avatar" => $user['avatar'] ?? 'profile-icon.png',
        ];
        redirect('/index.php');
    } else {
        redirect('/about.php');
    }
}
