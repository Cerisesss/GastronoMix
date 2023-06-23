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
        <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>
        <div id="menu">
            <ul>
                </br>
                <?php
                    if (isset($_SESSION['pseudo_user'])) {
                        MenuDeroulantConnecter($pseudo);
                    } else {
                        MenuDeroulantDeconnecter();
                    }
                ?>
            </ul>
        </div>


        <div id="Rechercher">
        <a href="http://localhost/gastronomix/recherche_avancee.php"><button id="Recherche_avancee" class="Button"><img src="Images/filtre.png" alt="Image"></button></a>

            <form action="resultat_recherche_avancee.php" method="GET">
                <input id="RechercherBarre" type="text" name="recherche" value="">
                <button id="RechercherButton" class="Button" type="submit">🔍</button>
            </form>
        </div>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h1>GastronoMix</h1>

        <?php
            if (isset($_SESSION['pseudo_user'])) {
                if($_SESSION['pseudo_user'] == "admin" || $_SESSION['pseudo_user'] == "Admin") {
                    MenuDeroulantAdmin($pseudo);
                }else {
                    MenuDeroulantCompte($pseudo);
                }
            } else {
                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }

            $mysqli = ConnectionDatabase();

            $categorie = ["Entrée", "Plat", "Dessert", "Boisson"];

            for ($i = 0; $i < count($categorie); $i++) {
                $categorie_actuelle = $categorie[$i];
                
                echo '<div class="recette-categorie">';
                echo '<h2>' . $categorie_actuelle . '</h2>';
                echo '<div class="container">';

                $rand = rand(1, 160);

                $query = "SELECT image_recette, titre, id_recette FROM recette
                                WHERE categorie_recette = '$categorie_actuelle'
                                ORDER BY RAND('$rand')
                                LIMIT 6;";

                $result = $mysqli->query($query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $image_recette = $row["image_recette"];
                    $titre = $row['titre'];

                    echo '<div class="recette zoom">';
                    // Image cliquable
                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">';
                    echo '<img src="' . $image_recette . '" alt="Image de la recette"><br>';
                    echo '</a>';
                    echo '<div class="nom-recette">';
                    // Titre cliquable
                    echo  '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">' . $titre . '</a>' . '<br>';
                    echo '</div>';
                    echo '</div>';

                    // Affichage du bouton d'ajout aux favoris
                    if (isset($_SESSION['pseudo_user'])) {
                        $id_recette = $row['id_recette'];
                        echo '<form action="" method="post">';
                        echo '<input type="hidden" name="favori_recette" value="' . $id_recette . '">';
                        echo '<button type="submit" class="favori-button" name="ajout_favori"><img src="favori.png"></button>';
                        echo '</form>';
                    }
                }
                echo '</div>';
                echo '</div>';
            }
            $mysqli->close();
        ?>

    </body>
</html>
