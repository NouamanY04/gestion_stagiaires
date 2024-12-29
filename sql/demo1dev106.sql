-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 avr. 2024 à 16:07
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `demo1dev106`
--

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE `competence` (
  `id` int(11) NOT NULL,
  `libelle` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `competence`
--

INSERT INTO `competence` (`id`, `libelle`) VALUES
(1, 'JS'),
(2, 'PHP'),
(3, 'SQL'),
(4, 'C'),
(5, 'PYTHON'),
(6, 'C#'),
(7, 'C++'),
(8, 'VB.NET'),
(9, 'J#'),
(10, 'JAVA'),
(11, 'VBSCRIPT'),
(12, 'REACT');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`id`, `libelle`) VALUES
(1, 'DEV101'),
(2, 'DEV102'),
(3, 'DEV103'),
(4, 'DEV104'),
(5, 'DEV105'),
(6, 'DEV106'),
(7, 'WFS201'),
(8, 'WFS202'),
(9, 'WFS203'),
(10, 'WFS204'),
(11, 'WFS205'),
(12, 'WFS206');

-- --------------------------------------------------------

--
-- Structure de la table `stagiaire`
--

CREATE TABLE `stagiaire` (
  `id` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `date_nais` date NOT NULL,
  `idgroupe` int(11) DEFAULT NULL,
  `compétences` varchar(200) DEFAULT NULL,
  `avatar_path` text DEFAULT NULL,
  `avatar_type` varchar(40) DEFAULT NULL,
  `fiche_path` text DEFAULT NULL,
  `fiche_type` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `stagiaire`
--

INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `date_nais`, `idgroupe`, `compétences`, `avatar_path`, `avatar_type`, `fiche_path`, `fiche_type`) VALUES
(1, 'Eladili', 'aissam', '1990-12-31', 2, 'JS|PHP|PYTHON|VB.NET', 'images/avatar2.png', 'image/png', 'files/MonCV.pdf', 'application/pdf'),
(2, 'elmiraoui', 'asmae', '1999-12-31', 5, 'JS|JAVA|VBSCRIPT', 'images/avatar3.png', 'image/png', 'files/TPimage.pdf', 'application/pdf'),
(3, 'daoudi', 'tarik', '2000-12-31', 7, 'JS|VB.NET', 'images/avatar1.png', 'image/png', 'Codage de texte et Expressions régulièresaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.pdf', 'application/pdf');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `competence`
--
ALTER TABLE `competence`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Fk_stagiaire_groupe` (`idgroupe`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `competence`
--
ALTER TABLE `competence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `stagiaire`
--
ALTER TABLE `stagiaire`
  ADD CONSTRAINT `Fk_stagiaire_groupe` FOREIGN KEY (`idgroupe`) REFERENCES `groupe` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
