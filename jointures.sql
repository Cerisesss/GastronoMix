//affiche le texte des étapes pour une recette
SELECT id_recette, titre, nom_etape, texte_etape FROM recette, etape WHERE id_etape = id_recette ORDER BY id_recette ASC;

Jointure : 
SELECT r.id_recette, r.titre, e.nom_etape, e.texte_etape, e.id_etape FROM recette r 
JOIN etape e ON e.id_etape = r.id_recette
ORDER BY r.id_recette ASC;



//Pour une recette, sortir tous les noms des ingrédients qui la compose
SELECT id_recette, titre, image_recette, image_ingredient, nom FROM recette, ingredient WHERE id_recette = 1;

Jointure :
SELECT r.id_recette, r.titre, r.image_recette, i.image_ingredient, i.nom FROM recette r
JOIN ingredient i ON i.id_ingredient = r.id_recette
WHERE id_recette = 1;



//Pour une recette, sortir tous les matériels 
SELECT id_recette, titre, image_recette, id_materiel, libelle_materiel FROM recette, materiel WHERE id_recette = 1;

Jointure :
SELECT r.id_recette, r.titre, r.image_recette, m.id_materiel, m.libelle_materiel FROM recette r
JOIN materiel m ON m.id_materiel = r.id_recette
WHERE id_recette = 1;



//ajoute pour id_recette = 1
INSERT INTO decompose (id_etape, id_recette)
SELECT 
    (SELECT id_etape FROM etape WHERE id_etape = 1 LIMIT 1),
    (SELECT id_recette FROM recette WHERE id_recette = 1 LIMIT 1);

    
//ajoute pour toute les recettes 
INSERT INTO decompose (id_etape, id_recette)
SELECT 
    (SELECT id_etape FROM etape LIMIT 1),
    (SELECT id_recette FROM recette LIMIT 1);


