<?php

declare(strict_types=1);

require __DIR__ . '/../../autoload.php';


// IF YOU ARE LOGGED IN, YOU ARE ABLE TO CHANGE YOUR AVATAR

if (isset($_SESSION['user']) && isset($_FILES['update-avatar'])) {
    // VARIABLES TO GIVES UPLOADED IMAGES RANDOM NAME OF NUMBERS AND THE CORRECT FILE EXTENSION
    $id = $_SESSION['user']['id'];
    $fileExt = pathinfo($_FILES['update-avatar']['type'])['filename'];
    $imgName = date('Ymd') . "_" . random_int(1, 999999) . '_' . random_int(1, 999999) . "." . $fileExt;

    $newAvatar = $_FILES['update-avatar'];

    $statement = $database->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_STR);
    $statement->bindParam(':avatar', $imgName, PDO::PARAM_STR);
    $statement->execute();


    $errors = [];

    // CHECKS IF IMAGE IS PNG OR JPEG
    if ($newAvatar['type'] !== 'image/png' &&  $newAvatar['type'] !== 'image/jpeg') {
        $_SESSION['message'] = 'The ' . $newAvatar['name'] . ' image file type is not allowed.';
    } elseif ($newAvatar['size'] >= 3145728) {
        $errors[] = 'The uploaded file ' . $newAvatar['name'] . ' exceeded the filesize limit.';
    }

    // PUTS THE IMAGE TO THE UPLOADS FOLDER
    $destinationAndName = __DIR__ . '/../../database/avatars/' . $imgName;

    move_uploaded_file($newAvatar['tmp_name'], $destinationAndName);

    // SETS THE NEW AVATAR TO BE DISPLAYED IN THE SESSION
    $_SESSION['user']['avatar'] = $imgName;

    $_SESSION['message'] = "Your avatar has been changed!";
    redirect('/profile.php');
}
