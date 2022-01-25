<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// WHEN BUTTON IS PRESSED - SET ALL TO COMPLETED
if (isset($_POST['current_list_id'])) {
    $user_id = $_SESSION['user']['id'];
    $list_id = $_POST['current_list_id'];
    $completed = 'true';
    $date = date('Y-m-d H:i:s');

    $statement = $database->prepare(
        'UPDATE tasks SET completed = :completed, updated = :updated WHERE list_id = :list_id AND user_id = :user_id'
    );
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':list_id', $list_id, PDO::PARAM_INT);
    $statement->bindParam(':completed', $completed, PDO::PARAM_STR);
    $statement->bindParam(':updated', $date, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    redirect($_SERVER['HTTP_REFERER']);
}
