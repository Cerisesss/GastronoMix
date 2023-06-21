<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Connexion</title>
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

        <?php
            $mysqli = ConnectionDatabase();

            $pseudo_user = $_GET['pseudo'];

            if($pseudo_user == ""){
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        ?>

        <h2>Se connecter</h2>

        <form action="Verification_connexion.php" method="post">
            <label for="mail_user">Email</label>
            <input type="email" class="Button" id="mail_user" name="mail_user" required /><br>

            <label for="password_user">Mot de passe</label>
            <input type="password" class="Button" id="password_user" name="password_user" required /><br>

            <input type="submit" class="Button" value="Se connecter" />
        </form>

        <p>Nouveau sur notre site ? <a href="http://localhost/gastronomix/test/CreationCompte.php"><button class="Button">Créer un compte</button></a></p>
    </body>
</html>