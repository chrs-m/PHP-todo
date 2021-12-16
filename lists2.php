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

<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="bg-gray-800 w-full">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!--
            Icon when menu is closed.

            Heroicon name: outline/menu

            Menu open: "hidden", Menu closed: "block"
          -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!--
            Icon when menu is open.

            Heroicon name: outline/x

            Menu open: "block", Menu closed: "hidden"
          -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 flex items-center">
                    <a class="navbar-brand" href="index.php"><?php echo $config['title']; ?></a>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="#" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page">Dashboard</a>

                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Team</a>

                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Projects</a>

                        <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Calendar</a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                    <span class="sr-only">View notifications</span>
                    <!-- Heroicon name: outline/bell -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>

                <!-- Profile dropdown -->
                <div class="ml-3 relative">
                    <div>
                        <button type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="avatar h-8 w-8 rounded-full" src="<?= '/app/database/avatars/' . $_SESSION['user']['avatar'] ?>" alt="Profile avatar image">
                        </button>
                    </div>

                    <!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
                    <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium" aria-current="page">Dashboard</a>

            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

            <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendar</a>
        </div>
    </div>
</nav>


<!-- TO DO SITE INSPO -->
<div class="flex flex-row">
    <div class="w-72 bg-gray-50 h-screen">
        <div class="p-4 pt-8">
            <div class="pb-3">
                <div class="p-0.5 pl-2">📦 Inbox</div>
            </div>
            <div class="pb-3">
                <div class="bg-gray-200 p-0.5 pl-2 rounded-lg">⭐ <a href="./index.html">Today</a></div>
                <div class="p-0.5 pl-2">📅 <a href="./upcoming.html">Upcoming</a></div>
                <div class="p-0.5 pl-2">📚 <a href="./anytime.html">Anytime</a></div>
                <div class="p-0.5 pl-2">📁 Someday</div>
            </div>
            <div class="pb-3">
                <div class="p-0.5 pl-2">📗 Logbook</div>
                <div class="p-0.5 pl-2">🗑️ Trash</div>
            </div>
            <div class="pb-3">
                <div class="p-0.5 pl-2">⛱️ Vacation in Rome</div>
                <div class="p-0.5 pl-2">🏢 Work</div>
                <div class="p-0.5 pl-2">🎂 Jen's birthday</div>
            </div>
        </div>
    </div>
    <div class="w-screen">
        <div class="px-32 pt-24">
            <!-- Title -->
            <div>
                <div class="text-3xl">⭐<span class="font-bold"> Today</span></div>
            </div>

            <!-- Todo List -->
            <div class="pt-10">
                <!-- Todo Item -->
                <div class="flex flex-row pb-2">
                    <div class="flex items-center">
                        <input class="text-3xl" type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                    </div>
                    <div class="pl-4">
                        <div class="text-gray-600 leading-none">Borrow Sarah's travel guide</div>
                        <div class="text-xs text-gray-400 leading-none">Vacation in Rome</div>
                    </div>
                </div>
                <!-- Todo Item -->
                <div class="flex flex-row pb-2">
                    <div class="flex items-center">
                        <input class="text-3xl" type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                    </div>
                    <div class="pl-4">
                        <div class="text-gray-600 leading-none">Finish expense report</div>
                        <div class="text-xs text-gray-400 leading-none">Work</div>
                    </div>
                </div>
                <!-- Todo Item -->
                <div class="flex flex-row pb-2">
                    <div class="flex items-center">
                        <input class="text-3xl" type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                    </div>
                    <div class="pl-4">
                        <div class="text-gray-600 leading-none">Buy birthday cake</div>
                        <div class="text-xs text-gray-400 leading-none">Jen's birthday</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php require __DIR__ . '/views/footer.php'; ?>
