<?php
    require 'Function.php';
        //demarrer la session qui permet de recuperer le pseudo de l'utilisateur connecter
    session_start();
// verifier si le peudo existe dans l'url si oui on le recupere et on le met dans la session
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
        <script>
            //cette fonction est appelé lors du click sur le bouton retirer des favoris qui a en parametre l'id de la recette
            function retirerDesFavoris(idRecette) {
                // Créer un objet FormData cette objet permet de construire les donnees de la requete post qui va etre envoyer au serveur
                var formData = new FormData();

                //ajouter pour l'objet formData l'id de la recette
                formData.append('id_recette', idRecette);

                //envoyer la requete post au serveur
                fetch('retirer_des_favoris.php', {
                        method: 'POST',//pour dire que c'est une requete post
                        body: formData//ce qui permet de recuperer les donnees de la requete
                })

                //la methode fetch renvoie une promesse donc on utilise la methode then pour recuperer la reponse du serveur
                .then(function(response) {
                    if (response.ok) {
                        // La recette a été retirée des favoris avec succès
                        alert("La recette a été retirée des favoris !");
                        // equivalent du refresh de la page
                        window.location.reload();
                       // Effectuer d'autres actions si nécessaire, comme mettre à jour l'interface utilisateur.
                    } else {
                        // Une erreur s'est produite lors de la suppression des favoris
                        alert("Erreur lors du retrait des favoris.");
                    }
                })

                //la methode fetch renvoie une promesse donc on utilise la methode catch pour recuperer l'erreur
                .catch(function(error) {
                    // Une erreur s'est produite lors de la requête AJAX
                    alert("Une erreur s'est produite lors de la requête AJAX.");
                });
            }
        </script>
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

        <br><br>

        <h2>Favoris</h2>

        <?php
            $mysqli = ConnectionDatabase();

            // Vérifier si l'utilisateur est connecté
            if (isset($_SESSION['pseudo_user'])) {
                $pseudo = $_SESSION['pseudo_user'];
                // Récupérer l'id de l'utilisateur
                $id_user = $mysqli->query("SELECT id_user FROM user WHERE pseudo_user = '$pseudo'")->fetch_assoc()['id_user'];
               //select dans la databse 
                $query = "SELECT r.id_recette, r.image_recette, r.titre
                        FROM recette AS r
                        INNER JOIN favoris AS f ON r.id_recette = f.id_recette
                        WHERE f.id_user = '$id_user'";

                $result = $mysqli->query($query);

                $recettes_favorites = array();

                echo '<div class="container">';
                //on utilise la fonction mysqli_fetch_assoc pour recuperer les donnees de la requete sous forme de tableau
                while ($row = mysqli_fetch_assoc($result)) {
                    $image_recette = $row["image_recette"];
                    $id_recette = $row['id_recette'];
                    $titre = $row['titre'];
                    $newtitre = str_replace("'", "_", $titre);

                    $recettes_favorites = [];
                    array_push($recettes_favorites, $image_recette, $titre, $id_recette);
                    
                    if (!empty($recettes_favorites)) {
                        if (isset($_SESSION['pseudo_user'])) {
                            echo '<div class="recette zoom">';
                            // Image cliquable
                            echo '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">';
                            echo '<img src="' . $image_recette . '" alt="Image de la recette"><br>';
                            echo '</a>';
                            echo '<div class="nom-recette">';
                            // Titre cliquable
                            echo  '<a href="http://localhost/gastronomix/recette.php?pseudo=' . $pseudo . '&recherche=' . $newtitre . '">' . $titre . '</a>' . '<br>';
                            echo '<button class="Button" onclick="retirerDesFavoris(' . $id_recette . ')">💔 </button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo 'Aucune recette favorite trouvée.';
                    }
                } 
                echo '</div>';
            }else {
                echo 'Veuillez vous connecter pour voir vos recettes favorites.';
            }
            $mysqli->close();
        ?>
    </body>
</html>