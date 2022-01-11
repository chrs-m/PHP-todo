<?php

declare(strict_types=1);

require __DIR__ . '/../../autoload.php';


// DELETE USER + ALL TASKS AND LISTS FROM DB
if (isLoggedIn() && isset($_POST['delete-account']) && ($_POST['delete-account']) === $user['email']) {
    $id = (int) $user['id'];
    $userAvatar = pathinfo($user['avatar'])['basename'];

    $statement = $database->prepare('DELETE FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM tasks WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $statement = $database->prepare('DELETE FROM lists WHERE user_id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // IF USER HAVE CHOOSEN OWN AVATAR, REMOVE LOCAL COPY
    if ($userAvatar !== 'profile-icon.png') {
        unlink(__DIR__ . '/../../database/avatars/' . $userAvatar);
    }
} elseif (isLoggedIn() && empty(($_POST['delete-account']))) {
    $_SESSION['message'] = 'Sorry, you need to put in your e-mail in order to delete the account.';
    redirect('/profile.php');
} elseif ((isLoggedIn() && isset($_POST['delete-account']) && ($_POST['delete-account']) !== $user['email'])) {
    $_SESSION['message'] = 'Sorry, you put in the wrong e-mail address.';
    redirect('/profile.php');
}

unset($_SESSION['user']);
session_destroy();

redirect('/');
