-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2022 at 01:42 PM
-- Server version: 8.0.13
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ezshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_provinces`
--

CREATE TABLE `tbl_provinces` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `no` tinyint(2) DEFAULT NULL,
  `record_status` tinyint(2) NOT NULL DEFAULT '1',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `updated_by` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_provinces`
--

INSERT INTO `tbl_provinces` (`name`, `no`) VALUES
('ABRA', 1),
('AGUSAN DEL NORTE', 2),
('AGUSAN DEL SUR', 3),
('AKLAN', 4),
('ALBAY', 5),
('ANTIQUE', 6),
('BASILAN', 7),
('BATAAN', 8),
('BATANES', 9),
('BATANGAS', 10),
('BENGUET', 11),
('BOHOL', 12),
('BUKIDNON', 13),
('BULACAN', 14),
('CAGAYAN', 15),
('CAMARINES NORTE', 16),
('CAMARINES SUR', 17),
('CAMIGUIN', 18),
('CAPIZ', 19),
('CATANDUANES', 20),
('CAVITE', 21),
('CEBU', 22),
('DAVAO (DAVAO DEL NORTE)', 23),
('DAVAO DEL SUR', 24),
('DAVAO ORIENTAL', 25),
('EASTERN SAMAR', 26),
('IFUGAO', 27),
('ILOCOS NORTE', 28),
('ILOCOS SUR', 29),
('ILOILO', 30),
('ISABELA', 31),
('KALINGA', 32),
('LA UNION', 33),
('LAGUNA', 34),
('LANAO DEL NORTE', 35),
('LANAO DEL SUR', 36),
('LEYTE', 37),
('MAGUINDANAO', 38),
('NCR - Manila', 39),
('MARINDUQUE', 40),
('MASBATE', 41),
('MISAMIS OCCIDENTAL', 42),
('MISAMIS ORIENTAL', 43),
('MOUNTAIN PROVINCE', 44),
('NEGROS OCCIDENTAL', 45),
('NEGROS ORIENTAL', 46),
('COTABATO (NORTH COTABATO)', 47),
('NORTHERN SAMAR', 48),
('NUEVA ECIJA', 49),
('NUEVA VIZCAYA', 50),
('OCCIDENTAL MINDORO', 51),
('ORIENTAL MINDORO', 52),
('PALAWAN', 53),
('PAMPANGA', 54),
('PANGASINAN', 55),
('QUEZON', 56),
('QUIRINO', 57),
('RIZAL', 58),
('ROMBLON', 59),
('SAMAR (WESTERN SAMAR)', 60),
('SIQUIJOR', 61),
('SORSOGON', 62),
('SOUTH COTABATO', 63),
('SOUTHERN LEYTE', 64),
('SULTAN KUDARAT', 65),
('SULU', 66),
('SURIGAO DEL NORTE', 67),
('SURIGAO DEL SUR', 68),
('TARLAC', 69),
('TAWI-TAWI', 70),
('ZAMBALES', 71),
('ZAMBOANGA DEL NORTE', 72),
('ZAMBOANGA DEL SUR', 73),
('NCR 2', 74),
('NCR 3', 75),
('NCR 4', 76),
('AURORA', 77),
('BILIRAN', 78),
('GUIMARAS', 79),
('SARANGANI', 80),
('APAYAO', 81),
('COMPOSTELA VALLEY', 82),
('ZAMBOANGA SIBUGAY', 83),
('DINAGAT ISLANDS', 85),
('COTABATO CITY', 98);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_provinces`
--
ALTER TABLE `tbl_provinces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provIndex` (`no`,`name`),
  ADD KEY `updated_by` (`updated_by`),
  ADD KEY `created_by` (`created_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_provinces`
--
ALTER TABLE `tbl_provinces`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
