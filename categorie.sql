insert into categorie( id_categorie, libelle_categorie,sous_categorie) VALUES('5','plats','sans//');
insert into categorie( id_categorie, libelle_categorie,sous_categorie) VALUES('13','dessert','sans/');
insert into categorie( id_categorie, libelle_categorie,sous_categorie) VALUES('2','boisson','sans///');

update categorie set libelle_categorie = 'entree' where id_categorie = 2;
update categorie set sous_categorie = 'sans' where id_categorie = 5;
