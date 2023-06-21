<?php
    require 'Function.php';

    $mysqli = ConnectionDatabase();

    // Récupérer les données du formulaire
    $pseudo_user = $_POST['pseudo_user'];
    $mail_user = $_POST['mail_user'];
    $password_user = $_POST['password_user'];

    // Effectuer les validations nécessaires

    // Requête pour vérifier les informations de connexion dans la base de données
    $query = "SELECT * FROM user WHERE mail_user = '$mail_user' AND password_user = '$password_user'";
    $result_query = $mysqli->query($query);

    $pseudo_user = $result_query->fetch_assoc();
    
    if ($result_query->num_rows > 0) {
        $pseudo_user = $pseudo_user['pseudo_user'];

        header("Location: Accueil.php?pseudo=$pseudo_user");
        exit("Connexion réussie.");

        echo "<p>Connexion réussie.</p>";
    } else {
        header("Location: connexion.php?pseudo=$pseudo_user");
        exit("Nom d'utilisateur ou mot de passe incorrect.");

        echo "<p>Nom d'utilisateur ou mot de passe incorrect.</p>";
    }

    $mysqli->close();
?>