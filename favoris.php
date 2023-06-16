<?php
require 'Function.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>GastronoMix</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="Function.js"></script>
</head>
<body>
<div id="header">
    <button id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

    <div id="menu">
        <ul>
            <h2>Menu</h2>
            <li><a href="http://localhost/gastronomix/favoris.php">🍽️ favoris</a></li>
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

    <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

<?php
$mysqli = ConnectionDatabase();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id_user'])) {
    $user_id = $_SESSION['id_user'];

    $query = "SELECT r.image_recette, r.titre
              FROM recette AS r
              INNER JOIN favoris AS f ON r.id_recette = f.id_recette
              WHERE f.id_user = '$id_user'";

    $result = $mysqli->query($query);

    $recettes_favorites = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $image_recette = $row["image_recette"];
        $titre = $row['titre'];

        $recette = array(
            'image_recette' => $image_recette,
            'titre' => $titre
        );

        $recettes_favorites[] = $recette;
    }

    if (!empty($recettes_favorites)) {
        foreach ($recettes_favorites as $recette) {
            echo '<div>';
            echo '<img src="' . $recette['image_recette'] . '" alt="' . $recette['titre'] . '">';
            echo '<h3>' . $recette['titre'] . '</h3>';
            echo '</div>';
        }
    } else {
        echo 'Aucune recette favorite trouvée.';
    }
} else {
    echo 'Veuillez vous connecter pour voir vos recettes favorites.';
}

$mysqli->close();

?>

<h2>Recettes favorites</h2>

</body>
</html>
