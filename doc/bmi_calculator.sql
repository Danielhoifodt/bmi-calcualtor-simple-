-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12. Mar, 2020 12:38 PM
-- Tjener-versjon: 10.4.6-MariaDB
-- PHP Version: 7.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bmi_calculator`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bmi_table`
--

CREATE TABLE `bmi_table` (
  `id` int(11) NOT NULL,
  `height` double NOT NULL,
  `weight` double NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `bmi_table`
--

INSERT INTO `bmi_table` (`id`, `height`, `weight`, `date`, `userID`) VALUES
(113, 193, 105, '2020-03-11 18:35:38', 8);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `login_table`
--

CREATE TABLE `login_table` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `login_table`
--

INSERT INTO `login_table` (`id`, `username`, `password`, `created_at`) VALUES
(8, 'daniel', '$2y$10$FQXDIdu5RjEFyndzVb2seOBTZBpufEgElKaIbPIiNkTQIglS7kWLS', '2020-03-08 21:34:52'),
(9, 'test', '$2y$10$uxOG8qv6sh.bOCq054kf8OluYO.UpzxZUZjbKtCT9d66frtxku6km', '2020-03-08 21:49:13'),
(10, 'birgitte', '$2y$10$uJg6vW8TIQjTt9Z0we82LuvAH8UZlOGJRsFAlRliXgtPqibjMVVDG', '2020-03-10 17:42:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bmi_table`
--
ALTER TABLE `bmi_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `login_table`
--
ALTER TABLE `login_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bmi_table`
--
ALTER TABLE `bmi_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `login_table`
--
ALTER TABLE `login_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `bmi_table`
--
ALTER TABLE `bmi_table`
  ADD CONSTRAINT `bmi_table_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `login_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
