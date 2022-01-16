<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// HERE WE REGISTER NEW USERS
if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm-password'])) {
    if ($_POST['confirm-password'] !== $_POST['password']) {
        $_SESSION['message'] = "Sorry, your passwords do not match. Please try again.";
        redirect('/signup.php');
    } else {
        $name = trim(filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS));
        $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $statement = $database->prepare('SELECT email, username FROM users WHERE email = :email AND username = :username');

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user && $email === $user['email'] && $username === $user['username']) {
            $_SESSION['message'] = "You already have an account! Try sign in instead.";
            redirect('/login.php');
        } else {
            // IF USER DOES NOT CHOOSE AVATAR, THE DEFAULT WILL BE SHOWN WHEN LOGGED IN
            if (empty($_FILES['avatar']['name'])) {
                $imgName = null;
            } elseif (!empty($_FILES['avatar'])) {
                // VARIABLES TO GIVES UPLOADED IMAGES RANDOM NAME OF NUMBERS AND THE CORRECT FILE EXTENSION
                $fileExt = pathinfo($_FILES['avatar']['type'])['filename'];
                $imgName = date('Ymd') . "_" . random_int(1, 999999) . '_' . random_int(1, 999999) . "." . $fileExt;

                $avatar = $_FILES['avatar'];

                $errors = [];

                // CHECKS IF IMAGE IS PNG OR JPEG
                if ($avatar['type'] !== 'image/png' &&  $avatar['type'] !== 'image/jpeg') {
                    $_SESSION['message'] = 'The ' . $avatar['name'] . ' image file type is not allowed.';
                } elseif ($avatar['size'] >= 3145728) {
                    $errors[] = 'The uploaded file ' . $avatar['name'] . ' exceeded the filesize limit.';
                }

                // PUTS THE IMAGE TO THE UPLOADS FOLDER
                $destinationAndName = __DIR__ . '/../database/avatars/' . $imgName;

                move_uploaded_file($avatar['tmp_name'], $destinationAndName);
            }

            $statement = $database->prepare('INSERT INTO users(name, email, username, password, avatar) VALUES(:name, :email, :username, :password, :avatar)');

            $statement->bindParam(':name', $name, PDO::PARAM_STR);
            $statement->bindParam(':username', $username, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':password', $password, PDO::PARAM_STR);
            $statement->bindParam(':avatar', $imgName, PDO::PARAM_STR);

            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            // SENDING AN EMAIL TO THE USER
            sendEmail($email, $name);

            $_SESSION['message'] = 'Account created! Please login in with your new credentials.';
            redirect('/index.php');
        }
        redirect('/about.php');
    }
}
