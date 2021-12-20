const navAvatar = document.querySelector('.avatar');
const profileMenu = document.querySelector('.profile-menu');
const mobileMenuButtonOpen = document.querySelector('.mobile-menu-button');
const mobileMenu = document.querySelector('.mobile-menu');
const mobileMenuIconOpen = document.querySelector('.mobile-menu-icon-open');
const mobileMenuIconClose = document.querySelector('.mobile-menu-icon-close');

// TOGGLE THE PROFILE MENU WHEN CLICKING THE AVATAR
navAvatar.addEventListener('click', () => {
    profileMenu.classList.toggle('hidden');
});

// TOGGLE THE MENU WHEN IN MOBILE
mobileMenuButtonOpen.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    mobileMenuIconClose.classList.toggle('hidden');
    mobileMenuIconOpen.classList.toggle('hidden');
});
