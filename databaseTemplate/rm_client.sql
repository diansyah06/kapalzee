-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2020 at 10:56 PM
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
-- Table structure for table `rm_client`
--

CREATE TABLE `rm_client` (
  `id_client` int(11) NOT NULL,
  `nick` varchar(255) NOT NULL,
  `sandi` varchar(255) NOT NULL,
  `garam` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  `locked` int(11) NOT NULL,
  `aka` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `kolabolator` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `office` varchar(50) NOT NULL,
  `hp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rm_client`
--

INSERT INTO `rm_client` (`id_client`, `nick`, `sandi`, `garam`, `user`, `locked`, `aka`, `tanggal`, `email`, `kolabolator`, `company`, `office`, `hp`) VALUES
(7, 'CItra', '8752144783309f73e1a0d282d38f4ec0597fa73a74ecd2e8f99f6992406a60b20bcf81a4bf2ee23c2de16eb4ab108c1a6f61a765bd506b3f9e5d5e55f0526bce', '5690d13e7646d7afb5418511a80c7eb3e41e248f6c158a801f4aa7d7aec9899d02bf9ece09cfb5e9de811d9f3b7b1d9c1946bcdf3497124d4ec5f1aac943f24a', 506, 0, 'PT. Citra Shipyard', '2018-10-05 14:11:27', 'd.kardiyono_engineering@cssgroup-batam.com', 1, '', '', ''),
(8, 'ANGGONO', '94cb81d0a14b16437107afd88ccdb7f26802be7354463c8c36a9e7419edd32fdf44b11f6ff01fb562e4838c4c9f128bb4bd6cb15fd51882444a6d5c6d750d937', 'd9d376e0a6c840e4894c88a0eed330e710b00564b03ce0d21d8d08873a93e097e475b4eaeda98de3a01e8071d2e049897243c1f9b83b68ee23f8ef139fff8258', 506, 0, 'Anggono Harry A.', '2018-10-12 09:29:41', 'anggono_project@cssgroup-batam.com', 0, '', '', ''),
(9, 'DIDI', '931a88f69c8a7e767ad39720153cc38e7a899b41b7e7e6d29bb7336d16f6d2b81c0935be40d43c99b9946c97a01797efe9991fb969aba9a677fe4069c86cf06f', 'a80938aac0cfa7e43b63a3e755d19e954541cea1c8bc1355e1dbdb4087e654bd981a149e4368d30b3e5caaae1e49ab42b8f5cd46014728283c63dc1e836fd784', 506, 0, 'Didi Kardiyono', '2018-10-12 09:55:50', 'd.kardiyono_engineering@cssgroup-batam.com', 0, '', '', ''),
(10, 'INDRAWAN', '229b1becbb3ef98ae001ffdfb92db7c9d13870af9d50306944a514d759ca69904deacfe659a19c3b8a744a44e8bfc10581635e8983a4fab8e350c14c250253ad', 'af128c62f01787b7de175565989334da42265d9bfea1522cbef444c0f5483e4ee85a2a113f1269908f9bcd48b54af8857513ed258f17cc48fc3ca8845295baa5', 506, 0, 'Didik Indrawan', '2018-10-12 09:58:28', 'indrawawn_commercial@cssgroup-batam.com', 0, '', '', ''),
(11, 'ROBINSON', '18c442a4d62c325adf397d8c4d9d7f9e5697e2e99fb88ba5843572ae5b70e9df3ac8cbcd3a6abe84ceca037413b64069bfb14eb9feb86099c62d358e4b486179', '6721a98700dc7a9668b37df6fe8a365901ece434a877aea54ebddd21edb2f52fb7bc769261b3904b8be2e60a92b9f20ca6f8f0092962261273b274751591928d', 506, 0, 'Robinson', '2018-10-12 10:01:42', 'robinson_qaqc@cssgroup-batam.com', 0, '', '', ''),
(12, 'GUNAWAN', 'ae34dd24a45c02145949ee432f2e9e7edb1f3d00f99ace432c53c0e50fae89313336ad6e477c36a5ae7858cdc2db9dc91374a420c4d8f004f213a8af476e258f', '692f76ab6a6aa5f05e4275def98a64a48132564c9413a073d491fffc9c1e3f59cf1ef1e5b4624a03df858dc2f31063cacc5393d7334eec4fc101e96788ebc2ae', 506, 0, 'Gunawan Samiarto Laksono', '2018-10-16 09:39:09', 'gunawan@terafulk.com', 0, '', '', ''),
(13, 'dummy', '444dac87282445dc33e349fbf7354f6e1ef5c4e8847b506bc1002ea4df4a9e945ae8d4851f243ef6330dfb5bc3b305d3dcfd44cd4fde5d17207cea740f6d3393', 'c1cf8718c54d0824037540862c04edcb68cd60ad03eb86cf484611db198271cd7c6c242e67ba3cb05fb4cfc3bfbcc1878d1b8dacf0372905ca7400bb97b926eb', 58, 0, 'dummy', '2018-10-30 13:50:00', 'monyet@gmail.com', 0, '', '', ''),
(14, 'FERDIAS', 'c4144abb7afa2b23af514434aeb7b9ab6d7a3fd97a2d87c139597f5401c243c823126fb3a7391361b89db258a91e3317abe690cc7989ffa17418cfb78d3c2424', '7b664579a5865a5d9e3a3984342d9d70439078450d492bd1f93f824bd97c7474bd6153733b7ae48e73c2e80e19216401d56edd4e6e842daded1048c9df30d9c3', 506, 0, 'HR. FERDIAS', '2018-11-14 11:28:59', 'hr.ferdias@ipcmarine.co.id', 1, '', '', ''),
(15, 'WAHAB', '596bebf7a025a9dbe129c646454cae478059507dde2fdef02a56447efb57a6eb3a17c86dc9d3bbb3dca09358b33fb503ddbd486a160ab1c5eb96801bf04338dc', 'b58fbc20ed24a6e5ee03e8f400c8d672257bae85bc189aa9c2b120ef3c95e2e800931e2649ae1317909d5003b551b06cf3f90b37b6657edbce282bb8f688f09a', 506, 0, 'Abdul Wahab', '2018-11-14 11:30:53', 'abdul.wahab@ipcmarine.co.id', 1, '', '', ''),
(16, 'ERFIN', 'a2fb47ff8e88e1de2a9a1b09995108c2a5c702823b621653c050cac7926366db2827f0c67ceee5f67cd620fd12fc57cebb167d5ff7615f1cc634517578c29c35', '4a7b6e3e4da2b71addb2608847097a9964dd07e65e1f53fc8dc018024bb81faf50bd4d7891263e867793410107de18f36dff220af267b4ebb933af97456b51b6', 506, 0, 'Erfin Ardiyanto', '2018-11-14 11:31:37', 'erfin.ardiyanto@ipcmarine.co.id', 1, '', '', ''),
(17, 'IBNU', '19c8e8616b95983f455c7b0b83ea9d65e52c5a61f8d4e2b8ad853fc530d397f00a5df3cffce2261916dbf11555c8d60c293a16ad786bd44bf65d73134fa0c02a', '6e3f4a3910f1efd8c378aa8e5de623f6a08d3270efd086cb57871087bea7fcbccead8f2251a694c197893f26f77de8ed9422cb404f3162322f54ee81cbf4f84e', 506, 0, 'Ibnu Sutowo', '2018-11-14 13:31:28', 'ibnu.sutowo@ipcmarine.co.id', 1, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rm_client`
--
ALTER TABLE `rm_client`
  ADD PRIMARY KEY (`id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rm_client`
--
ALTER TABLE `rm_client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
