<?php
    require 'Function.php';
    session_start();

    if (isset($_GET['pseudo'])) {
        $pseudo = $_GET['pseudo'];
        $_SESSION['pseudo_user'] = $pseudo;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GastronoMix</title>
        <link rel="stylesheet" type="text/css" href="style.css">
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

            $categorie = ["Entrée", "Plat", "Dessert", "Boisson"];

            for ($i = 0; $i < count($categorie); $i++) {
                $categorie_actuelle = $categorie[$i];
                
                echo '<div class="recette-categorie">';
                echo '<br>';
                echo '<br>';
                echo '<h2>' . $categorie_actuelle . '</h2>';
                echo '<br>';
                echo '<br>';
                echo '<div class="container-accueil">';
                

                $rand = rand(1, 160);

                $query = "SELECT r.image_recette, r.difficulte, r.titre, r.id_recette, h.avis_historique
                                FROM recette r
                                LEFT JOIN historique h ON h.id_recette = r.id_recette
                                WHERE categorie_recette = '$categorie_actuelle'
                                ORDER BY RAND('$rand')
                                LIMIT 6";

                $result = $mysqli->query($query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $image_recette = $row["image_recette"];
                    $titre = $row['titre'];
                    $id_recette = $row['id_recette'];
                    $newtitre = str_replace("'", "_", $titre);
                    $avis_historique = $row['avis_historique'];
                    $difficulte = $row['difficulte'];

                    // Affichage du bouton d'ajout aux favoris
                    if (isset($_SESSION['pseudo_user'])) {
                        echo '<div class="recette zoom">';
                        echo '<div style="position: relative;">';
                        //afficher la difficulté de la recette sur l'image
                        echo '<button id="difficulte" class="Button" style="position: absolute; top: 10px; left: 10px; width: 30px; height: 30px; font-size: 15px;">' . $difficulte . '</button>';
                        
                        //affiche l'historique si un utilisateur a déjà noté la recette
                        if($avis_historique === null) {
                            echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">';
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                            echo "</a>";
                        } else {
                            echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">';
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                            echo "</a>";
                            echo '<button id="avis" class="Button" style="position: relative; bottom: 55px; left: 20%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $avis_historique . '/5</button>';
                            // echo '<button id="avis" class="Button" style="position: absolute; bottom: 10px; left: 10px; width: 50px; height: 30px; font-size: 15px;">' . $avis_historique . '/5</button>';
                        }
                        
                        echo '<button id="ajouter-favoris-button-' . $id_recette . '" style="position: absolute; top: 10px; right: 10px; width: 30px; height: 30px; font-size: 15px;" class="Button" onclick="ajouterAuxFavoris(' . $id_recette . ', \'ajouter-favoris-button-' . $id_recette . '\')">&#x2661;</button>';
                        
                        echo '<div class="nom-recette">';
                        // Titre cliquable
                        echo "<a href=\"recette.php?pseudo=$pseudo&recherche=$newtitre\">$titre</a><br>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        
                    } else {
                        echo '<div class="recette zoom">';
                        // Image cliquable
                        echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $newtitre . '">';
                        echo '<img src="' . $image_recette . '" alt="Image de la recette">';                       
                        echo "</a>";
                        echo '<div class="nom-recette">';
                        // Titre cliquable
                        echo "<a href=\"recette.php?recherche=$newtitre\">$titre</a><br>";
                        echo '</div>';
                        echo '</div>';
                    }

                }
                echo '</div>';
                echo '</div>';
            }
            $mysqli->close();
        ?>
<script>
    
            function ajouterAuxFavoris(id_recette, buttonId) {
    var button = document.getElementById(buttonId);
    button.classList.add('red-heart');

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
            //conserve la couleur du coeur si la recette est déjà dans les favoris
            function conserveCouleur(id_recette, buttonId) {
                var button = document.getElementById(buttonId);
                button.classList.add('red-heart');
            }
            
        </script>
    </body>
</html>
