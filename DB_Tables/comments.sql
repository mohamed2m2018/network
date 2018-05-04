-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2018 at 09:50 AM
-- Server version: 10.1.25-MariaDB
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
-- Database: `network`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `owner` varchar(200) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(11) NOT NULL,
  `date_added` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `owner`, `post_id`, `comment`, `likes`, `date_added`) VALUES
(1, '7', 2, 'comment sdifgusd', 0, NULL),
(2, '7', 2, 'xijkbvisdhnk', 0, NULL),
(3, '7', 2, 'comment1', 0, '2018-05-04 09:42:02'),
(4, '7', 3, 'comment3', 0, '2018-05-04 09:42:10'),
(5, '7', 3, 'hugtsbhx', 0, '2018-05-04 09:42:16'),
(6, '7', 1, 'comments', 0, '2018-05-04 09:42:27'),
(7, '7', 1, '3ash', 0, '2018-05-04 09:42:38'),
(8, '7', 2, 'tb comment', 0, '2018-05-04 09:42:47'),
(9, '7', 2, 'kman comment', 0, '2018-05-04 09:42:55'),
(10, '7', 3, 'kman comment', 0, '2018-05-04 09:43:05'),
(11, '7', 1, 'kman comment', 0, '2018-05-04 09:43:23'),
(12, '8', 4, 'Ø§Ø¯ÙŠ ÙƒÙˆÙ…Ù†Øª', 0, '2018-05-04 09:47:54'),
(13, '8', 4, 'ÙƒÙ…Ø§Ù† ÙƒÙˆÙ…Ù†Øª', 0, '2018-05-04 09:48:01'),
(14, '8', 4, 'ÙƒÙ…Ø§Ù† ÙƒÙˆÙ…Ù†Øª Ø¹Ù„Ø´Ø§Ù† Ø®Ø§Ø·Ø± Ø§Ø­Ù†Ø§ Ø§Ù‚ÙˆÙŠ ØªÙŠÙ… ÙˆØ¨ØªØ§Ø¹ ', 0, '2018-05-04 09:48:21'),
(15, '8', 4, 'can we do this !?', 0, '2018-05-04 09:49:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
