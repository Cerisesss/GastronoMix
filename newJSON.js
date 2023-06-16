// Version théorique

"use strict";

const fs = require('fs');

function getIngredients(fichier_json, categories) {
    let unitesArray = ['g', 'kg', 'c.à.s', 'l', 'cl', 'ml', 'c.à.c', 'sachet', 'sachetnodes', 'boîte', 'boîtes', 'feuille', 'feuilles', 'pincée', 'pincées', 'tranche', 'tranches', 'verre', 'verres', 'boule', 'boules', 'cube', 'cubes', 'filet', 'filets', 'gousse', 'gousses', 'noix', 'noisette', 'noisettes', 'poignée', 'poignées', 'pot', 'pots', 'rouleau', 'rouleaux', 'tasse', 'tasses', 'zeste', 'zestes', 'barquette', 'barquettes', 'bocal', 'bocaux', 'botte', 'bottes', 'branche', 'branches', 'brique', 'briques', 'bûche', 'bûches', 'couteau à lame lisse', 'cagette', 'cagettes', 'caissette', 'caissettes', 'carré', 'carrés', 'cuillère', 'cuillères', 'dose', 'doses', 'entonnoir', 'entonnoirs', 'escalope', 'escalopes', 'étui', 'étuis', 'feuillet', 'feuillets', 'flacon', 'flacons', 'flûte', 'flûtes', 'fond', 'fonds', 'galet', 'galets', 'gobelet', 'gobelets', 'grappe', 'grappes', 'lamelle', 'lamelles', 'morceau', 'morceaux', 'paquet', 'paquets', 'part', 'parts', 'plaque', 'plaques', 'portion', 'portions', 'pot', 'pots', 'rondelle', 'rondelles', 'sachet', 'sachets', 'tablette', 'tablettes', 'talon', 'talons', 'tige', 'tiges', 'tranche', 'tranches', 'troupeau', 'troupeaux', 'verre', 'verres', 'zeste', 'zestes'];
    let output = [];
    let contenu = fs.readFileSync(fichier_json, "UTF-8");
    let obj = eval('(' + contenu + ')');
    var json = JSON.stringify(obj);
    let fichier = JSON.parse(json);
    let newJson = [];
    let quantite = [];
    let unite = [];
    let newIngredients = [];
    let recettes = [];

    for (let i = 0; i < fichier.length; i++) {
        let nom = fichier[i].name;
        let ingredients = fichier[i].ingredients;
        let image = fichier[i].images[5];
        let etapes = fichier[i].steps;
        let difficulte = fichier[i].difficulty;
        let tempspreparation = fichier[i].prepTime;
        let tempstotal = fichier[i].totalTime;
        let nombredepersonne = fichier[i].people;
        output = [];
        quantite = [];
        unite = [];
        newIngredients = [];

        for (let i = 0; i < ingredients.length; i++) {
            let ingredient = ingredients[i];
            let words = ingredient.split(" ");
            output.push(words);
        }

        for (let i = 0; i < output.length; i++) {
            let firstWord = output[i][0];

            // Le premier mot est un chiffre ?
            if (/^\d/.test(firstWord)) {
                quantite.push(firstWord);
                // Supprime le premier mot de output
                output[i].shift();
            } else {
                quantite.push(" ");
            }

            // Trouve l'index de la première occurrence du premier mot de la variable output[i] dans le tableau unitesArray
            let uniteIndex = unitesArray.indexOf(output[i][0]);

            // Compare pour savoir si le premier mot est dans unitesArray
            if (uniteIndex !== -1) {
                unite.push(output[i][0]);
                // Supprime le premier mot de output
                output[i].shift();
            } else {
                unite.push(" ");
            }

            let lereste = "";

            // Si le premier mot est "de"
            if (output[i][0] === "de") {
                // Supprimer le "de" de output
                output[i].shift();
                lereste = output[i].join(" ");
                newIngredients.push(lereste);
            } else {
                lereste = output[i].join(" ");
                newIngredients.push(lereste);
            }


        }

        recettes = {
            "nom": nom,
            "source": "Marmiton",
            "difficulte": difficulte,
            "quantite": quantite,
            "unite": unite,
            "ingredients": newIngredients,
            "image": image,
            "etapes": etapes,
            "tempspreparation": tempspreparation,
            "tempstotal": tempstotal,
            "nombredepersonne": nombredepersonne,
            "categorie": categories
        };

        quantite = [];
        unite = [];
        newIngredients = [];

        newJson.push(recettes);

        //console.log("quantite: ", quantite);
        //console.log("unite: ", unite);
        //console.log("newIngredients : ", newIngredients);
        //console.log("output: ", output);
    }

    let newfichier = [];
    let filenName = "new" + fichier_json;

    // check if fichier_json is created, if not create one
    if (!fs.existsSync(filenName)) {
        fs.writeFileSync(filenName, JSON.stringify(newJson), "UTF-8");
    } else {
        contenu = fs.readFileSync("new" + fichier_json, "UTF-8");
        newfichier = JSON.parse(contenu);
    }
}

function lecture_recette() {
    const fichier_json = ["entree.json", "plat.json", "dessert.json", "boisson.json"];
    const categories = ["entree", "plat", "dessert", "boisson"];

    for (let i = 0; i < fichier_json.length; i++) {
        if (fs.existsSync(fichier_json[i])) {
            getIngredients(fichier_json[i], categories[i]);
        }
    }
}

lecture_recette();
