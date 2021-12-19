<?php

declare(strict_types=1);

require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';
?>

<article class="py-6 px-6 grid justify-items-center">
    <?php if (!isLoggedIn()) : ?>
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
    <?php elseif (isLoggedIn()) : ?>
        <h2 class="mb-1 text-xl">Welcome, <?php echo $_SESSION['user']['name']; ?>!</h2>
        <p class="text-md mb-4">What do you need to accomplish today?</p>
        <a href="/lists.php" class="bg-blue-500 hover:bg-blue-700 text-sm text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Check and update lists!</a>
    <?php endif; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
