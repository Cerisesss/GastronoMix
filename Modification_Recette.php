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

        <br>

        <?php
            $mysqli = ConnectionDatabase();
            
            $titre = $_GET['recherche'];

            $query_id_titre = "SELECT * FROM recette WHERE titre LIKE '$titre';";

            $result_id_titre = $mysqli->query($query_id_titre);
            $result_id_recette = $result_id_titre->fetch_assoc();
            $id_recette = $result_id_recette['id_recette'];

            if (isset($_GET['recherche'])) {
                $mot_clef = $_GET['recherche'];

                $query = "SELECT id_recette, image_recette, titre, source, temps_prep_recette, temps_total_recette, nb_personne, difficulte
                            FROM recette 
                            WHERE titre LIKE '$mot_clef';";

                $result_recette = $mysqli->query($query);

                if ($result_recette && $result_recette->num_rows > 0) {
                    while ($row = $result_recette->fetch_assoc()) {
                        $id_recette = $row['id_recette'];

                        echo '<div class="container">';
                        echo '<div id="body_recette">';
                        echo '<div id="recette-container">';
                        echo '<br>';
                        echo '<img class="recipe-image" src="' . $row['image_recette'] . '" alt="Recette">';
                        echo "<h2>" . $row["titre"] . "</h2></br>";
                        echo "<h4>Source : " . $row['source'] . "</h4>";
                        echo "<p>Temps de préparation : " . $row['temps_prep_recette'] . "</p>";
                        echo "<p>Temps de total : " . $row['temps_total_recette'] . "</p>";
                        echo "<p>Nombre de personne : " . $row['nb_personne'] . "</br>";
                        echo "<p>Difficulté : " . $row['difficulte'] . "</p>";
                        
                    }

                    $query_ingredient = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                                        JOIN quantite q ON q.id_recette = r.id_recette
                                        JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                                        JOIN unite u ON u.id_unite = i.id_unite
                                        WHERE r.titre LIKE '$mot_clef';";

                    $result_ingredient = $mysqli->query($query_ingredient);

                    echo "<h3>Ingrédients</h3>";

                    while ($row = $result_ingredient->fetch_assoc()) {
                        if ($row['quantite'] == 0) {
                            $row['quantite'] = "";
                        }

                        echo "<li>" . $row['quantite'] . " " . $row['libelle_unite'] . " " . $row['nom_ingredient'] . "</li>";
                    }

                    $query_etape = "SELECT e.id_etape, e.texte_etape FROM recette r 
                                    JOIN etape e ON e.id_recette = r.id_recette
                                    WHERE r.id_recette = " . $id_recette . ";";

                    $result_etape = $mysqli->query($query_etape);

                    echo "<h3>Étapes</h3>";

                    while ($row = $result_etape->fetch_assoc()) {
                        echo "<li>" . "Etape " . $row['id_etape'] . " : " . $row['texte_etape'] . "</li>";
                    }

                    echo "</br>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<p>Aucun résultat.</p>";
                }
            } else {
                echo "<p>Aucun résultat</p>";
            }

            $mysqli->close();
        ?>

        <?php
            echo '<div id="body_modif">';
            echo '<div id="recette-container">';
        ?>

        <h2>Modification</h2>


        <form action="Confirmation_Modification_recette.php?pseudo=<?php echo $_SESSION['pseudo_user']; ?>" method="POST">
            <p>Pour modifier la recette, vous devez remplir toutes les cases. Si vous ne souhaitez pas modifier un élément, écrivez simplement l'élément sans modification. Attention vous ne pouvez pas modifier le titre en un titre déjà existant dans la database !</p>

            <label for="titre">Titre</label>
            <input type="text" class="Button" name="titre" required /><br>

            <label for="source">Source</label>
            <input type="text" class="Button" name="source" required /><br>

            <label for="image_recette">Lien de l'image</label>
            <input type="text" class="Button" name="image_recette" /><br>

            <label for="nb_personne">Nombre de personne</label>
            <input type="number" min="1" class="Button" name="nb_personne" required /><br>

            <label for="temps_prep_recette">Temps de préparation</label>
            <input type="number" min="0" class="Button" name="temps_prep_recette" step="1" required /><br>
            
            <label for="temps_total_recette">Temps total</label>
            <input type="number" min="0" class="Button" name="temps_total_recette" step="1" required /><br>

            <label for="difficulte">Difficulté</label>
            <input type="number" min="1" max="3" class="Button" name="difficulte" required /><br>
            
            <br>

             <div id="TextAreaQuantite">
                <label for="quantite_ingredient[]">Pour chaque ingredient, ajoutez un nouveau champ de texte avec ou sans modifications</label><br>
                <label for="quantite_ingredient[]">Ecrivez sous ce format : "quantité, ingrédient, unité, tag" (exemple : "200, chocolat, g, chocolat", "1/2, eau chaude, verre, eau", "2, oeufs, 0, oeufs")</label>
                <br>
                <textarea class="Button" name="quantite_ingredient[]" required ></textarea>
            </div>
            <button type="button" class="Button" onclick="AjoutChampTexteQuantite()">Ajouter un ingrédient</button>

            <br>
            <br>

            <div id="TextAreaEtapes">
                <label for="texte_etape">Pour chaque etape, ajoutez un nouveau champ de texte avec ou sans modifications</label><br>
                <label for="texte_etape">N'écrivez pas le numéro de l'étape (exemple : "Etape 4 : Laisser de côté pendant 4 h." => "Laisser de côté pendant 4 h.")</label>
                <br>
                <textarea class="Button" name="etapes[]"></textarea>
            </div>
            <button type="button" class="Button" onclick="AjoutChampTexteEtape()">Ajouter une étape</button>

            <br>
            <input type="submit" class="Button" value="Modifier" />

            <?php
                echo "</div>";
                echo "</div>";
                echo "</div>";
            ?>
        </form>
    </body>
</html>
