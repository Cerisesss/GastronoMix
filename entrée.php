<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des entrée</title>
</head>
<body>
    <h1>Les entrée</h1>
    <?php
    $mysqli = ConnectionDatabase();
    
    $query = "SELECT r.id_recette, r.titre, r.categorie_recette, r.description_recette, c.libelle_categorie FROM recette r
    JOIN categorie c ON c.id_categorie = r.id_categorie
    WHERE c.libelle_categorie = 'entrée'";
   
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
        echo "Aucun entrée trouvé.";
    }
    $mysqli->close();
    ?>
    
</body>
</html>
