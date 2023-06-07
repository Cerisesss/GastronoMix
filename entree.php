<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Liste des entrées</title>
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
        <h1>Entrées</h1>

        <?php
            $mysqli = ConnectionDatabase();
            
            $query = "SELECT r.image_recette, r.titre 
                    FROM recette r
                    JOIN categorie c ON c.id_categorie = r.id_categorie
                    WHERE c.libelle_categorie = 'entrée';";
        
            $result = $mysqli->query($query);
            
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo $row["image_recette"];
                    echo "<h2>" . $row["titre"] . "</h2>";
                }
            } else {
                echo "Aucun résultat.";
            }
            $mysqli->close();
        ?>
        
    </body>
</html>
