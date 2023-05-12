DROP TABLE IF EXISTS Menu ;
CREATE TABLE Menu (
    aperitif BIGINT PRIMARY KEY,
    entree BIGINT,
    plat BIGINT,
    dessert BIGINT,
    boisson BIGINT,
    mode_sombre BIGINT
);
    
DROP TABLE IF EXISTS Compte;
CREATE TABLE Compte (
    profil BIGINT PRIMARY KEY,
    favoris BIGINT,
    avis BIGINT,
    deconnexion BIGINT
);
    
DROP TABLE IF EXISTS Recherche_avance;
CREATE TABLE Recherche_avance (
    mots_cles BIGINT PRIMARY KEY,
    categorie BIGINT,
    allergie BIGINT,
    produit_possede BIGINT
);

DROP TABLE IF EXISTS Accueil;
CREATE TABLE Accueil (
    categorie VARCHAR(50),
    nom_recette VARCHAR(50)
);

DROP TABLE IF EXISTS Recette;
CREATE TABLE Recette (
    nom_recette BIGINT PRIMARY KEY,
    avis BIGINT,
    images BIGINT,
    ajouter_favoris BIGINT,
    partage BIGINT,
    imprimer BIGINT,
    temps_realisation BIGINT,
    niveau_difficulte BIGINT,
    ingredients BIGINT,
    materiel BIGINT,
    preparation BIGINT
);
    
DROP TABLE IF EXISTS Liste_recette;
CREATE TABLE Liste_recette (
    nom_recette BIGINT PRIMARY KEY,
    image_recette BIGINT
);