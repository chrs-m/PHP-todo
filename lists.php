<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>



    <?php if (isset($_SESSION['user'])) : ?>
        <p>Hi, <?php echo $_SESSION['user']['name']; ?>! What do you need to do today?</p>
    <?php else : ?>
        <a href="/signup.php">No account? Sign up here!</a>
    <?php endif; ?>

</article>

<!-- Here should lists and tasks being displayed -->


<a href="/create.php" class="btn btn-primary">Create new list!</a>


<?php require __DIR__ . '/views/footer.php'; ?>
