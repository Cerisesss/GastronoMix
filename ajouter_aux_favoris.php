<?php
require_once 'Function.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_recette = $_POST['id_recette'];

    $mysqli = ConnectionDatabase();
    $query = "INSERT INTO favoris (id_recette) VALUES ('$id_recette')";
        if ($mysqli->query($query)) {
        http_response_code(200); 
        exit();
    } else {
        http_response_code(500); 
        exit();
    }
}
?>