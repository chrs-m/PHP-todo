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


// IF YOU ARE LOGGED IN, YOU ARE ABLE TO CHANGE YOUR AVATAR

if (isset($_SESSION['user'])) {
    if (isset($_FILES['update-avatar'])) {
        // VARIABLES TO GIVES UPLOADED IMAGES RANDOM NAME OF NUMBERS AND THE CORRECT FILE EXTENSION
        $fileExt = pathinfo($_FILES['update-avatar']['type'])['filename'];
        $imgName = date('Ymd') . "_" . random_int(1, 999999) . '_' . random_int(1, 999999) . "." . $fileExt;

        $newAvatar = $_FILES['avatar'];


        $statement = $database->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
        $statement->bindParam(':avatar', $imgName, PDO::PARAM_STR);
        $statement->execute();


        $errors = [];

        // CHECKS IF IMAGE IS PNG OR JPEG
        if ($avatar['type'] !== 'image/png' &&  $avatar['type'] !== 'image/jpeg') {
            $_SESSION['message'] = 'The ' . $avatar['name'] . ' image file type is not allowed.';
        } elseif ($avatar['size'] >= 3145728) {
            $errors[] = 'The uploaded file ' . $avatar['name'] . ' exceeded the filesize limit.';
        }

        // PUTS THE IMAGE TO THE UPLOADS FOLDER
        $destinationAndName = __DIR__ . '/../database/avatars/' . $imgName;
        // print_r(explode('/', $_FILES['type']));
        // die(var_dump($destination));

        move_uploaded_file($newAvatar['tmp_name'], $destinationAndName);
    }
}
