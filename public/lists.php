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
            </div>
        </div>
        <div class="w-full grid">
            <div class="px-2 py-2">

                <!-- TITLE -->
                <div>
                    <div class="text-2xl"><span class="font-bold">
                            <?php foreach (getListNameFromId($database, $_GET['id']) as $listName) : ?>
                                <h2><?= $listName['list_desc'] ?></h2>
                            <?php endforeach; ?>
                        </span></div>
                </div>

                <!-- TO-DO LIST -->
                <div class="pt-5 grid justify-items-start">
                    <!-- TO-DO ITEM(S) -->
                    <?php
                    foreach (getAllTasksFromList($database, $_GET['id']) as $tasks) : ?>
                        <div class="flex flex-row py-2">
                            <div class="flex items-center">
                                <input style="width:25px; height:25px; background:white; border-radius:8px; border:2px solid #555;" class="" type="checkbox" id="<?= $tasks['task_title'] ?>" name="<?= $tasks['task_title'] ?>" value="">
                            </div>
                            <div class="pl-4">
                                <div class="text-gray-600 leading-none font-bold"><?= $tasks['task_title'] ?></div>
                                <div class="text-xs text-gray-400 leading-none"><?= $tasks['task_description'] . ", " . $tasks['task_deadline']  ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
