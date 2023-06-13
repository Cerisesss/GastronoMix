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
    <a href="http://localhost/gastronomix/favoris.php"><button class="Button">Favoris</button></a>

        <div header>
            <h1>GastronoMix</h1>

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

            <form action="recette.php" method="GET">
                <input type="text" name="recherche" value="">
                <button class="Button" type="submit">Rechercher</button>
            </form>
            <li><a href="deconnexion.php">Déconnexion</a></li> <!-- Bouton de déconnexion -->
            <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
        </div>
        <?php if (isset($_SESSION['id_user'])) : ?>
    <a href="http://localhost/gastronomix/favoris.php"><button class="Button">Favoris</button></a>
<?php endif; ?>



        <!-- Si connecté
        <button class="Button" onclick="toggleCompte()">Compte</button>
        <div id="compte">
            <ul> 
                <li><a href="http://localhost/gastronomix/profil.php">Profil</a></li>
                <li><a href="http://localhost/gastronomix/favoris.php">Favoris</a></li>
                <li><a href="http://localhost/gastronomix/historique.php">Historique</a></li>
                <li><a href="http://localhost/gastronomix/deconnexion.php">Déconnexion</a></li>
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

        <h1>GastronoMix</h1>

    <!-- Si connecté
    <button id="CompteButton" class="Button" onclick="toggleCompte()">Compte</button>
    <div id="compte">
        <ul> 
            <li><a href="http://localhost/gastronomix/profil.php">⚙️ Profil</a></li>
            <li><a href="http://localhost/gastronomix/favoris.php">🧡 Favoris</a></li>
            <li><a href="http://localhost/gastronomix/historique.php">⌛️ Historique</a></li>
            <li><a href="http://localhost/gastronomix/deconnexion.php">👋 Déconnexion</a></li>
        </ul>
    </div>
    -->

	
    </br></br>
    

    <?php
        $mysqli = ConnectionDatabase();
        
        $categorie = ["Entree", "Plat", "Dessert", "Boisson"];

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

                $lienRecette = '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">' . $titre . '</a>';

                echo $image_recette . '<br>';
                echo $lienRecette . '<br><br>';
            }

            echo "</br>";
        }

        $mysqli->close();
    ?>
</body>
</html>