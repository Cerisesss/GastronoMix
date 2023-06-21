<?php
require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix</title>
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

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <?php
            $mysqli = ConnectionDatabase();

            // Récupérer les données du formulaire
            $nom_user = $_POST['nom_user'];
            $pseudo_user = $_POST['pseudo_user'];
            $prenom_user = $_POST['prenom_user'];
            $tel_user = $_POST['tel_user'];
            $mail_user = $_POST['mail_user'];
            $password_user = $_POST['password_user'];

            $query = "SELECT pseudo_user FROM user WHERE pseudo_user = '$pseudo_user'";
            $verification = $mysqli->query($query);

            if($verification->num_rows > 0) {
                echo "Pseudo déjà existant. ";
            } else {
                // Insert les données dans la table user
                $inscription = $mysqli->prepare("INSERT INTO user(nom_user, pseudo_user, prenom_user, tel_user, mail_user, password_user) VALUES (?, ?, ?, ?, ?, ?)");
            
                //"s" pour une chaîne de caractères
                $inscription->bind_param("ssssss", $nom_user, $pseudo_user, $prenom_user, $tel_user, $mail_user, $password_user);

                if ($inscription->execute()) {
                    echo "Inscription réussie.";
                } else {
                    echo "Erreur lors de l'inscription : " . $inscription->error;
                }
                $inscription->close();
            }

            $mysqli->close();
        ?>

        <br><br>
        <a href="http://localhost/gastronomix/test/connexion.php"><button class="Button">Se connecter</button></a>
    </body>
</html>
