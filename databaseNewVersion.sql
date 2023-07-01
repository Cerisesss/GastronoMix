DROP DATABASE IF EXISTS GastronoMix;

CREATE DATABASE GastronoMix;

USE GastronoMix;


DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` bigint NOT NULL AUTO_INCREMENT,
  `libelle_categorie` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `etape`;
CREATE TABLE IF NOT EXISTS `etape` (
  `id_etape` bigint NOT NULL,
  `texte_etape` varchar(500) DEFAULT NULL,
  `id_recette` bigint NOT NULL,
  KEY `fk_etape_recette_id` (`id_recette`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id_favori` bigint NOT NULL AUTO_INCREMENT,
  `id_user` bigint NOT NULL,
  `id_recette` bigint NOT NULL,
  PRIMARY KEY (`id_favori`),
  KEY `fk_favoris_recette_id` (`id_recette`),
  KEY `fk_favoris_user_id` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `historique`;
CREATE TABLE IF NOT EXISTS `historique` (
  `id_historique` bigint NOT NULL AUTO_INCREMENT,
  `avis_historique` bigint DEFAULT NULL,
  `id_user` bigint NOT NULL,
  `id_recette` bigint NOT NULL,
  PRIMARY KEY (`id_historique`),
  KEY `fk_historique_recette_id` (`id_recette`),
  KEY `fk_historique_user_id` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `id_ingredient` bigint NOT NULL AUTO_INCREMENT,
  `nom_ingredient` varchar(500) DEFAULT NULL,
  `ingredients_recherche` varchar(500) DEFAULT NULL,
  `id_unite` int NOT NULL,
  PRIMARY KEY (`id_ingredient`),
  KEY `fk_unite_id` (`id_unite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `quantite`;
CREATE TABLE IF NOT EXISTS `quantite` (
  `id_recette` bigint NOT NULL,
  `id_ingredient` bigint NOT NULL,
  `quantite` float DEFAULT NULL,
  KEY `fk_quantite_recette_id` (`id_recette`),
  KEY `fk_quantite_ingredient_id` (`id_ingredient`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id_recette` bigint NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) DEFAULT NULL,
  `source` varchar(50) DEFAULT NULL,
  `categorie_recette` varchar(50) DEFAULT NULL,
  `image_recette` varchar(500) DEFAULT NULL,
  `nb_personne` varchar(50) DEFAULT NULL,
  `temps_prep_recette` time NOT NULL DEFAULT '00:00:00',
  `temps_total_recette` time DEFAULT '00:00:00',
  `difficulte` varchar(50) DEFAULT NULL,
  `id_user` bigint NOT NULL,
  `id_categorie` bigint NOT NULL,
  PRIMARY KEY (`id_recette`),
  KEY `fk_recette_user_id` (`id_user`),
  KEY `fk_recette_categorie_id` (`id_categorie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `unite`;
CREATE TABLE IF NOT EXISTS `unite` (
  `id_unite` bigint NOT NULL AUTO_INCREMENT,
  `libelle_unite` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_unite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` bigint NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(50) DEFAULT NULL,
  `prenom_user` varchar(50) DEFAULT NULL,
  `pseudo_user` varchar(50) DEFAULT NULL,
  `mail_user` varchar(50) DEFAULT NULL,
  `tel_user` varchar(50) DEFAULT NULL,
  `password_user` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
COMMIT;
