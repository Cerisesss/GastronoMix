<?php
    function ConnectionDatabase() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "GastronoMix"; 
        
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

    //Menu deroulant "🟰" lorsque l'utilisateur est deconnecté
    function MenuDeroulantDeconnecter() {
        $categories = ['Entrée', 'Plat', 'Dessert', 'Boisson'];

        echo '<button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>';
        echo '<div id="menu">';
        echo '<ul>';
        echo '<br>';
        echo '<li><a href="http://localhost/gastronomix/Accueil.php">🍽️ Accueil</a></li>';

        foreach ($categories as $categorie) {
            echo '<li><a href="http://localhost/gastronomix/categorie.php?categorie=' . $categorie .'">🍽️ ' . $categorie . '</a></li>';
        }

        echo '</ul>';
        echo '</div>';
    }

    //Menu deroulant "🟰" lorsque l'utilisateur est connecté
    function MenuDeroulantConnecter($pseudo) {
        $categories = ['Entrée', 'Plat', 'Dessert', 'Boisson'];

        echo '<button id="MenuButton" class="Button" onclick="toggleMenu()">🟰</button>';
        echo '<div id="menu">';
        echo '<ul>';
        echo '<br>';
        echo '<li><a href="http://localhost/gastronomix/Accueil.php?pseudo=' . $pseudo . '">🍽️ Accueil</a></li>';

        foreach ($categories as $categorie) {
            echo '<li><a href="http://localhost/gastronomix/categorie.php?pseudo=' .  $pseudo . '&categorie='. $categorie . '">🍽️ ' . $categorie . '</a></li>';
        }

        echo '</ul>';
        echo '</div>';

    }

    //Menu deroulant du compte lorsque l'utilisateur est connecté
    function MenuDeroulantCompte($pseudo) {
        echo '<button id="CompteButton" class="Button" onclick="toggleCompte()">Compte</button>';
        echo '<div id="compte">';
        echo '<ul>';
        echo '<h3>' . $pseudo .'</h3>';
        echo '<li><a href="http://localhost/gastronomix/favoris.php?pseudo=' . $pseudo . '">🧡 Favoris</a></li>';
        echo '<li><a href="http://localhost/gastronomix/historique.php?pseudo=' . $pseudo . '">⌛️ Historique</a></li>';
        echo '<li><a href="http://localhost/gastronomix/deconnexion.php?pseudo=' . $pseudo . '">👋 Déconnexion</a></li>';
        echo '</ul>';
        echo '</div>';
    }

    //Menu deroulant du compte admin lorsqu'il est connecté
    function MenuDeroulantAdmin($pseudo) {
        echo '<button id="CompteButton" class="Button" onclick="toggleCompte()">Compte</button>';
        echo '<div id="compte">';
        echo '<ul>';
        echo '<h3>' . $pseudo .'</h3>';
        echo '<li><a href="http://localhost/gastronomix/InsertNewRecipe.php?pseudo=' . $pseudo . '">➕ Ajouter une recette</a></li>';
        echo '<li><a href="http://localhost/gastronomix/favoris.php?pseudo=' . $pseudo . '">🧡 Favoris</a></li>';
        echo '<li><a href="http://localhost/gastronomix/historique.php?pseudo=' . $pseudo . '">⌛️ Historique</a></li>';
        echo '<li><a href="http://localhost/gastronomix/deconnexion.php?pseudo=' . $pseudo . '">👋 Déconnexion</a></li>';
        echo '</ul>';
        echo '</div>';
    }

    //Barre de recherche et bouton qui mene vers la page de recherche avancee lorsque l'utilisateur est deconnecté
    function RechercheAvancee() {
        echo '<div id="Rechercher">';
        echo '<a href="http://localhost/gastronomix/recherche_avancee.php"><button id="Recherche_avancee" class="Button"><img src="Images/filtre.png" alt="Image"></button></a>';
        echo '<form action="resultat_recherche_avancee.php" method="GET">';
        echo '<input id="RechercherBarre" type="text" name="recherche" value="">';
        echo '<button id="RechercherButton" class="Button" type="submit">🔍</button>';
        echo '</form>';
        echo '</div>';
    }

    //Barre de recherche et bouton qui mene vers la page de recherche avancee lorsque l'utilisateur est connecté
    function RechercheAvanceeConnecter($pseudo) {
        echo '<div id="Rechercher">';
        echo '<a href="http://localhost/gastronomix/recherche_avancee.php?pseudo=' . $pseudo . '"><button id="Recherche_avancee" class="Button"><img src="Images/filtre.png" alt="Image"></button></a>';
        echo '<form action="resultat_recherche_avancee.php" method="GET">';
        echo '<input type="hidden" name="pseudo" value="' . $pseudo . '">';
        echo '<input id="RechercherBarre" type="text" name="recherche" value="">';
        echo '<button id="RechercherButton" class="Button" type="submit">🔍</button>';
        echo '</form>';
        echo '</div>';
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


