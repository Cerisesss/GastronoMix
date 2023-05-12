<?php
// Si l'email ou le mot de passe n'est pas spécifié
if ($_POST["email"] == "" or $_POST["password"] == "") {
	// On prépare un message d'erreur.
	$erreur = "L'email et le mot de passe doivent être renseignés.";
	require_once "../views/accueil.php";
} else {
	// Sinon, on récupère les fonctions pour gérer un utilisateur (ajouter, récupérer)
	require_once "../models/utilisateur.php";

	// Si on demande à s'inscrire
	if ($_POST["action"] == "sign-in") {
		// on ajoute l'utilisateur,
		$ajouter_utilisateur($_POST["email"], $_POST["password"]);

		// et on prépare un message de confirmation
		$confirmation = "L'utilisateur a bien été ajouté.";
		require_once "../views/accueil.php";
	} else if ($_POST["action"] == "sign-up") {
		// Sinon, si on demande à se connecter

		// on essaye de récupérer l'utilisateur depuis la base de données
		$utilisateur = $recuperer_utilisateur($_POST["email"], $_POST["password"]);

		// Si on a rien récupéré
		if ($utilisateur == false) {
			// On indique que la connexion n'a pas fonctionné
			$erreur = "L'email ou le mot de passe n'est pas bon.";
			require_once "../views/accueil.php";
		} else if (isset($utilisateur->id)) {
			// Sinon, on enregistre l'id de l'utilisateur dans la session et on affiche la page suivante
			session_start();
			$_SESSION["user-id"] = $utilisateur->id;
			require_once "../views/espace_personnel.php";
		}
	}
}
?>
