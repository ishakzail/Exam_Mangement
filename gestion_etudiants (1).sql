-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 30 jan. 2021 à 12:46
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_etudiants`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motdepass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `Foreign key` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`email`, `motdepass`, `role_id`, `id`) VALUES
('admin@admin.com', 'admin', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id_etud` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motdepass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filiere` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  PRIMARY KEY (`id_etud`),
  KEY `id_role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etud`, `nom`, `prenom`, `email`, `motdepass`, `filiere`, `role_id`) VALUES
(15, 'Zail', 'Ishak', 'ishak.zail@gmail.com', '$2y$10$FMTjIfFzzGACHGEvoM7mdeWAlewl.2/5lM1k2S6LWR/T3wNJy6LWW', 'WM', 2),
(18, 'Zail', 'Ismael', 'zail.ismail@gmail.com', '$2y$10$OWX9ZrjB1Qmub8EHJJPqE.qUJDSQFwoMQ5dG0jGQ4A6BTKw/DgU7q', 'WM', 2);

-- --------------------------------------------------------

--
-- Structure de la table `examen`
--

DROP TABLE IF EXISTS `examen`;
CREATE TABLE IF NOT EXISTS `examen` (
  `id_exam` int NOT NULL AUTO_INCREMENT,
  `date_exam` date NOT NULL,
  `mat_id` int NOT NULL,
  PRIMARY KEY (`id_exam`),
  KEY `Foreign key` (`mat_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `examen`
--

INSERT INTO `examen` (`id_exam`, `date_exam`, `mat_id`) VALUES
(4, '2020-08-03', 6),
(5, '2021-01-01', 3),
(7, '2020-10-04', 3),
(8, '2019-01-26', 4);

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

DROP TABLE IF EXISTS `matiere`;
CREATE TABLE IF NOT EXISTS `matiere` (
  `id_mat` int NOT NULL AUTO_INCREMENT,
  `nom_mat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `semestre` int NOT NULL,
  PRIMARY KEY (`id_mat`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`id_mat`, `nom_mat`, `semestre`) VALUES
(1, 'Base de données', 3),
(3, 'Dev Mobile', 3),
(4, 'Contrôle de gestion', 3),
(5, 'Comptabilité', 3),
(6, 'Langue & Communications', 3),
(7, 'M1', 3);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

DROP TABLE IF EXISTS `note`;
CREATE TABLE IF NOT EXISTS `note` (
  `id_etud` int DEFAULT NULL,
  `id_mat` int DEFAULT NULL,
  `noteMat` int NOT NULL,
  KEY `Key1` (`id_etud`),
  KEY `Key2` (`id_mat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_etud`, `id_mat`, `noteMat`) VALUES
(18, 1, 14),
(18, 3, 18),
(18, 4, 17),
(18, 5, 18),
(18, 6, 18),
(18, 7, 18),
(15, 1, 17),
(15, 3, 17),
(15, 4, 18),
(15, 5, 15),
(15, 6, 16),
(15, 7, 19);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `nom_role`) VALUES
(1, 'ADMIN'),
(2, 'ETUDIANT');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `Foreign key` FOREIGN KEY (`role_id`) REFERENCES `role` (`id_role`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `id_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id_role`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `mat_id` FOREIGN KEY (`mat_id`) REFERENCES `matiere` (`id_mat`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `Key1` FOREIGN KEY (`id_etud`) REFERENCES `etudiant` (`id_etud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Key2` FOREIGN KEY (`id_mat`) REFERENCES `matiere` (`id_mat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
