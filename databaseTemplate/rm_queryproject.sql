-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 11:02 PM
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
-- Table structure for table `rm_queryproject`
--

CREATE TABLE `rm_queryproject` (
  `id` int(11) NOT NULL,
  `id_kon` int(11) NOT NULL,
  `vesselname` varchar(255) NOT NULL,
  `bkiid` int(11) NOT NULL,
  `bkidesaindid` varchar(50) NOT NULL,
  `imo` int(11) NOT NULL,
  `operationstat` varchar(50) NOT NULL,
  `flag` varchar(50) NOT NULL,
  `port` varchar(50) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `manager` varchar(255) NOT NULL,
  `rulesset` varchar(255) NOT NULL,
  `ruleedision` varchar(50) NOT NULL,
  `classnotation` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `builder` varchar(255) NOT NULL,
  `hullyard` varchar(255) NOT NULL,
  `outfittingyard` varchar(255) NOT NULL,
  `keellaid` date NOT NULL,
  `launchdate` date NOT NULL,
  `dateofbuild` date NOT NULL,
  `deliverydate` date NOT NULL,
  `loa` float NOT NULL,
  `lbp` float NOT NULL,
  `lload` float NOT NULL,
  `bext` float NOT NULL,
  `b` float NOT NULL,
  `d` float NOT NULL,
  `draught` float NOT NULL,
  `freeboard` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rm_queryproject`
--
ALTER TABLE `rm_queryproject`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kon` (`id_kon`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rm_queryproject`
--
ALTER TABLE `rm_queryproject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
