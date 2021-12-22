const taskContainers = document.querySelectorAll('.task-container');
const taskButtons = document.querySelectorAll('.task-btn');

// WHEN YOU HOVER A TASK, SHOW THE BUTTONS
[...taskContainers].forEach((taskContaier, i) => {
    taskContaier.addEventListener('mouseenter', () => {
        [...taskContaier.querySelectorAll('.task-btn')].map((btn) => {
            btn.classList.remove('hidden');
        });
    });
});
[...taskContainers].forEach((taskContaier, i) => {
    taskContaier.addEventListener('mouseleave', () => {
        [...taskContaier.querySelectorAll('.task-btn')].map((btn) => {
            btn.classList.add('hidden');
        });
    });
});

// CLICK TO SHOW TODAYS TASKS AND ALL TASKS
function showTodaysTasks() {
    const taskContainer = document.getElementById('todaysTasks');
    if (taskContainer.style.display === 'block') {
        taskContainer.style.display = 'none';
    } else {
        taskContainer.style.display = 'block';
    }
}
function showAllMyTasks() {
    const taskContainer = document.getElementById('allTasks');
    if (taskContainer.style.display === 'block') {
        taskContainer.style.display = 'none';
    } else {
        taskContainer.style.display = 'block';
    }
}
