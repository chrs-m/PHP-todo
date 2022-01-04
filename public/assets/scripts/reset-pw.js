const fakeBtn = document.querySelector('.fake-btn');
const messageDiv = document.querySelector('.reset-message');
const resetForm = document.querySelector('.reset-form');

fakeBtn.addEventListener('click', () => {
    resetForm.reset();
    messageDiv.classList.remove('hidden');
});
