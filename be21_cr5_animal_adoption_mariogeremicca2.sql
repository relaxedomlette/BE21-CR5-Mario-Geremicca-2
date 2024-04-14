-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Apr 2024 um 00:14
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `be21_cr5_animal_adoption_mariogeremicca2`
--
CREATE DATABASE IF NOT EXISTS `be21_cr5_animal_adoption_mariogeremicca2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `be21_cr5_animal_adoption_mariogeremicca2`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `petName` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `breed` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` enum('adopted','unclaimed') DEFAULT NULL,
  `vaccinated` enum('vaccinated','not vaccinated') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `animal`
--

INSERT INTO `animal` (`id`, `petName`, `type`, `breed`, `age`, `size`, `location`, `description`, `picture`, `status`, `vaccinated`) VALUES
(14, 'Leonard', 'dog', 'Labrador Retriever', 8, 'medium', 'New York City', 'Bella is a loyal Labrador Retriever who loves play', '661c3c374cf02.jpg', 'adopted', 'vaccinated'),
(15, 'Bella', 'Cat', 'Calico', 5, 'small', 'Los Angeles', 'Simba is a fluffy Persian kitten with a playful pe', '661c3c6eaff35.jpg', 'adopted', 'vaccinated'),
(16, 'Buddy', 'Dog', 'Labrador Retriever', 8, 'large', 'London', 'Charlie is a friendly cockatiel who loves to whist', '661c3cac1c62e.jpg', 'adopted', 'vaccinated'),
(22, 'Luna', 'Cat', 'Tabby', 5, 'small', 'Sydney', 'test', '661c3d09a5a63.jpg', 'adopted', 'vaccinated'),
(23, 'Bailey', 'Dog', 'Beagle', 5, 'medium', 'Toronto', '', '661c3d5a57a2d.jpg', 'adopted', 'vaccinated'),
(24, 'Oliver', 'Dog', 'Tuxedo', 3, 'small', 'San Francisco', 'Oliver is a playful and mischievous tuxedo cat. He', '661c47731dcd8.jpg', 'adopted', 'vaccinated'),
(25, 'Chloe', 'Cat', 'Siamese', 7, 'small', 'Vancouver', 'test', '661c47b5f1e76.jpg', 'adopted', 'vaccinated'),
(27, 'Duke', 'Dog', 'Doberman Pinscher', 3, 'small', 'Miami', 'Duke is a confident and intelligent Doberman Pinsc', '661c441949915.jpg', 'unclaimed', 'vaccinated'),
(29, 'Gizmo', 'Cat', 'Maine Coon', 8, 'small', 'Houston', 'Gizmo is a curious and playful Maine Coon cat. He ', '661c43f613c89.jpg', 'adopted', 'vaccinated'),
(31, 'Manu', '', 'German Shepherd', 8, 'small', 'Karlgasse9', 'sss', '661c481c2d704.jpg', 'adopted', 'vaccinated');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_pet_id` int(11) NOT NULL,
  `adoption` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `pet_adoption`
--

INSERT INTO `pet_adoption` (`id`, `fk_user_id`, `fk_pet_id`, `adoption`) VALUES
(1, 7, 14, '2024-04-14'),
(2, 7, 15, '2024-04-14'),
(3, 7, 16, '2024-04-14'),
(4, 7, 22, '2024-04-14'),
(5, 7, 23, '2024-04-14');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` enum('user','admin') DEFAULT NULL,
  `phoneNumber` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `birthDate`, `picture`, `status`, `phoneNumber`, `address`) VALUES
(1, 'mario', 'gere', 'mario@gmail.com', 'addb0f5e7826c857d7376d1bd9bc33c0c544790a2eac96144a8af22b1298c940', '1998-05-06', '', 'admin', NULL, NULL),
(2, '', '', '', 'addb0f5e7826c857d7376d1bd9bc33c0c544790a2eac96144a8af22b1298c940', '0000-00-00', 'petlogo.jpg', 'user', '', ''),
(7, 'Nando', 'Bauer', 'nando@aon.at', 'addb0f5e7826c857d7376d1bd9bc33c0c544790a2eac96144a8af22b1298c940', '1946-08-07', 'account.jpg', NULL, '06507845962', 'Schönwiesenweg52');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`fk_user_id`),
  ADD KEY `pet_id` (`fk_pet_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT für Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`fk_pet_id`) REFERENCES `animal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
