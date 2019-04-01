-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  lun. 01 avr. 2019 à 12:51
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
-- Structure de la table `block`
--

CREATE TABLE `block` (
  `id` int(11) NOT NULL,
  `id_blocker` int(11) NOT NULL,
  `id_blocked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `id_reporter` int(11) NOT NULL,
  `id_reported` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `report`
--

INSERT INTO `report` (`id`, `id_reporter`, `id_reported`) VALUES
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
(9, 'Space6Fic', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'Space6Fic@byom.de', NULL, '2019-03-27 20:17:23', NULL),
(10, 'asff', '410c6628072476812f42e4414553bae859ab984667f5250883143ff5380bf8a14552bef191998368eeef1b35e1bb52f05d47301a65c0f620def1d2dd7b6c4de7', 'asff@byom.de', 'NULL', '2019-03-29 20:15:13', NULL),
(11, 'tabtest', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'tabtest@byom.de', 'NULL', '2019-04-01 19:42:27', NULL);

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
  `orientation` varchar(128) DEFAULT 'Bisexual',
  `last_online` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `firstname`, `lastname`, `birth_year`, `bio`, `gender`, `orientation`, `last_online`) VALUES
(8, 4, 'Andreas', 'Doge', 1998, 'extremely inclusived', 'Male', 'Heterosexual', '2019-03-31 19:47:15'),
(9, 6, 'Antonio', 'Kiwyz', 1992, 'je suis un petit khey qui boit de l\'eau', 'Male', 'Bisexual', '2019-04-01 21:51:47'),
(10, 7, 'Johnny', 'TikTokDoe', 1995, 'autiste\n\nautodiag\n\ndas', 'Female', 'Heterosexual', '2019-03-31 19:47:15'),
(11, 8, 'Kévin', 'Secaly', 1990, 'je suis un pedophile', 'Female', 'Bisexual', '2019-04-01 19:28:30'),
(12, 9, 'Andreas', 'Blin', 1998, 'men fou', 'Female', 'Homosexual', '2019-03-31 19:47:15'),
(13, 10, 'asdad', 'asdasd', 1999, 'im a fag', 'Male', 'Bisexual', '2019-03-31 19:47:15'),
(14, 11, 'tab', 'test', 1940, NULL, NULL, 'Bisexual', '2019-04-01 19:42:33');

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
(8, 1, NULL, NULL, NULL, NULL, NULL),
(9, 10, NULL, NULL, NULL, NULL, NULL);

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
(11, 7, 'veganism'),
(12, 7, 'antispecist'),
(13, 7, 'feminism'),
(16, 7, 'animals'),
(17, 8, 'loli'),
(18, 8, 'anime'),
(19, 8, 'soap'),
(20, 6, 'animals'),
(21, 6, 'veganism'),
(22, 6, 'complots'),
(23, 8, 'complots'),
(24, 10, 'loli'),
(26, 10, 'soap'),
(27, 10, 'animals'),
(28, 8, 'dofus'),
(29, 8, 'lol'),
(30, 6, 'dofus'),
(31, 6, 'lol');

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
(3, 6, 7, '2019-03-29 18:28:51'),
(4, 6, 8, '2019-04-01 17:44:24'),
(5, 10, 8, '2019-03-31 18:59:51'),
(6, 8, 6, '2019-04-01 17:13:06'),
(7, 8, 8, '2019-04-01 17:05:04');

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
(22, 7, 6, 1, '2019-03-28 06:19:20'),
(104, 6, 8, 1, '2019-03-31 16:59:39');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `block`
--
ALTER TABLE `block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `user_photo`
--
ALTER TABLE `user_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user_tags`
--
ALTER TABLE `user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
