<?php
require 'Function.php';
session_start();
//cette condition verifie si la requete est de type post et si l'id de la recette est bien present
if (isset($_POST['id_recette'])) {
    $id_recette = $_POST['id_recette'];
    //on verifie si l'utilisateur est connecte et on recupere son id a partir de son pseudo
    if (isset($_SESSION['pseudo_user'])) {
        $pseudo = $_SESSION['pseudo_user'];
        $mysqli = ConnectionDatabase();
        $id_user = $mysqli->query("SELECT id_user FROM user WHERE pseudo_user = '$pseudo'")->fetch_assoc()['id_user'];
        //une requete pour supprimer la recette des favoris 
        $query = "DELETE FROM favoris WHERE id_user = '$id_user' AND id_recette = '$id_recette'";
        //la requette est executee et stockee dans la variable result
        $result = $mysqli->query($query);
        //si la requete est bien executee on affiche success sinon on affiche une erreur
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
