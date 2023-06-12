<?php
require 'Function.php';
$bdd = ConnectionDatabase();

session_start(); // Démarrage de la session

if (!empty($_POST['mail_user']) && !empty($_POST['password_user'])) {
    // Patch XSS
    $mail = htmlspecialchars($_POST['mail_user']);
    $password = htmlspecialchars($_POST['password_user']);

    $mail = strtolower($mail); // Email transformé en minuscules

    // On vérifie si l'utilisateur est inscrit dans la table "user"
    $check = $bdd->prepare('SELECT pseudo_user, mail_user, password_user FROM user WHERE mail_user = ?');
    $check->bind_param("s", $mail);
    $check->execute();
    $result = $check->get_result(); // Récupérer le résultat de la requête
    $row = $result->num_rows; // Compter le nombre de lignes dans le résultat

    // Si $row > 0, alors l'utilisateur existe
    if ($row > 0) {
        $data = $result->fetch_assoc(); // Récupérer les données de l'utilisateur

        // Si le mail est au bon format
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            // Si le mot de passe est correct
            if (password_verify($password, $data['password_user'])) {
                // On crée la session et on redirige vers la page d'accueil
                $_SESSION['user'] = $data['pseudo_user']; // Correction : utilisez le pseudo de l'utilisateur plutôt que le token
                header('Location: Accueil.php');
                exit();
            } else {
                header('Location: connexion.php?login_err=password');
                exit();
            }
        } else {
            header('Location: connexion.php?login_err=email');
            exit();
        }
    } else {
        header('Location: connexion.php?login_err=already');
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
                <li><a href="http://localhost/gastronomix/Accueil.php">Accueil</a></li>
                <li><a href="http://localhost/gastronomix/entree.php">Entrée</a></li>
                <li><a href="http://localhost/gastronomix/plat.php">Plat</a></li>
                <li><a href="http://localhost/gastronomix/dessert.php">Dessert</a></li>
                <li><a href="http://localhost/gastronomix/boisson.php">Boisson</a></li>
            </ul>
        </div>

        <form action="recette.php" method="GET">
            <input type="text" name="recherche" value="">
            <button class="Button" type="submit">Rechercher</button>
        </form>
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
