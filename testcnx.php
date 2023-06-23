<?php
require 'Function.php';
$bdd = ConnectionDatabase();

session_start(); 
if (!empty($_POST['mail_user']) && !empty($_POST['password_user'])) {
    
    $mail = htmlspecialchars($_POST['mail_user']);
    $password = htmlspecialchars($_POST['password_user']);

    $mail = strtolower($mail); 

    $check = $bdd->prepare('SELECT pseudo_user, mail_user, password_user,id_user FROM user WHERE mail_user = ?');
    $check->bind_param("s", $mail);
    $check->execute();
    $result = $check->get_result(); 
    $row = $result->num_rows; 

    if ($row > 0) {
        $data = $result->fetch_assoc(); 

        
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
           
            if (password_verify($password, $data['password_user'])) {
                $_SESSION['user'] = $data['pseudo_user']; 
                $_SESSION['id'] = $data['id_user']; // Correction : utilisez le pseudo de l'utilisateur plutôt que le token
                header('Location: Accueil.php');
                exit();
            } else {
                header('Location: Connexion.php?login_err=password');
                exit();
            }
        } else {
            header('Location: Connexion.php?login_err=email');
            exit();
        }
    } else {
        header('Location: Connexion.php?login_err=already');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="Function.js"></script>
</head>
<body>
    <div header>
        <button id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

        <div id="menu">
            <ul>
                <h2>Menu</h2>
                <li><a href="http://localhost/gastronomix/Accueil.php">🍽️ Accueil</a></li>
                <li><a href="http://localhost/gastronomix/entree.php">🍽️ Entrée</a></li>
                <li><a href="http://localhost/gastronomix/plat.php">🍽️ Plat</a></li>
                <li><a href="http://localhost/gastronomix/dessert.php">🍽️ Dessert</a></li>
                <li><a href="http://localhost/gastronomix/boisson.php">🍽️ Boisson</a></li>
            </ul>
        </div>

      
   
    <div class="panel-body">
        <h2>Se connecter</h2>
        <?php
        if (isset($_GET['login_err'])) {
            $login_err = $_GET['login_err'];
            if ($login_err == "password") {
                echo '<p class="error">Mot de passe incorrect</p>';
            } elseif ($login_err == "email") {
                echo '<p class="error">Email incorrect</p>';
            } elseif ($login_err == "already") {
                echo '<p class="error">L\'utilisateur n\'existe pas</p>';
            }
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="mail_user">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="mail_user"
                    name="mail_user"
                    required
                />
            </div>
            <div class="form-group">
                <label for="password_user">Mot de passe</label>
                <input
                    type="password"
                    class="form-control"
                    id="password_user"
                    name="password_user"
                    required
                />
            </div>
            <input type="submit" class="Button" value="Se connecter" />
        </form>
        <p>Nouveau sur notre site ? <a href="http://localhost/gastronomix/CreationCompte.php"><button class="Button">Créer un compte</button></a></p>
    </div>
</body>
</html>
<?php
require_once 'Function.php';
session_start();
?> 

<!DOCTYPE html>
<html>
<head>
    <title>GastronoMix</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="Function.js"></script>
</head>
<body>
<div id="header">
    <button id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

    <div id="menu">
        <ul>
            <h2>Menu</h2>
            <li><a href="http://localhost/gastronomix/Accueil.php">🍽️ Accueil</a></li>
            <li><a href="http://localhost/gastronomix/entree.php">🍽️ Entrée</a></li>
            <li><a href="http://localhost/gastronomix/plat.php">🍽️ Plat</a></li>
            <li><a href="http://localhost/gastronomix/dessert.php">🍽️ Dessert</a></li>
            <li><a href="http://localhost/gastronomix/boisson.php">🍽️ Boisson</a></li>
        </ul>
    </div>

    <div id="Rechercher">
        <form action="recette.php" method="GET">
            <input id="RechercherBarre" type="text" name="recherche" value="">
            <button id="RechercherButton" class="Button" type="submit">🔍</button>
        </form>

        <a href="http://localhost/gastronomix/connexion.php"><button class="Button">Connexion</button></a>
    </div>

    <br><br>

    <h1>Résultat</h1> 

    <button id="ThemeButton" class="Button" onclick="ChangeBackgroundColor()">🌓</button>


    <?php
    $mysqli = ConnectionDatabase();

    if (isset($_GET['recherche'])) {
        $mot_clef = $_GET['recherche'];

                $query = "SELECT image_recette, titre, temps_prep_recette, temps_cui_recette, temps_repos_recette, nb_personne, id_recette
                FROM recette 
                WHERE titre LIKE '%$mot_clef%';";

        $result_recette = $mysqli->query($query);

    if ($result_recette->num_rows > 0) {
            while ($row = $result_recette->fetch_assoc()) {
                $id_recette = $row['id_recette']; // Correction : Assigner la valeur de $row['id_recette'] à $id_recette

                echo '<img src="' . $row['image_recette'] . '"><br>';
                echo "<h2>" . $row["titre"] . "</h2><br>";
                echo "<p>Temps de préparation : " . $row['temps_prep_recette']. "</p>";
                echo "<p>Temps de cuisson : " . $row['temps_cui_recette']. "</p>";
                echo "<p>Temps de repos : " . $row['temps_repos_recette'] . "</p>";
                echo "<h3>Nombre de personnes</h3>" . $row['nb_personne'] . "<br>";

                $query_materiel = "SELECT m.libelle_materiel FROM recette r
                                    JOIN recette_materiel rm ON rm.id_recette = r.id_recette
                                    JOIN materiel m ON m.id_materiel = rm.id_materiel
                                    WHERE r.titre LIKE '%$mot_clef%';";

                $result_materiel = $mysqli->query($query_materiel);

            if ($result_materiel->num_rows > 0) {
                    echo "<h3>Matériel</h3>";
                    while ($row_materiel = $result_materiel->fetch_assoc()) {
                        echo "<li>" . $row_materiel['libelle_materiel'] . "</li>";
                    }
                }

                $query_ingredient = "SELECT i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
                                        JOIN quantite q ON q.id_recette = r.id_recette
                                        JOIN ingredient i ON i.id_ingredient = q.id_ingredient
                                        JOIN unite u ON u.id_unite = i.id_unite
                                        WHERE r.titre LIKE '%$mot_clef%';";

                $result_ingredient = $mysqli->query($query_ingredient);

            if ($result_ingredient->num_rows > 0) {
                    echo "<h3>Ingrédients</h3>";
                    while ($row_ingredient = $result_ingredient->fetch_assoc()) {
                        echo "<li>" . $row_ingredient['nom_ingredient'] . " " . $row_ingredient['quantite'] . " " . $row_ingredient['libelle_unite'] . "</li>";
                    }
                }

                $query_etape = "SELECT e.id_etape, e.texte_etape FROM recette r 
                                    JOIN etape e ON e.id_recette = r.id_recette
                                    WHERE r.id_recette = " . $id_recette . ";";

                $result_etape = $mysqli->query($query_etape);

            if ($result_etape->num_rows > 0) {
                    echo "<h3>Étapes</h3>"; 
                    while ($row_etape = $result_etape->fetch_assoc()) {
                        echo "<li>" . "Étape " . $row_etape['id_etape'] . " : " . $row_etape['texte_etape'] . "</li>";
                    }
                }

                echo "<br>";

                if (isset($_SESSION['id'])) {// L'utilisateur est connecté, afficher le formulaire pour ajouter aux favoris
                echo '<form id="ajouter-favoris-form" method="POST" action="ajouter_aux_favoris.php">';
                echo '<input type="hidden" name="id_recette" value="' . $id_recette . '">';
                echo '<input type="submit" value="Ajouter aux favoris">';
                echo '</form>';
               
            }
            
        }
        } else {
            echo "<p>Aucun résultat.</p>";
        }
    } else {
        echo "<p>Aucun résultat.</p>";
    }

    $mysqli->close();
    ?>

    <script>
    document.getElementById('ajouter-favoris-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        var form = event.target;
        var formData = new FormData(form);

        fetch('ajouter_aux_favoris.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            if (response.ok) {
                // Le script PHP a terminé avec succèsh
                alert("La recette a été ajoutée aux favoris !");   
            } else {
                throw new Error('Erreur lors de l\'ajout aux favoris.');  
            }
        })
        .catch(function(error) {
            // Une erreur s'est produite lors de l'appel à ajouter_aux_favoris.php
            alert(error.message);
        });
    });
    </script>
</div>
</body>
</html>
