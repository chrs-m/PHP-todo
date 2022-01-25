<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (isset($_GET['email'])) : ?>
    <h1><?php echo $_GET['email'] ?></h1>
    <form class="py-6" action="app/users/update/password-via-link.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" id="email" />

            <label for="new-password" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Choose your new password</label>
            <input class="form-control shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-xs" type="password" name="new-password" id="new-password" placeholder="Password">
            <small class="form-text block text-xs text-gray-500 italic px-1 py-1">Please provide your new password (passphrase).</small>
        </div>

        <div class="mb-3">
            <label for="confirm-new-password" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Confirm your new password</label>
            <input class="form-control shadow appearance-none border rounded w-full sm:w-1/3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-xs" type="password" name="confirm-new-password" id="confirm-new-password" placeholder="Confirm your passowrd">
            <small class="form-text block text-xs text-gray-500 italic px-1 py-1">Please provide your new password again.</small>
        </div>

        <button type="submit" class="block mt-2 text-xs mr-4 py-2 px-4 rounded-full border-0 font-semibold bg-blue-600 text-white hover:bg-green-700">Update password</button>
    </form>
<?php else : ?>
    <h1>Try again later</h1>
<?php endif; ?>
