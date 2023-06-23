<?php
    function ConnectionDatabase() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "gastronomix"; 
        
        try {
            $mysqli = new mysqli($host, $user, $password, $database);
            return $mysqli;
            //$mysqli = mysqli_connect($host, $user, $password, $database);
            //echo "Connexion à la base de données : " . $database . " réussie. </br></br>";
        }

        catch (Exception $e) {
            echo '<p>Erreur de Connexion au SGBD = '.$database;
            echo "\n -ERROR-ERROR-ERROR " . $e;
            die('Erreur de connexion (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error); 
            exit();
        }
    }

    function MenuDeroulantDeconnecter() {
        $categories = ['Entrée', 'Plat', 'Dessert', 'Boisson'];

        echo '<li><a href="http://localhost/gastronomix/Accueil.php">🍽️ Accueil</a></li>';

        foreach ($categories as $categorie) {
            echo '<li><a href="http://localhost/gastronomix/categorie.php?categorie=' . $categorie .'">🍽️ ' . $categorie . '</a></li>';
        }
    }

    function MenuDeroulantConnecter($pseudo) {
        $categories = ['Entrée', 'Plat', 'Dessert', 'Boisson'];

        echo '<li><a href="http://localhost/gastronomix/Accueil.php?pseudo=' . $pseudo . '">🍽️ Accueil</a></li>';

        foreach ($categories as $categorie) {
            echo '<li><a href="http://localhost/gastronomix/categorie.php?categorie=' . $categorie .'&pseudo=' . $pseudo . '">🍽️ ' . $categorie . '</a></li>';
        }

    }

    function MenuDeroulantCompte($pseudo) {
        echo '<button id="CompteButton" class="Button" onclick="toggleCompte()">Compte</button>';
        echo '<div id="compte">';
        echo '<ul>';
        echo '<li><a href="http://localhost/gastronomix/profil.php?pseudo=' . $pseudo . '">⚙️ Profil</a></li>';
        echo '<li><a href="http://localhost/gastronomix/favoris.php?pseudo=' . $pseudo . '">🧡 Favoris</a></li>';
        echo '<li><a href="http://localhost/gastronomix/historique.php?pseudo=' . $pseudo . '">⌛️ Historique</a></li>';
        echo '<li><a href="http://localhost/gastronomix/deconnexion.php?pseudo=' . $pseudo . '">👋 Déconnexion</a></li>';
        echo '</ul>';
        echo '</div>';
    }

    function MenuDeroulantAdmin($pseudo) {
        echo '<button id="CompteButton" class="Button" onclick="toggleCompte()">Compte</button>';
        echo '<div id="compte">';
        echo '<ul>';
        echo '<li><a href="http://localhost/gastronomix/deconnexion.php?pseudo=' . $pseudo . '">👋 Déconnexion</a></li>';
        echo '</ul>';
        echo '</div>';
    }
    
?>

<?php
    function ajouterFavori($id_user, $id_recette) {
        // Connectez-vous à votre base de données
        $mysqli = ConnectionDatabase();

        // Vérifiez d'abord si la recette n'est pas déjà dans les favoris de l'utilisateur
        $query = "SELECT * FROM favoris WHERE id_user = '$id_user' AND id_recette = '$id_recette'";
        $result = $mysqli->query($query);

        if ($result->num_rows > 0) {
            // La recette est déjà dans les favoris de l'utilisateur, vous pouvez afficher un message d'erreur ou effectuer une action appropriée
            echo "La recette est déjà dans vos favoris.";
        } else {
            // La recette n'est pas encore dans les favoris, vous pouvez l'ajouter
            $query = "INSERT INTO favoris (id_user, id_recette) VALUES ('$id_user', '$id_recette')";
            $mysqli->query($query);

            // Affichez un message de succès ou effectuez une action appropriée
            echo "La recette a été ajoutée aux favoris.";
        }

        // Fermez la connexion à la base de données
        $mysqli->close();
    }
?>

<?php
    function redirectTo($url, $query_string = null) {
        if ($query_string) {
            $url .= '?' . $query_string;
        }
        echo '<script>window.location.href = "' . $url . '";</script>';
    }
?>


