function toggleMenu() {
    var menu = document.getElementById("menu");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

function toggleCompte() {
    var compte = document.getElementById("compte");
    if (compte.style.display === "block") {
        compte.style.display = "none";
    } else {
        compte.style.display = "block";
    }
}


function ChangeBackgroundColor() {
    var html = document.documentElement;
    backgroundColor = html.style.backgroundColor;

    if (backgroundColor === 'white' || backgroundColor === '') {
        html.style.backgroundColor = '#202020';
    } else {
        html.style.backgroundColor = 'white';
    }
}
