<?php
require 'Function.php';
session_start();

if (isset($_SESSION['pseudo_user'])) {
    $pseudo = $_SESSION['pseudo_user'];

    $mysqli = ConnectionDatabase();

    // Récupérer les avis de l'utilisateur pour une recette donnée
    $query = "SELECT h.id_recette, r.titre, r.image_recette, h.avis_historique
                FROM historique h
                JOIN recette r ON r.id_recette = h.id_recette
                JOIN user u ON u.id_user = h.id_user
                WHERE u.pseudo_user = '$pseudo';";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id_recette = $row['id_recette'];
            $titre = $row['titre'];
            $image_recette = $row['image_recette'];
            $avis_historique = $row['avis_historique'];

            echo '<div class="recette zoom">';
            // Image cliquable
            echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">';
            echo '<img src="' . $image_recette . '" alt="Image de la recette"><br>';
            echo '</a>';
            echo '<div class="nom-recette">';
            // Titre cliquable
            echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $titre . '">' . $titre . '</a><br>';
            // Afficher l'avis de l'utilisateur
            echo 'Avis : ' . $avis_historique . '/5';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>Aucun avis trouvé dans l'historique.</p>";
    }

    $mysqli->close();
} else {
    echo "<p>Veuillez vous connecter pour accéder à votre historique d'avis.</p>";
}
?>
