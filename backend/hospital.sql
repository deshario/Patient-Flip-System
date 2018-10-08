-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2017 at 08:53 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `patient_info`
--

CREATE TABLE `patient_info` (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(100) NOT NULL,
  `patient_bed` varchar(10) NOT NULL,
  `patient_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient_info`
--

INSERT INTO `patient_info` (`patient_id`, `patient_name`, `patient_bed`, `patient_created`) VALUES
(1, 'marke', 'B1235', '2017-05-08 00:00:00'),
(2, 'deshario', 'P132', '0000-00-00 00:00:00'),
(3, 'jason', 'D123', '0000-00-00 00:00:00'),
(4, 'jackie', 'J123', '2017-10-25 00:00:00'),
(5, 'PIXKY', 'p12', '2017-10-19 00:00:00'),
(12, 'bella', 'B123', '2017-10-14 03:26:01'),
(13, 'auum', '22', '2017-10-14 14:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `patient_turning`
--

CREATE TABLE `patient_turning` (
  `turning_id` int(11) NOT NULL,
  `P_id` int(11) NOT NULL,
  `latest_turned` datetime NOT NULL,
  `position` varchar(50) NOT NULL,
  `turned_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patient_turning`
--

INSERT INTO `patient_turning` (`turning_id`, `P_id`, `latest_turned`, `position`, `turned_by`) VALUES
(3, 3, '2017-10-11 23:30:00', 'sraight', '2'),
(5, 3, '2017-10-27 03:14:18', 'straight', ''),
(6, 4, '2017-10-12 04:11:14', 'straight', '3'),
(16, 13, '2017-10-14 14:45:19', 'blue', NULL),
(17, 13, '2017-10-14 14:47:49', 'No Movement', NULL),
(18, 13, '2017-10-14 14:50:19', 'No Movement', NULL),
(19, 13, '2017-10-14 15:15:19', 'red', '2'),
(20, 13, '2017-10-14 15:40:19', 'blue', '2');

-- --------------------------------------------------------

--
-- Table structure for table `staff_info`
--

CREATE TABLE `staff_info` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(50) NOT NULL,
  `staff_gender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_info`
--

INSERT INTO `staff_info` (`staff_id`, `staff_name`, `staff_gender`) VALUES
(1, 'amrit', 1),
(2, 'staff2', 0),
(3, 'staff3', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patient_info`
--
ALTER TABLE `patient_info`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_turning`
--
ALTER TABLE `patient_turning`
  ADD PRIMARY KEY (`turning_id`);

--
-- Indexes for table `staff_info`
--
ALTER TABLE `staff_info`
  ADD PRIMARY KEY (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient_info`
--
ALTER TABLE `patient_info`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `patient_turning`
--
ALTER TABLE `patient_turning`
  MODIFY `turning_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `staff_info`
--
ALTER TABLE `staff_info`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
