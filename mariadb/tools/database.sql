CREATE DATABASE IF NOT EXISTS gestion_etudiants;
CREATE USER IF NOT EXISTS 'izail'@'%' IDENTIFIED BY 'izail1337';
GRANT ALL PRIVILEGES ON gestion_etudiants.* TO 'izail'@'%';
-- GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'root1337';
FLUSH PRIVILEGES;

USE gestion_etudiants;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 20 avr. 2022 à 05:54
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

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

CREATE TABLE `admin` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `motdepass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`email`, `motdepass`, `id`) VALUES
('admin@admin.com', 'admin', 1);

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id_dept` int(11) NOT NULL,
  `nom_dept` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etud` int(11) NOT NULL,
  `appogee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etudiant`
--
-- --------------------------------------------------------

--
-- Structure de la table `examen`
--

CREATE TABLE `examen` (
  `id_exam` int(11) NOT NULL,
  `date_exam` date NOT NULL,
  `mat_id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL,
  `salle_id` int(11) NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `prof_sup` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_exam` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

CREATE TABLE `filieres` (
  `id_fil` int(11) NOT NULL,
  `nom_filiere` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dept_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `filieres`
--

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `id_mat` int(11) NOT NULL,
  `nom_mat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `semestre` int(11) NOT NULL,
  `fil_id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `professeurs`
--

CREATE TABLE `professeurs` (
  `id_prof` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `professeurs`
--

-- --------------------------------------------------------

--
-- Structure de la table `professeurs_filieres`
--

CREATE TABLE `professeurs_filieres` (
  `fil_id` int(11) NOT NULL,
  `prof_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `professeurs_filieres`
--
-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(11) NOT NULL,
  `num_salle` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `type_salle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `capacite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id_dept`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etud`),
  ADD KEY `etudiant_filiere` (`fil_id`);

--
-- Index pour la table `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id_exam`),
  ADD KEY `Foreign key` (`mat_id`) USING BTREE,
  ADD KEY `prof_id` (`prof_id`),
  ADD KEY `salle_exam` (`salle_id`);

--
-- Index pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id_fil`),
  ADD KEY `dept_fil` (`dept_id`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_mat`),
  ADD KEY `filiere_matiere` (`fil_id`),
  ADD KEY `prof_matiere` (`prof_id`);

--
-- Index pour la table `professeurs`
--
ALTER TABLE `professeurs`
  ADD PRIMARY KEY (`id_prof`);

--
-- Index pour la table `professeurs_filieres`
--
ALTER TABLE `professeurs_filieres`
  ADD KEY `prof_r` (`prof_id`),
  ADD KEY `fil_r` (`fil_id`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id_dept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id_etud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `examen`
--
ALTER TABLE `examen`
  MODIFY `id_exam` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id_fil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `professeurs`
--
ALTER TABLE `professeurs`
  MODIFY `id_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_filiere` FOREIGN KEY (`fil_id`) REFERENCES `filieres` (`id_fil`);

--
-- Contraintes pour la table `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `mat_id` FOREIGN KEY (`mat_id`) REFERENCES `matiere` (`id_mat`),
  ADD CONSTRAINT `prof_id` FOREIGN KEY (`prof_id`) REFERENCES `professeurs` (`id_prof`),
  ADD CONSTRAINT `salle_exam` FOREIGN KEY (`salle_id`) REFERENCES `salle` (`id_salle`);

--
-- Contraintes pour la table `filieres`
--
ALTER TABLE `filieres`
  ADD CONSTRAINT `dept_fil` FOREIGN KEY (`dept_id`) REFERENCES `departements` (`id_dept`);

--
-- Contraintes pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD CONSTRAINT `filiere_matiere` FOREIGN KEY (`fil_id`) REFERENCES `filieres` (`id_fil`),
  ADD CONSTRAINT `prof_matiere` FOREIGN KEY (`prof_id`) REFERENCES `professeurs` (`id_prof`);

--
-- Contraintes pour la table `professeurs_filieres`
--
ALTER TABLE `professeurs_filieres`
  ADD CONSTRAINT `fil_r` FOREIGN KEY (`fil_id`) REFERENCES `filieres` (`id_fil`),
  ADD CONSTRAINT `prof_r` FOREIGN KEY (`prof_id`) REFERENCES `professeurs` (`id_prof`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
