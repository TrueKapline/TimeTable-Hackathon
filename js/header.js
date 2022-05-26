"use strict";

const navbarBurger = document.querySelector('.navbar__burger');

if(navbarBurger) {
    const navbarMenu = document.querySelector('.menu__items');
    navbarBurger.addEventListener("click", function(e) {
        document.body.classList.toggle('_lock');
        navbarBurger.classList.toggle('active');
        navbarMenu.classList.toggle('active');
    });
}