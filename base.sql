-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db737744185.db.1and1.com
-- Généré le :  Lun 18 Juin 2018 à 19:34
-- Version du serveur :  5.5.60-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db737744185`
--

-- --------------------------------------------------------

--
-- Structure de la table `difficulty`
--

CREATE TABLE IF NOT EXISTS `difficulty` (
  `id_difficulty` varchar(3) COLLATE latin1_general_ci NOT NULL,
  `nom_difficulty` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_difficulty`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `difficulty`
--

INSERT INTO `difficulty` (`id_difficulty`, `nom_difficulty`) VALUES
('EAS', 'Easy'),
('HAR', 'Hard'),
('MID', 'Intermediaire');

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id_game` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_game`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `game`
--

INSERT INTO `game` (`id_game`, `nom`) VALUES
(1, 'snake'),
(2, 'spaceInvaders'),
(3, 'demineur');

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `id` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `id_difficulty` varchar(3) COLLATE latin1_general_ci NOT NULL DEFAULT 'EAS',
  `highscore` int(11) NOT NULL,
  PRIMARY KEY (`highscore`),
  KEY `id_game` (`id_game`),
  KEY `id` (`id`),
  KEY `Fk_id_difficulty` (`id_difficulty`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `mail` text COLLATE latin1_general_ci,
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `mdp` longtext COLLATE latin1_general_ci,
  `tokenToConfirm` longtext COLLATE latin1_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=26 ;


--
-- Contraintes pour la table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `fk_id` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Fk_id_difficulty` FOREIGN KEY (`id_difficulty`) REFERENCES `difficulty` (`id_difficulty`),
  ADD CONSTRAINT `fk_id_game` FOREIGN KEY (`id_game`) REFERENCES `game` (`id_game`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
