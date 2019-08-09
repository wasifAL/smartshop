create database smartshop;

CREATE TABLE `chat` (
  `sl` int(11) NOT NULL,
  `to_user` varchar(40) NOT NULL,
  `from_user` varchar(40) NOT NULL,
  `message` text NOT NULL,
  `message_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(2, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-14 Delivery Date : 2018-04-21 Order ID :  order2 Product SL : converse Cost : 100 Units : 1<br>', '2018-04-14', '2018-04-21', 0),
(3, '2', 'system', 'Dear  srabone, thank you for using our online shop. You have successfully order the below items : <br>Order Date : 2018-04-14 Delivery Date : 2018-04-21 Order ID :  order3 Product SL : Jamdani Sharee Cost : 100 Units : 1<br>', '2018-04-14', '2018-04-21', 0);

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

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`sl`, `start_date`, `end_date`, `discount`, `product_sl`) VALUES
(9, '2018-04-07', '2018-04-08', 20, 1);

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
(1, 'order1', 2, 1, '2018-04-16 18:00:00', 0, '2018-04-09 18:00:00', 1, 100),
(2, 'order2', 3, 2, '2018-04-20 18:00:00', 0, '2018-04-13 18:00:00', 1, 100),
(3, 'order3', 2, 2, '2018-04-20 18:00:00', 0, '2018-04-13 18:00:00', 1, 100);

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
  `offers` varchar(50) NOT NULL DEFAULT ' ',
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
(1, 'product0', 'Polo TShirt', 'Cats Eye', 'Description is the fiction-writing mode for transmitting a mental image of the particulars of a story. Together with dialogue, narration, exposition, and summarization, description is one of the most widely recognized of the fiction-writing modes. As stated in Writing from A to Z, edited by Kirk Polking, description is more than the amassing of details; it is bringing something to life by carefully choosing and arranging words and phrases to produce the desired effect.[3] The most appropriate and effective techniques for presenting description are a matter of ongoing discussion among writers and writing coaches.', '6', 'Tshirt', 110, 94, '20', 'upload/product0.jpg', 'wamvmaw', NULL, '2018-04-20 02:54:09', NULL),
(3, 'product3', 'converse', 'Bata', 'On Coursera, you can start a course today that is within a graduate degree curriculum. If you are accepted to the full Masterâ€™s program, your completed courses count towards earning your degree. Earn credentials as you learn skills. Sample content before you commit to a full degree program. We offer more access to Masterâ€™s degrees and high-value credentials than ever to make it easy to find a program thatâ€™s right for you.', '6', 'Shoes', 100, 99, ' ', 'upload/product3.jpg', 'wamvmaw', NULL, '2018-04-14 17:12:33', NULL),
(4, 'product4', 'Sharee', 'Aarong', 'a garment worn by Hindu women, consisting of a long piece of cotton or silk wrapped around the body with one end draped over the head or over one shoulder. Where is that saree and jacket you used to wear in the cold weather.', '7', 'Sharee', 100, 200, ' ', 'upload/product4.jpg', 'wamvmaw', NULL, '2018-04-20 02:56:07', NULL),
(5, 'product5', 'Tshirt', 'Yellow', 'A T-shirt is a style of unisex fabric shirt named after the T shape of its body and sleeves. It normally has short sleeves and a round neckline, known as a crew neck, which lacks a collar. T-shirts are generally made of a light, inexpensive fabric and are easy to clean. Typically made of cotton textile in a stockinette or jersey knit,', '6', 'Tshirt', 100, 120, ' ', 'upload/product5.jpg', 'wamvmaw', NULL, '2018-04-20 00:24:05', NULL);

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
  `contact_no` int(15) NOT NULL,
  `address` text NOT NULL,
  `gender` text NOT NULL,
  `zip_code` int(5) DEFAULT NULL,
  `profile_picture` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`sl`, `username`, `password`, `full_name`, `email`, `role`, `contact_no`, `address`, `gender`, `zip_code`, `profile_picture`) VALUES
(1, 'wasif1', '123456', 'Wasif Al Mahmud', 'wamvmaw@gmail.com', 'admin', 172346566, 'Uttara, Dhaka', 'Male', 1230, NULL),
(2, 'srabone', '123456', 'srabone', 'srabone@gmail.com', 'customer', 2147483647, 'MES', 'Female', 1230, NULL),
(3, 'eity00', '123456', 'eity', 'e@g.com', 'customer', 2147483647, 'Dhaka', 'Female', 1230, NULL),
(4, 'trq123', '123456', 'tareq', 'trq@gmail.com', 'customer', 2147483647, 'Uttara', 'Male', 0, NULL);

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
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `sl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
