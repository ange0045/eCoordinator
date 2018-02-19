-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2018 at 01:45 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ecoordinator`
--
CREATE DATABASE IF NOT EXISTS `ecoordinator` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ecoordinator`;

-- --------------------------------------------------------

--
-- Table structure for table `COURSE`
--

CREATE TABLE `COURSE` (
  `course_key` varchar(30) NOT NULL,
  `course_pass_grade` varchar(5) NOT NULL,
  `course_dependent` varchar(1) NOT NULL,
  `course_dependency` varchar(30) DEFAULT NULL,
  `course_level` varchar(1) NOT NULL,
  `course_comments` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `COURSEKEY`
--

CREATE TABLE `COURSEKEY` (
  `course_id` varchar(10) NOT NULL,
  `course_key` varchar(30) NOT NULL,
  `course_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `INTAKE`
--

CREATE TABLE `INTAKE` (
  `inkate_key` varchar(20) NOT NULL,
  `intake_year` int(11) NOT NULL,
  `intake_term` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PROGRAMKEY`
--

CREATE TABLE `PROGRAMKEY` (
  `program_id` varchar(10) NOT NULL,
  `program_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `STUDENT`
--

CREATE TABLE `STUDENT` (
  `student_id` varchar(15) NOT NULL,
  `student_last_name` varchar(20) NOT NULL,
  `student_first_name` varchar(20) NOT NULL,
  `student_account` varchar(15) NOT NULL,
  `student_type` varchar(2) NOT NULL,
  `student_comments` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `STUDENTCOURSE`
--

CREATE TABLE `STUDENTCOURSE` (
  `student_course_key` varchar(30) NOT NULL,
  `student_id` varchar(5) NOT NULL,
  `course_key` varchar(30) NOT NULL,
  `student_grade` varchar(5) NOT NULL,
  `student_pass_yn` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE `USERS` (
  `user_id` int(10) NOT NULL,
  `user_username` varchar(75) NOT NULL,
  `user_fullname` varchar(50) NOT NULL,
  `user_type` varchar(5) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_approval` varchar(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USERS`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `COURSE`
--
ALTER TABLE `COURSE`
  ADD PRIMARY KEY (`course_key`),
  ADD UNIQUE KEY `course_key_UNIQUE` (`course_key`);

--
-- Indexes for table `COURSEKEY`
--
ALTER TABLE `COURSEKEY`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_key_UNIQUE` (`course_key`),
  ADD UNIQUE KEY `course_id_UNIQUE` (`course_id`);

--
-- Indexes for table `INTAKE`
--
ALTER TABLE `INTAKE`
  ADD PRIMARY KEY (`inkate_key`);

--
-- Indexes for table `PROGRAMKEY`
--
ALTER TABLE `PROGRAMKEY`
  ADD PRIMARY KEY (`program_id`);

--
-- Indexes for table `STUDENT`
--
ALTER TABLE `STUDENT`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `STUDENTCOURSE`
--
ALTER TABLE `STUDENTCOURSE`
  ADD PRIMARY KEY (`student_course_key`);

--
-- Indexes for table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
