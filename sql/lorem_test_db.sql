-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2019 at 06:55 PM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `lorem_test_db`
--
CREATE DATABASE IF NOT EXISTS `lorem_test_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `lorem_test_db`;

-- --------------------------------------------------------

--
-- Table structure for table `email_list`
--

CREATE TABLE `email_list` (
  `id` int(11) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_list`
--

INSERT INTO `email_list` (`id`, `first_name`, `last_name`, `email`) VALUES
(1, 'Denny', 'Bubbleton', 'denny@mightygumball.net'),
(2, 'Irma', 'Werlitz', 'iwer@aliensabductedme.com'),
(3, 'Elbert', 'Kreslee', 'elbert@kresleesprockets.biz'),
(5, 'Don', 'Draper', 'draper@sterling-cooper.com'),
(7, 'Pepper', 'Oni', 'pepperoni.pizza@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`first_name`, `last_name`, `email`) VALUES
('Bill', 'Gates', 'billgates@microsoft.com'),
('Elon', 'Musk', 'elon.musk@tesla.com'),
('Jabal', 'Torres', 'jabaltorres@gmail.com'),
('Sergey', 'Brin', 'sergey.brin@google.com'),
('Steve', 'Jobs', 'steve.jobs@apple.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_list`
--
ALTER TABLE `email_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_list`
--
ALTER TABLE `email_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
