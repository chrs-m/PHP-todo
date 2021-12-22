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

// CLICK TO SHOW TODAYS TASKS AND TO SHOW ALL TASKS
const todaysTasks = document.querySelector('.show-todays-tasks');
const todaysTasksContainer = document.querySelector('.todays-tasks-container');
const allTasks = document.querySelector('.show-all-tasks');
const allTasksContainer = document.querySelector('.all-tasks-container');

// TODAYS TASKS
todaysTasks.addEventListener('click', () => {
    if (todaysTasksContainer.style.display === 'block') {
        todaysTasksContainer.style.display = 'none';
    } else {
        todaysTasksContainer.style.display = 'block';
    }
});

// ALL TASKS
allTasks.addEventListener('click', () => {
    if (allTasksContainer.style.display === 'block') {
        allTasksContainer.style.display = 'none';
    } else {
        allTasksContainer.style.display = 'block';
    }
});
