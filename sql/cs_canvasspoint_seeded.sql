-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2021 at 03:38 PM
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
-- Table structure for table `cs_admin`
--

CREATE TABLE `cs_admin` (
  `cs_admin_id` int(11) NOT NULL,
  `cs_admin_user` varchar(64) NOT NULL,
  `cs_admin_password` varchar(255) NOT NULL,
  `cs_admin_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_admin`
--

INSERT INTO `cs_admin` (`cs_admin_id`, `cs_admin_user`, `cs_admin_password`, `cs_admin_role`) VALUES
(1, 'jpneey', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', 5),
(2, 'admin', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', 5);

-- --------------------------------------------------------

--
-- Table structure for table `cs_bidder_options`
--

CREATE TABLE `cs_bidder_options` (
  `cs_option_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_allowed_view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_bidder_options`
--

INSERT INTO `cs_bidder_options` (`cs_option_id`, `cs_user_id`, `cs_allowed_view`) VALUES
(1, 1, 1),
(2, 4, 1),
(3, 2, 1),
(4, 3, 4),
(5, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_biddings`
--

CREATE TABLE `cs_biddings` (
  `cs_bidding_id` int(11) NOT NULL,
  `cs_bidding_category_id` int(11) NOT NULL,
  `cs_bidding_user_id` int(11) NOT NULL,
  `cs_bidding_title` varchar(64) NOT NULL,
  `cs_bidding_permalink` varchar(255) NOT NULL,
  `cs_bidding_picture` varchar(255) NOT NULL,
  `cs_bidding_details` text NOT NULL,
  `cs_bidding_tags` text NOT NULL,
  `cs_bidding_location` varchar(64) NOT NULL DEFAULT 'Metro Manila',
  `cs_bidding_date_needed` datetime NOT NULL,
  `cs_bidding_added` datetime NOT NULL DEFAULT current_timestamp(),
  `cs_bidding_expiration` datetime NOT NULL,
  `cs_bidding_status` int(11) NOT NULL,
  `cs_expired_notif` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_biddings`
--

INSERT INTO `cs_biddings` (`cs_bidding_id`, `cs_bidding_category_id`, `cs_bidding_user_id`, `cs_bidding_title`, `cs_bidding_permalink`, `cs_bidding_picture`, `cs_bidding_details`, `cs_bidding_tags`, `cs_bidding_location`, `cs_bidding_date_needed`, `cs_bidding_added`, `cs_bidding_expiration`, `cs_bidding_status`, `cs_expired_notif`) VALUES
(54, 1, 1, 'Prepare the elements you want to lazy load', 'prepare-the-elements-you-want-to-lazy-load', 'jp-20557-prod-37125-humaaans.png', 'Test', '1', 'Pasig City', '2020-11-28 17:53:00', '2020-11-30 13:54:16', '2020-11-29 13:54:16', 0, 1),
(55, 2, 4, 'Active', 'active', '#!', 'Test', '1', 'Antipolo City', '2021-01-31 20:02:00', '2021-01-30 20:02:50', '2021-02-06 20:02:50', 2, 1),
(56, 12, 4, 'Plastic Cups', 'plastic-cups', '#!', 'Test', '1', 'Antipolo City', '2021-01-31 20:15:00', '2021-01-30 20:15:47', '2021-02-06 20:15:47', 2, 1),
(57, 2, 4, 'Prepare the elements you want to lazy load', 'prepare-the-elements-you-want-to-lazy-load-2', '#!', 'Test', '1', 'Antipolo City', '2021-01-31 20:16:00', '2021-01-30 20:16:18', '2021-02-06 20:16:18', 1, 1),
(58, 12, 4, 'Static Website', 'static-website', '#!', 'r', '1', 'Antipolo City', '2021-01-31 20:18:00', '2021-01-30 20:18:35', '2021-02-06 20:18:35', 2, 1),
(59, 2, 4, 'Active', 'active', '#!', 'Test', '1', 'Antipolo City', '2021-01-31 20:02:00', '2021-01-30 20:02:50', '2021-02-06 20:02:50', 0, 1),
(60, 12, 4, 'Plastic Cups', 'plastic-cups', '#!', 'Test', '1', 'Antipolo City', '2021-01-31 20:15:00', '2021-01-30 20:15:47', '2021-02-06 20:15:47', 0, 1),
(61, 2, 4, 'Prepare the elements you want to lazy load', 'prepare-the-elements-you-want-to-lazy-load-2', '#!', 'Test', '1', 'Antipolo City', '2021-01-31 20:16:00', '2021-01-30 20:16:18', '2021-02-06 20:16:18', 0, 1),
(62, 12, 4, 'Static Website', 'static-website', '#!', 'r', '1', 'Antipolo City', '2021-01-31 20:18:00', '2021-01-30 20:18:35', '2021-02-06 20:18:35', 0, 1),
(63, 12, 4, 'Static Website', 'static-website', '#!', 'r', '1', 'Antipolo City', '2021-01-31 20:18:00', '2021-01-30 20:18:35', '2021-02-06 20:18:35', 0, 1),
(64, 12, 1, 'Static Website', 'static-website-4', '#!', 'Lorem ipsum dotor sit amet', '1', 'Antipolo City', '2021-01-31 21:37:00', '2021-01-30 21:37:17', '2021-02-06 21:37:17', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_bidding_winners`
--

CREATE TABLE `cs_bidding_winners` (
  `cs_winner_id` int(11) NOT NULL,
  `cs_offer_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_offer_owner_id` int(11) NOT NULL,
  `cs_bidding_owner_id` int(11) NOT NULL,
  `cs_offer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cs_blogs`
--

CREATE TABLE `cs_blogs` (
  `cs_blog_id` int(11) NOT NULL,
  `cs_blog_title` varchar(255) NOT NULL,
  `cs_blog_permalink` varchar(300) NOT NULL,
  `cs_blog_featured_image` varchar(255) NOT NULL,
  `cs_blog_category_id` int(11) NOT NULL,
  `cs_blog_content` text NOT NULL,
  `cs_blog_description` varchar(500) NOT NULL,
  `cs_blog_keywords` varchar(500) NOT NULL,
  `cs_blog_added` date NOT NULL,
  `cs_blog_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_blogs`
--

INSERT INTO `cs_blogs` (`cs_blog_id`, `cs_blog_title`, `cs_blog_permalink`, `cs_blog_featured_image`, `cs_blog_category_id`, `cs_blog_content`, `cs_blog_description`, `cs_blog_keywords`, `cs_blog_added`, `cs_blog_status`) VALUES
(2, 'Lorem De` Connectitur', 'lorem-de-connectitur28337', 'http://localhost/admin/app/static/upload/jpg-91463-alex-harvey-nqSUnXINsp4-unsplash.jpg', 2, '<div class=\"browser-default\"><div style=\"text-align: left;\" class=\"browser-default\"><h1 class=\"browser-default\">Lorem Ipsum</h1><h2 class=\"browser-default\">\r\nLorem Ipsum</h2><h3 class=\"browser-default\">\r\nLorem Ipsum</h3><h4 class=\"browser-default\">\r\nLorem Ipsum</h4><div><br></div><div><img src=\"http://localhost/admin/app/static/upload/jpg-35912-picture.jpg\" align=\"left\" style=\"cursor: default;\"><br></div><div class=\"browser-default\"></div></div></div>', 'Add radio buttons to a group by adding the name attribute along with the same corresponding value for each of the radio buttons in the group. Create disabled radio buttons by adding the disabled attribute as shown below.', 'boop,beep', '2021-01-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_business`
--

CREATE TABLE `cs_business` (
  `cs_business_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_business_name` varchar(64) NOT NULL,
  `cs_business_link` varchar(125) NOT NULL,
  `cs_business_tags` varchar(255) NOT NULL,
  `cs_business_featured` text NOT NULL,
  `cs_business_status` int(11) NOT NULL DEFAULT 0,
  `cs_business_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_business`
--

INSERT INTO `cs_business` (`cs_business_id`, `cs_user_id`, `cs_business_name`, `cs_business_link`, `cs_business_tags`, `cs_business_featured`, `cs_business_status`, `cs_business_category`) VALUES
(6, 2, 'Dine In Furnishing', 'dine-in-furnishing', '', '', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cs_categories`
--

CREATE TABLE `cs_categories` (
  `cs_category_id` int(11) NOT NULL,
  `cs_category_name` varchar(255) NOT NULL,
  `cs_category_desciption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_categories`
--

INSERT INTO `cs_categories` (`cs_category_id`, `cs_category_name`, `cs_category_desciption`) VALUES
(1, 'Miscelaneous', ''),
(2, 'Front-end', ''),
(12, 'Back End', 'Lorem Ipsum Dotor sit amet');

-- --------------------------------------------------------

--
-- Table structure for table `cs_locations`
--

CREATE TABLE `cs_locations` (
  `cs_location_id` int(11) NOT NULL,
  `cs_location_type` int(11) NOT NULL DEFAULT 2,
  `cs_location` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_locations`
--

INSERT INTO `cs_locations` (`cs_location_id`, `cs_location_type`, `cs_location`) VALUES
(1, 2, 'Metro Manila'),
(2, 2, 'Pasig City'),
(3, 2, 'Cainta'),
(4, 2, 'Antipolo City');

-- --------------------------------------------------------

--
-- Table structure for table `cs_notifications`
--

CREATE TABLE `cs_notifications` (
  `cs_notif_id` int(11) NOT NULL,
  `cs_notif_read` int(11) NOT NULL DEFAULT 0,
  `cs_notif` varchar(255) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_notifications`
--

INSERT INTO `cs_notifications` (`cs_notif_id`, `cs_notif_read`, `cs_notif`, `cs_user_id`, `cs_added`) VALUES
(125, 1, 'Bidding: <a data-to=\"bid/prepare-the-elements-you-want-to-lazy-load\"><b>Prepare the elements you want to lazy load</b></a> has expired.', 1, '2020-11-30 15:07:40'),
(135, 1, 'Bidding: <a data-to=\"my/plan\"><b>Your premium plan</b></a> has expired.', 2, '2021-01-30 20:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `cs_offers`
--

CREATE TABLE `cs_offers` (
  `cs_offer_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_offer` text NOT NULL,
  `cs_offer_price` decimal(13,4) NOT NULL,
  `cs_date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `cs_offer_status` int(1) NOT NULL DEFAULT 0,
  `cs_offer_success` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_offers`
--

INSERT INTO `cs_offers` (`cs_offer_id`, `cs_bidding_id`, `cs_user_id`, `cs_offer`, `cs_offer_price`, `cs_date_added`, `cs_offer_status`, `cs_offer_success`) VALUES
(40, 40, 1, 'a:7:{s:7:\"product\";s:4:\"Test\";s:3:\"qty\";s:2:\"15\";s:4:\"date\";s:10:\"2020-11-30\";s:5:\"notes\";s:4:\"Test\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";s:9:\"img-three\";s:2:\"#!\";}', '56.0000', '2020-11-15 13:37:50', 2, 0),
(41, 57, 2, 'a:7:{s:7:\"product\";s:42:\"Prepare the elements you want to lazy load\";s:3:\"qty\";s:3:\"567\";s:4:\"date\";s:9:\"2021-1-31\";s:5:\"notes\";s:92:\"Bidders remain anonymous until it&#39;s offer is selected by the client and won the bidding.\";s:3:\"img\";s:2:\"#!\";s:7:\"img-two\";s:2:\"#!\";s:9:\"img-three\";s:2:\"#!\";}', '89.9900', '2021-01-30 12:41:13', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_plans`
--

CREATE TABLE `cs_plans` (
  `cs_plan_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_plan_status` int(11) NOT NULL DEFAULT 0,
  `cs_to_open` int(11) NOT NULL DEFAULT 4,
  `cs_to_view` int(11) NOT NULL DEFAULT 4,
  `cs_to_featured` int(11) NOT NULL DEFAULT 3,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `cs_plan_payment` varchar(255) NOT NULL,
  `cs_gateway_comment` varchar(255) NOT NULL DEFAULT '',
  `expires` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_plans`
--

INSERT INTO `cs_plans` (`cs_plan_id`, `cs_user_id`, `cs_plan_status`, `cs_to_open`, `cs_to_view`, `cs_to_featured`, `date_added`, `cs_plan_payment`, `cs_gateway_comment`, `expires`) VALUES
(22, 2, 2, 0, 0, 3, '2020-11-22 07:39:34', 'Direct Pay', '20.13192900 16060307742_dp', '2020-11-22 07:39:34'),
(23, 1, 1, 4, 4, 0, '2020-11-30 06:12:22', 'Direct Pay', '10.09266600 16067167421_dp', '2021-11-30 06:14:58'),
(24, 2, 2, 0, 0, 3, '2020-11-30 06:49:32', 'Direct Pay', 'expiring', '2020-12-07 06:50:18'),
(25, 2, 1, 0, 0, 3, '2021-01-30 13:47:05', 'Direct Pay', '20.88642700 16120144252_dp', '2021-01-30 13:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `cs_products`
--

CREATE TABLE `cs_products` (
  `cs_product_id` int(11) NOT NULL,
  `cs_category_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_product_name` varchar(500) NOT NULL,
  `cs_product_details` text NOT NULL,
  `cs_product_image` varchar(255) NOT NULL,
  `cs_product_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `cs_sale_price` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `cs_unit` varchar(255) NOT NULL,
  `cs_product_permalink` varchar(500) NOT NULL,
  `cs_link` varchar(500) NOT NULL DEFAULT '#!',
  `cs_link_text` varchar(50) NOT NULL DEFAULT 'Add to Cart',
  `cs_inquired` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_products`
--

INSERT INTO `cs_products` (`cs_product_id`, `cs_category_id`, `cs_user_id`, `cs_product_name`, `cs_product_details`, `cs_product_image`, `cs_product_price`, `cs_sale_price`, `cs_unit`, `cs_product_permalink`, `cs_link`, `cs_link_text`, `cs_inquired`) VALUES
(27, 12, 2, 'ES6 Js Tutorial', '/* Notify users with expiring plans in a week */\r\n\r\n$stmt = $connection->prepare(&#34;SELECT cs_plan_id, cs_user_id, expires FROM cs_plans WHERE cs_plan_status = 1 AND cs_gateway_comment != &#39;expiring&#39; AND DATE(expires)', 'prod-58257-baking.jpg', '620.0000', '600.0000', 'kg', 'es6-js-tutorial-2owd', '#!', 'Add to Cart', 0),
(28, 2, 2, 'Fresh Banana', 'Test', 'prod-37125-humaaans.png', '670.0000', '599.0000', 'kg', 'fresh-banana-2psg', '#!', 'Add to Cart', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_products_in_biddings`
--

CREATE TABLE `cs_products_in_biddings` (
  `cs_product_id` int(11) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_product_name` varchar(255) NOT NULL,
  `cs_product_unit` varchar(5) NOT NULL,
  `cs_product_qty` int(10) NOT NULL,
  `cs_product_price` decimal(13,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_products_in_biddings`
--

INSERT INTO `cs_products_in_biddings` (`cs_product_id`, `cs_bidding_id`, `cs_product_name`, `cs_product_unit`, `cs_product_qty`, `cs_product_price`) VALUES
(42, 52, 'Plastic Cups', 'hy', 21, '200.0000'),
(43, 42, 'Static Website', 'pc', 15, '60.0000'),
(44, 53, '11 Test', 'kg', 15, '700.0000'),
(45, 54, 'Prepare the elements you want to lazy load', 'pcs', 15, '6700.0000'),
(46, 55, 'Active', 'kg', 56, '5700.0000'),
(47, 56, 'Plastic Cups', 'kg', 56, '6700.0000'),
(48, 57, 'Prepare the elements you want to lazy load', 'pcs', 567, '5600.0000'),
(49, 58, 'Static Website', 'in', 67, '5600.0000'),
(50, 64, 'Static Website', 'kg', 56, '6700.0000');

-- --------------------------------------------------------

--
-- Table structure for table `cs_store`
--

CREATE TABLE `cs_store` (
  `cs_setting_id` int(11) NOT NULL,
  `cs_setting_name` varchar(255) NOT NULL,
  `cs_setting_value` varchar(255) NOT NULL,
  `cs_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_store`
--

INSERT INTO `cs_store` (`cs_setting_id`, `cs_setting_name`, `cs_setting_value`, `cs_status`) VALUES
(1, 'admin_email', 'burato348@gmail.com', 1),
(2, 'admin_home', '1590,210,127,0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_tags`
--

CREATE TABLE `cs_tags` (
  `cs_tag_id` int(11) NOT NULL,
  `cs_category_id` int(11) NOT NULL,
  `cs_tag` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_tags`
--

INSERT INTO `cs_tags` (`cs_tag_id`, `cs_category_id`, `cs_tag`, `sort_order`) VALUES
(9, 12, 'API Development', 0),
(10, 12, 'MySQL', 0),
(11, 12, 'Foo', 0),
(12, 12, 'Back End', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_transactions`
--

CREATE TABLE `cs_transactions` (
  `cs_transaction_id` int(11) NOT NULL,
  `cs_bidder_id` int(11) NOT NULL,
  `cs_bid_owner_id` int(11) NOT NULL,
  `cs_bidding_title` varchar(255) NOT NULL,
  `cs_bidding_id` int(11) NOT NULL,
  `cs_is_success` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cs_users`
--

CREATE TABLE `cs_users` (
  `cs_user_id` int(11) NOT NULL,
  `cs_user_name` varchar(64) NOT NULL,
  `cs_user_email` varchar(64) NOT NULL,
  `cs_contact_details` text DEFAULT NULL,
  `cs_user_detail` varchar(255) DEFAULT NULL,
  `cs_user_password` varchar(255) NOT NULL,
  `cs_user_role` varchar(64) NOT NULL,
  `cs_user_avatar` varchar(255) NOT NULL,
  `cs_account_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cs_users`
--

INSERT INTO `cs_users` (`cs_user_id`, `cs_user_name`, `cs_user_email`, `cs_contact_details`, `cs_user_detail`, `cs_user_password`, `cs_user_role`, `cs_user_avatar`, `cs_account_status`) VALUES
(1, 'jpneey', 'burato348@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'You are one click away on reaching the next step of Canvasspoint&#39;s registration process! Please click the button below to setup your account\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Eius voluptatum esse quas possimus, officiis nemo ', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', '1', 'jp-95245-jp.jpg', 0),
(2, 'dine-in', 'supplier@mail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";s:7:\"8700555\";s:9:\"cs_mobile\";s:12:\"095967800909\";}', 'When it comes to choosing the most perfect dining set for sale in the Philippines, look no further than Dine-In Furnishing. We have a wide range of furniture pieces which carries the creativity and ingenuity of every Filipino in the country. We take pride', '$2y$10$qkY8Vtz7p97.R2VerRzyPuKjRVResSXzyhaGsc78bXcJ.K2nNlArO', '2', 'jp-17177-08012020010811.png', 0),
(3, 'foo-bar', 'admin@mail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";s:7:\"8700555\";s:9:\"cs_mobile\";s:11:\"09296209999\";}', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio nostrum aperiam autem, cum laborum nihil id tempore non voluptas explicabo quasi maiores a iure sit dolore doloremque blanditiis ratione iusto!', '$2y$10$qkY8Vtz7p97.R2VerRzyPuKjRVResSXzyhaGsc78bXcJ.K2nNlArO', '2', 'jp-21235-icon.jpg', 0),
(4, 'leafa', 'leafa@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";N;}', 'You are one click away on reaching the next step of Canvasspoint&#39;s registration process! Please click the button below to setup your account', '$2y$10$k4AYoKWROtb//0wZRqtnC.fq0Jdeh3xlNkgNPLF5193tB6bwOdUlS', '1', 'jp-65542-ae1c29bea800e5c1adde375bb4b06e56--simple-fashion-minimalist-fashion-minimalist-outfits.jpg', 0),
(6, 'pepes', 'codenipepe@gmail.com', 'a:5:{s:11:\"cs_facebook\";N;s:11:\"cs_linkedin\";N;s:10:\"cs_website\";N;s:12:\"cs_telephone\";N;s:9:\"cs_mobile\";s:11:\"09296209056\";}', 'Your temporary password is: k0QxU. You&#39;ll need this inorder to update your account after clicking the button above.', '$2y$10$c1H5kd29XYTVDSWKEiwj4OY6JPUSLVrFANyDwA6eQ4sxgpMrw9hMW', '2', 'jp-28819-php-512.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_user_address`
--

CREATE TABLE `cs_user_address` (
  `cs_address_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_address_province` varchar(255) NOT NULL,
  `cs_address_city` varchar(255) NOT NULL,
  `cs_address_line` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cs_user_ratings`
--

CREATE TABLE `cs_user_ratings` (
  `cs_rating_id` int(11) NOT NULL,
  `cs_user_id` int(11) NOT NULL,
  `cs_user_rated_id` int(11) NOT NULL,
  `cs_rating` int(5) NOT NULL,
  `cs_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cs_admin`
--
ALTER TABLE `cs_admin`
  ADD PRIMARY KEY (`cs_admin_id`);

--
-- Indexes for table `cs_bidder_options`
--
ALTER TABLE `cs_bidder_options`
  ADD PRIMARY KEY (`cs_option_id`);

--
-- Indexes for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  ADD PRIMARY KEY (`cs_bidding_id`);

--
-- Indexes for table `cs_bidding_winners`
--
ALTER TABLE `cs_bidding_winners`
  ADD PRIMARY KEY (`cs_winner_id`);

--
-- Indexes for table `cs_blogs`
--
ALTER TABLE `cs_blogs`
  ADD PRIMARY KEY (`cs_blog_id`);

--
-- Indexes for table `cs_business`
--
ALTER TABLE `cs_business`
  ADD PRIMARY KEY (`cs_business_id`);

--
-- Indexes for table `cs_categories`
--
ALTER TABLE `cs_categories`
  ADD PRIMARY KEY (`cs_category_id`);

--
-- Indexes for table `cs_locations`
--
ALTER TABLE `cs_locations`
  ADD PRIMARY KEY (`cs_location_id`);

--
-- Indexes for table `cs_notifications`
--
ALTER TABLE `cs_notifications`
  ADD PRIMARY KEY (`cs_notif_id`);

--
-- Indexes for table `cs_offers`
--
ALTER TABLE `cs_offers`
  ADD PRIMARY KEY (`cs_offer_id`);

--
-- Indexes for table `cs_plans`
--
ALTER TABLE `cs_plans`
  ADD PRIMARY KEY (`cs_plan_id`);

--
-- Indexes for table `cs_products`
--
ALTER TABLE `cs_products`
  ADD PRIMARY KEY (`cs_product_id`);

--
-- Indexes for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  ADD PRIMARY KEY (`cs_product_id`);

--
-- Indexes for table `cs_store`
--
ALTER TABLE `cs_store`
  ADD PRIMARY KEY (`cs_setting_id`);

--
-- Indexes for table `cs_tags`
--
ALTER TABLE `cs_tags`
  ADD PRIMARY KEY (`cs_tag_id`);

--
-- Indexes for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  ADD PRIMARY KEY (`cs_transaction_id`);

--
-- Indexes for table `cs_users`
--
ALTER TABLE `cs_users`
  ADD PRIMARY KEY (`cs_user_id`);

--
-- Indexes for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  ADD PRIMARY KEY (`cs_address_id`);

--
-- Indexes for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  ADD PRIMARY KEY (`cs_rating_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cs_admin`
--
ALTER TABLE `cs_admin`
  MODIFY `cs_admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_bidder_options`
--
ALTER TABLE `cs_bidder_options`
  MODIFY `cs_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_biddings`
--
ALTER TABLE `cs_biddings`
  MODIFY `cs_bidding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `cs_bidding_winners`
--
ALTER TABLE `cs_bidding_winners`
  MODIFY `cs_winner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cs_blogs`
--
ALTER TABLE `cs_blogs`
  MODIFY `cs_blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_business`
--
ALTER TABLE `cs_business`
  MODIFY `cs_business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cs_categories`
--
ALTER TABLE `cs_categories`
  MODIFY `cs_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cs_locations`
--
ALTER TABLE `cs_locations`
  MODIFY `cs_location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cs_notifications`
--
ALTER TABLE `cs_notifications`
  MODIFY `cs_notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `cs_offers`
--
ALTER TABLE `cs_offers`
  MODIFY `cs_offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `cs_plans`
--
ALTER TABLE `cs_plans`
  MODIFY `cs_plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cs_products`
--
ALTER TABLE `cs_products`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `cs_products_in_biddings`
--
ALTER TABLE `cs_products_in_biddings`
  MODIFY `cs_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cs_store`
--
ALTER TABLE `cs_store`
  MODIFY `cs_setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_tags`
--
ALTER TABLE `cs_tags`
  MODIFY `cs_tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cs_transactions`
--
ALTER TABLE `cs_transactions`
  MODIFY `cs_transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `cs_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cs_user_address`
--
ALTER TABLE `cs_user_address`
  MODIFY `cs_address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_user_ratings`
--
ALTER TABLE `cs_user_ratings`
  MODIFY `cs_rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
