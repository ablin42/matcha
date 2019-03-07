-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  jeu. 07 mars 2019 à 15:04
-- Version du serveur :  5.7.23
-- Version de PHP :  7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `matcha`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mail_token` varchar(128) DEFAULT NULL,
  `confirmed_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `mail_token`, `confirmed_token`) VALUES
(1, 'harbinger', '410c6628072476812f42e4414553bae859ab984667f5250883143ff5380bf8a14552bef191998368eeef1b35e1bb52f05d47301a65c0f620def1d2dd7b6c4de7', 'Space6fic@gmail.com', 'ovukh3jkacs6van2ui5fpy1irc8yhrnns09x7t0rpbrotjdgejzo248sc0wb9ku903q13mazha5dim7vmagocprsuc4c8f9nrjzjhdzla18yhjkipl9e2xo6j1ryiash', NULL),
(4, 'harbinger42', '410c6628072476812f42e4414553bae859ab984667f5250883143ff5380bf8a14552bef191998368eeef1b35e1bb52f05d47301a65c0f620def1d2dd7b6c4de7', 'ablin42@byom.de', 'NULL', '2019-02-28 21:59:02'),
(5, 'harbinger43', '410c6628072476812f42e4414553bae859ab984667f5250883143ff5380bf8a14552bef191998368eeef1b35e1bb52f05d47301a65c0f620def1d2dd7b6c4de7', 'ablin43@byom.de', 'NULL', '2019-02-28 22:03:42');

-- --------------------------------------------------------

--
-- Structure de la table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bio` varchar(512) NOT NULL,
  `gender` varchar(128) NOT NULL,
  `orientation` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `bio`, `gender`, `orientation`) VALUES
(8, 4, 'inclusive', 'Agender', 'Lesbian');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
