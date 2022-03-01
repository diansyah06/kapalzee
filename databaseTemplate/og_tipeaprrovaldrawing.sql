-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2020 at 10:02 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `og_tipeaprrovaldrawing`
--

CREATE TABLE `og_tipeaprrovaldrawing` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `desck` varchar(255) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `og_tipeaprrovaldrawing`
--

INSERT INTO `og_tipeaprrovaldrawing` (`id`, `code`, `desck`, `id_status`) VALUES
(1, 'RV', 'To be Revised Subjectto Remarks in Red', 0),
(2, 'AP', 'Approved', 1),
(3, 'RE', 'Returned', 2),
(4, 'EF', 'Have been Examined by Flag State', 3),
(5, 'EX', 'Examined', 4),
(6, 'RF', 'Reference', 5),
(7, 'NP', 'Not approved', 6),
(8, 'SN', 'Seen', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `og_tipeaprrovaldrawing`
--
ALTER TABLE `og_tipeaprrovaldrawing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `og_tipeaprrovaldrawing`
--
ALTER TABLE `og_tipeaprrovaldrawing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
