<?php
    session_start(); // Démarrage de la session
    $pseudo = $_GET['pseudo'];
    $_SESSION['pseudo_user'] = '$pseudo';

    // Supprimer toutes les variables de session
    $_SESSION = array();

    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion ou une autre page de votre choix
    header("Location: Accueil.php");
    exit();
?>
