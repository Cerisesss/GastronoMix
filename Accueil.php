<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>GastronoMix</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!--<meta http-equiv="refresh" content="2; url=/req_actualiser_lobby?choix={{choix}}&pseudo={{pseudo}}">-->
    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }
    </script>
</head>
<body>

    <div header>
        <h1>GastronoMix</h1>

        <button class="Button" onclick="toggleMenu()">=</button>

        <div id="menu">
            <!-- Votre contenu de menu ici -->
            <ul>
                <h2>Menu</h2>
                <!--<li><a href="http://localhost/gastronomix/Accueil.php">Accueil</a></li>-->
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


    <!-- Si connecté
    <button class="Button" onclick="toggleCompte()">Compte</button>
    <div id="compte">
        <ul> 
            <li><a href="http://localhost/gastronomix/profil.php">Profil</a></li>
            <li><a href="http://localhost/gastronomix/favoris.php">Favoris</a></li>
            <li><a href="http://localhosts/gastronomix/historique.php">Historique</a></li>
            <li><a href="http://localhost/gastronomix/deconnexion.php">Déconnexion</a></li>
        </ul>
    </div>
    -->

	
    </br></br></br>
    

    <?php
        $mysqli = ConnectionDatabase();
        
        $categorie = ["Entree", "Plat", "Dessert", "Boisson"];

        // Requête SQL
        
        for($i = 0; $i < count($categorie); $i++){
            $categorie_actuelle = $categorie[$i];

            echo $categorie_actuelle . "</br>";

            $query = "SELECT image_recette, titre FROM recette
                    WHERE categorie_recette = '$categorie_actuelle'
                    ORDER BY titre asc ;";

            $result = $mysqli->query($query);


            while ($row = mysqli_fetch_assoc($result)) {
                $image_recette = $row["image_recette"];
                $titre = $row['titre'];

                $lienRecette = '<a href="http://localhost/gastronomix/recette.php/' . $titre . '">' . $titre . '</a>';

                echo $image_recette . '<br>';
                echo $lienRecette . '<br><br>';
            }

            echo "</br>";
        }

        $mysqli->close();
    ?>
</body>
</html>