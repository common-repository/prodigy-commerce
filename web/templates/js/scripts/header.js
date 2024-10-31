(function () {
    const openMenuBtn = document.querySelector('.open-menu-btn-js');
    const closeMenuBtn = document.querySelector('.close-menu-btn-js');
    const navbarMenu = document.querySelector('.navbar-menu-js');
    const searchJsDesktop = document.querySelector('#search-desktop');
    const searchJsTablet = document.querySelector('#search-tablet');
    const body = document.body;

    const menuOpenClass = 'prodigy-navbar__menu--open';
    const btnCloseClass = 'prodigy-navbar__btn-close--show';
    const navbarOpenClass = 'navbar-open-js';

    const mediaQueryLg = 1024;

    window.addEventListener('resize', function () {
        if (window.innerWidth >= mediaQueryLg) {
            closeMenu();
        }
    });

    function toggleClass(el, className) {
        el.classList.contains(className) && el.classList.remove(className);
    }

    function closeMenu() {

        /*
         * activate/deactivate search tablet/desktop
         */
        // searchJsDesktop.classList.add('search-value-js');
        // searchJsTablet.classList.remove('search-value-js');

        toggleClass(navbarMenu, menuOpenClass);
        toggleClass(body, navbarOpenClass);
        toggleClass(closeMenuBtn, btnCloseClass);
        // $('.prodigy-collapse-js').collapse('hide');
    }

    function openMenu() {

        /*
         * activate/deactivate search tablet/desktop
         */
        // searchJsDesktop.classList.remove('search-value-js');
        // searchJsTablet.classList.add('search-value-js');

        navbarMenu.classList.add(menuOpenClass);
        closeMenuBtn.classList.add(btnCloseClass);
        body.classList.add(navbarOpenClass);
    }

    openMenuBtn.addEventListener('click', function () {
        openMenu();
    });

    closeMenuBtn.addEventListener('click', function () {
        closeMenu();
    });
})();
