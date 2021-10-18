-- phpMyAdmin SQL Dump
-- version 4.0.10.17
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 07, 2017 at 12:26 PM
-- Server version: 5.5.51
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ads_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_ads`
--

CREATE TABLE IF NOT EXISTS `t_ads` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(3) DEFAULT '1',
  `campaign_id` int(11) DEFAULT NULL,
  `ad_name` varchar(150) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_url` varchar(150) DEFAULT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `company_url` varchar(150) DEFAULT NULL,
  `company_logo` varchar(200) DEFAULT NULL,
  `coverage_radius` int(4) DEFAULT NULL,
  `ads_banner` varchar(300) DEFAULT NULL,
  `off_deal` varchar(25) NOT NULL DEFAULT '',
  `coupon_code` varchar(15) NOT NULL DEFAULT '',
  `deal_link` varchar(250) NOT NULL DEFAULT '',
  `associated_store` int(3) DEFAULT '1',
  `min_entry_age` int(3) NOT NULL DEFAULT '0',
  `max_entry_age` int(3) NOT NULL DEFAULT '101',
  `entry_gender` enum('male','female','transgender','all') NOT NULL DEFAULT 'all',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `exclusion_days` varchar(15) DEFAULT NULL,
  `location_count` int(2) DEFAULT NULL,
  `quiz_count` int(2) DEFAULT NULL,
  `reward_amount` int(5) NOT NULL DEFAULT '0',
  `loyalty_audience` varchar(15) DEFAULT 'public',
  `moby_audience` varchar(15) DEFAULT 'off',
  `salary_group` varchar(10) DEFAULT NULL,
  `club_membership` varchar(10) DEFAULT NULL,
  `defence_service` varchar(10) DEFAULT NULL,
  `work_type` varchar(10) DEFAULT NULL,
  `watch_brand` varchar(10) DEFAULT NULL,
  `car_brand` varchar(10) DEFAULT NULL,
  `residence_type` varchar(10) DEFAULT NULL,
  `transport_type` varchar(10) DEFAULT NULL,
  `miles_card` varchar(10) DEFAULT NULL,
  `credit_card` varchar(10) DEFAULT NULL,
  `publish` enum('yes','no') NOT NULL DEFAULT 'no',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `t_ads`
--

INSERT INTO `t_ads` (`ad_id`, `version_id`, `campaign_id`, `ad_name`, `product_name`, `product_url`, `company_name`, `company_url`, `company_logo`, `coverage_radius`, `ads_banner`, `off_deal`, `coupon_code`, `deal_link`, `associated_store`, `min_entry_age`, `max_entry_age`, `entry_gender`, `start_date`, `end_date`, `exclusion_days`, `location_count`, `quiz_count`, `reward_amount`, `loyalty_audience`, `moby_audience`, `salary_group`, `club_membership`, `defence_service`, `work_type`, `watch_brand`, `car_brand`, `residence_type`, `transport_type`, `miles_card`, `credit_card`, `publish`, `timestamp`) VALUES
(1, 38, 16, 'Discount on Saree', 'Saree', 'https://www.indianroots.in', 'Indian Roots', 'https://www.indianroots.in', '16171113023008.png', 300, '16171113023008.png', '20 % off', 'DEAL20', 'https://www.indianroots.in', 1, 0, 100, 'female', '2017-11-02', '2017-12-12', '3,5', 33, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:35:25'),
(2, 34, 6, 'LG TVS', 'Televisions', 'http://www.lg.com/in/tvs', 'LG', 'http://www.lg.com/in/', '6171113023949.png', 300, '6171113023949.png', '30 % cashback', 'DEAL30', 'http://www.lg.com/in/', 1, 0, 100, 'all', '2017-11-07', '2017-12-07', '3', 31, 3, 100, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:16:48'),
(3, 33, 37, 'Phive Nov', 'Handbags', 'www.phiverivers.com', 'Phive Rivers', 'www.phiverivers.com', '37171113043939.png', 30000, '37171113043939.png', '20% off', 'DEAL20', 'www.phiverivers.com', 1, 18, 69, 'female', '2017-11-07', '2018-11-07', '0,2', 29, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:17:10'),
(4, 34, 1, 'dell mumbai', 'computer', 'http://www.dell.com/in/p', 'dell', 'http://www.dell.com/in/p', '1171114113029.png', 3000, '1171114113029.png', '20% discount', 'dell20', 'http://www.dell.com/in/p', 1, 20, 100, 'all', '2017-11-01', '2017-12-01', '0,6', 23, 0, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:17:32'),
(5, 30, 2, 'levis', 'jeans', 'http://levi.in/', 'levis', 'http://levi.in/', '2171114112552.png', 1000, '2171114112552.png', '20% discount', 'levis40', 'http://levi.in/', 1, 21, 71, 'all', '2017-10-07', '2017-12-07', '0', 24, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:17:54'),
(6, 26, 28, 'Amazonian Saviour', 'Spa', 'http://www.thebodyshop.in/', 'The Body Shop', 'http://www.thebodyshop.in/', '28171114113423.png', 3000, '28171114113423.png', '20% OFF', 'DEAL20', 'http://www.thebodyshop.in/', 1, 19, 85, 'all', '2017-10-21', '2017-12-21', '1', 23, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:18:10'),
(7, 25, 4, 'Hyundai', 'i10', 'http://www.hyundai.com/in/en/Main/index.html', 'Hyundai', 'http://www.hyundai.com/in/en/Main/index.html', '4171114114340.png', 3000, '4171114114340.png', '30% OFF', 'DEAL30', 'http://www.hyundai.com/in/en/Main/index.html', 1, 0, 100, 'all', '2017-09-22', '2017-12-22', '', 22, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:18:32'),
(8, 29, 39, 'Titan Watches', 'Mens Watch', 'https://www.titan.co.in/titan/product/titan-regalia-sovereign-black-dial-chronograph-watch-for-men/1747KM02', 'TITAN', 'https://www.titan.co.in/shop-online/watches/men', '39171114015108.png', 30000, '39171114015108.png', '20% OFF', 'TITAN20', 'https://www.titan.co.in/shop-online/watches/men', 1, 0, 100, 'male', '2017-11-05', '2017-12-29', '3', 14, 0, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:19:25'),
(9, 26, 16, 'Indian Roots', 'Saree', 'https://www.indianroots.com/', 'Indian Roots', 'https://www.indianroots.com/', '16171114115101.png', 3000, '16171114115101.png', '10% OFF', 'DEAL10', 'https://www.indianroots.com/', 1, 0, 100, 'all', '2017-10-15', '2017-12-30', '', 21, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:19:35'),
(10, 29, 38, 'Phive Rivers Leather Bags', 'Leather Bags', 'http://www.phiverivers.com/womens-bag/handbag', 'Phive Rivers', 'http://www.phiverivers.com/', '38171114015355.png', 30000, '38171114015355.png', '30% OFF', 'PR30', 'http://www.phiverivers.com/', 1, 0, 100, 'female', '2017-12-03', '2018-01-12', '3', 14, 0, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:19:57'),
(11, 27, 0, 'Puma Shoes', 'Shoes', 'https://in.puma.com/women/shoes/running.html?dir=asc&order=position&in-stock=1', 'Puma', 'https://in.puma.com/', '0171114014657.png', 30000, '0171114014657.png', '40% off on shoes', 'PUMA40', 'https://in.puma.com/', 1, 0, 100, 'all', '2017-10-09', '2017-12-09', '3', 14, 0, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:20:06'),
(12, 27, 41, 'Voylla Jewellery', 'Women''s Artificial Jewellery', 'https://www.voylla.com/jewellery', 'Voylla', 'https://www.voylla.com/', '41171114014427.png', 30000, '41171114014427.png', 'Flat 30% off', 'WOW30', 'https://www.voylla.com/', 1, 0, 100, 'female', '2017-11-22', '2018-02-22', '3', 14, 0, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:20:15'),
(13, 26, 42, 'Maybelline New York', 'Lipsticks', 'https://www.maybelline.co.in/lips/lipstick', 'Maybelline', 'https://www.maybelline.co.in/', '42171114014255.png', 30000, '42171114014255.png', '15% OFF', 'LIP15', 'https://www.maybelline.co.in/', 1, 0, 100, 'female', '2017-12-05', '2017-12-28', '3', 14, 0, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:20:21'),
(14, 17, 14, 'Anvaya i10', 'Hyundai i10', 'https://www.cardekho.com/carmodels/Hyundai/Hyundai_i10', 'Hyundai', 'https://www.cardekho.com/carmodels/Hyundai/', '14171114100519.png', 3000, '14171114100519.png', 'Get 30% Off', 'ABC123', 'https://www.cardekho.com/carmodels/Hyundai/', 1, 18, 58, 'all', '2017-10-23', '2018-03-23', '4', 14, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:20:35'),
(15, 15, 0, 'Titan Skinn Perfume', 'Perfume', 'https://www.titan.co.in/skinn/product/skinn-bohemian-country-road-fragrance-for-men/FM08PC1', 'TITAN SKINN', 'https://www.titan.co.in/shop-online/skinn/skinn?cm_mmc=GooWASearchBrand-_-405096069-_-30281648829-_-231067826611&gclid=EAIaIQobChMI7bG80uW_1wIVyQ0rCh0', '171115103726.png', 30000, '171115103726.png', '20% OFF', 'SKINN20', 'https://www.titan.co.in/shop-online/skinn/skinn?cm_mmc=GooWASearchBrand-_-405096069-_-30281648829-_-231067826611&gclid=EAIaIQobChMI7bG80uW_1wIVyQ0rCh0UWwTuEAAYASAAEgJdJ_D_BwE', 1, 0, 100, 'all', '2017-12-06', '2017-12-30', '2', 12, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:20:45'),
(16, 9, 43, 'Wrangler Clothing', 'Jeans', 'https://www.wrangler-ap.com/in/products/men/category-jeans+season-AW17', 'WRANGLER', 'https://www.wrangler-ap.com/in', '43171115110525.png', 30000, '43171115110525.png', '25% OFF', 'JEAN25', 'https://www.wrangler-ap.com/in', 1, 0, 100, 'all', '2017-10-10', '2017-12-29', '3', 6, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:21:02'),
(17, 8, 44, 'BODY SHOP BATH AND BODY PRODUCTS', 'Bath & Body Products', 'http://www.thebodyshop.in/body/bath-and-body/washes-gels.html/', 'Body Shop', 'http://www.thebodyshop.in/body.html/', '44171115113122.png', 30000, '44171115113122.png', '30% OFF', 'SHOP30', 'https://www.themall.co.uk/images/store/The-body-shop.png?preset=store-logo', 1, 0, 100, 'all', '2017-11-07', '2017-12-07', '3', 5, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:21:13'),
(18, 6, 1, 'Dell Laptop on Sale', 'Dell Laptop', 'http://deals.dell.com/category/laptops', 'Dell', 'http://dell.com', '1171206071539.png', 30000, '1171206071539.png', '20% Off', 'DELL20', 'http://deals.dell.com/category/laptops', 1, 0, 100, 'all', '2017-11-05', '2017-12-04', '', 4, 3, 10, 'private', 'on', '', '', '', '', '', '', '', '', '', '', 'yes', '2017-12-07 10:28:23');

-- --------------------------------------------------------

--
-- Table structure for table `t_ad_location`
--

CREATE TABLE IF NOT EXISTS `t_ad_location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) DEFAULT NULL,
  `location_lat` varchar(10) DEFAULT NULL,
  `location_long` varchar(10) DEFAULT NULL,
  `location_state` varchar(200) NOT NULL,
  `landmark` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `t_ad_location`
--

INSERT INTO `t_ad_location` (`location_id`, `ad_id`, `location_lat`, `location_long`, `location_state`, `landmark`, `email`, `contact`) VALUES
(2, 1, '28.4383741', '76.9986828', '450, udyog vihar industrial area phase vi, sector 37, gurugram, haryana 122004, india', 'near elements exports', 'a@g.com', '9876543212'),
(3, 1, '28.518227', '77.305997', '123, mangla puri main rd, new manglapuri, manglapuri village, sultanpur, new delhi, delhi 110030, india', 'new mangla puri', 'b@gmail.com', '8765432345'),
(4, 2, '28.5004706', '77.1688786', '123, mangla puri main rd, new manglapuri, manglapuri village, sultanpur, new delhi, delhi 110030, india', 'main road new mangla puri', 'tv@gmail.com', '9876544689'),
(5, 2, '28.5067876', '77.1748888', 'acharya shree tulsi marg, andheria mor village, vasant kunj, new delhi, delhi 110070, india', 'chattarpur metro station', 'ctv@gmail.com', '9876543212'),
(6, 3, '28.5519949', '77.1216996', 'worldmark 3, aerocity, indira gandhi international airport, new delhi, delhi 110037, india', 'central mall, first floor', 'mohit@phiverivers.com', '1234567890'),
(7, 3, '28.6001972', '77.2269344', 'khan market, rabindra nagar, new delhi, delhi 110003', 'shop number 21', 'a@g.com', '987654321'),
(8, 3, '19.0693377', '72.8710618', 'c 36, bandra kurla complex road, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', 'bkc', 'b@gmail.com', '9876543212'),
(9, 4, '19.0689727', '72.8696195', '59, bandra kurla complex road, kolivery village, mmrda area, kalina, bandra east, mumbai, maharashtra 400098, india', '', '', ''),
(10, 4, '19.0689118', '72.8702417', 'r4-a/g, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', 'indus bank', 'dell@gmail.com', '9958203015'),
(11, 5, '19.0685468', '72.8698726', 'r4-a/g, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', 'near axis bank', 'mohit@levis.com', '9965203010'),
(12, 6, '19.0641459', '72.8614290', 'icici bank north tower, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', 'north tower', 'mohit@mobi.com', '9876543212'),
(13, 7, '19.0636997', '72.8612262', '10, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', 'icici atm', 'mohit@mobi.com', '9876543212'),
(14, 9, '19.0630913', '72.8606351', 'il&fs financial centre, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', 'ibm ltd', 'mohit@mobi.com', '9876543212'),
(15, 13, '19.0683643', '72.8701177', 'b-1001, income tax colony, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', '', '', ''),
(16, 10, '19.0684454', '72.8698602', 'b-1001, income tax colony, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', '', 'mohit@elementsexports.com', '9958203010'),
(17, 8, '19.0689321', '72.8701177', 'r4-a/g, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', '', '', ''),
(18, 8, '19.0694188', '72.8703752', 'r4-a/g, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', '', 'b@gmail.com', '9958203010'),
(19, 12, '19.0689321', '72.8702893', 'r4-a/g, g block bkc, bandra kurla complex, bandra east, mumbai, maharashtra 400051, india', '', 'b@gmail.com', '9958203010'),
(20, 11, '19.0694188', '72.8699460', '59, bandra kurla complex road, kolivery village, mmrda area, kalina, bandra east, mumbai, maharashtra 400098, india', '', 'b@gmail.com', '9958203010'),
(21, 14, '28.5602783', '77.2194842', '62, uday park, south extension ii, new delhi, delhi 110049, india', 'south ex2', 'shekhar@credext.com', '568855678'),
(22, 14, '28.5964293', '77.2367352', 'unnamed road, delhi golf club, golf links, new delhi, delhi 110003, india', '', '', ''),
(23, 15, '12.9404894', '77.5853570', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', 'future lifestyle', 'b@gmail.com', '9958203010'),
(24, 10, '12.9403116', '77.5853677', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(25, 8, '12.9403430', '77.5853570', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(26, 12, '12.9402071', '77.5854106', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(27, 13, '12.9403012', '77.5853462', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(28, 11, '12.9403325', '77.5853892', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(29, 16, '12.9402593', '77.5852926', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(30, 17, '12.9402593', '77.5853570', '124, 10th main rd, 1st block, jaya nagar east, jayanagar, bengaluru, karnataka 560011, india', '', 'b@gmail.com', '9958203010'),
(31, 10, '12.9491011', '77.6899201', '77 town center, kodbisanhalli, marathahalli, bengaluru, karnataka 560037, india', '', 'b@gmail.com', '9958203010'),
(32, 18, '28.5187134', '77.3057742', 'beri bag rd, gayatri kunj, ali, new delhi, delhi 110044, india', 'near peer baba', 'delldelhi@gmail.com', '9876543215'),
(33, 18, '28.4300528', '76.9666528', 'pataudi rd, gurugram, haryana 122505, india', 'gurgaon', 'dellgurugram@gmail.com', '765787654'),
(34, 18, '28.5160950', '77.3007767', 'mathora road,, a-54/7, ali extension, ali, new delhi, delhi 110044, india', 'aali gaon road', 'dellaali@gmail.com', '875477799292');

-- --------------------------------------------------------

--
-- Table structure for table `t_answers`
--

CREATE TABLE IF NOT EXISTS `t_answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `status` enum('right','wrong') DEFAULT 'right',
  `user_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_campaign`
--

CREATE TABLE IF NOT EXISTS `t_campaign` (
  `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(3) DEFAULT '1',
  `campaign_name` varchar(100) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `t_campaign`
--

INSERT INTO `t_campaign` (`campaign_id`, `version_id`, `campaign_name`, `store_id`, `timestamp`) VALUES
(1, 1, 'Dell laptop on sale', 1, '2017-05-01 19:15:13'),
(2, 1, 'Levis Sale', 1, '2017-05-01 19:15:13'),
(3, 1, 'New Campaign', 1, '2017-06-01 04:27:28'),
(4, 1, 'Hyundai i10', 1, '2017-06-01 04:54:39'),
(5, 1, 'Home Center', 1, '2017-06-01 07:22:28'),
(6, 1, 'TV on sale', 1, '2017-06-01 09:12:30'),
(7, 1, 'Pulsar 220 on Sale', 1, '2017-06-01 10:57:21'),
(8, 1, 'Barishta', 1, '2017-06-01 12:46:56'),
(9, 1, 'Mohit new', 1, '2017-06-12 12:56:26'),
(10, 1, 'CyberCity', 1, '2017-06-20 10:18:31'),
(11, 1, 'Subway', 1, '2017-07-01 05:54:57'),
(12, 1, 'South Point Mall', 1, '2017-07-02 13:15:02'),
(13, 1, 'South Point Mall', 1, '2017-07-02 13:29:01'),
(14, 1, 'Shoes', 1, '2017-07-03 04:09:02'),
(15, 1, 'Revlon', 1, '2017-07-03 04:13:44'),
(16, 1, 'Indian Roots', 1, '2017-07-03 04:17:28'),
(17, 1, 'New collection at Panna sarees', 1, '2017-07-04 04:20:06'),
(18, 1, 'Step into Panna Sarees  & Get cash rewarded', 1, '2017-07-04 04:20:48'),
(19, 1, 'Step into Panna Sarees  & Get cash rewarded', 1, '2017-07-04 04:21:12'),
(20, 1, 'Panna sarees', 1, '2017-07-04 04:21:43'),
(21, 1, 'Panna sarees', 1, '2017-07-04 04:22:54'),
(22, 1, '7 degrees Brauhas', 1, '2017-07-04 05:46:05'),
(23, 1, 'Chantik furniture', 1, '2017-07-04 05:46:05'),
(24, 1, 'Skill Training at Centum', 1, '2017-07-10 08:12:50'),
(25, 1, 'Maxus', 1, '2017-07-11 04:13:38'),
(26, 1, 'Perfume', 1, '2017-07-14 11:20:00'),
(27, 1, 'phive rivers', 1, '2017-07-26 07:47:37'),
(28, 1, 'The Body shop', 1, '2017-08-07 10:31:37'),
(29, 1, 'The Body shop - Vitamin C cream', 1, '2017-08-07 15:52:22'),
(30, 1, 'Body Shop - Launch of Vitamin C glow', 1, '2017-08-07 15:57:10'),
(31, 1, 'Marks and spencers Perfume', 1, '2017-08-07 16:20:21'),
(32, 1, 'Anvaya', 1, '2017-11-11 16:37:56'),
(33, 1, 'Anvaya New', 1, '2017-11-11 17:28:32'),
(34, 1, 'Sandeep', 1, '2017-11-11 17:49:35'),
(35, 1, 'Jagjit', 1, '2017-11-11 18:06:21'),
(36, 1, 'Anvaya New 1', 1, '2017-11-12 13:10:02'),
(37, 1, 'Phive Rivers New Trail', 1, '2017-11-13 09:58:20'),
(38, 1, 'PHIVE RIVERS LEATHER BAGS', 1, '2017-11-14 05:44:16'),
(39, 1, 'TITAN WATCHES', 1, '2017-11-14 06:09:12'),
(40, 1, 'Vyolla Jewellery', 1, '2017-11-14 06:43:26'),
(41, 1, 'Voylla Jewellery', 1, '2017-11-14 06:44:01'),
(42, 1, 'Maybelline', 1, '2017-11-14 06:54:08'),
(43, 1, 'Jeans & clothing', 1, '2017-11-15 05:33:19'),
(44, 1, 'BODYSHOP', 1, '2017-11-15 05:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_code`
--

CREATE TABLE IF NOT EXISTS `t_code` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT,
  `code_type` varchar(20) DEFAULT NULL,
  `code_value` varchar(40) DEFAULT NULL,
  `code_label` varchar(100) DEFAULT NULL,
  `disabled` tinyint(4) DEFAULT '0',
  `updated_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `t_code`
--

INSERT INTO `t_code` (`code_id`, `code_type`, `code_value`, `code_label`, `disabled`, `updated_timestamp`) VALUES
(1, 'salary_group', 'salary_group_1', '10,000 - 50,000', 0, '2017-10-16 08:03:47'),
(2, 'salary_group', 'salary_group_2', '50001 - 100000', 0, '2017-10-16 08:03:53'),
(3, 'salary_group', 'salary_group_3', '100001 - 200000', 0, '2017-10-16 08:04:00'),
(4, 'salary_group', 'salary_group_4', '2  -  4 LACS', 0, '2017-10-16 07:20:38'),
(5, 'salary_group', 'salary_group_5', 'ABOVE 4 LACS', 0, '2017-10-16 07:20:38'),
(6, 'club_type', 'club_type_1', 'GOLF CLUB', 0, '2017-10-16 07:20:38'),
(7, 'club_type', 'club_type_2', 'DLF CLUB', 0, '2017-10-16 07:20:38'),
(8, 'club_type', 'club_type_3', 'CLASSIC RESORT', 0, '2017-10-16 07:20:38'),
(9, 'club_type', 'club_type_4', 'DGC', 0, '2017-10-16 07:20:38'),
(10, 'club_type', 'club_type_5', 'OTHER', 0, '2017-10-16 07:20:38'),
(11, 'defence_group', 'defence_group_1', 'YES', 0, '2017-10-16 07:20:38'),
(12, 'defence_group', 'defence_group_2', 'NO', 0, '2017-10-16 07:20:38'),
(13, 'defence_group', 'defence_group_3', 'RETIRED', 0, '2017-10-16 07:20:38'),
(14, 'defence_group', 'defence_group_4', 'OTHER', 0, '2017-10-16 07:20:38'),
(15, 'work_type', 'business', 'BUSINESS', 0, '2017-10-16 07:20:38'),
(16, 'work_type', 'service', 'SERVICES', 0, '2017-10-16 07:20:38'),
(17, 'work_type', 'doctor', 'DOCTOR', 0, '2017-10-16 07:20:38'),
(18, 'work_type', 'professional', 'PROFESSIONAL', 0, '2017-10-16 07:20:38'),
(19, 'work_type', 'govt_employee', 'GOVT EMPLOYEE', 0, '2017-10-16 07:20:38'),
(20, 'work_type', 'student', 'STUDENT', 0, '2017-10-16 07:20:38'),
(21, 'work_type', 'other', 'OTHER', 0, '2017-10-16 07:20:38'),
(22, 'watch_brand', 'titan', 'TITAN', 0, '2017-10-16 07:20:38'),
(23, 'watch_brand', 'rolex', 'ROLEX', 0, '2017-10-16 07:20:38'),
(24, 'watch_brand', 'seiko', 'SEIKO', 0, '2017-10-16 07:20:38'),
(25, 'watch_brand', 'tissot', 'TISSOT', 0, '2017-10-16 07:20:38'),
(26, 'watch_brand', 'tag_huer', 'TAG HUER', 0, '2017-10-16 07:20:38'),
(27, 'watch_brand', 'other', 'OTHER', 0, '2017-10-16 07:20:38'),
(28, 'car_brand', 'car_audi', 'AUDI', 0, '2017-10-16 07:20:38'),
(29, 'car_brand', 'car_maruti', 'MARUTI', 0, '2017-10-16 07:20:38'),
(30, 'car_brand', 'car_bmw', 'BMW', 0, '2017-10-16 07:20:38'),
(31, 'car_brand', 'car_toyota', 'TOYOTA', 0, '2017-10-16 07:20:38'),
(32, 'car_brand', 'car_skoda', 'SKODA', 0, '2017-10-16 07:20:38'),
(33, 'car_brand', 'car_mahindra', 'MAHINDRA', 0, '2017-10-16 07:20:38'),
(34, 'car_brand', 'car_mercedes', 'MERCEDES', 0, '2017-10-16 07:20:38'),
(35, 'car_brand', 'car_volvo', 'VOLVO', 0, '2017-10-16 07:20:38'),
(36, 'car_brand', 'car_hyundai', 'HYUNDAI', 0, '2017-10-16 07:20:38'),
(37, 'car_brand', 'car_other', 'OTHER', 0, '2017-10-16 07:20:38'),
(38, 'residence_type', 'owned', 'OWNED', 0, '2017-10-16 07:20:38'),
(39, 'residence_type', 'rented', 'RENTED', 0, '2017-10-16 07:20:38'),
(40, 'residence_type', 'other', 'OTHER', 0, '2017-10-16 07:20:38'),
(41, 'transport_type', 'car', 'CAR', 0, '2017-10-16 07:22:17'),
(42, 'transport_type', 'bike', 'BIKE', 0, '2017-10-16 07:22:17'),
(43, 'transport_type', 'public', 'PUBLIC', 0, '2017-10-16 07:22:17'),
(44, 'transport_type', 'other', 'OTHER', 0, '2017-10-16 07:22:17'),
(45, 'miles_card', 'non', 'N/A', 0, '2017-10-16 07:20:38'),
(46, 'miles_card', 'jet', 'JET', 0, '2017-10-16 07:22:17'),
(47, 'miles_card', 'airindia', 'AIR INDIA', 0, '2017-10-16 07:22:17'),
(48, 'miles_card', 'spicejet', 'SPICEJET', 0, '2017-10-16 07:22:17'),
(49, 'miles_card', 'vistara', 'VISTARA', 0, '2017-10-16 07:22:17'),
(50, 'miles_card', 'lufthansa', 'LUFTHANSA', 0, '2017-10-16 07:22:17'),
(51, 'miles_card', 'other', 'Others', 0, '2017-10-16 07:20:38'),
(52, 'credit_card', 'visa', 'Visa', 0, '2017-10-16 08:31:02'),
(53, 'credit_card', 'mastercard', 'Mastercard', 0, '2017-10-16 08:31:07'),
(54, 'credit_card', 'amex', 'Amex', 0, '2017-10-16 08:31:12'),
(55, 'credit_card', 'other', 'Others', 0, '2017-10-16 08:31:17'),
(56, 'salary_group', 'salary_group_5', 'ABOVE 8 LACS', 0, '2017-10-16 07:20:38'),
(57, 'club_type', 'ULTIMATE CLUB', 'ULTIMATE CLUB', 0, '2017-11-13 11:01:27');

-- --------------------------------------------------------

--
-- Table structure for table `t_message`
--

CREATE TABLE IF NOT EXISTS `t_message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_title` varchar(75) DEFAULT NULL,
  `message_content` varchar(150) DEFAULT NULL,
  `min_entry_age` varchar(10) DEFAULT NULL,
  `max_entry_age` varchar(10) DEFAULT NULL,
  `entry_gender` varchar(10) DEFAULT NULL,
  `salary_group` varchar(10) DEFAULT NULL,
  `work_type` varchar(10) DEFAULT NULL,
  `residence_type` varchar(10) DEFAULT NULL,
  `transport_type` varchar(10) DEFAULT NULL,
  `club_type` varchar(10) DEFAULT NULL,
  `defence_service` varchar(10) DEFAULT NULL,
  `watch_brand` varchar(10) DEFAULT NULL,
  `car_brand` varchar(10) DEFAULT NULL,
  `miles_card` varchar(10) DEFAULT NULL,
  `credit_card` varchar(10) DEFAULT NULL,
  `updated_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_message`
--

INSERT INTO `t_message` (`message_id`, `message_title`, `message_content`, `min_entry_age`, `max_entry_age`, `entry_gender`, `salary_group`, `work_type`, `residence_type`, `transport_type`, `club_type`, `defence_service`, `watch_brand`, `car_brand`, `miles_card`, `credit_card`, `updated_timestamp`) VALUES
(1, 'Rs. 1000 off BigBazar', 'Get Rs. 1000 off on all the orders above 1000.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-11-03 05:59:43'),
(2, 'Grant Mall 1500 Cashback', 'Grand Mall inaugral offer, get 1500 PayTm cashback on all order above 10000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-03 07:59:43'),
(3, 'Huge discount on FILA products', 'Get 20% instant discount on FILA products at Grand Central Mall, Gurugram', '', '', 'all', '', '', '', '', '', '', '', '', '', '', '2017-11-13 06:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `t_promotion`
--

CREATE TABLE IF NOT EXISTS `t_promotion` (
  `promotion_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) DEFAULT NULL,
  `target_audience` varchar(150) DEFAULT NULL,
  `status` varchar(15) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`promotion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_quiz`
--

CREATE TABLE IF NOT EXISTS `t_quiz` (
  `quiz_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) DEFAULT NULL,
  `options` varchar(500) DEFAULT NULL,
  `answer` varchar(100) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `reward_amount` int(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`quiz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `t_quiz`
--

INSERT INTO `t_quiz` (`quiz_id`, `question`, `options`, `answer`, `ad_id`, `reward_amount`, `timestamp`) VALUES
(1, 'Question 1', 'Option 11*,*Option 12*,*Option 13*,*Option 14', '1', 1, 0, '2017-11-13 09:04:53'),
(2, 'Question 2', 'Option 21*,*Option 22*,*Option 23*,*Option 24', '3', 1, 0, '2017-11-13 09:04:53'),
(3, 'Question 3', 'Option 31*,*Option 32*,*Option 33*,*Option 34', '4', 1, 0, '2017-11-13 09:04:53'),
(4, 'Question 1', 'Option 11*,*Option 12*,*Option 13*,*Option 14', '1', 2, 0, '2017-11-13 09:13:21'),
(5, 'Question 2', 'Option 21*,*Option 22*,*Option 23*,*Option 24', '2', 2, 0, '2017-11-13 09:13:21'),
(6, 'Question 3', 'Option 31*,*Option 32*,*Option 33*,*Option 34', '3', 2, 0, '2017-11-13 09:13:21'),
(7, 'What is the Brand Name?', 'Phive Rivers*,*Rivers*,*Phive*,*Riv', '1', 3, 0, '2017-11-13 10:31:41'),
(8, 'What is the color?', 'Red*,*Yellow*,*Brown*,*Black', '2', 3, 0, '2017-11-13 10:31:41'),
(9, 'What is the material?', 'Lether*,*Wood*,*Plastic*,*Paper', '4', 3, 0, '2017-11-13 10:31:41'),
(10, 'dell is the top laptop brand', 'worldwide*,*india only*,*pakistan only*,*srilanka only', '1', 4, 0, '2017-11-14 05:28:21'),
(11, 'dell laptops carry longest warranty period', '20 days*,*365 day*,*3 years*,*none', '2', 4, 0, '2017-11-14 05:28:21'),
(12, 'dell offers the highest cash back on its products', '10%*,*5%*,*30%*,*none', '3', 4, 0, '2017-11-14 05:28:21'),
(13, 'the oldest denim brand in the world', 'levis*,*jeans*,*chinos*,*shorts', '1', 5, 0, '2017-11-14 05:59:26'),
(14, 'levis is the favoured brand in', 'america and world over*,*only pakistan*,*only bangladesh*,*no where', '1', 5, 0, '2017-11-14 05:59:26'),
(15, 'we price our denims at affordable prices', '1000- 5000*,*20-25000*,*25-27000*,*very expensive', '1', 5, 0, '2017-11-14 05:59:26'),
(16, 'How many products on display?', '3*,*4*,*1*,*2', '1', 6, 0, '2017-11-14 06:08:19'),
(17, 'Whats the color?', 'Red*,*Blue*,*Yellow*,*Green', '3', 6, 0, '2017-11-14 06:08:19'),
(18, 'Whats the packaging?', 'Box*,*Bottle*,*Wooden*,*Leather', '1', 6, 0, '2017-11-14 06:08:19'),
(19, 'How many products on display?', '3*,*2*,*4*,*1', '1', 7, 0, '2017-11-14 06:15:55'),
(20, 'Whats the color?', 'Red*,*White*,*Blue*,*Black', '2', 7, 0, '2017-11-14 06:15:55'),
(21, 'How many variants?', '3*,*4*,*2*,*1', '1', 7, 0, '2017-11-14 06:15:55'),
(25, 'How many products on display?', '4*,*10*,*2*,*3', '1', 9, 0, '2017-11-14 06:23:22'),
(26, 'Whats the design?', 'Indian*,*Arabic*,*Western*,*Other', '1', 9, 0, '2017-11-14 06:23:22'),
(27, 'Whats the color?', 'Red*,*Green*,*Yellow*,*Blue', '3', 9, 0, '2017-11-14 06:23:22'),
(31, 'What is the shoe type?', 'Sports and Fitness*,*Casual*,*Formal*,*None', '1', 11, 0, '2017-11-14 06:36:45'),
(32, 'What is the warranty period?', '6 months*,*1 year*,*2 months*,*15 days', '1', 11, 0, '2017-11-14 06:36:45'),
(33, 'What is the material of the sole?', 'Rubber*,*Leather*,*Plastic*,*None', '1', 11, 0, '2017-11-14 06:36:45'),
(34, 'What is the material of the bag?', 'leather*,*pu*,*fabric*,*plastic', '1', 10, 0, '2017-11-14 06:40:01'),
(35, 'What is the warranty period?', '6 months*,*1 year*,*2 months*,*15 days', '1', 10, 0, '2017-11-14 06:40:01'),
(36, 'The product is ideal for?', 'Women*,*Men*,*Children*,*All', '1', 10, 0, '2017-11-14 06:40:01'),
(37, 'What is the product material', 'stainless steel*,*steel*,*leather*,*None of the above', '1', 8, 0, '2017-11-14 06:42:40'),
(38, 'What is the warranty period?', '1 year*,*6 months*,*15 days*,*2 months', '1', 8, 0, '2017-11-14 06:42:40'),
(39, 'The product is ideal for?', 'Men*,*Women*,*Children*,*Unisex', '1', 8, 0, '2017-11-14 06:42:40'),
(40, 'What is the jewellery made of?', 'Artificial metals*,*gold*,*silver*,*platinum', '1', 12, 0, '2017-11-14 06:49:47'),
(41, 'The product is ideal for?', 'Women*,*Men*,*Children*,*All', '1', 12, 0, '2017-11-14 06:49:47'),
(42, 'What is the warranty period?', '1 month*,*1 year*,*6 months*,*15 days', '1', 12, 0, '2017-11-14 06:49:47'),
(43, 'What is the lipstick type?', 'matte*,*glossy*,*moisturising*,*none', '1', 13, 0, '2017-11-14 07:07:20'),
(44, 'The product is ideal for?', 'Women*,*Men*,*Both*,*None', '1', 13, 0, '2017-11-14 07:07:20'),
(45, 'What is the nourishing element in the product?', 'Nourishing honey nectar*,*Bee wax*,*Coconut oil*,*Other', '1', 13, 0, '2017-11-14 07:07:20'),
(46, 'q1', '1*,*2*,*3*,*4', '3', 14, 0, '2017-11-14 16:39:15'),
(47, 'q2', '5*,*4*,*1*,*6', '1', 14, 0, '2017-11-14 16:39:15'),
(48, 'q3', 't*,*u*,*e*,*f', '3', 14, 0, '2017-11-14 16:39:15'),
(49, 'What is the origin of the perfume?', 'French*,*American*,*Indian*,*Chinese', '1', 15, 0, '2017-11-15 05:14:15'),
(50, 'What is the smell like?', 'Woody*,*Fruity*,*Musk*,*None of the above', '1', 15, 0, '2017-11-15 05:14:15'),
(51, 'What is the price range?', 'INR 1800-2000*,*INR14500*,*INR10000*,*INR7000', '1', 15, 0, '2017-11-15 05:14:15'),
(52, 'What is the look of the jeans?', 'Distressed indigo*,*Solid*,*Ombre*,*None of the above', '1', 16, 0, '2017-11-15 05:44:13'),
(53, 'What is the fit like?', 'Slim Fit*,*Straight fit*,*Boot fit*,*Regular Fit', '1', 16, 0, '2017-11-15 05:44:13'),
(54, 'What is the price range?', 'INR 1800-2500*,*INR 4000 and above*,*INR 5000 and above*,*INR 7000 and above', '1', 16, 0, '2017-11-15 05:44:13'),
(55, 'What are the products made of?', 'Organic ingredients*,*Synthetic ingredients*,*Mix of 1 and 2*,*None of the above', '1', 17, 0, '2017-11-15 06:06:13'),
(56, 'What is the price range of the products?', 'INR 500-2500*,*INR 2500 and above*,*INR 5000 and above*,*INR 7000 and above', '1', 17, 0, '2017-11-15 06:06:13'),
(57, 'What is the smell like?', 'Fruity*,*Musk*,*Woody*,*None of the above', '1', 17, 0, '2017-11-15 06:06:13'),
(58, 'What was the size of laptop on sale?', '15.6"*,*17"*,*14"*,*19"', '2', 18, 0, '2017-12-06 13:42:54'),
(59, 'Which version was on sale?', 'Inspiron*,*R version*,*Experio*,*Ultimate', '1', 18, 0, '2017-12-06 13:42:54'),
(60, 'Maximum discount is how much?', '2000*,*4000*,*5000*,*2500', '3', 18, 0, '2017-12-06 13:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `t_states`
--

CREATE TABLE IF NOT EXISTS `t_states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(30) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `t_states`
--

INSERT INTO `t_states` (`state_id`, `state_name`, `country_id`) VALUES
(1, 'Andaman & Nicobar Islands', 1),
(2, 'Andhra Pradesh', 1),
(3, 'Arunachal Pradesh', 1),
(4, 'Assam', 1),
(5, 'Bihar', 1),
(6, 'Chandigarh', 1),
(7, 'Chattisgarh', 1),
(8, 'Dadra & Nagar Haveli', 1),
(9, 'Daman & Diu', 1),
(10, 'Delhi', 1),
(11, 'Goa', 1),
(12, 'Gujarat', 1),
(13, 'Haryana', 1),
(14, 'Himachal Pradesh', 1),
(15, 'Jammu & Kashmir', 1),
(16, 'Jharkhand', 1),
(17, 'Karnataka', 1),
(18, 'Kerala', 1),
(19, 'Lakshadweep', 1),
(20, 'Madhya Pradesh', 1),
(21, 'Maharashtra', 1),
(22, 'Manipur', 1),
(23, 'Meghalaya', 1),
(24, 'Mizoram', 1),
(25, 'Nagaland', 1),
(26, 'Odisha', 1),
(27, 'Poducherry', 1),
(28, 'Punjab', 1),
(29, 'Rajasthan', 1),
(30, 'Sikkim', 1),
(31, 'Tamil Nadu', 1),
(32, 'Telangana', 1),
(33, 'Tripura', 1),
(34, 'Uttar Pradesh', 1),
(35, 'Uttarakhand', 1),
(36, 'West Bengal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_store`
--

CREATE TABLE IF NOT EXISTS `t_store` (
  `store_id` int(6) NOT NULL AUTO_INCREMENT,
  `version_id` int(3) DEFAULT '1',
  `store_name` varchar(150) DEFAULT NULL,
  `location_lat` varchar(10) DEFAULT NULL,
  `location_long` varchar(10) DEFAULT NULL,
  `store_website` varchar(30) NOT NULL DEFAULT '',
  `store_contact` varchar(15) NOT NULL DEFAULT '',
  `store_address` varchar(250) DEFAULT NULL,
  `store_city` varchar(30) NOT NULL DEFAULT '',
  `store_state` varchar(100) DEFAULT NULL,
  `store_pincode` varchar(6) NOT NULL DEFAULT '',
  `store_landmark` varchar(100) DEFAULT NULL,
  `store_image` varchar(100) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `wallet_guid` varchar(100) DEFAULT NULL,
  `wallet_amount` varchar(7) DEFAULT NULL,
  `subscribed` varchar(20) NOT NULL DEFAULT 'no',
  `company_cin` varchar(50) DEFAULT NULL,
  `incorporation_date` varchar(20) DEFAULT NULL,
  `company_gst` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `t_store`
--

INSERT INTO `t_store` (`store_id`, `version_id`, `store_name`, `location_lat`, `location_long`, `store_website`, `store_contact`, `store_address`, `store_city`, `store_state`, `store_pincode`, `store_landmark`, `store_image`, `owner_id`, `wallet_guid`, `wallet_amount`, `subscribed`, `company_cin`, `incorporation_date`, `company_gst`, `timestamp`) VALUES
(1, 1, 'Dell Store', '28.632317', '77.222438', 'http://www.dell.com/in/', '9818121699', 'Cannought place', 'New Delhi', NULL, '110001', NULL, 'http://www.omgubuntu.co.uk/wp-content/uploads/2012/06/dell-store-front-in-dheli.jpg', 10, 'd00b23ef-aabb-4d9a-ba62-6c56806d77ac', '100', 'no', NULL, NULL, NULL, '2017-06-29 10:22:28'),
(2, 1, 'Levis Showroom', '28.501383', '77.168972', 'http://levi.in/', '8285347634', 'Sultanpuri', 'New Delhi', NULL, '110030', NULL, 'http://images.taubman.com/www.shoptwelveoaks.com/asset/get/3607', 2, 'd00b23ef-aabb-4d9a-ba62-6c56806d77ac', NULL, 'no', NULL, NULL, NULL, '2017-07-11 11:19:05'),
(3, 1, 'Beats', NULL, NULL, 'beats.com', '98765432145', 'Cannought Place', 'Delhi', 'New Delhi', '110001', NULL, NULL, 28, 'asdfasdf', '3000', 'yes', '987hi7jn99', '2005-02-09', 'oijksa9d7asdf', '2017-12-06 13:27:01');

-- --------------------------------------------------------

--
-- Table structure for table `t_transaction`
--

CREATE TABLE IF NOT EXISTS `t_transaction` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `transaction_type` varchar(100) DEFAULT NULL,
  `transaction_status` varchar(30) DEFAULT 'FAILURE',
  `failure_reason` varchar(100) DEFAULT '',
  `reward_amount` int(4) NOT NULL DEFAULT '0',
  `order_id` varchar(20) DEFAULT '',
  `paytm_transaction_id` varchar(50) DEFAULT '',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `t_transaction`
--

INSERT INTO `t_transaction` (`transaction_id`, `user_id`, `ad_id`, `store_id`, `transaction_type`, `transaction_status`, `failure_reason`, `reward_amount`, `order_id`, `paytm_transaction_id`, `timestamp`) VALUES
(1, 6, 1, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171113-6-1-1-ZdW', '16541659690', '2017-11-13 09:27:54'),
(2, 11, 1, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171113-11-1-1-aHQ', '16541720258', '2017-11-13 09:30:14'),
(3, 21, 3, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171113-21-1-3-wDL', '16543583306', '2017-11-13 10:39:08'),
(4, 4, 3, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171113-4-1-3-ckS', '16549104014', '2017-11-13 13:19:13'),
(5, 21, 5, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171114-21-1-5-bwb', '16567028610', '2017-11-14 06:50:08'),
(6, 21, 7, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171114-21-1-7-FMo', '16575395598', '2017-11-14 11:43:11'),
(7, 21, 6, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171114-21-1-6-aSX', '16576045354', '2017-11-14 12:03:57'),
(8, 21, 17, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171115-21-1-17-mWk', '16597305158', '2017-11-15 07:11:45'),
(9, 16, 3, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171115-16-1-3-NYR', '16600807946', '2017-11-15 09:09:39'),
(10, 21, 15, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171116-21-1-15-btA', '16631043370', '2017-11-16 09:07:37'),
(11, 21, 1, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171207-21-1-1-vsW', '16959990928', '2017-12-07 07:34:27'),
(12, 16, 18, 1, 'paytm', 'SUCCESS', 'SUCCESS', 10, '171207-16-1-18-GQq', '16960114729', '2017-12-07 07:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE IF NOT EXISTS `t_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id` int(3) DEFAULT '1',
  `user_name` varchar(150) DEFAULT NULL,
  `user_email` varchar(150) DEFAULT NULL,
  `user_contact` varchar(15) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `login_using` varchar(20) DEFAULT NULL,
  `user_type` enum('customer','admin','store') NOT NULL DEFAULT 'customer',
  `user_gender` enum('female','male','transgender') NOT NULL DEFAULT 'male',
  `user_address` varchar(250) NOT NULL DEFAULT '',
  `user_location` varchar(100) DEFAULT NULL,
  `user_city` varchar(100) DEFAULT NULL,
  `user_state` varchar(100) DEFAULT NULL,
  `user_pincode` int(6) NOT NULL DEFAULT '0',
  `user_photo` varchar(100) NOT NULL DEFAULT '',
  `user_dob` date DEFAULT NULL,
  `user_salary` varchar(20) NOT NULL DEFAULT '',
  `club_membership` int(3) DEFAULT NULL,
  `defence_service` int(3) DEFAULT NULL,
  `work_type` int(3) DEFAULT NULL,
  `user_profession` varchar(100) NOT NULL DEFAULT '',
  `watch_brand` int(3) DEFAULT NULL,
  `car_brand` int(3) DEFAULT NULL,
  `residence_type` int(3) DEFAULT NULL,
  `locality` varchar(30) DEFAULT NULL,
  `transport_type` int(3) DEFAULT NULL,
  `miles_card` int(3) DEFAULT NULL,
  `credit_card` int(3) DEFAULT NULL,
  `wallet_amount` int(5) NOT NULL DEFAULT '0',
  `fb_link` varchar(200) NOT NULL DEFAULT '',
  `twitter_link` varchar(200) NOT NULL DEFAULT '',
  `gplus_link` varchar(200) NOT NULL DEFAULT '',
  `last_seen_message` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`user_id`, `version_id`, `user_name`, `user_email`, `user_contact`, `user_password`, `login_using`, `user_type`, `user_gender`, `user_address`, `user_location`, `user_city`, `user_state`, `user_pincode`, `user_photo`, `user_dob`, `user_salary`, `club_membership`, `defence_service`, `work_type`, `user_profession`, `watch_brand`, `car_brand`, `residence_type`, `locality`, `transport_type`, `miles_card`, `credit_card`, `wallet_amount`, `fb_link`, `twitter_link`, `gplus_link`, `last_seen_message`, `timestamp`) VALUES
(1, 138, 'Admin', 'admin@gmail.com', '9818121699', '0192023a7bbd73250516f069df18b500', NULL, 'admin', 'male', '', '', '', '', 0, '', '0000-00-00', '0', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', 2, '2017-11-13 09:30:08'),
(4, 133, 'Rahul', 'hugh@gmail.com', '+918510076969', 'e807f1fcf82d132f9bb018ca6738a19f', '', 'customer', '', 'NM', '', 'delhi', 'Delhi', 110030, '', '0000-00-00', '1', 7, 12, 19, 'GOVT EMPLOYEE', 26, 34, 39, '', 42, 47, 52, 10, '', '', '', 2, '2017-11-13 13:19:13'),
(5, 115, '', 'anvayarai@gmail.com', '+917011673561', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(6, 113, 'Pradeep Kumar', 'pkumars.1792@gmail.com', '+919818121699', '0878fc6e87386e0965484432eafab0cc', '', 'customer', '', 'Sarita Vihar', '', 'New Delhi', 'delhi', 110076, '', '0000-00-00', '3', 7, 11, 16, 'SERVICES', 23, 31, 38, '', 43, 48, 52, 0, '', '', '', 3, '2017-11-13 11:38:08'),
(7, 103, '', 'nupurkohli68@gmail.com', '+919810800888', 'd58949b3d4caf3bb1d8d33f5ae8d3529', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(8, 92, '', 'sayoroy12@gmail.com', '+919560155609', '54127313948a05302b9901ed56102a76', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(9, 89, '', 'parmeet@gmail.com', '+919671718285', '25d55ad283aa400af464c76d713c07ad', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(10, 89, 'Mohit', 'mohit@mobi.com', NULL, 'cf3b27ef58e8421ad18556857077d39f', NULL, 'store', 'male', '', NULL, NULL, NULL, 0, '', NULL, '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(11, 89, '', 'anvayarai@gmail.com', '+919711350701', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '', '', '', 3, '2017-11-13 09:30:14'),
(12, 88, '', 'wamiquetahir43@gmail.com', '+919717790646', '67cb07554257293251415f2afbf745e0', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(13, 80, '', 'shekhar.swetank@gmail.com', '+919953113888', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(14, 80, 'dalip gill', 'dalipsingh78@yahoo.in', '+919560045368', 'ae0d4045891365940089570d28e316fd', '', 'customer', '', '', '', 'gurgaon', '', 0, '', '0000-00-00', 'Salary', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(15, 80, '', 'pragyapradeepti86@gmail.com', '+919582676228', '5f4dcc3b5aa765d61d8327deb882cf99', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(16, 77, 'yasir khan', 'khan.rules19921@gmail.com', '+918285342637', '', '', 'customer', '', 'shaheen bagh', '', 'new delhi', 'delhi', 110076, '', '1986-06-08', '2', 6, 11, 15, 'C.Oa', 23, 28, 39, 'i', 43, 47, 53, 20, '', '', '', 3, '2017-12-07 07:42:48'),
(18, 23, '', 'yasirkhan8691@gmail.com', '+919602715895', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(19, 23, '', 'open_ellsxrd_user@tfbnw.net', '+917428352626', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(20, 21, '', 'mohit@globalsell.in', '+919971589900', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(21, 26, '', 'mohit@elementsexports.com', '+919958203010', '', '', 'customer', 'male', '', '', '', '', 0, '', '2017-11-13', '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 70, '', '', '', 1, '2017-12-07 07:34:27'),
(22, 10, '', 'open_ellsxrd_user@tfbnw.net', '+919871138870', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(23, 10, '', 'flyflyerson9000@gmail.com', '+14088021945', '', '', 'customer', 'male', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(24, 5, '', '', '', '', NULL, 'store', 'male', '', NULL, NULL, NULL, 0, '', NULL, '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(25, 3, 'Manivannan CN', 'buvanapriyan@gmail.com', '+919080976852', '', '', 'customer', '', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(26, 3, 'Sandeep Sethi', 'sethissethi@gmail.com', '+919004245670', '', '', 'customer', '', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-13 09:30:08'),
(27, 1, 'Vishal Virani', 'vishal4virani@yahoo.co.in', '+919820074126', '', '', 'customer', '', '', '', '', '', 0, '', '0000-00-00', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-11-14 05:34:52'),
(28, 1, 'Beats', 'beats@gmail.com', '9876543215', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'store', 'male', '', NULL, NULL, NULL, 0, '', NULL, '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '', '', '', NULL, '2017-12-06 13:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_activity`
--

CREATE TABLE IF NOT EXISTS `t_user_activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `activity_type` varchar(100) DEFAULT NULL,
  `answer_id` int(1) DEFAULT NULL,
  `reward_amount` int(4) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `t_user_activity`
--

INSERT INTO `t_user_activity` (`activity_id`, `user_id`, `ad_id`, `quiz_id`, `activity_type`, `answer_id`, `reward_amount`, `timestamp`) VALUES
(7, 11, 1, 1, 'Quiz Answered', 1, 0, '2017-11-13 09:30:13'),
(8, 11, 1, 3, 'Quiz Answered', 4, 0, '2017-11-13 09:30:13'),
(9, 21, 3, 7, 'Quiz Answered', 1, 0, '2017-11-13 10:39:07'),
(10, 21, 3, 8, 'Quiz Answered', 2, 0, '2017-11-13 10:39:07'),
(11, 4, 3, 7, 'Quiz Answered', 1, 0, '2017-11-13 13:19:13'),
(12, 21, 5, 13, 'Quiz Answered', 1, 0, '2017-11-14 06:50:08'),
(13, 21, 5, 15, 'Quiz Answered', 1, 0, '2017-11-14 06:50:08'),
(14, 21, 7, 19, 'Quiz Answered', 1, 0, '2017-11-14 11:43:11'),
(15, 21, 7, 20, 'Quiz Answered', 2, 0, '2017-11-14 11:43:11'),
(16, 21, 6, 16, 'Quiz Answered', 1, 0, '2017-11-14 12:03:57'),
(17, 21, 17, 55, 'Quiz Answered', 1, 0, '2017-11-15 07:11:44'),
(18, 21, 17, 57, 'Quiz Answered', 1, 0, '2017-11-15 07:11:44'),
(19, 16, 3, 7, 'Quiz Answered', 1, 0, '2017-11-15 09:09:39'),
(20, 21, 15, 49, 'Quiz Answered', 1, 0, '2017-11-16 09:07:36'),
(21, 21, 15, 51, 'Quiz Answered', 1, 0, '2017-11-16 09:07:36'),
(22, 21, 1, 1, 'Quiz Answered', 1, 0, '2017-12-07 07:34:26'),
(23, 16, 18, 59, 'Quiz Answered', 1, 0, '2017-12-07 07:42:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
