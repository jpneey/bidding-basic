-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2020 at 02:47 PM
-- Server version: 10.4.6-MariaDB
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
-- Database: `cs_canvasspoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `cs_biddings`
--

CREATE TABLE `cs_biddings` (
  `cs_bidding_id` int(11) NOT NULL,
  `cs_bidding_category_id` int(11) NOT NULL,
  `cs_bidding_user_id` int(11) NOT NULL,
  `cs_bidding_title` varchar(64) NOT NULL,
  `cs_bidding_picture` varchar(255) NOT NULL,
  `cs_bidding_details` text NOT NULL,
  `cs_bidding_date_needed` datetime NOT NULL,
  `cs_bidding_product` varchar(255) NOT NULL,
  `cs_bidding_product_qty` int(11) NOT NULL,
  `cs_bidding_product_unit` varchar(50) NOT NULL,
  `cs_bidding_product_price` varchar(255) NOT NULL,
  `cs_bidding_added` datetime NOT NULL DEFAULT current_timestamp(),
  `cs_bidding_expiration` datetime NOT NULL,
  `cs_bidding_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_biddings`
--

INSERT INTO `cs_biddings` (`cs_bidding_id`, `cs_bidding_category_id`, `cs_bidding_user_id`, `cs_bidding_title`, `cs_bidding_picture`, `cs_bidding_details`, `cs_bidding_date_needed`, `cs_bidding_product`, `cs_bidding_product_qty`, `cs_bidding_product_unit`, `cs_bidding_product_price`, `cs_bidding_added`, `cs_bidding_expiration`, `cs_bidding_status`) VALUES
(1, 0, 1, 'Looking for cheap plastic bottles', 'placeholder.svg', 'I am a very simple card. I am good at containing small bits of information. I am convenient because I require little markup to use effectively. We hope you have enjoyed using Materialize and if you feel like it has helped you out and want to support the team you can help us by donating or backing us on Patreon. Any amount would help support and continue development on this project and is greatly appreciated.\r\n\r\n', '2020-07-26 00:00:00', 'Plastic bottles', 2, 'pc', '15.00', '2020-07-13 21:34:37', '2020-07-26 00:00:00', 1),
(2, 0, 1, 'Tops For Women', '#!', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non officiis tenetur quam atque nisi quod excepturi, dolorem est et possimus delectus, eum, adipisci fugit aliquid aliquam. Vel enim reprehenderit doloremque!\r\n', '2020-07-23 00:00:00', 'White Tshirt', 15, 'pc', '50.00', '2020-07-14 05:42:45', '2020-07-21 00:00:00', 1),
(3, 0, 1, 'Cloud Harvester in Tanay', 'b.jpg', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', '2020-07-21 00:00:00', 'Cloud harvester', 1, 'oz', '78999.00', '2020-07-14 11:35:46', '2020-07-21 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_categories`
--

CREATE TABLE `cs_categories` (
  `cs_category_id` int(11) NOT NULL,
  `cs_category_name` varchar(255) NOT NULL,
  `cs_category_desciption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cs_users`
--

CREATE TABLE `cs_users` (
  `cs_user_id` int(11) NOT NULL,
  `cs_user_name` varchar(64) NOT NULL,
  `cs_user_email` varchar(64) NOT NULL,
  `cs_user_password` varchar(255) NOT NULL,
  `cs_user_role` varchar(64) NOT NULL,
  `cs_user_avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_users`
--

INSERT INTO `cs_users` (`cs_user_id`, `cs_user_name`, `cs_user_email`, `cs_user_password`, `cs_user_role`, `cs_user_avatar`) VALUES
(1, 'jpneey', 'burato348@gmail.com', 'default', 'bidder', 'jp.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  ADD PRIMARY KEY (`cs_bidding_id`);

--
-- Indexes for table `cs_categories`
--
ALTER TABLE `cs_categories`
  ADD PRIMARY KEY (`cs_category_id`);

--
-- Indexes for table `cs_users`
--
ALTER TABLE `cs_users`
  ADD PRIMARY KEY (`cs_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cs_categories`
--
ALTER TABLE `cs_categories`
  MODIFY `cs_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
