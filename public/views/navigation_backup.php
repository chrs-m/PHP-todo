<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">

    <div class="profile-container d-flex">
        <a class="navbar-brand" href="index.php"><?php echo $config['title']; ?></a>
        <img class="avatar" src="<?= '/app/database/avatars/' . $_SESSION['user']['avatar'] ?>" alt="Profile avatar image">
    </div>
    <div class="nav-list-container">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/index.php" || $_SERVER['REQUEST_URI'] === "/") ? 'active' : "" ?>" href="/index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/about.php") ? 'active' : "" ?>" href="/about.php">About</a>
            </li>

            <?php if (isLoggedIn()) : ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/lists.php") ? 'active' : "" ?>" href="/lists.php">Lists</a>
                </li>
            <?php endif; ?>
            <?php if (isLoggedIn()) : ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/profile.php") ? 'active' : "" ?>" href="/profile.php">My profile</a>
                </li>
            <?php endif; ?>

            <?php if (!isLoggedIn()) : ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] === "/login.php") ? 'active' : "" ?>" href="/login.php">Login</a>
                </li>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link" href="/logout.php">Log out</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
