<?php
require_once 'Function.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_recette = $_POST['id_recette'];
    
    // Effectuez ici les opérations nécessaires pour ajouter la recette aux favoris dans la base de données
    // Par exemple, vous pouvez exécuter une requête SQL pour insérer les données dans une table "favoris"

    // Connectez-vous à la base de données
    $mysqli = ConnectionDatabase();
    
    // Assurez-vous de valider et d'échapper les données avant de les utiliser dans une requête SQL pour éviter les injections SQL
    
    // Exemple de requête SQL d'insertion
    $query = "INSERT INTO favoris (id_recette) VALUES ('$id_recette')";
    
    // Exécutez la requête
    if ($mysqli->query($query)) {
        // La recette a été ajoutée aux favoris avec succès
        http_response_code(200); // Réponse HTTP 200 pour indiquer le succès
        exit();
    } else {
        // Une erreur s'est produite lors de l'ajout aux favoris
        http_response_code(500); // Réponse HTTP 500 pour indiquer une erreur interne du serveur
        exit();
    }
}
?>