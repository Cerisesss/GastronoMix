<?php
require 'Function.php';
session_start();
if (isset($_POST['id_recette'])) {
    $id_recette = $_POST['id_recette'];
    if (isset($_SESSION['pseudo_user'])) {
        $pseudo = $_SESSION['pseudo_user'];
        $mysqli = ConnectionDatabase();
        $id_user = $mysqli->query("SELECT id_user FROM user WHERE pseudo_user = '$pseudo'")->fetch_assoc()['id_user'];
        $query = "DELETE FROM favoris WHERE id_user = '$id_user' AND id_recette = '$id_recette'";
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
