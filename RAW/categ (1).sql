-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2019 at 02:22 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helptimize_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `categ`
--

CREATE TABLE `categ` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `descr` text,
  `parent_id` int(11) DEFAULT NULL,
  `notes` mediumtext,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categ`
--

INSERT INTO `categ` (`id`, `name`, `descr`, `parent_id`, `notes`, `status`) VALUES
(11, 'Home/DIY Market/Handyman', '', NULL, '', 0),
(12, 'Delivery Service', '', NULL, '', 0),
(13, 'Pets', '', NULL, '', 0),
(14, 'Home Tutoring', '', NULL, '', 0),
(15, 'Web/IT/Software1', 'aaaaa', NULL, '', 1),
(16, 'Graphic Design/Media/Architecture', '', NULL, '', 0),
(18, 'Child Care Services (Baby Sitting)', '', NULL, '', 0),
(200, 'Others', '', NULL, '', 0),
(201, 'LAUNDRY', 'PUNE LAUNDRY SERVICE ', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categ`
--
ALTER TABLE `categ`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categ`
--
ALTER TABLE `categ`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
