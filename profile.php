<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article class="profile-container">
    <h1><?php echo $config['title']; ?></h1>
    <?php if (!isset($_SESSION['user'])) : ?>
        <?php $_SESSION['message'] = "Welcome stranger!"; ?>
        <?php echo $_SESSION['message']; ?>
    <?php endif ?>
    <br>


    <?php if (isset($_SESSION['user'])) : ?>
        <p>Hi, <?php echo $_SESSION['user']['name']; ?>!</p>

        <img class="avatar" src="<?= '/app/database/avatars/' . $_SESSION['user']['avatar'] ?>" alt="Profile avatar image">
        <p>Here you can update your avatar, e-mail and/or password down below.</p>

    <?php endif; ?>

</article>

<article class="update-info-container">
    <h1>Update info</h1>
    <br>
    <?= $_SESSION['message']; ?>
    <br>
    <br>

    <form action="app/users/update/avatar.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="update-avatar">Choose your new avatar</label>
            <br>
            <input class="image-input" type="file" accept="image/jpeg, image/png" name="update-avatar">
            <br>
            <br>
            <button type="submit" class="btn btn-primary">Update avatar</button>
            <br>
            <br>
        </div>
    </form>
    <form action="app/users/update/email.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="new-email">Enter your new email below</label>
            <input class="form-control" type="email" name="new-email" id="new-email" placeholder="email@email.com">
            <small class="form-text">Please provide your new email address.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update e-mail</button>
        <br>
        <br>
    </form>
    <form action="app/users/update/password.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="new-password">Choose your new password</label>
            <input class="form-control" type="password" name="new-password" id="new-password" placeholder="Password">
            <small class="form-text">Please provide your new password (passphrase).</small>
        </div>

        <div class="mb-3">
            <label for="confirm-new-password">Confrim your new password</label>
            <input class="form-control" type="password" name="confirm-new-password" id="confirm-new-password" placeholder="Confirm your passowrd">
            <small class="form-text">Please provide your new password again.</small>
            <br>
        </div>



        <button type="submit" class="btn btn-primary">Update password</button>
    </form>
</article>





<?php require __DIR__ . '/views/footer.php'; ?>
