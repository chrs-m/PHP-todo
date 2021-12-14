<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// In this file we update our users info.
if (isset($_SESSION['user'])) {
    $registeredEmail = trim(filter_var($_POST['new-email'], FILTER_SANITIZE_EMAIL));
    $id = $_SESSION['user']['id'];

    $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // die(var_dump($_POST));

    // IF YOU ARE LOGGED IN, YOU ARE ABLE TO CHANGE YOUR EMAIL
    if (isset($_POST['new-email'])) {
        $statement = $database->prepare('UPDATE users SET email = :email WHERE id = :id');
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':email', $registeredEmail, PDO::PARAM_STR);
        $statement->execute();


        $_SESSION['message'] = "Your email has been changed!";
        redirect('/profile.php');
        echo $_SESSION['message'];
    } else {
        $_SESSION['message'] = "Thats not a valid email address!";
        echo $_SESSION['message'];
    }
}
