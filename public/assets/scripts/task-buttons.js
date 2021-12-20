const taskContainers = document.querySelectorAll('.task-container');
const taskButtons = document.querySelectorAll('.task-btn');

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
