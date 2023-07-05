<?php
    require 'Function.php';
    session_start();

    if (isset($_GET['pseudo'])) {
        $pseudo = $_GET['pseudo'];
        $_SESSION['pseudo_user'] = $pseudo;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['avis_historique'])) {
        $mysqli = ConnectionDatabase();

        if (isset($_SESSION['pseudo_user'])) {
            $pseudo = $_SESSION['pseudo_user'];
            $id_recette = $_POST['id_recette'];

            $query = "SELECT id_user FROM user WHERE pseudo_user = '$pseudo';";
            //verifier si l'utilisateur a note la recette et mettre la note a jour si on souhaite modifier la note
            $result_user = $mysqli->query($query);
            $row_user = $result_user->fetch_assoc();
            $id_user = $row_user['id_user'];

            $query = "SELECT id_historique FROM historique WHERE id_user = '$id_user' AND id_recette = '$id_recette';";
            $result_historique = $mysqli->query($query);

            if ($result_historique && $result_historique->num_rows > 0) {
                $row_historique = $result_historique->fetch_assoc();
                $id_historique = $row_historique['id_historique'];

                $query = "UPDATE historique SET avis_historique = '" . $_POST['avis_historique'] . "' WHERE id_historique = '$id_historique';";
                $result = $mysqli->query($query);
            } else {
                $query = "INSERT INTO historique (id_user, id_recette, avis_historique) VALUES ('$id_user', '$id_recette', '" . $_POST['avis_historique'] . "');";
                $result = $mysqli->query($query);
            }

        }}

          
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix - <?php if(isset($_GET['recherche'])) echo $_GET['recherche']; ?></title>
        <link rel="stylesheet" type="text/css" href="styler.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <?php
            if (isset($_SESSION['pseudo_user'])) {
                if($_SESSION['pseudo_user'] == "admin" || $_SESSION['pseudo_user'] == "Admin") {
                    MenuDeroulantAdmin($pseudo);
                }else {
                    MenuDeroulantCompte($pseudo);
                }
                
                MenuDeroulantConnecter($pseudo);
                RechercheAvanceeConnecter($pseudo);
            } else {
                MenuDeroulantDeconnecter();
                RechercheAvancee();

                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }
        ?>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h1>GastronoMix</h1>
        
        <?php
            $mysqli = ConnectionDatabase();

            if (isset($_GET['recherche'])) {
                $mot_clef = $_GET['recherche'];

                if (isset($_SESSION['pseudo_user'])) {
                    if($pseudo == "admin" || $pseudo == "Admin") {
                        echo '<form action="Confirmation_Suppression.php?pseudo=' . $pseudo . '&recherche=' . $mot_clef . '" method="POST">';
                        echo '<button id="DeleteButton" class="Button" type="submit">Supprimer cette recette</button>';
                        echo '</form>';
                    }
                }



                $query = "SELECT id_recette, image_recette, titre, source, temps_prep_recette, temps_total_recette, nb_personne, difficulte
                            FROM recette 
                            WHERE titre LIKE '$mot_clef';";

                $result_recette = $mysqli->query($query);

                if ($result_recette && $result_recette->num_rows > 0) {
                    while ($row = $result_recette->fetch_assoc()) {
                        //calcul du temps de préparation en format 00:00
                        $temps_prep = $row['temps_prep_recette'];

                        $heures_prep = floor($temps_prep / 60);
                        $minutes_prep = $temps_prep % 60;
                        $temps_prep_recette = sprintf('%02d:%02d', $heures_prep, $minutes_prep);

                        //calcul du temps total en format 00:00
                        $temps_total = $row['temps_total_recette'];

                        $heures_total = floor($temps_total / 60);
                        $minutes_total = $temps_total % 60;
                        $temps_total_recette = sprintf('%02d:%02d', $heures_total, $minutes_total);


                        $id_recette = $row['id_recette'];
                        echo '<div id="recette-container">';
                        echo '<br>';

                        if (isset($_SESSION['pseudo_user'])) {
                            if($pseudo == "admin" || $pseudo == "Admin") {
                                $newtitre = str_replace("'", "_", $mot_clef);

                                echo '<form action="Modification_Recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '" method="POST">';
                                echo '<button id="UpdateButton" class="Button" type="submit">Modifier cette recette</button>';
                                echo '</form>';
                            }
                        }

                        echo '<img class="recipe-image" src="' . $row['image_recette'] . '" alt="Recette">';
                        echo "<h2>" . $row["titre"] . "</h2></br>";
                        echo "<h4>Source : " . $row['source'] . "</h4>";
                        echo "<p>Temps de préparation : " . $temps_prep_recette . "</p>";
                        echo "<p>Temps total : " . $temps_total_recette . "</p>";
                        echo "<p>Nombre de personne : " . $row['nb_personne'] . "</br>";
                        echo "<p>Difficulté : " . $row['difficulte'] . "</p>";
                    }

                    $query_ingredient = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                                        JOIN quantite q ON q.id_recette = r.id_recette
                                        JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                                        JOIN unite u ON u.id_unite = i.id_unite
                                        WHERE r.titre LIKE '%$mot_clef%';";

                    $result_ingredient = $mysqli->query($query_ingredient);

                    echo "<h3>Ingrédients</h3>";

                    while ($row = $result_ingredient->fetch_assoc()) {
                        if ($row['quantite'] == 0) {
                            $row['quantite'] = "";
                        }

                        echo "<li>" . $row['quantite'] . " " . $row['libelle_unite'] . " " . $row['nom_ingredient'] . "</li>";
                    }

                    $query_etape = "SELECT e.id_etape, e.texte_etape FROM recette r 
                                    JOIN etape e ON e.id_recette = r.id_recette
                                    WHERE r.id_recette = " . $id_recette . ";";

                    $result_etape = $mysqli->query($query_etape);

                    echo "<h3>Étapes</h3>";

                    while ($row = $result_etape->fetch_assoc()) {
                        echo "<li>" . "Etape " . $row['id_etape'] . " : " . $row['texte_etape'] . "</li>";
                    }

                    echo "</br>";

                    
                    if (isset($_SESSION['pseudo_user'])) {
                        echo '<form id="ajouter-favoris-form" onsubmit="ajouterAuxFavoris(' . $id_recette . '); return false;">';
                        echo '<input type="hidden" name="id_recette" value="' . $id_recette . '">';
                        echo '<input type="submit" value="🧡">';
                        echo '</form>';
                        echo '<form id="rating-form" method="POST">';
                        echo '<input type="hidden" name="id_recette" value="' . $id_recette . '">';
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<input type="radio" id="star' . $id_recette . '_' . $i . '" name="avis_historique" value="' . $i . '" style="display: none;">';
                            echo '<label for="star' . $id_recette . '_' . $i . '" onclick="submitForm(' . $i . ')"><span class="star">&#9734;</span></label>';
                        }
                        echo '</form>';
                    }
                    
                } else {
                    echo "<p>Aucun résultat.</p>";
                }
            } else {
                echo "<p>Aucun résultat</p>";
            }

            $mysqli->close();
        ?>

    <script>
        function submitForm(avis) {
            document.getElementById('rating-form').elements['avis_historique'].value = avis;
            document.getElementById('rating-form').submit();
        }

        function ajouterAuxFavoris(id_recette) {
    var form = new FormData();
    form.append('id_recette', id_recette);

    fetch('ajouter_aux_favoris.php', {
        method: 'POST',
        body: form
    })
    .then(function(response) {
        if (response.ok) {
            // Le script PHP a terminé avec succès
            alert("La recette a été ajoutée aux favoris !");
        } else {
            throw new Error("Erreur lors de l'ajout aux favoris.");
        }
    })
    .catch(function(error) {
        // Une erreur s'est produite lors de l'appel à ajouter_aux_favoris.php
        alert(error.message);
    });
}

        </script>
    </body>
</html>