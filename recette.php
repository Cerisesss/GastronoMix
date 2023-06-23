<?php
    require 'Function.php';
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix</title>
        <link rel="stylesheet" type="text/css" href="styler.css">
       

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



        <?php
            $mysqli = ConnectionDatabase();

            if (isset($_GET['recherche'])) {
                $mot_clef = $_GET['recherche'];

                $query = "SELECT id_recette, image_recette, titre, source, temps_prep_recette, temps_total_recette, nb_personne, difficulte
                        FROM recette 
                        WHERE titre LIKE '%$mot_clef%';";

                $result_recette = $mysqli->query($query);

                if ($result_recette && $result_recette->num_rows > 0) {
                    // Pour la table recettes
                    while ($row = $result_recette->fetch_assoc()) {
                        $id_recette = $row['id_recette'];
                        echo '<div id="recette-container">';
                        echo '<img class="recipe-image" src="' . $row['image_recette'] . '" alt="Recette">';
                        echo "<h2>" . $row["titre"] . "</h2></br>";
                        echo "<h4>Source : " . $row['source']. "</h4>";
                        echo "<p>Temps de préparation : " . $row['temps_prep_recette']. "</p>";
                        echo "<p>Temps de total : " . $row['temps_total_recette'] . "</p>";
                        echo "<p>Nombre de personne : " . $row['nb_personne'] . "</br>" ;
                        echo "<p>Difficulté : " . $row['difficulte'] . "</p>";
                    }
                    
                    // Pour les ingrédients
                    $query_ingredient = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                            JOIN quantite q ON q.id_recette = r.id_recette
                            JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                            JOIN unite u ON u.id_unite = i.id_unite
                            WHERE r.titre LIKE '%$mot_clef%';";

                    $result_ingredient = $mysqli->query($query_ingredient);

                    echo "<h3>Ingrédients</h3>";

                    while ($row = $result_ingredient->fetch_assoc()) {
                        if ($row['quantite'] == 0) {
                            $row['quantite'] = "";
                        }

                        echo "<li>" . $row['quantite'] . " " . $row['libelle_unite'] . " " . $row['nom_ingredient'] . "</li>" ;
                    }

                    // Pour les étapes
                    $query_etape = "SELECT e.id_etape, e.texte_etape FROM recette r 
                            JOIN etape e ON e.id_recette = r.id_recette
                            WHERE r.id_recette = " . $id_recette . ";";

                    $result_etape = $mysqli->query($query_etape);

                    echo "<h3>Étapes</h3>";

                    while ($row = $result_etape->fetch_assoc()) {
                        echo "<li>" . "Etape " . $row['id_etape'] . " : " . $row['texte_etape'] . "</li>" ;
                    }

                    echo "</br>";

                    if (isset($_SESSION['id'])) {
                        // L'utilisateur est connecté, afficher le formulaire pour ajouter aux favoris
                        echo '<form id="ajouter-favoris-form" method="post">';
                        echo '<input type="hidden" name="id_recette" value="' . $id_recette . '">';
                        echo '<input type="submit" value="🧡">';
                        echo '</form>';
                        echo '<button id="CompteButton" class="Button" onclick="toggleCompte()">Compte</button>';
                        echo '<div id="compte">';
                        echo '<ul>';
                        echo '<li><a href="http://localhost/gastronomix/profil.php">⚙️ Profil</a></li>';
                        echo '<li><a href="http://localhost/gastronomix/favoris.php">🧡 Favoris</a></li>';
                        echo '<li><a href="http://localhost/gastronomix/historique.php">⌛️ Historique</a></li>';
                        echo '<li><a href="http://localhost/gastronomix/deconnexion.php">👋 Déconnexion</a></li>';
                        echo '</ul>';
                        echo '</div>';
                        
                        echo '<form action="historique.php" method="POST">';
                       for ($i = 1; $i <= 5; $i++) {
                     // Afficher les 5 étoiles cliquables qui permettent de noter la recette
                     echo '<input type="radio" id="star' . $i . '" name="note" value="' . $i . '" style="display: none;">';
                     echo '<label for="star' . $i . '"><span class="star">&#9734;</span></label>';
                    }    
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
                        // Le script PHP a terminé avec succès
                        alert("La recette a été ajoutée aux favoris !");
                    } else {
                        throw new Error("Erreur lors de l'ajout aux favoris.");
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





