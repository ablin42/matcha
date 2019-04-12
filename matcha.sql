-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 12 avr. 2019 à 10:57
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

--
-- Déchargement des données de la table `block`
--

INSERT INTO `block` (`id`, `id_blocker`, `id_blocked`) VALUES
(1, 6, 10),
(2, 6, 11);

-- --------------------------------------------------------

--
-- Structure de la table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `roomid` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chat`
--

INSERT INTO `chat` (`id`, `roomid`, `user_id`, `username`, `message`, `date`) VALUES
(2, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 6, 'Kiwyz', 'asfasfasf', '2019-04-09 00:00:00'),
(3, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 6, 'Kiwyz', 'death knows no boundaries', '2019-04-09 00:00:00'),
(4, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 'Secaly', 'I concur', '2019-04-09 00:00:00'),
(5, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 'Secaly', 'asfafsfsf', '2019-04-09 23:59:04'),
(6, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 6, 'Kiwyz', 'WEW lad', '2019-04-09 23:59:04'),
(7, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 'Secaly', 'okay', '2019-04-10 00:00:01'),
(8, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 'Secaly', 'ui', '2019-04-10 00:25:16'),
(9, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 'Secaly', 'oof', '2019-04-10 00:39:59'),
(10, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 'Secaly', 'oof', '2019-04-10 00:40:05'),
(11, '2e8f10aebdce7f9429b4a7efda777af403cc154903b0771232', 6, 'Kiwyz', 'death', '2019-04-10 18:31:20'),
(12, '2e8f10aebdce7f9429b4a7efda777af403cc154903b0771232', 4, 'harbinger42', 'dumb shit', '2019-04-10 20:14:34'),
(13, '646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 6, 'Kiwyz', 'kug', '2019-04-11 18:27:02');

-- --------------------------------------------------------

--
-- Structure de la table `chatroom`
--

CREATE TABLE `chatroom` (
  `roomid` varchar(50) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chatroom`
--

INSERT INTO `chatroom` (`roomid`, `user1_id`, `user2_id`) VALUES
('2e8f10aebdce7f9429b4a7efda777af403cc154903b0771232', 6, 4),
('646bd6c94ccaee3e1d93ada771852f3c56f105648a95b7ec4b', 8, 6);

-- --------------------------------------------------------

--
-- Structure de la table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `id_notifier` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notif`
--

INSERT INTO `notif` (`id`, `id_notifier`, `user_id`, `type`, `body`, `date`) VALUES
(29, 0, 1, 'like', '<a href=\'profile?u=Kiwyz\'>Kiwyz</a> liked your profile', '2019-04-09 16:22:39'),
(30, 6, 5, 'like', '<a href=\'profile?u=Kiwyz\'>Kiwyz</a> liked your profile', '2019-04-09 16:22:39'),
(32, 6, 5, 'visit', '<a href=\'profile?u=Harbinger43\'>Harbinger43</a> <b>visited</b> your profile', '2019-04-09 17:01:35'),
(33, 6, 1, 'visit', '<a href=\'profile?u=Harbinger\'>Harbinger</a> <b>visited</b> your profile', '2019-04-11 18:26:17'),
(137, 6, 4, 'message', '<a href=\'profile?u=Kiwyz\'>Kiwyz</a> <b>sent</b> you a message!', '2019-04-10 18:31:20'),
(140, 4, 8, 'visit', '<a href=\'profile?u=Secaly\'>Secaly</a> <b>visited</b> your profile', '2019-04-10 20:03:06'),
(144, 6, 4, 'visit', '<a href=\'profile?u=Harbinger42\'>Harbinger42</a> <b>visited</b> your profile', '2019-04-10 20:25:47'),
(146, 6, 8, 'message', '<a href=\'profile?u=Kiwyz\'>Kiwyz</a> <b>sent</b> you a message!', '2019-04-11 18:27:02'),
(147, 8, 6, 'visit', '<a href=\'profile?u=Kiwyz\'>Kiwyz</a> <b>visited</b> your profile', '2019-04-12 18:07:50'),
(148, 8, 6, 'like', '<b>Match! </b><a href=\'profile?u=Secaly\'>Secaly</a> <b>liked</b> your profile back! You can now <b>message eachother</b>!', '2019-04-12 18:07:49'),
(149, 8, 11, 'visit', '<a href=\'profile?u=Tabtest\'>Tabtest</a> <b>visited</b> your profile', '2019-04-12 19:30:44');

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
(12, 8, 6),
(13, 6, 1);

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
(1, 'Harbinger', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'Space6fic1@byom.de', 'NULL', '2019-04-05 19:22:22', NULL),
(4, 'harbinger42', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'ablin42@byom.de', NULL, '2019-02-28 21:59:02', NULL),
(5, 'harbinger43', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'ablin43@byom.de', NULL, '2019-02-28 22:03:42', NULL),
(6, 'Kiwyz', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'kiwyz@byom.de', 'NULL', '2019-04-10 22:58:46', NULL),
(7, 'johndoe', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'johndoe@byom.de', 'NULL', '2019-03-22 20:02:49', NULL),
(8, 'Secaly', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'secaly42@byom.de', 'NULL', '2019-03-25 18:42:35', NULL),
(9, 'Space6Fic', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'Space6Fic@byom.de', NULL, '2019-03-27 20:17:23', NULL),
(10, 'asff', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'asff@byom.de', 'NULL', '2019-03-29 20:15:13', NULL),
(11, 'tabtest', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'tabtest@byom.de', 'NULL', '2019-04-01 19:42:27', NULL),
(13, 'granma67', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'granma67@byom.de', 'NULL', '2019-04-04 20:42:33', NULL),
(14, 'crashtest', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'crashtest@byom.de', NULL, '2019-04-10 08:26:27', NULL),
(15, 'aaaa', 'ac487e1212b849e370931cff6c3b36f32df7e5e97e87024fb5bccf389353eb5338e9b3571c6930e0c770c930de09c15bf3935add173adedea6a10cc5dcd3381b', 'aaaa@byom.de', '66ymzasxbw7rl608lvpyy2tw95wrt2uemob90gien8a1kcrjor0eopjsy046s7y6uyodzza4ml14xzs5qvx56w36r9m4wncvurl097hwoo1gye118gibh70ihwi41emy', NULL, NULL);

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
(8, 4, 'Andreas', 'Dogezz', 1998, 'extremely inclusived', 'Male', 'Heterosexual', '2019-04-10 20:14:45'),
(9, 6, 'Antonio', 'Marijuanga', 1992, 'je suisfdfs un petit khey qui boit de l\'eau', 'Male', 'Bisexual', '2019-04-11 18:38:03'),
(10, 7, 'Johnny', 'TikTokDoe', 1995, 'autiste\n\nautodiag\n\ndas', 'Female', 'Heterosexual', '2019-04-05 19:26:54'),
(11, 8, 'Kévin', 'Secaly', 1990, 'je suis un pedophile', 'Female', 'Bisexual', '2019-04-12 19:56:55'),
(12, 9, 'Andreas', 'Blin', 1998, 'men fou', 'Female', 'Homosexual', '2019-04-05 19:28:19'),
(13, 10, 'asdad', 'asdasd', 1999, 'im a fag', 'Male', 'Bisexual', '2019-04-05 19:29:13'),
(14, 11, 'tab', 'test', 1999, 'furfag', 'Female', 'Bisexual', '2019-04-05 19:29:42'),
(16, 13, 'OG', 'lord', 1967, 'dsaadafasfa', 'Female', 'Heterosexual', '2019-04-11 00:15:48'),
(17, 1, 'Andreas', 'Blin', 1998, 'dark overlord', 'Male', 'Heterosexual', '2019-04-05 21:47:15'),
(18, 5, 'Doombringer', 'Zedaar', 1997, 'les petits bras de micron', 'Female', 'Bisexual', '2019-04-05 21:47:15'),
(19, 14, 'trysha', 'crashito', 1984, 'i suck', 'Male', 'Bisexual', '2019-04-10 18:12:02'),
(20, 15, 'aaaaa', 'aaaaaa', 1999, NULL, NULL, 'Bisexual', '2019-04-11 00:27:50');

-- --------------------------------------------------------

--
-- Structure de la table `user_location`
--

CREATE TABLE `user_location` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_location`
--

INSERT INTO `user_location` (`id`, `user_id`, `lat`, `lng`) VALUES
(1, 6, 48.8581, 2.30968),
(2, 13, 48.8543, 2.3527),
(3, 8, 48.8848, 2.30213),
(4, 1, 48.8416, 2.29492),
(5, 4, 48.8703, 2.31758),
(6, 5, 48.8918, 2.40959),
(7, 7, 48.8326, 2.35672),
(8, 9, 48.8791, 2.33509),
(9, 10, 48.8613, 2.24617),
(10, 11, 48.8622, 2.45251),
(11, 14, 48.8475, 2.30316),
(12, 15, 48.8568, 2.34573);

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
(6, 6, 'photos/ewu1an7t6un7eyw279zb8e8nhqtzpbuh5mkwwyex.jpeg', NULL, NULL, NULL, 'photos/7csz1n96qnddgnetkd1o73uejprltho77k6to871.jpg'),
(7, 8, 'photos/lwzemhxwo4qex7tj8fbs74i0wfcf01b8405g3ipv.jpeg', NULL, NULL, NULL, NULL),
(8, 1, 'photos/kbso9psw97qqpj5y3ky6u87harywjavfkdtzlqu4.png', NULL, NULL, NULL, NULL),
(9, 10, 'photos/ouuql2xgum330wvdm2216j43rssonpf0bwyvcsve.jpeg', NULL, NULL, NULL, NULL),
(10, 5, 'photos/1ih1mnr0f1rjg5qy9wih73k87nu4zx9ewl1vju7l.png', NULL, NULL, NULL, NULL),
(11, 9, 'photos/za3x27b9pec1h92wy205b0fav9nfxuzr18dycwof.jpeg', NULL, NULL, NULL, NULL),
(12, 11, 'photos/3zvl6lzl171lqeiyoy3ve4k4m7s4dkmyfoxwfncy.jpeg', NULL, NULL, NULL, NULL),
(13, 14, 'photos/03dwhpa2cx93jht18nzn7q1tqpdgh73n3b3nqp3a.png', NULL, NULL, NULL, NULL),
(14, 13, 'photos/nfherhylxze4ho24ck3z8spzgo7jlcdfhsvqaxn4.jpeg', NULL, NULL, NULL, NULL);

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
(32, 1, 'sport'),
(33, 1, 'video games'),
(34, 1, 'animals'),
(35, 1, 'complots'),
(36, 4, 'sport'),
(37, 5, 'complots'),
(38, 5, 'video games'),
(39, 9, 'antispecist'),
(40, 9, 'video games'),
(41, 11, 'animals'),
(42, 14, 'animals'),
(47, 13, 'grandfathers');

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
(3, 6, 7, '2019-04-05 19:07:37'),
(4, 6, 8, '2019-04-11 18:37:03'),
(5, 10, 8, '2019-03-31 18:59:51'),
(6, 8, 6, '2019-04-12 18:07:50'),
(7, 8, 8, '2019-04-01 17:05:04'),
(8, 6, 10, '2019-04-05 21:54:57'),
(9, 6, 11, '2019-04-05 21:54:59'),
(10, 6, 4, '2019-04-10 20:25:47'),
(11, 4, 6, '2019-04-10 20:14:20'),
(12, 6, 1, '2019-04-11 18:26:17'),
(13, 6, 5, '2019-04-09 17:01:35'),
(14, 6, 6, '2019-04-10 18:14:38'),
(15, 4, 4, '2019-04-10 20:05:19'),
(16, 4, 8, '2019-04-10 20:03:06'),
(17, 8, 11, '2019-04-12 19:30:44');

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
(16, 3, 6, 1, '2019-03-22 13:20:23'),
(17, 2, 6, 1, '2019-03-12 12:29:28'),
(18, 4, 6, 1, '2019-03-27 07:24:36'),
(19, 1, 6, -1, '2019-03-28 15:25:34'),
(20, 6, 7, 1, '2019-03-28 06:21:20'),
(22, 7, 6, 1, '2019-03-28 06:19:20'),
(104, 6, 8, 1, '2019-03-31 16:59:39'),
(105, 1, 10, 1, '2019-04-02 05:20:19'),
(106, 4, 10, 1, '2019-04-02 05:20:19'),
(107, 1, 7, 1, '2019-03-28 06:19:20'),
(108, 5, 10, 1, '2019-03-28 06:19:20'),
(128, 6, 5, 1, '2019-04-09 17:01:33'),
(213, 6, 1, -1, '2019-04-11 18:26:20'),
(228, 6, 4, 1, '2019-04-09 19:07:42'),
(231, 7, 13, 1, '2019-04-10 00:00:00'),
(232, 8, 13, 1, '2019-04-10 00:00:00'),
(233, 8, 6, 1, '2019-04-12 18:07:49');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chatroom`
--
ALTER TABLE `chatroom`
  ADD PRIMARY KEY (`roomid`);

--
-- Index pour la table `notif`
--
ALTER TABLE `notif`
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
-- Index pour la table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT pour la table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user_photo`
--
ALTER TABLE `user_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `user_tags`
--
ALTER TABLE `user_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `visit`
--
ALTER TABLE `visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
