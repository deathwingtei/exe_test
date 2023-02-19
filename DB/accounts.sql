-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2023 at 02:51 PM
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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `phone`, `email`, `password`, `username`, `company`, `nationality`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Micah Figueroa', '(175) 897-5654', 'vestibulum.ut@aol.net', '$2y$10$fal6Pru5RXxK3g5mgZOOKu9etc1AmesWCsMm3VcgBZw.wE23P35dC', 'Aimee', 'Tempor Diam Company', 'Norway', NULL, NULL, NULL),
(2, 'Salvador Robles', '(149) 416-0327', 'ut.nec.urna@aol.com', '$2y$10$CwQwYgkWdDkacE85.nyPxeNLqHeMu/7zAzCj8MVZq3v0O7b1AIrwi', 'Moana', 'Sagittis Felis LLC', 'Nigeria', NULL, NULL, NULL),
(3, 'Daphne Solomon', '(465) 633-1234', 'facilisis@hotmail.net', '$2y$10$61Pb71s64Nyo8tp76HvDhuvO2l741WOxnj/yeXrhuYbxqrWaMNQF6', 'Ila', 'Non LLP', 'Philippines', NULL, NULL, NULL),
(4, 'Inga Dudley', '(785) 320-8427', 'diam.luctus@yahoo.org', '$2y$10$yANrW7ZSleKfCAQ3J9Z8SuWvqIeFxdv7sGN0TTfaLV88GQg7AmNXi', 'Samson', 'Eu PC', 'India', NULL, NULL, NULL),
(5, 'Farrah Bartlett', '1-975-537-1622', 'hendrerit.a@google.couk', '$2y$10$DiSz7Ptdp3UySG93ildps.hyk66q2vCXslRhLHFRMGiKiZ7sPPgOa', 'Brynne', 'Consectetuer Incorporated', 'Belgium', NULL, NULL, NULL),
(6, 'Bethany Martinez', '(344) 341-3583', 'dapibus.quam@outlook.couk', '$2y$10$gf6A3yW.bZxTVWGvzJhP2OAKrM7xrEAEs7INubmiM64POGnwFjv7W', 'Dante', 'Lorem Vitae Corporation', 'Australia', NULL, NULL, NULL),
(7, 'Olga Harmon', '(535) 736-8745', 'vel.venenatis@yahoo.edu', '$2y$10$ykRYfj2YDnLjIq4BCdExk.AoJWpCAEYw/pYWnCz5aY6cKg6Ce5XG2', 'Louis', 'Eu Industries', 'Peru', NULL, NULL, NULL),
(8, 'Tiger Oneal', '1-330-563-3873', 'a.auctor.non@aol.org', '$2y$10$kg/8rQHG6DJlLJHIrZyTReglv5noWSTXHSdUMILRzAax8qeNxLZ5m', 'Stephanie', 'Pellentesque Massa Lobortis Inc.', 'Austria', NULL, NULL, NULL),
(9, 'Adria Mcclure', '1-966-100-7223', 'faucibus.ut@protonmail.couk', '$2y$10$gNR.63WYMSQ.If7YJPVBr.9qNYQITxEw3LNQWqMgLF2MmAOkxnZdy', 'Gil', 'Egestas Fusce Aliquet Industries', 'Italy', NULL, NULL, NULL),
(10, 'Price Watson', '1-265-555-4354', 'sem.egestas@hotmail.org', '$2y$10$14JPPW7RNpdgElPfeHsZruqi.Z6yh31URTZeUBWZrdFhMBFkD6SMq', 'Kylynn', 'Donec Ltd', 'Australia', NULL, NULL, NULL),
(11, 'Hakeem Gillespie', '1-824-119-7226', 'semper.erat.in@protonmail.ca', '$2y$10$jio3VzKASBREfR5vpIrNE.p3KiW6QELMMkyHOVDZdd/BO12GzXxye', 'Rowan', 'Vulputate Velit Eu Incorporated', 'Australia', NULL, NULL, NULL),
(12, 'Laith Tillman', '(946) 933-3197', 'purus.nullam.scelerisque@yahoo.net', '$2y$10$ih.YiI0zP9kPyldHnAj60.QLBoC5Ym8TifamYJbrUV8URj4ENjRjC', 'Uriah', 'Gravida Molestie Company', 'Indonesia', NULL, NULL, NULL),
(13, 'Dean Clements', '1-177-836-7163', 'facilisis.eget.ipsum@yahoo.com', '$2y$10$weDH5nXZthsk9jy1g9QYjOuQcdy1TQlQWO2Jl7sPkHo8dMGB3I5CG', 'Bryar', 'Aliquet Vel Vulputate Institute', 'Poland', NULL, NULL, NULL),
(14, 'Drew Payne', '1-964-982-5491', 'mauris@hotmail.com', '$2y$10$2rW0pXx85Ner652APC.7.eOWxAXzwBF/vEq1PEVctg3OuTK2fiKYy', 'Adrian', 'Molestie Associates', 'Norway', NULL, NULL, NULL),
(15, 'Cora Foreman', '(533) 823-6188', 'eget.ipsum.suspendisse@outlook.edu', '$2y$10$vQn4/aimBl8LGdbaTs4DB.ojM6irpharElhHBA1DHzyj7fxAINKGS', 'Oscar', 'Vivamus Molestie LLP', 'United States', NULL, NULL, NULL),
(16, 'Nero Woodard', '1-756-145-6998', 'eu@outlook.ca', '$2y$10$gQxtQDaWz.42DHP5iInGfu66JV2b6ncPHJrGBJ4LbPZPBPEOciWHO', 'Aphrodite', 'Vestibulum Foundation', 'Germany', NULL, NULL, NULL),
(17, 'Hanae Bond', '1-853-416-6337', 'sem.consequat.nec@protonmail.net', '$2y$10$VKzgfxRLHHHUF5CNKgcSqeSKRHfZG6PmM/m3fCUL8mx9cZ7xN9fje', 'Marah', 'Malesuada Consulting', 'Philippines', NULL, NULL, NULL),
(18, 'Emery Harrington', '(750) 611-1035', 'ligula@aol.org', '$2y$10$VkHB44kaeAhew3FxrHe4V.G9/BuwJSHuIdlpKGHW8rw.DHWT4enuu', 'Stephanie2', 'Euismod Foundation', 'Colombia', NULL, NULL, NULL),
(19, 'Mallory Reeves', '1-655-719-7060', 'eleifend.nec@yahoo.com', '$2y$10$LFao3jfQCIBePS8pdXZnku2l.iglwl/jEc53saqpjPFE1SVSCrY42', 'Judah', 'Aliquam Erat Industries', 'Colombia', NULL, '2023-02-19 04:02:46', '2023-02-19 04:02:46'),
(20, 'Cara Arnolds', '1-248-752-1173', 'eu.placerat@outlook.couk', '$2y$10$2ClxxHuE8i4BkDebPnVKouU2rEkYHtuXPluhF.hvPI3cSmn4MOF6G', 'Maris', 'Neque Non Quam Incorporated', 'Philippines', NULL, '2023-02-19 04:02:39', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_email_unique` (`email`),
  ADD UNIQUE KEY `accounts_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
