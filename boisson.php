<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Liste des boissons</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <div header>
            <button class="Button" onclick="toggleMenu()">=</button>

            <div id="menu">
                <!-- Votre contenu de menu ici -->
                <ul>
                    <h2>Menu</h2>
                    <li><a href="http://localhost/gastronomix/Accueil.php">Accueil</a></li>
                    <li><a href="http://localhost/gastronomix/entree.php">Entrée</a></li>
                    <li><a href="http://localhost/gastronomix/plat.php">Plat</a></li>
                    <li><a href="http://localhost/gastronomix/dessert.php">Dessert</a></li>
                    <li><a href="http://localhost/gastronomix/boisson.php">Boisson</a></li>
                </ul>
            </div>

            <form action="display" method="GET">
                <input type="text" name="recherche" value="">
                <button class="Button" type="submit">Rechercher</button>
            </form>

            <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
        </div>
        
        <h1>Les boissons</h1>

        <?php
        $mysqli = ConnectionDatabase();
        
        $query = "SELECT r.id_recette, r.titre, r.categorie_recette, r.description_recette, c.libelle_categorie FROM recette r
        JOIN categorie c ON c.id_categorie = r.id_categorie
        WHERE c.libelle_categorie = 'boisson'";
    
        $result = $mysqli->query($query);
        
        if ($result !== false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>Titre: " . $row["titre"] . "</h2>";
                echo "<p><strong>Description:</strong> " . $row["description_recette"] . "</p>";
                echo "<p><strong>Catégorie:</strong> " . $row["categorie_recette"] . "</p>";
                
                $recette_id = $row["id_recette"];
                
                $etape_query = "SELECT nom_etape, texte_etape FROM etape WHERE id_recette = $recette_id";
                $etape_result = $mysqli->query($etape_query);
                
                if ($etape_result !== false && $etape_result->num_rows > 0) {
                    echo "<h3>Étapes:</h3>";
                    echo "<ol>";
                    
                    while ($etape_row = $etape_result->fetch_assoc()) {
                        echo "<li><strong>Nom de l'étape:</strong> " . $etape_row["nom_etape"] . "</li>";
                        echo "<li><strong>Texte de l'étape:</strong> " . $etape_row["texte_etape"] . "</li>";
                    }
                    
                    echo "</ol>";
                } else {
                    echo "<p>Aucune étape trouvée pour cette recette.</p>";
                }
            }
        } else {
            echo "Aucune boisson trouvée.";
        }
        $mysqli->close();
        ?>
        
    </body>
</html>
