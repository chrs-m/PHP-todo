<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <?php if (!isset($_SESSION['user'])) : ?>
        <?PHP $_SESSION['message'] = "Welcome stranger!"; ?>
        <?php echo $_SESSION['message']; ?>
    <?php endif ?>
    <br>


    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?php echo $_SESSION['user']['name']; ?>!</p>
        <a href="/lists.php" class="btn btn-primary">Check or upload posts!</a>
    <?php else : ?>
        <a href="/signup.php">No account? Sign up here!</a>
    <?php endif; ?>

</article>





<?php require __DIR__ . '/views/footer.php'; ?>
