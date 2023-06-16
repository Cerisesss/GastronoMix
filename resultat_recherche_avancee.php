<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Res</title>
    </head>
    <body>
        <?php
            $mysqli = ConnectionDatabase();

            // Récupérer les mots associés à "aliments_ok" et "aliments_ko"
            if (!empty($_GET['aliments_ok']) && !empty($_GET['aliments_ko']) && !empty($_GET['categorie'])) {
                $aliments_ok = $_GET['aliments_ok'];
                $aliments_ko = $_GET['aliments_ko'];
                $categorie = $_GET['categorie'];

                //test de récupération des données
                //var_dump($_GET['aliments_ok'], $_GET['aliments_ko'], $_GET['categorie']);

                $aliments_ok_string = implode("', '", $aliments_ok);
                $aliments_ko_string = implode("', '", $aliments_ko);

                // Requête SQL pour récupérer les recettes correspondantes
                $sql = "SELECT r.titre, r.image_recette, c.libelle_categorie
                FROM recette r
                JOIN quantite q ON q.id_recette = r.id_recette
                JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                JOIN categorie c ON c.id_categorie = r.id_categorie
                WHERE i.nom_ingredient IN ('$aliments_ok_string')
                AND NOT EXISTS (
                    SELECT 1
                    FROM quantite q2
                    JOIN ingredient i2 ON i2.id_ingredient = q2.id_ingredient
                    WHERE q2.id_recette = r.id_recette
                    AND i2.nom_ingredient IN ('$aliments_ko_string')
                )
                AND c.libelle_categorie = '$categorie'";
        
                $result = $mysqli->query($sql);

                // Utilisez le résultat de la requête pour afficher les données
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "Titre de la recette : " . $row['titre'] . "<br>";
                        echo "Image de la recette : " . $row['image_recette'] . "<br>";
                    }
                    $result->free();
                } else {
                    echo "Erreur lors de l'exécution de la requête : " . $mysqli->error;
                }
            }
        ?>
    </body>
</html>


