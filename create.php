<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<section>
    <h2>Create list</h2>
    <div class="create-list">
        <form class="create-post-container" action="/app/lists/create.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <label for="list-description">Please give your list a name</label>
                <br>
                <input class="description-field" type="text" name="list-description" required placeholder="List name"></input>
                <br>
                <button class="btn btn-primary submit" type="submit" name="button">Create</button>
            </div>
        </form>
    </div>
</section>

<section>
    <h2>Create task</h2>
    <div class="create-task">
        <form class="create-post-container" action="/app/lists/create.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <label for="task-title">Title</label>
                <br>
                <input class="task-title" type="text" name="task-title" required placeholder="Whats your task?"></input>
                <br>
                <!-- <input class="task-description" type="text" name="task-description" required placeholder="What should you do?"></input>
                <br> -->
                <select class="task-list" name="task-list" required>
                    <option value="">--Please choose a list--</option>
                    <option value="List 1">List 1</option>
                </select>
                <br>
                <label for="task-deadline">Do you need a deadline?</label>
                <input class="task-deadline" type="date" name="task-deadline"></input>
                <br>
                <button class="btn btn-primary submit" type="submit" name="button">Create</button>
            </div>
        </form>
    </div>
</section>


<?php require __DIR__ . '/views/footer.php'; ?>
