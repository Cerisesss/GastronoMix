INSERT INTO unite(libelle_unite) VALUES('kg');
INSERT INTO unite(libelle_unite) VALUES('L');
INSERT INTO unite(libelle_unite) VALUES('c. à café');
INSERT INTO unite(libelle_unite) VALUES('c. à soupe');
INSERT INTO unite(libelle_unite) VALUES('pincée');
INSERT INTO unite(libelle_unite) VALUES('gousse');
INSERT INTO unite(libelle_unite) VALUES('verre');

INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\fraise.jpg'), 'Fraise' , 'Fraise', 'Fruits', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\lait.jpg'), 'Lait/Lactose' , 'Lait', 'Produits laitiers', 2);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\oeuf.jpg'), 'Oeuf' , 'Oeuf', 'Produits laitiers', null);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Gluten' , 'Farine', 'Céréales', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Carotte' , 'Carotte', 'Légumes', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Tomate' , 'Tomate', 'Fruits', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Haricot' , 'Haricot vert', 'Légumineuse', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Poulet' , 'Poulet', 'Viande', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Haricot' , 'Haricot rouge', 'Légumineuse', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Porc' , 'Porc', 'Viande', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Porc' , 'Porc haché', 'Viande', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Aubergine' , 'Aubergine', 'Légumes', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Ail' , 'Ail', 'Légumes', 6);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Orange' , 'Orange', 'Fruits', 1);
INSERT INTO ingredient(image_ingredient, allergie_ingredient, nom_ingredient, categorie_ingredient, id_unite, id_recette) VALUES(LOAD_FILE('C:\Images\farine.jpg'), 'Sucre' , 'Sucre', 'Glucide', 1);

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

insert into categorie(libelle_categorie, sous_categorie) VALUES('entree','null');
insert into categorie(libelle_categorie, sous_categorie) VALUES('plat','pays');
insert into categorie(libelle_categorie, sous_categorie) VALUES('dessert','pays');
insert into categorie(libelle_categorie, sous_categorie) VALUES('boisson','sans alcool, avec alcool');
insert into categorie(libelle_categorie, sous_categorie) VALUES('aperitif','null');

INSERT INTO recette(titre, date_recette, categorie_recette, description_recette, image_recette, nb_personne, temps_prep_recette, temps_cui_recette, temps_repos_recette, id_user, id_pays, id_categorie) 
VALUES ('Gateau fraise', '2023-05-16', 'Dessert', 'Bon gateau aux fraises miam miam', 'https://', 2, 30, 30, 0, 1, null, 3); 
INSERT INTO recette(titre, date_recette, categorie_recette, description_recette, image_recette, nb_personne, temps_prep_recette, temps_cui_recette, temps_repos_recette, id_user, id_pays, id_categorie) 
VALUES ('Couscous', '2023-06-17', 'Plat', 'Plat traditionnel Algerien', 'https://', 4, 30, 30, 0, 1, 2, 2); 
INSERT INTO recette(titre, date_recette, categorie_recette, description_recette, image_recette, nb_personne, temps_prep_recette, temps_cui_recette, temps_repos_recette, id_user, id_pays, id_categorie) 
VALUES ('Feijoada', '2023-06-17', 'Plat', 'Un excellent plat portugais/bresilien', 'https://', 4, 30, 30, 0, 2, 3, 2); 
INSERT INTO recette(titre, date_recette, categorie_recette, description_recette, image_recette, nb_personne, temps_prep_recette, temps_cui_recette, temps_repos_recette, id_user, id_pays, id_categorie) 
VALUES ('Aubergine sautée', '2023-06-17', 'Plat', 'Un petit plat asiatique de qualite', 'https://', 4, 30, 30, 0, 2, 4, 2); 
INSERT INTO recette(titre, date_recette, categorie_recette, description_recette, image_recette, nb_personne, temps_prep_recette, temps_cui_recette, temps_repos_recette, id_user, id_pays, id_categorie) 
VALUES (`Jus d'orange`, '2023-06-17', 'Boisson', `Jus d'orange non industriel`, 'https://', 4, 0, 0, 30, 3, null, 4); 

INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('1', '1', 'Mélanger dans un saladier les ingrédients les un après les autres'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('1', '2', 'Laver les fraises et les couper en morceaux.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('1', '3', 'Manger le tout.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('2', '1', 'Faire cuire le couscous a la vapeur.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('2', '2', 'Faire la sauce.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('2', '3', 'Melanger les deux.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('3', '1', 'Faire cuir la viande pendant 20 minutes.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('3', '2', 'Ajouter les haricots.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('3', '3', 'Deguster.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('4', '1', `Laver et couper les aubergines et l'ail en cube.`); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('4', '2', 'Faire cuire le tout pendant 20 minutes.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('5', '1', 'Laver les oranges et les presser.'); 
INSERT INTO etape(id_etape, nom_etape, texte_etape) VALUES ('5', '2', 'Mettre le jus dans un verre et ajouter le sucre.'); 

insert into historique(avis_historique, favori_historique) VALUES(5, 1);
insert into historique(avis_historique, favori_historique) VALUES(3, 4);
insert into historique(avis_historique, favori_historique) VALUES(1, 3);










