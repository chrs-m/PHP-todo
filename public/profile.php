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
    <div class="px-6 py-6">
        <h2 class="text-2xl font-bold mb-2">Hi, <?php echo $_SESSION['user']['name']; ?>!</h2>
        <img class="avatar rounded-full h-24 mb-6" src="<?= '/app/database/avatars/' . $_SESSION['user']['avatar'] ?>" alt="Profile avatar image">
        <p class="text-xs sm:text-base">Here you can update your avatar, e-mail and/or password down below. 👇</p>
    </div>

    <article class="update-info-container px-6 py-6">
        <form action="app/users/update/avatar.php" method="post" enctype="multipart/form-data">
            <div class="pb-6">
                <label class="text-lg lg:text-2xl font-bold" for="update-avatar">Choose your new avatar</label>
                <input class="block mt-2 w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[0.8rem] file:font-semibold file:bg-gray-100 file:text-blue-700 hover:file:bg-blue-100" type="file" accept="image/jpeg, image/png" name="update-avatar">
                <button type="submit" class="block mt-4 text-xs mr-4 py-2 px-4 rounded-full border-0 font-semibold bg-blue-600 text-white hover:bg-green-700">Update avatar</button>
            </div>
        </form>
        <form class="py-6" action="app/users/update/email.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="new-email" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Enter your new email below</label>
                <input class="form-control block shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="email" name="new-email" id="new-email" placeholder="email@email.com">
                <small class="form-text text-xs italic px-1 py-1">Please provide your new email address.</small>
            </div>
            <button type="submit" class="block mt-2 text-xs mr-4 py-2 px-4 rounded-full border-0 font-semibold bg-blue-600 text-white hover:bg-green-700">Update e-mail</button>
        </form>
        <form class="py-6" action="app/users/update/password.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="new-password" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Choose your new password</label>
                <input class="form-control shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="password" name="new-password" id="new-password" placeholder="Password">
                <small class="form-text block text-xs italic px-1 py-1">Please provide your new password (passphrase).</small>
            </div>

            <div class="mb-3">
                <label for="confirm-new-password" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Confirm your new password</label>
                <input class="form-control shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="password" name="confirm-new-password" id="confirm-new-password" placeholder="Confirm your passowrd">
                <small class="form-text block text-xs italic px-1 py-1">Please provide your new password again.</small>
            </div>



            <button type="submit" class="block mt-2 text-xs mr-4 py-2 px-4 rounded-full border-0 font-semibold bg-blue-600 text-white hover:bg-green-700">Update password</button>
        </form>
    </article>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
