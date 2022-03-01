-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 01, 2020 at 07:10 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.1.11-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `og_comment`
--

CREATE TABLE `og_comment` (
  `id` int(11) NOT NULL,
  `nomer_comment` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `gambar` text NOT NULL,
  `gamb_infoRef` text,
  `create_by` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_kontrak` int(11) NOT NULL,
  `tipe` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `importan` int(11) NOT NULL,
  `closedby` int(11) NOT NULL,
  `closedAT` datetime DEFAULT NULL,
  `reviewby` int(11) NOT NULL,
  `reviewat` datetime DEFAULT NULL,
  `commentcategory` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `og_comment`
--
ALTER TABLE `og_comment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `og_comment`
--
ALTER TABLE `og_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
