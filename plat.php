<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Liste des plats</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <div header>
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

            <form action="recette.php" method="GET">
                <input type="text" name="recherche" value="">
                <button class="Button" type="submit">Rechercher</button>
            </form>

            <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
        </div>

        <h1>Plats</h1>

        <?php
    $mysqli = ConnectionDatabase();
    
    $query = "SELECT r.id_recette, r.titre, r.image_recette
              FROM recette r
              JOIN categorie c ON c.id_categorie = r.id_categorie
              WHERE c.libelle_categorie = 'plat'";
    
    $result = $mysqli->query($query);
    
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           
            $titre = $row['titre'];
            $imageLink = $row['image_recette'];
            
            echo "<a href=\"recette.php?recherche=$titre\">";
            echo "<h2>$titre</h2>";
            echo "<img src=\"$imageLink\" alt=\"Description de l'image\">";
            echo "</a>";
        }
    } else {
        echo "Aucun plat trouvé.";
    }
    
    $mysqli->close();
    ?>
        
    </body>
</html>
