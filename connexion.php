<!DOCTYPE html>
<html>
<head>
  
</head>
<body>
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
        <a href="Accueil.php"><button type="button" class="btn btn-primary">Se connecter</button></a>

    </form>
    <p>Nouveau sur notre site ? <a href="connect.php">Créer un compte</a></p>
</div>
</body>
</html>
