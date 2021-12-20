<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

$statement = $database->prepare('SELECT * FROM lists WHERE user_id = :id');
$statement->bindParam(':id', $userId, PDO::PARAM_INT);
$statement->execute();

$userLists = $statement->fetchAll(PDO::FETCH_ASSOC);


?>
<section class="px-8 pt-6 pb-8 mb-4">
    <h2 class="font-bold text-xl mb-2 underline decoration-pink-500">Create list</h2>
    <div class="create-list">
        <form class="create-post-container" action="/app/lists/create.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <label for="list-description" class="block text-gray-700 text-sm font-bold mb-2">Please give your list a name</label>
                <input class="description-field focus:invalid:border-pink-500 block shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" type="text" name="list-description" required placeholder="List name"></input>
                <button class="submit bg-blue-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 mt-3 mb-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="button">Create list</button>
            </div>
        </form>
    </div>

    <h2 class="font-bold text-xl mb-2 mt-4 underline decoration-pink-500">Create task</h2>
    <div class="create-task">
        <form class="create-post-container" action="/app/tasks/create.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <label for="task-title" class="block text-gray-700 text-sm font-bold mb-2">Title of your task</label>
                <input class="task-title focus:invalid:border-pink-500 shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" type="text" name="task-title" required placeholder="Whats your task?"></input>
                <small class="block text-xs italic mb-3">Please give your task a name.</small>

                <label for="task-description" class="block text-gray-700 text-sm font-bold mb-2">Description of your task</label>
                <input class="task-description shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" type="text" name="task-description" placeholder="Extra description?"></input>
                <small class="block text-xs italic mb-3">Please fill in if you want more details.</small>
                <label for="task-title" class="block text-gray-700 text-sm font-bold mb-2">Choose a list for your task</label>
                <!-- LOOPS OUT EVERY LIST CONNECTED TO THE USER -->
                <select class="task-list focus:invalid:border-pink-500 shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xs" name="task-list" required>
                    <option value="">--Please choose a list (dropdown menu)--</option>
                    <?php
                    foreach ($userLists as $userList) { ?>
                        <option value="<?= $userList['id'] ?>"><?= $userList['description'] ?></option>
                    <?php } ?>
                </select>
                <label for="task-deadline" class="block text-gray-700 text-sm font-bold mb-2">Do you have a deadline?</label>
                <input class="task-deadline shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xs" type="datetime-local" name="task-deadline"></input>
                <small class="block text-xs italic mb-3">Pick your deadline (optional).</small>

                <button class="submit bg-blue-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 mt-3 mb-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="button">Create task</button>
            </div>
        </form>
    </div>
</section>


<?php require __DIR__ . '/views/footer.php'; ?>
