<?php
    function ConnectionDatabase() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "gastronomix"; 
        
        try {
            $mysqli = new mysqli($host, $user, $password, $database);
            return $mysqli;
            //$mysqli = mysqli_connect($host, $user, $password, $database);
            //echo "Connexion à la base de données : " . $database . " réussie. </br></br>";
        }
        catch (Exception $e) {
            echo '<p>Erreur de Connexion au SGBD = '.$database;
            echo "\n -ERROR-ERROR-ERROR " . $e;
            die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error); 
            exit();
        }
    }


?>
<?php

function ajouterFavori($id_user, $id_recette) {
    // Connectez-vous à votre base de données
    $mysqli = ConnectionDatabase();

    // Vérifiez d'abord si la recette n'est pas déjà dans les favoris de l'utilisateur
    $query = "SELECT * FROM favoris WHERE id_user = '$id_user' AND id_recette = '$id_recette'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        // La recette est déjà dans les favoris de l'utilisateur, vous pouvez afficher un message d'erreur ou effectuer une action appropriée
        echo "La recette est déjà dans vos favoris.";
    } else {
        // La recette n'est pas encore dans les favoris, vous pouvez l'ajouter
        $query = "INSERT INTO favoris (id_user, id_recette) VALUES ('$id_user', '$id_recette')";
        $mysqli->query($query);

        // Affichez un message de succès ou effectuez une action appropriée
        echo "La recette a été ajoutée aux favoris.";
    }

    // Fermez la connexion à la base de données
    $mysqli->close();
}

?>
