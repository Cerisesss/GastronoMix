<!DOCTYPE html>
<html>
<head>
    <title>plats</title>
</head>
<body>
<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "GastronoMix";

function connection_database($host, $user, $password, $database) {
    echo "\n Bonjour MySql DATABASE \n";
  
    try {
     
        $conn = mysqli_connect($host, $user, $password, $database);
    }
    catch (Exception $e) {
        echo '<p>Erreur de Connexion au SGBD = '.$database;
        echo "\n -ERROR-ERROR-ERROR " . $e;
        die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error); 
        exit();
    }
    


    return ($conn);
}
$conn = connection_database($host, $user, $password, $database);

function close_database($conn) {
  
    $status = mysqli_close($conn);
   
}
close_database($conn);
?>
    <h1>plats</h1>
    <a href=".."><img src="images/2.jpg" alt="jeux"/>
<br />
<span>recette1</span>
</a>
<a href="..">  <img  src="images/5.jpg" alt="jeux"/>
<br />
<span>recette2s</span>
</a>
</body>
</html>



