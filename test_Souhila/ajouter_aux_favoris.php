<?php
require_once 'Function.php';
session_start();

print_r("fav");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_recette = $_POST['id_recette'];
    $id_user = $_SESSION['id'];

    $mysqli = ConnectionDatabase();
    //verifier si la recette est deja dans les favoris on ne l'ajoute pas
    if($mysqli->query("SELECT * FROM favoris WHERE id_recette = '$id_recette' AND id_user = '$id_user'")->num_rows > 0){
       echo "recette deja dans les favoris";
    }
    else{
        $query = "INSERT INTO favoris (id_recette, id_user) VALUES ('$id_recette', '$id_user')";

        if ($mysqli->query($query)) {
        http_response_code(200); 
        exit();
    } else {
        http_response_code(500); 
        exit();
    }
    }
    
}
