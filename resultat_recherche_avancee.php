<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Resultat recherche avancée</title>
        <link rel="stylesheet" type="text/css" href="new_affichage_recettes.css">
        <script src="Function.js"></script>
    </head>

    <body>
    <button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>
        <div id="menu">
            <ul>
                </br>
                <?php
                    if (isset($_SESSION['pseudo_user'])) {
                        MenuDeroulantConnecter($pseudo);
                    } else {
                        MenuDeroulantDeconnecter();
                    }
                ?>
            </ul>
        </div>

        <div id="Rechercher">
        <a href="http://localhost/gastronomix/recherche_avancee.php"><button id="Recherche_avancee" class="Button"><img src="Images/filtre.png" alt="Image"></button></a>

            <form action="resultat_recherche_avancee.php" method="GET">
                <input id="RechercherBarre" type="text" name="recherche" value="">
                <button id="RechercherButton" class="Button" type="submit">🔍</button>
            </form>
        </div>

        <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>

        <h1>GastronoMix</h1>

        <?php
            if (isset($_SESSION['pseudo_user'])) {
                if($_SESSION['pseudo_user'] == "admin" || $_SESSION['pseudo_user'] == "Admin") {
                    MenuDeroulantAdmin($pseudo);
                }else {
                    MenuDeroulantCompte($pseudo);
                }
            } else {
                echo '<a href="http://localhost/gastronomix/connexion.php"><button id="CompteButton" class="Button">Connexion</button></a>';
            }
        ?>
        <center>
            <h2>Résultat recherche avancée</h2>
        </center>
            <div class="container">
                <?php
                $mysqli = ConnectionDatabase();

                // Récupérer les mots associés à "aliments_ok", "aliments_ko" et "categorie"
                if (!empty($_GET['aliments_ok']) || !empty($_GET['aliments_ko']) || !empty($_GET['categorie'])) {
                    //regarde si les variables existent et si elles ne sont pas vides
                    if (!empty($_GET['aliments_ok'])) {
                        $aliments_ok = $_GET['aliments_ok'];
                    } else {
                        $aliments_ok = "";
                    }
                    if (!empty($_GET['aliments_ko'])) {
                        $aliments_ko = $_GET['aliments_ko'];
                    } else {
                        $aliments_ko = "";
                    }
                    if (!empty($_GET['categorie'])) {
                        $categorie = $_GET['categorie'];
                    } else {
                        $categorie = "";
                    }

                    //test de récupération des données
                    //var_dump($_GET['aliments_ok'], $_GET['aliments_ko'], $_GET['categorie']);

                    // Convertir les tableaux en chaînes de caractères
                    if (!empty($aliments_ok)) {
                        $aliments_ok_string = implode("', '", $aliments_ok);
                    } else {
                        $aliments_ok_string = "";
                    }

                    // Idem pour les aliments à exclure
                    if (!empty($aliments_ko)) {
                        $aliments_ko_string = implode("', '", $aliments_ko);
                    } else {
                        $aliments_ko_string = "";
                    }

                    //echo "aliments_ko_string : " . $aliments_ko_string . "<br>";
                    //echo "aliments_ok_string : " . $aliments_ok_string . "<br>";

                    // Requête SQL pour récupérer les recettes correspondantes
                    $sql = "SELECT DISTINCT r.titre, r.image_recette, c.libelle_categorie
                                FROM recette r
                                JOIN quantite q ON q.id_recette = r.id_recette
                                JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                                JOIN categorie c ON c.id_categorie = r.id_categorie
                                WHERE ";

                    // Si les deux tableaux ne sont pas vides, on ajoute les deux conditions
                    if (!empty($aliments_ok_string) && !empty($aliments_ko_string)) {
                        $sql .= "i.ingredients_recherche IN ('$aliments_ok_string') AND
                            NOT EXISTS (
                            SELECT 1
                            FROM quantite q2
                            JOIN ingredient i2 ON i2.id_ingredient = q2.id_ingredient
                            WHERE q2.id_recette = r.id_recette
                            AND i2.ingredients_recherche IN ('$aliments_ko_string')
                            )";
                    } else if (!empty($aliments_ok_string) && empty($aliments_ko_string)) { 
                        // Sinon, on ajoute la condition correspondante
                        $sql .= "i.ingredients_recherche IN ('$aliments_ok_string')"; 
                    } else if (!empty($aliments_ko_string) && empty($aliments_ok_string)) {
                        // Idem pour les aliments à exclure
                        $sql .= "NOT EXISTS (
                                        SELECT 1
                                        FROM quantite q2
                                        JOIN ingredient i2 ON i2.id_ingredient = q2.id_ingredient
                                        WHERE q2.id_recette = r.id_recette
                                        AND i2.ingredients_recherche IN ('$aliments_ko_string')
                                    )";
                    } else {
                        // Aucun filtre sur les aliments
                        $sql .= "1"; 
                    }

                    // Ajouter la condition sur la catégorie si la personne à pas mis une catégorie spécifique
                    if ($categorie == 'null') {
                        $categories = ["entree", "plat", "dessert", "boisson"];
                        $categorie_condition = "c.libelle_categorie IN ('" . implode("', '", $categories) . "')";
                    } else {
                        $categorie_condition = "c.libelle_categorie = '$categorie'";
                    }

                    $sql .= " AND $categorie_condition";

                    $result = $mysqli->query($sql);

                    // Utilisez le résultat de la requête pour afficher les données
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
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
                    } else {
                        echo "Aucune recette trouvée.";
                    }
                }

                //resultat barre de recherche 
                if (isset($_GET['recherche'])) {
                    $mot_clef = $_GET['recherche'];
    
                    $query_recherche = "SELECT titre, image_recette
                            FROM recette 
                            WHERE titre LIKE '%$mot_clef%';";

                    $result_recherche = $mysqli->query($query_recherche);

                    if ($result_recherche->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result_recherche)) {
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
                    } else {
                        echo "Aucune recette trouvée.";
                    }
                }
            ?>
        </div>
    </body>
</html>