<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Create account</h1>
    <p class="session_message"><?php echo $_SESSION['message']; ?></p>

    <form action="app/users/signup.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="avatar">Choose your avatar</label>
            <input class="image-input" type="file" accept="image/jpeg, image/png" name="avatar">
            <br>
        </div>

        <div class="mb-3">
            <label for="name">Enter your name below</label>
            <input class="form-control" type="name" name="name" id="name" placeholder="Your name" required>
            <small class="form-text">Please provide the your name.</small>
        </div>

        <div class="mb-3">
            <label for="username">Enter your username below</label>
            <input class="form-control" type="username" name="username" id="username" placeholder="Username" required>
            <small class="form-text">Please provide the your username.</small>
        </div>

        <div class="mb-3">
            <label for="email">Enter your email below</label>
            <input class="form-control" type="email" name="email" id="email" placeholder="email@email.com" required>
            <small class="form-text">Please provide the your email address.</small>
        </div>

        <div class="mb-3">
            <label for="password">Choose your password</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
            <small class="form-text">Please provide the your password (passphrase).</small>
        </div>

        <div class="mb-3">
            <label for="confirm-password">Confrim your password</label>
            <input class="form-control" type="password" name="confirm-password" id="confirm-password" placeholder="Confirm your passowrd" required>
            <small class="form-text">Please provide your choosen password again.</small>
        </div>



        <button type="submit" class="btn btn-primary">Sign up!</button>
    </form>
</article>

<a href="/login.php">Already have an account? Sign in here!</a>

<?php require __DIR__ . '/views/footer.php'; ?>
