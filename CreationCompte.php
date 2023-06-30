<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Creation de compte</title>
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

        <h2>Création du compte</h2>

        <br>

        <?php
           $mysqli = ConnectionDatabase();

           if (isset($_GET['error'])) {
                if ($_GET['error'] == "createPseudo") {
                    echo "Pseudo déjà existant. ";
                } else if ($_GET['error'] == "createMail") {
                    echo "Mail déjà existant. ";
                }
           }
           $mysqli->close();
        ?>

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

        <p>Déjà inscrit ?<a href="http://localhost/gastronomix/connexion.php"><button class="Button">Se connecter</button></a></p>
    </body>
</html>