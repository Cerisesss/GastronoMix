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
        <title>Historique</title>
        <link rel="stylesheet" type="text/css" href="new_affichage_recettes.css">
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

        <br><br>

        <h2>Recettes noté</h2>

        <?php
            if (isset($_SESSION['pseudo_user'])) {
                $pseudo = $_SESSION['pseudo_user'];

                $mysqli = ConnectionDatabase();

                // Récupérer les avis de l'utilisateur pour une recette donnée
                $query = "SELECT h.id_recette, r.titre, r.image_recette, h.avis_historique
                            FROM historique h
                            JOIN recette r ON r.id_recette = h.id_recette
                            JOIN user u ON u.id_user = h.id_user
                            WHERE u.pseudo_user = '$pseudo';";
//la requete sql est stockée dans une variable $query
                $result = $mysqli->query($query);
//on fait une condition pour vérifier si la requete est bien exécutée et si le nombre de lignes est supérieur à 0
                if ($result && $result->num_rows > 0) {
                    //assigner les valeurs de la requete dans un tableau associatif
                    
                    echo '<div class="container">';
                    while ($row = $result->fetch_assoc()) {
                        //les valeurs sont stockées dans des variables
                        $id_recette = $row['id_recette'];
                        $titre = $row['titre'];
                        $image_recette = $row['image_recette'];
                        $avis_historique = $row['avis_historique'];

                        echo '<div class="recette-categorie">';
                        
                        echo '<div class="recette zoom">';
                        // Image cliquable
                        echo 'Avis : ' . $avis_historique . '/5<br>';
                        echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $titre . '">';
                        echo '<img src="' . $image_recette . '" alt="Avis: ' . $avis_historique . '/5"><br>';
                        echo '</a>';
                        // Titre cliquable
                        echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $titre . '">' . $titre . '</a><br>';
                        echo '</div>';
                        echo '<div class="nom-recette">';
                        // Afficher l'avis de l'utilisateur
                        echo '</div>';
                      //  echo 'Avis : ' . $avis_historique . '/5';
                        echo '</div>';
                       
                    }
                } else {
                    echo "<p>Aucun avis trouvé dans l'historique.</p>";
                }
                echo '</div>';

                $mysqli->close();
            } else {
                echo "<p>Veuillez vous connecter pour accéder à votre historique d'avis.</p>";
            }
        ?>
    </body>
</html>
