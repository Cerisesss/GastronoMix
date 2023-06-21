DROP DATABASE IF EXISTS GastronoMix;

CREATE DATABASE GastronoMix;

USE GastronoMix;

CREATE TABLE IF NOT EXISTS `unite` (
    `id_unite` BIGINT NOT NULL AUTO_INCREMENT,
    `libelle_unite` VARCHAR(50) NULL,
    PRIMARY KEY (`id_unite`)
);

CREATE TABLE IF NOT EXISTS `quantite` (
    `id_recette` BIGINT NOT NULL,
    `id_ingredient` BIGINT NOT NULL,
    `quantite` FLOAT,
    CONSTRAINT `fk_quantite_recette_id`
        FOREIGN KEY (`id_recette`)
        REFERENCES `recette` (`id_recette`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_quantite_ingredient_id`
        FOREIGN KEY (`id_ingredient`)
        REFERENCES `ingredient` (`id_ingredient`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `ingredient` (
    `id_ingredient` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `image_ingredient` VARCHAR(500) NULL,
    `allergie_ingredient` VARCHAR(100) NULL,
    `nom_ingredient` VARCHAR(500) NULL,
    `categorie_ingredient` VARCHAR(100) NULL,
    `id_unite` INT NOT NULL,
    CONSTRAINT `fk_unite_id`
        FOREIGN KEY (`id_unite`)
        REFERENCES `unite` (`id_unite`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `materiel` (
    `id_materiel` INT NOT NULL AUTO_INCREMENT,
    `libelle_materiel` VARCHAR(100) NULL,
    PRIMARY KEY (`id_materiel`)
);

CREATE TABLE IF NOT EXISTS `user` (
    `id_user` BIGINT NOT NULL AUTO_INCREMENT,
    `nom_user` VARCHAR(50) NULL,
    `prenom_user` VARCHAR(50) NULL,
    `pseudo_user` VARCHAR(50) NULL,
    `mail_user` VARCHAR(100) NULL,
    `date_user` DATE NULL,
    `tel_user` VARCHAR(50) NULL,
    `password_user` VARCHAR(50) NULL,
    PRIMARY KEY (`id_user`)
);

CREATE TABLE IF NOT EXISTS `pays` (
    `id_pays` BIGINT NOT NULL AUTO_INCREMENT,
    `nom_pays` VARCHAR(50) NULL,
    `abrev_pays` VARCHAR(50) NULL,
    PRIMARY KEY (`id_pays`)
);

CREATE TABLE IF NOT EXISTS `categorie` (
    `id_categorie` BIGINT NOT NULL AUTO_INCREMENT,
    `libelle_categorie` VARCHAR(50) NULL,
    PRIMARY KEY (`id_categorie`)
);

CREATE TABLE IF NOT EXISTS `recette` (
    `id_recette` BIGINT NOT NULL AUTO_INCREMENT,
    `titre` VARCHAR(100) NULL,
    `source` VARCHAR(50) NULL,
    `date_recette` DATE NULL,
    `categorie_recette` VARCHAR(50) NULL,
    `image_recette` VARCHAR(500) NULL,
    `nb_personne` VARCHAR(50) NULL,
    `temps_prep_recette` TIME NOT NULL DEFAULT '00:00:00',
    `temps_total_recette` TIME NULL DEFAULT '00:00:00',
    `difficulte` VARCHAR(50) NULL,
    `id_user` BIGINT NOT NULL,
    `id_pays` BIGINT NOT NULL,
    `id_categorie` BIGINT NOT NULL,
    PRIMARY KEY (`id_recette`),
    
    CONSTRAINT `fk_recette_user_id`
        FOREIGN KEY (`id_user`)
        REFERENCES `user` (`id_user`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_recette_pays_id`
        FOREIGN KEY (`id_pays`)
        REFERENCES `pays` (`id_pays`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_recette_categorie_id`
        FOREIGN KEY (`id_categorie`)
        REFERENCES `categorie` (`id_categorie`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `recette_materiel` (
    `id_recette` BIGINT NOT NULL,
    `id_materiel` INT NOT NULL,
    CONSTRAINT `fk_recette_materiel_recette_id`
        FOREIGN KEY (`id_recette`)
        REFERENCES `recette` (`id_recette`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_recette_materiel_materiel_id`
        FOREIGN KEY (`id_materiel`)
        REFERENCES `materiel` (`id_materiel`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    PRIMARY KEY (`id_recette`, `id_materiel`)
);

CREATE TABLE IF NOT EXISTS `etape` (
    `id_etape` BIGINT NOT NULL,
    `texte_etape` VARCHAR(500) NULL,
    `id_recette` BIGINT NOT NULL,
    CONSTRAINT `fk_etape_recette_id`
        FOREIGN KEY (`id_recette`)
        REFERENCES `recette` (`id_recette`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `historique` (
    `id_historique` BIGINT NOT NULL AUTO_INCREMENT,
    `avis_historique` BIGINT NULL,
    `id_user` BIGINT NOT NULL,
    `id_recette` BIGINT NOT NULL,
    PRIMARY KEY (`id_historique`),
    CONSTRAINT `fk_historique_recette_id`
        FOREIGN KEY (`id_recette`)
        REFERENCES `recette` (`id_recette`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_historique_user_id`
        FOREIGN KEY (`id_user`)
        REFERENCES `user` (`id_user`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);


CREATE TABLE IF NOT EXISTS `favoris` (
    `id_favori` BIGINT NOT NULL AUTO_INCREMENT,
    `id_user` BIGINT NOT NULL,
    `id_recette` BIGINT NOT NULL,
    PRIMARY KEY (`id_favori`),
    CONSTRAINT `fk_favoris_recette_id`
        FOREIGN KEY (`id_recette`)
        REFERENCES `recette` (`id_recette`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_favoris_user_id`
        FOREIGN KEY (`id_user`)
        REFERENCES `user` (`id_user`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
);
