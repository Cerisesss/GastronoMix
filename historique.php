

<!DOCTYPE html>
<html>
<head>
    <title>GastronoMix</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="Function.js"></script>
</head>
<body>


<div id="header">
    <button id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

    <div id="menu">
        <ul>
            <h2>Menu</h2>
            <li><a href="http://localhost/gastronomix/Accueil.php">🍽️ Accueil</a></li>
            <li><a href="http://localhost/gastronomix/entree.php">🍽️ Entrée</a></li>
            <li><a href="http://localhost/gastronomix/plat.php">🍽️ Plat</a></li>
            <li><a href="http://localhost/gastronomix/dessert.php">🍽️ Dessert</a></li>
            <li><a href="http://localhost/gastronomix/boisson.php">🍽️ Boisson</a></li>
        </ul>
    </div>

    <div id="Rechercher">
        <form action="recette.php" method="GET">
            <input id="RechercherBarre" type="text" name="recherche" value="">
            <button id="RechercherButton" class="Button" type="submit">🔍</button>
        </form>

        <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
    </div>

    <br><br>

    <h1>Résultat</h1> 
    <h2>Recettes noter</h2>

    <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>
<?php
require 'Function.php';
session_start();

if (isset($_SESSION['pseudo_user'])) {
    $pseudo = $_SESSION['pseudo_user'];

    $mysqli = ConnectionDatabase();

    // Récupérer les avis de l'utilisateur pour une recette donnée
    $query = "SELECT h.id_recette, r.titre, r.image_recette, h.avis_historique
                FROM historique h
                JOIN recette r ON r.id_recette = h.id_recette
                JOIN user u ON u.id_user = h.id_user
                WHERE u.pseudo_user = '$pseudo';";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_recette = $row['id_recette'];
            $titre = $row['titre'];
            $image_recette = $row['image_recette'];
            $avis_historique = $row['avis_historique'];
            echo '<div class="recette-categorie">';
            echo '<div class="container">';
            echo '<div class="recette zoom">';
            // Image cliquable
            echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">';
            echo '<img src="' . $image_recette . '" alt="Image de la recette"><br>';
            echo '</a>';
              // Titre cliquable
              echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">' . $titre . '</a><br>';
            echo '</div>';
            echo '<div class="nom-recette">';
            // Afficher l'avis de l'utilisateur
            echo '</div>';
            echo 'Avis : ' . $avis_historique . '/5';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Aucun avis trouvé dans l'historique.</p>";
    }

    $mysqli->close();
} else {
    echo "<p>Veuillez vous connecter pour accéder à votre historique d'avis.</p>";
}
?>
</body>
</html>