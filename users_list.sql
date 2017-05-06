-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2017 at 04:57 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `lorem_test_db`
--

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
