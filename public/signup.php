<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article class="px-6 py-6 lg:grid lg:justify-center">
    <h2 class="text-lg font-bold mb-4">Create your new account down below!</h2>

    <form action=" app/users/signup.php" method="post" enctype="multipart/form-data">
        <div class="">
            <label for="avatar" class="text-sm lg:text-2xl font-bold">Choose your avatar</label>
            <input class="block mt-2 w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[0.8rem] file:font-semibold file:bg-gray-100 file:text-blue-700 hover:file:bg-blue-100" type="file" accept="image/jpeg, image/png" name="avatar">
            <br>
        </div>

        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Enter your name below</label>
            <input class="form-control block shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="name" name="name" id="name" placeholder="Your name" required>
            <small class="form-text text-xs">Please provide the your name.</small>
        </div>

        <div class="mb-6">
            <label for="username" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Enter your username below</label>
            <input class="form-control block shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="username" name="username" id="username" placeholder="Username" required>
            <small class="form-text text-xs">Please provide the your username.</small>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Enter your email below</label>
            <input class="form-control block shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="email" name="email" id="email" placeholder="email@email.com" required>
            <small class="form-text text-xs">Please provide the your email address.</small>
        </div>

        <div class="mb-3">
            <label for="password" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Choose your password</label>
            <input class="form-control block shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="password" name="password" id="password" placeholder="Password" required>
            <small class="form-text text-xs">Please provide the your password (passphrase).</small>
        </div>

        <div class="mb-3">
            <label for="confirm-password" class="block text-gray-700 text-sm lg:text-2xl font-bold mb-2">Confrim your password</label>
            <input class="form-control block shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline placeholder:text-sm" type="password" name="confirm-password" id="confirm-password" placeholder="Confirm your passowrd" required>
            <small class="form-text text-xs">Please provide your choosen password again.</small>
        </div>



        <button type="submit" class="inline-block mt-2 text-sm mr-4 py-2 px-4 rounded-full border-0 font-semibold bg-blue-600 text-white hover:bg-green-700">Sign up!</button>
        <form action="/index.php">
            <input type="submit" value="Back" class="inline-block mt-2 text-sm mr-4 py-2 px-4 rounded-full border-0 font-semibold bg-blue-400 text-white hover:bg-fuchsia-400 mb-6" />
        </form>
    </form>

    <a class="text-blue-300" href="/login.php">Already have an account? Sign in here!</a>
</article>


<?php require __DIR__ . '/views/footer.php'; ?>
