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
        <a href="/lists.php" class="bg-sky-600 hover:bg-blue-700 text-sm text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Go to your lists and tasks!</a>
        <svg class="w-56 mt-24 fill-sky-400 animate-wiggle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
            <path d="M400,48H112a64.07,64.07,0,0,0-64,64V400a64.07,64.07,0,0,0,64,64H400a64.07,64.07,0,0,0,64-64V112A64.07,64.07,0,0,0,400,48ZM364.25,186.29l-134.4,160a16,16,0,0,1-12,5.71h-.27a16,16,0,0,1-11.89-5.3l-57.6-64a16,16,0,1,1,23.78-21.4l45.29,50.32L339.75,165.71a16,16,0,0,1,24.5,20.58Z" />
        </svg>
        <!-- <img src="assets/images/checkbox.png" alt="" class="animate-wiggle"> -->
    <?php endif; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
