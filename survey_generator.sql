-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2017 at 01:31 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey_generator`
--

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `start_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `name`, `subject`, `start_date`, `expiration_date`, `state`) VALUES
(1, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(2, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(3, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(4, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(5, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(6, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(7, 'My first survey', 'test', '2017-08-24', '2017-09-07', 0),
(8, 'asdas', 'dfs', '2017-08-24', '2017-08-30', 0),
(9, 'asdas', 'dfs', '2017-08-24', '2017-08-30', 0),
(10, 'Abel', 'asdad', '2017-08-17', '2017-09-07', 0),
(11, 'Abel', 'asdad', '2017-08-17', '2017-09-07', 0),
(12, 'Abel', 'asdad', '2017-08-17', '2017-09-07', 0),
(13, 'Abel', 'asdad', '2017-08-17', '2017-09-07', 0),
(14, 'nkjdsdfnkjsd', 'fkjsfjs', '2017-08-16', '2017-09-07', 0),
(15, 'Survey', 'Physics', '2017-08-18', '2017-08-31', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
