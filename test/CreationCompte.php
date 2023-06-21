<?php
require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Creation de compte</title>
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

        <h2>Créer un compte</h2>

        <form action="confirmation_inscription.php" method="POST">
            <label for="nom_user">Nom</label>
            <input type="text" class="Button" name="nom_user" required /><br>

            <label for="pseudo_user">Pseudo</label>
            <input type="text" class="Button" name="pseudo_user" required /><br>

            <label for="prenom_user">Prénom</label>
            <input type="text" class="Button"  name="prenom_user" required /><br>

            <label for="tel_user">Téléphone</label>
            <input type="tel" class="Button" name="tel_user" required /><br>

            <label for="mail_user">Email</label>
            <input type="email" class="Button" name="mail_user" required /><br>

            <label for="password_user">Mot de passe</label>
            <input type="password" class="Button" name="password_user" required /><br>

            <input type="submit" class="Button" value="S'inscrire" />
        </form>

        <p>Déjà inscrit ?<a href="http://localhost/gastronomix/test/connexion.php"><button class="Button">Se connecter</button></a></p>
    </body>
</html>