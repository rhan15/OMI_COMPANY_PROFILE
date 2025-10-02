$( document ).ready(function() {
    const queryString = window.location.search;
    // console.log(queryString);
    const urlParams = new URLSearchParams(queryString);
    const menu = urlParams.get('menu')
    // console.log("Menu- "+menu);

    if (menu != '0') {
        var link = document.getElementById('menu-'+menu);
        link.click();
    }
});

$( document ).ready(function() {
    var menu_title = document.getElementsByClassName("menu-item");
    var menu1 = document.getElementById('Nav-Left');
    var mask1 = document.getElementById('mask-overlay');

    for (var i = 0; i < menu_title.length; i++) {
        menu_title[i].addEventListener('click', () => {
            console.log(document.getElementById('Nav-Left').classList.contains("open"));
            if (menu1.classList.contains("open")) {
                menu1.classList.toggle('open');
                mask1.classList.toggle('open');
            }
        });
    }
});

// Menu Nav
var open = document.getElementById('menu-button');
var menu = document.getElementById('Nav-Left');
var mask = document.getElementById('mask-overlay');

open.addEventListener('click', () => {
    menu.classList.toggle('open');
    mask.classList.toggle('open');
});

mask.addEventListener('click', () => {
    menu.classList.toggle('open');
    mask.classList.toggle('open');
});
