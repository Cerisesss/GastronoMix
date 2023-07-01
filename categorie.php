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

            echo '<h2>' . $categorie . '</h2>';
            
            echo '<div class="container">';
            $query = "SELECT r.id_recette, r.titre, r.image_recette, h.avis_historique
                    FROM recette r
                    JOIN categorie c ON c.id_categorie = r.id_categorie
                    LEFT JOIN historique h ON h.id_recette = r.id_recette
                    WHERE c.libelle_categorie = '$categorie'
                    ORDER BY r.titre ASC";
            
            $result = $mysqli->query($query);
            
            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $titre = $row['titre'];
                    $image_recette = $row['image_recette'];
                    $newtitre = str_replace("'", "_", $titre);
                    $avis_historique = $row['avis_historique'];

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
                        echo "</a>";
                        echo '<div class="nom-recette">';
                        // Titre cliquable
                        echo "<a href=\"recette.php?pseudo=$pseudo&recherche=$newtitre\">$titre</a><br>";
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
</html>
