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

function toggleRechercheAvancee() {
    var letter = document.getElementById("letter");
    if (letter.style.display === "block") {
        letter.style.display = "none";
    } else {
        letter.style.display = "block";
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

function AjoutChampInput() {
    var Input = document.getElementById("Input");
    var newInput = document.createElement("input");
    newinput.name = "quantite[]";
    Input.appendChild(newInput);
}


function AjoutChampTexte() {
    var text = document.getElementById("TextArea");
    var etapes = document.createElement("textarea");
    etapes.name = "quantite_ingredient[]";
    text.appendChild(etapes);
}

/*function SupprimerChampTexte(button) {
  var TextArea = button.parentNode;
  TextArea.parentNode.removeChild(TextArea);
}*/

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
    toggleRechercheAvancee: toggleRechercheAvancee,
    ChangeBackgroundColor: ChangeBackgroundColor,
    telecharger_image: telecharger_image,
    fichierExiste: fichierExiste
};
