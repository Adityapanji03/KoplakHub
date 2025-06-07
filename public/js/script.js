// toggle class active navbar
const navbarNav = document.querySelector('.navbar-nav');
document.querySelector('#menu').onclick = () => {
    console.log("hai")
    navbarNav.classList.toggle('active');
};

// klik ousidebar nav
const menu = document.querySelector('#menu');
document.addEventListener('click', function(e){
    if(!menu.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove('active');
    };
})

// overflow horizontal hiiden
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.hero .content');
    const heroHeight = window.innerHeight;

    function adjustScale() {
        if (content.offsetHeight > heroHeight) {
            const scaleFactor = heroHeight / content.offsetHeight;
            content.style.transform = `scaleY(${scaleFactor})`;
            content.style.overflowX = 'hidden';
        } else {
            content.style.transform = 'scaleY(1)';
            content.style.overflowX = 'hidden';
        }
    }

    adjustScale();
    window.addEventListener('resize', adjustScale);
});


