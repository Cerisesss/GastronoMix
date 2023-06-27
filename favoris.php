<?php
require 'Function.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>GastronoMix</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="Function.js"></script>
    <script>
        
    function retirerDesFavoris(idRecette) {
    var formData = new FormData();
    formData.append('id_recette', idRecette);

    fetch('retirer_des_favoris.php', {
        method: 'POST',
        body: formData
    })
    .then(function(response) {
        if (response.ok) {
            // La recette a été retirée des favoris avec succès
            alert("La recette a été retirée des favoris !");
            // Effectuer d'autres actions si nécessaire, comme mettre à jour l'interface utilisateur.
        } else {
            // Une erreur s'est produite lors de la suppression des favoris
            alert("Erreur lors du retrait des favoris.");
        }
    })
    .catch(function(error) {
        // Une erreur s'est produite lors de la requête AJAX
        alert("Une erreur s'est produite lors de la requête AJAX.");
    });
}
    

</script>
    
</head>
<body>


<div id="header">
    <button id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

    <div id="menu">
        <ul>
            <h2>Menu</h2>
            <li><a href="http://localhost/gastronomix/Accueil.php">🍽️ Accueil</a></li>
            <li><a href="http://localhost/gastronomix/entree.php">🍽️ Entrée</a></li>
            <li><a href="http://localhost/gastronomix/plat.php">🍽️ Plat</a></li>
            <li><a href="http://localhost/gastronomix/dessert.php">🍽️ Dessert</a></li>
            <li><a href="http://localhost/gastronomix/boisson.php">🍽️ Boisson</a></li>
        </ul>
    </div>

    <div id="Rechercher">
        <form action="recette.php" method="GET">
            <input id="RechercherBarre" type="text" name="recherche" value="">
            <button id="RechercherButton" class="Button" type="submit">🔍</button>
        </form>

        <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
    </div>

    <br><br>

    <h1>Résultat</h1> 

    <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

<?php
$mysqli = ConnectionDatabase();

// Vérifier si l'utilisateur est connecté

if (isset($_SESSION['pseudo_user'])) {
    $pseudo = $_SESSION['pseudo_user'];
    $id_user = $mysqli->query("SELECT id_user FROM user WHERE pseudo_user = '$pseudo'")->fetch_assoc()['id_user'];
    $query = "SELECT r.id_recette, r.image_recette, r.titre
    FROM recette AS r
    INNER JOIN favoris AS f ON r.id_recette = f.id_recette
    WHERE f.id_user = '$id_user'";

    $result = $mysqli->query($query);

    $recettes_favorites = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id_recette = $row['id_recette'];
        $image_recette = $row["image_recette"];
        $titre = $row['titre'];
        

        $recette = array(
            'image_recette' => $image_recette,
            'titre' => $titre,
            'id_recette' => $id_recette
        );

        $recettes_favorites[] = $recette;
    }

    if (!empty($recettes_favorites)) {
        foreach ($recettes_favorites as $recette) {
            echo '<div class="recette zoom">';
                    // Image cliquable
                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">';
                    echo '<img src="' . $image_recette . '" alt="Image de la recette"><br>';
                    echo '</a>';
                    echo '<div class="nom-recette">';
                    echo '<button onclick="retirerDesFavoris(' . $recette['id_recette'] . ')">Retirer des favoris</button>';

                    // Titre cliquable
                    echo  '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">' . $titre . '</a>' . '<br>';
                    echo '</div>';
                    echo '</div>';
      
        }

    } else {
        echo 'Aucune recette favorite trouvée.';
    }
} else {
    echo 'Veuillez vous connecter pour voir vos recettes favorites.';
}

$mysqli->close();

?>

<h2>Recettes favorites</h2>

</body>
</html>
