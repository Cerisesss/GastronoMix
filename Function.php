<?php
    function ConnectionDatabase() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "GastronoMix"; 
        
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