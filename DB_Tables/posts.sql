-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2018 at 01:39 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `network`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `owner` int(200) NOT NULL,
  `post` text NOT NULL,
  `likes` int(11) DEFAULT '0',
  `shares` int(11) DEFAULT '0',
  `comments` int(11) DEFAULT '0',
  `date_added` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `owner`, `post`, `likes`, `shares`, `comments`, `date_added`) VALUES
(177, 39, 'I love tomato', 0, 0, 0, '2018-05-04 01:36:20'),
(178, 39, 'Can you do as much good as I can?', 0, 0, 0, '2018-05-04 01:37:03'),
(179, 39, 'Hobba lallo', 0, 0, 0, '2018-05-04 01:37:14'),
(180, 38, 'Men zaman, 3aref?', 0, 0, 0, '2018-05-04 01:37:40'),
(181, 38, 'Dmoo3 ashwa2..', 0, 0, 0, '2018-05-04 01:37:46'),
(182, 40, 'Meen fil 7wari matwaladshi baree2?!', 0, 0, 0, '2018-05-04 01:38:10'),
(183, 40, '3arfa? A7lamek tamou7a', 0, 0, 0, '2018-05-04 01:38:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
