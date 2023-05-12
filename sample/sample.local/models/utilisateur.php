<?php
require_once "connexion.php";

$ajouter_utilisateur = function (string $email, string $motDePasse) use($db) {
	$statement = $db->prepare("INSERT INTO user(email, password_hash) VALUES (?, PASSWORD(?));");
	$statement->execute([$email, $motDePasse]);
	// TODO: Gestion des erreurs.
};

$recuperer_utilisateur = function (string $email, string $motDePasse) use($db) {
	$statement = $db->prepare(
		"SELECT id, email, password_hash
		FROM user
		WHERE email = ? AND password_hash = PASSWORD(?);"
	);
	$statement->execute([$email, $motDePasse]);
	$result = $statement->fetch(PDO::FETCH_OBJ);
	return $result;
};
?>
