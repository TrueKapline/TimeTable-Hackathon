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

const btn_prevent = document.getElementById("btn_prevent");
const btn_next = document.getElementById("btn_next");

btn_prevent.addEventListener('click', function() {
    console.log('TEST TEST TEST TEST');
})
/*setTimeout(function() {
    document.getElementById("preloader_malc").style.display = "none";
}, 1000);*/