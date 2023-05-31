<!DOCTYPE html>
<html>
<head>
  
</head>
<body>
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
    <form action="" method="post">
        <div class="form-group">
            <label for="nom_user">nom_user</label>
            <input
                type="text"
                class="form-control"
                id="nom_user"
                name="nom_user"
            />
        </div>
        <div class="panel-body">
    <form action="" method="post">
        <div class="form-group">
            <label for="pseudo_user">pseudo_user</label>
            <input
                type="text"
                class="form-control"
                id="pseudo_user"
                name="pseudo_user"
            />
        </div>
        <div class="form-group">
            <label for="prenom_user">prenom_user</label>
            <input
                type="prenom"
                class="form-control"
                id="prenom_user"
                name="prenom_user"
            />
        </div>
        <div class="form-group">
            <label for="tel_user">tel_user</label>
            <input
                type="tel"
                class="form-control"
                id="tel_user"
                name="tel_user"
            />
        </div>
        <div class="form-group">
            <label for="mail_user">mail_user</label>
            <input
                type="email"
                class="form-control"
                id="mail_user"
                name="mail_user"
            />
        </div>
        <div class="form-group">
            <label for="password_user">password_user</label>
            <input
                type="password"
                class="form-control"
                id="password_user"
                name="password_user"
            />
        </div>
        <input type="submit" class="btn btn-primary" value="Submit" />
    </form>
</div>
</body>
</html>
