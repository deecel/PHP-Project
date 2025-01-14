-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 02:16 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trimexdbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `name`, `password`) VALUES
(1, 'admin', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
(37, 1, 200133, 'try', '2024-06-08 14:07:04'),
(38, 1, 200134, 'try', '2024-06-08 14:07:04'),
(39, 1, 200135, 'try', '2024-06-08 14:07:04'),
(40, 200133, 200134, 'test', '2024-06-08 14:10:22'),
(41, 200133, 1, 'test', '2024-06-10 11:11:26'),
(42, 200134, 200133, 'check', '2024-06-10 11:39:39'),
(43, 200134, 1, 'test', '2024-06-11 10:08:11'),
(44, 200134, 1, 'test', '2024-06-11 10:22:27'),
(45, 200134, 200133, 'asdadasdsa', '2024-06-11 10:23:08'),
(46, 200134, 200133, 'adsda', '2024-06-11 10:29:29'),
(47, 1, 200133, 'aaaa', '2024-06-11 10:34:25'),
(48, 1, 1, 'test', '2024-06-11 10:51:05'),
(49, 200133, 1, 'asdasda', '2024-06-11 10:54:04'),
(50, 200133, 200134, 'casdas', '2024-06-12 14:41:30'),
(51, 1, 200133, 'test', '2024-06-12 14:43:37'),
(52, 200133, 1, 'asdasdas', '2024-06-12 14:45:18'),
(53, 1, 200133, 'asdadas', '2024-06-12 14:45:31'),
(54, 200133, 200134, 'asdasd', '2024-06-25 05:56:52'),
(55, 101010, 200133, 'hi ', '2024-08-12 11:28:12'),
(56, 200133, 101010, 'hello ', '2024-08-12 11:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `ID` int(11) NOT NULL,
  `PASSWORD` varchar(50) DEFAULT NULL,
  `NAME` varchar(255) NOT NULL,
  `STUDENT_ADDRESS` varchar(255) NOT NULL,
  `STUDENT_EMAIL` varchar(255) NOT NULL,
  `HOURS` bigint(250) NOT NULL,
  `COMPANY` varchar(255) NOT NULL,
  `COMPANY_ADDRESS` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `COMPANY_CONTACTS` varchar(255) DEFAULT NULL,
  `STUDENT_CONTACT` varchar(255) DEFAULT NULL,
  `STATUS` enum('pending','approve','reject') DEFAULT 'pending',
  `OJT` enum('Done','Ongoing') DEFAULT 'Ongoing',
  `LOCKED` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`ID`, `PASSWORD`, `NAME`, `STUDENT_ADDRESS`, `STUDENT_EMAIL`, `HOURS`, `COMPANY`, `COMPANY_ADDRESS`, `EMAIL`, `COMPANY_CONTACTS`, `STUDENT_CONTACT`, `STATUS`, `OJT`, `LOCKED`) VALUES
(200133, 'Deecel320', 'MARCHK FRANCOIS DEECEL V ESCAÑO', 'BINAN LAGUNA', 'deecelescano20@gmail.com', 500, 'TRIMEX COLLEGES', 'binan laguna', 'trimexcolleges@gmail.com', '501133', '09082385078', 'approve', 'Ongoing', 0),
(200134, 'password', 'richard lazado', 'biñan laguna', 'richard@gmail.com', 450, 'trimexcolleges', 'biñan laguna', 'trimex@edu.ph.com', '123456', '564321', 'approve', 'Ongoing', 0),
(200135, 'password', 'deecel escaño', 'biñan laguna', 'deecelescano@gmail.com', 500, 'trimexcolleges', 'biñan laguna', 'trimex@edu.ph.com', '123456', '564321', 'approve', 'Done', 0),
(101010, 'password', 'asdadasdas', 'asdasdasd', 'asdaad@gmail.com', 500, 'trimex', 'san antonio', 'trimex@gmail.com', '2016050131', '09090606055', 'approve', 'Ongoing', 0),
(20220, 'password', 'abcde', 'biñan laguna', 'asdaad@gmail.com', 500, 'trimexcolleges', 'biñan laguna', 'trimex@edu.ph.com', '123456', '09090606055', 'pending', 'Ongoing', 0),
(0, 'password', 'qwerty', 'biñan laguna', 'qwerty@gmail.com', 500, 'trimexcolleges', 'biñan laguna', 'trimex@gmail.com', '123456', '564321', 'reject', 'Ongoing', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
