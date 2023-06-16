INSERT INTO unite(libelle_unite) VALUES('kg');
INSERT INTO unite(libelle_unite) VALUES('L');
INSERT INTO unite(libelle_unite) VALUES('c. à café');
INSERT INTO unite(libelle_unite) VALUES('c. à soupe');
INSERT INTO unite(libelle_unite) VALUES('pincée');
INSERT INTO unite(libelle_unite) VALUES('gousse');
INSERT INTO unite(libelle_unite) VALUES('verre');
INSERT INTO unite(libelle_unite) VALUES('pièce');

INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(1, 1, 0.25);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(1, 2, 0.25);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(1, 3, 3);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(1, 4, 0.4);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(1, 15, 0.3);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(2, 5, 0.5);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(2, 6, 0.4);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(2, 7, 0.5);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(2, 8, 1);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(3, 9, 1);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(3, 10, 3);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(3, 5, 0.1);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(4, 11, 0.25);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(4, 12, 1);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(4, 13, 1);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(5, 14, 0.5);
INSERT INTO quantite(id_recette, id_ingredient, quantite) VALUES(5, 15, 0.2);
 
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('\Images\fraise.jpg'), 'Fraise' , 'Fraise', 'Fruits', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('\Images\lait.jpg'), 'Lait/Lactose' , 'Lait', 'Produits laitiers', 2);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('\Images\oeuf.jpg'), 'Oeuf' , 'Oeuf', 'Produits laitiers', 8);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('\Images\farine.jpg'), 'Gluten' , 'Farine', 'Céréales', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('\Images\Carotte.jpg'), 'Carotte' , 'Carotte', 'Légumes', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Tomate.jpg'), 'Tomate' , 'Tomate', 'Fruits', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\HaricotVert.jpg'), 'Haricot' , 'Haricot vert', 'Légumineuse', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Poulet.jpg'), 'Poulet' , 'Poulet', 'Viande', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\HaricotRouge.jpg'), 'Haricot' , 'Haricot rouge', 'Légumineuse', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Porc.jpg'), 'Porc' , 'Porc', 'Viande', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\PorcHache.jpg'), 'Porc' , 'Porc haché', 'Viande', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Aubergine.jpg'), 'Aubergine' , 'Aubergine', 'Légumes', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Ail.jpg'), 'Ail' , 'Ail', 'Légumes', 6);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Orange.jpg'), 'Orange' , 'Orange', 'Fruits', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite) VALUES(LOAD_FILE('C:\Images\Sucre.jpg'), 'Sucre' , 'Sucre', 'Glucide', 1);

INSERT INTO materiel(libelle_materiel) VALUES ('casserole'); 
INSERT INTO materiel(libelle_materiel) VALUES ('cuillere'); 
INSERT INTO materiel(libelle_materiel) VALUES ('couteau'); 
INSERT INTO materiel(libelle_materiel) VALUES ('planche'); 
INSERT INTO materiel(libelle_materiel) VALUES ('poêle'); 
INSERT INTO materiel(libelle_materiel) VALUES ('fouet'); 
INSERT INTO materiel(libelle_materiel) VALUES ('four'); 
INSERT INTO materiel(libelle_materiel) VALUES ('fourchette'); 
INSERT INTO materiel(libelle_materiel) VALUES ('passoire'); 
INSERT INTO materiel(libelle_materiel) VALUES ('batteur électrique'); 
INSERT INTO materiel(libelle_materiel) VALUES ('saladier'); 
INSERT INTO materiel(libelle_materiel) VALUES ('pressoir'); 
INSERT INTO materiel(libelle_materiel) VALUES ('verre');

insert into user(nom_user, prenom_user, pseudo_user, mail_user, date_user, tel_user, password_user) 
VALUES('Achour', 'Souhila', 'sousou', 'sachour@et.intechinfo.fr','2023-05-16','06.34.56.32','password');
insert into user(nom_user, prenom_user, pseudo_user, mail_user, date_user, tel_user, password_user)  
VALUES('Pedra', 'Lea', 'puck', 'pedra@et.intechinfo.fr','2023-05-17','06.65.87.09' ,'mot');
insert into user(nom_user, prenom_user, pseudo_user, mail_user, date_user, tel_user, password_user) 
VALUES('Ding', 'Celive', 'sylvie', 'ding@et.intechinfo.fr','2023-05-18','06.35.12.95','motpass');

insert into pays(nom_pays, abrev_pays) VALUES('France','FRA');
insert into pays(nom_pays, abrev_pays) VALUES('Algerie','DZA');
insert into pays(nom_pays, abrev_pays) VALUES('Portugal','PRT');
insert into pays(nom_pays, abrev_pays) VALUES('Chine','CHN');
insert into pays(nom_pays, abrev_pays) VALUES('Coree du sud','KOR');
insert into pays(nom_pays, abrev_pays) VALUES('Japon','JPN');
insert into pays(nom_pays, abrev_pays) VALUES('Italie','ITA');
insert into pays(nom_pays, abrev_pays) VALUES('Espagne','ESP');
insert into pays(nom_pays, abrev_pays) VALUES('Chili','CHL');
insert into pays(nom_pays, abrev_pays) VALUES('Angleterre','UK');
insert into pays(nom_pays, abrev_pays) VALUES('Etat-Unis','USA');
insert into pays(nom_pays, abrev_pays) VALUES('Inde','IND');
insert into pays(nom_pays, abrev_pays) VALUES('Russie','RUS');
insert into pays(nom_pays, abrev_pays) VALUES('Allemagne','GER');

insert into categorie(libelle_categorie) VALUES('entree');
insert into categorie(libelle_categorie) VALUES('Plat');
insert into categorie(libelle_categorie) VALUES('Dessert');
insert into categorie(libelle_categorie) VALUES('Boisson');

INSERT INTO recette(titre, source, date_recette, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte, id_user, id_pays, id_categorie) 
VALUES ('Gateau fraise', 'Personne', '2023-05-16', 'Dessert', 'https://', 2, 30, 30, 3, 1, '', 3); 
INSERT INTO recette(titre, source, date_recette, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte, id_user, id_pays, id_categorie) 
VALUES ('Couscous', 'Souhila', '2023-06-17', 'Plat', 'https://', 4, 30, 30, 2, 1, 2, 2); 
INSERT INTO recette(titre, source, date_recette, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte, id_user, id_pays, id_categorie) 
VALUES ('Feijoada', 'Lea', '2023-06-17', 'Plat', 'https://', 4, 30, 30, 2, 2, 3, 2); 
INSERT INTO recette(titre, source, date_recette, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte, id_user, id_pays, id_categorie) 
VALUES ('Aubergine sautée', 'Celive', '2023-06-17', 'Plat', '\Images\aubergineSautee.jpg', 2, 30, 30, 1, 3, 4, 2); 
INSERT INTO recette(titre, source, date_recette, categorie_recette, image_recette, nb_personne, temps_prep_recette, temps_total_recette, difficulte, id_user, id_pays, id_categorie) 
VALUES ('Jus d`orange', 'Personne', '2023-06-17', 'Boisson', 'https://', 4, 0, 30, 0, 2, '', 4); 

INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 1);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 2);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 3);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 4);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 6);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 7);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 9);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 10);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (1, 11);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (2, 1);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (2, 2);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (2, 3);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (2, 8);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (2, 11);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (3, 1);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (3, 3);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (3, 4);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (3, 8);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (3, 11);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (4, 3);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (4, 4);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (4, 5);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (4, 8);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (5, 2);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (5, 3);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (5, 4);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (5, 12);
INSERT INTO recette_materiel(id_recette, id_materiel) VALUES (5, 13);

INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (1, 'Mélanger dans un saladier les ingrédients les un après les autres', 1); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (2, 'Laver les fraises et les couper en morceaux.', 1); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (3, 'Manger le tout.', 1); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (1, 'Faire cuire le couscous a la vapeur.', 2); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (2, 'Faire la sauce.', 2); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (3, 'Melanger les deux.', 2); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (1, 'Faire cuir la viande pendant 20 minutes.', 3); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (2, 'Ajouter les haricots.', 3); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (3, 'Deguster.', 3); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (1, 'Laver et couper les aubergines et l`ail en cube.', 4); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (2, 'Faire cuire le tout pendant 20 minutes.', 4); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (1, 'Laver les oranges et les presser.', 5); 
INSERT INTO etape(id_etape, texte_etape, id_recette) VALUES (2, 'Mettre le jus dans un verre et ajouter le sucre.', 5); 

insert into historique(avis_historique, id_user, id_recette) VALUES(5, 1, 1);
insert into historique(avis_historique, id_user, id_recette) VALUES(3, 2, 1);
insert into historique(avis_historique, id_user, id_recette) VALUES(1, 2, 3);

insert into favoris(id_user, id_recette) VALUES(1, 1);
insert into favoris(id_user, id_recette) VALUES(1, 2);
insert into favoris(id_user, id_recette) VALUES(2, 3);
