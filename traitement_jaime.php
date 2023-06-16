<?php
    // Assurez-vous que l'utilisateur est connecté
    if (estConnecte()) {
        $id_recette = $_POST['id_recette'];
        $id_user = $_SESSION['id_user']; // L'ID de l'utilisateur connecté

        // Vérifiez si l'utilisateur a déjà aimé cette recette
        $query = "SELECT * FROM historique WHERE id_user = $id_user AND id_recette = $id_recette";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            // L'utilisateur a déjà aimé cette recette, vous pouvez ajouter une logique pour retirer son like
            $query = "DELETE FROM historique WHERE id_user = $id_user AND id_recette = $id_recette";
            $mysqli->query($query);
        } else {
            // L'utilisateur n'a pas encore aimé cette recette, vous pouvez ajouter une logique pour enregistrer son like
            $query = "INSERT INTO historique (id_user, id_recette) VALUES ($id_user, $id_recette)";
            $mysqli->query($query);
        }

        // Effectuez toute autre logique nécessaire, par exemple, mettre à jour le compteur de likes

        // Redirigez l'utilisateur vers la page de recette après le traitement
        header("Location: recette.php?id=$recette_id");
        exit();
    } else {
        // Si l'utilisateur n'est pas connecté, vous pouvez ajouter une logique pour le rediriger vers la page de connexion
        header("Location: connexion.php");
        exit();
    }
?>
