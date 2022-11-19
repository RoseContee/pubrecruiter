-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2022 at 02:31 PM
-- Server version: 10.3.36-MariaDB-log-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `senikvjs_extension`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.com', NULL, '$2y$10$hAGYWe5ViWjIb90ysy3oiusqxzjltWoUE5nuItzUEsvtYkrRFWMxi', 'OzkxhNKBwxOs9BOILzcgp5bCf9IQXxNVXzCyvFHqsLPKHjgSAOQMF8NrxIWy', '2022-03-10 06:34:33', '2022-03-10 06:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blacklists`
--

CREATE TABLE `blacklists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `owner_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Creator','Brand') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Brand',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_id` int(11) DEFAULT NULL,
  `network` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `network_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission` float DEFAULT NULL,
  `commission_type` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclusive_deal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offers` tinyint(1) NOT NULL DEFAULT 0,
  `posts` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `owner_id`, `owner_type`, `type`, `name`, `email`, `website`, `domain`, `logo`, `network_id`, `network`, `network_link`, `tags`, `commission`, `commission_type`, `commission_unit`, `exclusive_deal`, `offers`, `posts`, `featured`, `active`, `created_at`, `updated_at`) VALUES
(3, 1, 'App\\Models\\Admin', 'Brand', 'Greenlight', 'breanna.warren@greenlight.me', 'https://greenlight.com/', 'greenlight.com', 'uploads/brands/2TbDMYLFlWiM5t8VHZVb6XwauAplpzGxhPrUmRhV.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Finance, Kids', 40, '$', 'Per Card Sign Up', '', 0, 0, 1, 1, '2022-06-07 09:05:26', '2022-09-09 22:05:18'),
(47, 4, 'App\\Models\\User', 'Brand', 'Fiverr', 'limmor.kfiri@fiverr.com', 'https://www.fiverr.com/', 'www.fiverr.com', 'uploads/brands/cdbVpGuJlO8uNwMcQDF2pKSDGRet6YbXgs7N2YpP.png', 1, 'ShareASale', 'https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}', 'Services, Freelancer', 15, '$', 'First Time Buyers', '', 0, 0, 1, 1, '2022-07-18 01:34:16', '2022-08-23 19:41:11'),
(48, 5, 'App\\Models\\User', 'Brand', 'Partnerality', 'galen@partnerality.com', 'http://partnerality.com', 'partnerality.com', 'uploads/brands/ieu0QlVTjZpJANqqiRaZXc9vff28lo9WoVKLanY8.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Affiliate Service', NULL, '$', 'Per Sale', NULL, 0, 0, 0, 0, '2022-07-18 10:54:08', '2022-07-19 04:54:52'),
(51, 6, 'App\\Models\\User', 'Brand', 'Sharper Image', 'mfernandes@sharperimageonline.com', 'https://www.sharperImage.com', 'www.sharperImage.com', 'uploads/brands/ZlOwNCH2ZaNI1Ku1KudLe4sZANxKLyV3KERx03pM.jpg', 5, 'Rakuten', 'https://rakutenadvertising.com/', 'Electronics, Technology', 2, '%', 'Per Sale', NULL, 0, 0, 0, 1, '2022-07-28 08:30:38', '2022-07-28 09:27:42'),
(52, 7, 'App\\Models\\User', 'Creator', 'The Budget Savvy Bride', 'jessica@thebudgetsavvybride.com', 'https://thebudgetsavvybride.com', 'thebudgetsavvybride.com', NULL, NULL, NULL, NULL, 'Home, Finance', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2022-08-03 04:50:20', '2022-09-12 18:06:15'),
(53, 8, 'App\\Models\\User', 'Brand', 'HoneyBricks', 'jack.aldridge@honeybricks.com', 'https://www.honeybricks.com/', 'www.honeybricks.com', 'uploads/brands/FkiNnbGFx7lVAlIUrdi6LVfRwFfkSrDgRfzw3jVg.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Real Estate, Crypto', 50, '$', 'Per Lead', '', 0, 0, 1, 1, '2022-08-06 04:14:52', '2022-08-24 17:38:22'),
(57, 12, 'App\\Models\\User', 'Brand', 'Kikoff', 'steven@kikoff.com', 'https://kikoff.com/', 'kikoff.com', 'uploads/brands/R0fmzp8vEXjIl9r4tYsmTeryjwifyLqMZ2Xw1Jye.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Finance, Credit', 5, '$', 'Per Sign Up', '', 0, 0, 0, 1, '2022-08-18 00:49:01', '2022-08-18 02:30:40'),
(58, 13, 'App\\Models\\User', 'Brand', 'Rocket Money', 'jessica@rocketmoney.com', 'https://www.rocketmoney.com', 'www.rocketmoney.com', 'uploads/brands/4bLUlzA2U31nCHqIpwgSEQTgCam50UIBilWOvRmX.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Finance, Bills', 10, '$', 'Per Account Link', '', 0, 0, 1, 1, '2022-08-24 03:59:02', '2022-09-09 23:04:46'),
(60, 15, 'App\\Models\\User', 'Brand', 'Acorns', 'conor.robbins.contractor@acorns.com', 'https://www.acorns.com/', 'www.acorns.com', 'uploads/brands/WCrNBh7xIVZVr0UKsVF214CCSjjFeGSPrfy01VZU.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Investing, Finance', 10, '$', 'Per Funded Account', '', 0, 0, 0, 1, '2022-08-28 21:56:08', '2022-08-29 18:05:50'),
(62, 17, 'App\\Models\\User', 'Creator', 'Lady Boss Blogger', 'ladybossblogger@gmail.com', 'https://ladybossblogger.com/', 'ladybossblogger.com', NULL, NULL, NULL, NULL, 'Blogging, Entrepreneurship', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2022-09-07 21:46:20', '2022-09-07 21:49:54'),
(64, 19, 'App\\Models\\User', 'Brand', 'Kovo Credit', 'partners@kovocredit.com', 'https://kovocredit.com/', 'kovocredit.com', 'uploads/brands/9Pf6z4xDgjPKoBx5OVmq4WJSBtqFUqUcVFaIhEyS.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Credit Builder, Finance', 60, '$', 'Per Qualified Lead', '', 0, 0, 0, 1, '2022-09-08 19:43:44', '2022-09-08 19:45:56'),
(65, 20, 'App\\Models\\User', 'Creator', 'Financial Panther', 'kevin@financialpanther.com', 'https://financialpanther.com/', 'financialpanther.com', NULL, NULL, NULL, NULL, 'Side Hustle, Money', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2022-09-09 00:00:03', '2022-09-09 22:05:50'),
(66, 21, 'App\\Models\\User', 'Creator', 'Broke Girl Rich', 'brokeGIRLrich@gmail.com', 'https://brokegirlrich.com/', 'brokegirlrich.com', NULL, NULL, NULL, NULL, 'Debt, Finance', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2022-09-09 02:46:49', '2022-09-09 22:01:45'),
(67, 22, 'App\\Models\\User', 'Creator', 'Eluxe Magazine', 'chere@eluxemagazine.com', 'https://eluxemagazine.com/', 'eluxemagazine.com', NULL, NULL, NULL, NULL, 'Fashion, Women', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2022-09-12 17:24:09', '2022-09-12 18:05:16'),
(68, 23, 'App\\Models\\User', 'Creator', 'Mommy Gone Healthy', 'amberbattishill@gmail.com', 'https://mommygonehealthy.com/', 'mommygonehealthy.com', NULL, NULL, NULL, NULL, 'DIY, Home', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2022-09-12 18:16:05', '2022-09-12 18:34:44'),
(70, 25, 'App\\Models\\User', 'Brand', 'Hatch', 'caroline@hatchbaby.com', 'https://www.hatch.co/', 'www.hatch.co', 'uploads/brands/w8uyMiD6IcqAxIj4TPqYKv4VQnIJX2PO6dFOFPGS.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Baby, Home', 7, '%', 'Per Sale', '', 0, 0, 0, 1, '2022-09-15 21:54:43', '2022-09-15 21:55:46'),
(71, 26, 'App\\Models\\User', 'Brand', 'Test Brand', 'testbrand@pubrecruiter.com', 'https://testbrand.com', 'dan.com', NULL, 4, 'AWIN', 'https://www.awin1.com/awclick.php?gid=171448&mid=4032&awinaffid=1072681&linkid=362688&clickref=', NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, '2022-09-16 18:00:00', '2022-10-14 20:02:26'),
(72, 27, 'App\\Models\\User', 'Brand', 'Neighbor', 'affiliates@neighbor.com', 'https://www.neighbor.com/', 'www.neighbor.com', 'uploads/brands/OEiBWgWpgaXkfncKpzkt80n9X1x3ZrqNFnNIE2i8.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Side Hustle, Storage', 40, '$', 'Per New Listing', '', 0, 0, 1, 1, '2022-09-19 18:13:43', '2022-09-19 18:16:33'),
(74, 29, 'App\\Models\\User', 'Brand', 'Survey Junkie', 'devon.n@surveyjunkie.com', 'https://www.surveyjunkie.com/', 'www.surveyjunkie.com', 'uploads/brands/WWiH6hZAGDrfFonfuKca5lyoIQZFEKYYf4HhwddQ.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Surveys, Side Hustle', 1, '$', 'Per Sign Up', '', 0, 0, 0, 1, '2022-09-19 18:20:03', '2022-09-20 21:20:07'),
(76, 31, 'App\\Models\\User', 'Brand', 'Little Passports', 'danielle.hernandez@homerlearning.com', 'https://www.littlepassports.com/', 'www.littlepassports.com', 'uploads/brands/hcK2yRX2ktkLuOxW6n27yfStqIl4yI2293juGbGT.png', 2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', 'Children, Education', 20, '$', 'Per Sign Up', '', 0, 0, 0, 1, '2022-10-13 21:21:53', '2022-10-14 20:14:17'),
(77, 32, 'App\\Models\\User', 'Brand', 'meowcards', 'hubbledamon246@gmail.com', 'https://www.amazon.com/stores/Meowcards/page/F76570C9-E725-4407-B2A6-9DA0B35E57C8?ref_=ast_bln', 'www.amazon.com', 'uploads/brands/LVsvtOu6vdpVJhA88NRAZA0u7uWdvHQRT5KXXZcs.jpg', 8, 'Amazon Associates', 'https://affiliate-program.amazon.com/', 'Baby, Children', 1, '%', 'Per Sale', '', 0, 0, 0, 1, '2022-10-26 13:17:24', '2022-10-26 19:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `contact_metrics`
--

CREATE TABLE `contact_metrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `metric_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_metrics`
--

INSERT INTO `contact_metrics` (`id`, `contact_id`, `metric_id`, `value`, `number`, `created_at`, `updated_at`) VALUES
(16, 62, 1, '100K', 100000, '2022-09-07 21:47:30', '2022-09-07 21:47:30'),
(17, 62, 2, NULL, NULL, '2022-09-07 21:47:30', '2022-09-07 21:47:30'),
(18, 62, 3, NULL, NULL, '2022-09-07 21:47:30', '2022-09-07 21:47:30'),
(19, 65, 1, '131.2K', 131200, '2022-09-09 00:03:30', '2022-09-09 00:03:30'),
(20, 65, 2, NULL, NULL, '2022-09-09 00:03:30', '2022-09-09 00:03:30'),
(21, 65, 3, NULL, NULL, '2022-09-09 00:03:30', '2022-09-09 00:03:30'),
(22, 66, 1, '25000', 25000, '2022-09-09 02:48:56', '2022-09-09 02:48:56'),
(23, 66, 2, NULL, NULL, '2022-09-09 02:48:56', '2022-09-09 02:48:56'),
(24, 66, 3, NULL, NULL, '2022-09-09 02:48:56', '2022-09-09 02:48:56'),
(25, 67, 1, '227K', 227000, '2022-09-12 17:25:03', '2022-09-12 17:25:03'),
(26, 67, 2, NULL, NULL, '2022-09-12 17:25:03', '2022-09-12 17:25:03'),
(27, 67, 3, NULL, NULL, '2022-09-12 17:25:03', '2022-09-12 17:25:03'),
(28, 52, 1, '239K', 239000, '2022-09-12 18:05:51', '2022-09-12 18:06:15'),
(29, 52, 2, NULL, NULL, '2022-09-12 18:05:51', '2022-09-12 18:05:51'),
(30, 52, 3, NULL, NULL, '2022-09-12 18:05:51', '2022-09-12 18:05:51'),
(31, 68, 1, '10K', 10000, '2022-09-12 18:34:42', '2022-09-12 18:34:42'),
(32, 68, 2, NULL, NULL, '2022-09-12 18:34:42', '2022-09-12 18:34:42'),
(33, 68, 3, NULL, NULL, '2022-09-12 18:34:42', '2022-09-12 18:34:42');

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
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `contact_id`, `created_at`, `updated_at`) VALUES
(46, 2, 52, '2022-08-19 23:41:59', '2022-08-19 23:41:59'),
(48, 9, 47, '2022-08-25 20:40:37', '2022-08-25 20:40:37'),
(49, 26, 66, '2022-09-20 21:11:54', '2022-09-20 21:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_time` tinyint(4) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `domain`, `response_time`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 'www.moneytalksnews.com', 3, 'Based in South Florida, he responds more to deals', '2022-03-24 13:03:46', '2022-03-24 13:03:46'),
(2, 1, 'www.nav.com', 2, NULL, '2022-03-25 11:59:00', '2022-03-25 11:59:00'),
(3, 1, 'www.affinity.solutions', 2, NULL, '2022-03-25 12:01:01', '2022-03-25 12:01:01'),
(4, 1, 'www.paypal.com', 3, NULL, '2022-03-25 12:38:43', '2022-03-25 12:38:43'),
(5, 1, 'www.buzzfeed.com', 3, NULL, '2022-03-25 13:24:22', '2022-03-25 13:24:22'),
(6, 1, 'capitaloneshopping.com', 2, NULL, '2022-03-25 14:21:57', '2022-03-25 14:21:57'),
(7, 1, 'thriftytraveler.com', 3, NULL, '2022-03-26 12:49:14', '2022-03-26 12:49:14'),
(8, 1, 'pubrecruiter.com', 1, 'Hello!', '2022-03-29 14:17:06', '2022-03-30 08:54:32'),
(9, 1, 'www.everflow.io', 1, NULL, '2022-04-01 13:22:20', '2022-04-01 13:22:20'),
(10, 1, 'www.benzinga.com', 2, NULL, '2022-04-05 10:06:43', '2022-04-05 10:06:43'),
(11, 1, 'https://www.youtube.com/channel/UCLr9nHPNpj7U3096nEo8Qfg', 3, NULL, '2022-04-05 10:09:23', '2022-04-05 10:09:23'),
(12, 1, 'dollarflightclub.com', 1, NULL, '2022-04-05 11:40:50', '2022-04-05 11:40:50'),
(13, 1, 'www.nytimes.com', 2, NULL, '2022-04-08 09:41:24', '2022-04-08 09:41:24'),
(14, 1, 'slickdeals.net', 2, NULL, '2022-04-08 18:42:59', '2022-04-08 18:42:59'),
(15, 1, 'www.lemonade.com', 2, NULL, '2022-04-12 14:28:43', '2022-04-12 14:28:43'),
(16, 1, 'www.shopify.com', 3, NULL, '2022-04-12 14:33:14', '2022-04-12 14:33:14'),
(17, 1, 'www.aspiration.com', 2, NULL, '2022-04-13 10:57:09', '2022-04-13 10:57:09'),
(18, 1, 'vape.deals', 3, NULL, '2022-04-13 12:21:08', '2022-04-13 12:21:08'),
(19, 1, 'www.magiclinks.com', 2, NULL, '2022-04-13 12:59:40', '2022-04-13 12:59:40'),
(20, 1, 'cupofjo.com', 3, NULL, '2022-04-13 13:05:25', '2022-04-13 13:05:25'),
(21, 1, 'practicalwanderlust.com', 2, NULL, '2022-04-13 13:10:41', '2022-04-13 13:10:41'),
(22, 1, 'www.mattressclarity.com', 3, NULL, '2022-04-14 15:55:41', '2022-04-14 15:55:41'),
(23, 1, 'www.carefulcents.com', 4, NULL, '2022-04-14 15:59:31', '2022-04-14 15:59:31'),
(24, 1, 'sezzle.com', 3, NULL, '2022-04-14 16:10:58', '2022-04-14 16:10:58'),
(25, 1, 'www.55haitao.com', 2, NULL, '2022-04-14 16:14:09', '2022-04-14 16:14:09'),
(26, 1, 'www.makingsenseofcents.com', 3, NULL, '2022-04-15 12:06:52', '2022-04-15 12:06:52'),
(27, 1, 'readthejoe.com', 2, NULL, '2022-04-20 14:51:49', '2022-04-20 14:51:49'),
(28, 1, 'theplantbasedbeard.com', 2, NULL, '2022-04-21 11:41:15', '2022-04-21 11:41:15'),
(29, 1, 'thesleepdoctor.com', 3, NULL, '2022-04-21 14:28:14', '2022-04-21 14:28:14'),
(30, 1, 'https://www.youtube.com/c/MxRMods', 3, NULL, '2022-04-21 14:32:34', '2022-04-21 14:32:34'),
(31, 1, 'www.investopedia.com', 2, NULL, '2022-04-22 11:26:48', '2022-04-22 11:26:48'),
(32, 1, 'www.sleepfoundation.org', 3, NULL, '2022-04-22 12:34:52', '2022-04-22 12:34:52'),
(33, 1, 'hormonesbalance.com', 2, NULL, '2022-04-22 12:36:07', '2022-04-22 12:36:07'),
(34, 1, 'www.forbes.com', 3, NULL, '2022-04-23 08:49:59', '2022-04-23 08:49:59'),
(35, 1, 'www.passportsandpreemies.com', 2, NULL, '2022-04-26 10:19:41', '2022-04-26 10:19:41'),
(36, 1, 'www.ispyfabulous.com', 2, NULL, '2022-04-26 10:20:44', '2022-04-26 10:20:44'),
(37, 1, 'https://www.instagram.com/dope__kitchen', 2, NULL, '2022-04-26 10:21:52', '2022-04-26 10:21:52'),
(38, 1, 'www.shophermedia.com', 2, NULL, '2022-04-29 11:23:40', '2022-04-29 11:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `metrics`
--

CREATE TABLE `metrics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metrics`
--

INSERT INTO `metrics` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Monthly Visitors', '2022-09-01 23:14:07', '2022-09-01 23:16:43'),
(2, 'Followers', '2022-09-01 23:14:12', '2022-09-01 23:14:49'),
(3, 'YouTube Subs', '2022-09-01 23:15:03', '2022-09-13 23:11:17'),
(4, 'Newsletter Subs', '2022-09-13 23:11:31', '2022-09-13 23:11:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_03_04_180651_create_admins_table', 1),
(6, '2022_03_04_180710_create_contacts_table', 1),
(7, '2022_03_04_182114_create_blacklists_table', 1),
(8, '2022_03_05_203158_create_settings_table', 1),
(9, '2022_03_22_220412_create_feedback_table', 2),
(10, '2022_04_06_172600_create_ads_table', 3),
(11, '2022_04_28_002141_create_outreaches_table', 4),
(12, '2022_05_04_094803_create_networks_table', 5),
(13, '2022_06_09_210036_create_favorites_table', 6),
(14, '2022_07_05_102847_create_nocontacts_table', 7),
(15, '2022_08_02_182012_create_opportunities_table', 8),
(16, '2022_08_24_205915_create_sub_records_table', 9),
(17, '2022_09_01_000501_create_metrics_table', 10),
(18, '2022_09_01_011437_create_contact_metrics_table', 10),
(19, '2022_09_13_213614_create_user_info_table', 11),
(20, '2022_09_13_213817_create_referral_codes_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `networks`
--

CREATE TABLE `networks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `networks`
--

INSERT INTO `networks` (`id`, `name`, `link`, `created_at`, `updated_at`) VALUES
(1, 'ShareASale', 'https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}', '2022-05-05 20:32:42', '2022-08-22 17:22:03'),
(2, 'Impact', 'https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925', '2022-05-05 20:33:31', '2022-06-07 08:58:49'),
(3, 'Refersion', 'https://marketplace.refersion.com/?rfsn=6151486.587a716&utm_source=ambassador&utm_medium=referral&utm_campaign=6151486', '2022-05-05 20:39:04', '2022-06-07 09:10:01'),
(4, 'AWIN', 'https://www.awin1.com/awclick.php?gid=171448&mid=4032&awinaffid=1072681&linkid=362688&clickref=', '2022-05-06 08:36:18', '2022-06-07 09:11:32'),
(5, 'Rakuten', 'https://rakutenadvertising.com/', '2022-05-06 08:37:52', '2022-07-19 04:51:42'),
(6, 'CJ', 'https://signup.cj.com/member/signup/publisher/', '2022-06-07 08:59:17', '2022-06-07 08:59:17'),
(7, 'Partnerize', 'https://signup.partnerize.com/signup/en/phg', '2022-07-20 05:55:53', '2022-07-20 05:55:53'),
(8, 'Amazon Associates', 'https://affiliate-program.amazon.com/', '2022-10-26 19:33:07', '2022-10-26 19:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `nocontacts`
--

CREATE TABLE `nocontacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nocontacts`
--

INSERT INTO `nocontacts` (`id`, `user_id`, `domain`, `created_at`, `updated_at`) VALUES
(1, 5, 'www.goodshop.com', '2022-08-03 02:48:04', '2022-08-03 02:48:04'),
(2, 8, 'realwealth.com', '2022-08-16 19:53:57', '2022-08-16 19:53:57'),
(3, 8, 'goodmenproject.com', '2022-08-18 00:59:56', '2022-08-18 00:59:56'),
(4, 8, 'smartasset.com', '2022-08-18 21:37:33', '2022-08-18 21:37:33'),
(7, 8, 'www.businessinsider.com', '2022-09-20 18:24:50', '2022-09-20 18:24:50'),
(8, 8, 'www.forbes.com', '2022-09-20 18:25:01', '2022-09-20 18:25:01'),
(9, 8, 'www.bloomberg.com', '2022-09-20 18:25:32', '2022-09-20 18:25:32'),
(10, 8, 'www.stakingrewards.com', '2022-09-20 21:24:50', '2022-09-20 21:24:50'),
(11, 8, 'www.therealestatecrowdfundingreview.com', '2022-09-20 21:25:11', '2022-09-20 21:25:11');

-- --------------------------------------------------------

--
-- Table structure for table `opportunities`
--

CREATE TABLE `opportunities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_type` enum('dollar','Contact for Pricing') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Contact for Pricing',
  `cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opportunities`
--

INSERT INTO `opportunities` (`id`, `user_id`, `description`, `cost_type`, `cost`, `created_at`, `updated_at`) VALUES
(4, 17, 'Instagram photo + video post', 'Contact for Pricing', NULL, '2022-09-07 21:48:10', '2022-09-07 21:48:10'),
(5, 17, 'Instagram reel', 'Contact for Pricing', NULL, '2022-09-07 21:48:19', '2022-09-07 21:48:19'),
(6, 17, 'Youtube video', 'Contact for Pricing', NULL, '2022-09-07 21:48:30', '2022-09-07 21:48:30'),
(7, 17, 'TikTok video', 'Contact for Pricing', NULL, '2022-09-07 21:48:37', '2022-09-07 21:48:37'),
(8, 21, 'Sponsored Post with Content Provided by Company', 'dollar', '100', '2022-09-09 02:47:51', '2022-09-09 02:47:51'),
(9, 21, 'Sponsored Post with Content Written by Mel', 'dollar', '200', '2022-09-09 02:48:10', '2022-09-09 02:48:10'),
(10, 22, 'Banner Ads (200x300) 1 Month', 'dollar', '75', '2022-09-12 21:54:40', '2022-09-12 21:54:40'),
(11, 22, 'Sponsored Post', 'dollar', '275', '2022-09-12 21:54:54', '2022-09-12 21:54:54'),
(12, 22, 'Deluxe Competition Giveaway', 'dollar', '175', '2022-09-12 21:55:15', '2022-09-12 21:55:15'),
(13, 22, 'Newsletter Blast', 'dollar', '125', '2022-09-12 21:55:27', '2022-09-12 21:55:27'),
(14, 22, 'Homepage Takeover - 1 Month', 'dollar', '450', '2022-09-12 21:55:44', '2022-09-12 21:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `outreaches`
--

CREATE TABLE `outreaches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `owner_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opportunities` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_sent` tinyint(1) NOT NULL DEFAULT 0,
  `io_date` date DEFAULT NULL,
  `notes` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outreaches`
--

INSERT INTO `outreaches` (`id`, `user_id`, `contact_id`, `owner_id`, `owner_type`, `opportunities`, `payment_sent`, `io_date`, `notes`, `seen`, `created_at`, `updated_at`) VALUES
(26, 8, 52, 7, 'App\\Models\\User', NULL, 0, NULL, NULL, 0, '2022-08-09 04:43:39', '2022-08-09 04:43:39'),
(27, 3, 53, 8, 'App\\Models\\User', NULL, 0, NULL, NULL, 1, '2022-08-10 02:11:02', '2022-08-10 02:13:11'),
(35, 12, 52, 7, 'App\\Models\\User', NULL, 0, NULL, NULL, 0, '2022-08-18 00:49:28', '2022-08-18 00:49:28'),
(58, 9, 47, 4, 'App\\Models\\User', NULL, 0, NULL, NULL, 1, '2022-08-25 20:47:19', '2022-08-31 16:21:40'),
(83, 26, 66, 21, 'App\\Models\\User', '8', 1, NULL, 'Still pending content', 0, '2022-09-16 18:00:56', '2022-09-16 18:06:17'),
(85, 8, 65, 20, 'App\\Models\\User', NULL, 0, NULL, NULL, 0, '2022-09-20 17:54:54', '2022-09-20 17:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `type`, `email`, `token`, `created_at`) VALUES
(1, 'user', 'anatoliydan9@gmail.com', NULL, '2022-03-10 20:10:08'),
(2, 'user', 'todd@pubrecruiter.com', 'zDJuPjOTOYVT7GR6siX14ZSkH99drmUE', '2022-03-11 00:17:15'),
(3, 'user', 'todd@creditcardgamer.com', 'Z2OgYo19CxWCCYHCvAQAwWawuqxdAhu5', '2022-06-06 06:25:28'),
(4, 'user', 'limmor.kfiri@fiverr.com', 'b9LHa3rcAFvhtWmb7kytD41Wdv6SImKi', '2022-08-28 14:52:25'),
(5, 'user', 'brokegirlrich@gmail.com', NULL, '2022-09-09 18:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '96671b80954a2a583ef5136b99bd2d9eba52628498bdf2dcde06113c7c801e86', '[\"*\"]', '2022-08-10 11:06:02', '2022-08-10 05:15:51', '2022-08-10 11:06:02'),
(2, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '1fccedb8aa2e2121dd3ae563e899ddb1b50127f40ba0fd1fb2e52c6be1f50bd7', '[\"*\"]', '2022-08-10 11:09:03', '2022-08-10 11:06:51', '2022-08-10 11:09:03'),
(3, 'App\\Models\\User', 2, 'LaravelSanctumAuth', 'a847f793c078516f3c346403c3b9ee37686d444fb0076b76d35b554758e39eda', '[\"*\"]', '2022-08-10 11:20:45', '2022-08-10 11:20:26', '2022-08-10 11:20:45'),
(4, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '8a3fe137b5c13340f5ce068b5b1bf73afc861a473f2a728f1ddb9a431fd87ef3', '[\"*\"]', '2022-08-10 11:23:11', '2022-08-10 11:23:02', '2022-08-10 11:23:11'),
(5, 'App\\Models\\User', 2, 'LaravelSanctumAuth', 'e253c99f5ed07b5bdd0d8dd46f26bfaac6c0dd6c99b162087610adefa65c84ba', '[\"*\"]', '2022-08-10 22:27:31', '2022-08-10 22:27:15', '2022-08-10 22:27:31'),
(6, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '808c718952c2af29da9214ab548dd926dedc5e5b88a90bd7b05b6ef543ba0f2d', '[\"*\"]', '2022-08-11 06:31:52', '2022-08-11 01:28:19', '2022-08-11 06:31:52'),
(7, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '47d7cbe8241e36245e682cbbbbf6a060972ba2e4d4a30c5e402def7624837da9', '[\"*\"]', '2022-08-15 22:40:13', '2022-08-14 05:18:29', '2022-08-15 22:40:13'),
(8, 'App\\Models\\User', 1, 'LaravelSanctumAuth', '44a818e721bac477816d24b1fbc038ca4669f6a0f990a447cc88f0832dfb1ac5', '[\"*\"]', '2022-08-14 05:30:15', '2022-08-14 05:28:29', '2022-08-14 05:30:15'),
(9, 'App\\Models\\User', 2, 'LaravelSanctumAuth', 'de37c37a5ec19818f1f989432b1f6f1cd471c46ddf257dd8db78bcd69fee322f', '[\"*\"]', '2022-08-15 22:08:01', '2022-08-14 05:30:20', '2022-08-15 22:08:01'),
(10, 'App\\Models\\User', 9, 'LaravelSanctumAuth', '20276a297e1df62b5ee42cd2cea75e641306cd8b5a9abb3592894f1a028acb27', '[\"*\"]', '2022-08-16 19:51:05', '2022-08-15 22:08:11', '2022-08-16 19:51:05'),
(11, 'App\\Models\\User', 8, 'LaravelSanctumAuth', 'b49a00cd8641fed66ab1703980e7d526f7a93984e2e84a52a6dd349f4b6aba5c', '[\"*\"]', '2022-10-26 21:40:09', '2022-08-16 19:53:50', '2022-10-26 21:40:09'),
(12, 'App\\Models\\User', 1, 'LaravelSanctumAuth', '042c595b00f429deb9558be57f34283809af7e3d7cc83cea7d867b45234ad362', '[\"*\"]', '2022-08-16 21:42:13', '2022-08-16 21:42:12', '2022-08-16 21:42:13'),
(13, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '1ab6c79de5bbcb8c041a0a9b0af394d6c549caffd1d471aa12e2203cafbb459e', '[\"*\"]', '2022-08-18 02:36:43', '2022-08-17 00:58:54', '2022-08-18 02:36:43'),
(14, 'App\\Models\\User', 1, 'LaravelSanctumAuth', 'f288cb8cc6966fedc76244b8a06e3a7eed65c5e0b3263c0ff06405553cf20907', '[\"*\"]', '2022-08-18 19:57:33', '2022-08-18 02:36:50', '2022-08-18 19:57:33'),
(15, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '25b60fc0df6bab7a681923376584915815fffb5dd8f7cb872dcbb0f4ad1f2d45', '[\"*\"]', '2022-08-20 21:01:34', '2022-08-18 19:57:44', '2022-08-20 21:01:34'),
(16, 'App\\Models\\User', 2, 'LaravelSanctumAuth', '830fb18f3b10fa26614d0af1819f2dc6d2009c9173fc07453b6d0a84bb2c4d67', '[\"*\"]', '2022-08-21 18:48:19', '2022-08-21 18:41:53', '2022-08-21 18:48:19'),
(17, 'App\\Models\\User', 2, 'LaravelSanctumAuth', 'c0bc9fcf0ab163c7b944730539fe51819b3b6183e0f8c9ed71c9bf93373846d2', '[\"*\"]', '2022-08-25 02:30:06', '2022-08-21 18:48:37', '2022-08-25 02:30:06'),
(18, 'App\\Models\\User', 14, 'LaravelSanctumAuth', '59ee93043e8a8820bbff2864621e9ef2d9d95b9fa5b94faf33c1bcd7f758a268', '[\"*\"]', '2022-09-11 20:41:41', '2022-08-25 18:31:40', '2022-09-11 20:41:41'),
(19, 'App\\Models\\User', 14, 'LaravelSanctumAuth', 'a7d6f9dc2b5b2416e39feef9d9c6065d06f210b0fb7aca00f01483680ce6dddd', '[\"*\"]', '2022-09-14 20:33:50', '2022-09-07 03:37:00', '2022-09-14 20:33:50'),
(20, 'App\\Models\\User', 5, 'LaravelSanctumAuth', '2804d760758861c32c5bd96cd2c547e43e385e883efedd607f706cd716412ae3', '[\"*\"]', '2022-10-26 21:57:07', '2022-10-13 18:27:08', '2022-10-26 21:57:07'),
(21, 'App\\Models\\User', 31, 'LaravelSanctumAuth', '191395b78d6dea478304438acc4e0ea2732fb03a3787f8c67e32ca5ad6c30d9c', '[\"*\"]', '2022-10-26 22:31:29', '2022-10-13 21:22:18', '2022-10-26 22:31:29'),
(22, 'App\\Models\\User', 32, 'LaravelSanctumAuth', '6bcdd513c511d318d1aa386ea96d358d8e41e184f62be46cba9a11bf99299b28', '[\"*\"]', '2022-10-26 18:44:12', '2022-10-26 13:22:31', '2022-10-26 18:44:12'),
(23, 'App\\Models\\User', 27, 'LaravelSanctumAuth', 'f053dc6a5897f3fd4b2752db7f7ba95e1231b161f633312bac5f861694dc7173', '[\"*\"]', '2022-10-26 22:05:03', '2022-10-26 21:16:09', '2022-10-26 22:05:03');

-- --------------------------------------------------------

--
-- Table structure for table `referral_codes`
--

CREATE TABLE `referral_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referral_codes`
--

INSERT INTO `referral_codes` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'TEST213', '2022-09-14 18:16:46', '2022-09-14 20:45:09'),
(2, 'Dustin', '2022-09-15 20:49:11', '2022-09-15 20:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Pub Recruiter', '2022-03-10 06:34:33', '2022-03-10 06:34:33'),
(2, 'site_url', 'https://extension.pubrecruiter.com/', '2022-03-10 06:34:33', '2022-03-10 06:34:33'),
(3, 'site_logo', 'uploads/settings/1PX2uSDiSx9Wy3jOKv2HEudBmIju76XAhH50IVKK.png', '2022-03-10 06:34:33', '2022-06-18 07:19:35'),
(4, 'favicon', 'uploads/settings/SWqkx5UrkOWaRVRNTWaeEGtBZgu9totXfIh81RIt.png', '2022-03-10 06:34:33', '2022-06-18 07:32:15'),
(5, 'contact_email', 'Partnerships@PubRecruiter.com', '2022-03-10 06:34:33', '2022-08-16 18:15:01'),
(6, 'partnership_email', 'Partnerships@PubRecruiter.com', '2022-03-10 12:34:33', '2022-03-10 12:34:33'),
(7, 'extension_link', 'https://chrome.google.com/webstore/detail/pub-recruiter/chfobgdkgknlemijfomlmoicedemnhbk', '2022-03-10 12:34:33', '2022-03-10 12:34:33'),
(8, 'stripe_link', 'https://pubrecruiter.com/reviewing-application/', '2022-03-10 18:34:33', '2022-07-14 06:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `sub_records`
--

CREATE TABLE `sub_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Brand','Creator') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Brand',
  `paid_at` date DEFAULT NULL,
  `expires` date DEFAULT NULL,
  `ad_supported` tinyint(1) NOT NULL DEFAULT 1,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `paid_at`, `expires`, `ad_supported`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pub Recruiter Founder', 'todd@pubrecruiter.com', NULL, '$2y$10$AO/ybS/WQ6XiCc8BV61vIe7MR9R/NK4SG2sxFRpsdOmk1lVO.OWt2', 'Brand', NULL, NULL, 1, 1, NULL, '2022-03-10 20:11:10', '2022-09-23 18:38:37'),
(4, 'Fiverr', 'limmor.kfiri@fiverr.com', NULL, '$2y$10$nTyfXWlbwDcvMqF2cIpmVOYMC2NFRXZpQ6H3YLHmVacPsDOihUfvC', 'Brand', '2022-07-18', '2029-08-01', 1, 1, NULL, '2022-07-18 01:34:16', '2022-08-28 14:51:49'),
(5, 'Partnerality', 'galen@partnerality.com', NULL, '$2y$10$Z/ra8iOMyZ1ercYvH2Tjh.by8UHnDxmi0YjGVKuBzmgabO6x1va6K', 'Brand', '2022-07-18', '2029-07-25', 1, 1, NULL, '2022-07-18 10:54:08', '2022-07-19 03:12:56'),
(6, 'Sharper Image', 'mfernandes@sharperimageonline.com', NULL, '$2y$10$n3cv2pW2y35VKcckTinp3.3Ahpgc5jORL2n9QmkWkAc0GRf/bNumC', 'Brand', '2022-07-20', '2041-03-01', 1, 1, NULL, '2022-07-28 08:30:38', '2022-07-28 09:19:18'),
(7, 'The Budget Savvy Bride', 'jessica@thebudgetsavvybride.com', NULL, '$2y$10$rysnr6Nt7Ppf3BgQVoggQeLQZwoA4hyZSoJrlz.vM2zBaHmJO65Wi', 'Creator', NULL, NULL, 1, 1, NULL, '2022-08-03 04:50:20', '2022-08-03 04:50:20'),
(8, 'HoneyBricks', 'jack.aldridge@honeybricks.com', NULL, '$2y$10$4mKLK/8OLJPeW74TAR2se.do.bRO9P8L3P/WOiwWr8K0OPAThSZDG', 'Brand', NULL, NULL, 1, 1, NULL, '2022-08-06 04:14:52', '2022-08-06 04:14:52'),
(12, 'Kikoff', 'steven@kikoff.com', NULL, '$2y$10$S522XtWDHoyOj/8JJLP9A.i6U2LVfM3FZTXuHcUOUd6ANUcedPvUy', 'Brand', NULL, NULL, 1, 1, NULL, '2022-08-18 00:49:01', '2022-08-18 00:49:01'),
(13, 'Rocket Money', 'jessica@rocketmoney.com', NULL, '$2y$10$CLlAc7pBlt6dNoZGrEEHCOpm9bw.653WiyjFS4dT31QuvbO1eEHbC', 'Brand', NULL, NULL, 1, 1, NULL, '2022-08-24 03:59:02', '2022-08-24 03:59:02'),
(15, 'Acorns', 'conor.robbins.contractor@acorns.com', NULL, '$2y$10$cl2qYEbVWIVvutW5tsvjdO5q58qYfZZ9JnqqTV3tp8aSjRZCc6a7q', 'Brand', NULL, NULL, 1, 1, NULL, '2022-08-28 21:56:08', '2022-08-28 21:56:08'),
(17, 'Lady Boss Blogger', 'ladybossblogger@gmail.com', NULL, '$2y$10$k8oNsynKn7kgQFMM3AzFUOPm5CQgoKbisI/shxxX3ttPQU.3/XuwK', 'Creator', NULL, NULL, 1, 1, NULL, '2022-09-07 21:46:20', '2022-09-07 21:46:20'),
(19, 'Kovo Credit', 'partners@kovocredit.com', NULL, '$2y$10$THOMYNOWk0VYS22KIxzk3u17nKBIH/NDjEe/QCT26LNNzohXb2sm.', 'Brand', NULL, NULL, 1, 1, NULL, '2022-09-08 19:43:44', '2022-09-08 19:43:44'),
(20, 'Financial Panther', 'kevin@financialpanther.com', NULL, '$2y$10$pk377vexab8Z5QCpf42eEuWHi4FrUIhRa7Pkl1n8/XqrhNt1Gn/7W', 'Creator', NULL, NULL, 1, 1, NULL, '2022-09-09 00:00:03', '2022-09-09 00:00:03'),
(21, 'Broke Girl Rich', 'brokeGIRLrich@gmail.com', NULL, '$2y$10$oD8ni/84WuJi.OyTI/6/xudFOgHzwuFmwSEeM9z9SCk8rb3K6Stn6', 'Creator', NULL, NULL, 1, 1, NULL, '2022-09-09 02:46:49', '2022-09-09 18:54:21'),
(22, 'Eluxe Magazine', 'chere@eluxemagazine.com', NULL, '$2y$10$WhcNDRGpZDJN8Sp3KopaRONzqN2pKM9QRznzwdmPuCYqZ.NStJK2m', 'Creator', NULL, NULL, 1, 1, NULL, '2022-09-12 17:24:09', '2022-09-12 17:24:09'),
(23, 'Mommy Gone Healthy', 'amberbattishill@gmail.com', NULL, '$2y$10$5tfjGr8NNt0o8E8/IqwbqOkfAV1rtN.I1tYkfBysOUlrPdpGP6QPu', 'Creator', NULL, NULL, 1, 1, NULL, '2022-09-12 18:16:05', '2022-10-26 19:37:12'),
(25, 'Hatch', 'caroline@hatchbaby.com', NULL, '$2y$10$3Ua35.kZL5376f8L7Q/BPu0tqFLuJqJtgUt1RrVRxhw2eLL/1XMuq', 'Brand', NULL, NULL, 1, 1, NULL, '2022-09-15 21:54:43', '2022-09-15 21:54:43'),
(26, 'Test Brand', 'testbrand@pubrecruiter.com', NULL, '$2y$10$bd7WLs15Fl0YJ83XJv0PFOi/pGy2TUe7w9B/RPm6xCBQk3XFQ3Is6', 'Brand', NULL, NULL, 1, 1, NULL, '2022-09-16 18:00:00', '2022-09-16 18:00:00'),
(27, 'Neighbor', 'affiliates@neighbor.com', NULL, '$2y$10$YAA/Hbm4VFjCvumAVxzFHe63MrmexgTHZQSbPtSgHKDWOs1D4tuGe', 'Brand', NULL, NULL, 1, 1, NULL, '2022-09-19 18:13:43', '2022-09-19 18:13:43'),
(29, 'Survey Junkie', 'devon.n@surveyjunkie.com', NULL, '$2y$10$I.Do/80j7rCL7.qVzXyHL.PmXTSiKgWLMVXRFc.Pfi46TtzBZgW1O', 'Brand', NULL, NULL, 1, 1, NULL, '2022-09-19 18:20:03', '2022-09-19 18:20:03'),
(31, 'Little Passports', 'danielle.hernandez@homerlearning.com', NULL, '$2y$10$JsoQST0.8WDCJRITXSsPtu19rQkpcb9X5gmaJiVAvPl8t4ZKjXn32', 'Brand', NULL, NULL, 1, 1, NULL, '2022-10-13 21:21:53', '2022-10-13 21:21:53'),
(32, 'meowcards', 'hubbledamon246@gmail.com', NULL, '$2y$10$eWUmg9oeWVNK7zgXDT2wUe1XCeyYQXAafNAiBeZV4hOXb6kjhvXrm', 'Brand', NULL, NULL, 1, 1, NULL, '2022-10-26 13:17:24', '2022-10-26 13:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `media_kit_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_kit_description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_code_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `media_kit_link`, `media_kit_description`, `referral_code_id`, `created_at`, `updated_at`) VALUES
(2, 25, NULL, NULL, NULL, '2022-09-15 21:54:43', '2022-09-15 21:54:43'),
(3, 26, NULL, NULL, NULL, '2022-09-16 18:00:00', '2022-09-16 18:00:00'),
(4, 27, NULL, NULL, NULL, '2022-09-19 18:13:43', '2022-09-19 18:13:43'),
(6, 29, NULL, NULL, NULL, '2022-09-19 18:20:03', '2022-09-19 18:20:03'),
(8, 1, NULL, NULL, NULL, '2022-09-23 18:38:37', '2022-09-23 18:38:37'),
(9, 31, NULL, NULL, NULL, '2022-10-13 21:21:53', '2022-10-13 21:21:53'),
(10, 32, NULL, NULL, NULL, '2022-10-26 13:17:24', '2022-10-26 13:17:24'),
(11, 23, NULL, NULL, NULL, '2022-10-26 19:37:12', '2022-10-26 19:37:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklists`
--
ALTER TABLE `blacklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_metrics`
--
ALTER TABLE `contact_metrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metrics`
--
ALTER TABLE `metrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `networks`
--
ALTER TABLE `networks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nocontacts`
--
ALTER TABLE `nocontacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opportunities`
--
ALTER TABLE `opportunities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outreaches`
--
ALTER TABLE `outreaches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `referral_codes`
--
ALTER TABLE `referral_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_records`
--
ALTER TABLE `sub_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blacklists`
--
ALTER TABLE `blacklists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `contact_metrics`
--
ALTER TABLE `contact_metrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `metrics`
--
ALTER TABLE `metrics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `networks`
--
ALTER TABLE `networks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nocontacts`
--
ALTER TABLE `nocontacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `opportunities`
--
ALTER TABLE `opportunities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `outreaches`
--
ALTER TABLE `outreaches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `referral_codes`
--
ALTER TABLE `referral_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_records`
--
ALTER TABLE `sub_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
