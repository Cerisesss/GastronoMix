"use strict";

const fs = require('fs');
const path = require('path');
const { telecharger_image } = require('./Function.js');

async function getIngredients(fichier_json, categories) {
    let unitesArray = ['g', 'kg', 'c.à.s', 'l', 'cl', 'ml', 'c.à.c', 'sachet', 'sachetnodes', 'boîte', 'boîtes', 'feuille', 'feuilles', 'pincée', 'pincées', 'tranche', 'tranches', 'verre', 'verres', 'boule', 'boules', 'cube', 'cubes', 'filet', 'filets', 'gousse', 'gousses', 'poignée', 'poignées', 'pot', 'pots', 'rouleau', 'rouleaux', 'tasse', 'tasses', 'zeste', 'zestes', 'barquette', 'barquettes', 'bocal', 'bocaux', 'botte', 'bottes', 'branche', 'branches', 'brique', 'briques', 'bûche', 'bûches', 'couteau à lame lisse', 'cagette', 'cagettes', 'caissette', 'caissettes', 'carré', 'carrés', 'cuillère', 'cuillères', 'dose', 'doses', 'entonnoir', 'entonnoirs', 'escalope', 'escalopes', 'étui', 'étuis', 'feuillet', 'feuillets', 'flacon', 'flacons', 'flûte', 'flûtes', 'fond', 'fonds', 'galet', 'galets', 'gobelet', 'gobelets', 'grappe', 'grappes', 'lamelle', 'lamelles', 'morceau', 'morceaux', 'paquet', 'paquets', 'part', 'parts', 'plaque', 'plaques', 'portion', 'portions', 'pot', 'pots', 'rondelle', 'rondelles', 'sachet', 'sachets', 'tablette', 'tablettes', 'talon', 'talons', 'tige', 'tiges', 'tranche', 'tranches', 'troupeau', 'troupeaux', 'verre', 'verres', 'zeste', 'zestes'];
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
    let recherche = [];
    let fichierExiste = false;

    for (let i = 0; i < fichier.length; i++) {
        let nom = fichier[i].name;
        let ingredients = fichier[i].ingredients;
        let image = fichier[i].images[5];
        let etapes = fichier[i].steps;
        let difficulte = fichier[i].difficulty;
        let tempspreparation = fichier[i].prepTime;
        let tempstotal = fichier[i].totalTime;
        let nombredepersonne = fichier[i].people;
        let ingredients_recherche = fichier[i].description;
        let newEtapes = [];
        output = [];
        quantite = [];
        unite = [];
        newIngredients = [];

        // Converti en minuscules, remplace les : par des underscores, enleve les accents, remplace les espaces par des underscores et supprime les espaces en fin de chaîne
        let new_image = nom.toLowerCase().replace(/:/g, "a").normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/ /g, "_").replace(/\//g, "a");
        let imageFilePath = path.resolve(__dirname, 'images_recettes', new_image + '.jpg');

        // Partie pour les images
        // Vérifie si l'image existe déjà
        if (!fs.existsSync(imageFilePath)) {
            try {
                // Télécharge l'image
                imageFilePath = await telecharger_image(image, new_image);
                console.log('L\'image a été téléchargée :', imageFilePath);
            } catch (error) {
                console.error('Erreur lors du téléchargement de l\'image :', error);
                continue;
            }
        } else {
            // L'image existe déjà
            console.log('L\'image existe déjà :', imageFilePath);
        }

        recherche = ingredients_recherche.split(",");

        for (let i = 0; i < etapes.length; i++) {
            let texte = etapes[i];
            newEtapes[i] = texte.replace(/\n|\r|\"/g, "");
        }

        for (let i = 0; i < ingredients.length; i++) {
            let ingredient = ingredients[i];
            ingredient = ingredient.replace(/\"/g, "");
            let words = ingredient.split(" ");
            output.push(words);
        }

        for (let i = 0; i < output.length; i++) {
            let firstWord = output[i][0];

            if (/^\d/.test(firstWord)) {
                quantite.push(firstWord);
                output[i].shift();
            } else {
                quantite.push(" ");
            }

            let uniteIndex = unitesArray.indexOf(output[i][0]);

            if (uniteIndex !== -1) {
                unite.push(output[i][0]);
                output[i].shift();
            } else {
                unite.push(" ");
            }

            let lereste = "";

            if (output[i][0] === "de") {
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
            "image": "images_recettes/" + new_image + ".jpg",
            "etapes": newEtapes,
            "tempspreparation": tempspreparation,
            "tempstotal": tempstotal,
            "nombredepersonne": nombredepersonne,
            "categorie": categories,
            "ingredients_recherche": recherche
        };

        quantite = [];
        unite = [];
        newIngredients = [];

        newJson.push(recettes);
    }

    let newfichier = [];
    let filenName = "new" + fichier_json;

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
