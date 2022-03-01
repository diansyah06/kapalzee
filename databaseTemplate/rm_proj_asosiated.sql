-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 02:21 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

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
-- Table structure for table `rm_proj_asosiated`
--

CREATE TABLE `rm_proj_asosiated` (
  `id` int(11) NOT NULL,
  `proj_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `oleh` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `groupteam` int(11) NOT NULL,
  `colaborator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rm_proj_asosiated`
--

INSERT INTO `rm_proj_asosiated` (`id`, `proj_id`, `date`, `oleh`, `id_client`, `groupteam`, `colaborator`) VALUES
(7, 451, '2016-10-03 14:56:15', 36, 5, 0, 0),
(8, 501, '2018-09-21 11:20:46', 1, 3, 0, 0),
(9, 455, '2018-09-21 13:12:13', 1, 3, 0, 0),
(10, 455, '2018-09-27 14:59:12', 507, 6, 0, 0),
(11, 501, '2018-10-05 14:12:00', 506, 7, 0, 0),
(12, 501, '2018-10-12 09:30:53', 506, 8, 0, 0),
(13, 501, '2018-10-12 09:58:59', 506, 10, 0, 0),
(14, 501, '2018-10-12 09:59:25', 506, 9, 0, 0),
(15, 501, '2018-10-12 10:01:48', 506, 11, 0, 0),
(16, 501, '2018-10-16 09:39:26', 506, 12, 0, 0),
(17, 501, '2018-10-30 13:50:10', 58, 13, 0, 0),
(18, 455, '2018-10-31 16:06:50', 1, 13, 0, 0),
(19, 501, '2018-11-14 11:32:18', 506, 16, 0, 0),
(20, 501, '2018-11-14 11:32:59', 506, 15, 0, 0),
(21, 501, '2018-11-14 11:33:27', 506, 14, 0, 0),
(22, 501, '2018-11-14 13:31:41', 506, 17, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rm_proj_asosiated`
--
ALTER TABLE `rm_proj_asosiated`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rm_proj_asosiated`
--
ALTER TABLE `rm_proj_asosiated`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
