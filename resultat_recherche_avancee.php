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
                        $sql = "SELECT DISTINCT r.titre, r.image_recette, r.temps_total_recette, r.difficulte, c.libelle_categorie
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
                            echo '<div class="container">';
                            while ($row = $result->fetch_assoc()) {
                                $titre = $row['titre'];
                                $newtitre = str_replace("'", "_", $titre);
                                $difficulte = $row['difficulte'];
                                $temps_total_recette = $row['temps_total_recette'];

                                //calcul du temps total en format 00:00
                                $temps_total = $row['temps_total_recette'];
            
                                $heures_total = floor($temps_total / 60);
                                $minutes_total = $temps_total % 60;
                                $temps_total_recette = sprintf('%02d:%02d', $heures_total, $minutes_total);

                                if (isset($_SESSION['pseudo_user'])) {
                                    echo '<div class="recette zoom">';

                                    echo '<div style="position: relative;">';
                                    //afficher la difficulté de la recette sur l'image
                                    echo '<button id="difficulte" class="Button" style="position: absolute; top: 10px; left: 10px; width: 30px; height: 30px; font-size: 15px;">' . $difficulte . '</button>';
                                    
                                    // Image cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($newtitre) . '">';
                                    echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                    echo '</a>';
                                    echo '<div class="nom-recette">';
                                    
                                    // Titre cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($newtitre) . '">' . $titre . '</a>';
                                    echo '</a>';
                                    
                                    // Affichage du temps total de la recette
                                    echo '<div id="temps-total-wrapper">';
                                    echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                } else {

                                    echo '<div class="recette zoom">';

                                    // Image cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($newtitre) . '">';
                                    echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                    echo '</a>';
                                    echo '<div class="nom-recette">';

                                    // Titre cliquable
                                    echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($newtitre) . '">' . $titre . '</a>';
                                    echo '</a>';

                                    // Affichage du temps total de la recette
                                    echo '<div id="temps-total-wrapper">';
                                    echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                    echo '</div>';

                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            echo '</div>';
                        } else {
                            echo "Aucune recette trouvée.<br>";

                            echo "<h2>Quelques suggestions :</h2><br><br>";
                
                                $rand = rand(1, 160);
                
                                $query = "SELECT r.image_recette, r.difficulte, r.temps_total_recette, r.titre, r.id_recette, h.avis_historique
                                                FROM recette r
                                                LEFT JOIN historique h ON h.id_recette = r.id_recette
                                                ORDER BY RAND('$rand')
                                                LIMIT 6";
                
                                $result = $mysqli->query($query);
                
                                echo '<div class="container">';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $image_recette = $row["image_recette"];
                                    $titre = $row['titre'];
                                    $id_recette = $row['id_recette'];
                                    $newtitre = str_replace("'", "_", $titre);
                                    $avis_historique = $row['avis_historique'];
                                    $difficulte = $row['difficulte'];
                                    $temps_total_recette = $row['temps_total_recette'];
                
                                    //calcul du temps total en format 00:00
                                    $temps_total = $row['temps_total_recette'];
                
                                    $heures_total = floor($temps_total / 60);
                                    $minutes_total = $temps_total % 60;
                                    $temps_total_recette = sprintf('%02d:%02d', $heures_total, $minutes_total);
                
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
                                        // Affichage du temps total de la recette
                                        echo '<div id="temps-total-wrapper">';
                                        echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                        echo '</div>';
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
                                       // Affichage du temps total de la recette
                                        echo '<div id="temps-total-wrapper">';
                                        echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                        echo '</div>';
                                       // echo '<button id="" class="Button" style="position: relative; bottom: 45px; left: 20%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $temps_total_recette . '</button>';
                
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    

                // resultat barre de recherche lorsqu'un utilisateur est connecté
                if (isset($_GET['recherche'])) {
                    $mot_clef = $_GET['recherche'];
    
                    $query_recherche = "SELECT titre, image_recette, difficulte, temps_total_recette
                            FROM recette 
                            WHERE titre LIKE '%$mot_clef%';";

                    $result_recherche = $mysqli->query($query_recherche);

                    if ($result_recherche->num_rows > 0) {
                        echo '<div class="container">';
                        while ($row = mysqli_fetch_assoc($result_recherche)) {
                            $difficulte = $row['difficulte'];
                            $temps_total_recette = $row['temps_total_recette'];
        
                            //calcul du temps total en format 00:00
                            $temps_total = $row['temps_total_recette'];
        
                            $heures_total = floor($temps_total / 60);
                            $minutes_total = $temps_total % 60;
                            $temps_total_recette = sprintf('%02d:%02d', $heures_total, $minutes_total);

                            if (isset($_SESSION['pseudo_user'])) {
                                echo '<div class="recette zoom">';
                                echo '<div style="position: relative;">';
                                
                                //afficher la difficulté de la recette sur l'image
                                echo '<button id="difficulte" class="Button" style="position: absolute; top: 10px; left: 10px; width: 30px; height: 30px; font-size: 15px;">' . $difficulte . '</button>';
                        
                                // Image cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($row['titre']) . '">';
                                echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                echo '</a>';
                                echo '<div class="nom-recette">';
                                
                                // Titre cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . urlencode($row['titre']) . '">';
                                echo $row['titre'];
                                echo '</a>';

                                // Affichage du temps total de la recette
                                echo '<div id="temps-total-wrapper">';
                                echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                echo '</div>';

                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo '<div class="recette zoom">';
                                echo '<div style="position: relative;">';
                                
                                //afficher la difficulté de la recette sur l'image
                                echo '<button id="difficulte" class="Button" style="position: absolute; top: 10px; left: 10px; width: 30px; height: 30px; font-size: 15px;">' . $difficulte . '</button>';
                                
                                // Image cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($row['titre']) . '">';
                                echo '<img src="' . $row['image_recette'] . '" alt="Recette">';
                                echo '</a>';
                                echo '<div class="nom-recette">';
                                
                                // Titre cliquable
                                echo '<a href="http://localhost/gastronomix/recette.php?recherche=' . urlencode($row['titre']) . '">';
                                echo $row['titre'];
                                echo '</a>';

                                // Affichage du temps total de la recette
                                echo '<div id="temps-total-wrapper">';
                                echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    } else {
                        echo "Aucune recette trouvée.<br>";

                        echo "<h2>Quelques suggestions :</h2><br><br>";
            
                        $rand = rand(1, 160);
        
                        $query = "SELECT r.image_recette, r.difficulte, r.temps_total_recette, r.titre, r.id_recette, h.avis_historique
                                        FROM recette r
                                        LEFT JOIN historique h ON h.id_recette = r.id_recette
                                        ORDER BY RAND('$rand')
                                        LIMIT 6";
        
                        $result = $mysqli->query($query);
        
                        echo '<div class="container">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image_recette = $row["image_recette"];
                            $titre = $row['titre'];
                            $id_recette = $row['id_recette'];
                            $newtitre = str_replace("'", "_", $titre);
                            $avis_historique = $row['avis_historique'];
                            $difficulte = $row['difficulte'];
                            $temps_total_recette = $row['temps_total_recette'];
        
                            //calcul du temps total en format 00:00
                            $temps_total = $row['temps_total_recette'];
        
                            $heures_total = floor($temps_total / 60);
                            $minutes_total = $temps_total % 60;
                            $temps_total_recette = sprintf('%02d:%02d', $heures_total, $minutes_total);
        
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
                                // Affichage du temps total de la recette
                                echo '<div id="temps-total-wrapper">';
                                echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                echo '</div>';
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
                                // Affichage du temps total de la recette
                                echo '<div id="temps-total-wrapper">';
                                echo '<button class="temps-total-button">' . $temps_total_recette .' min'. '</button>';
                                echo '</div>';
                                // echo '<button id="" class="Button" style="position: relative; bottom: 45px; left: 20%; width: 50px; height: -50%; font-size: 15px; transform: translate(50%, 50%);">' . $temps_total_recette . '</button>';
        
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }            
            ?>
        </div>
    </body>
</html>