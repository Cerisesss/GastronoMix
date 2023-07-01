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

                $query = "SELECT r.image_recette, r.titre, r.id_recette, h.avis_historique
                                FROM recette r
                                LEFT JOIN historique h ON h.id_recette = r.id_recette
                                WHERE categorie_recette = '$categorie_actuelle'
                                ORDER BY RAND('$rand')
                                LIMIT 6";

                $result = $mysqli->query($query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $image_recette = $row["image_recette"];
                    $titre = $row['titre'];
                    $newtitre = str_replace("'", "_", $titre);
                    $avis_historique = $row['avis_historique'];

                    // Affichage du bouton d'ajout aux favoris
                    if (isset($_SESSION['pseudo_user'])) {
                        echo '<div class="recette zoom">';
                        // Image cliquable
                        echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">';
                        //affiche l'historique si un utilisateur a déjà noté la recette
                        if($avis_historique === null) {
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                        } else {
                            echo '<div style="position: relative; display: inline-block;">';
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                            echo '<button id="avis" class="Button" style="position: relative; bottom: 55px; left: 26%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $avis_historique . '/5</button>';
                            echo '</div>';
                        }
                        echo '</a>';
                        echo '<div class="nom-recette">';
                        // Titre cliquable
                        echo  '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">' . $titre . '</a>' . '<br>';
                        echo '</div>';
                        echo '</div>';
                    } else {
                        echo '<div class="recette zoom">';
                        // Image cliquable
                        echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . $newtitre . '">';
                        //affiche l'historique si un utilisateur a déjà noté la recette
                        if($avis_historique === null) {
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                        } else {
                            echo '<div style="position: relative; display: inline-block;">';
                            echo '<img src="' . $image_recette . '" alt="Image de la recette">';
                            echo '<button id="avis" class="Button" style="position: relative; bottom: 55px; left: 26%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $avis_historique . '/5</button>';
                            echo '</div>';
                        }
                        echo '</a>';
                        echo '<div class="nom-recette">';
                        // Titre cliquable
                        echo  '<a href="http://localhost/gastronomix/recette.php?recherche=' . $newtitre . '">' . $titre . '</a>' . '<br>';
                        echo '</div>';
                        echo '</div>';
                    }

                }
                echo '</div>';
                echo '</div>';
            }
            $mysqli->close();
        ?>

    </body>
</html>
