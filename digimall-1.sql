-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2011 at 04:46 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `digimall`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

DROP TABLE IF EXISTS `account_type`;
CREATE TABLE IF NOT EXISTS `account_type` (
  `account_type_id` int(11) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  PRIMARY KEY (`account_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` VALUES(1, 'admin');
INSERT INTO `account_type` VALUES(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
CREATE TABLE IF NOT EXISTS `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `dist_id` int(11) NOT NULL,
  PRIMARY KEY (`brand_id`),
  KEY `dist_id` (`dist_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` VALUES(1, 'noob', 2);
INSERT INTO `brand` VALUES(2, 'test', 4);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` VALUES(6, 'processor');
INSERT INTO `category` VALUES(3, 'motherboard');
INSERT INTO `category` VALUES(8, 'model');
INSERT INTO `category` VALUES(1, 'graphics');
INSERT INTO `category` VALUES(2, 'harddisk');
INSERT INTO `category` VALUES(5, 'optical_rom');
INSERT INTO `category` VALUES(4, 'monitor');
INSERT INTO `category` VALUES(7, 'ram');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

DROP TABLE IF EXISTS `distributor`;
CREATE TABLE IF NOT EXISTS `distributor` (
  `dist_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_name` varchar(255) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`dist_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` VALUES(2, 'shitto', 1321231, '');
INSERT INTO `distributor` VALUES(4, 'dist', 123456, '');
INSERT INTO `distributor` VALUES(5, 'test', 1234, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `graphics`
--

DROP TABLE IF EXISTS `graphics`;
CREATE TABLE IF NOT EXISTS `graphics` (
  `graphics_id` int(11) NOT NULL AUTO_INCREMENT,
  `graphics_model` varchar(255) NOT NULL,
  `graphics_capacity` int(11) NOT NULL,
  `graphics_ram_type` varchar(255) DEFAULT NULL,
  `graphics_bit` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '1',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`graphics_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `graphics`
--

INSERT INTO `graphics` VALUES(1, 'GTX200', 1024, 'DDR4', 256, 1, 1, 98, 108.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `harddisk`
--

DROP TABLE IF EXISTS `harddisk`;
CREATE TABLE IF NOT EXISTS `harddisk` (
  `hdd_id` int(11) NOT NULL AUTO_INCREMENT,
  `hdd_type` varchar(255) NOT NULL,
  `hdd_model` varchar(255) NOT NULL,
  `hdd_capacity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '2',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`hdd_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `harddisk`
--

INSERT INTO `harddisk` VALUES(1, 'SATA', 'Raptor', 500, 2, 1, 65, NULL, NULL, 65.00);
INSERT INTO `harddisk` VALUES(2, 'SATA', 'Velocity', 320, 2, 1, 48, NULL, NULL, 86.00);

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `model_id` int(20) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(20) NOT NULL,
  `graphics_1` int(11) NOT NULL,
  `harddisk_1` int(11) NOT NULL,
  `harddisk_2` int(11) NOT NULL,
  `monitor_1` int(11) NOT NULL,
  `motherboard_1` int(11) NOT NULL,
  `optical_rom_1` int(11) NOT NULL,
  `processor_1` int(11) NOT NULL,
  `processor_2` int(11) NOT NULL,
  `ram_1` int(11) NOT NULL,
  `ram_2` int(11) NOT NULL,
  PRIMARY KEY (`model_id`),
  KEY `model_id` (`model_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `model`
--

INSERT INTO `model` VALUES(1, 'allspark', 1, 1, 2, 1, 1, 1, 3, 2, 1, 2);
INSERT INTO `model` VALUES(2, 'tardis', 1, 1, 2, 1, 1, 1, 1, 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `monitor`
--

DROP TABLE IF EXISTS `monitor`;
CREATE TABLE IF NOT EXISTS `monitor` (
  `disp_id` int(11) NOT NULL AUTO_INCREMENT,
  `disp_size` int(11) NOT NULL,
  `disp_type` varchar(255) DEFAULT NULL,
  `disp_refresh` int(11) DEFAULT NULL,
  `disp_contrast` varchar(255) DEFAULT NULL,
  `disp_resolution` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT '4',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`disp_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `monitor`
--

INSERT INTO `monitor` VALUES(1, 24, 'LED', 60, '5000000:1', '1920x1080', 4, 1, 98, NULL, NULL, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `motherboard`
--

DROP TABLE IF EXISTS `motherboard`;
CREATE TABLE IF NOT EXISTS `motherboard` (
  `mb_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_model` varchar(255) NOT NULL,
  `mb_socket` int(11) NOT NULL,
  `mb_chipset` varchar(255) NOT NULL,
  `mb_graphics` varchar(255) DEFAULT NULL,
  `mb_ram_slot` int(11) DEFAULT NULL,
  `mb_pcie_slot` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT '3',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mb_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `motherboard`
--

INSERT INTO `motherboard` VALUES(1, 'ATX-885', 775, 'ATI', 'x300', 2, 1, 3, 1, 113, 95.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `optical_rom`
--

DROP TABLE IF EXISTS `optical_rom`;
CREATE TABLE IF NOT EXISTS `optical_rom` (
  `rom_id` int(11) NOT NULL AUTO_INCREMENT,
  `rom_type` varchar(255) NOT NULL,
  `rom_model` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '5',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rom_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `optical_rom`
--

INSERT INTO `optical_rom` VALUES(1, 'SATA', 'DVD-1055', 5, 1, 112, 35.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `graphics` int(11) NOT NULL,
  `harddisk` int(11) NOT NULL,
  `monitor` int(11) NOT NULL,
  `motherboard` int(11) NOT NULL,
  `processor` int(11) NOT NULL,
  `ram` int(11) NOT NULL,
  `optical_rom` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `order`
--

INSERT INTO `order` VALUES(24, 1, 1, 2, 0, 3, 6, 8, 4, 0, '2011-10-10 23:02:13');
INSERT INTO `order` VALUES(23, 1, 1, 2, 0, 3, 6, 8, 4, 0, '2011-10-10 22:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `processor`
--

DROP TABLE IF EXISTS `processor`;
CREATE TABLE IF NOT EXISTS `processor` (
  `proc_id` int(11) NOT NULL AUTO_INCREMENT,
  `proc_name` varchar(255) NOT NULL,
  `proc_model` varchar(255) NOT NULL,
  `proc_speed` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '6',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`proc_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `processor`
--

INSERT INTO `processor` VALUES(1, 'Dual Core', 'E368', 2.66, 6, 1, 78, 80.00, NULL, NULL);
INSERT INTO `processor` VALUES(2, 'Quad Core', 'E868', 2.66, 6, 1, 93, 105.00, NULL, NULL);
INSERT INTO `processor` VALUES(3, 'Quad Core', 'E999', 3.00, 6, 1, 35, 210.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ram`
--

DROP TABLE IF EXISTS `ram`;
CREATE TABLE IF NOT EXISTS `ram` (
  `ram_id` int(11) NOT NULL AUTO_INCREMENT,
  `ram_type` varchar(255) NOT NULL,
  `ram_capacity` int(11) NOT NULL,
  `ram_speed` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '7',
  `brand_id` int(11) NOT NULL DEFAULT '0',
  `stock` int(11) NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `warranty` int(11) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ram_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ram`
--

INSERT INTO `ram` VALUES(1, 'DDR3', 2, 1333, 7, 1, 85, 98.00, NULL, NULL);
INSERT INTO `ram` VALUES(2, 'DDR3', 4, 1600, 7, 1, 90, 138.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `account_type_id` (`account_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 1, 'digimall', 'digimall', 'digimall@digimall.com', 'digimall');
INSERT INTO `user` VALUES(2, 2, 'jason', 'jason', 'jason@jason.com', 'Jason');
INSERT INTO `user` VALUES(7, 2, 'test', 'test', 'test@test.com', 'Ben');
