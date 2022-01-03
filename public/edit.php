<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$userId = $_SESSION['user']['id'];

getAllListsAndTasks($database, $_SESSION['user']['id']);


?>
<!-- EDIT YOUR LISTS HERE -->
<section class="px-8 pt-6 pb-8 mb-4">
    <form class="edit-list-container" action="/app/lists/edit.php" method="post" enctype="multipart/form-data">
        <div class="form-container">
            <h2 class="font-bold text-xl mb-2 underline decoration-pink-500">Edit list</h2>
            <select class="task-list focus:invalid:border-pink-500 shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xs" name="dropdown-list-id" required>
                <option value="">--Please choose a list (dropdown menu)--</option>
                <?php
                $listName = '';
                foreach (getAllListsAndTasks($database, $_SESSION['user']['id']) as $userList) :
                    if ($userList['list_desc'] !== $listName) : ?>
                        <option value="<?= $userList['list_id'] ?>"><?= $userList['list_desc'] ?></option>
                    <?php endif; ?>
                    <?php $listName = $userList['list_desc']; ?>
                <?php endforeach; ?>
            </select>
            <div class="edit-list">

                <label for="list-description" class="block text-gray-700 text-sm font-bold mb-2">Please enter the new list name</label>
                <input class="description-field focus:invalid:border-pink-500 block shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" type="text" name="new-list-description" placeholder="New list name"></input>
                <button class="submit bg-blue-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 mt-3 mb-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="update-list-button" value="update-list">Update list</button>
                <button class="submit bg-rose-500 hover:bg-rose-700 text-white text-xs font-bold py-2 px-4 mt-3 mb-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="delete-list-button" value="delete-list">Delete list</button>
            </div>
    </form>
    </div>

    <!-- EDIT YOUR TASKS HERE -->
    <form class="edit-post-container" action="/app/tasks/edit.php" method="post" enctype="multipart/form-data">
        <div class="form-container">
            <h2 class="font-bold text-xl mb-2 mt-4 underline decoration-pink-500">Edit task</h2>
            <div class="create-task">
                <select class="task-list focus:invalid:border-pink-500 shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 mb-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xs" name="dropdown-task-id" required>
                    <option value="">--Please choose task (dropdown menu)--</option>
                    <?php
                    $listName = '';
                    foreach (allUserTasksByTitle($database, $_SESSION['user']['id']) as $userTask) :
                        if ($userTask['list_desc'] !== $listName) : ?>
                            <option value="<?= $userTask['task_id'] ?>"><?= $userTask['task_title'] ?></option>
                        <?php endif; ?>
                        <?php $listName = $userTask['task_id']; ?>
                    <?php endforeach; ?>
                </select>
                <label for="task-title" class="block text-gray-700 text-sm font-bold mb-2">New title for your task</label>
                <input class="task-title focus:invalid:border-pink-500 shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" type="text" name="new-task-title" required placeholder="Whats your task?"></input>
                <small class="block text-xs text-gray-500 italic px-1 py-1 mb-3">Enter the new title.</small>

                <label for="task-description" class="block text-gray-700 text-sm font-bold mb-2">Description of your task</label>
                <input class="task-description shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-sm" type="text" name="new-task-description" placeholder="Extra description?"></input>
                <small class="block text-xs text-gray-500 italic px-1 py-1 mb-3">New details? (optional)</small>
                <label for="task-title" class="block text-gray-700 text-sm font-bold mb-2">Choose a new list for your task</label>
                <!-- LOOPS OUT EVERY LIST CONNECTED TO THE USER -->
                <select class="task-list focus:invalid:border-pink-500 shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 mb-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xs" name="new-task-list">
                    <option value="">--Please choose a list (dropdown menu)--</option>
                    <?php
                    $listName = '';
                    foreach (getAllListsAndTasks($database, $_SESSION['user']['id']) as $userList) :
                        if ($userList['list_desc'] !== $listName) : ?>
                            <option value="<?= $userList['list_id'] ?>"><?= $userList['list_desc'] ?></option>
                        <?php endif; ?>
                        <?php $listName = $userList['list_desc']; ?>
                    <?php endforeach; ?>
                </select>
                <label for="task-deadline" class="block text-gray-700 text-sm font-bold mb-2">Do you have a deadline?</label>
                <input class="task-deadline shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-xs" type="datetime-local" name="new-task-deadline"></input>
                <small class="block text-xs text-gray-500 italic px-1 py-1 mb-3">Update your deadline (optional).</small>

                <button class="submit bg-blue-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 mt-3 rounded focus:outline-none focus:shadow-outline" type="submit" name="update-task-button" value="update-task">Update task</button>
                <button class="submit bg-rose-500 hover:bg-rose-700 text-white text-xs font-bold py-2 px-4 mt-3 rounded focus:outline-none focus:shadow-outline" type="submit" name="delete-task-button" value="delete-task">Delete task</button>
            </div>
    </form>
    </div>
</section>


<?php require __DIR__ . '/views/footer.php'; ?>
