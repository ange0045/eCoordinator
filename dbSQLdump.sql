-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 26, 2018 at 09:17 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecoordinator`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_key` varchar(30) NOT NULL,
  `course_pass_grade` varchar(5) NOT NULL DEFAULT 'D-',
  `course_level` varchar(1) NOT NULL,
  `course_name` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`course_key`),
  UNIQUE KEY `course_key_UNIQUE` (`course_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dependencies`
--

DROP TABLE IF EXISTS `dependencies`;
CREATE TABLE IF NOT EXISTS `dependencies` (
  `course_key` varchar(30) NOT NULL,
  `depends_on` varchar(30) NOT NULL,
  PRIMARY KEY (`course_key`,`depends_on`),
  KEY `depends_on` (`depends_on`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `student_id` varchar(15) NOT NULL,
  `student_name` varchar(140) NOT NULL,
  `student_account` varchar(15) DEFAULT NULL,
  `student_type` varchar(2) NOT NULL DEFAULT 'FT',
  `student_email` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentcourse`
--

DROP TABLE IF EXISTS `studentcourse`;
CREATE TABLE IF NOT EXISTS `studentcourse` (
  `student_id` varchar(5) NOT NULL,
  `course_key` varchar(30) NOT NULL,
  `student_grade` varchar(5) NOT NULL,
  `comments` varchar(280) DEFAULT NULL,
  PRIMARY KEY (`student_id`,`course_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(75) NOT NULL,
  `user_fullname` varchar(50) NOT NULL,
  `user_type` varchar(5) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_approval` varchar(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_fullname`, `user_type`, `user_password`, `user_approval`) VALUES
(7, 'tester', 'Test User', 'Admin', '2ac9cb7dc02b3c0083eb70898e549b63', 'Y');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
