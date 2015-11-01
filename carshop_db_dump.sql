-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2015 at 10:11 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `carshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
`id` int(11) NOT NULL COMMENT 'unique id for each car entry\nprimary key in the table, not null and auto icremental',
  `owner_id` int(11) NOT NULL COMMENT 'id of the owner - foreign key to users.id\nnot null',
  `made` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'made of the car',
  `model` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'model of the car',
  `year` int(11) DEFAULT NULL COMMENT 'year of first registration',
  `cat` varchar(45) COLLATE cp1251_bulgarian_ci NOT NULL COMMENT 'category: car, bus, truck, bycicle, etc.'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=cp1251 COLLATE=cp1251_bulgarian_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `owner_id`, `made`, `model`, `year`, `cat`) VALUES
(1, 1, ' Honda', ' CR-V', 1999, ' car'),
(2, 1, ' VW', ' Golf III', 1998, ' car'),
(3, 3, ' Mercedes', ' C200', 1995, ' car'),
(4, 3, ' BMW', ' E39 320i', 1992, ' car'),
(5, 3, ' Opel', ' Corsa 1.3 TDi', 2010, ' car'),
(6, 3, ' Ford', ' Transporter', 2001, ' bus');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(11) NOT NULL COMMENT 'unique comment id\nauto incremental; non null; primary key',
  `job_id` int(11) NOT NULL COMMENT 'the job this comment is posted about',
  `author_id` int(11) NOT NULL COMMENT 'the user id of the author of the comment',
  `timestamp` int(11) NOT NULL COMMENT 'unix timestamp of the comment\nused also for chronological order of the comments once listed one after the other',
  `comment` varchar(150) COLLATE cp1251_bulgarian_ci NOT NULL COMMENT 'actual text of the comment'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251 COLLATE=cp1251_bulgarian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `job_id`, `author_id`, `timestamp`, `comment`) VALUES
(1, 1, 1, 1425589904, 'моля, ползвайте масло castrol'),
(2, 1, 2, 1425591003, 'разбира се - клиентът е цар!'),
(3, 2, 4, 1425591003, 'Абе тая кола ударена ли си беше, като я оставихте?'),
(4, 2, 3, 1425591203, 'Какво сте направили, бе изродииии?'),
(5, 4, 2, 1425589904, 'Какви свещи да слагаме?'),
(6, 4, 1, 1425591003, 'Какви има?'),
(7, 4, 2, 1425591203, 'Китайски и немски бош...'),
(8, 4, 1, 1425591403, 'Какви са им цените?'),
(9, 4, 2, 1425591603, 'Немските са по 30лв, а китайските - по 2.'),
(10, 4, 1, 1425591803, 'Слагайте китайски!'),
(11, 4, 2, 1425592003, 'Пинтия...'),
(12, 6, 4, 1425591603, 'Готово е транспортерчето!..'),
(13, 3, 1, 1434065634, 'Is the car ready yet?');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
`id` int(11) NOT NULL COMMENT 'unique id of the job\nnot null; primary key; auto incremental',
  `car_id` int(11) NOT NULL COMMENT 'the id of the car the job''s being performed on',
  `mechanic_id` int(11) NOT NULL COMMENT 'the id of the user (mechanic) that''s performing the job',
  `description` varchar(45) COLLATE cp1251_bulgarian_ci NOT NULL COMMENT 'description of the job',
  `price` float NOT NULL COMMENT 'price of the current job',
  `status` tinyint(1) NOT NULL COMMENT 'bool status of the job:\n0 = active\n1 = finished',
  `timestamp` int(11) NOT NULL COMMENT 'timestamp the job should begin',
  `duration` int(11) NOT NULL COMMENT 'estimated duration in minutes'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=cp1251 COLLATE=cp1251_bulgarian_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `car_id`, `mechanic_id`, `description`, `price`, `status`, `timestamp`, `duration`) VALUES
(1, 1, 2, ' смяна масло и филтри', 82, 1, 1433838600, 1),
(2, 3, 4, ' реглаж преден мост', 48, 1, 1434011400, 2),
(3, 2, 2, ' смяна масло и филтри', 123, 1, 1434108600, 1),
(4, 1, 2, ' смяна свещи', 76, 1, 1434007800, 1),
(5, 4, 4, ' смяна шарнири', 80, 0, 1434094200, 3),
(6, 6, 4, ' смяна биалетки', 48, 0, 1434015000, 3),
(10, 1, 2, 'sdfs', 123, 1, 1434528000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL COMMENT 'unique id for the table;\nnot null\nprimary key, auto incremental',
  `uname` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'chosen username; unique',
  `fname` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'first name of the user',
  `mname` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'middle name of the user',
  `lname` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'last name of the user',
  `type` tinyint(1) DEFAULT NULL COMMENT 'bool type fo the user:\n0 = mechanic\n1 = client',
  `phone` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'phone for contact',
  `address` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'address of the user',
  `pass` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'password \nwill be stored as md5 hash;\nprobably the hash will be pulled out of the concatenated string of the user name and password in order to increase the security and prevent dictionary and bruteforce attacks.',
  `email` varchar(45) COLLATE cp1251_bulgarian_ci DEFAULT NULL COMMENT 'email of the user'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 COLLATE=cp1251_bulgarian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `fname`, `mname`, `lname`, `type`, `phone`, `address`, `pass`, `email`) VALUES
(1, 'ivan', 'Иван', 'Иванов', 'Петров', 1, '0888 999 000', 'София, ж.к. "Белите брези", бл. 15, ап.25', '52886cee89b45f0a73c4e73619c8a8e4', 'ivan@dummy.mail'),
(2, 'peter', 'Петър', 'Петров', 'Иванов', 0, '0888 111 222', 'Пазарджик, ул. 16, №3', '46a326be2e2207b8859ecf3080f159b7', 'peter@dummy.mail'),
(3, 'joro', 'Георги', 'Георгиев', 'Гогов', 1, '0888 222 333', 'Петрич, ул. 162, № 1', '3d58c89520ce29d46eddcfe717f3b0d1', 'joro@dummy.mail'),
(4, 'kiro', 'Кирил', 'Кирилов', 'Кирчов', 0, '0888 123 456', 'Варна, ж.к. Трошево, бл 56, ап. 52', 'd8616c03addf095d215bdf52d2d95d67', 'kiro@dummy.mail');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `owner_id_idx` (`owner_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `author-comment_idx` (`author_id`), ADD KEY `job-id_idx` (`job_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD KEY `job-car_idx` (`car_id`), ADD KEY `job-mechanic_idx` (`mechanic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id_UNIQUE` (`id`), ADD UNIQUE KEY `username_UNIQUE` (`uname`), ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id for each car entry\nprimary key in the table, not null and auto icremental',AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique comment id\nauto incremental; non null; primary key',AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of the job\nnot null; primary key; auto incremental',AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id for the table;\nnot null\nprimary key, auto incremental',AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
ADD CONSTRAINT `owner_id` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `author-comment` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `job-id` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
ADD CONSTRAINT `job-car` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `job-mechanic` FOREIGN KEY (`mechanic_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
