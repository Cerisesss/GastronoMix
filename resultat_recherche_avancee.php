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
        <title>Resultat recherche avancée</title>
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

        <center>
            <h2>Résultat(s)</h2>
        </center>
            <div class="container">
                <?php
                    $mysqli = ConnectionDatabase();

                    // Récupérer les mots associés à "aliments_ok", "aliments_ko" et "categorie"
                    if (!empty($_GET['aliments_ok']) || !empty($_GET['aliments_ko']) || !empty($_GET['categorie'])) {
                    
                        // Regarde si les variables existent et si elles ne sont pas vides
                        if (!empty($_GET['aliments_ok'])) {
                            $aliments_ok = $_GET['aliments_ok'];
                        } else {
                            $aliments_ok = [];
                        }
                        if (!empty($_GET['aliments_ko'])) {
                            $aliments_ko = $_GET['aliments_ko'];
                        } else {
                            $aliments_ko = [];
                        }
                        if (!empty($_GET['categorie'])) {
                            $categorie = $_GET['categorie'];
                        } else {
                            $categorie = "";
                        }
                    
                        $aliments_ok_string = implode(",", $aliments_ok);
                        $aliments_ko_string = implode(",", $aliments_ko);
                        
                        // Requête SQL pour récupérer les recettes correspondantes
                        $sql = "SELECT DISTINCT r.titre, r.image_recette, c.libelle_categorie
                                FROM recette r
                                JOIN quantite q ON q.id_recette = r.id_recette
                                JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                                JOIN categorie c ON c.id_categorie = r.id_categorie
                                WHERE ";
                        
                        // Si les deux tableaux ne sont pas vides, on ajoute les deux conditions
                        if (!empty($aliments_ok) && !empty($aliments_ko)) {
                            $sql .= "FIND_IN_SET(TRIM(i.ingredients_recherche), '$aliments_ok_string') > 0 AND
                                    NOT EXISTS (
                                        SELECT 1
                                        FROM quantite q2
                                        JOIN ingredient i2 ON i2.id_ingredient = q2.id_ingredient
                                        WHERE q2.id_recette = r.id_recette
                                        AND FIND_IN_SET(TRIM(i2.ingredients_recherche), '$aliments_ko_string') > 0
                                    )";
                        } else if (!empty($aliments_ok) && empty($aliments_ko)) {
                            $sql .= "FIND_IN_SET(TRIM(i.ingredients_recherche), '$aliments_ok_string') > 0";
                        } else if (empty($aliments_ok) && !empty($aliments_ko)) {
                            $sql .= "NOT EXISTS (
                                        SELECT 1
                                        FROM quantite q2
                                        JOIN ingredient i2 ON i2.id_ingredient = q2.id_ingredient
                                        WHERE q2.id_recette = r.id_recette
                                        AND FIND_IN_SET(TRIM(i2.ingredients_recherche), '$aliments_ko_string') > 0
                                    )";
                        } else {
                            // Aucun filtre sur les aliments
                            $sql .= "1";
                        }
                    
                        // Ajouter la condition sur la catégorie si la personne n'a pas spécifié de catégorie spécifique
                        if ($categorie == 'null') {
                            $categories = ["entree", "plat", "dessert", "boisson"];
                            $categorie_condition = "c.libelle_categorie IN ('" . implode("', '", $categories) . "')";
                        } else {
                            $categorie_condition = "c.libelle_categorie = '$categorie'";
                        }
                    
                        $sql .= " AND $categorie_condition";
                    
                        // Exécution de la requête SQL
                        $result = $mysqli->query($sql);

                        // Utilisez le résultat de la requête pour afficher les données
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if (isset($_SESSION['pseudo_user'])) {
                                    $titre = $row['titre'];
                                    $newtitre = str_replace("'", "_", $titre);
                                    echo '<div class="recette zoom">';
                                    // Image cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($newtitre) . '">';
                                    echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                    echo '</a>';
                                    echo '<div class="nom-recette">';
                                    // Titre cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($newtitre) . '">' . $titre . '</a>';
                                    echo '</a>';
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    $titre = $row['titre'];
                                    $newtitre = str_replace("'", "_", $titre);
                                    echo '<div class="recette zoom">';
                                    // Image cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($newtitre) . '">';
                                    echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                    echo '</a>';
                                    echo '<div class="nom-recette">';
                                    // Titre cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($newtitre) . '">' . $titre . '</a>';
                                    echo '</a>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        } else {
                            echo "Aucune recette trouvée.";
                        }
                    }

                //resultat barre de recherche lorsu'un utilisateur est connecté
                if (isset($_GET['recherche'])) {
                    $mot_clef = $_GET['recherche'];
    
                    $query_recherche = "SELECT titre, image_recette
                            FROM recette 
                            WHERE titre LIKE '%$mot_clef%';";

                    $result_recherche = $mysqli->query($query_recherche);

                    if ($result_recherche->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result_recherche)) {
                            if (isset($_SESSION['pseudo_user'])) {
                                echo '<div class="recette zoom">';
                                // Image cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($row['titre']) . '">';
                                echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                echo '</a>';
                                echo '<div class="nom-recette">';
                                // Titre cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($row['titre']) . '">';
                                echo $row['titre'];
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo '<div class="recette zoom">';
                                // Image cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($row['titre']) . '">';
                                echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                echo '</a>';
                                echo '<div class="nom-recette">';
                                // Titre cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($row['titre']) . '">';
                                echo $row['titre'];
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo "Aucune recette trouvée.";
                    }
                }
            ?>
        </div>
    </body>
</html>