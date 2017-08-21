-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 21, 2017 at 08:35 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

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
  `text` varchar(500) CHARACTER SET utf8 NOT NULL,
  `count` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_id`, `text`, `count`) VALUES
(149, 51, 'Shout it from the rooftops, announce it to the media, etc.', 70),
(150, 51, 'Mention it only to my closest friends and family members', 91),
(151, 51, 'Mention it only to my significant other and maybe one other person', 78),
(152, 51, 'Keep it strictly between my lawyer and myself; money can do funny things to human relationships', 65),
(153, 52, 'Feel and act jealous', 29),
(154, 52, 'Feel happy for me', 76),
(155, 52, 'Feel mixed feelings about my sudden good fortune', 78),
(156, 52, 'Try to get in my good graces', 55),
(157, 53, 'Actors, models and rock stars', 94),
(158, 53, 'Inventors and creative geniuses', 39),
(159, 53, 'Major politicians and world leaders', 20),
(160, 53, 'CEOs and other business leaders', 54),
(161, 54, 'Strongly agree', 47),
(162, 54, 'Agree', 77),
(163, 54, 'Disagree', 94),
(164, 54, 'Strongly disagree', 43),
(165, 55, 'True', 105),
(166, 55, 'False', 64),
(167, 56, 'Strongly agree', 30),
(168, 56, 'Agree', 39),
(170, 56, 'Disagree', 15),
(172, 56, 'Strongly disagree', 86),
(175, 58, 'Strongly agree', 69),
(176, 58, 'Agree', 92),
(177, 58, 'Disagree', 46),
(178, 58, 'Strongly disagree', 43),
(183, 60, 'Strongly agree', 65),
(184, 60, 'Agree', 62),
(185, 60, 'Disagree', 42),
(186, 60, 'Strongly disagree', 48),
(187, 61, 'Food', 0),
(188, 61, 'Quack', 0),
(189, 61, 'For Dinner', 0),
(190, 61, 'Oh no!!! The aliens are coming for my percent signs!!!', 0),
(191, 62, '...Food?', 0),
(192, 62, 'hmm... I go to school and mantain a good average.', 0),
(193, 62, '........................ (me: you don\'t know what describe means, do you?)', 0),
(194, 63, '...Food?!', 0),
(195, 63, 'gasp OMG WHERE???!!!???!!!?!?!?!!!!!!!?!?!??!!?!!?', 0),
(196, 63, '............................... (me: you don\'t know what chocolate is?!)', 0),
(197, 63, 'MMMMmmmm..... sugar.', 0),
(198, 64, '... food?', 0),
(199, 64, '... sentence? where? (me: oops...) YOU FORGOT THE SENTENCE?! (me: chill down, yeesh...)', 0),
(200, 64, '.......................................... (me: you\'ve got mental health issues.)', 0),
(201, 64, 'Platipie??? (inside joke....)', 0),
(202, 65, '...... Food???!!! (me: Oh, shut up already!!!)', 0),
(203, 66, 'Mickey D\'s Burgers', 1108),
(204, 66, 'Chucky\'s Pizza', 852),
(205, 67, 'Fries from McDonald\'s', 1160),
(206, 67, 'Bread Sticks from Chuck E. Cheese\'s', 916),
(207, 68, 'McDonald\'s Menu', 917),
(208, 68, 'Chuck E. Cheese\'s Menu', 844),
(209, 69, 'McDonald\'s', 1121),
(210, 69, 'Chuck E. Cheese\'s', 1041),
(211, 70, '&quot;I\'m Lovin\' It!&quot;', 1129),
(212, 70, '&quot;Where A Kid Can Be A Kid!&quot;', 644),
(213, 71, 'Ronald McDonald', 647),
(214, 71, 'Chuck E. Cheese', 515),
(215, 72, 'Birdie the Early Bird', 1060),
(216, 72, 'Helen Henny', 924),
(217, 73, 'Grimace', 1128),
(218, 73, 'Mr. Munch', 294),
(219, 74, 'Hamburglar', 318),
(220, 74, 'Jasper T. Jowls', 162),
(221, 75, 'McDonald\'s', 208),
(222, 75, 'Chuck E. Cheese\'s', 997),
(223, 76, 'Arabic', 314),
(224, 76, 'Chinese (includes Mandarin, Jin, Wu, Huizhou, Gan, Xiang, Min, Hakka, Yue, Pinghua and others)', 844),
(225, 76, 'Dutch', 1105),
(226, 76, 'English', 147),
(227, 76, 'Finnish', 644),
(228, 76, 'French', 917),
(229, 76, 'German', 960),
(230, 76, 'Italian', 971),
(231, 76, 'Japanese', 970),
(232, 76, 'Korean', 526),
(233, 76, 'Language predominantly found in India (includes Hindi, Bengali, Punjabi, Telugu, Marathi, Tamil, Urdu, Kannada, Gujarati, Odia, Malayalam, Sanskrit and others)', 289),
(234, 76, 'Language predominantly found in Indonesia (includes Indonesian, Malay, Javanese, Sundanese, Madurese, Minangkabau and others)', 683),
(235, 76, 'Language predominantly found in Scandinavia (includes Swedish, Norwegian and Danish)', 358),
(236, 76, 'Persian', 1034),
(237, 76, 'Polish', 283),
(238, 76, 'Portuguese', 165),
(239, 76, 'Russian', 422),
(240, 76, 'Spanish', 476),
(241, 76, 'Swahili', 956),
(242, 76, 'Turkish', 677),
(243, 76, 'Vietnamese', 556),
(244, 76, 'Other language', 543),
(245, 76, 'I prefer not to answer this question', 1011),
(246, 77, 'Arabic', 118),
(247, 77, 'Chinese (includes Mandarin, Jin, Wu, Huizhou, Gan, Xiang, Min, Hakka, Yue, Pinghua and others)', 868),
(248, 77, 'Dutch', 926),
(249, 77, 'English', 485),
(250, 77, 'Finnish', 406),
(251, 77, 'French', 434),
(252, 77, 'German', 350),
(253, 77, 'Italian', 869),
(254, 77, 'Japanese', 685),
(255, 77, 'Korean', 396),
(256, 77, 'Language predominantly found in India (includes Hindi, Bengali, Punjabi, Telugu, Marathi, Tamil, Urdu, Kannada, Gujarati, Odia, Malayalam, Sanskrit and others)', 595),
(257, 77, 'Language predominantly found in Indonesia (includes Indonesian, Malay, Javanese, Sundanese, Madurese, Minangkabau and others)', 952),
(258, 77, 'Language predominantly found in Scandinavia (includes Swedish, Norwegian and Danish)', 489),
(259, 77, 'Persian', 325),
(260, 77, 'Polish', 1198),
(261, 77, 'Portuguese', 1000),
(262, 77, 'Russian', 802),
(263, 77, 'Spanish', 957),
(264, 77, 'Swahili', 395),
(265, 77, 'Turkish', 753),
(266, 77, 'Vietnamese', 1180),
(267, 77, 'Other language', 1093),
(268, 77, 'I don\'t speak a second language', 1173),
(269, 77, 'I prefer not to answer this question', 150),
(270, 78, 'Arabic', 219),
(271, 78, 'Chinese (includes Mandarin, Jin, Wu, Huizhou, Gan, Xiang, Min, Hakka, Yue, Pinghua and others)', 391),
(272, 78, 'Dutch', 354),
(273, 78, 'English', 945),
(274, 78, 'Finnish', 1104),
(275, 78, 'French', 315),
(276, 78, 'German', 1000),
(277, 78, 'Italian', 607),
(278, 78, 'Japanese', 772),
(279, 78, 'Korean', 793),
(280, 78, 'Language predominantly found in India (includes Hindi, Bengali, Punjabi, Telugu, Marathi, Tamil, Urdu, Kannada, Gujarati, Odia, Malayalam, Sanskrit and others)', 1197),
(281, 78, 'Language predominantly found in Indonesia (includes Indonesian, Malay, Javanese, Sundanese, Madurese, Minangkabau and others)', 911),
(282, 78, 'Language predominantly found in Scandinavia (includes Swedish, Norwegian and Danish)', 962),
(283, 78, 'Persian', 304),
(284, 78, 'Polish', 1057),
(285, 78, 'Portuguese', 1069),
(286, 78, 'Russian', 884),
(287, 78, 'Spanish', 187),
(288, 78, 'Swahili', 698),
(289, 78, 'Turkish', 1144),
(290, 78, 'Vietnamese', 413),
(291, 78, 'Other language', 269),
(292, 78, 'I don\'t speak a third language', 351),
(293, 78, 'I prefer not to answer this question', 556);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) UNSIGNED NOT NULL,
  `survey_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(500) CHARACTER SET utf8 NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `survey_id`, `name`, `subject`, `state`) VALUES
(28, 58, 'What Kind of SUPER Rich Person Would You Be?', 'Unless you just won the lottery, or you\'re a co-founder of Google, or you just got the check in the mail for your Nobel Prize, the following fun quiz is as much a fantasy for you as it is for the rest of us.', 1),
(29, 58, 'What Kind of SUPER Rich Person Would You Be?', 'A &quot;Paris Hilton&quot;... a &quot;Bill Gates&quot;... a &quot;Warren Buffet&quot;... or a &quot;George Soros&quot;?', 1),
(30, 60, 'First page of randomness', 'Title says it all!!', 1),
(31, 61, 'First page', 'Two place where kids can eat and play at the same time!', 1),
(32, 61, 'Second Page', 'Two place where kids can eat and play at the same time!', 1),
(33, 62, 'People and their Languages', 'An opinion survey on languages and language learning.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `page_id` int(11) UNSIGNED NOT NULL,
  `subject` varchar(500) CHARACTER SET utf8 NOT NULL,
  `type` varchar(6) NOT NULL,
  `mandatory` tinyint(1) NOT NULL,
  `position` smallint(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `page_id`, `subject`, `type`, `mandatory`, `position`) VALUES
(51, 28, 'If you suddenly came into some serious money, you would:', 'multi', 1, 1),
(52, 28, 'If people were to find out that you had suddenly become very wealthy, they would most likely:', 'single', 1, 2),
(53, 28, 'If you were to become enormously wealthy, out of the following you would likely spend most of your time with:', 'multi', 0, 3),
(54, 28, 'I think people who are extremely wealthy have an obligation to donate a significant portion of their money to charities.', 'single', 1, 4),
(55, 28, 'There is a good reason that &quot;Avarice&quot; is included as one of the &quot;Seven Deadly Sins.&quot; After all, money is the root of (nearly) all evil.', 'single', 1, 5),
(56, 29, 'People who have a lot of money should concentrate first and foremost on saving and investing it wisely.', 'single', 0, 1),
(58, 29, 'You only live once, and everyone knows that, &quot;You can\'t take it with you!&quot; So I say, if you\'ve got it, spend it on whatever you like, no matter how silly or frivolous!', 'single', 1, 2),
(60, 29, 'Donating to an important cause, campaign, or political movement that they believe in passionately is one of the absolute best ways for wealthy people to spend their surplus money.', 'single', 1, 4),
(61, 30, 'I say &quot;Chicken,&quot; you say...', 'single', 1, 1),
(62, 30, 'Describe yourself.', 'multi', 0, 2),
(63, 30, 'Chocolate', 'single', 1, 3),
(64, 30, 'What do you think of this sentence...', 'single', 1, 4),
(65, 30, 'What\'d you think??', 'multi', 1, 5),
(66, 31, 'First off, every restaurant has a food most commonly associated with it! Which do you prefer?', 'single', 1, 1),
(67, 31, 'Every main course has a side to go with it! Which do you prefer?', 'single', 0, 2),
(68, 31, 'But both of these places have more than just the usual main course, side, drink and dessert. Both have entire menus of things to eat and drink. Which do you prefer?', 'multi', 1, 3),
(69, 31, 'But kids don\'t want to just eat! They want to play while the food\'s cooking. Which place is better for kids to have fun at?', 'single', 1, 4),
(70, 31, 'Every company needs a slogan! Which is better?', 'single', 0, 5),
(71, 32, 'In an attempt to draw attention from children, a lot of business\'s make a kid-friendly mascot! And what kid-friendly mascot could be better than a wierd clown and a creepy animatronic rat! Which one?', 'single', 1, 1),
(72, 32, 'But both places have an entire cast of mascots! Like female birds! Which character is better?', 'single', 1, 2),
(73, 32, 'Both of these places also have wierd, purple guys that nobody knows exactly what they\'re supposed to be? Which character?', 'single', 1, 3),
(74, 32, 'One hunts outlaws, one is an outlaw! Which character do you prefer?', 'single', 1, 4),
(75, 32, 'Finally, which restaurant/playland do you prefer overall?', 'single', 1, 5),
(76, 33, 'What is your mother tongue?', 'single', 1, 1),
(77, 33, 'What is your second language?', 'single', 1, 2),
(78, 33, 'What is your third language?', 'single', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(500) CHARACTER SET utf8 NOT NULL,
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
(58, 'What Kind of SUPER Rich Person Would You Be?', 'Unless you just won the lottery, or you\'re a co-founder of Google, or you just got the check in the mail for your Nobel Prize, the following fun quiz is as much a fantasy for you as it is for the rest of us.\r\n \r\nHowever, you\'ll actually see there is also some real value in learning what kind of fantastically wealthy person you would be because, upon just a bit of reflection, you\'ll discover it is likely similar to the way you are treating your (much more limited) finances today. And that can either be satisfying, or prompt you to evaluate changing your habits!\r\n \r\nSo given the opportunity, what kind of &quot;big spender&quot; do you think you would be? A &quot;Paris Hilton&quot;... a &quot;Bill Gates&quot;... a &quot;Warren Buffet&quot;... or a &quot;George Soros&quot;?', '2017-08-18', '2017-08-20', 1, 'ea56bdaa'),
(60, 'The Random Quiz!!!', 'This is just a VERY RANDOM QUIZ!!', '2017-08-24', '2017-08-28', 1, '81e45efe'),
(61, 'McDonald\'s vs Chuck E Cheese\'s', 'Two place where kids can eat and play at the same time!', '2017-08-21', '2017-08-25', 1, '36f99ffa'),
(62, 'People and their Languages', 'An opinion survey on languages and language learning. \r\n\r\nNote: This survey is heavily based on &quot;Europeans and their Languages&quot; from 2012 which was conducted by TNS Opinion and Social.', '2017-08-21', '2017-08-24', 1, 'efdfdcf7'),
(63, 'Favorite Harry Potter character', 'Favorite Harry Potter character survey. Let as know which character is your favorite!!', '2017-08-21', '2017-08-25', 0, '58c21df3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
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
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
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
