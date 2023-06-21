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
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>

        <div id="menu">
            <ul>
                <h2>Menu</h2>

                <?php 
                    if(isset($_SESSION['pseudo_user'])) {
                        MenuDeroulantConnecter($pseudo);
                    } else {
                        MenuDeroulantDeconnecter();
                    }
                ?>
            </ul>
        </div>

        <div id="Rechercher">
            <form action="recette.php" method="GET">
                <input id="RechercherBarre" type="text" name="recherche" value="">
                <button id="RechercherButton" class="Button" type="submit">🔍</button>
            </form>
        </div>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>

        <h1>GastronoMix</h1>

        <?php
            if (isset($_SESSION['pseudo_user'])) {
                MenuDeroulantCompte($pseudo);
            } else {
                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }


            $mysqli = ConnectionDatabase();

            $categorie = ["Entree", "Plat", "Dessert", "Boisson"];

            for ($i = 0; $i < count($categorie); $i++) {
                $categorie_actuelle = $categorie[$i];

                echo $categorie_actuelle . "</br>";

                $query = "SELECT image_recette, titre, id_recette FROM recette
                        WHERE categorie_recette = '$categorie_actuelle'
                        ORDER BY titre asc ;";

                $result = $mysqli->query($query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $image_recette = $row["image_recette"];
                    $titre = $row['titre'];

                    $lienRecette = '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">' . $titre . '</a>';

                    echo '<img src="' . $row['image_recette'] . '" alt="Image de la recette"><br>';
                    echo $lienRecette . '<br>';

                    // Affichage du bouton d'ajout aux favoris
                    if (isset($_SESSION['pseudo_user'])) {
                        $id_recette = $row['id_recette'];
                        echo '<form action="" method="post">';
                        echo '<input type="hidden" name="favori_recette" value="' . $id_recette . '">';
                        echo '<button class="Button" type="submit">🧡</button>';
                        echo '</form>';
                    }

                    echo "<br>";
                }

                echo "</br>";
            }

            $mysqli->close();
        ?>

    </body>
</html>
