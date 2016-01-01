-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 04, 2015 at 01:56 AM
-- Server version: 5.5.40-36.1
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `savsoftq_deepak`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_coment`
--

CREATE TABLE IF NOT EXISTS `class_coment` (
  `content_id` int(11) NOT NULL,
  `generated_time` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `content_by` int(11) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_gid`
--

CREATE TABLE IF NOT EXISTS `class_gid` (
  `clgid` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `gid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `difficult_level`
--

CREATE TABLE IF NOT EXISTS `difficult_level` (
  `did` int(11) NOT NULL,
  `level_name` varchar(100) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `difficult_level`
--

INSERT INTO `difficult_level` (`did`, `level_name`, `institute_id`) VALUES
(1, 'Easy', 1),
(2, 'Medium', 1),
(3, 'Difficult', 1);

-- --------------------------------------------------------

--
-- Table structure for table `essay_qsn`
--

CREATE TABLE IF NOT EXISTS `essay_qsn` (
  `essay_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `essay_cont` longtext NOT NULL,
  `essay_score` int(11) NOT NULL,
  `essay_status` int(11) NOT NULL DEFAULT '0',
  `q_type` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `essay_qsn`
--

INSERT INTO `essay_qsn` (`essay_id`, `q_id`, `r_id`, `essay_cont`, `essay_score`, `essay_status`, `q_type`) VALUES
(1, 6, 1, 'Red=Green,BMW=Honda,Keyboard=Mouse,Eye=Nose', 0, 0, 5),
(2, 4, 1, 'Red', 0, 0, 3),
(3, 6, 1, 'Red=Green,BMW=Honda,Keyboard=Mouse,Eye=Nose', 0, 0, 5),
(4, 3, 1, 'Transparent', 0, 0, 2),
(5, 6, 2, 'Red=Mouse,BMW=Nose,Keyboard=Green,Eye=Honda', 0, 0, 5),
(6, 4, 2, 'red', 0, 0, 3),
(7, 3, 2, 'yellow', 0, 0, 2),
(8, 6, 2, 'Red=Mouse,BMW=Nose,Keyboard=Green,Eye=Honda', 0, 0, 5),
(9, 5, 2, 'India is a country in Asia', 1, 1, 0),
(10, 6, 3, 'Red=Nose,BMW=Green,Keyboard=Green,Eye=Mouse', 0, 0, 5),
(11, 4, 3, 'blue', 0, 0, 3),
(12, 3, 3, 'transparent', 0, 0, 2),
(13, 6, 3, 'Red=Nose,BMW=Green,Keyboard=Green,Eye=Mouse', 0, 0, 5),
(14, 5, 3, 'india india', 1, 1, 0),
(15, 6, 4, 'Red=Mouse,BMW=Nose,Keyboard=Honda,Eye=Mouse', 0, 0, 5),
(16, 4, 4, 'blue', 0, 0, 3),
(17, 3, 4, 'transparent', 0, 0, 2),
(18, 6, 4, 'Red=Mouse,BMW=Nose,Keyboard=Honda,Eye=Mouse', 0, 0, 5),
(19, 5, 4, 'india', 1, 1, 0),
(20, 6, 5, 'Red=Nose,BMW=Green,Keyboard=Honda,Eye=Mouse', 0, 0, 5),
(21, 4, 5, 'blue', 0, 0, 3),
(22, 3, 5, 'transparent', 0, 0, 2),
(23, 6, 5, 'Red=Nose,BMW=Green,Keyboard=Honda,Eye=Mouse', 0, 0, 5),
(24, 5, 5, 'india', 1, 1, 0),
(25, 6, 6, 'Red=,BMW=,Keyboard=,Eye=', 0, 0, 5),
(26, 4, 6, 'blue', 0, 0, 3),
(27, 3, 6, 'transparent', 0, 0, 2),
(28, 5, 6, 'india', 1, 1, 0),
(29, 6, 7, 'Red=Nose,BMW=Green,Keyboard=Nose,Eye=Green', 0, 0, 5),
(30, 4, 7, 'blue', 0, 0, 3),
(31, 3, 7, 'transparent', 0, 0, 2),
(32, 6, 7, 'Red=Nose,BMW=Green,Keyboard=Nose,Eye=Green', 0, 0, 5),
(33, 5, 7, 'india is a country', 1, 1, 0),
(34, 6, 8, 'Red=Honda,BMW=Green,Keyboard=Green,Eye=Green', 0, 0, 5),
(35, 4, 8, 'blue', 0, 0, 3),
(36, 3, 8, 'transparent', 0, 0, 2),
(37, 6, 8, 'Red=Honda,BMW=Green,Keyboard=Green,Eye=Green', 0, 0, 5),
(38, 5, 8, 'india', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gcm_ids`
--

CREATE TABLE IF NOT EXISTS `gcm_ids` (
  `gcm_id` int(11) NOT NULL,
  `gcm_regid` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institute_data`
--

CREATE TABLE IF NOT EXISTS `institute_data` (
  `su_institute_id` int(11) NOT NULL,
  `organization_name` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL DEFAULT 'logo.png',
  `contact_info` text NOT NULL,
  `active_till` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `custom_domain` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institute_data`
--

INSERT INTO `institute_data` (`su_institute_id`, `organization_name`, `logo`, `contact_info`, `active_till`, `status`, `description`, `custom_domain`) VALUES
(1, '', 'logo.png', '', 2147483647, 1, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `live_class`
--

CREATE TABLE IF NOT EXISTS `live_class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(1000) NOT NULL,
  `initiated_by` int(11) NOT NULL,
  `initiated_time` int(11) NOT NULL,
  `closed_time` int(11) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `nid` int(11) NOT NULL,
  `gid` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `noti_date` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paypal_ipn`
--

CREATE TABLE IF NOT EXISTS `paypal_ipn` (
  `id` int(11) NOT NULL,
  `itransaction_id` varchar(60) NOT NULL,
  `ipayerid` varchar(60) NOT NULL,
  `iname` varchar(60) NOT NULL,
  `iemail` varchar(60) NOT NULL,
  `itransaction_date` datetime NOT NULL,
  `ipaymentstatus` varchar(60) NOT NULL,
  `ieverything_else` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qbank`
--

CREATE TABLE IF NOT EXISTS `qbank` (
  `qid` int(11) NOT NULL,
  `question` text NOT NULL,
  `description` text NOT NULL,
  `cid` int(11) NOT NULL,
  `did` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1',
  `q_type` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qbank`
--

INSERT INTO `qbank` (`qid`, `question`, `description`, `cid`, `did`, `institute_id`, `q_type`) VALUES
(1, '<p>What is the Capital of India?</p>', '<p>Capital of india is New delhi - here you can describe the solution or answer</p>', 1, 1, 1, 0),
(2, '<p>What is 2+2 =?</p>', '', 1, 1, 1, 1),
(3, '<p>Color of water is _____ .</p>', '', 1, 1, 1, 2),
(4, '<p>What is the color of sky?</p>', '', 1, 1, 1, 3),
(5, '<p>Write an Essay on India in 100 words</p>', '', 1, 1, 1, 4),
(6, '<p>Match the Column by similar category</p>', '', 1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `question_category`
--

CREATE TABLE IF NOT EXISTS `question_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question_category`
--

INSERT INTO `question_category` (`cid`, `category_name`, `institute_id`) VALUES
(1, 'General', 1),
(2, 'Math', 1),
(3, 'General History', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `quid` int(11) NOT NULL,
  `quiz_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `pass_percentage` varchar(5) NOT NULL,
  `test_type` int(1) NOT NULL,
  `credit` varchar(10) NOT NULL,
  `view_answer` int(1) NOT NULL,
  `max_attempts` int(3) NOT NULL,
  `correct_score` varchar(1000) NOT NULL,
  `incorrect_score` varchar(1000) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1',
  `qids_static` text,
  `qselect` int(11) NOT NULL DEFAULT '1',
  `ip_address` text NOT NULL,
  `camera_req` int(1) NOT NULL DEFAULT '0',
  `pract_test` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`quid`, `quiz_name`, `description`, `start_time`, `end_time`, `duration`, `pass_percentage`, `test_type`, `credit`, `view_answer`, `max_attempts`, `correct_score`, `incorrect_score`, `institute_id`, `qids_static`, `qselect`, `ip_address`, `camera_req`, `pract_test`) VALUES
(1, 'Sample Quiz with Photo', '<p>This is sample quiz containing all 6 types of question.</p>\r\n<p>Multiple choice-single answer</p>\r\n<p>Multiple choice-multiple answer</p>\r\n<p>Fill inthe blanks</p>\r\n<p>Short answer</p>\r\n<p>Math the column</p>\r\n<p>Essay</p>\r\n<p>Note: This quiz contain essay type question so your result require manual evaluation by admin.</p>\r\n<p>&nbsp;</p>', 1420050600, 1477938600, 10, '20', 0, '0', 1, 1000, '1', '0', 1, '1,2,6,4,3,5', 0, '', 1, 0),
(2, 'Sample Quiz', '<p>This is sample quiz containing 5 types of question.<br />Multiple choice-single answer<br />Multiple choice-multiple answer<br />Fill inthe blanks<br />Short answer<br />Math the column<br />Nex quiz contain all 6 type of questions</p>\r\n<p>&nbsp;</p>', 1420050600, 1477938600, 10, '20', 0, '0', 1, 510, '1', '0', 1, '1,2,6,4,3', 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_group`
--

CREATE TABLE IF NOT EXISTS `quiz_group` (
  `qgid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_group`
--

INSERT INTO `quiz_group` (`qgid`, `quid`, `gid`, `institute_id`) VALUES
(5, 2, 9, 1),
(6, 2, 10, 1),
(7, 1, 9, 1),
(8, 1, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_qids`
--

CREATE TABLE IF NOT EXISTS `quiz_qids` (
  `qquid` int(11) NOT NULL,
  `quid` text NOT NULL,
  `cid` text NOT NULL,
  `did` text NOT NULL,
  `no_of_questions` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE IF NOT EXISTS `quiz_result` (
  `rid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `quid` int(11) NOT NULL,
  `qids` text NOT NULL,
  `category_name` varchar(1000) DEFAULT NULL,
  `qids_range` varchar(1000) DEFAULT NULL,
  `oids` text NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `last_response` int(11) NOT NULL,
  `time_spent` int(11) NOT NULL,
  `time_spent_ind` text NOT NULL,
  `score` float NOT NULL,
  `percentage` varchar(10) NOT NULL DEFAULT '0',
  `q_result` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `institute_id` int(11) NOT NULL DEFAULT '1',
  `photo` text NOT NULL,
  `essay_ques` int(11) NOT NULL DEFAULT '0',
  `score_ind` varchar(2000) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_result`
--

INSERT INTO `quiz_result` (`rid`, `uid`, `quid`, `qids`, `category_name`, `qids_range`, `oids`, `start_time`, `end_time`, `last_response`, `time_spent`, `time_spent_ind`, `score`, `percentage`, `q_result`, `status`, `institute_id`, `photo`, `essay_ques`, `score_ind`) VALUES
(1, 12, 2, '1,2,6,4,3', 'General', '0-4', '2,6-7,11-12-13-14,10,9', 1425394097, 1425394280, 1425394097, 183, '6,5,14,9,31', 4, '80', 1, 1, 1, '', 0, '1,1,1,0,1'),
(2, 12, 1, '1,2,6,4,3,5', 'General', '0-5', '1,6-7,11-12-13-14,10,9,0', 1425394372, 1425394442, 1425394372, 70, '25,3,10,5,5,0', 2, '33.3333333', 1, 1, 1, '1425394372.jpg', 1, '0,1,0,0,0,1');

-- --------------------------------------------------------

--
-- Table structure for table `q_options`
--

CREATE TABLE IF NOT EXISTS `q_options` (
  `oid` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `option_value` text NOT NULL,
  `score` varchar(10) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `q_options`
--

INSERT INTO `q_options` (`oid`, `qid`, `option_value`, `score`, `institute_id`) VALUES
(1, 1, '<p>Patiala</p>', '0', 1),
(2, 1, '<p>New Delhi</p>', '1', 1),
(3, 1, '<p>Mumbai</p>', '0', 1),
(4, 1, '<p>Chandigarh</p>', '0', 1),
(5, 2, '<p>Five</p>', '0', 1),
(6, 2, '<p>Four</p>', '0.5', 1),
(7, 2, '<p>4</p>', '0.5', 1),
(8, 2, '<p>six</p>', '0', 1),
(9, 3, 'Transparent', '1', 1),
(10, 4, 'Blue,Sky Blue', '1', 1),
(11, 6, 'Red=Green', '0.25', 1),
(12, 6, 'BMW=Honda', '0.25', 1),
(13, 6, 'Keyboard=Mouse', '0.25', 1),
(14, 6, 'Eye=Nose', '0.25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE IF NOT EXISTS `super_admin` (
  `super_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
   `veri` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `super_admin`
--

INSERT INTO `super_admin` (`super_id`, `email`, `username`, `password`) VALUES
(1, 'superadmin@example.com', 'superadmin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `credit` varchar(100) NOT NULL DEFAULT '0',
  `gid` int(10) NOT NULL,
  `su` int(1) DEFAULT '1',
  `main_su_admin` int(11) NOT NULL DEFAULT '0',
  `institute_id` int(11) NOT NULL,
  `veri_code` int(11) NOT NULL,
  `noti` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `credit`, `gid`, `su`, `main_su_admin`, `institute_id`, `veri_code`, `noti`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', 'admin', 'admin', '1000', 9, 1, 1, 1, 0, ''),
(12, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'user@example.com', 'user', 'user', '1000', 9, 0, 0, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `gid` int(11) NOT NULL,
  `group_name` varchar(200) NOT NULL,
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`gid`, `group_name`, `institute_id`) VALUES
(9, 'Group1', 1),
(10, 'Group 2', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_coment`
--
ALTER TABLE `class_coment`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `class_gid`
--
ALTER TABLE `class_gid`
  ADD PRIMARY KEY (`clgid`);

--
-- Indexes for table `difficult_level`
--
ALTER TABLE `difficult_level`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `essay_qsn`
--
ALTER TABLE `essay_qsn`
  ADD PRIMARY KEY (`essay_id`);

--
-- Indexes for table `gcm_ids`
--
ALTER TABLE `gcm_ids`
  ADD PRIMARY KEY (`gcm_id`);

--
-- Indexes for table `institute_data`
--
ALTER TABLE `institute_data`
  ADD PRIMARY KEY (`su_institute_id`);

--
-- Indexes for table `live_class`
--
ALTER TABLE `live_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `paypal_ipn`
--
ALTER TABLE `paypal_ipn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qbank`
--
ALTER TABLE `qbank`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `question_category`
--
ALTER TABLE `question_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quid`);

--
-- Indexes for table `quiz_group`
--
ALTER TABLE `quiz_group`
  ADD PRIMARY KEY (`qgid`);

--
-- Indexes for table `quiz_qids`
--
ALTER TABLE `quiz_qids`
  ADD PRIMARY KEY (`qquid`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `q_options`
--
ALTER TABLE `q_options`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`super_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`gid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_coment`
--
ALTER TABLE `class_coment`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_gid`
--
ALTER TABLE `class_gid`
  MODIFY `clgid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `difficult_level`
--
ALTER TABLE `difficult_level`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `essay_qsn`
--
ALTER TABLE `essay_qsn`
  MODIFY `essay_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `gcm_ids`
--
ALTER TABLE `gcm_ids`
  MODIFY `gcm_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institute_data`
--
ALTER TABLE `institute_data`
  MODIFY `su_institute_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `live_class`
--
ALTER TABLE `live_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paypal_ipn`
--
ALTER TABLE `paypal_ipn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `qbank`
--
ALTER TABLE `qbank`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `question_category`
--
ALTER TABLE `question_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `quiz_group`
--
ALTER TABLE `quiz_group`
  MODIFY `qgid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `quiz_qids`
--
ALTER TABLE `quiz_qids`
  MODIFY `qquid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `q_options`
--
ALTER TABLE `q_options`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `super_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
