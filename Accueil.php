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

    <button onclick="toggleMenu()">=</button>
    <div id="menu">
        <!-- Votre contenu de menu ici -->
        <ul>
            <li><a href="http://localhost/gastronomix/entree.php">Entrée</a></li>
            <li><a href="http://localhost/gastronomix/plat.php">Plat</a></li>
            <li><a href="http://localhost/gastronomix/dessert.php">Dessert</a></li>
            <li><a href="http://localhost/gastronomix/boisson.php">Boisson</a></li>
        </ul>
    </div>


    <form action="display" method="GET">
		<input type="text" name="recherche" value="">
		<button class="favorite styled" type="submit">Rechercher</button>
    </form>

    <a href="http://localhost/gastronomix/creationdecompte.php"><button>Connexion</button></a>

	
    </br></br></br>
    

        <?php
            $host = "localhost";
            $user = "root";
            $password = "";
            $database = "GastronoMix"; 

            // Connexion à la base de données
            
            try {
                // Vérification de la connexion
                $mysqli = new mysqli($host, $user, $password, $database);
                //$mysqli = mysqli_connect($host, $user, $password, $database);
                //echo "Connexion à la base de données : " . $database . " réussie. </br></br>";
            }
            catch (Exception $e) {
                echo '<p>Erreur de Connexion au SGBD = '.$database;
                echo "\n -ERROR-ERROR-ERROR " . $e;
                die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error); 
                exit();
            }
            
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