<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article class="flex justify-center">
    <div class="flex mt-24 w-full max-w-xs">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="app/users/login.php" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    E-mail
                </label>
                <input class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500" type="email" name="email" id="email" placeholder="your@email.com" required>
                <small class="text-xs italic">Please provide your email address.</small>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2 mt-4" for="password">
                        Password
                    </label>
                    <input class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" name="password" id="password" placeholder="******************" required>
                    <small class="text-xs italic">Please provide your password (passphrase).</small>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Forgot Password?
                    </a>
                </div>
        </form>
        <a class="flex justify-center mt-3 text-blue-300" href="/signup.php">No account? Sign up here!</a>
    </div>
</article>



<?php require __DIR__ . '/views/footer.php'; ?>
