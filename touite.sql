-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 22, 2023 at 03:38 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `touite`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `ID` int(45) NOT NULL,
  `ID_USER` int(45) NOT NULL,
  `CONTENT` text NOT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`ID`, `ID_USER`, `CONTENT`, `CREATED_AT`) VALUES
(4, 9, 'Audrey, a poet, and Dorothy, a math wiz,\r\nAt NASA they met, their friendship began to fizz,\r\nThrough late nights and long days, they worked side by side,\r\nBreaking barriers and shattering racial divides.\r\nTheir bond grew stronger, through thick and thin,\r\nA friendship unbreakable, like the stars up in the sky, so dim,\r\nTheir legacy lives on, even though they’re gone,\r\nAudrey and Dorothy Vaughan, two best friends who became one.', '2023-02-22 16:28:59'),
(5, 10, 'Touiter c\'est trop bien, j\'adore !', '2023-02-22 16:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(4) NOT NULL,
  `EMAIL` text NOT NULL,
  `LASTNAME` text NOT NULL,
  `FIRSTNAME` text NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `AVATAR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `EMAIL`, `LASTNAME`, `FIRSTNAME`, `PASSWORD`, `AVATAR`) VALUES
(1, 'toto@gmail.com', 'Toto', 'Tata', 'toto', NULL),
(9, 'au.doyen@gmail.com', 'Doyen', 'Audrey', '8c08dc529eccf4277a402cb8f7da0c96', './avatars/63f63341bf9a09.78111076.jpg'),
(10, 'nou.sma@gmail.com', 'Smahat', 'Noura', '2c332463df17b093eb3c15726c6e58a7', './avatars/63f636342fdb04.30597845.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER` (`ID_USER`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`ID_USER`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
