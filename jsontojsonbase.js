// Version théorique

"use strict";

function getIngredients() {
    let ingredients = ["1 pâte feuilleté", "1 bûche de fromage de chèvre", "basilici", "1/2 c.à.c de curry", "1 c.à.s de miel", "1 c.à.s de graines de sésame", "1 jaune d'oeuf"];
    let unitesArray = ['g', 'kg', 'c.à.s', 'l', 'cl', 'ml', 'c.à.c', 'sachet', 'sachetnodes', 'boîte', 'boîtes', 'feuille', 'feuilles', 'pincée', 'pincées', 'tranche', 'tranches', 'verre', 'verres', 'boule', 'boules', 'cube', 'cubes', 'filet', 'filets', 'gousse', 'gousses', 'noix', 'noisette', 'noisettes', 'pomme', 'pommes', 'poignée', 'poignées', 'pot', 'pots', 'rouleau', 'rouleaux', 'tasse', 'tasses', 'zeste', 'zestes', 'barquette', 'barquettes', 'bocal', 'bocaux', 'botte', 'bottes', 'branche', 'branches', 'brique', 'briques', 'bûche', 'bûches', 'couteau à lame lisse', 'cagette', 'cagettes', 'caissette', 'caissettes', 'carré', 'carrés', 'cuillère', 'cuillères', 'dose', 'doses', 'entonnoir', 'entonnoirs', 'escalope', 'escalopes', 'étui', 'étuis', 'feuillet', 'feuillets', 'flacon', 'flacons', 'flûte', 'flûtes', 'fond', 'fonds', 'galet', 'galets', 'gobelet', 'gobelets', 'grappe', 'grappes', 'lamelle', 'lamelles', 'morceau', 'morceaux', 'paquet', 'paquets', 'part', 'parts', 'plaque', 'plaques', 'portion', 'portions', 'pot', 'pots', 'rondelle', 'rondelles', 'sachet', 'sachets', 'tablette', 'tablettes', 'talon', 'talons', 'tige', 'tiges', 'tranche', 'tranches', 'troupeau', 'troupeaux', 'verre', 'verres', 'zeste', 'zestes'];
    let output = [];
    let quantiteArray = [];
    let uniteIngredients = [];
    let ingredientsArray = [];

    for (let i = 0; i < ingredients.length; i++) {
        let ingredient = ingredients[i];
        let words = ingredient.split(" ");
        output.push(words);
    }

    //console.log("0 output: " + output);

    for (let i = 0; i < output.length; i++) {
        let firstWord = output[i][0];

        // Le premier mot est un chiffre ?
        if (/^\d/.test(firstWord)) {
            quantiteArray.push(firstWord);
            // Supprime le premier mot de output
            output[i].shift();
        } else {
            quantiteArray.push(" ");
        }

        let uniteIndex = unitesArray.indexOf(output[i][0]);

        //compare pour savoir si le premier mot est dans unitesArray
        if (uniteIndex !== -1) {
            uniteIngredients.push(output[i][0]);
            // Supprime le premier mot de output
            output[i].shift();
        } else {
            uniteIngredients.push(" ");
        }

        // Si le premier mot est "de"
        if (output[i][0] === "de") {
            // Supprimer le "de" de output
            output[i].shift();
            let lereste = output[i].join(" ");
            ingredientsArray.push(lereste);
        } else {
            let lereste = output[i].join(" ");
            ingredientsArray.push(lereste);
        }
    }
    console.log("quantiteArray: ", quantiteArray);
    console.log("uniteIngredients: ", uniteIngredients);
    console.log("ingredientsArray: ", ingredientsArray);
    console.log("output: ", output);
}

getIngredients();

