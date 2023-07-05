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
        <title>Liste des catégories</title>
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

            if (isset($_GET['categorie'])) {
                $categorie = $_GET['categorie'];
            }

           
            $queryCount = "SELECT COUNT(*) AS count FROM recette WHERE categorie_recette = '$categorie'";
            $resultCount = $mysqli->query($queryCount);
    
            if ($resultCount !== false && $resultCount->num_rows > 0) {
                $row = $resultCount->fetch_assoc();
                $count = $row['count'];
              

                echo '<h2>'.$count .' '. $categorie .'s'. '</h2>';
            }
            
            echo '<div class="container">';
            $query = "SELECT r.id_recette, r.difficulte, r.titre, r.image_recette, h.avis_historique
                    FROM recette r
                    JOIN categorie c ON c.id_categorie = r.id_categorie
                    LEFT JOIN historique h ON h.id_recette = r.id_recette
                    WHERE c.libelle_categorie = '$categorie'
                    ORDER BY r.titre ASC";
            
            $result = $mysqli->query($query);
            
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $titre = $row['titre'];
                    $id_recette = $row['id_recette'];
                    $image_recette = $row['image_recette'];
                    $newtitre = str_replace("'", "_", $titre);
                    $avis_historique = $row['avis_historique'];
                    $difficulte = $row['difficulte'];

                    if (isset($_SESSION['pseudo_user'])) {
                        echo '<div class="recette zoom">';
                        echo '<button id="difficulte" class="Button" style="position: relative; top : -3% ; right: -30%; width: 30px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $difficulte . '</button>';

                        // Image cliquable
                        //affiche l'historique si un utilisateur a déjà noté la recette
                        if($avis_historique === null) {
                            echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">';
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                            echo "</a>";
                        } else {
                            echo '<div style="position: relative; display: inline-block;">';
                            echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">';
                            
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                            echo "</a>";
                            echo '<button id="avis" class="Button" style="position: relative; bottom: 55px; left: 26%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $avis_historique . '/5</button>';
                            echo '</div>';
                        }
                       
                        echo '<button id="ajouter-favoris-button-' . $id_recette . '"style="position: relative; top : -70% ; left: -48%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);" class="Button" onclick="ajouterAuxFavoris(' . $id_recette . ', \'ajouter-favoris-button-' . $id_recette . '\')">&#x2661;</button>';
                        
                        echo '<div class="nom-recette">';
                        // Titre cliquable
                        echo "<a href=\"recette.php?pseudo=$pseudo&recherche=$newtitre\">$titre</a><br>";
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
            } else {
                echo "Aucune entrée trouvée.";
            }
            echo '</div>';
            $mysqli->close();
        ?>
    </body>
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
</html>
