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
                
        
            
                
                //if ($mot_clef !== false && $mot_clef !== null) {

                $query = "SELECT image_recette, titre, temps_prep_recette, temps_cui_recette, temps_repos_recette, nb_personne
                        FROM recette 
                        WHERE titre LIKE '%$mot_clef%';";


                $result_recette = $mysqli->query($query);


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
            /*} else {
                echo "<p>Aucun résultat.</p>";
            }*/
            } else {
                echo "<p>Aucun résultat</p>";
            }

            $mysqli->close();
        ?>
</body>
</html>