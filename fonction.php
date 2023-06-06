<?php
function connection_database($host, $user, $password, $database) {
    echo "\n Bonjour MySql DATABASE \n";
    // Connexion à la base de données
        try {
            // Vérification de la connexion
            $conn = mysqli_connect($host, $user, $password, $database);
        }
        catch (Exception $e) {
            echo '<p>Erreur de Connexion au SGBD = '.$database;
            echo "\n -ERROR-ERROR-ERROR " . $e;
            die('Erreur de connexion (' . $conn->connect_errno . ') ' . $conn->connect_error); 
            exit();
        }
    }
function fonction1() {
    $query = "SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape
              FROM recette r
              JOIN etape e ON e.id_recette = r.id_recette
              ORDER BY r.id_recette ASC";
}

function fonction2($id_recette) {
    $query = "SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape
              FROM recette r
              JOIN etape e ON e.id_recette = r.id_recette
              WHERE r.id_recette = 1;";

}

function fonction3($titre_recette) {
    $query = "SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape
              FROM recette r
              JOIN etape e ON e.id_recette = r.id_recette
              WHERE r.titre = $titre_recette";

}

function fonction4($id_etape) {
    $query = "SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape
              FROM recette r
              JOIN etape e ON e.id_recette = r.id_recette
              WHERE e.id_etape = $id_etape";

}

function fonction5 ($nom_etape, $id_recette) {
    $query = "SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape
              FROM recette r
              JOIN etape e ON e.id_recette = r.id_recette
              WHERE e.nom_etape = '$nom_etape' AND r.id_recette = $id_recette";

}


function fonction6($titre_recette) {
    $query = "SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite
              FROM recette r
              JOIN quantite q ON q.id_recette = r.id_recette
              JOIN ingredient i ON i.id_ingredient = q.id_ingredient
              WHERE r.titre = '$titre_recette'";


}
function fonction7($id_recette) {
    $query = "SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
    JOIN quantite q ON q.id_recette = r.id_recette
    JOIN ingredient i ON i.id_ingredient = q.id_ingredient
    JOIN unite u ON u.id_unite = i.id_unite
    WHERE r.id_recette = $id_recette";


}
function fonction8($titre_recette) {
    $query = "SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
    JOIN quantite q ON q.id_recette = r.id_recette
    JOIN ingredient i ON i.id_ingredient = q.id_ingredient
    JOIN unite u ON u.id_unite = i.id_unite
    WHERE r.titre = $titre_recette";
}
function fonction9($nom_ingredient) {
    $query = "SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
    JOIN quantite q ON q.id_recette = r.id_recette
    JOIN ingredient i ON i.id_ingredient = q.id_ingredient
    JOIN unite u ON u.id_unite = i.id_unite
    WHERE i.nom_ingredient =$nom_ingredient";
}

function fonction10() {
    $query = "SELECT i.id_ingredient, i.nom_ingredient, u.libelle_unite FROM ingredient i
    JOIN unite u ON i.id_unite = u.id_unite";
}

function fonction11() {
    $query = "SELECT u.id_user, u.nom_user, u.prenom_user, u.password_user, h.avis_historique, h.favori_historique, id_recette FROM user u
    JOIN historique h ON u.id_user = h.id_user";
}
function fonction12() {
    $query = "SELECT p.id_pays, p.nom_pays, r.id_recette, r.titre, r.categorie_recette
    FROM pays p
    JOIN recette r ON p.id_pays = r.id_pays";
}
function fonction13($libelle_categorie){
    $query = "SELECT r.id_recette, r.titre, r.categorie_recette, r.description_recette, c.libelle_categorie FROM recette r
    JOIN categorie c ON c.id_categorie = r.id_categorie
    WHERE c.libelle_categorie = $libelle_categorie";
}
function fonction14(){
    $query = "SELECT titre
FROM recette
WHERE categorie_recette = 'Plat'";
}
?>