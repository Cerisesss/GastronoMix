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
        <title>Liste des entrées</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <h1>GastronoMix</h1>
        <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>
        <div id="menu">
            <ul>
                <h3>Menu</h3>
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

        <h2>Entrée</h2>

        <?php
            if (isset($_SESSION['pseudo_user'])) {
                MenuDeroulantCompte($pseudo);
            } else {
                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }
            
            $mysqli = ConnectionDatabase();
            
            echo '<div class="container">';
            $query = "SELECT r.id_recette, r.titre, r.image_recette
                    FROM recette r
                    JOIN categorie c ON c.id_categorie = r.id_categorie
                    WHERE c.libelle_categorie = 'entree'
                    ORDER BY r.titre ASC";
            
            $result = $mysqli->query($query);
            
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $titre = $row['titre'];
                    $image_recette = $row['image_recette'];
                
                    echo '<div class="recette zoom">';
                    // Image cliquable
                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">';
                    echo '<img src="' . $image_recette . '" alt="Image de la recette"><br>';
                    echo "</a>";
                    echo '<div class="nom-recette">';
                    // Titre cliquable
                    echo "<a href=\"recette.php?recherche=$titre\">$titre</a><br>";
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Aucun entree trouvé.";
            }
            echo '</div>';
            $mysqli->close();
        ?>
    </body>
</html>
