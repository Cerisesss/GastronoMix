<?php
require 'Function.php';
session_start();

if (isset($_POST['id_recette'])) {
    $id_recette = $_POST['id_recette'];
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $mysqli = ConnectionDatabase();
        $query = "DELETE FROM favoris WHERE id_user = '$user_id' AND id_recette = '$id_recette'";
        $result = $mysqli->query($query);

        if ($result) {
            echo "success";
        } else {
            echo "erreur lors de la suppression des favoris";
        }

        $mysqli->close();
    } else {
        echo "utilisateur non connecte";
    }
} else {
    echo "id recette manquant";
}
?>
