-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2020 at 03:07 PM
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
-- Table structure for table `rm_workspaces`
--

CREATE TABLE `rm_workspaces` (
  `object_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `project` varchar(255) NOT NULL,
  `team` varchar(255) NOT NULL,
  `starting` date NOT NULL,
  `due` date NOT NULL,
  `progress` int(11) NOT NULL,
  `id_kontrak` varchar(50) NOT NULL,
  `class_id` int(11) NOT NULL,
  `vessel` int(11) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `builder` varchar(255) NOT NULL,
  `submited` varchar(255) NOT NULL,
  `linker` int(11) NOT NULL,
  `finish` date NOT NULL,
  `target` float NOT NULL,
  `description` text NOT NULL,
  `offregnum` varchar(50) NOT NULL,
  `callsign` varchar(50) NOT NULL,
  `flag` varchar(50) NOT NULL,
  `port` varchar(50) NOT NULL,
  `datereg` date NOT NULL,
  `keellaying` date NOT NULL,
  `deliverydate` date NOT NULL,
  `solas` varchar(50) NOT NULL,
  `marpol` varchar(50) NOT NULL,
  `ibcigc` varchar(50) NOT NULL,
  `ism` varchar(50) NOT NULL,
  `notation` varchar(255) NOT NULL,
  `desaigndwt` float NOT NULL,
  `lpp` float NOT NULL,
  `moldedbreadth` float NOT NULL,
  `moldeddepth` float NOT NULL,
  `blublengthfromfp` float NOT NULL,
  `loadinginstr` int(11) NOT NULL,
  `trimstabilitibook` int(11) NOT NULL,
  `kontractlink` text NOT NULL,
  `reason` text NOT NULL,
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trash_date` datetime NOT NULL,
  `trash_byid` int(11) NOT NULL,
  `kadivprb` int(11) NOT NULL,
  `kadivprbat` datetime DEFAULT NULL,
  `kadivsurvey` int(11) NOT NULL,
  `kadivsurveyat` datetime DEFAULT NULL,
  `kadivkemnko` int(11) NOT NULL,
  `kadivkemnkoat` datetime DEFAULT NULL,
  `kodeowner` varchar(50) DEFAULT NULL,
  `sister` varchar(255) DEFAULT NULL,
  `latetask` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rm_workspaces`
--

INSERT INTO `rm_workspaces` (`object_id`, `status`, `project`, `team`, `starting`, `due`, `progress`, `id_kontrak`, `class_id`, `vessel`, `lokasi`, `builder`, `submited`, `linker`, `finish`, `target`, `description`, `offregnum`, `callsign`, `flag`, `port`, `datereg`, `keellaying`, `deliverydate`, `solas`, `marpol`, `ibcigc`, `ism`, `notation`, `desaigndwt`, `lpp`, `moldedbreadth`, `moldeddepth`, `blublengthfromfp`, `loadinginstr`, `trimstabilitibook`, `kontractlink`, `reason`, `create_time`, `trash_date`, `trash_byid`, `kadivprb`, `kadivprbat`, `kadivsurvey`, `kadivsurveyat`, `kadivkemnko`, `kadivkemnkoat`, `kodeowner`, `sister`, `latetask`) VALUES
(430, 2, 'Project KAPLA API', ',53,36,43', '2016-03-01', '2016-03-26', 0, '2147483647', 0, 1, 'masela', '', 'apasdjashdasd', 0, '0000-00-00', 1, '', '0', '0', '0', '0', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-01-26 10:11:00', '2018-09-13 09:48:53', 506, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(451, 2, 'kali Baru', ',505,506,36', '2016-10-03', '2016-10-31', 0, '6788888', 0, 1, 'kali anget', 'PT PAL', 'Mukidi', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-01-26 10:11:00', '2018-09-13 09:49:00', 506, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(453, 2, 'gagak rimang', ',36', '2018-09-13', '2018-09-28', 0, '1233424234', 1234, 3, 'PAL', 'PAL Surabaya', 'Raynaldy', 0, '0000-00-00', 100000, 'sesuai dengan anggaran', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 'link nya', '', '2018-01-26 10:11:00', '2018-09-21 07:59:09', 506, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(454, 2, 'FPU JANGKRIK', ',506', '1970-01-01', '1970-01-01', 0, '6363', 0, 2, 'Ulsan - Korea & Karimun Indonesia', 'Hyundai Heavy Industries', '', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-01-26 10:11:00', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(455, 2, 'FPU JANGKRIK', ',507,36', '2014-07-01', '1970-01-01', 67, '1812070036', 0, 2, 'Ulsan - Korea & Karimun Indonesia', 'Hyundai Heavy Industries', 'STC-JO & HHI', 0, '0000-00-00', 0, 'Jangkrik Field discovered in 2009, belongs to an offshore block called Muara Bakau, located\nwithin the offshore Kutei Basin, Indonesia, at a water depth ranging from 250m to 500m. The\nproject has been undertaken by Eni Indonesia (55% of share, operator) and GDF Suez (45% of\nshare).\nTo date, 3 exploration wells have been drilled â€“ Jangkrik-1, Jangkrik-2 and Jangkrik-3. The\nconcept is based on a subsea development with full treatment facilities on a FPU and an export\nline to shore at Sapi landfall.\nThe barge shaped FPU shall perform full offshore process and export treated gas onshore near\nSAPI existing plant for tie-in of gas to the existing 42â€ pipeline to Badak plant and stabilized\ncondensate to the 20â€ existing pipeline to Senipah plant.\nFinal destination of Jangkrik gas is the Bontang LNG Plant and local market.\nThe vessel to be classified is a newly built barge shaped FPU (Floating Production Unit) to be\noperated in the Indonesian waters.\nBasic design, which has been endorsed and used by FEED Competitors to develop FEED\nactivities, reports the following values:\nLength (overall) : 200.0 m\nBreadth : 50.0 m\nFlag : Indonesia\nThe FPU shall be entirely double side whereas double bottom under the cargo tank area only.\nA requirement of 70 POB (Personnel on board) has been defined as the input for the Jangkrik\nFPU.', '', 'D5KS8', 'Liberia', 'Monrovia', '2017-03-21', '1970-01-01', '2017-03-21', 'MODU', 'Oil Storage', 'N/A', 'MODU', '+ A 100 Floating Offshore Installation (ship type), FL(20), 2037 in Jangkrik Field - Indonesia, IW, + A-SM', 0, 0, 0, 0, 0, 1, 1, '1601360003', '', '2018-01-26 10:11:00', '2020-02-17 11:26:03', 528, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(459, 2, 'Trial', ',41,40,37,507', '2018-02-01', '2018-02-28', 0, '123123123', 123456, 5, 'jakarta', 'Galangan', 'PT apa aja', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-01-26 10:11:00', '2018-01-26 10:34:44', 1, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(460, 2, 'Metal Gear Ray', ',41,40,37,507', '2018-02-01', '2018-05-31', 40, '123456', 56789, 1, 'Jakarta', 'Outer Heaven', 'PT apa aja', 0, '0000-00-00', 100000000000, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-01-26 10:11:00', '2018-09-21 07:59:26', 506, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(469, 2, 'Oceania', ',36,507', '2018-03-01', '2018-12-31', 0, '123', 451320, 4, 'Jakarta', 'PT ABC', 'Sun International', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-01-26 10:36:55', '2018-09-21 07:59:33', 506, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(478, 2, 'UPAPK 2018', ',506', '2018-05-07', '2018-05-17', 0, '1801360002', 0, 21, 'TBA', 'TBA', 'Chendy', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-05-17 08:40:26', '2020-02-17 11:26:15', 528, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(500, 2, 'JAI4X50T', ',40,57,506', '2018-10-01', '2019-11-30', 0, '2200000000', 0, 21, 'Batam - Indonesia', 'PT. CITRA SHIPYARD ', 'DIDIK', 0, '0000-00-00', 1, '', '', '', 'Indonesia', '', '1970-01-01', '1970-01-01', '1970-01-01', 'SOLAS', '', '', 'N/A', '+A100 I P "TUG"', 0, 0, 0, 0, 0, 0, 0, '', '', '2018-09-13 10:14:46', '2018-09-13 11:18:46', 506, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(501, 0, 'JAI PROJECT #TUGBOAT 2 X 2200HP, 50T BOLLARD PULL - X4 ', ',36,519,517,514,513,512,511,510,509,508,57,40,506', '2018-10-10', '2019-12-09', 89, 'HK.55/04/15/MS-18', 1801020318, 21, 'Batam - Indonesia', 'PT. CITRA SHIPYARD ', 'DIDIK', 0, '0000-00-00', 1, 'Sesuai dengan rencana anggaran perusahaan tahun 2017, PT. Jasa Armada Indonesia (JAI) akan melaksanakan pembangunan Kapal Tunda / Harbour Tug dengan daya minimal 2 x 2200 HP dan minimum bollard pull 50 ton dengan tipe kapal ASD, dengan tujuan untuk:\na.	Peningkatan pelayanan jasa pemanduan dan penundaan kepada stakeholder-stakeholder;\nb.	Mendukung kelancaran operasional dan performasi pelayanan kepada pengguna jasa sesuai dengan Permen Hub no.57 tahun 2015 tentang pemanduan dan penundaan kapal;\nc.	Memperkuat armada milik PT Jasa Armada Indonesia untuk mendukung pengembangan pelabuhan di lingkungan PT. Pelabuhan Indonesia II pada khususnya dan Indonesia pada umumnya;\nd.	Pengembangan usaha JAI dengan melakukan kerja sama usaha dengan pihak-pihak lain;\nDalam pelaksanaannya, untuk menjamin kapal dibangun memenuhi spesifikasi teknis yang ditetapkan dan memenuhi persyaratan baik dari Statutoria dan Klasifikasi, JAI menunjuk BKI-SBU Marine & Offshore sebagai konsultan pengawas pembangunan 4 (empat) Kapal Tunda / Harbour Tug dengan daya minimal 2 x 2200 HP dan minimum bollard pull 50 ton dengan tipe kapal Azimuth Stern Drive (ASD).\nSesuai kontrak, pembangunan keempat kapal tersebut ditetapkan 14 (empat belas) bulan oleh PT. Citra Shipyard Batam.', '', '', 'INDONESIA', 'JAKARTA', '1970-01-01', '1970-01-01', '1970-01-01', '', '', '', 'N/A', '+A100 I P ', 0, 32, 11.6, 5.1, 0, 0, 1, 'PERJANJIAN NO. HK.55/04/15/MS-18', '', '2018-09-13 11:19:45', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0),
(662, 2, 'SOLUNA 29', ',522,521,496', '2020-01-31', '2021-08-10', 0, '1901020333', 0, 1, 'NAMA KOTA', 'NAMA GALANGAN (DITARIK DARI PERMOHONAN ', 'NAMA PEMOHON, ABMIL DARI PERMOHONAN OTOMATIS', 0, '0000-00-00', 200000, 'PENERIMAAN BANGUNAN BARU', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-28 10:38:25', '2020-01-30 10:00:39', 496, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(663, 2, '', ',514', '1970-01-01', '1970-01-01', 0, '507_2001020019', 0, 1, '', '', '', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-28 10:39:05', '2020-01-29 15:08:32', 525, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(674, 2, 'project coba 1', ',527,525,524,521,523,526', '2020-01-29', '2021-05-20', 0, '1901020048', 0, 21, 'batam', 'PT. XXX', 'KACAB JAMBI', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-29 11:18:53', '2020-01-30 10:50:41', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(685, 2, 'Testing', ',36', '2020-01-06', '2020-01-31', 0, '1302030499', 0, 0, '', '', 'Paijoo', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 09:40:26', '2020-01-30 10:36:13', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(686, 0, 'CPO TRIAL', ',507,571,547,522,585,583,582,584,36,512,525,528,524,521,496', '2020-01-31', '2020-05-25', 37, '5028291', 0, 0, '', 'KTU BATAM', 'RUSDIANTO', 0, '0000-00-00', 500000, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 09:58:52', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '1025462,1025767', 0),
(687, 2, '', ',36', '2020-01-28', '2020-01-10', 0, '1302010212', 0, 0, '', '', 'rudianto', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 10:36:45', '2020-01-30 10:38:54', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(689, 2, '', ',36', '2020-01-28', '2020-01-10', 0, '1321200124', 0, 0, '', '', 'rudianto', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 10:38:46', '2020-01-30 10:38:51', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(690, 2, 'Testing', ',36', '2020-01-28', '2020-01-10', 0, '1302130071', 0, 0, '', '', 'rudianto', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 10:39:08', '2020-01-30 10:39:11', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(691, 2, 'Testing', ',36', '2020-01-28', '2020-01-10', 0, '1303080011', 0, 0, '', '', 'rudianto', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 10:39:25', '2020-01-30 10:39:39', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(693, 2, '', ',36', '2020-01-05', '2020-01-31', 0, '2012140010', 0, 0, '', '', 'rusdi', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 12:18:34', '2020-01-30 12:18:41', 36, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(694, 2, 'PEGASUS', ',526,496,512,531,529,530,36', '2020-01-05', '2020-01-31', 50, '1312180032', 0, 0, '', '', 'rusdi', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-01-30 12:18:56', '2020-02-17 11:25:32', 528, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(730, 2, 'GERBANG SAMUDRA - 1 KMP.', ',512,566,563,496,537,523,554,509,522,543,548,525,542,565,526', '2020-02-11', '2020-02-12', 50, '100212581', 0, 0, '', '', 'IRAWAN ONGGARA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 11:07:10', '2020-02-11 20:16:29', 496, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(731, 2, 'GANDI KMP.', ',496,512,535,536,555,557,556,560,562,547,546,545,544,539,533', '2020-02-11', '2020-02-12', 60, '80210300', 0, 0, '', '', 'BAHARUDDIN PUA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 11:07:50', '2020-02-11 20:16:34', 496, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(732, 2, 'SUPITAN MAS KM.', ',496,512,553,552,551,550,564,538,561,558,559,521,528,534', '2020-02-11', '2020-02-12', 94, '5027792', 0, 0, '', '', 'CAP.ROY CHARLES R.MAWUNTU', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 11:09:07', '2020-02-11 20:16:38', 496, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(733, 2, 'CLOVER KM.               ', ',528,524,512,496', '2020-02-12', '2020-11-25', 89, '99024490', 0, 0, '', '', 'CAPT. JOHANNES TITUS     ', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 11:24:40', '2020-02-17 11:25:55', 528, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(864, 2, 'SINAR SONA KM.           ', ',537,554,543,548,542,566,565,563,525,523,522,509,524,512,528,496,526', '1970-01-01', '1970-01-01', 91, '1025462', 0, 0, '', '', 'CAPT. SOEDARWAN          ', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 20:58:18', '2020-02-17 11:25:38', 528, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(865, 2, 'SUNNY ROSE KM.           ', ',57,535,536,555,557,556,560,562,547,546,545,544,539,524,512,528,496,533', '1970-01-01', '1970-01-01', 85, '1025767', 0, 0, '', '', 'DIDIEK B. JHAUHARI       ', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 20:59:12', '2020-02-17 11:25:49', 528, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(866, 2, 'SINAR ANDALAS KM.        ', ',567,553,552,551,550,538,561,558,559,564,521,512,524,528,496,534', '1970-01-01', '1970-01-01', 81, '2026043', 0, 0, '', 'PT.Broedin Shipyard', 'E. NAINGGOLAN            ', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-11 20:59:37', '2020-02-17 11:25:43', 528, 0, NULL, 0, NULL, 0, NULL, NULL, '1025462', 0),
(953, 0, 'HARBOUR TUGS B156', ',585,586,587,582,583,584,575,576,551,550,540,558,555,535,536,564,554,523,528,496,534', '2020-02-12', '2021-02-01', 63, '2001040023', 0, 0, '', '', 'BUNKUS HADI WIJAYA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-12 16:02:11', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(954, 0, 'HARBOUR TUGS B157', ',587,586,582,583,585,584,576,575,551,550,540,558,555,554,564,535,536,523,528,496,534', '2020-02-12', '2021-02-01', 62, '2001040024', 0, 0, '', '', 'BUNKUS HADI WIJAYA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-12 16:02:21', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(958, 0, 'KTU - 1303', ',584,582,586,587,585,583,536,569,492,563,558,557,509,523,572,571,570,539,537,535,546,547,526,496,528,532', '2020-02-12', '2021-02-13', 58, '2001020121', 0, 0, '', 'Karya Teknik Utama', 'CHANDRA HERRY', 0, '0000-00-00', 1, 'PT. Karya Teknik Utama', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:49:50', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '2001020122,2001020123,2001020124,2001020125,2001020126,2001020127,2001020128', 0),
(959, 0, 'KTU - 1302', ',584,585,586,582,587,583,569,572,546,539,492,526,547,528,570,571,563,535,496,509,523,536,532', '2020-02-12', '2021-02-13', 6, '2001020122', 0, 0, '', '', 'Karya Teknik Utama', 0, '0000-00-00', 1, 'Ship Yard', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:50:11', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '2001020123,2001020124,2001020125,2001020126,2001020127,2001020128,2001020121', 0),
(960, 0, 'KTU - 1301', ',528,583,584,585,586,582,587,569,556,557,558,546,539,526,492,572,547,571,563,535,496,509,523,536,532', '2020-02-12', '2021-02-13', 0, '2001020123', 0, 0, '', '', 'CHANDRA HERRY', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:50:30', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(961, 0, 'KTU - 1300', ',584,585,586,587,582,583,569,546,539,492,526,547,556,570,528,557,558,571,563,535,496,509,523,536,532', '2020-02-12', '2021-02-13', 0, '2001020124', 0, 0, '', '', 'CHANDRA HERRY', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:50:47', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(962, 0, 'KTU - 1299', ',584,585,586,587,582,583,569,546,539,492,526,572,547,556,537,528,570,557,558,571,563,535,496,509,523,536,532', '2020-02-12', '2021-02-13', 0, '2001020125', 0, 0, '', '', 'CHANDRA HERRY', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:50:56', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(963, 0, 'KTU - 1298', ',528,584,585,586,587,582,583,569,536,539,526,572,547,556,537,570,558,571,563,496,535,509,523,532', '2020-02-12', '2021-02-13', 0, '2001020126', 0, 0, '', '', 'CHANDRA HERRY', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:51:06', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(964, 0, 'KTU - 1297', ',584,585,586,587,582,583,546,539,492,526,572,547,556,537,528,570,558,571,563,535,509,523,536,532', '2020-02-12', '2021-02-13', 0, '2001020127', 0, 0, '', '', 'CHANDRA HERRY', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:51:15', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(965, 0, 'KTU - 1296', ',584,585,586,587,582,583,546,539,492,526,572,547,556,537,528,570,558,571,563,535,509,523,536,532', '2020-02-12', '2021-02-13', 0, '2001020128', 0, 0, '', '', 'CHANDRA HERRY', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-13 08:51:25', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(1091, 0, 'TRANSKO DARA 3209', ',592,583,586,582,587,57,584,523,560,564,558,555,554,492,535,549,565,548,536,528,533,496', '2020-02-16', '2021-02-28', 100, '2001120022', 0, 0, '', 'PT. DRU LAMPUNG', 'STEVEN ANGGA PRANA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-16 13:21:43', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(1092, 0, 'TRANSKO DARA 3210', ',592,583,587,582,586,584,566,560,564,558,555,554,549,565,548,492,523,535,536,528,533,496', '2020-02-16', '2021-02-28', 0, '2001120023', 0, 0, '', 'DRU', 'STEVEN ANGGA PRANA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-16 13:22:02', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(1093, 0, 'TRANSKO DARA 3211', ',592,586,583,587,582,584,566,560,564,558,555,554,492,535,523,549,565,548,536,528,533,496', '2020-02-16', '2021-02-28', 0, '2001120024', 0, 0, '', 'PT. DRU LAMPUNG', 'STEVEN ANGGA PRANA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-16 13:22:14', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(1094, 0, 'TRANSKO DARA 3212', ',592,586,583,587,582,584,523,566,492,565,555,558,560,549,535,548,564,536,528,533,496', '2020-02-16', '2021-02-28', 0, '2001120025', 0, 0, '', '', 'STEVEN ANGGA PRANA', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-02-16 13:22:23', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(1416, 0, 'AH - 124', ',590,589,535,564,522,523,539,571,528,526,496', '1970-01-01', '1970-01-01', 0, '2001020175', 0, 0, '', '', 'PT. PALINDO', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-03-05 07:49:30', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0),
(1417, 0, 'AH - 125', ',590,535,522,564,523,539,571,528,526,496', '1970-01-01', '1970-01-01', 0, '2001020176', 0, 0, '', '', 'PT. PALINDO', 0, '0000-00-00', 1, '', '', '', '', '', '0000-00-00', '0000-00-00', '0000-00-00', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, '', '', '2020-03-05 07:49:46', '0000-00-00 00:00:00', 0, 0, NULL, 0, NULL, 0, NULL, NULL, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rm_workspaces`
--
ALTER TABLE `rm_workspaces`
  ADD PRIMARY KEY (`object_id`),
  ADD UNIQUE KEY `id_kontrak` (`id_kontrak`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
