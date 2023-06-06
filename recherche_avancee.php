<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Recherche avancée</title>
    </head>
    <body>
        <?php
            $mysqli = ConnectionDatabase();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $categorie = $_POST['categorie'];
                switch ($categorie) {
                    case 'entree':
                        $requete = "SELECT libelle_categorie FROM categorie WHERE id_categorie = 1";
                        break;
                    case 'plat':
                        $requete = "SELECT libelle_categorie FROM categorie WHERE id_categorie = 2";
                        break;
                    case 'dessert':
                        $requete = "SELECT libelle_categorie FROM categorie WHERE id_categorie = 3";
                        break;
                    case 'boisson':
                        $requete = "SELECT libelle_categorie FROM categorie WHERE id_categorie = 4";
                        break;
                }echo $requete;
            }

            // Effectuer la recherche en fonction des aliments
            $sql = "SELECT nom_ingredient FROM ingredient";
        ?>
        <center>
            <h1>Recherche avancée</h1>
            <p>
                Catégories :
                <form action="categoriser" method="GET">
                    <select name="categorie">
                        <option value="null" selected>...</option> 
                        <option value="entree">Entrée</option>   
                        <option value="plat">Plat</option> 
                        <option value="dessert">Dessert</option>
                        <option value="boisson">Boisson</option>
                    </select>
                    <br>
                </form>
                <br>

                Aliments : <br>
                <br>
                <?php
                    // Exécute la requête SQL de recherche des aliments et récupère les résultats
                    $result = $mysqli->query($sql);

                    // Parcour les résultats et les affiche dans la liste déroulante
                    while ($row = $result->fetch_assoc()) {
                        //echo '<option value="' . $row['nom_ingredient'] . '">' . $row['nom_ingredient'] . '</option>';
                        echo '<input type="checkbox" class="form-check-input" name="aliments[]" value="' . $row['nom_ingredient'] . '">' . $row['nom_ingredient'] . '<br>';
                    }
                ?>
            </p>
            <input type="submit" name="bouton" value="Rechercher">
        </center>
    </body>
</html>
