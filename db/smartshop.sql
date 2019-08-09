
--
-- Database: `smartshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `sl` int(11) NOT NULL,
  `to_user` varchar(40) NOT NULL,
  `from_user` varchar(40) NOT NULL,
  `message` text NOT NULL,
  `message_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`sl`, `to_user`, `from_user`, `message`, `message_time`, `status`) VALUES
(1, 'admin', 'srabone', 'Hello', '2018-04-22 17:32:25', 1),
(2, 'admin', 'srabone', 'Hola', '2018-04-22 17:32:25', 1),
(3, 'admin', 'srabone', 'Hola', '2018-04-22 17:32:25', 1),
(4, 'srabone', 'admin', 'Good', '2018-04-22 04:16:47', 1),
(5, 'admin', 'srabone', 'Very Good', '2018-04-22 17:32:25', 1),
(6, 'srabone', 'admin', 'Ow', '2018-04-22 04:16:47', 1),
(7, 'admin', 'srabone', 'hello', '2018-04-22 17:32:25', 1),
(8, 'admin', 'srabone', 'Good', '2018-04-22 17:32:25', 1),
(9, 'admin', 'srabone', 'sdas', '2018-04-22 17:32:25', 1),
(10, 'srabone', 'admin', 'vg', '2018-04-22 04:42:23', 1),
(11, 'srabone', 'admin', 'good', '2018-04-22 04:43:13', 1),
(12, 'admin', 'srabone', 'hello Sir', '2018-04-22 17:32:25', 1),
(13, 'admin', 'eity00', 'HEllo Sir', '2018-04-22 06:50:42', 1),
(14, 'eity00', 'admin', 'Good Evening', '2018-04-22 06:51:51', 1),
(15, 'admin', 'srabone', 'Good Night Sir It''s 11pm', '2018-04-22 17:32:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `sl` int(11) NOT NULL,
  `product_sl` int(11) NOT NULL,
  `month` varchar(10) NOT NULL,
  `units` int(11) NOT NULL,
  `totale_sale` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`sl`, `product_sl`, `month`, `units`, `totale_sale`) VALUES
(1, 5, 'Apr/2018', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `sl` int(11) NOT NULL,
  `for_user` varchar(40) NOT NULL,
  `from_user` varchar(40) NOT NULL,
  `message` mediumtext NOT NULL,
  `create_date` date NOT NULL,
  `destroy_date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`sl`, `for_user`, `from_user`, `message`, `create_date`, `destroy_date`, `status`) VALUES
(1, '1', 'system', 'Dear  wamvmaw, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-10 Delivery Date : 2018-04-17 Order ID :  order1 Product SL : Jamdani Sharee Cost : 100 Units : 1<br>', '2018-04-10', '2018-04-17', 1),
(4, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order4 Product SL : Polo TShirt Cost : 220 Units : 2<br>', '2018-04-23', '2018-04-30', 1),
(5, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order4 Product SL : converse Cost : 100 Units : 1<br>', '2018-04-23', '2018-04-30', 1),
(6, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order6 Product SL : Sharee Cost : 100 Units : 1<br>', '2018-04-23', '2018-04-30', 1),
(7, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order7 Product SL : Sharee Cost : 100 Units : 1<br>', '2018-04-23', '2018-04-30', 0),
(8, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order8 Product SL : Sharee Cost : 100 Units : 1<br>', '2018-04-23', '2018-04-30', 0),
(9, '1', 'order', 'There is a new order from srabone.The details is here : Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order8 Product SL : Sharee Cost : 100 Units : 1<br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order8 Product SL : Sharee Cost : 100 Units : 1<br>', '2018-04-23', '2018-04-30', 1),
(10, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order9 Product SL : Polo TShirt Cost : 110 Units : 1<br>', '2018-04-23', '2018-04-30', 0),
(11, '1', 'order', 'There is a new order from srabone.The details is here : Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order9 Product SL : Polo TShirt Cost : 110 Units : 1<br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order9 Product SL : Polo TShirt Cost : 110 Units : 1<br>', '2018-04-23', '2018-04-30', 1),
(12, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order10 Product SL : Polo TShirt Cost : 110 Units : 1<br>', '2018-04-23', '2018-04-30', 0),
(13, '1', 'order', 'There is a new order from srabone.The details is here : Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order10 Product SL : Polo TShirt Cost : 110 Units : 1<br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order10 Product SL : Polo TShirt Cost : 110 Units : 1<br>', '2018-04-23', '2018-04-30', 1),
(14, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order11 Product SL : Polo TShirt Cost : 110 Units : 1<br>', '2018-04-23', '2018-04-30', 0),
(15, '1', 'order', 'There is a new order from srabone.The details is here : Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order11 Product SL : Polo TShirt Cost : 110 Units : 1<br>Order Date : 2018-04-23 Delivery Date : 2018-04-30 Order ID :  order11 Product SL : Polo TShirt Cost : 110 Units : 1<br>', '2018-04-23', '2018-04-30', 1),
(16, '1', 'order', 'This orderorder3 is not delivered yet. last date of delivery is passed Please check.', '0000-00-00', '0000-00-00', 0),
(17, '1', 'order', 'This orderorder3 is not delivered yet. last date of delivery is passed Please check.', '0000-00-00', '0000-00-00', 0),
(18, '1', 'order', 'This orderorder3 is not delivered yet. last date of delivery is passed Please check.', '0000-00-00', '0000-00-00', 0),
(19, '1', 'order', 'This orderorder3 is not delivered yet. last date of delivery is passed Please check.', '2018-04-23', '2018-04-25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `sl` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount` float NOT NULL,
  `product_sl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `sl` int(11) NOT NULL,
  `order_id` varchar(40) NOT NULL,
  `product_sl` int(11) NOT NULL,
  `user_sl` int(11) NOT NULL,
  `delivery_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delivery_status` tinyint(4) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `units` int(11) NOT NULL,
  `total_cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`sl`, `order_id`, `product_sl`, `user_sl`, `delivery_date`, `delivery_status`, `order_date`, `units`, `total_cost`) VALUES
(4, 'order4', 1, 2, '2018-04-23 03:50:34', 1, '2018-04-22 18:00:00', 2, 220),
(5, 'order4', 3, 2, '2018-04-23 03:50:34', 1, '2018-04-22 18:00:00', 1, 100),
(6, 'order6', 4, 2, '2018-04-29 18:00:00', 0, '2018-04-22 18:00:00', 1, 100),
(7, 'order7', 4, 2, '2018-04-29 18:00:00', 0, '2018-04-22 18:00:00', 1, 100),
(8, 'order8', 4, 2, '2018-04-29 18:00:00', 0, '2018-04-22 18:00:00', 1, 100),
(9, 'order9', 1, 2, '2018-04-29 18:00:00', 0, '2018-04-22 18:00:00', 1, 110),
(10, 'order10', 1, 2, '2018-04-29 18:00:00', 0, '2018-04-22 18:00:00', 1, 110);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `sl` int(11) NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `product_name` text NOT NULL,
  `product_brand` text,
  `product_description` mediumtext NOT NULL,
  `category` text NOT NULL,
  `subcategory` text NOT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `offers` float NOT NULL DEFAULT '0',
  `image` varchar(1000) NOT NULL,
  `added_by` varchar(40) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`sl`, `product_code`, `product_name`, `product_brand`, `product_description`, `category`, `subcategory`, `price`, `stock`, `offers`, `image`, `added_by`, `updated_by`, `add_date`, `update_date`) VALUES
(3, 'product3', 'converse', 'Bata', 'On Coursera, you can start a course today that is within a graduate degree curriculum. If you are accepted to the full Masterâ€™s program, your completed courses count towards earning your degree. Earn credentials as you learn skills. Sample content before you commit to a full degree program. We offer more access to Masterâ€™s degrees and high-value credentials than ever to make it easy to find a program thatâ€™s right for you.', '6', 'Shoes', 100, 5, 0, 'upload/product3.jpg', 'wamvmaw', NULL, '2018-04-22 23:18:46', NULL),
(4, 'product4', 'Sharee', 'Aarong', 'a garment worn by Hindu women, consisting of a long piece of cotton or silk wrapped around the body with one end draped over the head or over one shoulder. Where is that saree and jacket you used to wear in the cold weather.', '7', 'Sharee', 100, 0, 0, 'upload/product4.jpg', 'wamvmaw', NULL, '2018-04-22 23:39:30', NULL),
(5, 'product5', 'Tshirt', 'Yellow', 'A T-shirt is a style of unisex fabric shirt named after the T shape of its body and sleeves. It normally has short sleeves and a round neckline, known as a crew neck, which lacks a collar. T-shirts are generally made of a light, inexpensive fabric and are easy to clean. Typically made of cotton textile in a stockinette or jersey knit,', '6', 'Tshirt', 100, 0, 0, 'upload/product5.jpg', 'wamvmaw', NULL, '2018-04-21 01:30:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `sl` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `subcategory` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`sl`, `category`, `subcategory`) VALUES
(6, 'Men', 'Shirt,Tshirt,Pant,Shoes'),
(7, 'Women', 'Sharee,Shoes'),
(8, 'Kids', 'Pant,Shirt,TShirt,Shoes,Skirt');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `sl` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `full_name` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` text NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `gender` text NOT NULL,
  `zip_code` int(5) DEFAULT NULL,
  `profile_picture` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`sl`, `username`, `password`, `full_name`, `email`, `role`, `contact_no`, `address`, `gender`, `zip_code`, `profile_picture`) VALUES
(1, 'wamvmaw', '123456', 'Wasif Al Mahmud', 'wamw@gmail.com', 'admin', '8801723406566', 'Uttara, Dhaka', 'Male', 1230, 'pp/wamvmaw.jpg'),
(2, 'srabone', '123456', 'srabone', 'srabone@gmail.com', 'customer', '8801723406566', 'Uttara', 'Female', 1230, 'pp/srabone.jpg'),
(3, 'eity00', '123456', 'eity', 'e@g.com', 'customer', '2147483647', 'Dhaka', 'Female', 1230, NULL),
(4, 'trq123', '123456', 'tareq', 'trq@gmail.com', 'customer', '2147483647', 'Uttara', 'Male', 0, NULL),
(5, 'israt1', '123456', 'Israt', 'israt@iubat.edu', 'customer', '2147483647', 'Abdullapur', 'Female', 0, NULL),
(6, 'shihab', '123456', 'shihab', 'shihab@iubat.edu', 'customer', '2147483647', 'Uttara', 'Male', 0, NULL),
(7, 'rbn123', '123456', 'Robiul Alam Robin', 'rbn@gmail.com', 'customer', '2147483647', 'Uttara', 'Male', 0, NULL),
(9, 'srabone123', '123456', 'Farzana Islam', 'jahan@univx.edu', 'customer', '8801700000000', 'MES', 'Female', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`sl`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `product_sl` (`product_sl`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`sl`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `product_code` (`product_sl`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`sl`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`sl`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
