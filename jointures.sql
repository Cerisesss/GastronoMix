//affiche le texte des étapes pour une recette
select id_recette, titre, nom_etape, texte_etape from recette, etape where id_etape = id_recette order by id_recette asc;

//Pour une recette, sortir tous les noms des ingrédients qui la compose
select id_recette, titre, image_recette, image_ingredient, nom from recette, ingredient where id_recette = 1;

//Pour une recette, sortir tous les matériels 
select id_recette, titre, image_recette, id_materiel, libelle_materiel from recette, materiel where id_recette = 1;
