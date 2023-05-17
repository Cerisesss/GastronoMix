DROP TABLE IF EXISTS user;
CREATE TABLE user (
    id_compte BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_compte VARCHAR(50),
    prenom_compte VARCHAR(50),
    pseudo_compte VARCHAR(50),
    mail_compte VARCHAR(50),
    date_compte date,
    tel_compte VARCHAR(50),
    password_compte VARCHAR(50)
);

DROP TABLE IF EXISTS recette;
CREATE TABLE recette (
    id_recette BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    titre VARCHAR(50),
    date_recette DATE,
    categorie_recette VARCHAR(50),
    description_recette VARCHAR(50),
    image_recette VARCHAR(50),
    nb_personne_recette BIGINT,
    id_c_categorie **NOT FOUND**,
);

DROP TABLE IF EXISTS etape;
CREATE TABLE etape (
    id_etape BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_etape VARCHAR(50),
    texte_etape VARCHAR(400)
);


DROP TABLE IF EXISTS ingredient;
CREATE TABLE ingredient (
    id_ingredient BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    image_ingredient VARCHAR(50),
    allergie_ingredient VARCHAR(50), 
    nom VARCHAR(50),
    categorieI_ingredient VARCHAR(50)
);


DROP TABLE IF EXISTS unite;
CREATE TABLE unite (
    id_unite BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    libelle_unite VARCHAR(50),
);

//
 DROP TABLE IF EXISTS unite ; 

DROP TABLE IF EXISTS historique ; 
CREATE TABLE historique (id_historique BIGINT AUTO_INCREMENT NOT NULL, avis_historique VARCHAR, favori_historique BIGINT, PRIMARY KEY (id_historique)) ENGINE=InnoDB;  

DROP TABLE IF EXISTS categorie ; 
CREATE TABLE categorie (id_c_categorie BIGINT AUTO_INCREMENT NOT NULL, libelle_categorie VARCHAR, sous_categorie_categorie VARCHAR, PRIMARY KEY (id_c_categorie)) ENGINE=InnoDB;  

DROP TABLE IF EXISTS materiel ; 
CREATE TABLE materiel (id_materiel BIGINT AUTO_INCREMENT NOT NULL, libelle_materiel VARCHAR, PRIMARY KEY (id_materiel)) ENGINE=InnoDB;  

DROP TABLE IF EXISTS Pays ; 
CREATE TABLE Pays (id_pays BIGINT AUTO_INCREMENT NOT NULL, nom VARCHAR, abrev_Pays VARCHAR, PRIMARY KEY (id_pays)) ENGINE=InnoDB;  

DROP TABLE IF EXISTS possede ; 
CREATE TABLE possede (id_historique **NOT FOUND** AUTO_INCREMENT NOT NULL, id_recette **NOT FOUND** NOT NULL, PRIMARY KEY (id_historique,  id_recette)) ENGINE=InnoDB;

//



DROP TABLE IF EXISTS produit ;
CREATE TABLE produit (
    id_produit BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    quantite_produit BIGINT,
    nb_personne_produit BIGINT,
    libelle_produit VARCHAR(50)
);
    

DROP TABLE IF EXISTS historique;
CREATE TABLE historique (
    id_historique BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    avis_historique VARCHAR(50),
    favori_historique BIGINT
);

DROP TABLE IF EXISTS categorie;
CREATE TABLE categorie (
    id_c_categorie BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    libelle_categorie VARCHAR(50),
    sous_categorie VARCHAR(50)
);

DROP TABLE IF EXISTS pays;
CREATE TABLE pays (
    id_pays BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nom_pays VARCHAR(50)
);
    
DROP TABLE IF EXISTS materiel;
CREATE TABLE materiel (
    id_materiel BIGINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    libelle_materiel VARCHAR(50)
);

DROP TABLE IF EXISTS transforme;
CREATE TABLE transforme (
    id_produit BIGINT AUTO_INCREMENT NOT NULL,
    id_ingredient BIGINT NOT NULL,
    PRIMARY KEY (id_produit, id_ingredient),
    FOREIGN KEY (id_produit) REFERENCES produit (id_produit),
    FOREIGN KEY (id_ingredient) REFERENCES ingredient (id_ingredient)
);

DROP TABLE IF EXISTS possede;
CREATE TABLE possede (
    id_historique BIGINT AUTO_INCREMENT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_historique, id_recette),
    FOREIGN KEY (id_historique) REFERENCES historique (id_historique),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette)
);

DROP TABLE IF EXISTS relier;
CREATE TABLE relier (
    id_compte BIGINT AUTO_INCREMENT NOT NULL,
    id_historique BIGINT NOT NULL,
    PRIMARY KEY (id_compte, id_historique),
    FOREIGN KEY (id_compte) REFERENCES user (id_compte),
    FOREIGN KEY (id_historique) REFERENCES historique (id_historique)
);

DROP TABLE IF EXISTS consulter;
CREATE TABLE consulter (
    id_compte BIGINT AUTO_INCREMENT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_compte, id_recette),
    FOREIGN KEY (id_compte) REFERENCES user (id_compte),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette)
);

DROP TABLE IF EXISTS decompose;
CREATE TABLE decompose (
    id_etape BIGINT AUTO_INCREMENT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_etape, id_recette),
    FOREIGN KEY (id_etape) REFERENCES etape (id_etape),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette)
);

DROP TABLE IF EXISTS compose;
CREATE TABLE compose (
    id_ingredient BIGINT AUTO_INCREMENT NOT NULL,
    id_recette BIGINT NOT NULL,
    PRIMARY KEY (id_ingredient, id_recette),
    FOREIGN KEY (id_ingredient) REFERENCES ingredient (id_ingredient),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette)
);

DROP TABLE IF EXISTS utilise;
CREATE TABLE utilise (
    id_recette BIGINT AUTO_INCREMENT NOT NULL,
    id_materiel BIGINT NOT NULL,
    PRIMARY KEY (id_recette, id_materiel),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette),
    FOREIGN KEY (id_materiel) REFERENCES materiel (id_materiel)
);

DROP TABLE IF EXISTS categoriser;
CREATE TABLE categoriser (
    id_recette BIGINT NOT NULL,
    id_categorie BIGINT NOT NULL,
    PRIMARY KEY (id_recette, id_categorie),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette),
    FOREIGN KEY (id_categorie) REFERENCES categorie (id_c_categorie)
);

DROP TABLE IF EXISTS contient;
CREATE TABLE contient (
    id_recette BIGINT NOT NULL,
    id_ingredient BIGINT NOT NULL,
    PRIMARY KEY (id_recette, id_ingredient),
    FOREIGN KEY (id_recette) REFERENCES recette (id_recette),
    FOREIGN KEY (id_ingredient) REFERENCES ingredient (id_ingredient)
);

DROP TABLE IF EXISTS provient;
CREATE TABLE provient (
    id_recette NOT FOUND AUTO_INCREMENT NOT NULL,
    id_Pays NOT FOUND NOT NULL,
    PRIMARY KEY (id_recette,  id_Pays)
);

ALTER TABLE recette ADD CONSTRAINT FK_recette_id_c_categorie FOREIGN KEY (id_c_categorie) REFERENCES categorie (id_c_categorie);
ALTER TABLE unite ADD CONSTRAINT FK_unite_ingredient_id_ingredient FOREIGN KEY (ingredient_id_ingredient) REFERENCES ingredient (id_ingredient); 
ALTER TABLE transforme ADD CONSTRAINT FK_transforme_id_produit FOREIGN KEY (id_produit) REFERENCES produit (id_produit); 
ALTER TABLE transforme ADD CONSTRAINT FK_transforme_id_ingredient FOREIGN KEY (id_ingredient) REFERENCES ingredient (id_ingredient); 
ALTER TABLE possede ADD CONSTRAINT FK_possede_id_historique FOREIGN KEY (id_historique) REFERENCES historique (id_historique); 
ALTER TABLE possede ADD CONSTRAINT FK_possede_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE relier ADD CONSTRAINT FK_relier_id_compte FOREIGN KEY (id_compte) REFERENCES user (id_compte);
ALTER TABLE relier ADD CONSTRAINT FK_relier_id_historique FOREIGN KEY (id_historique) REFERENCES historique (id_historique);
ALTER TABLE consulter ADD CONSTRAINT FK_consulter_id_compte FOREIGN KEY (id_compte) REFERENCES user (id_compte);
ALTER TABLE consulter ADD CONSTRAINT FK_consulter_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE decompose ADD CONSTRAINT FK_decompose_id_etape FOREIGN KEY (id_etape) REFERENCES etape (id_etape);
ALTER TABLE decompose ADD CONSTRAINT FK_decompose_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE compose ADD CONSTRAINT FK_compose_id_ingredient FOREIGN KEY (id_ingredient) REFERENCES ingredient (id_ingredient);
ALTER TABLE compose ADD CONSTRAINT FK_compose_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE utilise ADD CONSTRAINT FK_utilise_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE utilise ADD CONSTRAINT FK_utilise_id_materiel FOREIGN KEY (id_materiel) REFERENCES materiel (id_materiel);
ALTER TABLE provient ADD CONSTRAINT FK_provient_id_recette FOREIGN KEY (id_recette) REFERENCES recette (id_recette);
ALTER TABLE provient ADD CONSTRAINT FK_provient_id_pays FOREIGN KEY (id_pays) REFERENCES Pays (id_pays);