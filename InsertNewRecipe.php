<?php
    require 'Function.php';
    session_start();

    if (isset($_GET['pseudo'])) {
        $pseudo = $_GET['pseudo'];
        $_SESSION['pseudo_user'] = $pseudo;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <?php
            if (isset($_SESSION['pseudo_user'])) {
                if($_SESSION['pseudo_user'] == "admin" || $_SESSION['pseudo_user'] == "Admin") {
                    MenuDeroulantAdmin($pseudo);
                    MenuDeroulantConnecter($pseudo);
                    RechercheAvanceeConnecter($pseudo);
                } else {
                    echo "Tu n'es pas autoriser à accéder à cette page !";
                    header("Refresh: 2; url=http://localhost/gastronomix/Accueil.php");
                }
            } else {
                echo "Tu n'es pas autoriser à accéder à cette page !";
                header("Refresh: 2; url=http://localhost/gastronomix/Accueil.php");
            }
        ?>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h1>GastronoMix</h1>

        <h2>Ajout d'une nouvelle recette</h2>

        <br>

        <form action="Confirmation_InsertNewRecipe.php?pseudo=<?php echo $pseudo; ?>" method="POST">
            <label for="titre">Titre</label>
            <input type="text" class="Button" name="titre" required /><br>

            <label for="source">Source</label>
            <input type="text" class="Button" name="source" required /><br>

            <label for="categorie_recette">Catégorie</label>
            <select class="Button" name="categorie_recette" required>
                <option value="">Sélectionnez une catégorie</option>
                <option value="entree">Entrée</option>
                <option value="plat">Plat</option>
                <option value="dessert">Dessert</option>
                <option value="boisson">Boisson</option>
            </select>
            <br>

            <label for="image_recette">Lien de l'image</label>
            <input type="text" class="Button" name="image_recette" /><br>

            <label for="nb_personne">Nombre de personne</label>
            <input type="number" min="1" class="Button" name="nb_personne" required /><br>

            <label for="temps_prep_recette">Temps de préparation</label>
            <input type="time" class="Button" name="temps_prep_recette" step="1" required /><br>
            
            <label for="temps_total_recette">Temps total</label>
            <input type="time" class="Button" name="temps_total_recette" step="1" required /><br>

            <label for="difficulte">Difficulté</label>
            <input type="number" min="1" max="3" class="Button" name="difficulte" required /><br>
            
            <br>
            <h2>Ajout des ingrédients et de leur quantité</h2>
            <br>

             <div id="TextAreaQuantite">
                <label for="quantite_ingredient[]">Ecrivez sous ce format : "quantité, ingrédient, unité, tag" (exemple : "200, chocolat, g, chocolat", "1/2, eau chaude, verre, eau", "2, oeufs, 0, oeufs")</label><br>
                <label for="quantite_ingredient[]">Si l'un des éléments est manquant, écrivez simplement "0"</label><br>
                <label for="quantite_ingredient[]">Le "tag" est le nom de l'ingrédient sans aucun attribut : "eau chaude" devient "eau", "carotte rapée" devient "carotte"...</label><br>
                <textarea class="Button" name="quantite_ingredient[]" required ></textarea>
            </div>
            <button type="button" class="Button" onclick="AjoutChampTexteQuantite()">Ajouter un ingrédient</button>

            <br>
            <h2>Ajout des étapes</h2>
            <br>

            <div id="TextAreaEtapes">
                <label for="texte_etape">Etapes</label>
                <textarea class="Button" name="etapes[]"></textarea>
            </div>
            <button type="button" class="Button" onclick="AjoutChampTexteEtape()">Ajouter une étape</button>

            <br>
            <input type="submit" class="Button" value="Ajouter" />
        </form>
    </body>
</html>
