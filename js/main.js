document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.querySelector('.nav-toggle');
    var header = document.querySelector('.site-header');
    var navList = document.getElementById('primary-nav');

    if (!toggle || !header || !navList) {
        return;
    }

    toggle.addEventListener('click', function () {
        var isOpen = header.classList.toggle('nav-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
});
