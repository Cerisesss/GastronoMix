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
        <?php
        
            session_start();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $mail_user = $_POST['mail_user'];
                $password_user = $_POST['password_user'];

                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'gastronomix');
                if ($conn->connect_error) {
                    echo "$conn->connect_error";
                    die("Connection Failed: " . $conn->connect_error);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM user WHERE mail_user = ?");
                    if (!$stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    
                    $stmt->bind_param("s", $mail_user);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows === 1) {
                        $user = $result->fetch_assoc();
                        if ($password_user == $user['password_user']) {
                            // Authentification réussie
                            $_SESSION['mail_user'] = $user['mail_user'];
                            header("Location: welcome.php");
                            exit();
                        } else {
                            echo "Mot de passe incorrect.";
                        }
                    } else {
                        echo "Adresse e-mail incorrecte.";
                    }
                    $stmt->close();
                    $conn->close();
                }
            }
        ?>
        
        <div class="panel-body">
            <h2>Se connecter</h2>
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
                <a href="Accueil.php"><button type="button" class="Button">Se connecter</button></a>

            </form>
            <p>Nouveau sur notre site ? <a href="http://localhost/gastronomix/CreationCompte.php"><button class="Button">Créer un compte</button></a></p>
        </div>
    </body>
</html>
<?php
    require 'Function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Creation de compte</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="Function.js"></script>
    </head>
    <body>
        <div header>
        <btuton id="MenuButton" class="Button" onclick="toggleMenu()">=</button>

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
        

        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom_user = $_POST['nom_user'];
                $pseudo_user = $_POST['pseudo_user'];
                $mail_user = $_POST['mail_user'];
                $prenom_user = $_POST['prenom_user'];
                $tel_user = $_POST['tel_user'];
                $password_user = $_POST['password_user'];


                // Database connection
                $conn = new mysqli('localhost', 'root', '', 'gastronomix');
                if ($conn->connect_error) {
                    echo "$conn->connect_error";
                    die("Connection Failed : " . $conn->connect_error);
                } else {
                    $stmt = $conn->prepare("INSERT INTO user (nom_user,pseudo_user, prenom_user, tel_user, mail_user, password_user) VALUES (?, ?,?, ?, ?, ?)");
                    if (!$stmt) {
                        die("Prepare failed: " . $conn->error);
                    }
                    
                    $stmt->bind_param("ssssss", $nom_user, $pseudo_user,$prenom_user, $tel_user, $mail_user, $password_user);
                    $execval = $stmt->execute();
                    echo $execval;
                    echo "enregistrer...";
                    $stmt->close();
                    $conn->close();
                }
            }
        ?>

        <div class="panel-body">
            <h2>Créer un compte</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="nom_user">Nom</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nom_user"
                        name="nom_user"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="pseudo_user">Pseudo</label>
                    <input
                        type="text"
                        class="form-control"
                        id="pseudo_user"
                        name="pseudo_user"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="prenom_user">Prénom</label>
                    <input
                        type="text"
                        class="form-control"
                        id="prenom_user"
                        name="prenom_user"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="tel_user">Téléphone</label>
                    <input
                        type="tel"
                        class="form-control"
                        id="tel_user"
                        name="tel_user"
                        required
                    />
                </div>
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
                <input type="submit" class="Button" value="S'inscrire" />
            </form>
            <p>Déjà inscrit ?<a href="http://localhost/gastronomix/connexion.php"><button class="Button">Se connecter</button></a></p>
        </div>
    </body>
</html>
