<?php
require 'Function.php';
session_start();

if (isset($_SESSION['id_user'])) {
    header('Location: favoris.php');
    exit;
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
<div id="header">
    <h1>GastronoMix</h1>

    <button id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

    <div id="menu">
        <ul>
            <h2>Menu</h2>
            <li><a href="http://localhost/gastronomix/Accueil.php">Accueil</a></li>
            <li><a href="http://localhost/gastronomix/entree.php">Entrée</a></li>
            <li><a href="http://localhost/gastronomix/plat.php">Plat</a></li>
            <li><a href="http://localhost/gastronomix/dessert.php">Dessert</a></li>
            <li><a href="http://localhost/gastronomix/boisson.php">Boisson</a></li>
        </ul>
    </div>

    <form action="favoris.php" method="GET">
        <button class="Button" type="submit">Afficher les recettes favorites</button>
    </form>

    <form action="recette.php" method="GET">
        <input type="text" name="recherche" value="">
        <button class="Button" type="submit">Rechercher</button>
    </form>

    <?php if (isset($_SESSION['id_user'])) : ?>
        <a href="deconnexion.php">Déconnexion</a>
    <?php else: ?>
        <!-- Bouton de connexion -->
        <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
    <?php endif; ?>



        <!-- Si connecté
        <button class="Button" onclick="toggleCompte()">Compte</button>
        <div id="compte">
            <ul> 
                <li><a href="http://localhost/gastronomix/profil.php">Profil</a></li>
                <li><a href="http://localhost/gastronomix/favoris.php">Favoris</a></li>
                <li><a href="http://localhost/gastronomix/historique.php">Historique</a></li>
                <li><a href="http://localhost/gastronomix/deconnexion.php">Déconnexion</a></li>
            </ul>
</div>
        -->

        
        </br></br>

<br><br>

<?php
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

        echo $image_recette . '<br>';
        echo $lienRecette . '<br>';

        // Affichage du bouton d'ajout aux favoris
        if (isset($_SESSION['id_user'])) {
            $id_recette = $row['id_recette'];
            echo '<form action="" method="post">';
            echo '<input type="hidden" name="favori_recette" value="' . $id_recette . '">';
            echo '<button class="Button" type="submit">Ajouter aux favoris</button>';
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
