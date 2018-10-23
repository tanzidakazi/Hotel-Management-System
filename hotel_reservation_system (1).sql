-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2017 at 03:42 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel reservation system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookroom`
--

CREATE TABLE `bookroom` (
  `RoomID` varchar(50) NOT NULL,
  `RoomNumber` int(50) NOT NULL,
  `Calendar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `cityid` varchar(50) NOT NULL,
  `cityname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
	`HotelID` int(50) NOT NULL,
  `Central_Air_Conditioning` varchar(50) NOT NULL,
  `Hot_and_Cold_Water` varchar(50) NOT NULL,
  `Cable_Television` varchar(50) NOT NULL,
  `Internet_Access` varchar(50) NOT NULL,
  `Room_Services` varchar(50) NOT NULL,
  `Conference_and_Banquet_facility` varchar(50) NOT NULL,
  `Airport Transfer` varchar(50) NOT NULL,
  `IDD_Telephone` varchar(50) NOT NULL,
  `Free_Parking` varchar(50) NOT NULL,
  `Cyber_Cafe` varchar(50) NOT NULL,
  `Swimming_Pool` varchar(50) NOT NULL,
  `Jacuzzi` varchar(50) NOT NULL,
  `Salon` varchar(50) NOT NULL,
  `Hot_Spa_and _Massage` varchar(50) NOT NULL,
  `Shopping_Arcade` varchar(50) NOT NULL,
  `Fitness_centre` varchar(50) NOT NULL,
  `Laundry` varchar(50) NOT NULL,
  `ATM_Card_Machine` varchar(50) NOT NULL,
  `Doctor_On_Call` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `HotelID` varchar(50) NOT NULL,
  `CityID` varchar(50) NOT NULL,
  `HotelName` varchar(50) NOT NULL,
  `MinCost` int(100) NOT NULL,
  `MaxCost` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ReservationID` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `HotelID` varchar(50) NOT NULL,
  `Check_In_Date` varchar(50) NOT NULL,
  `Check_Out_Date` varchar(50) NOT NULL,
  `Payment` varchar(50) NOT NULL,
  `Room_Details` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `status` varchar(50) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`CityID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserName`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
