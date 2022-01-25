<?php

declare(strict_types=1);

//Vendor
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Dotenv\Dotenv;

// Redirect function
/**
 * @param string $path
 * @return never
 */
function redirect(string $path)
{
    header("Location: ${path}");

    exit;
}


// CHECKES IF USER IS LOGGED IN OR NOT
/** @return bool  */
function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

if (isLoggedIn()) {
    $user = $_SESSION['user'];
}

// QUERY TO GET ALL LISTS AND TASKS FOR THE USER
/**
 * @param mixed $database
 * @param mixed $userId
 * @return mixed
 */
function getAllListsAndTasks(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT
    lists.id AS list_id,
    lists.description AS list_desc,
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM
    lists
    INNER JOIN users ON lists.user_id = users.id
    LEFT JOIN tasks ON lists.id = tasks.list_id
    WHERE lists.user_id = :id
    ORDER BY list_desc ASC;');
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $getAllUserListsAndTasks = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getAllUserListsAndTasks;
}

// QUERY TO GET ALL TASKS BELONGING TO LIST_ID ($_GET)
/**
 * @param mixed $database
 * @param mixed $id
 * @return mixed
 */
function getAllTasksFromList(PDO $database, string $id): array
{
    $statement = $database->prepare('SELECT
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM tasks
    WHERE task_list_id = :list_id
    ORDER BY
    task_completed ASC,
    task_deadline ASC;');
    $statement->bindParam(':list_id', $id, PDO::PARAM_INT);
    $statement->execute();
    $getAllTasksFromList = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getAllTasksFromList;
}

//QUERY TO GET THE LIST NAME FOR THE SELECTED LIST
/**
 * @param PDO $database
 * @param string $id
 * @return array
 * @throws PDOException
 */
function getListNameFromId(PDO $database, string $id): array
{
    $statement = $database->prepare('SELECT
    lists.id AS list_id,
    lists.description AS list_desc,
    lists.user_id AS list_user_id
    FROM lists
    WHERE list_id = :list_id');
    $statement->bindParam(':list_id', $id, PDO::PARAM_INT);
    $statement->execute();
    $getListFromId = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getListFromId;
}

// QUERY TO GET ALL LISTS AND TASKS FOR THE USER SORTED BY COMPLETE STATUS
/**
 * @param PDO $database
 * @param int $userId
 * @return array
 * @throws PDOException
 */
function getAllTasksByComplete(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT
    lists.id AS list_id,
    lists.description AS list_desc,
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM
    lists
    INNER JOIN users ON lists.user_id = users.id
    LEFT JOIN tasks ON lists.id = tasks.list_id
    WHERE lists.user_id = :id
    ORDER BY
    task_completed ASC,
    task_deadline ASC;');
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $getAllTasksByComplete = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getAllTasksByComplete;
}

// QUERY TO GET ALL TASKS FOR THE USER SORTED BY COMPLETE STATUS
/**
 * @param PDO $database
 * @param int $userId
 * @return array
 * @throws PDOException
 */
function getAllUserTasksByComplete(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM
    tasks
    WHERE user_id = :id
    ORDER BY
    task_completed ASC,
    task_deadline ASC;');
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $getAllUserTasksByComplete = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getAllUserTasksByComplete;
}

// QUERY TO GET ALL TASKS FOR THE USER SORTED BY TITLE
/**
 * @param PDO $database
 * @param int $userId
 * @return array
 * @throws PDOException
 */
function getAllUserTasksByTitle(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM
    tasks
    WHERE user_id = :id
    ORDER BY
    task_title ASC,
    task_deadline ASC;');
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->execute();
    $getAllUserTasksByTitle = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getAllUserTasksByTitle;
}


// QUERY TO GET ALL LISTS AND TASKS WHERE DEADLINE IS TODAY
/**
 * @param PDO $database
 * @param int $userId
 * @return array
 * @throws PDOException
 */
function getAllTodaysTasks(PDO $database, int $userId): array
{
    $todayStart = date("Y-m-d H:i:s", mktime(00, 00, 01));
    $todayEnd = date("Y-m-d H:i:s", mktime(23, 59, 59));

    $statement = $database->prepare('SELECT
    tasks.title AS task_title,
    tasks.description as task_description,
    tasks.user_id AS task_user_id,
    tasks.id AS task_id,
    REPLACE (tasks.deadline, "T", " ") as task_deadline,
    tasks.created AS task_created,
    tasks.updated AS task_updated,
    tasks.list_id AS task_list_id,
    tasks.completed AS task_completed
    FROM
    tasks
    WHERE user_id = :id
    AND task_deadline BETWEEN :todayStart
	AND :todayEnd
    ORDER BY
    task_completed ASC,
    task_deadline ASC;');
    $statement->bindParam(':id', $userId, PDO::PARAM_INT);
    $statement->bindParam(':todayStart', $todayStart, PDO::PARAM_STR);
    $statement->bindParam(':todayEnd', $todayEnd, PDO::PARAM_STR);
    $statement->execute();
    $getAllTodaysTasks = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $getAllTodaysTasks;
}

// SENDING AN EMAIL

function sendEmail(string $email, string $name): void
{
    $dotenv = new Dotenv();
    $dotenv->loadEnv(__DIR__ . '/../../.env');
    $password = $_ENV['EMAIL_PASSWORD'];
    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "antmar0417@skola.goteborg.se";
        // Type a password here
        $mail->Password = "$password";
        $mail->Subject = "Wunderlist";
        $mail->setFrom("antmar0417@skola.goteborg.se");
        $mail->isHTML(true);
        $mail->Body = "<h1>Hello $name! </h1><p>Thanks for creating an account!</p>";
        // Reciever
        $mail->addAddress("$email");
        $mail->Send();
        echo "email sent!";

        $mail->smtpClose();
    } catch (Exception $e) {
        echo 'Error: ', $mail->ErrorInfo;
    }
}
