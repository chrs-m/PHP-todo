<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article class="py-6 px-6 grid justify-items-center">
    <?php if (!isLoggedIn()) : ?>
        <?php $_SESSION['message'] = "Welcome stranger!"; ?>
        <p class="font-bold text-2xl underline decoration-indigo-700"> <?php echo $_SESSION['message']; ?></p>
    <?php endif; ?>
    <div class="flex mt-24 w-full max-w-xs">
        <form class="reset-form bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="/app/users/reset-password.php" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="reset-password">Email address</label>
                <input class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500" type="email" name="email" id="email">
                <small class="text-xs text-gray-500 italic">We'll never share your email with anyone else.</small>
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Send reset link
            </button>
            <a class="flex justify-center mt-7 text-blue-300 hover:text-fuchsia-400" href="/signup.php">No account? Sign up here!</a>
            <a class="flex justify-center mt-2 text-blue-300 hover:text-fuchsia-400" href="/index.php">Remember your password? Sign in!</a>
        </form>
    </div>
    <div class="hidden reset-message bg-gray-100 py-2 px-2 rounded-md drop-shadow-md">
        <p class="text-[12px] sm:text-base">A reset link may or may not have been sent to you.</p>
        <p class="text-[12px] sm:text-sm text-center">¯\_(ツ)_/¯</p>
    </div>
</article>



<?php require __DIR__ . '/views/footer.php'; ?>
