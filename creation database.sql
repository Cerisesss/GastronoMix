DROP TABLE IF EXISTS user;
CREATE TABLE user (
    id_user BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_user VARCHAR(50),
    prenom_user VARCHAR(50),
    pseudo_user VARCHAR(50),
    mail_user VARCHAR(50),
    date_user date,
    tel_user VARCHAR(50),
    password_user VARCHAR(50)
);
    
DROP TABLE IF EXISTS recette;
CREATE TABLE recette (
    id_recette BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    titre VARCHAR(50),
    date_recette DATE,
    categorie_recette VARCHAR(50),
    description_recette VARCHAR(50),
    image_recette VARCHAR(50),
    nb_personne BIGINT,
    temps_prep_recette TIME NOT NULL,
    temps_cui_recette TIME NULL DEFAULT '00:00:00',
    temps_repos_recette TIME NULL DEFAULT '00:00:00'
);

DROP TABLE IF EXISTS etape;
CREATE TABLE etape (
    id_etape BIGINT NOT NULL,
    nom_etape VARCHAR(50),
    texte_etape VARCHAR(400)
);


DROP TABLE IF EXISTS ingredient;
CREATE TABLE ingredient (
    id_ingredient BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    image_ingredient VARCHAR(50),
    allergie_ingredient VARCHAR(50), 
    nom_ingredient VARCHAR(50),
    categorieI_ingredient VARCHAR(50)
);

DROP TABLE IF EXISTS unite;
CREATE TABLE unite (
    id_unite BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    libelle_unite VARCHAR(50)
);

DROP TABLE IF EXISTS historique;
CREATE TABLE historique (
    id_historique BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    avis_historique BIGINT,
    favori_historique BIGINT
);

DROP TABLE IF EXISTS categorie;
CREATE TABLE categorie (
    id_categorie BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    libelle_categorie VARCHAR(50),
    sous_categorie VARCHAR(50)
);

DROP TABLE IF EXISTS pays;
CREATE TABLE pays (
    id_pays BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_pays VARCHAR(50),
    abrev_pays VARCHAR(50)
);
    
DROP TABLE IF EXISTS materiel;
CREATE TABLE materiel (
    id_materiel BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    libelle_materiel VARCHAR(50)
); 

DROP TABLE IF EXISTS possede;
CREATE TABLE possede (
    id_historique BIGINT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_historique, id_recette)
);

DROP TABLE IF EXISTS relier;
CREATE TABLE relier (
    id_user BIGINT  NOT NULL,
    id_historique BIGINT NOT NULL,
    PRIMARY KEY (id_user, id_historique)
);

DROP TABLE IF EXISTS consulter;
CREATE TABLE consulter (
    id_user BIGINT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_user, id_recette)
);

DROP TABLE IF EXISTS decompose;
CREATE TABLE decompose (
    id_etape BIGINT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_recette)
);

DROP TABLE IF EXISTS categoriser;
CREATE TABLE categoriser (
    id_categorie BIGINT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_categorie, id_recette)
);

DROP TABLE IF EXISTS compose;
CREATE TABLE compose (
    id_recette BIGINT NOT NULL,
    id_ingredient BIGINT NOT NULL,
    quantite_compose BIGINT,
    id_unite BIGINT,
    PRIMARY KEY (id_ingredient, id_recette)
);

DROP TABLE IF EXISTS utilise;
CREATE TABLE utilise (
    id_recette BIGINT NOT NULL,
    id_materiel BIGINT NOT NULL,
    PRIMARY KEY (id_recette, id_materiel)
);

DROP TABLE IF EXISTS provient;
CREATE TABLE provient (
    id_recette BIGINT NOT NULL,
    id_Pays BIGINT NOT NULL,
    PRIMARY KEY (id_recette,  id_Pays)
);

ALTER TABLE possede ADD CONSTRAINT FK_possede_id_historique FOREIGN KEY (id_historique) REFERENCES historique (id_historique);
ALTER TABLE possede ADD CONSTRAINT FK_possede_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE relier ADD CONSTRAINT FK_relier_id_user FOREIGN KEY (id_user) REFERENCES user (id_user);
ALTER TABLE relier ADD CONSTRAINT FK_relier_id_historique FOREIGN KEY (id_historique) REFERENCES historique (id_historique);
ALTER TABLE consulter ADD CONSTRAINT FK_consulter_id_user FOREIGN KEY (id_user) REFERENCES user (id_user);
ALTER TABLE consulter ADD CONSTRAINT FK_consulter_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE decompose ADD CONSTRAINT FK_decompose_id_etape FOREIGN KEY (id_etape) REFERENCES etape (id_etape);
ALTER TABLE decompose ADD CONSTRAINT FK_decompose_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE categoriser ADD CONSTRAINT FK_categoriser_id_categorie FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie);
ALTER TABLE categoriser ADD CONSTRAINT FK_categoriser_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE compose ADD CONSTRAINT FK_compose_id_ingredient FOREIGN KEY (id_ingredient) REFERENCES ingredient (id_ingredient);
ALTER TABLE compose ADD CONSTRAINT FK_compose_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE utilise ADD CONSTRAINT FK_utilise_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE utilise ADD CONSTRAINT FK_utilise_id_materiel FOREIGN KEY (id_materiel) REFERENCES materiel (id_materiel);
ALTER TABLE provient ADD CONSTRAINT FK_provient_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE provient ADD CONSTRAINT FK_provient_id_pays FOREIGN KEY (id_pays) REFERENCES Pays (id_pays);
