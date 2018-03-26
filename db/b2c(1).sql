-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2018 at 07:20 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `b2c`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `adt_fullname` varchar(255) NOT NULL,
  `adt_mob` int(10) NOT NULL,
  `adt_pincode` int(6) NOT NULL,
  `adt_addressline1` varchar(255) NOT NULL,
  `adt_addressline2` varchar(255) NOT NULL,
  `adt_landmark` varchar(100) NOT NULL,
  `adt_city` varchar(50) NOT NULL,
  `adt_state` varchar(50) NOT NULL,
  `adt_country` varchar(50) NOT NULL DEFAULT 'IN',
  `adt_type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batch_product_list`
--

CREATE TABLE `batch_product_list` (
  `product_id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `isTop` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_id` varchar(11) NOT NULL,
  `Merchant_id` varchar(11) NOT NULL,
  `appoved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `isTop`, `parent_id`, `dateAdded`, `image_id`, `Merchant_id`, `appoved`) VALUES
(1, 1, NULL, '2018-02-12 17:00:18', '5', 'b72c423c5b5', 0),
(5, 1, 1, '2018-02-12 17:05:22', '6', 'b72c423c5b5', 0),
(6, 1, 5, '2018-02-12 17:23:20', '7', 'b72c423c5b5', 0),
(7, 1, 1, '2018-02-12 17:24:43', '8', 'b72c423c5b5', 0),
(8, 1, 7, '2018-02-12 17:27:31', '9', 'b72c423c5b5', 0),
(9, 1, 7, '2018-02-13 07:32:17', '10', 'b72c423c5b5', 0),
(10, 0, 8, '2018-02-13 08:42:59', '11', 'b72c423c5b5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categorydescription`
--

CREATE TABLE `categorydescription` (
  `category_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(512) NOT NULL,
  `cat_meta_keyword` varchar(255) NOT NULL,
  `Merchant_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorydescription`
--

INSERT INTO `categorydescription` (`category_id`, `cat_name`, `cat_description`, `cat_meta_keyword`, `Merchant_id`) VALUES
(1, 'Root Category', 'root', 'root', ''),
(5, 'Electronics', 'All Electronic Items', 'Test Test', ''),
(6, 'Mobiles', 'Mobiles', 'Mobiles', ''),
(7, 'Cloathing', 'Cloathing', 'Cloathing', ''),
(8, 'Mens Wear', 'All Man Wear', 'menwear', ''),
(9, 'Women Wear', 'women Wear', 'women Wear', 'b72c423c5b5'),
(10, 'T Shirts', 'Tees', 'Tees', 'b72c423c5b5');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `c_fullname` varchar(255) NOT NULL,
  `c_email` varchar(255) NOT NULL,
  `ppImg_id` varchar(128) DEFAULT NULL,
  `c_mobile` varchar(10) NOT NULL,
  `c_def_address_id` int(11) DEFAULT NULL,
  `c_newsletter` tinyint(1) NOT NULL,
  `c_added_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `merchant_id` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `c_fullname`, `c_email`, `ppImg_id`, `c_mobile`, `c_def_address_id`, `c_newsletter`, `c_added_datetime`, `merchant_id`) VALUES
(1, 'Kunal Awasthi', 'test@b2c.com', '2', '8561996246', NULL, 0, '2018-02-01 14:48:29', 'b72c423c5b5'),
(2, 'Test User', 'testuser@testb2c.com', NULL, '4567891203', NULL, 0, '2018-02-03 06:37:46', 'NULL');

-- --------------------------------------------------------

--
-- Table structure for table `ex_txn`
--

CREATE TABLE `ex_txn` (
  `txn_id` varchar(10) NOT NULL,
  `txn_amount` int(5) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `txn_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `img_id` int(11) NOT NULL,
  `img_dir` varchar(100) NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `img_list_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`img_id`, `img_dir`, `img_name`, `isDeleted`, `customer_id`, `img_list_id`) VALUES
(1, 'products/uploads/', 'f88e4e3c98337cca9ef7c0dcb245eaf6.png', 0, 1, '751efe55ed'),
(2, 'products/uploads/', '22be20b1bf2190a3ecccc3dea69d7ae3.jpg', 0, 1, '86a7dac962'),
(4, 'products/uploads/', 'ccb2e0f38c5c9fe40934dec78c96165a.jpg', 0, 1, NULL),
(5, 'products/uploads/', '6c40a6501ccdb51c0537d6e14f1fd896.png', 0, 1, NULL),
(6, 'products/uploads/', '0ef8a4158a8e5e3948d329bd33c8e16b.jpg', 0, 1, NULL),
(7, 'products/uploads/', 'e95752a682288d9d99cbbea9e71634b7.png', 0, 1, NULL),
(8, 'products/uploads/', '953af2936905a31a573d04e6a6876bd5.png', 0, 1, NULL),
(9, 'products/uploads/', '7a8597a6344302afed66bd0c398f7f8e.jpg', 0, 1, NULL),
(10, 'products/uploads/', '157ce46ab2eae713ed152d09d63604ab.jpg', 0, 1, NULL),
(11, 'products/uploads/', '08b153845de4831b639c9ea81d9aba16.jpg', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `image_list`
--

CREATE TABLE `image_list` (
  `img_list_id` varchar(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image_list`
--

INSERT INTO `image_list` (`img_list_id`, `customer_id`, `added`) VALUES
('751efe55ed', 1, '2018-02-03 15:44:51'),
('86a7dac962', 1, '2018-02-05 12:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `in_txn`
--

CREATE TABLE `in_txn` (
  `txn_id` varchar(11) NOT NULL,
  `txn_amount` int(5) NOT NULL,
  `txn_credit_wallet_id` int(11) NOT NULL,
  `txn_debit_wallet_id` int(11) NOT NULL,
  `txn_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `merchant_id` int(10) NOT NULL,
  `ord_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ord_status` int(1) NOT NULL DEFAULT '1',
  `ord_payment_method` varchar(32) NOT NULL,
  `ord_address_id` int(10) NOT NULL,
  `ord_invoice_id` int(10) DEFAULT NULL,
  `ord_pl_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_list_items`
--

CREATE TABLE `order_list_items` (
  `order_id` int(11) NOT NULL,
  `pl_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(10) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_description` text NOT NULL,
  `p_price` int(11) NOT NULL,
  `p_category` int(10) NOT NULL,
  `p_stock` int(4) NOT NULL,
  `img_list_id` varchar(10) NOT NULL,
  `Merchant_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_name`, `p_description`, `p_price`, `p_category`, `p_stock`, `img_list_id`, `Merchant_id`) VALUES
('25c84c7af1', 'Product Edited', ' ProductProductProductProductProductProductProductProduct  ProductProductProductProductProductProductProductProduct  ProductProductProductProductProductProductProductProduct', 2400, 1, 200, '86a7dac962', 'b72c423c5b5'),
('8f9ff4d430', 'Helllo gg', 'Hel', 200, 1, 1, '751efe55ed', 'b72c423c5b5');

-- --------------------------------------------------------

--
-- Table structure for table `p_cart`
--

CREATE TABLE `p_cart` (
  `item_id` int(11) NOT NULL,
  `p_id` varchar(10) NOT NULL,
  `qty` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_cart`
--

INSERT INTO `p_cart` (`item_id`, `p_id`, `qty`, `added_on`, `customer_id`) VALUES
(2, '25c84c7af1', 1, '2018-02-17 12:01:52', 1),
(3, '8f9ff4d430', 3, '2018-02-17 13:56:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `p_cod_bool`
--

CREATE TABLE `p_cod_bool` (
  `product_id` varchar(10) NOT NULL,
  `isEligable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_cod_bool`
--

INSERT INTO `p_cod_bool` (`product_id`, `isEligable`) VALUES
('25c84c7af1', 1),
('8f9ff4d430', 1);

-- --------------------------------------------------------

--
-- Table structure for table `p_highlight`
--

CREATE TABLE `p_highlight` (
  `product_id` varchar(10) NOT NULL,
  `pht_field_value` varchar(255) NOT NULL,
  `pht_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pht_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_highlight`
--

INSERT INTO `p_highlight` (`product_id`, `pht_field_value`, `pht_added`, `pht_id`) VALUES
('8f9ff4d430', '1st column', '2018-02-03 15:44:51', 1),
('25c84c7af1', 'hlgt 1', '2018-02-05 12:09:39', 2);

-- --------------------------------------------------------

--
-- Table structure for table `p_qna`
--

CREATE TABLE `p_qna` (
  `product_id` varchar(10) NOT NULL,
  `Merchant_id` varchar(11) NOT NULL,
  `qna_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `qna_question` varchar(255) NOT NULL,
  `qna_answer` varchar(255) DEFAULT NULL,
  `qna_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qna_closed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_qna`
--

INSERT INTO `p_qna` (`product_id`, `Merchant_id`, `qna_id`, `customer_id`, `qna_question`, `qna_answer`, `qna_added`, `qna_closed`) VALUES
('25c84c7af1', 'b72c423c5b5', 2, 1, 'does it have NFC ?? Blah Blah', 'this edited this edited this edited this edited this edited this edited this edited this edited this edited this edited this edited this edited ', '2018-02-09 16:46:47', '2018-02-12 05:02:55'),
('25c84c7af1', 'b72c423c5b5', 3, 1, 'does it have NFC ?? Blah Blah', 'no in Other Varients', '2018-02-09 16:48:04', '2018-02-10 03:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `p_review`
--

CREATE TABLE `p_review` (
  `review_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rew_rating` int(1) NOT NULL DEFAULT '1',
  `rew_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_review`
--

INSERT INTO `p_review` (`review_id`, `product_id`, `customer_id`, `rew_rating`, `rew_text`) VALUES
(1, '25c84c7af1', 1, 1, 'this review is edited by postman'),
(2, '25c84c7af1', 2, 4, 'this review is edited by postman');

-- --------------------------------------------------------

--
-- Table structure for table `p_spec`
--

CREATE TABLE `p_spec` (
  `spc_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `spc_field_name` varchar(255) NOT NULL,
  `spc_field_value` varchar(255) NOT NULL,
  `spc_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_spec`
--

INSERT INTO `p_spec` (`spc_id`, `product_id`, `spc_field_name`, `spc_field_value`, `spc_added`) VALUES
(1, '8f9ff4d430', 'qwerty', 'qwertyvalue', '2018-02-03 15:44:51'),
(2, '25c84c7af1', 'spec 1', 'spec 1 val', '2018-02-05 12:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `qna_answer_edit_log`
--

CREATE TABLE `qna_answer_edit_log` (
  `qna_id` int(11) NOT NULL,
  `qna_answer` varchar(255) NOT NULL,
  `went_old_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qna_answer_edit_log`
--

INSERT INTO `qna_answer_edit_log` (`qna_id`, `qna_answer`, `went_old_on`) VALUES
(2, 'yes but available in other varients.', '2018-02-10 06:47:32'),
(3, 'no in Other Varients', '2018-02-10 14:29:53'),
(2, 'this edited ', '2018-02-12 16:04:37'),
(2, 'this edited this edited this edited this edited this edited this edited this edited this edited this edited this edited this edited this edited ', '2018-02-12 16:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `qna_question_edit_log`
--

CREATE TABLE `qna_question_edit_log` (
  `qna_id` int(11) NOT NULL,
  `went_old_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qna_question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `wallet_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `balance` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_tbl_pass`
--

CREATE TABLE `_tbl_pass` (
  `customer_id` int(11) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `iteration` int(6) NOT NULL,
  `byte` int(2) NOT NULL DEFAULT '20'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_tbl_pass`
--

INSERT INTO `_tbl_pass` (`customer_id`, `salt`, `hash`, `iteration`, `byte`) VALUES
(1, '¶ó–¿\ZW%”!¯µêšU5', '7c9e32f9f405e2b5d3e0', 42199, 20),
(2, 'ÆïcÛïæI¹\0æz>%', 'ed6afb70c3b58ad68138', 5993, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `categorydescription`
--
ALTER TABLE `categorydescription`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `image_list`
--
ALTER TABLE `image_list`
  ADD PRIMARY KEY (`img_list_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `p_cart`
--
ALTER TABLE `p_cart`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `p_cod_bool`
--
ALTER TABLE `p_cod_bool`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `p_highlight`
--
ALTER TABLE `p_highlight`
  ADD PRIMARY KEY (`pht_id`);

--
-- Indexes for table `p_qna`
--
ALTER TABLE `p_qna`
  ADD PRIMARY KEY (`qna_id`);

--
-- Indexes for table `p_review`
--
ALTER TABLE `p_review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `p_spec`
--
ALTER TABLE `p_spec`
  ADD PRIMARY KEY (`spc_id`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`wallet_id`);

--
-- Indexes for table `_tbl_pass`
--
ALTER TABLE `_tbl_pass`
  ADD PRIMARY KEY (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_cart`
--
ALTER TABLE `p_cart`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `p_highlight`
--
ALTER TABLE `p_highlight`
  MODIFY `pht_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `p_qna`
--
ALTER TABLE `p_qna`
  MODIFY `qna_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `p_review`
--
ALTER TABLE `p_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `p_spec`
--
ALTER TABLE `p_spec`
  MODIFY `spc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `wallet_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `p_cod_bool`
--
ALTER TABLE `p_cod_bool`
  ADD CONSTRAINT `p_cod_bool_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
