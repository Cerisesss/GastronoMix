<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
    </head>
    <body>
        <?php
            $password = "";
            $user = "root";
            $host = "localhost"; 
            $database = "gastronomix";

            function connection_database($host, $user, $password, $database) {
                try {
                    $mysqli = mysqli_connect($host, $user, $password, $database);
                } catch (Exception $e) {
                    echo '<p>Erreur de Connexion au SGBD = ' . $database;
                    echo "\n -ERROR-ERROR-ERROR " . $e;
                    die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error); 
                    exit();
                }
                return $mysqli;
            }

            function close_database($mysqli) {
                mysqli_close($mysqli);
            }

            $mysqli = connection_database($host, $user, $password, $database);

            // Effectuer la recherche en fonction des aliments
            $sql = "SELECT nom_ingredient FROM ingredient";
            
            //close_database($mysqli);
        ?>
        <h1>Test</h1>
        <p>
            Aliments : <br>
                <?php
                    // Exécute la requête SQL de recherche des aliments et récupère les résultats
                    $result = $mysqli->query($sql);

                    // Parcour les résultats et les affiche dans la liste déroulante
                    while ($row = $result->fetch_assoc()) {
                        //echo '<option value="' . $row['nom_ingredient'] . '">' . $row['nom_ingredient'] . '</option>';
                        echo '<input type="checkbox" name="aliments[]" value="' . $row['nom_ingredient'] . '">' . $row['nom_ingredient'] . '<br>';
                    }
                ?>
        </p>
        <input type="submit" name="bouton" value="Rechercher">
    </body>
</html>
