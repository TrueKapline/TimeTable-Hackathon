"use strict";

const headerBurger = document.querySelector('.header__burger');

if(headerBurger) {
    const headerMenu = document.querySelector('.menu__items');
        headerBurger.addEventListener("click", function(e) {
        document.body.classList.toggle('_lock');
        headerBurger.classList.toggle('active');
        headerMenu.classList.toggle('active');
    });
}