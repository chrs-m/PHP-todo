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
    <!-- MY TASKLISTS -->
    <div style="display: grid; grid-template: minmax(20vw, 100%) 1fr/ auto 1fr" class="">

        <div class="p-2 pt-2">
            <div id="listSideNav" class="sidenav h-full fixed w-0 top-0 left-0 bg-gray-900/95 overflow-x-hidden py-16 ">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                <div class="pb-3">
                    <div class="text-white font-bold underline decoration-2 decoration-fuchsia-500 text-lg px-2">My Tasklists</div>
                </div>
                <div class="pb-3 px-3">
                    <?php $listName = '';
                    foreach (getAllListsAndTasks($database, $_SESSION['user']['id']) as $userLists) :
                        if ($userLists['list_desc'] !== $listName) : ?>
                            <div class="p-1 pl-1 rounded-lg"><a class="text-white hover:underline hover:decoration-emerald-400" href="?id=<?= $userLists['list_id'] ?>"><?= $userLists['list_desc'] ?></a></div>
                        <?php endif; ?>
                        <?php $listName = $userLists['list_desc']; ?>
                    <?php endforeach; ?>
                </div>
                <div class="hover:underline hover:decoration-yellow-400 px-3 rounded-lg mb-6"><a href="/lists.php" class="text-white font-bold">All tasks</a></div>
                <a href="/create.php" class="block text-center bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold mt-8 ml-3 py-2 px-4 rounded focus:outline-none focus:shadow-outline w-1/2">Add list</a>
                <a href="/edit.php" class="block text-center bg-yellow-500 hover:bg-amber-500 text-white text-xs font-bold mt-2 ml-3 py-2 px-4 rounded focus:outline-none focus:shadow-outline w-1/2">Edit list(s)</a>
            </div>
        </div>

        <div class="w-full grid">
            <div class="px-2 py-2">

                <!-- TITLE -->
                <div class="px-2">
                    <?php if (!isset($_GET['id'])) : ?>
                        <h2 class="text-lg sm:text-2xl font-bold">Here are all your tasks!</h2>
                        <p class="text-xs sm:text-lg">Click on "<span class="italic">Show my lists</span>" to see all your lists.</p>
                    <?php else : ?>
                        <?php foreach (getListNameFromId($database, $_GET['id']) as $listName) : ?>
                            <h2 class="text-lg sm:text-2xl font-bold"><?= $listName['list_desc'] ?></h2>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- TO-DO LIST -->
                <div class="mt-2 px-2 grid justify-items-start">
                    <!-- TO-DO ITEM(S) -->
                    <!-- IF NO LIST ARE CHOOSEN, SHOW ALL MY TASKS SPLIT INTO 'TODAY' AND 'ALL TASKS' -->
                    <?php if (!isset($_GET['id'])) : ?>
                        <!-- TAP TO SHOW ALL TODAYS TASKS -->
                        <button class="show-todays-tasks text-lg sm:text-xl py-2 px-2 font-bold underline decoration-emerald-500">Show todays tasks <i class="fas fa-angle-down"></i></button>
                        <div class="hidden todays-tasks-container py-2 px-2">
                            <?php if (empty(getAllTodaysTasks($database, $_SESSION['user']['id']))) : ?>
                                <p class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-sky-700 leading-none text-lg font-bold mb-6 py-2 px-2">No tasks for today!</p>

                            <?php endif; ?>
                            <?php foreach (getAllTodaysTasks($database, $_SESSION['user']['id']) as $todaysTasks) : ?>
                                <div class="task-container flex flex-col justify-between py-2 px-2 my-2 hover:bg-gray-200 rounded-md">
                                    <div class="pl-4">
                                        <h2 class="<?= $todaysTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-lg' : 'text-gray-700 leading-none text-lg font-bold' ?>"><?= $todaysTasks['task_title'] ?></h2>
                                        <div class="<?= $todaysTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-xs' : 'text-xs leading-none text-gray-500' ?>">
                                            <?php if (!empty($allTasks['task_description'])) : ?>
                                                <p class="text-[0.8rem] sm:text-sm "><?= $todaysTasks['task_description'] . "<br>"; ?></p>
                                            <?php endif; ?>
                                            <?php if ($todaysTasks['task_deadline'] !== null && $todaysTasks['task_deadline'] < date('Y-m-d H:i')) : ?>
                                                <p class="<?= $todaysTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-[0.7rem] sm:text-xs' : "text-rose-500 text-[0.7rem] sm:text-xs" ?>"><?= $todaysTasks['task_deadline'] ?></p>
                                            <?php elseif ($todaysTasks['task_deadline'] !== null) : ?>
                                                <p class="<?= $todaysTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-[0.7rem] sm:text-xs' : "text-gray-400 text-[0.7rem] sm:text-xs" ?>"><?= $todaysTasks['task_deadline'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex pl-4">
                                        <?php if ($todaysTasks['task_completed'] === 'false') : ?>
                                            <form action="app/tasks/complete.php" method="POST">
                                                <input type="hidden" id="task_id_done" name="task_id_done" value="<?= $todaysTasks['task_id'] ?>"><button class="task-btn hidden w-14 bg-blue-500 hover:bg-green-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline" type="submit">Done</button>
                                            </form>
                                        <?php else : ?>
                                            <form action="app/tasks/complete.php" method="POST">
                                                <input type="hidden" id="task_id_undone" name="task_id_undone" value="<?= $todaysTasks['task_id'] ?>">
                                                <button class="task-btn hidden w-14 bg-blue-500 hover:bg-blue-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline" type="submit">Undone</button>
                                            </form>
                                        <?php endif; ?>

                                        <form action="app/tasks/delete.php" method="POST">
                                            <input type="hidden" id="task_id" name="task_id" value="<?= $todaysTasks['task_id'] ?>">
                                            <button type="submit" class="task-btn hidden w-14 bg-rose-500 hover:bg-rose-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                        </form>
                                        <form action="/edit.php" method="POST">
                                            <input type="hidden" id="task_id" name="task_id" value="<?= $todaysTasks['task_id'] ?>">
                                            <button type="submit" class="task-btn hidden w-14 bg-yellow-500 hover:bg-yellow-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- TAP TO SHOW ALL USERS TASKS! -->
                        <button class="show-all-tasks text-lg sm:text-xl py-2 px-2 font-bold underline decoration-emerald-500">Show all my tasks <i class="fas fa-angle-down"></i></button>
                        <div class="hidden all-tasks-container">
                            <?php foreach (getAllUserTasksByComplete($database, $_SESSION['user']['id']) as $allTasks) : ?>
                                <div class="task-container flex flex-col justify-between py-2 px-2 my-2 hover:bg-gray-200 rounded-md">
                                    <div class="pl-4">
                                        <h2 class="<?= $allTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-lg' : 'text-gray-700 leading-none text-lg font-bold' ?>"><?= $allTasks['task_title'] ?></h2>
                                        <div class="<?= $allTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-xs' : 'text-xs leading-none text-gray-500' ?>">
                                            <?php if (!empty($allTasks['task_description'])) : ?>
                                                <p class="text-[0.8rem] sm:text-sm "><?= $allTasks['task_description'] . "<br>"; ?></p>
                                            <?php endif; ?>
                                            <?php if ($allTasks['task_deadline'] !== null && $allTasks['task_deadline'] < date('Y-m-d H:i')) : ?>
                                                <p class="<?= $allTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-[0.7rem] sm:text-xs' : "text-rose-500 text-[0.7rem] sm:text-xs" ?>"><?= $allTasks['task_deadline'] ?></p>
                                            <?php elseif ($allTasks['task_deadline'] !== null) : ?>
                                                <p class="<?= $allTasks['task_completed'] === 'true' ? 'text-green-600 line-through text-[0.7rem] sm:text-xs' : "text-gray-400 text-[0.7rem] sm:text-xs" ?>"><?= $allTasks['task_deadline'] ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex pl-4">
                                        <?php if ($allTasks['task_completed'] === 'false') : ?>
                                            <form action="app/tasks/complete.php" method="POST">
                                                <input type="hidden" id="task_id_done" name="task_id_done" value="<?= $allTasks['task_id'] ?>"><button class="task-btn hidden w-14 bg-blue-500 hover:bg-green-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline" type="submit">Done</button>
                                            </form>
                                        <?php else : ?>
                                            <form action="app/tasks/complete.php" method="POST">
                                                <input type="hidden" id="task_id_undone" name="task_id_undone" value="<?= $allTasks['task_id'] ?>">
                                                <button class="task-btn hidden w-14 bg-blue-500 hover:bg-blue-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline" type="submit">Undone</button>
                                            </form>
                                        <?php endif; ?>

                                        <form action="app/tasks/delete.php" method="POST">
                                            <input type="hidden" id="task_id" name="task_id" value="<?= $allTasks['task_id'] ?>">
                                            <button type="submit" class="task-btn hidden w-14 bg-rose-500 hover:bg-rose-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                        </form>
                                        <form action="/edit.php" method="POST">
                                            <input type="hidden" id="task_id" name="task_id" value="<?= $allTasks['task_id'] ?>">
                                            <button type="submit" class="task-btn hidden w-14 bg-yellow-500 hover:bg-amber-500 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline">Edit</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <?php foreach (getAllTasksFromList($database, $_GET['id']) as $tasks) : ?>
                            <div class="task-container flex flex-col justify-between py-2 px-2 my-2 hover:bg-gray-200 rounded-md">
                                <div class="pl-4">
                                    <h2 class="<?= $tasks['task_completed'] === 'true' ? 'text-green-600 line-through text-lg' : 'text-gray-700 leading-none text-lg font-bold' ?>"><?= $tasks['task_title'] ?></h2>
                                    <div class="<?= $tasks['task_completed'] === 'true' ? 'text-green-600 line-through text-xs' : 'text-xs text-gray-400 leading-none' ?>">
                                        <?php if ($tasks['task_description'] !== null) : ?>
                                            <p class=""><?= $tasks['task_description'] . "<br>"; ?></p>
                                        <?php endif; ?>
                                        <?php if ($tasks['task_deadline'] !== null && $tasks['task_deadline'] < date('Y-m-d H:i')) : ?>
                                            <p class="<?= $tasks['task_completed'] === 'true' ? 'text-green-600 line-through text-xs' : "text-rose-500 text-xs" ?>"><?= $tasks['task_deadline'] ?></p>
                                        <?php elseif ($tasks['task_deadline'] !== null) : ?>
                                            <p class="text-xs"><?= $tasks['task_deadline'] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex pl-4">
                                    <?php if ($tasks['task_completed'] === 'false') : ?>
                                        <form action="app/tasks/complete.php" method="POST">
                                            <input type="hidden" id="task_id_done" name="task_id_done" value="<?= $tasks['task_id'] ?>"><button class="task-btn hidden w-14 bg-blue-500 hover:bg-green-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline" type="submit">Done</button>
                                        </form>
                                    <?php else : ?>
                                        <form action="app/tasks/complete.php" method="POST">
                                            <input type="hidden" id="task_id_undone" name="task_id_undone" value="<?= $tasks['task_id'] ?>">
                                            <button class="task-btn hidden w-14 bg-blue-500 hover:bg-blue-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline" type="submit">Undone</button>
                                        </form>
                                    <?php endif; ?>

                                    <form action="app/tasks/delete.php" method="POST">
                                        <input type="hidden" id="task_id" name="task_id" value="<?= $tasks['task_id'] ?>">
                                        <button type="submit" class="task-btn hidden w-14 bg-rose-500 hover:bg-rose-700 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                    </form>
                                    <form action="/edit.php" method="POST">
                                        <input type="hidden" id="task_id" name="task_id" value="<?= $tasks['task_id'] ?>">
                                        <button type="submit" class="task-btn hidden w-14 bg-yellow-500 hover:bg-amber-500 text-white text-[0.7rem] font-bold py-1 px-1 my-1 mr-1 rounded focus:outline-none focus:shadow-outline">Edit</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <a href="/create.php" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold mt-6 py-2 px-4 ml-2 rounded focus:outline-none focus:shadow-outline">Add task!</a>
                    <button class="bg-fuchsia-600 hover:bg-fuchsia-800 text-white text-xs font-bold mt-3 py-2 px-4 ml-2 rounded focus:outline-none focus:shadow-outline" onclick=openNav()>Show my lists</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
