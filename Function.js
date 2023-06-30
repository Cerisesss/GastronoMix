const fs = require('fs');
const path = require('path');
const https = require('https');

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
        html.style.backgroundColor = '#d9b9b9';
    } else {
        html.style.backgroundColor = 'white';
    }
}


function AjoutChampTexteQuantite() {
    var text = document.getElementById("TextAreaQuantite");
    var quantite = document.createElement("textarea");
    quantite.name = "quantite_ingredient[]";
    quantite.classList.add("Button");
    text.appendChild(quantite);
}

function AjoutChampTexteEtape() {
    var text = document.getElementById("TextAreaEtapes");
    var etapes = document.createElement("textarea");
    etapes.name = "etapes[]";
    etapes.classList.add("Button");
    text.appendChild(etapes);
}


function telecharger_image(url, new_image) {
    return new Promise((resolve, reject) => {
        const dirPath = path.resolve(__dirname, 'images_recettes');
        if (!fs.existsSync(dirPath)) {
            try {
                fs.mkdirSync(dirPath);
            } catch (error) {
                reject(error);
                return;
            }
        }

        const filePath = path.resolve(dirPath, new_image + '.jpg');
        const file = fs.createWriteStream(filePath);
        const request = https.get(url, function (response) {
            response.pipe(file);
            file.on('finish', function () {
                file.close();
                resolve(filePath);
            });
        }).on('error', function (err) {
            fs.unlink(filePath, () => {
                reject(err);
            });
        });
    });
}


function fichierExiste(filePath) {
    return fs.existsSync(filePath);
}

module.exports = {
    toggleMenu: toggleMenu,
    toggleCompte: toggleCompte,
    ChangeBackgroundColor: ChangeBackgroundColor,
    telecharger_image: telecharger_image,
    fichierExiste: fichierExiste
};
