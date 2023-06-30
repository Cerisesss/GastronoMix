<?php
require 'Function.php';
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <?php 
            MenuDeroulantDeconnecter();
            RechercheAvancee();
        ?>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h1>GastronoMix</h1>

        <h2>Confirmation d'inscription</h2>


        <?php
            $mysqli = ConnectionDatabase();

            // Récupérer les données du formulaire
            $nom_user = $_POST['nom_user'];
            $pseudo_user = $_POST['pseudo_user'];
            $prenom_user = $_POST['prenom_user'];
            $tel_user = $_POST['tel_user'];
            $mail_user = $_POST['mail_user'];
            $password_user = $_POST['password_user'];

            $query_verification_pseudo = "SELECT * FROM user WHERE pseudo_user = '$pseudo_user';";
            $verification_pseudo = $mysqli->query($query_verification_pseudo);

            $query_verification_mail = "SELECT * FROM user WHERE mail_user = '$mail_user';";
            $verification_mail = $mysqli->query($query_verification_mail);

            if($verification_pseudo->num_rows > 0) {
                header("Location: CreationCompte.php?error=createPseudo");
                exit();
            } else if ($verification_mail->num_rows > 0){
                echo "Mail déjà existant. ";
                header("Location: CreationCompte.php?error=createMail");
                exit();
            }else {
                $hashed_password = password_hash($password_user, PASSWORD_DEFAULT);

                // Insert les données dans la table user
                $inscription = $mysqli->prepare("INSERT INTO user(nom_user, pseudo_user, prenom_user, tel_user, mail_user, password_user) VALUES (?, ?, ?, ?, ?, ?)");

                //"s" pour une chaîne de caractères
                $inscription->bind_param("ssssss", $nom_user, $pseudo_user, $prenom_user, $tel_user, $mail_user, $hashed_password);

                if ($inscription->execute()) {
                    echo "Inscription réussite.";
                } else {
                    echo "Erreur lors de l'inscription : " . $inscription->error;
                }

                $inscription->close();
                $mysqli->close();
            }
        ?>

        <br>
        <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Se connecter</button></a>
    </body>
</html>
