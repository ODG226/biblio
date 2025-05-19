-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 19 mai 2025 à 12:20
-- Version du serveur : 9.1.0
-- Version de PHP : 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_biblio`
--

-- --------------------------------------------------------

--
-- Structure de la table `emprunts`
--

DROP TABLE IF EXISTS `emprunts`;
CREATE TABLE IF NOT EXISTS `emprunts` (
  `id_emprunt` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `id_livre` int DEFAULT NULL,
  `date_emprunt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_retour` datetime DEFAULT NULL,
  `date_retour_prevu` datetime NOT NULL,
  PRIMARY KEY (`id_emprunt`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_livre` (`id_livre`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `emprunts`
--

INSERT INTO `emprunts` (`id_emprunt`, `id_utilisateur`, `id_livre`, `date_emprunt`, `date_retour`, `date_retour_prevu`) VALUES
(1, 3, 24, '2024-09-15 20:14:56', '2024-09-22 20:14:56', '0000-00-00 00:00:00'),
(2, 9, 25, '2025-05-16 17:34:17', '2025-05-23 17:34:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `id_genre` int NOT NULL AUTO_INCREMENT,
  `nom_genre` varchar(100) NOT NULL,
  PRIMARY KEY (`id_genre`),
  UNIQUE KEY `nom_genre` (`nom_genre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `historique_emprunts`
--

DROP TABLE IF EXISTS `historique_emprunts`;
CREATE TABLE IF NOT EXISTS `historique_emprunts` (
  `id_historique` int NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int DEFAULT NULL,
  `id_livre` int DEFAULT NULL,
  `date_emprunt` datetime NOT NULL,
  `date_retour` datetime NOT NULL,
  PRIMARY KEY (`id_historique`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_livre` (`id_livre`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `historique_emprunts`
--

INSERT INTO `historique_emprunts` (`id_historique`, `id_utilisateur`, `id_livre`, `date_emprunt`, `date_retour`) VALUES
(1, 1, 16, '2024-09-10 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 20, '2024-09-10 00:00:00', '2024-09-17 00:00:00'),
(3, 1, 20, '2024-09-10 00:00:00', '2024-09-17 00:00:00'),
(4, 1, 19, '2024-09-10 00:00:00', '2024-09-17 00:00:00'),
(5, 1, 16, '2024-09-10 00:00:00', '2024-09-17 00:00:00'),
(6, 1, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(7, 1, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(8, 1, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(9, NULL, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(10, 1, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(11, 5, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(12, 5, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(13, NULL, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(14, 5, 19, '2024-09-11 00:00:00', '2024-09-18 00:00:00'),
(15, 5, 22, '2024-09-14 00:00:00', '2024-09-21 00:00:00'),
(16, 5, 24, '2024-09-14 00:00:00', '2024-09-21 00:00:00'),
(17, 5, 24, '2024-09-14 09:00:00', '1970-01-01 00:00:00'),
(18, 5, 24, '2024-09-14 09:57:49', '2024-09-21 09:57:49'),
(19, 5, 24, '2024-09-14 10:47:00', '2024-09-21 10:47:00'),
(20, 5, 24, '2024-09-15 18:48:32', '2024-09-22 18:48:32'),
(21, NULL, 23, '2024-09-15 18:57:23', '2024-09-22 18:57:23'),
(22, NULL, 23, '2024-09-15 19:01:20', '2024-09-22 19:01:20'),
(23, 3, 23, '2024-09-15 19:02:26', '2024-09-22 19:02:26'),
(24, 3, 23, '2024-09-15 20:13:11', '2024-09-22 20:13:11'),
(25, 3, 23, '2024-09-15 20:13:46', '2024-09-15 20:13:46'),
(26, 3, 24, '2024-09-15 20:13:55', '2024-09-22 20:13:55'),
(27, 3, 24, '2024-09-15 20:14:56', '2024-09-22 20:14:56'),
(28, 9, 25, '2025-05-16 17:34:17', '2025-05-23 17:34:17');

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

DROP TABLE IF EXISTS `livres`;
CREATE TABLE IF NOT EXISTS `livres` (
  `id_livre` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `annee_publication` year DEFAULT NULL,
  `resume` text,
  `image` varchar(255) NOT NULL,
  `nb_exemplaires` int NOT NULL,
  PRIMARY KEY (`id_livre`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id_livre`, `titre`, `auteur`, `genre`, `annee_publication`, `resume`, `image`, `nb_exemplaires`) VALUES
(22, 'sous l\'orage', 'sembene ousmane', 'histoire', '1950', 'hfthf jyggy jugjug jhjhv ', 'upload/OIP (14).jpeg', 0),
(23, 'L\'ENFANT NOIR', 'Camare LAYE', 'Biographie', '1950', 'HFDCUYHFUJHYFK', 'upload/R (7).jpeg', 0),
(24, 'Une si longue lettre', 'Mairama BA', 'amour', '1936', 'KJJK KJKJ KJHK KHKJ LKJL', 'upload/41vUkspKeML.jpg', 1),
(25, 'La princesse AFRICAINE', 'Christel MOUCHARRD', 'histoire', '2030', 'jhnj io lk im,  l;k,.', 'upload/R (4).jpeg', 0),
(26, 'Les sept douleurs', 'William Aristide Nassidia COMBARY', 'Recueil', '2016', 'jhg yfgyu uyfgyu uyguy byugy yufg yugyu yg ', 'upload/R (5).jpeg', 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','utilisateur') NOT NULL,
  `date_inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `date_inscription`) VALUES
(1, 'edeef', 'efed', 'hujhuk@gmail.com', '$2y$10$yNXKtRSPM6//nvR2mwVZYeLquzCsZLvz8bP489VxOdK9vZLrAFqsi', 'utilisateur', '2024-09-04 09:29:07'),
(3, 'DA', 'Mahamadou', 'oud@gmail.com', '$2y$10$ZjQNdKO8q1yfIJ01Qhqql.BFUvvAgfmJsiI/8O3xIRT8CogWpmNsa', 'utilisateur', '2024-09-14 00:00:00'),
(5, 'Super', 'Admin', 'admin@example.com', '$2b$12$B3Qn1TVoH.9/1eJaRYEaM.nmgibHc8r/3kE0BsXehE5LiLe7WXrjq', 'admin', '2024-09-04 18:03:12'),
(6, 'Yaro', 'Boukare', 'yaro@gmail.com', '$2y$10$i0ET530GQ6SI5dKk2K6lru0Yty/.mCQCeOVHYelV8xERCJj/k3XLO', 'admin', '2024-09-09 23:05:09'),
(7, 'ouedraogo', 'jacob', 'oudrao@gmail.com', '$2y$10$fgHyc8QqHmf5pFZsGLV0GO0ZZU3Xx.GCeniyBuHsihc90uSFy6D3a', 'utilisateur', '2024-09-11 00:20:02'),
(8, 'admin', 'admin', 'admin@gmail.bf', '123456789', '', '2025-03-11 18:08:49'),
(9, 'Mahamadou', 'OUEDRAOGO', 'mahoued226@gmail.com', '$2y$10$AQyTmfJZ9K/KV9luiPLY1.mV0dB7fFz3ZHf2YVKY2HODtpkq0HcxO', 'admin', '2025-05-16 17:33:26'),
(10, 'admin', 'admin', 'admin@admin.com', 'admin', 'admin', '2025-05-19 12:18:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
