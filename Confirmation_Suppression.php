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

        <h2>Suppression</h2>


        <?php
            $mysqli = ConnectionDatabase();

            // Récupérer les données du formulaire
            $titre = $_GET['recherche'];

            $query_id_titre = "SELECT * FROM recette WHERE titre = '$titre';";

            $result_id_titre = $mysqli->query($query_id_titre);
            $result_id_recette = $result_id_titre->fetch_assoc();
            $id_recette = $result_id_recette['id_recette'];
            
            $query_Delete_recette = "DELETE FROM recette WHERE id_recette = '$id_recette';";
            $result_Delete_recette = $mysqli->prepare($query_Delete_recette);

            $query_Delete_Quantite = "DELETE FROM quantite WHERE id_recette = '$id_recette';";
            $result_Delete_Quantite = $mysqli->prepare($query_Delete_Quantite);

            $query_Delete_Etape = "DELETE FROM etape WHERE id_recette = '$id_recette';";
            $result_Delete_Etape = $mysqli->prepare($query_Delete_Etape);

            $query_Delete_Historique = "DELETE FROM historique WHERE id_recette = '$id_recette';";
            $result_Delete_Historique = $mysqli->prepare($query_Delete_Historique);

            $query_Delete_Favoris = "DELETE FROM favoris WHERE id_recette = '$id_recette';";
            $result_Delete_Favoris = $mysqli->prepare($query_Delete_Favoris);
            

            if ($result_Delete_recette->execute() && $result_Delete_Quantite->execute() && $result_Delete_Etape->execute() && $result_Delete_Historique->execute() && $result_Delete_Favoris->execute()) {
                echo "Suppression réussite.";
            } else {
                echo "Erreur lors de la supression : " . $mysqli->error;
            }


            $mysqli->close();
            
        ?>
        
        <br>
        
        <form action="Accueil.php?pseudo=<?php echo $pseudo?>" method="POST">
            <button id="DeleteButton" class="Button" type="submit">Retour à la page d'accueil</button>
        </form>

    </body>
</html>
