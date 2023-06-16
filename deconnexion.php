<?php
session_start(); // Démarrage de la session

// Supprimer toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou une autre page de votre choix
header("Location: connexion.php");
exit();
?>
