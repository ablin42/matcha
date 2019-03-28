-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  jeu. 28 mars 2019 à 15:02
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
-- Structure de la table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `reported_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `report`
--

INSERT INTO `report` (`id`, `reporter_id`, `reported_id`) VALUES
(12, 8, 6);

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
  `confirmed_token` datetime DEFAULT NULL,
  `password_token` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `mail_token`, `confirmed_token`, `password_token`) VALUES
(1, 'harbinger', '410c6628072476812f42e4414553bae859ab984667f5250883143ff5380bf8a14552bef191998368eeef1b35e1bb52f05d47301a65c0f620def1d2dd7b6c4de7', 'Space6fic@gmail.com', 'ovukh3jkacs6van2ui5fpy1irc8yhrnns09x7t0rpbrotjdgejzo248sc0wb9ku903q13mazha5dim7vmagocprsuc4c8f9nrjzjhdzla18yhjkipl9e2xo6j1ryiash', NULL, NULL),
(4, 'harbinger42', '03b2fa83d9c2ee02117b4b8f487fa290531ebe08730d9756212d77f3a895db085eb661adb55a7caeb8d46bd28928fd6e07d1ae4acff31f3c0d8f4711bc9594d1', 'ablin42@byom.de', NULL, '2019-02-28 21:59:02', NULL),
(5, 'harbinger43', '410c6628072476812f42e4414553bae859ab984667f5250883143ff5380bf8a14552bef191998368eeef1b35e1bb52f05d47301a65c0f620def1d2dd7b6c4de7', 'ablin43@byom.de', NULL, '2019-02-28 22:03:42', NULL),
(6, 'Kiwyz', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'gigatest@byom.de', NULL, '2019-03-19 21:33:22', NULL),
(7, 'johndoe', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'johndoe@byom.de', 'NULL', '2019-03-22 20:02:49', NULL),
(8, 'Secaly', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'secaly42@byom.de', 'NULL', '2019-03-25 18:42:35', NULL),
(9, 'Space6Fic', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'Space6Fic@byom.de', NULL, '2019-03-27 20:17:23', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `birth_year` year(4) DEFAULT NULL,
  `bio` varchar(512) DEFAULT NULL,
  `gender` varchar(128) DEFAULT NULL,
  `orientation` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `firstname`, `lastname`, `birth_year`, `bio`, `gender`, `orientation`) VALUES
(8, 4, 'Andreas', 'Doge', 1998, 'extremely inclusived', 'Male', 'Heterosexual'),
(9, 6, 'Antonio', 'Kiwyz', 1992, 'je suis un petit khey qui boit de l\'eau', 'Male', 'Bisexual'),
(10, 7, 'Johnny', 'TikTokDoe', 1995, 'autiste\n\nautodiag\n\ndas', 'Female', 'Heterosexual'),
(11, 8, 'Kévin', 'Secaly', 1990, 'je suis un pedophile', 'Female', 'Bisexual'),
(12, 9, 'Andreas', 'Blin', 1998, 'men fou', 'Female', 'Homosexual');

-- --------------------------------------------------------

--
-- Structure de la table `user_photo`
--

CREATE TABLE `user_photo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `photo1` varchar(255) DEFAULT NULL,
  `photo2` varchar(255) DEFAULT NULL,
  `photo3` varchar(255) DEFAULT NULL,
  `photo4` varchar(255) DEFAULT NULL,
  `photo5` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_photo`
--

INSERT INTO `user_photo` (`id`, `user_id`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(5, 4, 'photos/0hje8lloy65jw2csy4b33uh7qj0y7zflfpp2rt84.jpg', NULL, 'photos/m5vaxt741hhxsf903yxrp2ab2clhvyl1iv7asn8y.png', NULL, NULL),
(6, 6, 'photos/ewu1an7t6un7eyw279zb8e8nhqtzpbuh5mkwwyex.jpeg', NULL, 'photos/m5vaxt741hhxsf903yxrp2ab2clhvyl1iv7asn8y.png', NULL, 'photos/7csz1n96qnddgnetkd1o73uejprltho77k6to871.jpg'),
(7, 8, 'photos/1bbd9180zr51bgpljr9t3sdtz9oi5bk9gc6iub3o.jpeg', NULL, NULL, NULL, NULL),
(8, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_tags`
--

CREATE TABLE `user_tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_tags`
--

INSERT INTO `user_tags` (`id`, `user_id`, `tag`) VALUES
(11, 7, 'vegan'),
(12, 7, 'antispeciste'),
(13, 7, 'feministe'),
(16, 7, 'autodiag'),
(17, 8, 'loli'),
(18, 8, 'anime'),
(19, 8, 'savon'),
(20, 6, 'animaux'),
(21, 6, 'vegan'),
(22, 6, 'complots'),
(23, 8, 'complots');

-- --------------------------------------------------------

--
-- Structure de la table `visit`
--

CREATE TABLE `visit` (
  `id` int(11) NOT NULL,
  `id_visitor` int(11) NOT NULL,
  `id_visited` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `visit`
--

INSERT INTO `visit` (`id`, `id_visitor`, `id_visited`, `date`) VALUES
(1, 7, 6, '2019-03-27 18:15:35'),
(3, 6, 7, '2019-03-27 18:55:31'),
(4, 6, 8, '2019-03-28 18:14:21');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `id_voter` int(11) NOT NULL,
  `id_voted` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `vote`
--

INSERT INTO `vote` (`id`, `id_voter`, `id_voted`, `type`, `date`) VALUES
(8, 8, 6, 1, '2019-03-28 06:17:05'),
(16, 3, 6, 1, '2019-03-22 13:20:23'),
(17, 2, 6, 1, '2019-03-12 12:29:28'),
(18, 4, 6, 1, '2019-03-27 07:24:36'),
(19, 1, 6, -1, '2019-03-28 15:25:34'),
(20, 6, 7, 1, '2019-03-28 06:21:20'),
(21, 6, 8, 1, '2019-03-28 15:17:17'),
(22, 7, 6, 1, '2019-03-28 06:19:20');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

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
-- Index pour la table `user_photo`
--
ALTER TABLE `user_photo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`user_id`);

--
-- Index pour la table `user_tags`
--
ALTER TABLE `user_tags`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user_photo`
--
ALTER TABLE `user_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user_tags`
--
ALTER TABLE `user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
