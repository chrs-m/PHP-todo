<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';
?>

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

<?php elseif (isLoggedIn()) :

    $userId = $_SESSION['user']['id'];

    // QUERY TO GET ALL LISTS AND TASKS FOR THE USER
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
    $userListsAndTasks = $statement->fetchAll(PDO::FETCH_ASSOC);

    // $_GET['id'] = 1;
    // die(var_dump($_GET));
?>

    <!-- MY TASKLISTS -->
    <div class="grid grid-cols-3">
        <div class="bg-gray-50 h-screen col-span-1">
            <div class="p-2 pt-2">
                <div class="pb-3">
                    <div class="font-bold underline decoration-fuchsia-600 text-lg">My Tasklists</div>
                </div>
                <div class="pb-3">
                    <?php $listName = '';
                    foreach ($userListsAndTasks as $userListAndTask) :
                        if ($userListAndTask['list_desc'] !== $listName) : ?>
                            <div class="hover:bg-gray-200 p-0.5 pl-1 rounded-lg"><a href="?id=<?= $userListAndTask['list_id'] ?>"><?= $userListAndTask['list_desc'] ?></a></div>
                        <?php endif; ?>
                        <?php $listName = $userListAndTask['list_desc']; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="w-screen grid">
            <div class="px-2 py-2">

                <!-- TITLE -->
                <div>
                    <div class="text-2xl"><span class="font-bold">To-do:</span></div>
                </div>

                <!-- TO-DO LIST -->
                <div class="pt-5 grid justify-items-start col-span-2">
                    <!-- TO-DO ITEM(S) -->
                    <?php $listName = '';
                    foreach ($userListsAndTasks as $userListAndTask) :
                        if ($userListAndTask['task_list_id'] === $_GET['id']) : ?>
                            <div class="flex flex-row py-2">
                                <div class="flex items-center">
                                    <input style="width:25px; height:25px; background:white; border-radius:8px; border:2px solid #555;" class="" type="checkbox" id="<?= $userListAndTask['task_title'] ?>" name="<?= $userListAndTask['task_title'] ?>" value="">
                                </div>
                                <div class="pl-4">
                                    <div class="text-gray-600 leading-none font-bold"><?= $userListAndTask['task_title'] ?></div>
                                    <div class="text-xs text-gray-400 leading-none"><?= $userListAndTask['task_description'] . ", " . $userListAndTask['task_deadline']  ?></div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="flex flex-row py-2">
                                <div class="flex items-center">
                                    <input style="width:25px; height:25px; background:white; border-radius:8px; border:2px solid #555;" class="" type="checkbox" id="<?= $userListAndTask['task_title'] ?>" name="<?= $userListAndTask['task_title'] ?>" value="">
                                </div>
                                <div class=" pl-4">
                                    <div class="text-gray-600 leading-none font-bold"><?= $userListAndTask['task_title'] ?></div>
                                    <div class="text-xs text-gray-400 leading-none"><?= $userListAndTask['task_description'] . ", <br>" . $userListAndTask['task_deadline']  ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php $listName = $userListAndTask['task_list_id']; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php require __DIR__ . '/views/footer.php'; ?>
