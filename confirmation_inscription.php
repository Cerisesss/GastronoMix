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

                <?php
                    MenuDeroulantDeconnecter();
                ?>
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

            $hashed_password = password_hash($password_user, PASSWORD_DEFAULT);

            // Insert les données dans la table user
            $inscription = $mysqli->prepare("INSERT INTO user(nom_user, pseudo_user, prenom_user, tel_user, mail_user, password_user) VALUES (?, ?, ?, ?, ?, ?)");

            //"s" pour une chaîne de caractères
            $inscription->bind_param("ssssss", $nom_user, $pseudo_user, $prenom_user, $tel_user, $mail_user, $hashed_password);

            if ($inscription->execute()) {
                echo "Inscription réussie.";
            } else {
                echo "Erreur lors de l'inscription : " . $inscription->error;
            }

            $inscription->close();
            $mysqli->close();
        ?>

        <br>
        <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Se connecter</button></a>
    </body>
</html>
