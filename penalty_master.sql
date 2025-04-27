-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 07:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `penalty_master`
--

CREATE TABLE `penalty_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `EmpID` bigint(20) NOT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  `Amount` double NOT NULL,
  `Final_Amount` double DEFAULT NULL,
  `Date_of_Penalty` date NOT NULL,
  `Waived_Off` double DEFAULT NULL,
  `Waived_off_By` varchar(255) DEFAULT NULL,
  `Waived_On` date DEFAULT NULL,
  `Reason_of_Waive_Off` varchar(255) DEFAULT NULL,
  `Payment_Status` enum('pending','success') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `extra_Info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penalty_master`
--

INSERT INTO `penalty_master` (`id`, `EmpID`, `Reason`, `Amount`, `Final_Amount`, `Date_of_Penalty`, `Waived_Off`, `Waived_off_By`, `Waived_On`, `Reason_of_Waive_Off`, `Payment_Status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `extra_Info`) VALUES
(6, 1, 'o', 1000, 500, '2025-04-27', 500, 'Sagar', '2025-04-27', 'k', 'pending', '2025-04-26 20:55:00', '2025-04-26 20:56:55', 6, 6, '[{\"amount\":\"200\",\"date\":\"27-04-2025\"}]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `penalty_master`
--
ALTER TABLE `penalty_master`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penalty_master`
--
ALTER TABLE `penalty_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
