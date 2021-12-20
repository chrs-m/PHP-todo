<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';
?>
<!-- IF THE USER IS NOT LOGGED IN, THE LOGIN PAGE WILL SHOW -->
<?php if (!isLoggedIn()) : ?>
    <article class="py-6 px-6 grid justify-items-center">
        <?php $_SESSION['message'] = "Welcome stranger!"; ?>
        <p class="font-bold text-2xl underline decoration-indigo-700"> <?php echo $_SESSION['message']; ?></p>
        <div class="mt-24 w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="app/users/login.php" method="post">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">E-mail</label>
                    <input class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 disabled:shadow-none invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500" type="email" name="email" id="email" placeholder="your@email.com" required>
                    <small class="text-xs italic">Please provide your email address.</small>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2 mt-4" for="password">Password</label>
                        <input class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name="password" id="password" placeholder="******************" required>
                        <small class="text-xs italic">Please provide your password (passphrase).</small>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Sign In</button>
                        <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">Forgot Password?</a>
                    </div>
                </div>
                <a href="/signup.php" class="block text-center font-bold text-blue-300 mt-8">No account? Sign up here!</a>
            </form>
        </div>
    </article>

    <!-- IF THE USER IS LOGGED IN, THE LIST VIEW WILL BE SHOWN -->
<?php elseif (isLoggedIn()) : ?>
    <?php
    // A QUERY TO GET ALL LISTS AND TASKS FOR THE USER
    getAllListsAndTasks($database, $_SESSION['user']['id']);

    ?>

    <!-- MY TASKLISTS -->
    <div style="display: grid; grid-template: minmax(20vw, 100%) 1fr/ auto 1fr" class="">
        <div class="bg-gray-50 h-screen col-span-1">
            <div class="p-2 pt-2">
                <div class="pb-3">
                    <div class="font-bold underline decoration-fuchsia-600 text-lg">My Tasklists</div>
                </div>
                <div class="pb-3">
                    <?php $listName = '';
                    foreach (getAllListsAndTasks($database, $_SESSION['user']['id']) as $userLists) :
                        if ($userLists['list_desc'] !== $listName) : ?>
                            <div class="hover:bg-gray-200 p-0.5 pl-1 rounded-lg"><a href="?id=<?= $userLists['list_id'] ?>"><?= $userLists['list_desc'] ?></a></div>
                        <?php endif; ?>
                        <?php $listName = $userLists['list_desc']; ?>
                    <?php endforeach; ?>
                </div>
                <a href="/create.php" class="bg-blue-500 hover:bg-green-700 text-white text-xs font-bold mt-8 py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add list!</a>
            </div>
        </div>
        <div class="w-full grid">
            <div class="px-2 py-2">

                <!-- TITLE -->
                <div class="text-2xl px-2"><span class="font-bold">
                        <?php if (!isset($_GET['id'])) : ?>
                            <p>Please choose a list to check of those tasks!</p>
                        <?php else : ?>
                            <?php foreach (getListNameFromId($database, $_GET['id']) as $listName) : ?>
                                <h2><?= $listName['list_desc'] ?></h2>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </span>
                </div>

                <!-- TO-DO LIST -->
                <div class="mt-2 px-2 grid justify-items-start">
                    <!-- TO-DO ITEM(S) -->
                    <?php if (!isset($_GET['id'])) : ?>
                        <p>Today is the perfect day for things to be done!</p>
                    <?php else : ?>
                        <?php foreach (getAllTasksFromList($database, $_GET['id']) as $tasks) : ?>
                            <div class="task-container flex flex-row justify-between py-2 px-2 my-2 hover:bg-gray-200 rounded-md w-96">
                                <div class="pl-4">
                                    <div class="<?= $tasks['task_completed'] === 'true' ? 'text-green-600 line-through' : 'text-gray-600 leading-none font-bold' ?>"><?= $tasks['task_title'] ?></div>
                                    <div class=" text-xs text-gray-400 leading-none"><?php if ($tasks['task_description'] !== null) : ?>
                                            <?= $tasks['task_description'] . "<br>"; ?>
                                        <?php endif; ?>
                                        <?php if ($tasks['task_deadline'] !== null && $tasks['task_deadline'] < date('Y-m-d H:i')) : ?>
                                            <p class="<?= $tasks['task_completed'] === 'true' ? 'text-green-600 line-through' : "text-rose-500" ?>"><?= $tasks['task_deadline'] ?></p>
                                        <?php elseif ($tasks['task_deadline'] !== null) : ?>
                                            <p><?= $tasks['task_deadline'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="">
                                    <form action="app/tasks/complete.php" method="POST">
                                        <button class="task-btn hidden w-14 bg-blue-500 hover:bg-green-700 text-white text-xs font-bold py-2 px-2 my-1 rounded focus:outline-none focus:shadow-outline" type="submit">Done</button>
                                        <input type="hidden" id="task_id" name="task_id" value="<?= $tasks['task_id'] ?>">
                                    </form>
                                    <form action="app/lists/delete.php" method="post">
                                        <input type="hidden" id="task_delete" name="task_delete" value="<?= $tasks['task_id'] ?>">
                                        <button type="submit" class="task-btn hidden w-14 bg-rose-500 hover:bg-rose-700 text-white text-xs font-bold py-2 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <a href="/create.php" class="bg-blue-500 hover:bg-green-700 text-white text-xs font-bold mt-8 py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add task!</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
