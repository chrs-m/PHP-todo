// SET THE WIDTH OF NAV WHEN OPENING AND CLOSING
const openNav = () => {
    document.querySelector('.sidenav').classList.remove('close');
    document.querySelector('.sidenav').classList.add('open');
};

const closeNav = () => {
    document.querySelector('.sidenav').classList.remove('open');
    document.querySelector('.sidenav').classList.add('close');
};
