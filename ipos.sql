-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2021 at 12:18 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_name`) VALUES
(1, 'kilo');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cheque`
--

CREATE TABLE `tbl_cheque` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `bank` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cheque`
--

INSERT INTO `tbl_cheque` (`id`, `name`, `bank`, `date`, `amount`) VALUES
(1, 'Haji Shakoor', 'Soneri Bank', '2021-04-27', 10000),
(2, 'Ilyas', 'MCB Bank', '2021-04-26', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `balance` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `name`, `address`, `balance`) VALUES
(1, 'test', 'test', '02892');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense`
--

CREATE TABLE `tbl_expense` (
  `expense_id` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `discription` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `Amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expense`
--

INSERT INTO `tbl_expense` (`expense_id`, `Type`, `discription`, `date`, `Amount`) VALUES
(1, 'ki', 'kkio', '2021-04-27', 90);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoice_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `cashier_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `time_order` varchar(50) NOT NULL,
  `total` float NOT NULL,
  `discount` int(11) NOT NULL,
  `paid` float NOT NULL,
  `due` float NOT NULL,
  `credit` int(11) NOT NULL,
  `duedate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoice_id`, `customer_name`, `cashier_name`, `order_date`, `time_order`, `total`, `discount`, `paid`, `due`, `credit`, `duedate`) VALUES
(1, 'test', 'Test', '2021-04-28', '06:32', 2000, 0, 0, 2000, 1, '2021-04-29'),
(2, 'test', 'Test', '2021-04-28', '06:56', 2000, 2, 20, 1978, 1, '2021-04-29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_detail`
--

CREATE TABLE `tbl_invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` char(6) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice_detail`
--

INSERT INTO `tbl_invoice_detail` (`id`, `invoice_id`, `product_id`, `product_code`, `product_name`, `qty`, `price`, `total`, `order_date`) VALUES
(1, 1, 1, 'io9', 'sugar', 20, 100, 2000, '2021-04-28'),
(2, 2, 1, 'io9', 'kiu', 20, 100, 2000, '2021-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_code` char(6) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_category` varchar(200) NOT NULL,
  `purchase_price` varchar(20) NOT NULL,
  `sell_price` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `product_satuan` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_code`, `product_name`, `product_category`, `purchase_price`, `sell_price`, `stock`, `min_stock`, `product_satuan`, `description`) VALUES
(1, 'io9', 'sugar', 'kilo', '90', '100', 50, 9, 'kilo', 'ko'),
(2, 'kio', 'kilo', 'kilo', '90', '105', 90, 9, 'kilo', 'kilo'),
(3, 'kio', 'kdiod', 'kilo', '20', '21', 82, 32, 'kilo', 'ko'),
(4, 'ki', 'kiu', 'kilo', '20.8', '23.2', 80, 7, 'kilo', 'kilo'),
(6, 'a88a', 'AA', 'kilo', '2', '2', 30, 20, 'kilo', '00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase`
--

CREATE TABLE `tbl_purchase` (
  `purchase_id` int(11) NOT NULL,
  `supplier_name` varchar(100) NOT NULL,
  `cashier_name` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `time_order` time NOT NULL,
  `total` varchar(20) NOT NULL,
  `discount` varchar(20) NOT NULL,
  `paid` varchar(20) NOT NULL,
  `due` varchar(20) NOT NULL,
  `credit` int(11) NOT NULL,
  `duedate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase`
--

INSERT INTO `tbl_purchase` (`purchase_id`, `supplier_name`, `cashier_name`, `order_date`, `time_order`, `total`, `discount`, `paid`, `due`, `credit`, `duedate`) VALUES
(1, 'ko', 'Test', '2021-04-29', '19:56:00', '7200', '200', '5000', '2000', 1, '2021-04-28'),
(2, 'ko', 'Test', '2021-04-28', '02:41:00', '42', '0', '41', '1', 1, '2021-04-28'),
(3, 'ko', 'Test', '1970-01-01', '02:53:00', '21', '0', '0', '21', 1, '2021-04-28'),
(4, 'ko', 'Test', '2021-04-28', '02:59:00', '20.8', '0', '09', '11.8', 1, '2021-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_detail`
--

CREATE TABLE `tbl_purchase_detail` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(6) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` varchar(20) NOT NULL,
  `total` varchar(20) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_purchase_detail`
--

INSERT INTO `tbl_purchase_detail` (`id`, `purchase_id`, `product_id`, `product_code`, `product_name`, `qty`, `price`, `total`, `order_date`) VALUES
(1, 1, 1, 'io9', 'sugar', 80, '90', '7200', '2021-04-29'),
(2, 2, 4, 'ki', 'kiu', 2, '21', '42', '2021-04-28'),
(3, 3, 4, 'ki', 'kiu', 1, '21', '21', '1970-01-01'),
(4, 4, 4, 'ki', 'kiu', 1, '20.8', '20.8', '2021-04-28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_satuan`
--

CREATE TABLE `tbl_satuan` (
  `kd_satuan` int(2) NOT NULL,
  `nm_satuan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_satuan`
--

INSERT INTO `tbl_satuan` (`kd_satuan`, `nm_satuan`) VALUES
(1, 'kilo');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `balance` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`supplier_id`, `name`, `address`, `balance`) VALUES
(1, 'ko', 'ko', '09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(15) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `fullname`, `password`, `role`, `is_active`) VALUES
(7, 'Test', 'testing', '123456789', 'Admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`),
  ADD UNIQUE KEY `cat_name_2` (`cat_name`);

--
-- Indexes for table `tbl_cheque`
--
ALTER TABLE `tbl_cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_expense`
--
ALTER TABLE `tbl_expense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_code`,`product_name`);

--
-- Indexes for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `tbl_purchase_detail`
--
ALTER TABLE `tbl_purchase_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  ADD PRIMARY KEY (`kd_satuan`),
  ADD UNIQUE KEY `nm_satuan` (`nm_satuan`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_cheque`
--
ALTER TABLE `tbl_cheque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_expense`
--
ALTER TABLE `tbl_expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_invoice_detail`
--
ALTER TABLE `tbl_invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_purchase`
--
ALTER TABLE `tbl_purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_purchase_detail`
--
ALTER TABLE `tbl_purchase_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_satuan`
--
ALTER TABLE `tbl_satuan`
  MODIFY `kd_satuan` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
