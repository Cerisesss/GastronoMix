<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>

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
        </div>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>

        <button id="favori-button" class="Button" type="button">❤</button>
        

        <?php
            $mysqli = ConnectionDatabase();
            
            if (isset($_GET['recherche'])) {
                $mot_clef = $_GET['recherche'];

                $query = "SELECT image_recette, titre, source, temps_prep_recette, temps_total_recette, nb_personne, difficulte
                        FROM recette 
                        WHERE titre LIKE '%$mot_clef%';";


                $result_recette = $mysqli->query($query);

                if($result_recette->num_rows > 0) {
                    //pour la table recettes
                    while($row = mysqli_fetch_assoc($result_recette)){
                        echo '<img src="' . $row['image_recette'] . '"><br>';
                        echo "<h2>" . $row["titre"] . "</h2></br>";
                        echo "<p>Source : </p>" . $row['source']. "</p>";
                        echo "<p>Temps de préparation : </p>" . $row['temps_prep_recette']. "</p>";
                        echo "<p>Temps de total : </p>" . $row['temps_total_recette'] . "</p>";
                        echo "<h3>Nombre de personne</h3>" . $row['nb_personne'] . "</br>" ;
                        echo "<p>Difficulté : </p>" . $row['difficulte'] . "</p>";
                    }

                    $query_materiel = "SELECT m.libelle_materiel FROM recette r
                            JOIN recette_materiel rm ON rm.id_recette = r.id_recette
                            JOIN materiel m ON m.id_materiel = rm.id_materiel
                            WHERE r.titre LIKE '%$mot_clef%';";


                    $result_materiel = $mysqli->query($query_materiel);

                    //pour les materiels
                    echo "<h3>Matériel</h3>";
                    
                    while ($row = mysqli_fetch_assoc($result_materiel)) {
                        echo "<li>" . $row['libelle_materiel'] . "</li>" ; 
                    }


                    //pour les ingredients
                    $query_ingredient = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                            JOIN quantite q ON q.id_recette = r.id_recette
                            JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                            JOIN unite u ON u.id_unite = i.id_unite
                            WHERE r.titre LIKE '%$mot_clef%';";


                    $result_ingredient = $mysqli->query($query_ingredient);

                    echo "<h3>Ingrédients</h3>";
                    
                    while ($row = mysqli_fetch_assoc($result_ingredient)) {
                        echo "<li>" . $row['nom_ingredient'] . " " . $row['quantite'] . " " . $row['libelle_unite'] . "</li>" ; 
                    }


                    //pour les etapes
                    $query_etape = "SELECT e.id_etape, e.texte_etape FROM recette r 
                            JOIN etape e ON e.id_recette = r.id_recette
                            WHERE r.titre LIKE '%$mot_clef%';";

                    $result_ingredient = $mysqli->query($query_etape);

                    echo "<h3>Étapes</h3>";
                    
                    while ($row = mysqli_fetch_assoc($result_ingredient)) {
                        echo "<li>" . "Etape " . $row['id_etape'] . " : " . $row['texte_etape'] . "</li>" ; 
                    }

                    echo "</br>";

                    if (isset($_SESSION['user'])) {
                        // L'utilisateur est connecté, afficher le formulaire pour ajouter aux favoris
                        echo '<form id="ajouter-favoris-form" method="post">';
                        echo '<input type="hidden" name="id_recette" value="' . $id_recette . '">';
                        echo '<input type="submit" value="Ajouter aux favoris">';
                        echo '</form>';
                    }

                } else {
                    echo "<p>Aucun résultat.</p>";
                }
            } else {
                echo "<p>Aucun résultat</p>";
            }

            $mysqli->close();
        ?>
        <script>
            document.getElementById('ajouter-favoris-form').addEventListener('submit', function(event) {
                event.preventDefault(); // Empêche le rechargement de la page

                var form = event.target;
                var formData = new FormData(form);

                fetch('ajouter_aux_favoris.php', {
                    method: 'POST',
                    body: formData
                })
                .then(function(response) {
                    if (response.ok) {
                        // Le script PHP a terminé avec succèsh
                        alert("La recette a été ajoutée aux favoris !");   
                    } else {
                        throw new Error('Erreur lors de l\'ajout aux favoris.');  
                    }
                })
                .catch(function(error) {
                    // Une erreur s'est produite lors de l'appel à ajouter_aux_favoris.php
                    alert(error.message);
                });
            });
        </script>
    </body>
</html>