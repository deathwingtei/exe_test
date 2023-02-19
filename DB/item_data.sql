-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2023 at 02:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exe_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_data`
--

CREATE TABLE `item_data` (
  `game_item_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chance` double(10,2) NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_data`
--

INSERT INTO `item_data` (`game_item_id`, `name`, `chance`, `stock`, `created_at`, `updated_at`) VALUES
(892, 'Medium MP Potion', 0.08, 80, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(1050, 'Small Potion Heal', 0.12, 1000, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(1650, 'Full Potion Heal', 0.04, 10, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(3315, 'Medium Potion Heal', 0.08, 80, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(5830, 'Big Potion Heal', 0.06, 15, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(10235, 'Small MP Potion', 0.12, 1000, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(14736, 'Big MP Potion', 0.06, 15, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(19001, 'Full MP Potion', 0.04, 8, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(68411, 'Defense Ring', 0.05, 10, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(117462, 'Silver Key', 0.15, 1000, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(118930, 'Lucky Key', 0.15, 1000, '2023-02-19 07:17:45', '2023-02-19 07:17:45'),
(135007, 'Attack Ring', 0.05, 10, '2023-02-19 07:17:45', '2023-02-19 07:17:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_data`
--
ALTER TABLE `item_data`
  ADD PRIMARY KEY (`game_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_data`
--
ALTER TABLE `item_data`
  MODIFY `game_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135008;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
