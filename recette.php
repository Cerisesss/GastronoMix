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
    <script>
        document.getElementById('favori-button').addEventListener('click', function() {
            // Code à exécuter lors du clic sur le bouton
            // Vérifier si l'utilisateur est connecté
            <?php if (isset($_SESSION['id_user'])) { ?>
                // Envoyer une requête au serveur pour ajouter la recette en favori
                fetch('http://localhost/gastronomix/ajouter_favorie.php')
                .then(function(response) {
                    // Gérer la réponse du serveur ici
                })
                .catch(function(error) {
                    // Gérer les erreurs ici
                });
            <?php } else { ?>
                // Rediriger vers la page de connexion
                window.location.href = 'http://localhost/gastronomix/connexion.php';
            <?php } ?>
        });
    </script>


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

                $query = "SELECT image_recette, titre, temps_prep_recette, temps_cui_recette, temps_repos_recette, nb_personne
                        FROM recette 
                        WHERE titre LIKE '%$mot_clef%';";


                $result_recette = $mysqli->query($query);

                if($result_recette->num_rows > 0) {

                    if (isset($_SESSION['id_user'])) {
                        echo '<span class="favori-icon">&#9825;</span>';
                    }

                    $row = mysqli_fetch_assoc($result_recette);
                    echo $row['image_recette'] . "</br>";
                    echo "<h2>" . $row["titre"] . "</h2></br>";
                    echo "<p>Temps de preparation : </p>" . $row['temps_prep_recette']. "</p>";
                    echo "<p>Temps de cuisson : </p>" . $row['temps_cui_recette']. "</p>";
                    echo "<p>Temps de repos : </p>" . $row['temps_repos_recette'] . "</p>";
                    echo "<h3>Nombre de personne</h3>" . $row['nb_personne'] . "</br>" ;


                    $query = "SELECT m.libelle_materiel FROM recette r
                            JOIN recette_materiel rm ON rm.id_recette = r.id_recette
                            JOIN materiel m ON m.id_materiel = rm.id_materiel
                            WHERE r.titre LIKE '%$mot_clef%';";


                    $result_materiel = $mysqli->query($query);

                    echo "<h3>Materiel</h3>";
                    
                    while ($row = mysqli_fetch_assoc($result_materiel)) {
                        echo "<li>" . $row['libelle_materiel'] . "</li>" ; 
                    }


                    $query = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                            JOIN quantite q ON q.id_recette = r.id_recette
                            JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                            JOIN unite u ON u.id_unite = i.id_unite
                            WHERE r.titre LIKE '%$mot_clef%';";


                    $result_ingredient = $mysqli->query($query);

                    echo "<h3>Ingredient</h3>";
                    
                    while ($row = mysqli_fetch_assoc($result_ingredient)) {
                        echo "<li>" . $row['nom_ingredient'] . " " . $row['quantite'] . " " . $row['libelle_unite'] . "</li>" ; 
                    }


                    $query = "SELECT e.id_etape, e.texte_etape FROM recette r 
                            JOIN etape e ON e.id_recette = r.id_recette
                            WHERE r.titre LIKE '%$mot_clef%';";

                    $result_ingredient = $mysqli->query($query);

                    echo "<h3>Etape</h3>";
                    
                    while ($row = mysqli_fetch_assoc($result_ingredient)) {
                        echo "<li>" . "Etape " . $row['id_etape'] . " : " . $row['texte_etape'] . "</li>" ; 
                    }

                    echo "</br>";
                } else {
                    echo "<p>Aucun résultat.</p>";
                }
            } else {
                echo "<p>Aucun résultat</p>";
            }

            $mysqli->close();
        ?>
    </body>
</html>