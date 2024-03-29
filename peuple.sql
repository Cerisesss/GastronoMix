INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(1, 1, 0.25, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(1, 2, 0.25, 2);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(1, 3, 3, null);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(1, 4, 0.4, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(1, 15, 0.3, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(2, 5, 0.5, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(2, 6, 0.4, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(2, 7, 0.5, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(2, 8, 1, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(3, 9, 1, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(3, 10, 3, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(3, 5, 0.1, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(4, 11, 0.25, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(4, 12, 1, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(4, 13, 1, 6);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(5, 14, 0.5, 1);
INSERT INTO compose(id_recette, id_ingredient, quantite_compose, id_unite) VALUES(5, 15, 0.2, 1);

INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 1);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 2);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 3);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 4);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 6);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 7);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 9);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 10);
INSERT INTO utilise (id_recette, id_materiel) VALUES (1, 11);
INSERT INTO utilise (id_recette, id_materiel) VALUES (2, 1);
INSERT INTO utilise (id_recette, id_materiel) VALUES (2, 2);
INSERT INTO utilise (id_recette, id_materiel) VALUES (2, 3);
INSERT INTO utilise (id_recette, id_materiel) VALUES (2, 8);
INSERT INTO utilise (id_recette, id_materiel) VALUES (2, 11);
INSERT INTO utilise (id_recette, id_materiel) VALUES (3, 1);
INSERT INTO utilise (id_recette, id_materiel) VALUES (3, 3);
INSERT INTO utilise (id_recette, id_materiel) VALUES (3, 4);
INSERT INTO utilise (id_recette, id_materiel) VALUES (3, 8);
INSERT INTO utilise (id_recette, id_materiel) VALUES (3, 11);
INSERT INTO utilise (id_recette, id_materiel) VALUES (4, 3);
INSERT INTO utilise (id_recette, id_materiel) VALUES (4, 4);
INSERT INTO utilise (id_recette, id_materiel) VALUES (4, 5);
INSERT INTO utilise (id_recette, id_materiel) VALUES (4, 8);
INSERT INTO utilise (id_recette, id_materiel) VALUES (5, 2);
INSERT INTO utilise (id_recette, id_materiel) VALUES (5, 3);
INSERT INTO utilise (id_recette, id_materiel) VALUES (5, 4);
INSERT INTO utilise (id_recette, id_materiel) VALUES (5, 12);
INSERT INTO utilise (id_recette, id_materiel) VALUES (5, 13);

INSERT INTO decompose (id_etape, id_recette) VALUES ();

INSERT INTO categoriser(id_categorie, id_recette) VALUES (1, 1);
INSERT INTO categoriser(id_categorie, id_recette) VALUES (1, 1);
INSERT INTO categoriser(id_categorie, id_recette) VALUES (1, 1);
INSERT INTO categoriser(id_categorie, id_recette) VALUES (1, 1);

