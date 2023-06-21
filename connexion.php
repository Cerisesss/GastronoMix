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
            
            <?php
                MenuDeroulantDeconnecter();
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

    <h2>Se connecter</h2>

    <?php
        $mysqli = ConnectionDatabase();

        if (isset($_GET['error'])) {
            if ($_GET['error'] == "connexion") {
                echo "<p>Nom d'utilisateur ou mot de passe incorrect.</p>";
            }
        }
        $mysqli->close();
    ?>


    <form action="Verification_connexion.php" method="post">
        <label for="pseudo_user">Pseudo</label>
        <input type="pseudo" class="Button" id="pseudo_user" name="pseudo_user" required /><br>

        <label for="mail_user">Email</label>
        <input type="email" class="Button" id="mail_user" name="mail_user" required /><br>

        <label for="password_user">Mot de passe</label>
        <input type="password" class="Button" id="password_user" name="password_user" required /><br>

        <input type="submit" class="Button" value="Se connecter" />
    </form>

    <p>Nouveau sur notre site ? <a href="http://localhost/gastronomix/CreationCompte.php"><button class="Button">Créer un compte</button></a></p>
</body>

</html>