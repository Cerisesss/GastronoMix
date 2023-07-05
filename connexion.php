<?php
    require 'Function.php';
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Connexion</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <?php 
            MenuDeroulantDeconnecter();
            RechercheAvancee();
        ?>

        <h1>GastronoMix</h1>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h2>Connexion</h2>

        <br>

        <?php
            $mysqli = ConnectionDatabase();

            if (isset($_GET['error'])) {
                if ($_GET['error'] == "connexion") {
                    echo "<p>Nom d'utilisateur ou mot de passe incorrect.</p>";
                }
            }
        


            $mysqli->close();
        ?>


        <form action="verification_connexion.php" method="post">
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