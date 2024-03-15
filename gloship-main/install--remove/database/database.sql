-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 21, 2023 at 03:24 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecourier_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) NOT NULL,
  `address_type` tinyint(5) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `owner_id` bigint(20) DEFAULT NULL,
  `address` varchar(400) DEFAULT NULL,
  `area` varchar(200) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `country` varchar(40) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `postal` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `city_id` int(20) NOT NULL,
  `state_id` int(20) NOT NULL,
  `country_id` varchar(20) NOT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `map_code` text,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `owner_id` bigint(20) DEFAULT NULL,
  `status` int(5) NOT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `description` text,
  `img` varchar(200) DEFAULT NULL,
  `parent` bigint(20) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `img`, `parent`, `status`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"Uncategorized\",\"fr\":\"Uncategorized\",\"es\":\"Uncategorized\"}', 'uncategorized', NULL, NULL, 0, 1, '2023-03-19 01:13:22', '2023-03-19 01:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--
CREATE TABLE `cities` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `country_id` bigint(20) unsigned NOT NULL,
 `state_id` bigint(20) unsigned NOT NULL,
 `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `country_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
 `status` tinyint(5) NOT NULL,
 `created_at` timestamp NOT NULL,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `iso2` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `phone_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso3` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subregion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `iso2`, `name`, `status`, `phone_code`, `iso3`, `region`, `subregion`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', 1, '93', 'AFG', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-12 12:23:19'),
(2, 'AX', 'Aland Islands', 1, '358', 'ALA', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(3, 'AL', 'Albania', 1, '355', 'ALB', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(4, 'DZ', 'Algeria', 1, '213', 'DZA', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(5, 'AS', 'American Samoa', 1, '1', 'ASM', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(6, 'AD', 'Andorra', 1, '376', 'AND', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(7, 'AO', 'Angola', 1, '244', 'AGO', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(8, 'AI', 'Anguilla', 1, '1', 'AIA', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(9, 'AQ', 'Antarctica', 1, '672', 'ATA', 'Polar', '', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(10, 'AG', 'Antigua And Barbuda', 1, '1', 'ATG', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(11, 'AR', 'Argentina', 1, '54', 'ARG', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(12, 'AM', 'Armenia', 1, '374', 'ARM', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(13, 'AW', 'Aruba', 1, '297', 'ABW', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(14, 'AU', 'Australia', 1, '61', 'AUS', 'Oceania', 'Australia and New Zealand', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(15, 'AT', 'Austria', 1, '43', 'AUT', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(16, 'AZ', 'Azerbaijan', 1, '994', 'AZE', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(17, 'BH', 'Bahrain', 1, '973', 'BHR', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(18, 'BD', 'Bangladesh', 1, '880', 'BGD', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(19, 'BB', 'Barbados', 1, '1', 'BRB', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(20, 'BY', 'Belarus', 1, '375', 'BLR', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(21, 'BE', 'Belgium', 1, '32', 'BEL', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(22, 'BZ', 'Belize', 1, '501', 'BLZ', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(23, 'BJ', 'Benin', 1, '229', 'BEN', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(24, 'BM', 'Bermuda', 1, '1', 'BMU', 'Americas', 'Northern America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(25, 'BT', 'Bhutan', 1, '975', 'BTN', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(26, 'BO', 'Bolivia', 1, '591', 'BOL', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(27, 'BQ', 'Bonaire, Sint Eustatius and Saba', 1, '599', 'BES', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(28, 'BA', 'Bosnia and Herzegovina', 1, '387', 'BIH', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(29, 'BW', 'Botswana', 1, '267', 'BWA', 'Africa', 'Southern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(30, 'BV', 'Bouvet Island', 1, '0055', 'BVT', '', '', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(31, 'BR', 'Brazil', 1, '55', 'BRA', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(32, 'IO', 'British Indian Ocean Territory', 1, '246', 'IOT', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(33, 'BN', 'Brunei', 1, '673', 'BRN', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(34, 'BG', 'Bulgaria', 1, '359', 'BGR', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(35, 'BF', 'Burkina Faso', 1, '226', 'BFA', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(36, 'BI', 'Burundi', 1, '257', 'BDI', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(37, 'KH', 'Cambodia', 1, '855', 'KHM', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(38, 'CM', 'Cameroon', 1, '237', 'CMR', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(39, 'CA', 'Canada', 1, '1', 'CAN', 'Americas', 'Northern America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(40, 'CV', 'Cape Verde', 1, '238', 'CPV', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(41, 'KY', 'Cayman Islands', 1, '1', 'CYM', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(42, 'CF', 'Central African Republic', 1, '236', 'CAF', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(43, 'TD', 'Chad', 1, '235', 'TCD', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(44, 'CL', 'Chile', 1, '56', 'CHL', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(45, 'CN', 'China', 1, '86', 'CHN', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(46, 'CX', 'Christmas Island', 1, '61', 'CXR', 'Oceania', 'Australia and New Zealand', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(47, 'CC', 'Cocos (Keeling) Islands', 1, '61', 'CCK', 'Oceania', 'Australia and New Zealand', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(48, 'CO', 'Colombia', 1, '57', 'COL', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(49, 'KM', 'Comoros', 1, '269', 'COM', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(50, 'CG', 'Congo', 1, '242', 'COG', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(51, 'CK', 'Cook Islands', 1, '682', 'COK', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(52, 'CR', 'Costa Rica', 1, '506', 'CRI', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', 1, '225', 'CIV', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(54, 'HR', 'Croatia', 1, '385', 'HRV', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(55, 'CU', 'Cuba', 1, '53', 'CUB', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(56, 'CW', 'Curaçao', 1, '599', 'CUW', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(57, 'CY', 'Cyprus', 1, '357', 'CYP', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(58, 'CZ', 'Czech Republic', 1, '420', 'CZE', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(59, 'CD', 'Democratic Republic of the Congo', 1, '243', 'COD', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(60, 'DK', 'Denmark', 1, '45', 'DNK', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(61, 'DJ', 'Djibouti', 1, '253', 'DJI', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(62, 'DM', 'Dominica', 1, '1', 'DMA', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(63, 'DO', 'Dominican Republic', 1, '1', 'DOM', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(64, 'TL', 'East Timor', 1, '670', 'TLS', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(65, 'EC', 'Ecuador', 1, '593', 'ECU', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(66, 'EG', 'Egypt', 1, '20', 'EGY', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(67, 'SV', 'El Salvador', 1, '503', 'SLV', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(68, 'GQ', 'Equatorial Guinea', 1, '240', 'GNQ', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(69, 'ER', 'Eritrea', 1, '291', 'ERI', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(70, 'EE', 'Estonia', 1, '372', 'EST', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(71, 'ET', 'Ethiopia', 1, '251', 'ETH', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(72, 'FK', 'Falkland Islands', 1, '500', 'FLK', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(73, 'FO', 'Faroe Islands', 1, '298', 'FRO', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(74, 'FJ', 'Fiji Islands', 1, '679', 'FJI', 'Oceania', 'Melanesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(75, 'FI', 'Finland', 1, '358', 'FIN', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(76, 'FR', 'France', 1, '33', 'FRA', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(77, 'GF', 'French Guiana', 1, '594', 'GUF', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(78, 'PF', 'French Polynesia', 1, '689', 'PYF', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(79, 'TF', 'French Southern Territories', 1, '262', 'ATF', 'Africa', 'Southern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(80, 'GA', 'Gabon', 1, '241', 'GAB', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(81, 'GM', 'Gambia The', 1, '220', 'GMB', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(82, 'GE', 'Georgia', 1, '995', 'GEO', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(83, 'DE', 'Germany', 1, '49', 'DEU', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(84, 'GH', 'Ghana', 1, '233', 'GHA', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(85, 'GI', 'Gibraltar', 1, '350', 'GIB', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(86, 'GR', 'Greece', 1, '30', 'GRC', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(87, 'GL', 'Greenland', 1, '299', 'GRL', 'Americas', 'Northern America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(88, 'GD', 'Grenada', 1, '1', 'GRD', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(89, 'GP', 'Guadeloupe', 1, '590', 'GLP', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(90, 'GU', 'Guam', 1, '1', 'GUM', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(91, 'GT', 'Guatemala', 1, '502', 'GTM', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(92, 'GG', 'Guernsey and Alderney', 1, '44', 'GGY', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(93, 'GN', 'Guinea', 1, '224', 'GIN', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(94, 'GW', 'Guinea-Bissau', 1, '245', 'GNB', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(95, 'GY', 'Guyana', 1, '592', 'GUY', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(96, 'HT', 'Haiti', 1, '509', 'HTI', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(97, 'HM', 'Heard Island and McDonald Islands', 1, '672', 'HMD', '', '', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(98, 'HN', 'Honduras', 1, '504', 'HND', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(99, 'HK', 'Hong Kong S.A.R.', 1, '852', 'HKG', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(100, 'HU', 'Hungary', 1, '36', 'HUN', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(101, 'IS', 'Iceland', 1, '354', 'ISL', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(102, 'IN', 'India', 1, '91', 'IND', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(103, 'ID', 'Indonesia', 1, '62', 'IDN', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(104, 'IR', 'Iran', 1, '98', 'IRN', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(105, 'IQ', 'Iraq', 1, '964', 'IRQ', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(106, 'IE', 'Ireland', 1, '353', 'IRL', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(107, 'IL', 'Israel', 1, '972', 'ISR', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(108, 'IT', 'Italy', 1, '39', 'ITA', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(109, 'JM', 'Jamaica', 1, '1', 'JAM', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(110, 'JP', 'Japan', 1, '81', 'JPN', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(111, 'JE', 'Jersey', 1, '44', 'JEY', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(112, 'JO', 'Jordan', 1, '962', 'JOR', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(113, 'KZ', 'Kazakhstan', 1, '7', 'KAZ', 'Asia', 'Central Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(114, 'KE', 'Kenya', 1, '254', 'KEN', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(115, 'KI', 'Kiribati', 1, '686', 'KIR', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(116, 'XK', 'Kosovo', 1, '383', 'XKX', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(117, 'KW', 'Kuwait', 1, '965', 'KWT', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(118, 'KG', 'Kyrgyzstan', 1, '996', 'KGZ', 'Asia', 'Central Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(119, 'LA', 'Laos', 1, '856', 'LAO', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(120, 'LV', 'Latvia', 1, '371', 'LVA', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(121, 'LB', 'Lebanon', 1, '961', 'LBN', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(122, 'LS', 'Lesotho', 1, '266', 'LSO', 'Africa', 'Southern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(123, 'LR', 'Liberia', 1, '231', 'LBR', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(124, 'LY', 'Libya', 1, '218', 'LBY', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(125, 'LI', 'Liechtenstein', 1, '423', 'LIE', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(126, 'LT', 'Lithuania', 1, '370', 'LTU', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(127, 'LU', 'Luxembourg', 1, '352', 'LUX', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(128, 'MO', 'Macau S.A.R.', 1, '853', 'MAC', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(129, 'MK', 'Macedonia', 1, '389', 'MKD', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(130, 'MG', 'Madagascar', 1, '261', 'MDG', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(131, 'MW', 'Malawi', 1, '265', 'MWI', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(132, 'MY', 'Malaysia', 1, '60', 'MYS', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(133, 'MV', 'Maldives', 1, '960', 'MDV', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(134, 'ML', 'Mali', 1, '223', 'MLI', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(135, 'MT', 'Malta', 1, '356', 'MLT', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(136, 'IM', 'Man (Isle of)', 1, '44', 'IMN', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(137, 'MH', 'Marshall Islands', 1, '692', 'MHL', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(138, 'MQ', 'Martinique', 1, '596', 'MTQ', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(139, 'MR', 'Mauritania', 1, '222', 'MRT', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(140, 'MU', 'Mauritius', 1, '230', 'MUS', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(141, 'YT', 'Mayotte', 1, '262', 'MYT', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(142, 'MX', 'Mexico', 1, '52', 'MEX', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(143, 'FM', 'Micronesia', 1, '691', 'FSM', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(144, 'MD', 'Moldova', 1, '373', 'MDA', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(145, 'MC', 'Monaco', 1, '377', 'MCO', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(146, 'MN', 'Mongolia', 1, '976', 'MNG', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(147, 'ME', 'Montenegro', 1, '382', 'MNE', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(148, 'MS', 'Montserrat', 1, '1', 'MSR', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(149, 'MA', 'Morocco', 1, '212', 'MAR', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(150, 'MZ', 'Mozambique', 1, '258', 'MOZ', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(151, 'MM', 'Myanmar', 1, '95', 'MMR', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(152, 'NA', 'Namibia', 1, '264', 'NAM', 'Africa', 'Southern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(153, 'NR', 'Nauru', 1, '674', 'NRU', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(154, 'NP', 'Nepal', 1, '977', 'NPL', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(155, 'NL', 'Netherlands', 1, '31', 'NLD', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(156, 'NC', 'New Caledonia', 1, '687', 'NCL', 'Oceania', 'Melanesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(157, 'NZ', 'New Zealand', 1, '64', 'NZL', 'Oceania', 'Australia and New Zealand', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(158, 'NI', 'Nicaragua', 1, '505', 'NIC', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(159, 'NE', 'Niger', 1, '227', 'NER', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(160, 'NG', 'Nigeria', 1, '234', 'NGA', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(161, 'NU', 'Niue', 1, '683', 'NIU', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(162, 'NF', 'Norfolk Island', 1, '672', 'NFK', 'Oceania', 'Australia and New Zealand', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(163, 'KP', 'North Korea', 1, '850', 'PRK', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(164, 'MP', 'Northern Mariana Islands', 1, '1', 'MNP', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(165, 'NO', 'Norway', 1, '47', 'NOR', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(166, 'OM', 'Oman', 1, '968', 'OMN', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(167, 'PK', 'Pakistan', 1, '92', 'PAK', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(168, 'PW', 'Palau', 1, '680', 'PLW', 'Oceania', 'Micronesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(169, 'PS', 'Palestinian Territory Occupied', 1, '970', 'PSE', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(170, 'PA', 'Panama', 1, '507', 'PAN', 'Americas', 'Central America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(171, 'PG', 'Papua new Guinea', 1, '675', 'PNG', 'Oceania', 'Melanesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(172, 'PY', 'Paraguay', 1, '595', 'PRY', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(173, 'PE', 'Peru', 1, '51', 'PER', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(174, 'PH', 'Philippines', 1, '63', 'PHL', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(175, 'PN', 'Pitcairn Island', 1, '870', 'PCN', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(176, 'PL', 'Poland', 1, '48', 'POL', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(177, 'PT', 'Portugal', 1, '351', 'PRT', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(178, 'PR', 'Puerto Rico', 1, '1', 'PRI', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(179, 'QA', 'Qatar', 1, '974', 'QAT', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(180, 'RE', 'Reunion', 1, '262', 'REU', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(181, 'RO', 'Romania', 1, '40', 'ROU', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(182, 'RU', 'Russia', 1, '7', 'RUS', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(183, 'RW', 'Rwanda', 1, '250', 'RWA', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(184, 'SH', 'Saint Helena', 1, '290', 'SHN', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(185, 'KN', 'Saint Kitts And Nevis', 1, '1', 'KNA', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(186, 'LC', 'Saint Lucia', 1, '1', 'LCA', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(187, 'PM', 'Saint Pierre and Miquelon', 1, '508', 'SPM', 'Americas', 'Northern America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(188, 'VC', 'Saint Vincent And The Grenadines', 1, '1', 'VCT', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(189, 'BL', 'Saint-Barthelemy', 1, '590', 'BLM', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(190, 'MF', 'Saint-Martin (French part)', 1, '590', 'MAF', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(191, 'WS', 'Samoa', 1, '685', 'WSM', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(192, 'SM', 'San Marino', 1, '378', 'SMR', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(193, 'ST', 'Sao Tome and Principe', 1, '239', 'STP', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(194, 'SA', 'Saudi Arabia', 1, '966', 'SAU', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(195, 'SN', 'Senegal', 1, '221', 'SEN', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(196, 'RS', 'Serbia', 1, '381', 'SRB', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(197, 'SC', 'Seychelles', 1, '248', 'SYC', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(198, 'SL', 'Sierra Leone', 1, '232', 'SLE', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(199, 'SG', 'Singapore', 1, '65', 'SGP', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(200, 'SX', 'Sint Maarten (Dutch part)', 1, '1721', 'SXM', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(201, 'SK', 'Slovakia', 1, '421', 'SVK', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(202, 'SI', 'Slovenia', 1, '386', 'SVN', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(203, 'SB', 'Solomon Islands', 1, '677', 'SLB', 'Oceania', 'Melanesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(204, 'SO', 'Somalia', 1, '252', 'SOM', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(205, 'ZA', 'South Africa', 1, '27', 'ZAF', 'Africa', 'Southern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(206, 'GS', 'South Georgia', 1, '500', 'SGS', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(207, 'KR', 'South Korea', 1, '82', 'KOR', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(208, 'SS', 'South Sudan', 1, '211', 'SSD', 'Africa', 'Middle Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(209, 'ES', 'Spain', 1, '34', 'ESP', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(210, 'LK', 'Sri Lanka', 1, '94', 'LKA', 'Asia', 'Southern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(211, 'SD', 'Sudan', 1, '249', 'SDN', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(212, 'SR', 'Suriname', 1, '597', 'SUR', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(213, 'SJ', 'Svalbard And Jan Mayen Islands', 1, '47', 'SJM', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(214, 'SZ', 'Swaziland', 1, '268', 'SWZ', 'Africa', 'Southern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(215, 'SE', 'Sweden', 1, '46', 'SWE', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(216, 'CH', 'Switzerland', 1, '41', 'CHE', 'Europe', 'Western Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(217, 'SY', 'Syria', 1, '963', 'SYR', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(218, 'TW', 'Taiwan', 1, '886', 'TWN', 'Asia', 'Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(219, 'TJ', 'Tajikistan', 1, '992', 'TJK', 'Asia', 'Central Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(220, 'TZ', 'Tanzania', 1, '255', 'TZA', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(221, 'TH', 'Thailand', 1, '66', 'THA', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(222, 'BS', 'The Bahamas', 1, '1', 'BHS', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(223, 'TG', 'Togo', 1, '228', 'TGO', 'Africa', 'Western Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(224, 'TK', 'Tokelau', 1, '690', 'TKL', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(225, 'TO', 'Tonga', 1, '676', 'TON', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(226, 'TT', 'Trinidad And Tobago', 1, '1', 'TTO', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(227, 'TN', 'Tunisia', 1, '216', 'TUN', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(228, 'TR', 'Turkey', 1, '90', 'TUR', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(229, 'TM', 'Turkmenistan', 1, '993', 'TKM', 'Asia', 'Central Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(230, 'TC', 'Turks And Caicos Islands', 1, '1', 'TCA', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(231, 'TV', 'Tuvalu', 1, '688', 'TUV', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(232, 'UG', 'Uganda', 1, '256', 'UGA', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(233, 'UA', 'Ukraine', 1, '380', 'UKR', 'Europe', 'Eastern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(234, 'AE', 'United Arab Emirates', 1, '971', 'ARE', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(235, 'GB', 'United Kingdom', 1, '44', 'GBR', 'Europe', 'Northern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(236, 'US', 'United States', 1, '1', 'USA', 'Americas', 'Northern America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(237, 'UM', 'United States Minor Outlying Islands', 1, '1', 'UMI', 'Americas', 'Northern America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(238, 'UY', 'Uruguay', 1, '598', 'URY', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(239, 'UZ', 'Uzbekistan', 1, '998', 'UZB', 'Asia', 'Central Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(240, 'VU', 'Vanuatu', 1, '678', 'VUT', 'Oceania', 'Melanesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(241, 'VA', 'Vatican City State (Holy See)', 1, '379', 'VAT', 'Europe', 'Southern Europe', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(242, 'VE', 'Venezuela', 1, '58', 'VEN', 'Americas', 'South America', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(243, 'VN', 'Vietnam', 1, '84', 'VNM', 'Asia', 'South-Eastern Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(244, 'VG', 'Virgin Islands (British)', 1, '1', 'VGB', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(245, 'VI', 'Virgin Islands (US)', 1, '1', 'VIR', 'Americas', 'Caribbean', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(246, 'WF', 'Wallis And Futuna Islands', 1, '681', 'WLF', 'Oceania', 'Polynesia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(247, 'EH', 'Western Sahara', 1, '212', 'ESH', 'Africa', 'Northern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(248, 'YE', 'Yemen', 1, '967', 'YEM', 'Asia', 'Western Asia', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(249, 'ZM', 'Zambia', 1, '260', 'ZMB', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44'),
(250, 'ZW', 'Zimbabwe', 1, '263', 'ZWE', 'Africa', 'Eastern Africa', '2023-01-10 10:23:44', '2023-01-10 10:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precision` tinyint(4) NOT NULL DEFAULT '2',
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol_native` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol_first` tinyint(4) NOT NULL DEFAULT '1',
  `decimal_mark` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '.',
  `thousands_separator` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ',',
  `is_default` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `country_id`, `name`, `code`, `precision`, `symbol`, `symbol_native`, `symbol_first`, `decimal_mark`, `thousands_separator`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Afghan Afghani', 'AFN', 0, 'Af', '؋', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-21 14:24:32'),
(2, 2, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(3, 3, 'Albanian Lek', 'ALL', 0, 'ALL', 'Lek', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(4, 4, 'Algerian Dinar', 'DZD', 2, 'DA', 'د.ج.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(5, 5, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(6, 6, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(7, 7, 'AOA', 'AOA', 2, 'Kz', 'Kz', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(8, 8, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(9, 9, 'AAD', 'AAD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(10, 10, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(11, 11, 'Argentine Peso', 'ARS', 2, 'AR$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(12, 12, 'Armenian Dram', 'AMD', 0, 'AMD', 'դր.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(13, 13, 'AWG', 'AWG', 2, 'ƒ', 'ƒ', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(14, 14, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(15, 15, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(16, 16, 'Azerbaijani Manat', 'AZN', 2, 'man.', 'ман.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(17, 17, 'Bahraini Dinar', 'BHD', 3, 'BD', 'د.ب.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(18, 18, 'Bangladeshi Taka', 'BDT', 2, 'Tk', '৳', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(19, 19, 'BBD', 'BBD', 2, 'Bds$', 'Bds$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(20, 20, 'Belarusian Ruble', 'BYN', 2, 'Br', 'руб.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(21, 21, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(22, 22, 'Belize Dollar', 'BZD', 2, 'BZ$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(23, 23, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(24, 24, 'BMD', 'BMD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(25, 25, 'BTN', 'BTN', 2, 'Nu.', 'Nu.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(26, 26, 'Bolivian Boliviano', 'BOB', 2, 'Bs', 'Bs', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(27, 27, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(28, 28, 'Bosnia-Herzegovina Convertible Mark', 'BAM', 2, 'KM', 'KM', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(29, 29, 'Botswanan Pula', 'BWP', 2, 'BWP', 'P', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(30, 30, 'Norwegian Krone', 'NOK', 2, 'Nkr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(31, 31, 'Brazilian Real', 'BRL', 2, 'R$', 'R$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(32, 32, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(33, 33, 'Brunei Dollar', 'BND', 2, 'BN$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(34, 34, 'Bulgarian Lev', 'BGN', 2, 'BGN', 'лв.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(35, 35, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(36, 36, 'Burundian Franc', 'BIF', 0, 'FBu', 'FBu', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(37, 37, 'Cambodian Riel', 'KHR', 2, 'KHR', '៛', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(38, 38, 'CFA Franc BEAC', 'XAF', 0, 'FCFA', 'FCFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(39, 39, 'Canadian Dollar', 'CAD', 2, 'CA$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-07 00:40:44'),
(40, 40, 'Cape Verdean Escudo', 'CVE', 2, 'CV$', 'CV$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(41, 41, 'KYD', 'KYD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(42, 42, 'CFA Franc BEAC', 'XAF', 0, 'FCFA', 'FCFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(43, 43, 'CFA Franc BEAC', 'XAF', 0, 'FCFA', 'FCFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(44, 44, 'Chilean Peso', 'CLP', 0, 'CL$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(45, 45, 'Chinese Yuan', 'CNY', 2, 'CN¥', 'CN¥', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(46, 46, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(47, 47, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(48, 48, 'Colombian Peso', 'COP', 0, 'CO$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(49, 49, 'Comorian Franc', 'KMF', 0, 'CF', 'FC', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(50, 50, 'CFA Franc BEAC', 'XAF', 0, 'FCFA', 'FCFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(51, 51, 'New Zealand Dollar', 'NZD', 2, 'NZ$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(52, 52, 'Costa Rican Colón', 'CRC', 0, '₡', '₡', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(53, 53, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(54, 54, 'Croatian Kuna', 'HRK', 2, 'kn', 'kn', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(55, 55, 'CUP', 'CUP', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(56, 56, 'ANG', 'ANG', 2, 'ƒ', 'ƒ', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(57, 57, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(58, 58, 'Czech Republic Koruna', 'CZK', 2, 'Kč', 'Kč', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(59, 59, 'Congolese Franc', 'CDF', 2, 'CDF', 'FrCD', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(60, 60, 'Danish Krone', 'DKK', 2, 'Dkr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(61, 61, 'Djiboutian Franc', 'DJF', 0, 'Fdj', 'Fdj', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(62, 62, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(63, 63, 'Dominican Peso', 'DOP', 2, 'RD$', 'RD$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(64, 64, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(65, 65, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(66, 66, 'Egyptian Pound', 'EGP', 2, 'EGP', 'ج.م.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(67, 67, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(68, 68, 'CFA Franc BEAC', 'XAF', 0, 'FCFA', 'FCFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(69, 69, 'Eritrean Nakfa', 'ERN', 2, 'Nfk', 'Nfk', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(70, 70, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(71, 71, 'Ethiopian Birr', 'ETB', 2, 'Br', 'Br', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(72, 72, 'FKP', 'FKP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(73, 73, 'Danish Krone', 'DKK', 2, 'Dkr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(74, 74, 'FJD', 'FJD', 2, 'FJ$', 'FJ$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(75, 75, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(76, 76, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(77, 77, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(78, 78, 'XPF', 'XPF', 2, '₣', '₣', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(79, 79, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(80, 80, 'CFA Franc BEAC', 'XAF', 0, 'FCFA', 'FCFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(81, 81, 'GMD', 'GMD', 2, 'D', 'D', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(82, 82, 'Georgian Lari', 'GEL', 2, 'GEL', 'GEL', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(83, 83, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(84, 84, 'Ghanaian Cedi', 'GHS', 2, 'GH₵', 'GH₵', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(85, 85, 'GIP', 'GIP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(86, 86, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(87, 87, 'Danish Krone', 'DKK', 2, 'Dkr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(88, 88, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(89, 89, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(90, 90, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(91, 91, 'Guatemalan Quetzal', 'GTQ', 2, 'GTQ', 'Q', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(92, 92, 'British Pound Sterling', 'GBP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(93, 93, 'Guinean Franc', 'GNF', 0, 'FG', 'FG', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(94, 94, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(95, 95, 'GYD', 'GYD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(96, 96, 'HTG', 'HTG', 2, 'G', 'G', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(97, 97, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(98, 98, 'Honduran Lempira', 'HNL', 2, 'HNL', 'L', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(99, 99, 'Hong Kong Dollar', 'HKD', 2, 'HK$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(100, 100, 'Hungarian Forint', 'HUF', 0, 'Ft', 'Ft', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(101, 101, 'Icelandic Króna', 'ISK', 0, 'Ikr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(102, 102, 'Indian Rupee', 'INR', 2, 'Rs', 'টকা', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(103, 103, 'Indonesian Rupiah', 'IDR', 0, 'Rp', 'Rp', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(104, 104, 'Iranian Rial', 'IRR', 0, 'IRR', '﷼', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(105, 105, 'Iraqi Dinar', 'IQD', 0, 'IQD', 'د.ع.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(106, 106, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(107, 107, 'Israeli New Sheqel', 'ILS', 2, '₪', '₪', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(108, 108, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(109, 109, 'Jamaican Dollar', 'JMD', 2, 'J$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(110, 110, 'Japanese Yen', 'JPY', 0, '¥', '￥', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(111, 111, 'British Pound Sterling', 'GBP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(112, 112, 'Jordanian Dinar', 'JOD', 3, 'JD', 'د.أ.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(113, 113, 'Kazakhstani Tenge', 'KZT', 2, 'KZT', 'тңг.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(114, 114, 'Kenyan Shilling', 'KES', 2, 'Ksh', 'Ksh', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(115, 115, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(116, 116, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(117, 117, 'Kuwaiti Dinar', 'KWD', 3, 'KD', 'د.ك.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(118, 118, 'KGS', 'KGS', 2, 'лв', 'лв', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(119, 119, 'LAK', 'LAK', 2, '₭', '₭', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(120, 120, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(121, 121, 'Lebanese Pound', 'LBP', 0, 'L.L.', 'ل.ل.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(122, 122, 'LSL', 'LSL', 2, 'L', 'L', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(123, 123, 'LRD', 'LRD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(124, 124, 'Libyan Dinar', 'LYD', 3, 'LD', 'د.ل.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(125, 125, 'Swiss Franc', 'CHF', 2, 'CHF', 'CHF', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(126, 126, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(127, 127, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(128, 128, 'Macanese Pataca', 'MOP', 2, 'MOP$', 'MOP$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(129, 129, 'Macedonian Denar', 'MKD', 2, 'MKD', 'MKD', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(130, 130, 'Malagasy Ariary', 'MGA', 0, 'MGA', 'MGA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(131, 131, 'MWK', 'MWK', 2, 'MK', 'MK', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(132, 132, 'Malaysian Ringgit', 'MYR', 2, 'RM', 'RM', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(133, 133, 'MVR', 'MVR', 2, 'Rf', 'Rf', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(134, 134, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(135, 135, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(136, 136, 'British Pound Sterling', 'GBP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(137, 137, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(138, 138, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(139, 139, 'MRO', 'MRO', 2, 'MRU', 'MRU', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(140, 140, 'Mauritian Rupee', 'MUR', 0, 'MURs', 'MURs', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(141, 141, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(142, 142, 'Mexican Peso', 'MXN', 2, 'MX$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(143, 143, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(144, 144, 'Moldovan Leu', 'MDL', 2, 'MDL', 'MDL', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(145, 145, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(146, 146, 'MNT', 'MNT', 2, '₮', '₮', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(147, 147, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(148, 148, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(149, 149, 'Moroccan Dirham', 'MAD', 2, 'MAD', 'د.م.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(150, 150, 'Mozambican Metical', 'MZN', 2, 'MTn', 'MTn', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(151, 151, 'Myanma Kyat', 'MMK', 0, 'MMK', 'K', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(152, 152, 'Namibian Dollar', 'NAD', 2, 'N$', 'N$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(153, 153, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(154, 154, 'Nepalese Rupee', 'NPR', 2, 'NPRs', 'नेरू', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(155, 155, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(156, 156, 'XPF', 'XPF', 2, '₣', '₣', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(157, 157, 'New Zealand Dollar', 'NZD', 2, 'NZ$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(158, 158, 'Nicaraguan Córdoba', 'NIO', 2, 'C$', 'C$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(159, 159, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(160, 160, 'Nigerian Naira', 'NGN', 2, '₦', '₦', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 09:02:46'),
(161, 161, 'New Zealand Dollar', 'NZD', 2, 'NZ$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(162, 162, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(163, 163, 'KPW', 'KPW', 2, '₩', '₩', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(164, 164, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(165, 165, 'Norwegian Krone', 'NOK', 2, 'Nkr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(166, 166, 'Omani Rial', 'OMR', 3, 'OMR', 'ر.ع.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(167, 167, 'Pakistani Rupee', 'PKR', 0, 'PKRs', '₨', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(168, 168, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(169, 169, 'Israeli New Sheqel', 'ILS', 2, '₪', '₪', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(170, 170, 'Panamanian Balboa', 'PAB', 2, 'B/.', 'B/.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(171, 171, 'PGK', 'PGK', 2, 'K', 'K', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(172, 172, 'Paraguayan Guarani', 'PYG', 0, '₲', '₲', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(173, 173, 'Peruvian Nuevo Sol', 'PEN', 2, 'S/.', 'S/.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(174, 174, 'Philippine Peso', 'PHP', 2, '₱', '₱', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(175, 175, 'New Zealand Dollar', 'NZD', 2, 'NZ$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(176, 176, 'Polish Zloty', 'PLN', 2, 'zł', 'zł', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(177, 177, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(178, 178, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(179, 179, 'Qatari Rial', 'QAR', 2, 'QR', 'ر.ق.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(180, 180, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(181, 181, 'Romanian Leu', 'RON', 2, 'RON', 'RON', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(182, 182, 'Russian Ruble', 'RUB', 2, 'RUB', '₽.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(183, 183, 'Rwandan Franc', 'RWF', 0, 'RWF', 'FR', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(184, 184, 'SHP', 'SHP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(185, 185, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(186, 186, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(187, 187, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(188, 188, 'XCD', 'XCD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(189, 189, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(190, 190, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(191, 191, 'WST', 'WST', 2, 'SAT', 'SAT', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(192, 192, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(193, 193, 'STD', 'STD', 2, 'Db', 'Db', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(194, 194, 'Saudi Riyal', 'SAR', 2, 'SR', 'ر.س.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(195, 195, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(196, 196, 'Serbian Dinar', 'RSD', 0, 'din.', 'дин.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(197, 197, 'SCR', 'SCR', 2, 'SRe', 'SRe', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(198, 198, 'SLL', 'SLL', 2, 'Le', 'Le', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(199, 199, 'Singapore Dollar', 'SGD', 2, 'S$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(200, 200, 'ANG', 'ANG', 2, 'ƒ', 'ƒ', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(201, 201, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(202, 202, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(203, 203, 'SBD', 'SBD', 2, 'Si$', 'Si$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(204, 204, 'Somali Shilling', 'SOS', 0, 'Ssh', 'Ssh', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(205, 205, 'South African Rand', 'ZAR', 2, 'R', 'R', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(206, 206, 'British Pound Sterling', 'GBP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(207, 207, 'South Korean Won', 'KRW', 0, '₩', '₩', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(208, 208, 'SSP', 'SSP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(209, 209, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(210, 210, 'Sri Lankan Rupee', 'LKR', 2, 'SLRs', 'SL Re', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(211, 211, 'Sudanese Pound', 'SDG', 2, 'SDG', 'SDG', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(212, 212, 'SRD', 'SRD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(213, 213, 'Norwegian Krone', 'NOK', 2, 'Nkr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(214, 214, 'SZL', 'SZL', 2, 'E', 'E', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(215, 215, 'Swedish Krona', 'SEK', 2, 'Skr', 'kr', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(216, 216, 'Swiss Franc', 'CHF', 2, 'CHF', 'CHF', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(217, 217, 'Syrian Pound', 'SYP', 0, 'SY£', 'ل.س.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(218, 218, 'New Taiwan Dollar', 'TWD', 2, 'NT$', 'NT$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(219, 219, 'TJS', 'TJS', 2, 'SM', 'SM', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(220, 220, 'Tanzanian Shilling', 'TZS', 0, 'TSh', 'TSh', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(221, 221, 'Thai Baht', 'THB', 2, '฿', '฿', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(222, 222, 'BSD', 'BSD', 2, 'B$', 'B$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(223, 223, 'CFA Franc BCEAO', 'XOF', 0, 'CFA', 'CFA', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(224, 224, 'New Zealand Dollar', 'NZD', 2, 'NZ$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(225, 225, 'Tongan Paʻanga', 'TOP', 2, 'T$', 'T$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(226, 226, 'Trinidad and Tobago Dollar', 'TTD', 2, 'TT$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(227, 227, 'Tunisian Dinar', 'TND', 3, 'DT', 'د.ت.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(228, 228, 'Turkish Lira', 'TRY', 2, 'TL', 'TL', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(229, 229, 'TMT', 'TMT', 2, 'T', 'T', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(230, 230, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(231, 231, 'Australian Dollar', 'AUD', 2, 'AU$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-13 12:52:18'),
(232, 232, 'Ugandan Shilling', 'UGX', 0, 'USh', 'USh', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(233, 233, 'Ukrainian Hryvnia', 'UAH', 2, '₴', '₴', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(234, 234, 'United Arab Emirates Dirham', 'AED', 2, 'AED', 'د.إ.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(235, 235, 'British Pound Sterling', 'GBP', 2, '£', '£', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(236, 236, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(237, 237, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(238, 238, 'Uruguayan Peso', 'UYU', 2, '$U', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(239, 239, 'Uzbekistan Som', 'UZS', 0, 'UZS', 'UZS', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(240, 240, 'VUV', 'VUV', 2, 'VT', 'VT', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(241, 241, 'Euro', 'EUR', 2, '€', '€', 1, '.', ',', 1, 1, '2023-03-21 08:16:47', '2023-03-21 12:16:47'),
(242, 242, 'Venezuelan Bolívar', 'VEF', 2, 'Bs.F.', 'Bs.F.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(243, 243, 'Vietnamese Dong', 'VND', 0, '₫', '₫', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(244, 244, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(245, 245, 'US Dollar', 'USD', 2, '$', '$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-02-06 08:30:05'),
(246, 246, 'XPF', 'XPF', 2, '₣', '₣', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(247, 247, 'Moroccan Dirham', 'MAD', 2, 'MAD', 'د.م.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(248, 248, 'Yemeni Rial', 'YER', 0, 'YR', 'ر.ي.', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(249, 249, 'ZMW', 'ZMW', 2, 'ZK', 'ZK', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26'),
(250, 250, 'Zimbabwean Dollar', 'ZWL', 0, 'ZWL$', 'ZWL$', 1, '.', ',', 0, 1, '2023-01-10 10:45:26', '2023-01-10 10:45:26');

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rates`
--

CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `exchange_rate` double NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exchange_rates`
--

INSERT INTO `exchange_rates` (`id`, `code`, `exchange_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USD', 1, 1, '2023-02-05 17:35:21', '2023-02-21 14:22:06'),
(2, 'AUD', 1.28, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(5, 'BRL', 3.25, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(6, 'CAD', 1.27, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(7, 'CZK', 20.65, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(8, 'DKK', 6.05, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(9, 'EUR', 0.85, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(10, 'HKD', 7.83, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(11, 'HUF', 255.24, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(12, 'ILS', 3.48, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(13, 'JPY', 107.12, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(14, 'MYR', 3.91, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(15, 'MXN', 18.72, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(16, 'NOK', 7.83, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(17, 'NZD', 1.38, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(18, 'PHP', 52.26, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(19, 'PLN', 3.39, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(20, 'GBP', 0.72, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(21, 'RUB', 55.93, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(22, 'SGD', 1.32, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(23, 'SEK', 8.19, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(24, 'CHF', 0.94, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(26, 'THB', 31.39, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(27, 'BDT', 84, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(28, 'INR', 68.45, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(29, 'NGN', 420, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21'),
(37, 'GHC', 55.5, 1, '2023-02-05 17:35:21', '2023-02-05 17:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regional` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_locale` tinyint(5) NOT NULL DEFAULT '0',
  `dir` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(5) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `native`, `regional`, `flag_code`, `default_locale`, `dir`, `status`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'English', 'en-US', 'us', 1, NULL, 1, '2022-12-07 10:54:59', '2023-02-13 14:03:39'),
(2, 'fr', 'French', 'français', 'fr-FR', 'fr', 0, NULL, 1, '2022-12-07 10:54:59', '2023-03-18 11:53:11'),
(4, 'es', 'Spanish', 'español', 'es_ES', 'es', 0, NULL, 1, '2022-12-07 10:54:59', '2023-02-13 13:19:19'),
(5, 'zh', 'Chinese (Simplified)', '简体中文', 'Z', 'cn', 0, NULL, 1, '2022-12-07 10:54:59', '2023-03-18 11:46:30'),
(6, 'de', 'German', 'Deutsch', 'de_DE', 'de', 0, NULL, 1, '2023-03-18 11:46:08', '2023-03-18 11:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) NOT NULL,
  `subject` text NOT NULL,
  `message` text,
  `message_type` varchar(30) NOT NULL,
  `sender` varchar(40) DEFAULT NULL,
  `userid` bigint(20) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `reference_id` varchar(30) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `push` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `payment_id` varchar(50) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `invoice_id` varchar(100) DEFAULT NULL,
  `payer_id` varchar(100) DEFAULT NULL,
  `payer_email` varchar(100) DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `currency` char(4) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `payment_description` text,
  `gateway` varchar(100) NOT NULL,
  `branch` tinyint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `status` tinyint(5) NOT NULL,
  `fields` text NOT NULL,
  `instruction` text,
  `currency` char(5) DEFAULT NULL,
  `test_mode` char(10) NOT NULL DEFAULT 'true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `status`, `fields`, `instruction`, `currency`, `test_mode`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', 1, '{\"Live_Client_Id\":\"XXXXXX-XXXXXXX\",\"Live_Client_Secret\":\"XXXXXX-XXXXXXX\"}', '{\"en\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"fr\":\"Ecourier France\",\"es\":\"Ecourier espa\\u00f1ol\",\"zh\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"de\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\"}', 'USD', 'true', '2023-02-06 22:41:54', '2023-02-06 22:41:54'),
(2, 'Bank_Transfer', 1, '{\"Bank_Account_Details\":\"Account No: 0123456789, Account Name: Ecourier Company,  Bank: Ecourier Bank\"}', '{\"en\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"fr\":\"Ecourier France\",\"es\":\"Ecourier espa\\u00f1ol\",\"zh\":\"Ecourier\",\"de\":\"Ecourier\"}', 'USD', 'false', '2023-02-06 22:41:54', '2023-02-06 22:41:54'),
(3, 'Cash_Payment', 1, '[]', '{\"en\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"fr\":\"Ecourier France\",\"es\":\"Ecourier espa\\u00f1ol\",\"zh\":\"Ecourier\",\"de\":\"Ecourier\"}', 'USD', 'false', '2023-02-06 22:41:54', '2023-02-06 22:41:54'),
(4, 'Stripe', 1, '{\"Public_Key\":\"XXXXXX-XXXXXXX\",\"Secret_Key\":\"XXXXXX-XXXXXXX\"}', '{\"en\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"fr\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"es\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"zh\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\",\"de\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\\r\\n\\r\\nLorem ipsum dolor sit amet consectetur adipisicing elit. Laborum recusandae dolorem voluptas nemo, modi eos minus nesciunt.\"}', 'USD', 'true', '2023-02-06 22:41:54', '2023-02-06 22:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(11) NOT NULL,
  `post_type` char(10) COLLATE utf8_bin NOT NULL,
  `post_title` text COLLATE utf8_bin NOT NULL,
  `post_excerpt` text COLLATE utf8_bin,
  `post_content` text COLLATE utf8_bin,
  `post_status` tinyint(2) DEFAULT NULL,
  `post_featured` tinyint(3) DEFAULT '0',
  `post_author` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `post_last_edited` bigint(20) NOT NULL DEFAULT '0',
  `post_view` bigint(20) DEFAULT '0',
  `post_slug` varchar(300) COLLATE utf8_bin DEFAULT NULL,
  `post_img` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

CREATE TABLE `post_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `owner_id` bigint(20) DEFAULT NULL,
  `last_updated_by` bigint(20) DEFAULT NULL,
  `sender_address_id` bigint(20) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `sender_phone` varchar(40) DEFAULT NULL,
  `sender_email` varchar(200) DEFAULT NULL,
  `sender_country` varchar(255) DEFAULT NULL,
  `sender_state` varchar(50) DEFAULT NULL,
  `sender_city` varchar(50) DEFAULT NULL,
  `sender_address` text,
  `receiver_address_id` bigint(20) DEFAULT NULL,
  `receiver_name` varchar(50) DEFAULT NULL,
  `receiver_phone` text,
  `receiver_email` varchar(200) DEFAULT NULL,
  `receiver_country` varchar(40) DEFAULT NULL,
  `receiver_state` varchar(50) DEFAULT NULL,
  `receiver_city` varchar(100) DEFAULT NULL,
  `receiver_address` varchar(255) DEFAULT NULL,
  `from_area` int(10) DEFAULT NULL,
  `to_area` int(10) DEFAULT NULL,
  `from_branch` int(10) DEFAULT NULL,
  `to_branch` int(10) DEFAULT NULL,
  `postal_sender` varchar(200) DEFAULT NULL,
  `postal_receiver` varchar(200) DEFAULT NULL,
  `current_location` text,
  `payment_type` tinyint(4) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_status` int(2) DEFAULT NULL,
  `collection_type` tinyint(5) DEFAULT NULL,
  `delivery_type` int(5) DEFAULT NULL,
  `delivery_timeline` varchar(50) DEFAULT NULL,
  `delivery_date` timestamp NULL DEFAULT NULL,
  `delivery_agent` bigint(20) DEFAULT NULL,
  `shipped_date` timestamp NULL DEFAULT NULL,
  `total_weight` double NOT NULL DEFAULT '0',
  `package_name` varchar(255) DEFAULT NULL,
  `qty` int(10) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `note` text,
  `disabled` int(5) DEFAULT '0',
  `invoice_id` varchar(20) DEFAULT NULL,
  `subtotal` double DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `tax` double DEFAULT '0',
  `shipping_cost` double DEFAULT NULL,
  `currency` char(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_log`
--

CREATE TABLE `shipment_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipment_id` varchar(20) DEFAULT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_package`
--

CREATE TABLE `shipment_package` (
  `id` bigint(20) NOT NULL,
  `shipment_id` varchar(40) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `weight` int(5) DEFAULT NULL,
  `qty` int(5) DEFAULT NULL,
  `unit_price` double NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_cost`
--

CREATE TABLE `shipping_cost` (
  `id` bigint(20) NOT NULL,
  `origin_country` varchar(20) DEFAULT NULL,
  `origin_state` varchar(20) DEFAULT NULL,
  `destination_country` varchar(20) DEFAULT NULL,
  `destination_state` varchar(20) DEFAULT NULL,
  `destination_city` varchar(20) DEFAULT NULL,
  `destination_area` varchar(20) DEFAULT NULL,
  `weight_from` int(10) NOT NULL,
  `weight_to` int(10) NOT NULL,
  `amount` double NOT NULL,
  `currency` char(5) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_key` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_key`, `value`, `updated_at`, `created_at`) VALUES
(1, 'site_name', '{\"en\":\"Ecourier\",\"fr\":\"Ecourier France\",\"es\":\"Ecourier espa\\u00f1ol\",\"zh\":\"Ecourier China\",\"de\":\"Ecourier Germany\"}', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(2, 'site_theme', 'greenship', NULL, NULL),
(3, 'system_software', 'Ecourier', NULL, NULL),
(5, 'system_software_version', '1.1', NULL, NULL),
(17, 'translation', 'enabled', NULL, NULL),
(25, 'site_tagline', '{\"en\":\"Ship Faster Globally\",\"fr\":\"Exp\\u00e9diez plus rapidement dans le monde entier\",\"es\":\"Env\\u00ede m\\u00e1s r\\u00e1pido a nivel mundial\",\"zh\":\"\\u5168\\u7403\\u53d1\\u8d27\\u66f4\\u5feb\",\"de\":\"Weltweit schneller versenden\"}', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(26, 'site_description', '{\"en\":\"The best shipping and tracking script\",\"fr\":\"Le meilleur script d\'exp\\u00e9dition et de suivi\",\"es\":\"El mejor script de env\\u00edo y seguimiento.\",\"zh\":\"\\u6700\\u597d\\u7684\\u8fd0\\u8f93\\u548c\\u5305\\u88f9\\u8ddf\\u8e2a\\u811a\\u672c\\u3002\",\"de\":\"Das beste Versand- und Tracking-Skript\"}', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(27, 'site_announcement', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(28, 'site_copyright', '{\"en\":\"Copyright \\u00a9 2023 | All right reserved\",\"fr\":\"Droits d\'auteur \\u00a9 2023 | Tous droits r\\u00e9serv\\u00e9s\",\"es\":\"Derechos de autor \\u00a9 2023 | Todos los derechos reservados\",\"zh\":\"\\u7248\\u6743\\u6240\\u6709 \\u00a9 2023 |\\u4fdd\\u7559\\u6240\\u6709\\u6743\\u5229\",\"de\":\"Copyright \\u00a9 2023 | Alle Rechte vorbehalten\"}', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(29, 'set_locale', 'en', '2022-12-07 00:21:58', '2022-12-06 22:31:35'),
(30, 'site_email_support', 'support@example.com', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(31, 'site_phone', '+123456789', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(32, 'site_head_office', '123 Street, New York, USA', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(33, 'live_chat_embed', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(34, 'telegram_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(35, 'instagram_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(36, 'facebook_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(37, 'twitter_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(38, 'youtube_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(39, 'whatsapp_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(40, 'linkedin_link', NULL, '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(41, 'currency_code', 'USD', '2023-03-21 12:16:47', '2022-12-06 22:31:35'),
(43, 'default_shipping_cost', '100', '2023-03-19 03:21:52', '2022-12-06 22:31:35'),
(44, 'default_shipping_cost_currency', 'USD', '2022-12-07 21:32:30', '2022-12-06 22:31:35'),
(45, 'tracking_prefix', 'enabled', '2023-03-20 22:21:36', '2022-12-06 22:31:35'),
(46, 'default_tracking_prefix', 'ED', '2023-03-20 22:21:36', '2022-12-06 22:31:35'),
(47, 'currency_localize', 'enabled', '2023-03-21 12:16:47', '2022-12-06 22:31:35'),
(49, 'timezone', 'UTC', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(51, 'tax_type', 'fixed', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(52, 'tax_amount', '5', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(53, 'tax_currency', 'USD', '2022-12-07 21:32:30', '2022-12-06 22:31:35'),
(54, 'tax', 'enabled', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(55, 'payment_type', '2', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(56, 'payment_method', '3', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(57, 'shipment_terms', '{\"en\":\"Shipping Terms and Conditions\"}', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(58, 'discount_type', 'fixed', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(59, 'discount_amount', '2.5', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(60, 'discount_currency', 'USD', '2022-12-07 21:32:30', '2022-12-06 22:31:35'),
(61, 'discount', '', '2023-03-20 22:21:37', '2022-12-06 22:31:35'),
(62, 'email_notification', 'enabled', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(63, 'default_mailer', 'sendmail', '2023-03-21 13:27:09', '2022-12-06 22:31:35'),
(73, 'default_mailer_sender_name', 'Ecourier', '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(74, 'default_mailer_sender_email', 'noreply@example.com', '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(75, 'default_mailer_encryption', 'ssl', '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(76, 'default_mailer_host', 'http', '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(77, 'default_mailer_port', '3030', '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(78, 'default_mailer_username', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(79, 'default_mailer_password', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(80, 'default_mailer_mailgun_domain', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(81, 'default_mailer_mailgun_key', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(82, 'default_sms_gateway', 'twilo', '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(83, 'sms_sender_number', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(84, 'sms_twilo_sid', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(85, 'sms_twilo_auth_token', NULL, '2023-03-21 13:27:09', '2023-02-10 13:30:47'),
(87, 'shipment_notification', 'enabled', '2023-03-21 13:27:09', '2023-02-10 13:56:33'),
(88, 'invoice_notification', 'enabled', '2023-03-21 13:27:09', '2023-02-10 13:56:33'),
(89, 'site_notification', 'enabled', '2023-03-21 13:27:09', '2023-02-10 13:56:33'),
(91, 'account_notification', 'enabled', '2023-03-21 13:27:09', '2023-02-10 14:03:24'),
(92, 'sms_notification', 'disable', '2023-03-21 13:27:09', '2023-02-10 14:17:50'),
(93, '_token', NULL, '2023-03-21 13:27:09', '2023-02-17 12:40:35'),
(94, '_method', 'POST', '2023-03-21 13:27:09', '2023-02-17 12:40:35'),
(95, 'page', 'general', '2023-03-21 13:27:09', '2023-02-17 12:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--
CREATE TABLE `states` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `country_id` bigint(20) unsigned NOT NULL,
 `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
 `country_code` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
 `status` tinyint(5) DEFAULT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `theme_info` text NOT NULL,
  `theme_options` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `current_version` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `slug`, `theme_info`, `theme_options`, `status`, `current_version`, `created_at`, `updated_at`) VALUES
(1, 'Greenship', 'greenship', '{\r\n	\"name\": \"Greenship\",\r\n	\"version\": \"1.0\",\r\n	\"description\": \"Greenship\",\r\n	\"tags\": \"shipping, shipment, parcel, ship, cargo, logistics, green, courier, ecourier\",\r\n	\"author\": \"Endycode\",\r\n	\"require\": \"1.0\",\r\n	\"theme_url\": \"https://endycode.com/page/greenship\"\r\n}', '{\r\n	\"homepage\": [{\r\n		\"section_home_hero\": \"Homepage_Hero\",\r\n		\"section_home_service\": \"Homepage_Service\",\r\n		\"section_home_counter\": \"Homepage_Counter\",\r\n		\"section_home_faq\": \"Homepage_Faqs\",\r\n		\"section_home_blog\": \"Homepage_News\",\r\n		\"section_home_partner\": \"Homepage_Partners\"\r\n	}],\r\n	\"header\": [{\r\n		\"menu_item_service\": \"Our_Service\",\r\n		\"menu_item_contact\": \"Contact_Us\",\r\n		\"menu_item_tracking\": \"Track_Shipment\",\r\n		\"menu_item_phone\": \"Phone\",\r\n		\"menu_item_email\": \"Email\",\r\n		\"menu_item_login\": \"Login\",\r\n		\"menu_item_language\": \"Language_Switcher\"\r\n	}],\r\n	\"footer\": [{\r\n		\"footer_section_tracking\": \"Tracking_Section\",\r\n		\"footer_section_service\": \"Service_Section\",\r\n		\"footer_section_link\": \"Useful_Link_Section\",\r\n		\"footer_section_contact\": \"Contact_Section\",\r\n		\"footer_section_copyright\": \"Copyright_Section\"\r\n	}],\r\n	\"styling\": [{\r\n		\"styling_primary_color\": \"Primary_Color\",\r\n		\"styling_secondary_color\": \"Secondary_Color\"\r\n	}],\r\n	\"logo\": [{\r\n		\"site_logo_main\": \"Main_Logo\",\r\n		\"site_logo_dashboard\": \"Dashboard_Logo\"\r\n	}],\r\n	\"custom\": [{\r\n		\"custom_css\": \"Custom_Css\",\r\n		\"custom_js\": \"Custom_Javascript\"\r\n	}]\r\n}', 1, '1.0', '2023-02-01 10:04:59', '2023-02-01 10:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `theme_contents`
--

CREATE TABLE `theme_contents` (
  `id` bigint(20) NOT NULL,
  `theme` varchar(20) NOT NULL,
  `config_key` varchar(50) NOT NULL,
  `sub_key` varchar(50) NOT NULL,
  `contents` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme_contents`
--

INSERT INTO `theme_contents` (`id`, `theme`, `config_key`, `sub_key`, `contents`, `created_at`, `updated_at`) VALUES
(1, 'greenship', 'home_hero_title', 'section_home_hero', '{\"en\":\"Ship Smarter Today!\",\"fr\":\"Exp\\u00e9diez plus intelligemment aujourd\'hui\\u00a0!\",\"es\":\"\\u00a1Env\\u00ede de manera m\\u00e1s inteligente hoy!\",\"zh\":\"\\u4eca\\u5929\\u66f4\\u667a\\u80fd\\u5730\\u53d1\\u8d27\\uff01\",\"de\":\"Versende heute intelligenter!\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(2, 'greenship', 'home_hero_desc', 'section_home_hero', '{\"en\":\"Ready to ship faster, \\r\\n The absolute best rates from top carriers and everything you need for professional shipping\",\"fr\":\"Pr\\u00eat \\u00e0 exp\\u00e9dier plus rapidement,\\r\\n Les meilleurs tarifs absolus des meilleurs transporteurs et tout ce dont vous avez besoin pour une exp\\u00e9dition professionnelle\",\"es\":\"Listo para enviar m\\u00e1s r\\u00e1pido,\\r\\n Las mejores tarifas absolutas de los principales transportistas y todo lo que necesita para un env\\u00edo profesional\",\"zh\":\"\\u51c6\\u5907\\u53d1\\u8d27\\u66f4\\u5feb\\uff0c\\r\\n \\u9876\\u7ea7\\u627f\\u8fd0\\u5546\\u7684\\u7edd\\u5bf9\\u6700\\u4f18\\u60e0\\u4ef7\\u683c\\u4ee5\\u53ca\\u4e13\\u4e1a\\u8fd0\\u8f93\\u6240\\u9700\\u7684\\u4e00\\u5207\",\"de\":\"Schneller versandbereit,\\r\\n Die absolut besten Preise von Top-Spediteuren und alles, was Sie f\\u00fcr einen professionellen Versand ben\\u00f6tigen\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(3, 'greenship', 'home_service_title', 'section_home_service', '{\"en\":\"Our Services\",\"fr\":\"Nos services\",\"es\":\"Nuestros servicios\",\"zh\":\"\\u6211\\u4eec\\u7684\\u670d\\u52a1\",\"de\":\"Unsere Dienstleistungen\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(4, 'greenship', 'home_service_desc', 'section_home_service', '{\"en\":\"Our tech-empowered solutions offer customised logistics services ranging from collection and storage of goods to transportation and door-step delivery.\",\"fr\":\"Nos solutions technologiques offrent des services logistiques personnalis\\u00e9s allant de la collecte et du stockage des marchandises au transport et \\u00e0 la livraison \\u00e0 domicile.\",\"es\":\"Nuestras soluciones tecnol\\u00f3gicas ofrecen servicios de log\\u00edstica personalizados que van desde la recolecci\\u00f3n y el almacenamiento de mercanc\\u00edas hasta el transporte y la entrega a domicilio.\",\"zh\":\"\\u6211\\u4eec\\u7684\\u6280\\u672f\\u652f\\u6301\\u89e3\\u51b3\\u65b9\\u6848\\u63d0\\u4f9b\\u5b9a\\u5236\\u7684\\u7269\\u6d41\\u670d\\u52a1\\uff0c\\u4ece\\u8d27\\u7269\\u7684\\u6536\\u96c6\\u548c\\u5b58\\u50a8\\u5230\\u8fd0\\u8f93\\u548c\\u9001\\u8d27\\u4e0a\\u95e8\\u3002\",\"de\":\"Unsere technologiegest\\u00fctzten L\\u00f6sungen bieten ma\\u00dfgeschneiderte Logistikdienstleistungen, die von der Abholung und Lagerung von Waren bis hin zum Transport und der Lieferung an die Haust\\u00fcr reichen.\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(5, 'greenship', 'home_faq_title', 'section_home_faq', '{\"en\":\"Frequently Ask Questions\",\"fr\":\"Foire aux questions\",\"es\":\"Preguntas Frecuentes\",\"zh\":\"\\u5e38\\u89c1\\u95ee\\u9898\",\"de\":\"H\\u00e4ufig gestellte Fragen\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(6, 'greenship', 'home_news_title', 'section_home_blog', '{\"en\":\"Company News\",\"fr\":\"Nouvelles de la soci\\u00e9t\\u00e9\",\"es\":\"Noticias de la compa\\u00f1\\u00eda\",\"zh\":\"\\u516c\\u53f8\\u65b0\\u95fb\",\"de\":\"Unternehmens Nachrichten\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(7, 'greenship', 'home_news_desc', 'section_home_blog', '{\"en\":\"From the blog\",\"fr\":\"Du blog\",\"es\":\"Desde el blog\",\"zh\":\"\\u6765\\u81ea\\u535a\\u5ba2\",\"de\":\"Von dem Blog\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(8, 'greenship', 'home_partner_title', 'section_home_partner', '{\"en\":\"Over 20+ Carriers Worldwide\",\"fr\":\"Plus de 60+ transporteurs dans le monde\",\"es\":\"M\\u00e1s de 60 operadores en todo el mundo\",\"zh\":\"\\u5168\\u7403 60 \\u591a\\u5bb6\\u8fd0\\u8425\\u5546\",\"de\":\"\\u00dcber 60 Spediteure weltweit\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(9, 'greenship', 'home_partner_desc', 'section_home_partner', '{\"en\":\"We partner with over 60+ global carriers and dozens of top store platforms so that you can get started immediately.\",\"fr\":\"Nous travaillons en partenariat avec plus de 60 op\\u00e9rateurs mondiaux et des dizaines de plateformes de magasins de premier plan afin que vous puissiez commencer imm\\u00e9diatement.\",\"es\":\"Nos asociamos con m\\u00e1s de 60 operadores globales y docenas de las principales plataformas de tiendas para que pueda comenzar de inmediato.\",\"zh\":\"\\u6211\\u4eec\\u4e0e 60 \\u591a\\u5bb6\\u5168\\u7403\\u8fd0\\u8425\\u5546\\u548c\\u6570\\u5341\\u5bb6\\u9876\\u7ea7\\u5546\\u5e97\\u5e73\\u53f0\\u5408\\u4f5c\\uff0c\\u8ba9\\u60a8\\u53ef\\u4ee5\\u7acb\\u5373\\u5f00\\u59cb\\u4f7f\\u7528\\u3002\",\"de\":\"Wir arbeiten mit \\u00fcber 60 globalen Spediteuren und Dutzenden von Top-Store-Plattformen zusammen, damit Sie sofort loslegen k\\u00f6nnen.\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(10, 'greenship', 'home_partner_btn', 'section_home_partner', '{\"en\":\"Explore\",\"fr\":\"Explorer\",\"es\":\"Explorar\",\"zh\":\"\\u63a2\\u7d22\",\"de\":\"Erkunden\"}', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(12, 'greenship', 'styling_secondary_color_code', 'styling_secondary_color', '#ffffff', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(13, 'greenship', 'styling_primary_color_code', 'styling_primary_color', '#2B8B10', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(14, 'greenship', 'logo_main', 'site_logo_main', 'assets/img/logo_main.png', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(15, 'greenship', 'logo_dashboard', 'site_logo_dashboard', 'assets/img/logo_dashboard.png', '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(16, 'greenship', 'custom_css_code', 'custom_css', NULL, '2023-02-01 14:26:53', '2023-02-01 14:26:53'),
(17, 'greenship', 'custom_js_code', 'custom_js', '', '2023-02-01 14:26:53', '2023-02-01 14:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` bigint(20) NOT NULL,
  `theme` varchar(20) NOT NULL,
  `config_key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `theme`, `config_key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'greenship', 'menu_item_service', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(2, 'greenship', 'menu_item_contact', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(3, 'greenship', 'menu_item_tracking', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(4, 'greenship', 'section_home_hero', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(6, 'greenship', 'section_home_blog', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(7, 'greenship', 'section_home_service', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(8, 'greenship', 'section_home_partner', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(9, 'greenship', 'section_home_faq', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(10, 'greenship', 'section_home_counter', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(11, 'greenship', 'menu_item_phone', 'enabled', '2023-02-01 10:24:54', '2023-02-01 10:24:54'),
(14, 'greenship', 'menu_item_email', 'enabled', '2023-02-18 20:18:17', '2023-02-18 20:18:17'),
(15, 'greenship', 'footer_section_tracking', 'enabled', '2023-02-18 20:19:14', '2023-02-18 20:19:14'),
(16, 'greenship', 'footer_section_service', 'enabled', '2023-02-18 20:19:18', '2023-02-18 20:19:18'),
(17, 'greenship', 'footer_section_link', 'enabled', '2023-02-18 20:19:22', '2023-02-18 20:19:22'),
(18, 'greenship', 'footer_section_contact', 'enabled', '2023-02-18 20:19:25', '2023-02-18 20:19:25'),
(19, 'greenship', 'footer_section_copyright', 'enabled', '2023-02-18 20:19:29', '2023-02-18 20:19:29'),
(21, 'greenship', 'styling_primary_color', 'enabled', '2023-02-18 20:42:39', '2023-02-18 20:42:39'),
(22, 'greenship', 'styling_secondary_color', 'disable', '2023-02-18 20:42:43', '2023-02-18 20:42:43'),
(23, 'greenship', 'site_logo_main', 'enabled', '2023-02-18 22:23:41', '2023-02-18 22:23:41'),
(24, 'greenship', 'site_logo_dashboard', 'enabled', '2023-02-18 22:24:21', '2023-02-18 22:24:21'),
(25, 'greenship', 'menu_item_login', 'enabled', '2023-02-18 22:50:04', '2023-02-18 22:50:04'),
(26, 'greenship', 'menu_item_language', 'enabled', '2023-02-18 22:51:52', '2023-02-18 22:51:52'),
(27, 'greenship', 'custom_css', 'disable', '2023-02-19 00:18:31', '2023-02-19 00:18:31'),
(28, 'greenship', 'custom_js', 'disable', '2023-02-19 00:18:39', '2023-02-19 00:18:39');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Asia/Kabul', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(2, 2, 'Europe/Mariehamn', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(3, 3, 'Europe/Tirane', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(4, 4, 'Africa/Algiers', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(5, 5, 'Pacific/Pago_Pago', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(6, 6, 'Europe/Andorra', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(7, 7, 'Africa/Luanda', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(8, 8, 'America/Anguilla', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(9, 9, 'Antarctica/Casey', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(10, 9, 'Antarctica/Davis', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(11, 9, 'Antarctica/DumontDUrville', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(12, 9, 'Antarctica/Mawson', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(13, 9, 'Antarctica/McMurdo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(14, 9, 'Antarctica/Palmer', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(15, 9, 'Antarctica/Rothera', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(16, 9, 'Antarctica/Syowa', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(17, 9, 'Antarctica/Troll', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(18, 9, 'Antarctica/Vostok', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(19, 10, 'America/Antigua', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(20, 11, 'America/Argentina/Buenos_Aires', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(21, 11, 'America/Argentina/Catamarca', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(22, 11, 'America/Argentina/Cordoba', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(23, 11, 'America/Argentina/Jujuy', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(24, 11, 'America/Argentina/La_Rioja', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(25, 11, 'America/Argentina/Mendoza', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(26, 11, 'America/Argentina/Rio_Gallegos', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(27, 11, 'America/Argentina/Salta', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(28, 11, 'America/Argentina/San_Juan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(29, 11, 'America/Argentina/San_Luis', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(30, 11, 'America/Argentina/Tucuman', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(31, 11, 'America/Argentina/Ushuaia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(32, 12, 'Asia/Yerevan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(33, 13, 'America/Aruba', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(34, 14, 'Antarctica/Macquarie', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(35, 14, 'Australia/Adelaide', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(36, 14, 'Australia/Brisbane', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(37, 14, 'Australia/Broken_Hill', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(38, 14, 'Australia/Currie', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(39, 14, 'Australia/Darwin', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(40, 14, 'Australia/Eucla', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(41, 14, 'Australia/Hobart', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(42, 14, 'Australia/Lindeman', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(43, 14, 'Australia/Lord_Howe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(44, 14, 'Australia/Melbourne', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(45, 14, 'Australia/Perth', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(46, 14, 'Australia/Sydney', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(47, 15, 'Europe/Vienna', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(48, 16, 'Asia/Baku', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(49, 17, 'Asia/Bahrain', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(50, 18, 'Asia/Dhaka', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(51, 19, 'America/Barbados', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(52, 20, 'Europe/Minsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(53, 21, 'Europe/Brussels', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(54, 22, 'America/Belize', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(55, 23, 'Africa/Porto-Novo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(56, 24, 'Atlantic/Bermuda', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(57, 25, 'Asia/Thimphu', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(58, 26, 'America/La_Paz', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(59, 27, 'America/Anguilla', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(60, 28, 'Europe/Sarajevo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(61, 29, 'Africa/Gaborone', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(62, 30, 'Europe/Oslo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(63, 31, 'America/Araguaina', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(64, 31, 'America/Bahia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(65, 31, 'America/Belem', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(66, 31, 'America/Boa_Vista', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(67, 31, 'America/Campo_Grande', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(68, 31, 'America/Cuiaba', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(69, 31, 'America/Eirunepe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(70, 31, 'America/Fortaleza', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(71, 31, 'America/Maceio', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(72, 31, 'America/Manaus', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(73, 31, 'America/Noronha', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(74, 31, 'America/Porto_Velho', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(75, 31, 'America/Recife', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(76, 31, 'America/Rio_Branco', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(77, 31, 'America/Santarem', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(78, 31, 'America/Sao_Paulo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(79, 32, 'Indian/Chagos', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(80, 33, 'Asia/Brunei', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(81, 34, 'Europe/Sofia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(82, 35, 'Africa/Ouagadougou', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(83, 36, 'Africa/Bujumbura', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(84, 37, 'Asia/Phnom_Penh', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(85, 38, 'Africa/Douala', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(86, 39, 'America/Atikokan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(87, 39, 'America/Blanc-Sablon', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(88, 39, 'America/Cambridge_Bay', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(89, 39, 'America/Creston', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(90, 39, 'America/Dawson', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(91, 39, 'America/Dawson_Creek', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(92, 39, 'America/Edmonton', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(93, 39, 'America/Fort_Nelson', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(94, 39, 'America/Glace_Bay', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(95, 39, 'America/Goose_Bay', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(96, 39, 'America/Halifax', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(97, 39, 'America/Inuvik', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(98, 39, 'America/Iqaluit', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(99, 39, 'America/Moncton', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(100, 39, 'America/Nipigon', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(101, 39, 'America/Pangnirtung', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(102, 39, 'America/Rainy_River', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(103, 39, 'America/Rankin_Inlet', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(104, 39, 'America/Regina', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(105, 39, 'America/Resolute', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(106, 39, 'America/St_Johns', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(107, 39, 'America/Swift_Current', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(108, 39, 'America/Thunder_Bay', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(109, 39, 'America/Toronto', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(110, 39, 'America/Vancouver', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(111, 39, 'America/Whitehorse', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(112, 39, 'America/Winnipeg', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(113, 39, 'America/Yellowknife', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(114, 40, 'Atlantic/Cape_Verde', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(115, 41, 'America/Cayman', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(116, 42, 'Africa/Bangui', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(117, 43, 'Africa/Ndjamena', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(118, 44, 'America/Punta_Arenas', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(119, 44, 'America/Santiago', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(120, 44, 'Pacific/Easter', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(121, 45, 'Asia/Shanghai', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(122, 45, 'Asia/Urumqi', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(123, 46, 'Indian/Christmas', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(124, 47, 'Indian/Cocos', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(125, 48, 'America/Bogota', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(126, 49, 'Indian/Comoro', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(127, 50, 'Africa/Brazzaville', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(128, 51, 'Pacific/Rarotonga', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(129, 52, 'America/Costa_Rica', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(130, 53, 'Africa/Abidjan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(131, 54, 'Europe/Zagreb', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(132, 55, 'America/Havana', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(133, 56, 'America/Curacao', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(134, 57, 'Asia/Famagusta', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(135, 57, 'Asia/Nicosia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(136, 58, 'Europe/Prague', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(137, 59, 'Africa/Kinshasa', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(138, 59, 'Africa/Lubumbashi', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(139, 60, 'Europe/Copenhagen', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(140, 61, 'Africa/Djibouti', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(141, 62, 'America/Dominica', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(142, 63, 'America/Santo_Domingo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(143, 64, 'Asia/Dili', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(144, 65, 'America/Guayaquil', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(145, 65, 'Pacific/Galapagos', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(146, 66, 'Africa/Cairo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(147, 67, 'America/El_Salvador', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(148, 68, 'Africa/Malabo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(149, 69, 'Africa/Asmara', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(150, 70, 'Europe/Tallinn', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(151, 71, 'Africa/Addis_Ababa', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(152, 72, 'Atlantic/Stanley', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(153, 73, 'Atlantic/Faroe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(154, 74, 'Pacific/Fiji', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(155, 75, 'Europe/Helsinki', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(156, 76, 'Europe/Paris', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(157, 77, 'America/Cayenne', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(158, 78, 'Pacific/Gambier', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(159, 78, 'Pacific/Marquesas', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(160, 78, 'Pacific/Tahiti', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(161, 79, 'Indian/Kerguelen', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(162, 80, 'Africa/Libreville', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(163, 81, 'Africa/Banjul', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(164, 82, 'Asia/Tbilisi', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(165, 83, 'Europe/Berlin', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(166, 83, 'Europe/Busingen', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(167, 84, 'Africa/Accra', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(168, 85, 'Europe/Gibraltar', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(169, 86, 'Europe/Athens', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(170, 87, 'America/Danmarkshavn', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(171, 87, 'America/Nuuk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(172, 87, 'America/Scoresbysund', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(173, 87, 'America/Thule', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(174, 88, 'America/Grenada', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(175, 89, 'America/Guadeloupe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(176, 90, 'Pacific/Guam', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(177, 91, 'America/Guatemala', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(178, 92, 'Europe/Guernsey', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(179, 93, 'Africa/Conakry', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(180, 94, 'Africa/Bissau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(181, 95, 'America/Guyana', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(182, 96, 'America/Port-au-Prince', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(183, 97, 'Indian/Kerguelen', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(184, 98, 'America/Tegucigalpa', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(185, 99, 'Asia/Hong_Kong', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(186, 100, 'Europe/Budapest', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(187, 101, 'Atlantic/Reykjavik', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(188, 102, 'Asia/Kolkata', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(189, 103, 'Asia/Jakarta', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(190, 103, 'Asia/Jayapura', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(191, 103, 'Asia/Makassar', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(192, 103, 'Asia/Pontianak', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(193, 104, 'Asia/Tehran', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(194, 105, 'Asia/Baghdad', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(195, 106, 'Europe/Dublin', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(196, 107, 'Asia/Jerusalem', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(197, 108, 'Europe/Rome', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(198, 109, 'America/Jamaica', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(199, 110, 'Asia/Tokyo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(200, 111, 'Europe/Jersey', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(201, 112, 'Asia/Amman', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(202, 113, 'Asia/Almaty', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(203, 113, 'Asia/Aqtau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(204, 113, 'Asia/Aqtobe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(205, 113, 'Asia/Atyrau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(206, 113, 'Asia/Oral', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(207, 113, 'Asia/Qostanay', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(208, 113, 'Asia/Qyzylorda', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(209, 114, 'Africa/Nairobi', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(210, 115, 'Pacific/Enderbury', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(211, 115, 'Pacific/Kiritimati', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(212, 115, 'Pacific/Tarawa', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(213, 116, 'Europe/Belgrade', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(214, 117, 'Asia/Kuwait', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(215, 118, 'Asia/Bishkek', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(216, 119, 'Asia/Vientiane', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(217, 120, 'Europe/Riga', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(218, 121, 'Asia/Beirut', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(219, 122, 'Africa/Maseru', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(220, 123, 'Africa/Monrovia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(221, 124, 'Africa/Tripoli', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(222, 125, 'Europe/Vaduz', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(223, 126, 'Europe/Vilnius', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(224, 127, 'Europe/Luxembourg', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(225, 128, 'Asia/Macau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(226, 129, 'Europe/Skopje', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(227, 130, 'Indian/Antananarivo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(228, 131, 'Africa/Blantyre', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(229, 132, 'Asia/Kuala_Lumpur', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(230, 132, 'Asia/Kuching', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(231, 133, 'Indian/Maldives', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(232, 134, 'Africa/Bamako', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(233, 135, 'Europe/Malta', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(234, 136, 'Europe/Isle_of_Man', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(235, 137, 'Pacific/Kwajalein', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(236, 137, 'Pacific/Majuro', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(237, 138, 'America/Martinique', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(238, 139, 'Africa/Nouakchott', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(239, 140, 'Indian/Mauritius', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(240, 141, 'Indian/Mayotte', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(241, 142, 'America/Bahia_Banderas', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(242, 142, 'America/Cancun', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(243, 142, 'America/Chihuahua', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(244, 142, 'America/Hermosillo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(245, 142, 'America/Matamoros', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(246, 142, 'America/Mazatlan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(247, 142, 'America/Merida', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(248, 142, 'America/Mexico_City', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(249, 142, 'America/Monterrey', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(250, 142, 'America/Ojinaga', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(251, 142, 'America/Tijuana', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(252, 143, 'Pacific/Chuuk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(253, 143, 'Pacific/Kosrae', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(254, 143, 'Pacific/Pohnpei', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(255, 144, 'Europe/Chisinau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(256, 145, 'Europe/Monaco', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(257, 146, 'Asia/Choibalsan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(258, 146, 'Asia/Hovd', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(259, 146, 'Asia/Ulaanbaatar', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(260, 147, 'Europe/Podgorica', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(261, 148, 'America/Montserrat', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(262, 149, 'Africa/Casablanca', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(263, 150, 'Africa/Maputo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(264, 151, 'Asia/Yangon', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(265, 152, 'Africa/Windhoek', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(266, 153, 'Pacific/Nauru', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(267, 154, 'Asia/Kathmandu', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(268, 155, 'Europe/Amsterdam', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(269, 156, 'Pacific/Noumea', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(270, 157, 'Pacific/Auckland', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(271, 157, 'Pacific/Chatham', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(272, 158, 'America/Managua', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(273, 159, 'Africa/Niamey', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(274, 160, 'Africa/Lagos', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(275, 161, 'Pacific/Niue', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(276, 162, 'Pacific/Norfolk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(277, 163, 'Asia/Pyongyang', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(278, 164, 'Pacific/Saipan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(279, 165, 'Europe/Oslo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(280, 166, 'Asia/Muscat', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(281, 167, 'Asia/Karachi', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(282, 168, 'Pacific/Palau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(283, 169, 'Asia/Gaza', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(284, 169, 'Asia/Hebron', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(285, 170, 'America/Panama', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(286, 171, 'Pacific/Bougainville', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(287, 171, 'Pacific/Port_Moresby', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(288, 172, 'America/Asuncion', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(289, 173, 'America/Lima', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(290, 174, 'Asia/Manila', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(291, 175, 'Pacific/Pitcairn', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(292, 176, 'Europe/Warsaw', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(293, 177, 'Atlantic/Azores', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(294, 177, 'Atlantic/Madeira', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(295, 177, 'Europe/Lisbon', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(296, 178, 'America/Puerto_Rico', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(297, 179, 'Asia/Qatar', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(298, 180, 'Indian/Reunion', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(299, 181, 'Europe/Bucharest', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(300, 182, 'Asia/Anadyr', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(301, 182, 'Asia/Barnaul', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(302, 182, 'Asia/Chita', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(303, 182, 'Asia/Irkutsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(304, 182, 'Asia/Kamchatka', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(305, 182, 'Asia/Khandyga', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(306, 182, 'Asia/Krasnoyarsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(307, 182, 'Asia/Magadan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(308, 182, 'Asia/Novokuznetsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(309, 182, 'Asia/Novosibirsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(310, 182, 'Asia/Omsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(311, 182, 'Asia/Sakhalin', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(312, 182, 'Asia/Srednekolymsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(313, 182, 'Asia/Tomsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(314, 182, 'Asia/Ust-Nera', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(315, 182, 'Asia/Vladivostok', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(316, 182, 'Asia/Yakutsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(317, 182, 'Asia/Yekaterinburg', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(318, 182, 'Europe/Astrakhan', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(319, 182, 'Europe/Kaliningrad', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(320, 182, 'Europe/Kirov', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(321, 182, 'Europe/Moscow', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(322, 182, 'Europe/Samara', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(323, 182, 'Europe/Saratov', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(324, 182, 'Europe/Ulyanovsk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(325, 182, 'Europe/Volgograd', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(326, 183, 'Africa/Kigali', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(327, 184, 'Atlantic/St_Helena', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(328, 185, 'America/St_Kitts', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(329, 186, 'America/St_Lucia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(330, 187, 'America/Miquelon', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(331, 188, 'America/St_Vincent', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(332, 189, 'America/St_Barthelemy', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(333, 190, 'America/Marigot', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(334, 191, 'Pacific/Apia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(335, 192, 'Europe/San_Marino', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(336, 193, 'Africa/Sao_Tome', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(337, 194, 'Asia/Riyadh', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(338, 195, 'Africa/Dakar', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(339, 196, 'Europe/Belgrade', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(340, 197, 'Indian/Mahe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(341, 198, 'Africa/Freetown', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(342, 199, 'Asia/Singapore', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(343, 200, 'America/Anguilla', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(344, 201, 'Europe/Bratislava', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(345, 202, 'Europe/Ljubljana', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(346, 203, 'Pacific/Guadalcanal', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(347, 204, 'Africa/Mogadishu', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(348, 205, 'Africa/Johannesburg', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(349, 206, 'Atlantic/South_Georgia', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(350, 207, 'Asia/Seoul', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(351, 208, 'Africa/Juba', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(352, 209, 'Africa/Ceuta', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(353, 209, 'Atlantic/Canary', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(354, 209, 'Europe/Madrid', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(355, 210, 'Asia/Colombo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(356, 211, 'Africa/Khartoum', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(357, 212, 'America/Paramaribo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(358, 213, 'Arctic/Longyearbyen', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(359, 214, 'Africa/Mbabane', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(360, 215, 'Europe/Stockholm', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(361, 216, 'Europe/Zurich', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(362, 217, 'Asia/Damascus', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(363, 218, 'Asia/Taipei', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(364, 219, 'Asia/Dushanbe', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(365, 220, 'Africa/Dar_es_Salaam', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(366, 221, 'Asia/Bangkok', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(367, 222, 'America/Nassau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(368, 223, 'Africa/Lome', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(369, 224, 'Pacific/Fakaofo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(370, 225, 'Pacific/Tongatapu', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(371, 226, 'America/Port_of_Spain', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(372, 227, 'Africa/Tunis', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(373, 228, 'Europe/Istanbul', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(374, 229, 'Asia/Ashgabat', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(375, 230, 'America/Grand_Turk', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(376, 231, 'Pacific/Funafuti', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(377, 232, 'Africa/Kampala', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(378, 233, 'Europe/Kiev', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(379, 233, 'Europe/Simferopol', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(380, 233, 'Europe/Uzhgorod', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(381, 233, 'Europe/Zaporozhye', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(382, 234, 'Asia/Dubai', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(383, 235, 'Europe/London', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(384, 236, 'America/Adak', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(385, 236, 'America/Anchorage', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(386, 236, 'America/Boise', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(387, 236, 'America/Chicago', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(388, 236, 'America/Denver', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(389, 236, 'America/Detroit', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(390, 236, 'America/Indiana/Indianapolis', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(391, 236, 'America/Indiana/Knox', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(392, 236, 'America/Indiana/Marengo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(393, 236, 'America/Indiana/Petersburg', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(394, 236, 'America/Indiana/Tell_City', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(395, 236, 'America/Indiana/Vevay', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(396, 236, 'America/Indiana/Vincennes', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(397, 236, 'America/Indiana/Winamac', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(398, 236, 'America/Juneau', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(399, 236, 'America/Kentucky/Louisville', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(400, 236, 'America/Kentucky/Monticello', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(401, 236, 'America/Los_Angeles', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(402, 236, 'America/Menominee', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(403, 236, 'America/Metlakatla', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(404, 236, 'America/New_York', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(405, 236, 'America/Nome', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(406, 236, 'America/North_Dakota/Beulah', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(407, 236, 'America/North_Dakota/Center', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(408, 236, 'America/North_Dakota/New_Salem', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(409, 236, 'America/Phoenix', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(410, 236, 'America/Sitka', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(411, 236, 'America/Yakutat', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(412, 236, 'Pacific/Honolulu', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(413, 237, 'Pacific/Midway', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(414, 237, 'Pacific/Wake', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(415, 238, 'America/Montevideo', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(416, 239, 'Asia/Samarkand', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(417, 239, 'Asia/Tashkent', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(418, 240, 'Pacific/Efate', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(419, 241, 'Europe/Vatican', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(420, 242, 'America/Caracas', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(421, 243, 'Asia/Ho_Chi_Minh', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(422, 244, 'America/Tortola', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(423, 245, 'America/St_Thomas', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(424, 246, 'Pacific/Wallis', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(425, 247, 'Africa/El_Aaiun', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(426, 248, 'Asia/Aden', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(427, 249, 'Africa/Lusaka', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(428, 250, 'Africa/Harare', '2023-02-05 21:38:31', '2023-02-05 21:38:31'),
(430, 0, 'UTC', '2023-02-05 21:38:31', '2023-02-05 21:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` tinyint(5) DEFAULT '0',
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_status` tinyint(2) NOT NULL DEFAULT '0',
  `email` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_status` tinyint(1) NOT NULL DEFAULT '0',
  `email_notification` tinyint(1) NOT NULL DEFAULT '1',
  `sms_notification` tinyint(1) NOT NULL DEFAULT '0',
  `site_notification` tinyint(1) NOT NULL DEFAULT '1',
  `shipment_notification` tinyint(3) NOT NULL DEFAULT '0',
  `invoice_notification` tinyint(3) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `branch` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_by` int(11) NOT NULL DEFAULT '0',
  `two_factor` tinyint(1) NOT NULL DEFAULT '0',
  `language` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `username`, `firstname`, `lastname`, `phone`, `phone_status`, `email`, `email_status`, `email_notification`, `sms_notification`, `site_notification`, `shipment_notification`, `invoice_notification`, `password`, `remember_token`, `country`, `currency`, `avatar`, `address`, `branch`, `status`, `token`, `ref_by`, `two_factor`, `language`, `timezone`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 5, 'admin', 'Endy', 'Code', '+1234567890', 1, 'admin@example.com', 1, 1, 0, 0, 1, 0, '$2y$10$m3Dwwr16f5srVCXmBgnuEeoEqaFOUphxBKeIWM1BTnOnkDoKKF43y', 'wAX6L1Mn7wIWiPBUSax9kqDklyKYSpBGA0sCaz3QguLxnqBBG1ELaHRgrHWN', '160', 'USD', NULL, NULL, NULL, 1, '', 0, 0, 'en', 'UTC', NULL, '2022-12-29 01:19:36', '2023-03-21 15:58:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_id` (`country_id`);

--
-- Indexes for table `exchange_rates`
--
ALTER TABLE `exchange_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_slug` (`post_slug`);

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `shipment_log`
--
ALTER TABLE `shipment_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_package`
--
ALTER TABLE `shipment_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_cost`
--
ALTER TABLE `shipping_cost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_type` (`site_key`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `theme_contents`
--
ALTER TABLE `theme_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `exchange_rates`
--
ALTER TABLE `exchange_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_category`
--
ALTER TABLE `post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_log`
--
ALTER TABLE `shipment_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_package`
--
ALTER TABLE `shipment_package`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_cost`
--
ALTER TABLE `shipping_cost`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `theme_contents`
--
ALTER TABLE `theme_contents`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
