-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2018 at 10:57 AM
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
  `customer_id` varchar(10) NOT NULL,
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
  `cat_name` varchar(51) NOT NULL,
  `image_id` varchar(11) NOT NULL,
  `Merchant_id` varchar(10) NOT NULL,
  `appoved` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categorydescription`
--

CREATE TABLE `categorydescription` (
  `category_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(512) NOT NULL,
  `cat_meta_keyword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `isDeleted` tinyint(1) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `img_list_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image_list`
--

CREATE TABLE `image_list` (
  `img_list_id` varchar(10) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `p_cod_bool`
--

CREATE TABLE `p_cod_bool` (
  `product_id` varchar(10) NOT NULL,
  `isEligable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_highlight`
--

CREATE TABLE `p_highlight` (
  `product_id` varchar(10) NOT NULL,
  `pht_field_value` int(11) NOT NULL,
  `pht_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pht_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_qna`
--

CREATE TABLE `p_qna` (
  `product_id` varchar(10) NOT NULL,
  `qna_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `qna_question` varchar(255) NOT NULL,
  `qna_answer` varchar(255) DEFAULT NULL,
  `qna_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qna_closed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_review`
--

CREATE TABLE `p_review` (
  `review_id` int(11) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `rew_rating` int(1) NOT NULL,
  `rew_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `qna_answer_edit_log`
--

CREATE TABLE `qna_answer_edit_log` (
  `qna_id` int(11) NOT NULL,
  `qna_answer` varchar(255) NOT NULL,
  `went_old_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_cart`
--
ALTER TABLE `p_cart`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_highlight`
--
ALTER TABLE `p_highlight`
  MODIFY `pht_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_qna`
--
ALTER TABLE `p_qna`
  MODIFY `qna_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_review`
--
ALTER TABLE `p_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `p_spec`
--
ALTER TABLE `p_spec`
  MODIFY `spc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `wallet_id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
