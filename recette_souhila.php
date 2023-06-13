<?php
require 'Function.php';
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>GastronoMix</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!--<meta http-equiv="refresh" content="2; url=/req_actualiser_lobby?choix={{choix}}&pseudo={{pseudo}}">-->
    <script src="Function.js"></script>
</head>
<body>
<button id="favori-button" class="Button" type="button">❤</button>
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
 
<div id="header">
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

    <form action="" method="GET">
        <input type="text" name="recherche" value="">
        <button class="Button" type="submit">Rechercher</button>
    </form>

    <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
</div>

<br><br>

<h1>Résultat</h1>

<?php
$mysqli = ConnectionDatabase();

if (isset($_GET['recherche'])) {
    $mot_clef = $_GET['recherche'];

    $query = "SELECT image_recette, titre, temps_prep_recette, temps_cui_recette, temps_repos_recette, nb_personne
                FROM recette 
                WHERE titre LIKE '%$mot_clef%';";

    $result_recette = $mysqli->query($query);

    if ($result_recette->num_rows > 0) {
        while ($row = $result_recette->fetch_assoc()) {
            echo $row['image_recette'] . "<br>";
            echo "<h2>" . $row["titre"] . "</h2><br>";
            echo "<p>Temps de préparation : " . $row['temps_prep_recette']. "</p>";
            echo "<p>Temps de cuisson : " . $row['temps_cui_recette']. "</p>";
            echo "<p>Temps de repos : " . $row['temps_repos_recette'] . "</p>";
            echo "<h3>Nombre de personnes</h3>" . $row['nb_personne'] . "<br>";

            // Code pour afficher le cœur favori ici
            if (isset($_SESSION['id_user'])) {
                echo '<span class="favori-icon">&#9825;</span>';
            }

            $query_materiel = "SELECT m.libelle_materiel FROM recette r
                                JOIN recette_materiel rm ON rm.id_recette = r.id_recette
                                JOIN materiel m ON m.id_materiel = rm.id_materiel
                                WHERE r.titre LIKE '%$mot_clef%';";

            $result_materiel = $mysqli->query($query_materiel);

            if ($result_materiel->num_rows > 0) {
                echo "<h3>Matériel</h3>";
                while ($row_materiel = $result_materiel->fetch_assoc()) {
                    echo "<li>" . $row_materiel['libelle_materiel'] . "</li>";
                }
            }

            $query_ingredient = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                                    JOIN quantite q ON q.id_recette = r.id_recette
                                    JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                                    JOIN unite u ON u.id_unite = i.id_unite
                                    WHERE r.titre LIKE '%$mot_clef%';";

            $result_ingredient = $mysqli->query($query_ingredient);

            if ($result_ingredient->num_rows > 0) {
                echo "<h3>Ingrédients</h3>";
                while ($row_ingredient = $result_ingredient->fetch_assoc()) {
                    echo "<li>" . $row_ingredient['nom_ingredient'] . " " . $row_ingredient['quantite'] . " " . $row_ingredient['libelle_unite'] . "</li>";
                }
            }

            $query_etape = "SELECT e.id_etape, e.texte_etape FROM recette r 
                                JOIN etape e ON e.id_recette = r.id_recette
                                WHERE r.titre LIKE '%$mot_clef%';";

            $result_etape = $mysqli->query($query_etape);

            if ($result_etape->num_rows > 0) {
                echo "<h3>Étapes</h3>";
                while ($row_etape = $result_etape->fetch_assoc()) {
                    echo "<li>" . "Étape " . $row_etape['id_etape'] . " : " . $row_etape['texte_etape'] . "</li>";
                }
            }

            echo "<br>";
        }
    } else {
        echo "<p>Aucun résultat.</p>";
    }

    $mysqli->close();
} else {
    echo "<p>Aucun résultat</p>";
}
?>
</body>
</html>
