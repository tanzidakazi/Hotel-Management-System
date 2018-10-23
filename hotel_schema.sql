-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2017 at 07:06 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookroom`
--

CREATE TABLE `bookroom` (
  `roomid` varchar(50) NOT NULL,
  `roomnumber` int(50) NOT NULL,
  `calendar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookroom`
--

INSERT INTO `bookroom` (`roomid`, `roomnumber`, `calendar`) VALUES
('1', 101, ''),
('2', 102, ''),
('3', 201, ''),
('4', 205, ''),
('5', 206, '');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `cityid` int(100) NOT NULL,
  `cityname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`cityid`, `cityname`) VALUES
(1, 'coxs bazar'),
(2, 'sylhet'),
(3, 'comilla'),
(4, 'khulna'),
(5, 'dhaka'),
(6, 'chittagong'),
(7, 'rajshahi'),
(8, 'barisal'),
(9, 'bogra'),
(10, 'mymensingh'),
(17, 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `hotelid` int(11) NOT NULL,
  `central_air_conditioning` varchar(50) NOT NULL,
  `cable_television` varchar(50) NOT NULL,
  `internet_access` varchar(50) NOT NULL,
  `room_services` varchar(50) NOT NULL,
  `conference_and_banquet_facility` varchar(50) NOT NULL,
  `swimming_pool` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`hotelid`, `central_air_conditioning`, `cable_television`, `internet_access`, `room_services`, `conference_and_banquet_facility`, `swimming_pool`) VALUES
(1, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes'),
(2, 'No', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes'),
(3, 'yes', 'yes', 'yes', 'yes', 'no', 'yes'),
(4, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes'),
(5, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes'),
(6, 'no', 'yes', 'no', 'yes', 'no', 'no'),
(7, 'no', 'no', 'no', 'yes', 'no', 'no'),
(8, 'no', 'yes', 'yes', 'yes', 'no', 'no'),
(9, 'no', 'no', 'no', 'no', 'no', 'no'),
(10, 'yes', 'yes', 'yes', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `hotelid` int(50) NOT NULL,
  `cityid` int(50) NOT NULL,
  `hotelname` varchar(50) NOT NULL,
  `cost` int(100) NOT NULL,
  `roomcount` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`hotelid`, `cityid`, `hotelname`, `cost`, `roomcount`) VALUES
(1, 1, 'seagull', 8000, 10),
(2, 5, 'long beach', 5000, 22),
(3, 3, 'Deluxe', 40000, 33),
(4, 4, 'paradise', 20000, 44),
(5, 5, 'westin', 20000, 12),
(6, 6, 'hillview', 10000, 11),
(7, 7, 'new_castle', 20000, 21),
(8, 8, 'warison', 30000, 1),
(9, 10, 'naz', 2000, 3),
(10, 5, 'nicetown', 3000, 12);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservationid` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `hotelid` int(50) NOT NULL,
  `check_in_date` varchar(50) NOT NULL,
  `check_out_date` varchar(50) NOT NULL,
  `trxid` varchar(50) NOT NULL,
  `roomcount` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservationid`, `username`, `hotelid`, `check_in_date`, `check_out_date`, `trxid`, `roomcount`, `status`) VALUES
(1, 'arif', 9, '05/11/2017', '05/15/2017', 'credit card', '2', 'Accepted'),
(2, 'ariful22', 2, '3/5/2017', '5/5/2017', 'master card', '', 'Accepted'),
(3, 'biraltuya', 3, '14/5/2017', '20/5/17', 'credit card', '', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`firstname`, `lastname`, `username`, `email`, `password`, `status`) VALUES
('Abashhg', 'Abashhg', 'a', 'a', '111111', 'Regular'),
('admin', 'admin', 'admin', 'admin', 'admin', 'Admin'),
('FFF', 'FFF', 'arif', 'arif26@gmail.com', '111111', 'Admin'),
('ariful', 'islam', 'ariful22', 'arifulislam@gmail.com', 'arifulislam22', 'Regular'),
('sanzila', 'hossain', 'biraltuya', 'sanzila@yahoo.com', 'biral11', 'Regular'),
('dd', 'dd', 'dddd', 'dd@dd.dd', '111111', 'Regular'),
('dd', 'dd', 'ddddd', 'dd@dd.ddd', '111111', 'Regular'),
('efrat', 'kazi', 'efrat1', 'efrat56@gmail.com', 'efratcooks', 'Regular'),
('super', 'super', 'super', 'super', 'super', 'superadmin'),
('tanzida', 'kazi', 'tanzida21', 'ktanzida@yahoo.com', 'tanzida21', 'Banned');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookroom`
--
ALTER TABLE `bookroom`
  ADD PRIMARY KEY (`roomid`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`cityid`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD UNIQUE KEY `hotelid` (`hotelid`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`hotelid`),
  ADD KEY `cityid_fk` (`cityid`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationid`),
  ADD KEY `reservation_username_fk` (`username`),
  ADD KEY `reservation_hotelid_fk` (`hotelid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `cityid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `hotelid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `facility`
--
ALTER TABLE `facility`
  ADD CONSTRAINT `facility_hotelid_fk` FOREIGN KEY (`hotelid`) REFERENCES `hotel` (`hotelid`);

--
-- Constraints for table `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `cityid_fk` FOREIGN KEY (`cityid`) REFERENCES `city` (`cityid`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_hotelid_fk` FOREIGN KEY (`hotelid`) REFERENCES `hotel` (`hotelid`),
  ADD CONSTRAINT `reservation_username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
