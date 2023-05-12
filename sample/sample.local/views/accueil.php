<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Accueil</title>
	</head>
	<body>
		<h1>Bienvenu</h1>
		<form action="/controllers/authentifier.php" method="post">
			<?php if ($erreur) {
				echo $erreur;
				echo "<br>";
			} ?>
			<label for="email">Email :</label>
			<input type="email" id="email" name="email" />
			<br />
			<label for="password">Mot de passe :</label>
			<input type="password" id="password" name="password" />
			<br />
			<button name="action" value="sign-in">S'inscrire</button>
			<button name="action" value="sign-up">Se connecter</button>
		</form>
		<?php if ($confirmation) {
			echo $confirmation;
		} ?>
	</body>
</html>
