-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2024 at 04:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hp_tunisia_jobs`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `motivation_letter_path` varchar(255) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `phone`, `address`, `profile_picture`, `cv_path`, `motivation_letter_path`, `position_id`) VALUES
(1, '0000000', 'boumhal ben arous', '/pdp/0', '/cv/0', 'motivation_lettre/0', 1),
(6, '00000000', 'sea', NULL, NULL, NULL, 2),
(7, '00000000', '00', NULL, NULL, NULL, 2),
(8, '147258367', '258', NULL, NULL, NULL, 3),
(9, '14725836', '147', 'uploads/images.jpeg', NULL, NULL, 1),
(10, NULL, 'tunis', NULL, NULL, NULL, 6),
(11, '00000000', 'qqq', 'uploads/b1682a94b483db24dcf54c09f38cafa2.jpg', 'uploads/Imed Hamdene cv.pdf', 'uploads/Motivation letter.pdf', 2),
(12, '000', 'eee', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `candidate_id` int(11) NOT NULL,
  `hr_user_id` int(11) NOT NULL,
  `meeting_time` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nature` enum('en ligne','en personne') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetings`
--

INSERT INTO `meetings` (`candidate_id`, `hr_user_id`, `meeting_time`, `created_at`, `nature`) VALUES
(11, 5, '2024-08-30 11:57:44', '2024-08-30 09:58:04', 'en ligne');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `title`, `description`, `created_at`) VALUES
(1, 'candidature spontane', 'Chez HP Tunisie, nous sommes toujours à la recherche de talents passionnés et innovants pour rejoindre notre équipe. Si vous ne trouvez pas de poste correspondant à vos compétences parmi nos offres actuelles, nous vous invitons à soumettre une candidature spontanée. Votre profil sera conservé dans notre base de données, et nous vous contacterons si une opportunité correspondant à vos qualifications se présente. Montrez-nous ce que vous pouvez apporter à notre entreprise, et ensemble, nous pourrions construire l\'avenir de la technologie.\r\n\r\n\r\n\r\n\r\n\r\n', '2024-08-23 01:33:03'),
(2, 'Ingénieur Logiciel', 'En tant qu\'Ingénieur Logiciel chez HP Tunisie, vous serez responsable du développement, des tests et de la maintenance des applications logicielles qui soutiennent notre activité. Vous collaborerez avec des équipes multidisciplinaires pour fournir des solutions innovantes répondant aux besoins de nos clients. Ce poste exige une solide compréhension des méthodologies de développement logiciel, des langages de programmation, et de bonnes compétences en résolution de problèmes.', '2024-08-23 01:33:14'),
(3, 'Chef de Projet', 'En tant que Chef de Projet chez HP Tunisie, vous superviserez la planification, l\'exécution et la livraison de projets complexes au sein de l\'organisation. Vous travaillerez en étroite collaboration avec les parties prenantes pour définir les objectifs du projet, allouer les ressources, gérer les délais et assurer le succès des projets. Ce poste nécessite d\'excellentes compétences en leadership, organisation et communication, ainsi qu\'une expérience en méthodologies de gestion de projet.', '2024-08-29 15:37:41'),
(4, 'Coordinateur Marketing', 'Le Coordinateur Marketing chez HP Tunisie est chargé de soutenir l\'équipe marketing dans l\'exécution des campagnes, la gestion des réseaux sociaux et l\'analyse des tendances du marché. Ce poste implique la création de contenu, la coordination d\'événements et la collaboration avec des partenaires externes pour promouvoir les produits et services de HP Tunisie. La créativité, l\'attention aux détails et une passion pour le marketing sont des atouts clés pour ce poste.', '2024-08-30 06:30:54'),
(5, 'Spécialiste en Ressources Humaines', 'Le Spécialiste en Ressources Humaines chez HP Tunisie joue un rôle vital dans la gestion des relations avec les employés, le recrutement et la conformité RH. Vous serez responsable de l\'acquisition de talents, de l\'intégration, de la formation et des programmes de développement des employés. Ce poste nécessite de solides compétences interpersonnelles, une connaissance des pratiques RH et la capacité de gérer des informations sensibles avec confidentialité.', '2024-08-30 06:31:33'),
(6, 'Administrateur Réseau', 'En tant qu\'Administrateur Réseau chez HP Tunisie, vous serez responsable de maintenir l\'intégrité et la sécurité de notre infrastructure réseau. Cela inclut la configuration et le support du matériel réseau, la surveillance des performances du réseau et la mise en œuvre des protocoles de sécurité. Ce poste nécessite une solide formation technique en réseaux, des compétences en résolution de problèmes et la capacité de travailler dans un environnement dynamique.', '2024-08-30 06:32:00'),
(7, 'Analyste de Données', 'L\'Analyste de Données chez HP Tunisie est responsable de la collecte, de l\'analyse et de l\'interprétation des données pour soutenir la prise de décision stratégique. Vous collaborerez avec divers départements pour identifier les besoins en données, créer des rapports et fournir des insights qui orientent la stratégie. Ce poste nécessite la maîtrise des outils d\'analyse de données, une attention particulière aux détails et la capacité de traduire les données en recommandations actionnables.', '2024-08-30 06:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `candidate_id` int(11) NOT NULL,
  `hr_user_id` int(11) NOT NULL,
  `meeting_time` datetime NOT NULL,
  `linguistic` int(11) DEFAULT NULL CHECK (`linguistic` between 0 and 10),
  `technical` int(11) DEFAULT NULL CHECK (`technical` between 0 and 10),
  `managerial` int(11) DEFAULT NULL CHECK (`managerial` between 0 and 10),
  `transversal` int(11) DEFAULT NULL CHECK (`transversal` between 0 and 10)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`candidate_id`, `hr_user_id`, `meeting_time`, `linguistic`, `technical`, `managerial`, `transversal`) VALUES
(11, 5, '2024-08-30 11:57:44', 5, 8, 10, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `role` enum('candidate','hr') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'imed', 'hamdene', '$2y$10$odNs6bfBZxfaxSpnpzWGOeWpzTLhKxE/t55FFE5g.vol4PZTsTbjS', 'imed.hamdene@esprit.tn', 'candidate', '2024-08-23 01:18:37'),
(5, 'imed', 'imedimed', '$2y$10$odNs6bfBZxfaxSpnpzWGOeWpzTLhKxE/t55FFE5g.vol4PZTsTbjS', 'imedimed@gmail.com', 'hr', '2024-08-23 07:12:53'),
(6, 'abc', 'abc', '$2y$10$Hc1Yvi70SmKKdfu.LHuxWO26mtZrA1VVsQNPBz5byhkLhKKLzdb2S', 'abcdef@gmail.com', 'candidate', '2024-08-23 07:52:37'),
(7, 'qwerty', 'qwerty', '$2y$10$UtEqQqeue9nAnB7fPJb05.GiDAEB2l6i49odRmSn2xaac39tMAebu', 'qwerty@gamil.com', 'candidate', '2024-08-23 10:18:40'),
(8, 'jihen', 'hamdene', '$2y$10$eWpv/vu.RpDAeiE6m0tgROQK30akNCOakRVqQkaj5mfFdtSFUJaSu', 'jij@gmail.com', 'candidate', '2024-08-29 15:48:19'),
(9, 'ahmed', 'zoufli', '$2y$10$uB.NEFWs.fwmxv1WV1JK6uoZKJG5Y8Fd3WnL6q2alswmGrKsvAKCK', 'ah@gmail.com', 'candidate', '2024-08-29 17:37:35'),
(10, 'aaaaaa', 'aaaaaa', '$2y$10$MthD2QvhL04ythPrLsyYfOO3wyDyNELlShWsnegaogGfEi./Hypja', 'aaa@aaa', 'candidate', '2024-08-29 17:51:39'),
(11, 'qqqqqq', 'qqqqqq', '$2y$10$P11pqdo62EN6gegBE7WE4OvFYQviXgQcB5j2BSvK4XlH3GXKOntX6', 'qq@qq', 'candidate', '2024-08-29 18:15:23'),
(12, 'eee', 'eee', '$2y$10$SSn53TDyOzpB3BQw9HLxBebD1figtnu7/SmVS0phWTGJXDuhwzJom', 'ee@eee', 'candidate', '2024-08-29 18:17:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`candidate_id`,`hr_user_id`,`meeting_time`),
  ADD KEY `hr_user_id` (`hr_user_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`candidate_id`,`hr_user_id`,`meeting_time`),
  ADD KEY `hr_user_id` (`hr_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`);

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meetings_ibfk_2` FOREIGN KEY (`hr_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`candidate_id`,`hr_user_id`,`meeting_time`) REFERENCES `meetings` (`candidate_id`, `hr_user_id`, `meeting_time`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`hr_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
