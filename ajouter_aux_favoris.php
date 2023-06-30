<?php
require_once 'Function.php';
session_start();
//la conditions verifier si la requete est de type post 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_recette = $_POST['id_recette'];
    if (isset($_SESSION['pseudo_user'])) {
        $pseudo = $_SESSION['pseudo_user'];
    
    $mysqli = ConnectionDatabase();
    //recuperer l'id de l'utilisateur
    $id_user = $mysqli->query("SELECT id_user FROM user WHERE pseudo_user = '$pseudo'")->fetch_assoc()['id_user'];
echo'$id_user';
    //verifier si la recette est deja dans les favoris on ne l'ajoute pas
    if($mysqli->query("SELECT * FROM favoris WHERE id_recette = '$id_recette' AND id_user = '$id_user'")->num_rows > 0){
       echo "recette deja dans les favoris";
    }
    //sinon on l'ajoute
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
}