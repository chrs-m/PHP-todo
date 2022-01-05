<nav class="bg-gray-800">
    <div class="mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">

                <!-- Mobile menu button-->
                <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>

                    <!-- Icon when menu is closed. -->
                    <svg class="block mobile-menu-icon-open h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <!-- Icon when menu is open. -->
                    <svg class="hidden mobile-menu-icon-close h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 flex items-center">
                    <a class="navbar-brand text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 text-xl font-bold ml-10 sm:ml-0" href="index.php"><?php echo $config['title']; ?></a>
                </div>
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <a href="/index.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white hover:underline px-3 py-2 rounded-md text-sm font-medium  <?php echo ($_SERVER['REQUEST_URI'] === "/index.php" || $_SERVER['REQUEST_URI'] === "/") ? 'active' : "" ?>">Home</a>
                        <?php if (isLoggedIn()) : ?>
                            <a href="/lists.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white hover:underline px-3 py-2 rounded-md text-sm font-medium<?php echo ($_SERVER['REQUEST_URI'] === "/lists.php") ? 'active' : "" ?>">Lists & tasks</a>
                        <?php endif; ?>
                        <?php if (isLoggedIn()) : ?>
                            <a href="/edit.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white hover:underline px-3 py-2 rounded-md text-sm font-medium<?php echo ($_SERVER['REQUEST_URI'] === "/edit.php") ? 'active' : "" ?>">Edit</a>
                        <?php endif; ?>
                        <?php if (isLoggedIn()) : ?>
                            <a href="/profile.php" class="text-gray-300 hover:bg-gray-700 hover:text-white hover:underline px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['REQUEST_URI'] === "/profile.php") ? 'active' : "" ?>">My profile</a>
                        <?php endif; ?>
                        <a href="/about.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white hover:underline px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['REQUEST_URI'] === " /about.php") ? 'active' : "" ?>">About</a>
                        <?php if (!isLoggedIn()) : ?>
                            <a href="/login.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['REQUEST_URI'] === "/login.php") ? 'active' : "" ?>">Login</a>
                        <?php else : ?>
                            <a href="/logout.php" class="focus:bg-gray-900 text-rose-500 hover:bg-gray-700 hover:text-rose-600 hover:underline px-3 py-2 rounded-md text-sm font-medium">Sign out</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Profile dropdown -->
            <div class="ml-3 relative">
                <div>
                    <button type="button" class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        <?php if (isLoggedIn()) : ?>
                            <img class="avatar h-8 w-8 rounded-full hover:border-solid hover:border-gray-100" src="<?= '/app/database/avatars/' . $_SESSION['user']['avatar'] ?>" alt="Profile avatar image">
                        <?php endif; ?>
                    </button>
                </div>

                <!-- Dropdown menu -->
                <div class="hidden profile-menu absolute right-0 mt-2 w-48 rounded-md shadow-xl drop-shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none animate-opacity" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <a href="/profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-100 hover:bg-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">My Profile</a>
                    <a href="/about.php" class="block px-4 py-2 text-sm text-gray-700 hover:text-gray-100 hover:bg-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">About</a>
                    <a href="/logout.php" class="block px-4 py-2 text-sm text-rose-700 hover:text-rose-400 hover:bg-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden mobile-menu bg-gray-700" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 text-center">
            <a href="/index.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium  <?php echo ($_SERVER['REQUEST_URI'] === "/index.php" || $_SERVER['REQUEST_URI'] === "/") ? 'active' : "" ?>">Home</a>

            <?php if (isLoggedIn()) : ?>
                <a href="/lists.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium<?php echo ($_SERVER['REQUEST_URI'] === "/lists.php") ? 'active' : "" ?>">Lists & tasks</a>
            <?php endif; ?>
            <?php if (isLoggedIn()) : ?>
                <a href="/edit.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium<?php echo ($_SERVER['REQUEST_URI'] === "/edit.php") ? 'active' : "" ?>">Edit</a>
            <?php endif; ?>
            <?php if (!isLoggedIn()) : ?>
                <a href="/login.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['REQUEST_URI'] === "/login.php") ? 'active' : "" ?>">Login</a>
                <a href="/about.php" class="focus:bg-gray-900 text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium <?php echo ($_SERVER['REQUEST_URI'] === " /about.php") ? 'active' : "" ?>">About</a>
            <?php else : ?>
                <a href="/logout.php" class="focus:bg-gray-900 text-rose-400 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sign out</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
