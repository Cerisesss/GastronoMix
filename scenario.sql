--marche*******

--le texte des étapes -> pour les recettes
SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape FROM recette r 
JOIN etape e ON e.id_recette = r.id_recette
ORDER BY r.id_recette ASC;


--le texte des étapes -> pour recette = 1
SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape FROM recette r 
JOIN etape e ON e.id_recette = r.id_recette
WHERE r.id_recette = 1;


--le texte des étapes -> pour titre = 'Jus d`orange'
SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape FROM recette r 
JOIN etape e ON e.id_recette = r.id_recette
WHERE r.titre = 'Jus d`orange';


--le texte des étapes pour les recettes -> pour etape = 1
SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape FROM recette r 
JOIN etape e ON e.id_recette = r.id_recette
WHERE e.id_etape = 1;


--le texte des étapes pour les recettes -> pour recette = 1
SELECT r.id_recette, r.titre, e.id_etape, e.nom_etape, e.texte_etape FROM recette r 
JOIN etape e ON e.id_recette = r.id_recette
WHERE e.nom_etape = 'Cuisson';


--les noms des ingrédients qui la compose une recette -> pour recette = 1
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
WHERE r.id_recette = 1;



--les noms des ingrédients qui la compose une recette -> pour titre = 'gateau fraise'
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
WHERE r.titre = 'gateau fraise';


--les recettes qui contient un ingredient -> pour id_ingredient = 15;
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
WHERE q.id_ingredient = 15;


--les noms des ingrédients, quantite et l'unite qui compose la recette (avec l'id) -> pour recette = 1
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite
WHERE r.id_recette = 1;


--les noms des ingrédients, quantite et l'unite qui compose la recette -> pour titre = "feijoada"
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite
WHERE r.titre = "feijoada";


--Affiche les recettes qui utilise un ingrédient en particulier (avec l'id) -> pour id_ingredient = 15
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite
WHERE q.id_ingredient = 15 ;


--Affiche les recettes qui utilise un ingrédient en particulier -> pour nom_ingredient = "Carotte"
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite
WHERE i.nom_ingredient = "Carotte";


--Affiche les recettes en utilisant les unites -> pour libelle_unite = "kg"
SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite
WHERE u.libelle_unite = "kg";


--Affiche les materiels qui compose la recette -> pour recette = 1
SELECT r.id_recette, r.titre, r.image_recette, rm.id_materiel, libelle_materiel FROM recette r
JOIN recette_materiel rm ON rm.id_recette = r.id_recette
JOIN materiel m ON m.id_materiel = rm.id_materiel
WHERE r.id_recette = 1;


--Affiche les materiels qui compose la recette en cherchant avec le tire de la recette -> pour titre = "aubergine sautee"
SELECT r.id_recette, r.titre, r.image_recette, rm.id_materiel, libelle_materiel FROM recette r
JOIN recette_materiel rm ON rm.id_recette = r.id_recette
JOIN materiel m ON m.id_materiel = rm.id_materiel
WHERE r.titre = "aubergine sautee";


--Affiche les materiels -> pour id_materiel = 1
SELECT r.id_recette, r.titre, r.image_recette, rm.id_materiel, libelle_materiel FROM recette r
JOIN recette_materiel rm ON rm.id_recette = r.id_recette
JOIN materiel m ON m.id_materiel = rm.id_materiel
WHERE rm.id_materiel = 1;


--Affiche les materiels -> pour libelle_materiel = "couteau"
SELECT r.id_recette, r.titre, r.image_recette, rm.id_materiel, libelle_materiel FROM recette r
JOIN recette_materiel rm ON rm.id_recette = r.id_recette
JOIN materiel m ON m.id_materiel = rm.id_materiel
WHERE libelle_materiel = "couteau";


--Affiche les recettes et tous les materiels qui la compose -> pour libelle_materiel = "couteau"
SELECT r.id_recette, r.titre, r.image_recette, rm.id_materiel, libelle_materiel FROM recette r
JOIN recette_materiel rm ON rm.id_recette = r.id_recette
JOIN materiel m ON m.id_materiel = rm.id_materiel;


--Affiche le nom d'un ingrédient, sa categorie et son unité -> pour ingrédient = farine
SELECT i.nom_ingredient, i.categorie_ingredient, un.libelle_unite FROM ingredient i
JOIN unite un ON i.id_unite = un.id_unite
WHERE i.nom_ingredient = 'farine';

SELECT r.id_recette, r.titre, r.image_recette, q.id_ingredient, i.nom_ingredient, q.quantite, u.libelle_unite
FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite
WHERE r.id_recette IN (
    SELECT q2.id_recette
    FROM quantite q2
    JOIN ingredient i2 ON i2.id_ingredient = q2.id_ingredient
    WHERE i2.nom_ingredient IN ("Carotte", "Poulet")
    GROUP BY q2.id_recette
    HAVING COUNT(DISTINCT i2.nom_ingredient) = 2
);



--Affiche les ingrédients faisant partie d'une categorie -> pour categorie = légumes
SELECT i.nom_ingredient, i.categorie_ingredient, un.libelle_unite FROM ingredient i
JOIN unite un ON i.id_unite = un.id_unite
WHERE i.categorie_ingredient = 'Légumes';


--Affiche le nom d'un ingrédient, sa categorie et son unité -> pour unite = gousse
SELECT i.nom_ingredient, i.categorie_ingredient, un.libelle_unite FROM ingredient i
JOIN unite un ON i.id_unite = un.id_unite
WHERE un.libelle_unite = 'gousse';


--Affiche les recettes avec tous les ingrédients qui la compose
SELECT r.titre, i.nom_ingredient, q.quantite, u.libelle_unite FROM recette r
JOIN quantite q ON q.id_recette = r.id_recette
JOIN ingredient i ON i.id_ingredient = q.id_ingredient
JOIN unite u ON u.id_unite = i.id_unite;


--Affiche la liste d'ingredients avec son unite
SELECT i.id_ingredient, i.nom_ingredient, u.libelle_unite FROM ingredient i
JOIN unite u ON i.id_unite = u.id_unite;


--Affiche la liste d'user avec leur historique et favoris
SELECT u.id_user, u.nom_user, u.prenom_user, u.password_user, h.avis_historique, h.favori_historique, id_recette FROM user u
JOIN historique h ON u.id_user = h.id_user;


--Affiche la liste d'user avec leur historique
SELECT u.id_user, u.nom_user, u.prenom_user, u.password_user, h.avis_historique, id_recette FROM user u
JOIN historique h ON u.id_user = h.id_user;


--Affiche la liste d'user avec leur favoris
SELECT u.id_user, u.nom_user, u.prenom_user, u.password_user, h.favori_historique FROM user u
JOIN historique h ON u.id_user = h.id_user;


--Affiche les recettes qui ont un "pays" 
SELECT p.id_pays, p.nom_pays, r.id_recette, r.titre, r.categorie_recette
FROM pays p
JOIN recette r ON p.id_pays = r.id_pays;


--Affiche les recettes et les categories
SELECT r.id_recette, r.titre, r.categorie_recette, r.description_recette, c.libelle_categorie FROM recette r
JOIN categorie c ON c.id_categorie = r.id_categorie;


--Affiche les recettes et les categories -> pour libelle_categorie = "plat"
SELECT r.id_recette, r.titre, r.categorie_recette, r.description_recette, c.libelle_categorie FROM recette r
JOIN categorie c ON c.id_categorie = r.id_categorie
WHERE c.libelle_categorie = "plat";


--Affiche les recettes et les categories -> pour id_recette = 1;
SELECT r.id_recette, r.titre, r.categorie_recette, r.description_recette, c.libelle_categorie FROM recette r
JOIN categorie c ON c.id_categorie = r.id_categorie
WHERE r.id_recette = 1;


--fin*****







