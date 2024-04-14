-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2024 at 09:32 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentmarksdisplaysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `AdminID` varchar(50) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `phonenumber` int NOT NULL,
  `Address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`AdminID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `FullName`, `username`, `password`, `usertype`, `phonenumber`, `Address`, `email`) VALUES
('Admin01', 'Methma Hasaranga', 'Methma', 'admin001', 'Admin', 764534543, 'Galle', 'm@gmail.om'),
('Admin02', 'Hasaru', 'Admin02', 'Admin002', 'Admin', 723454323, 'Thalgaswala', 'hasi2518@gmail.com'),
('Admin03', 'Ishini Dilaksha', 'Admin03', 'Admin003', 'Admin', 764354756, 'Galle', 'ishni@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
CREATE TABLE IF NOT EXISTS `grade` (
  `GradeID` varchar(30) NOT NULL,
  `classID` varchar(30) NOT NULL,
  `TID` varchar(50) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  PRIMARY KEY (`GradeID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`GradeID`, `classID`, `TID`, `FullName`) VALUES
('1', '10A', 'Teacher03', ''),
('2', '10B', '', ''),
('3', '10C', '', ''),
('4', '10D', '', ''),
('5', '10E', 'Teacher06', ''),
('6', '11A', '', ''),
('7', '11B', 'Teacher05', 'Mihiri kawmini'),
('8', '11C', '', ''),
('9', '11D', '', ''),
('10', '11E', '', ''),
('11', '6A', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

DROP TABLE IF EXISTS `marks`;
CREATE TABLE IF NOT EXISTS `marks` (
  `SID` varchar(50) NOT NULL,
  `Term` varchar(5) NOT NULL,
  `Sinhala` int NOT NULL,
  `Maths` int NOT NULL,
  `Science` int NOT NULL,
  `History` int NOT NULL,
  `Buddhist` int NOT NULL,
  `English` int NOT NULL,
  `feedback` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`SID`, `Term`, `Sinhala`, `Maths`, `Science`, `History`, `Buddhist`, `English`, `feedback`) VALUES
('Student003', '2', 67, 7, 8, 7, 7, 8, 'verybad'),
('Student001', '3', 67, 7, 8, 7, 7, 8, 'verybad'),
('Student001', '1', 4, 4, 4, 4, 2, 1, 'very bad'),
('Student002', '1', 90, 78, 89, 56, 95, 59, 'Good ');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `SID` varchar(30) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `Email` varchar(70) NOT NULL,
  `phonenum` int NOT NULL,
  `Class` varchar(4) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `usertype` varchar(8) NOT NULL,
  PRIMARY KEY (`SID`),
  KEY `password` (`password`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`SID`, `username`, `password`, `Fullname`, `Email`, `phonenum`, `Class`, `Address`, `usertype`) VALUES
('Student001', 'GRADE06A', 'Student001', 'Hasaru Pathmindu', 'hasi@gmail.com', 765454367, '6A', 'Mapalagama,Galle', 'Student'),
('Student002', 'GRADE06B', 'Student002', 'Methuka', 'm@gmail.com', 765454334, '6A', 'Mathara', 'Student'),
('Student003', 'Manisha', 'Student003', 'Manisha Sadakalum', 'manisha@gmail.com', 745365435, '11A', 'Galle', 'Student'),
('Student004', 'Sadun', 'Student004', 'Sadun Nishantha', 'sadun@gmail.com', 745365765, '11A', 'Galle', 'Student'),
('Student005', 'Hiran', 'Student05', 'Hiran Thikshana', 'hiran@gmail.com', 875643523, '10C', 'Galle', 'Student'),
('Student006', 'Mihiran', 'Student0006', 'Mihiran Thikshana', 'mihiran@gmail.com', 914234545, '11B', 'Mathara', 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `studentgrade`
--

DROP TABLE IF EXISTS `studentgrade`;
CREATE TABLE IF NOT EXISTS `studentgrade` (
  `SID` varchar(30) NOT NULL,
  `GID` varchar(15) NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `studentgrade`
--

INSERT INTO `studentgrade` (`SID`, `GID`) VALUES
('Student005', '10C'),
('Student006', '11B'),
('s1', '10A');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `subID` varchar(5) NOT NULL,
  `subname` varchar(50) NOT NULL,
  PRIMARY KEY (`subID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subID`, `subname`) VALUES
('1', 'Sinhala'),
('2', 'Maths'),
('3', 'Science'),
('4', 'History'),
('5', 'English'),
('6', 'Buddhist');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE IF NOT EXISTS `teacher` (
  `TID` varchar(30) NOT NULL,
  `FullName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(10) NOT NULL,
  `address` varchar(100) NOT NULL,
  `GID` varchar(3) NOT NULL,
  PRIMARY KEY (`TID`),
  UNIQUE KEY `GID` (`GID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`TID`, `FullName`, `username`, `Password`, `usertype`, `email`, `phonenumber`, `address`, `GID`) VALUES
('Teacher01', 'Methma Hasaranga', 'Teacher001', 'Teacher001', 'Teacher', 'm@gmail.com', '0764534543', 'Galle', '6A'),
('Teacher02', 'Hasaru Pathmindu', 'Teacher02', 'Teacher02', 'Teacher', 'hasi@gmail.com', '0724563544', 'Gampaha', '10C'),
('Teacher03', 'Dilaksha', 'Teacher03', 'Teacher003', 'Teacher', 'dilakshawijesekara2518@gmail.com', '0773677628', '1/1/D/1, 03rd lane, Niyagama, Thalgaswala', '10B'),
('Teacher06', 'Dilaksha Wijesekara', 'Teacher006', 'Teacher006', 'Teacher', 'dila@gmail.com', '0987865676', 'Galle', '11A'),
('Teacher05', 'Mihiri kawmini', 'Mihiri', 'Teacher005', 'Teacher', 'mihiri@gmail.com', '0764565656', 'Galle', '11C');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
