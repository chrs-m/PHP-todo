<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

// QUERY TO GET ALL LISTS AND TASKS FOR THE USER
$statement = $database->prepare('SELECT
lists.id AS list_id,
lists.description AS list_desc,
tasks.title AS task_title,
tasks.description as task_description,
tasks.user_id AS task_user_id,
tasks.id AS task_id,
tasks.deadline AS task_deadline,
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
$userListsAndTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- MY TASKS -->
<div class="flex flex-row">
    <div class="w-72 bg-gray-50 h-screen">
        <div class="p-4 pt-8">
            <div class="pb-3">
                <div class="font-bold">My Tasklists</div>
            </div>
            <div class="pb-3">
                <?php $listName = '';
                foreach ($userListsAndTasks as $userListAndTask) :
                    if ($userListAndTask['list_desc'] !== $listName) : ?>
                        <div class="hover:bg-gray-200 p-0.5 pl-2 rounded-lg"><a href="/"><?= $userListAndTask['list_desc'] ?></a></div>
                    <?php endif; ?>
                    <?php $listName = $userListAndTask['list_desc']; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="w-screen">
        <div class="px-6 pt-6">
            <!-- Title -->
            <div>
                <div class="text-3xl"><span class="font-bold">Today</span></div>
            </div>

            <!-- Todo List -->
            <div class="pt-10">
                <!-- Todo Item -->
                <div class="flex flex-row pb-2">
                    <div class="flex items-center">
                        <input class="text-3xl" type="checkbox" id="" name="" value="">
                    </div>
                    <div class=" pl-4">
                        <div class="text-gray-600 leading-none">Task 1</div>
                        <div class="text-xs text-gray-400 leading-none">Be done with task 1</div>
                    </div>
                </div>
                <!-- Todo Item -->
                <div class="flex flex-row pb-2">
                    <div class="flex items-center">
                        <input class="text-3xl" type="checkbox" id="" name="" value="">
                    </div>
                    <div class="pl-4">
                        <div class="text-gray-600 leading-none">Task 1</div>
                        <div class="text-xs text-gray-400 leading-none">Be done with task 1</div>
                    </div>
                </div>
                <!-- Todo Item -->
                <div class="flex flex-row pb-2">
                    <div class="flex items-center">
                        <input class="text-3xl" type="checkbox" id="" name="" value="">
                    </div>
                    <div class="pl-4">
                        <div class="text-gray-600 leading-none">Task 1</div>
                        <div class="text-xs text-gray-400 leading-none">Be done with task 1</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php require __DIR__ . '/views/footer.php'; ?>
