<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gastronomix";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Requête pour récupérer tous les libellés de la table "categorie"
$sql = "SELECT libelle_categorie FROM categorie";
$result = $conn->query($sql);

// Vérifier si la requête a renvoyé des résultats
if ($result->num_rows > 0) {
    // Créer le menu déroulant
    echo '<select name="categorie">';
    while ($row = $result->fetch_assoc()) {
        $libelle = $row["libelle_categorie"];
        echo '<option value="' . $libelle . '">' . $libelle . '</option>';
    }
    echo '</select>';
} else {
    echo "Aucun libellé trouvé dans la table.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
