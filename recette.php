<?php
    require 'Function.php';
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
<div header>
        <button class="Button" onclick="toggleMenu()">=</button>

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
	
    </br></br>

    <h1>Résultat</h1>
    

        <?php
            $mysqli = ConnectionDatabase();
            
            if (isset($_GET['recherche'])) {
                $mot_clef = $_GET['recherche'];

                $query = "SELECT r.image_recette, r.titre, r.temps_prep_recette, r.temps_cui_recette, r.temps_repos_recette, m.libelle_materiel, r.nb_personne, i.nom_ingredient, q.quantite, u.libelle_unite, e.id_etape, e.texte_etape
                        FROM recette r
                        JOIN etape e ON e.id_recette = r.id_recette
                        JOIN quantite q ON q.id_recette = r.id_recette
                        JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                        JOIN unite u ON u.id_unite = i.id_unite
                        JOIN recette_materiel rm ON rm.id_recette = r.id_recette
                        JOIN materiel m ON m.id_materiel = rm.id_materiel
                        WHERE r.titre LIKE '%$mot_clef%';";


                $result = $mysqli->query($query);


                $row = mysqli_fetch_assoc($result);
                echo $row['image_recette'] . "</br>";
                echo "<h2>" . $row["titre"] . "</h2>";
                echo "<p>Temps de preparation : </p>" . $row['temps_prep_recette']. "</p>" . "</br>";
                echo "<p>Temps de cuisson : </p>" . $row['temps_cui_recette']. "</p>" . "</br>" ;
                echo "<p>Temps de repos : </p>" . $row['temps_repos_recette'] . "</p>" . "</br>" ;
                echo "<h3>Materiel</h3>" . $row['libelle_materiel'] . "</br>" ; 
                echo "<h3>Nombre de personne</h3>" . $row['nb_personne'] . "</br>" ;
                echo "<h3>Ingredient</h3>" . $row['nom_ingredient'] . " " . $row['quantite'] . " " . $row['libelle_unite'] . "</br>";
                echo "<h3>Etape</h3>" .  $row['id_etape'] . " :	" . $row['texte_etape'] . "</br>";

                echo "</br>";
            } else {
                echo "Aucun résultat";
            }

            $mysqli->close();
        ?>
</body>
</html>