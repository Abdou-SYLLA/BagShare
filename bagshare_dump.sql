-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-asylla.alwaysdata.net
-- Generation Time: Nov 06, 2024 at 09:05 AM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asylla_bagshare`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `numero` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `hashed_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`numero`, `nom`, `prenom`, `role`, `username`, `hashed_password`) VALUES
(601020304, 'Dupont', 'Jean', 'admin', 'jeandupont', '$2y$10$ULPSdDPEWtLZTBYZyz5Hu.EGi0CmNYLA9sGWC/KPduH44E5ScuUcO'),
(705060708, 'Martin', 'Claire', 'user', 'clairemartin', '$2y$10$ULPSdDPEWtLZTBYZyz5Hu.EGi0CmNYLA9sGWC/KPduH44E5ScuUcO');

-- --------------------------------------------------------

--
-- Table structure for table `annonces`
--

CREATE TABLE `annonces` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `depart` varchar(100) NOT NULL,
  `ville_depart` varchar(100) NOT NULL,
  `arrivee` varchar(100) NOT NULL,
  `ville_destination` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `kilos_disponibles` int(11) NOT NULL,
  `prix_par_kilo` decimal(10,2) NOT NULL,
  `adresse_depot` varchar(255) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `annonces`
--

INSERT INTO `annonces` (`id`, `description`, `depart`, `ville_depart`, `arrivee`, `ville_destination`, `date`, `kilos_disponibles`, `prix_par_kilo`, `adresse_depot`, `numero`) VALUES
(1, 'Livraison rapide de colis légers', 'France', 'Paris', 'France', 'Marseille', '2024-11-10', 50, 2.50, 'Gare de Lyon', 601020304),
(2, 'Transport de documents importants', 'France', 'Lyon', 'France', 'Toulouse', '2024-11-12', 20, 3.00, 'Place Bellecour', 601020304),
(3, 'Déménagement partiel, objets fragiles', 'France', 'Rodez', 'France', 'Paris', '2024-11-15', 100, 1.50, 'Centre-ville', 601020304),
(4, 'Transport de petits colis', 'Belgique', 'Bruxelles', 'Belgique', 'Liège', '2024-11-11', 30, 2.00, 'Gare Centrale', 705060708),
(5, 'Livraison de marchandises légères', 'Pays-Bas', 'Amsterdam', 'Pays-Bas', 'Rotterdam', '2024-11-13', 70, 2.20, 'Centraal Station', 705060708),
(6, 'Livraison express de documents', 'Allemagne', 'Berlin', 'Allemagne', 'Munich', '2024-11-14', 10, 3.50, 'Alexanderplatz', 705060708);

-- --------------------------------------------------------

--
-- Table structure for table `avantages`
--

CREATE TABLE `avantages` (
  `id` int(11) NOT NULL,
  `texte` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avantages`
--

INSERT INTO `avantages` (`id`, `texte`) VALUES
(1, 'Des tarifs flexibles selon le poids et la destination'),
(2, 'Un réseau mondial de voyageurs prêts à partager leurs bagages'),
(3, 'Une solution rapide, sécurisée et écologique pour vos envois'),
(4, 'Un moyen rentable pour les voyageurs d\'amortir leurs frais de voyage'),
(5, 'Contribue à la réduction de l\'empreinte carbone en optimisant l\'espace des bagages');

-- --------------------------------------------------------

--
-- Table structure for table `lieux`
--

CREATE TABLE `lieux` (
  `id` int(11) NOT NULL,
  `pays` varchar(100) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `endroit_populaire` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lieux`
--

INSERT INTO `lieux` (`id`, `pays`, `ville`, `endroit_populaire`) VALUES
(1, 'France', 'Paris', 'Tour Eiffel'),
(2, 'France', 'Rodez', 'Musée Soulages'),
(3, 'France', 'Marseille', 'Vieux-Port'),
(4, 'France', 'Lyon', 'Basilique de Fourvière'),
(5, 'France', 'Toulouse', 'Place du Capitole'),
(6, 'Belgique', 'Bruxelles', 'Grand-Place'),
(7, 'Belgique', 'Liège', 'Montagne de Bueren'),
(8, 'Allemagne', 'Berlin', 'Brandenburger Tor'),
(9, 'Allemagne', 'Munich', 'Marienplatz'),
(10, 'Pays-Bas', 'Amsterdam', 'Rijksmuseum'),
(11, 'Pays-Bas', 'Rotterdam', 'Pont Érasme'),
(12, 'Pays-Bas', 'La Haye', 'Palais de la Paix'),
(13, 'Suède', 'Stockholm', 'Gamla Stan'),
(14, 'Angleterre', 'Londres', 'Big Ben');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`numero`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_annonces_accounts_numero` (`numero`);

--
-- Indexes for table `avantages`
--
ALTER TABLE `avantages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lieux`
--
ALTER TABLE `lieux`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=705060709;

--
-- AUTO_INCREMENT for table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `avantages`
--
ALTER TABLE `avantages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lieux`
--
ALTER TABLE `lieux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `fk_annonces_accounts_numero` FOREIGN KEY (`numero`) REFERENCES `accounts` (`numero`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
