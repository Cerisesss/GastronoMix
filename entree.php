<?php
    require 'Function.php';
    session_start();

    if (isset($_GET['pseudo'])) {
        $pseudo = $_GET['pseudo'];
        $_SESSION['pseudo_user'] = $pseudo;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Liste des entrées</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>

        <div id="menu">
            <ul>
                <h2>Menu</h2>
                
                <?php 
                    if(isset($_SESSION['pseudo_user'])) {
                        MenuDeroulantConnecter($pseudo);
                    } else {
                        MenuDeroulantDeconnecter();
                    }
                ?>
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


        <h1>Entrées</h1>

        <?php
            if (isset($_SESSION['pseudo_user'])) {
                MenuDeroulantCompte($pseudo);
            } else {
                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }
            
            $mysqli = ConnectionDatabase();
            
            $query = "SELECT r.id_recette, r.titre, r.image_recette
                    FROM recette r
                    JOIN categorie c ON c.id_categorie = r.id_categorie
                    WHERE c.libelle_categorie = 'entree'";
            
            $result = $mysqli->query($query);
            
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                
                    $titre = $row['titre'];
                    $imageLink = $row['image_recette'];
                    
                    echo "<a href=\"recette.php?recherche=$titre\">";
                    echo "<h2>$titre</h2>";
                    echo "<img src=\"$imageLink\" alt=\"Description de l'image\">";
                    echo "</a>";
                }
            } else {
                echo "Aucun entree trouvé.";
            }
    
            $mysqli->close();
        ?>
        
    </body>
</html>
