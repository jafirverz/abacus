-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2023 at 11:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abacus3`
--

-- --------------------------------------------------------

--
-- Table structure for table `worksheets`
--

CREATE TABLE `worksheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question_template_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL COMMENT '1 -> free, 2 -> paid',
  `amount` varchar(255) DEFAULT NULL,
  `stopwatch_timing` smallint(6) DEFAULT NULL COMMENT '1 -> yes, 2 -> no',
  `preset_timing` smallint(6) DEFAULT NULL COMMENT '1 -> yes, 2 -> no',
  `question_type` varchar(255) DEFAULT NULL COMMENT '1 -> vertical, 2 -> horizontal',
  `description` text NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `worksheets`
--

INSERT INTO `worksheets` (`id`, `role_id`, `question_template_id`, `title`, `type`, `amount`, `stopwatch_timing`, `preset_timing`, `question_type`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Worksheet Title 1', 2, '200', 1, 1, '1', 'test', 1, '2023-05-22 07:14:23', '2023-05-22 09:01:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `worksheets`
--
ALTER TABLE `worksheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `worksheets_role_id_foreign` (`role_id`),
  ADD KEY `worksheets_question_template_id_foreign` (`question_template_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `worksheets`
--
ALTER TABLE `worksheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `worksheets`
--
ALTER TABLE `worksheets`
  ADD CONSTRAINT `worksheets_question_template_id_foreign` FOREIGN KEY (`question_template_id`) REFERENCES `question_templates` (`id`),
  ADD CONSTRAINT `worksheets_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
