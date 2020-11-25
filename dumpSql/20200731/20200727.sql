-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 31 juil. 2020 à 16:48
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `20200727`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

DROP TABLE IF EXISTS `auteur`;
CREATE TABLE IF NOT EXISTS `auteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id`, `nom`, `prenom`, `bio`) VALUES
(1, 'Pratchett', 'Terry', 'Il a écrit les annales du disque monde'),
(2, 'Adams', 'Douglas', 'Il a commencé en radio avec le guide du routard galactique et l\'a ensuite adapté en livre et à la télévision.\r\net aussi'),
(3, 'Gaiman', 'Neil', 'Il a écrit plein de comics et des livres.'),
(4, 'Herbert', 'Franck', 'Il a écrit Dune');

-- --------------------------------------------------------

--
-- Structure de la table `auteur_media`
--

DROP TABLE IF EXISTS `auteur_media`;
CREATE TABLE IF NOT EXISTS `auteur_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idauteur` int(11) NOT NULL,
  `idmedia` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `auteur_media`
--

INSERT INTO `auteur_media` (`id`, `idauteur`, `idmedia`) VALUES
(1, 1, 1),
(2, 2, 9),
(3, 1, 6),
(4, 1, 11),
(5, 3, 11),
(6, 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateCreate` datetime DEFAULT NULL,
  `resume` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `utilisateur_id`, `titre`, `dateCreate`, `resume`) VALUES
(1, 1, 'Au guet !', '2020-07-29 14:45:13', 'Un livre ++'),
(2, 1, 'Miroirs et fumées', '2020-07-29 14:45:23', 'Un livre'),
(3, 1, 'A la recherche du temps perdu', '2020-07-29 14:47:11', 'Un livre'),
(4, 1, 'L\'outremangeur', '2020-07-29 14:47:23', 'UNE bd inspirée par Eric cantona'),
(5, 1, 'Dune', '2020-07-29 16:14:02', 'Du sable ++'),
(6, 1, 'Les Tribulations d\'un mage en Aurient', '2020-07-29 16:14:21', 'Du terry pratchett'),
(7, 1, 'L\'empereur dieu de Dune', '2020-07-30 15:38:22', 'la suite de dune'),
(8, 1, 'Dracula (comic)', '2020-07-30 15:42:53', 'Un comics par l\'auteur de Hellboy'),
(9, 1, 'Le Guide du voyageur galactique', '2020-07-30 15:51:58', 'un livre'),
(10, 1, 'La vie, l\'univers et le reste', '2020-07-30 15:52:44', 'Un livre'),
(11, 1, 'De bons présages', '2020-07-31 11:58:51', 'coécrit par Pratchett et Gaiman');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pseudo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motdepasse` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `pseudo`, `email`, `motdepasse`) VALUES
(1, 'Duflot', 'Nicolas', 'Nico', 'nduflot@jehann.fr', '21232f297a57a5a743894a0e4a801fc3');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
