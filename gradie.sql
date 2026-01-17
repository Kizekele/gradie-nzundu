-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 17 jan. 2026 à 03:04
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gradie`
--

-- --------------------------------------------------------

--
-- Structure de la table `calendrier`
--

CREATE TABLE `calendrier` (
  `id` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `calendrier`
--

INSERT INTO `calendrier` (`id`, `id_cours`, `titre`, `description`, `date_debut`, `date_fin`, `created_at`) VALUES
(1, 1, 'Mathématiques', 'Chapitre 1 - Algèbre', '2025-12-05 08:00:00', '2025-12-05 10:00:00', '2025-12-02 18:26:03'),
(2, 2, 'Physique', 'TP sur la mécanique', '2025-12-06 10:00:00', '2025-12-06 12:00:00', '2025-12-02 18:26:03'),
(3, 3, 'Informatique', 'Introduction à PHP', '2025-12-07 14:00:00', '2025-12-07 16:00:00', '2025-12-02 18:26:03');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `nom_cours` varchar(255) NOT NULL,
  `nom_prof` varchar(255) NOT NULL,
  `ressources` text DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `nom_cours`, `nom_prof`, `ressources`, `note`, `created_at`) VALUES
(1, 'Programmation Python', 'Dr. Alain Mbayo', 'https://www.w3schools.com/python/', 'python_intro.pdf', '2025-12-02 15:26:02'),
(2, 'Base de Données MySQL', 'Mme. Sarah Kanyama', 'https://www.mysqltutorial.org/', 'mysql_cours.pdf', '2025-12-02 15:26:02'),
(3, 'Réseaux Informatiques', 'Ing. Patrick Mulumba', 'https://www.comptia.org/content/guides/what-is-networking', 'reseaux_fondamentaux.pdf', '2025-12-02 15:26:02'),
(4, 'Architecture des Ordinateurs', 'Dr. Michel Kalala', 'https://www.geeksforgeeks.org/computer-organization-and-architecture-tutorials/', 'architecture_machine.pdf', '2025-12-02 15:26:02'),
(5, 'Développement Web (HTML/CSS)', 'Mme. Déborah Tshimanga', 'https://developer.mozilla.org/fr/docs/Learn', 'dev_web_cours.pdf', '2025-12-02 15:26:02'),
(6, 'JavaScript Avancé', 'Ing. Christian Banza', 'https://javascript.info/', 'javascript_advanced.pdf', '2025-12-02 15:26:02'),
(7, 'Systèmes d’Exploitation', 'Prof. Jean-Paul Kabuya', 'https://www.studytonight.com/operating-system/', 'systeme_exploitation.pdf', '2025-12-02 15:26:02'),
(8, 'Sécurité Informatique', 'Dr. Roselyne Mwila', 'https://owasp.org/www-project-top-ten/', 'securite_info.pdf', '2025-12-02 15:26:02'),
(9, 'Algorithmique et Logique', 'Mme. Clarisse Mukeba', 'https://www.codingame.com/start', 'algorithmique_intro.pdf', '2025-12-02 15:26:02'),
(10, 'Introduction à l’IA & Machine Learning', 'Dr. Jonas Bisimwa', 'https://www.tensorflow.org/learn', 'ia_machine_learning.pdf', '2025-12-02 15:26:02');

-- --------------------------------------------------------

--
-- Structure de la table `devoir`
--

CREATE TABLE `devoir` (
  `id_devoir` int(11) NOT NULL,
  `id_cours` int(11) NOT NULL,
  `enonce_devoir` text NOT NULL,
  `date_expiration` datetime NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `devoir`
--

INSERT INTO `devoir` (`id_devoir`, `id_cours`, `enonce_devoir`, `date_expiration`, `date_creation`) VALUES
(1, 1, 'Rédiger un résumé de 2 pages sur l’histoire du web.', '2025-12-15 23:59:00', '2025-12-02 18:54:02'),
(2, 1, 'Exercice pratique : Créer une page HTML avec formulaire de contact.', '2025-12-20 23:59:00', '2025-12-02 18:54:02'),
(3, 2, 'Résoudre les 10 problèmes d’algèbre linéaire fournis.', '2025-12-18 23:59:00', '2025-12-02 18:54:02'),
(4, 2, 'Projet : Implémenter un petit programme en Python pour gérer une bibliothèque.', '2025-12-22 23:59:00', '2025-12-02 18:54:02'),
(5, 3, 'Rédiger un essai sur les enjeux de la cybersécurité.', '2025-12-19 23:59:00', '2025-12-02 18:54:02'),
(6, 3, 'Étude de cas : Analyser un réseau d’entreprise et proposer des améliorations.', '2025-12-23 23:59:00', '2025-12-02 18:54:02'),
(7, 1, 'Créer un mini-site responsive avec CSS Grid et Flexbox.', '2025-12-25 23:59:00', '2025-12-02 18:54:02'),
(8, 2, 'Exercices SQL : créer des requêtes pour extraire des données d’une base.', '2025-12-21 23:59:00', '2025-12-02 18:54:02'),
(9, 3, 'Rédiger un rapport sur les méthodes de chiffrement actuelles.', '2025-12-24 23:59:00', '2025-12-02 18:54:02'),
(10, 1, 'Projet final : réaliser un portfolio personnel avec HTML, CSS et JS.', '2025-12-26 23:59:00', '2025-12-02 18:54:02');

-- --------------------------------------------------------

--
-- Structure de la table `devoir_etudiant`
--

CREATE TABLE `devoir_etudiant` (
  `id_depot` int(11) NOT NULL,
  `id_devoir` int(11) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `mime_type` varchar(50) DEFAULT NULL,
  `size_bytes` int(11) DEFAULT NULL,
  `date_envoi` datetime NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `commentaire_prof` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `devoir_etudiant`
--

INSERT INTO `devoir_etudiant` (`id_depot`, `id_devoir`, `id_etudiant`, `fichier`, `original_filename`, `mime_type`, `size_bytes`, `date_envoi`, `note`, `commentaire_prof`) VALUES
(1, 1, 3, 'devoir_692f293ba3c0f.docx', 'PROSIT 7 ALLER.docx', 'application/vnd.openxmlformats-officedocument.word', 17209, '2025-12-02 19:00:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `postnom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `etat` enum('etudiant','professeur') NOT NULL,
  `faculte` varchar(255) NOT NULL,
  `cycle` enum('Ancien système','LMD') NOT NULL,
  `promotion` varchar(50) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `postnom`, `prenom`, `email`, `mot_de_passe`, `etat`, `faculte`, `cycle`, `promotion`, `date_inscription`) VALUES
(3, 'kizekele', 'musaga', 'john', 'kizekelejohn@gmail.com', '$2y$10$1Pnm49wLhcdP8hCLxFkhDeoKXPNLQXC9UsxtRaSASC95eglZOSW.e', 'etudiant', 'Sciences informatiques', 'LMD', 'L2', '2025-11-25 16:46:26');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `calendrier`
--
ALTER TABLE `calendrier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devoir`
--
ALTER TABLE `devoir`
  ADD PRIMARY KEY (`id_devoir`),
  ADD KEY `id_cours` (`id_cours`);

--
-- Index pour la table `devoir_etudiant`
--
ALTER TABLE `devoir_etudiant`
  ADD PRIMARY KEY (`id_depot`),
  ADD UNIQUE KEY `unique_submission` (`id_devoir`,`id_etudiant`),
  ADD KEY `id_etudiant` (`id_etudiant`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `calendrier`
--
ALTER TABLE `calendrier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `devoir`
--
ALTER TABLE `devoir`
  MODIFY `id_devoir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `devoir_etudiant`
--
ALTER TABLE `devoir_etudiant`
  MODIFY `id_depot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `calendrier`
--
ALTER TABLE `calendrier`
  ADD CONSTRAINT `calendrier_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `devoir`
--
ALTER TABLE `devoir`
  ADD CONSTRAINT `devoir_ibfk_1` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `devoir_etudiant`
--
ALTER TABLE `devoir_etudiant`
  ADD CONSTRAINT `devoir_etudiant_ibfk_1` FOREIGN KEY (`id_devoir`) REFERENCES `devoir` (`id_devoir`) ON DELETE CASCADE,
  ADD CONSTRAINT `devoir_etudiant_ibfk_2` FOREIGN KEY (`id_etudiant`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
