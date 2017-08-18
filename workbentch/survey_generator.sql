-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 12, 2017 at 01:18 AM
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
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `text` varchar(100) CHARACTER SET utf8 NOT NULL,
  `count` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `survey_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `survey_id`, `name`, `subject`, `state`) VALUES
(1, 1, 'First page', 'testing', 0),
(2, 1, 'Second Page', 'Testing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `page_id` int(11) UNSIGNED NOT NULL,
  `subject` varchar(200) CHARACTER SET utf8 NOT NULL,
  `type` varchar(6) NOT NULL,
  `mandatory` tinyint(1) NOT NULL,
  `position` smallint(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `start_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  `hash` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `name`, `subject`, `start_date`, `expiration_date`, `state`, `hash`) VALUES
(1, 'Test', 'test', '2017-08-12', '2017-08-14', 0, '6c300461'),
(2, 'asdas', 'sadsdasds', '2017-08-12', '2017-08-14', 1, NULL),
(3, 'asdas', 'sadsdasds', '2017-08-10', '2017-08-14', 1, NULL),
(4, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(5, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(6, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(7, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(8, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(9, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(10, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 1, NULL),
(11, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(12, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(13, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(14, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(15, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(16, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(17, 'asdas', 'sadsdasds', '2017-08-02', '2017-08-04', 0, NULL),
(18, 'Lorem Impsum dolor sit amet', 'Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet Lorem Impsum dolor sit amet', '2017-08-12', '2017-08-30', 0, '437799ef');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_id` (`page_id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
