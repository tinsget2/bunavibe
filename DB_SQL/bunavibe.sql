-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 20, 2022 at 07:45 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bunavibe`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longtiude` double DEFAULT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tab`
--

DROP TABLE IF EXISTS `admin_tab`;
CREATE TABLE IF NOT EXISTS `admin_tab` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `admin_Alies` varchar(100) NOT NULL,
  `admin_Name` varchar(100) NOT NULL,
  `admin_Username` varchar(100) NOT NULL,
  `admin_Email` varchar(100) NOT NULL,
  `admin_Password` varchar(100) NOT NULL,
  `admin_Token` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_tab`
--

INSERT INTO `admin_tab` (`ID`, `admin_Alies`, `admin_Name`, `admin_Username`, `admin_Email`, `admin_Password`, `admin_Token`) VALUES
(1, 'tins123456', 'Tinsae Getachew', 'tinsget', 'tinsget2@gmail.com', '123456', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

DROP TABLE IF EXISTS `apply`;
CREATE TABLE IF NOT EXISTS `apply` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `jobAlies` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alias` (`alias`,`jobAlies`),
  KEY `jobAlies` (`jobAlies`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chashout`
--

DROP TABLE IF EXISTS `chashout`;
CREATE TABLE IF NOT EXISTS `chashout` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `perchaseNumber` varchar(100) NOT NULL,
  `requestedBy` varchar(100) NOT NULL,
  `wihdrowalAmount` int(11) NOT NULL,
  `withdrowalCompleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`),
  KEY `perchaseNumber` (`perchaseNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `companyaddress`
--

DROP TABLE IF EXISTS `companyaddress`;
CREATE TABLE IF NOT EXISTS `companyaddress` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `jobAlies` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `jobAlies` (`jobAlies`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cv`
--

DROP TABLE IF EXISTS `cv`;
CREATE TABLE IF NOT EXISTS `cv` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `path` varchar(100) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `eduAlies` varchar(100) NOT NULL,
  `degreeType` varchar(32) NOT NULL,
  `graduatedIn` varchar(100) NOT NULL,
  `minor` varchar(100) DEFAULT NULL,
  `major` varchar(100) DEFAULT NULL,
  `graduatedFrom` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNIQUE_Education_Field` (`alies`,`graduatedIn`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

DROP TABLE IF EXISTS `experience`;
CREATE TABLE IF NOT EXISTS `experience` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `expAlies` varchar(100) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNIQUE_Exp_Filds` (`alies`,`companyName`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `giftperchase`
--

DROP TABLE IF EXISTS `giftperchase`;
CREATE TABLE IF NOT EXISTS `giftperchase` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `perchaseAlies` varchar(100) NOT NULL,
  `giftOwner` varchar(100) NOT NULL,
  `giftAlies` varchar(100) NOT NULL,
  `noOfGiftsSend` int(11) NOT NULL DEFAULT '0',
  `noOfGiftRecived` int(11) NOT NULL DEFAULT '0',
  `numberOfGift` int(11) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT '0',
  `transactionNumber` varchar(100) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `perchaseAlies` (`perchaseAlies`),
  UNIQUE KEY `giftOwner` (`giftOwner`,`giftAlies`,`perchaseAlies`) USING BTREE,
  KEY `giftAlies` (`giftAlies`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

DROP TABLE IF EXISTS `gifts`;
CREATE TABLE IF NOT EXISTS `gifts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `giftAlias` varchar(100) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `reciver` varchar(100) NOT NULL,
  `giftType` varchar(100) DEFAULT NULL,
  `totalGift` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `gifts_ibfk_2` (`reciver`),
  KEY `sender` (`sender`),
  KEY `giftAlias` (`giftAlias`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `giftspackage`
--

DROP TABLE IF EXISTS `giftspackage`;
CREATE TABLE IF NOT EXISTS `giftspackage` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) NOT NULL,
  `giftType` varchar(100) NOT NULL,
  `unitPrice` float NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gifttotal`
--

DROP TABLE IF EXISTS `gifttotal`;
CREATE TABLE IF NOT EXISTS `gifttotal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `perchaseNumber` varchar(100) NOT NULL,
  `giftAlies` varchar(100) NOT NULL,
  `giftOwner` varchar(100) DEFAULT NULL,
  `noOfGiftsSend` int(11) NOT NULL DEFAULT '0',
  `noOfGiftsRecived` int(11) NOT NULL DEFAULT '0',
  `totalGift` double NOT NULL,
  `approval` int(11) NOT NULL DEFAULT '1',
  `checkOutAmount` int(11) NOT NULL DEFAULT '0',
  `checkOutApproved` int(11) NOT NULL DEFAULT '0',
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `perchaseNumber` (`perchaseNumber`) USING BTREE,
  UNIQUE KEY `giftAlies` (`giftAlies`,`giftOwner`),
  KEY `gifttotal_ibfk_1` (`giftOwner`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

DROP TABLE IF EXISTS `interests`;
CREATE TABLE IF NOT EXISTS `interests` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `interest` varchar(100) NOT NULL,
  `interestCounter` int(11) NOT NULL DEFAULT '1',
  `interestPersent` int(11) NOT NULL DEFAULT '1',
  `interestWeight` int(11) NOT NULL DEFAULT '1',
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  KEY `User_Interests` (`alies`,`interest`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `matching`
--

DROP TABLE IF EXISTS `matching`;
CREATE TABLE IF NOT EXISTS `matching` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `aliesUserOne` varchar(100) NOT NULL,
  `userOneAccept` int(11) NOT NULL,
  `aliesUserTwo` varchar(100) NOT NULL,
  `giftForUserOne` varchar(100) DEFAULT NULL,
  `userOneMatchStatus` int(11) NOT NULL DEFAULT '1',
  `cheked` int(11) NOT NULL DEFAULT '0',
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `aliesUserOne` (`aliesUserOne`,`aliesUserTwo`),
  KEY `aliesUserTwo` (`aliesUserTwo`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `userOne` varchar(100) NOT NULL,
  `userTwo` varchar(100) DEFAULT NULL,
  `message` varchar(500) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`,`userOne`,`userTwo`),
  KEY `message_ibfk_1` (`userOne`),
  KEY `userTwo` (`userTwo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `path` varchar(100) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `bootePost` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`,`path`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `skill` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`,`skill`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE IF NOT EXISTS `userinfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fullName` varchar(100) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `gender` varchar(32) DEFAULT NULL,
  `InterestedIn` varchar(20) DEFAULT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `verification` varchar(100) NOT NULL,
  `photoVerify` int(11) NOT NULL DEFAULT '0',
  `about` varchar(200) DEFAULT NULL,
  `accountType` int(11) NOT NULL DEFAULT '3',
  `selectedAgeRangeMin` int(11) NOT NULL DEFAULT '18',
  `selectedAgeRangeMax` int(11) NOT NULL DEFAULT '100',
  `status` int(11) NOT NULL DEFAULT '2',
  `privacy` int(11) NOT NULL DEFAULT '1',
  `userType` int(11) NOT NULL DEFAULT '6',
  `iat` bigint(20) DEFAULT NULL,
  `expiredDate` bigint(20) DEFAULT NULL,
  `boosteDatingAccount` int(11) NOT NULL DEFAULT '0',
  `boosteWorkAccount` int(11) NOT NULL DEFAULT '0',
  `onlineStatus` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `alies` (`alies`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vacancy`
--

DROP TABLE IF EXISTS `vacancy`;
CREATE TABLE IF NOT EXISTS `vacancy` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `alies` varchar(100) NOT NULL,
  `jobAlies` varchar(100) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `aboutCompany` varchar(200) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `jobCatagory` varchar(100) NOT NULL,
  `jobType` varchar(50) NOT NULL,
  `jobEducation` varchar(100) NOT NULL,
  `experience` varchar(100) NOT NULL,
  `salary` varchar(100) NOT NULL,
  `postedDate` date NOT NULL,
  `endDate` date NOT NULL,
  `duty` varchar(200) NOT NULL,
  `requirement` varchar(200) NOT NULL,
  `applyMethod` varchar(100) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '2',
  `boosteVacancy` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `jobAlies` (`jobAlies`),
  KEY `alies` (`alies`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `apply`
--
ALTER TABLE `apply`
  ADD CONSTRAINT `apply_ibfk_1` FOREIGN KEY (`alias`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `apply_ibfk_2` FOREIGN KEY (`jobAlies`) REFERENCES `vacancy` (`jobAlies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companyaddress`
--
ALTER TABLE `companyaddress`
  ADD CONSTRAINT `companyaddress_ibfk_1` FOREIGN KEY (`jobAlies`) REFERENCES `vacancy` (`jobAlies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cv`
--
ALTER TABLE `cv`
  ADD CONSTRAINT `cv_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `education_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `experience_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `giftperchase`
--
ALTER TABLE `giftperchase`
  ADD CONSTRAINT `giftperchase_ibfk_1` FOREIGN KEY (`giftOwner`) REFERENCES `userinfo` (`alies`),
  ADD CONSTRAINT `giftperchase_ibfk_2` FOREIGN KEY (`giftAlies`) REFERENCES `giftspackage` (`alias`);

--
-- Constraints for table `gifts`
--
ALTER TABLE `gifts`
  ADD CONSTRAINT `gifts_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `userinfo` (`alies`),
  ADD CONSTRAINT `gifts_ibfk_2` FOREIGN KEY (`giftAlias`) REFERENCES `giftperchase` (`giftAlies`),
  ADD CONSTRAINT `gifts_ibfk_3` FOREIGN KEY (`giftAlias`) REFERENCES `userinfo` (`alies`);

--
-- Constraints for table `gifttotal`
--
ALTER TABLE `gifttotal`
  ADD CONSTRAINT `gifttotal_ibfk_1` FOREIGN KEY (`giftOwner`) REFERENCES `userinfo` (`alies`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `gifttotal_ibfk_2` FOREIGN KEY (`giftAlies`) REFERENCES `giftspackage` (`alias`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `interests_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `matching`
--
ALTER TABLE `matching`
  ADD CONSTRAINT `matching_ibfk_1` FOREIGN KEY (`aliesUserOne`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matching_ibfk_2` FOREIGN KEY (`aliesUserTwo`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`userOne`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`userTwo`) REFERENCES `userinfo` (`alies`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vacancy`
--
ALTER TABLE `vacancy`
  ADD CONSTRAINT `vacancy_ibfk_1` FOREIGN KEY (`alies`) REFERENCES `userinfo` (`alies`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
