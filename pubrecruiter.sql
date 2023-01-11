-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pubrecruiter
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin@admin.com',NULL,'$2y$10$hAGYWe5ViWjIb90ysy3oiusqxzjltWoUE5nuItzUEsvtYkrRFWMxi','vVdQ41lT9eEvxjJYv2QnVBBsm9xuI0EUOVbwYxfE0ZFr1E9EyD6GMIJrcAwN','2022-03-10 06:34:33','2022-03-10 06:34:33');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blacklists`
--

DROP TABLE IF EXISTS `blacklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blacklists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklists`
--

LOCK TABLES `blacklists` WRITE;
/*!40000 ALTER TABLE `blacklists` DISABLE KEYS */;
INSERT INTO `blacklists` VALUES (1,'www.yahoo.com','2022-12-29 20:38:05','2022-12-29 20:38:05');
/*!40000 ALTER TABLE `blacklists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (2,'What is Affiliate Marketing (in simple terms!)','What-is-Affiliate-Marketing--in-simple-terms--','uploads/blog/XaBo8z8XiAGvX91QznEyTFdV4yNquLdEghckoUvO.png','Let\'s not overcomplicate the best way to promote your favorite brands','<p class=\"MsoNormal\">Affiliate marketing is a way for people to earn money by\r\npromoting other people\'s products. Here\'s how it works:<o:p></o:p></p><p class=\"MsoNormal\">Imagine that you have a website or a YouTube channel that is\r\nall about toys. You might write blog posts or make videos about different toys,\r\nand you might even review them and give your opinions.</p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\">Now, let\'s say that there is a toy company that makes a toy\r\nthat you really like. You can sign up to be an \"affiliate\" for that\r\ntoy company, which means that you get a special link to their toy. When someone\r\nclicks on that link and buys the toy, the toy company will give you a small\r\npercentage of the sale as a commission.</p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\">So, if you have a lot of people visiting your website or\r\nwatching your videos and they end up buying toys through your special links,\r\nyou can earn a lot of money just by promoting toys that you already like and\r\nbelieve in. That\'s what affiliate marketing is all about!<br></p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\"><span style=\"font-size:14.0pt;line-height:107%\"><b>How do I\r\nwork with the “toy” company as an Affiliate?<o:p></o:p></b></span></p><p class=\"MsoNormal\">To work with a toy company (or any other company) as an\r\naffiliate, you\'ll need to sign up for their affiliate program. Most companies\r\nhave an affiliate program set up, so you just need to find the information on\r\ntheir website.</p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\">Here\'s what you\'ll need to do:<o:p></o:p></p><ul><li>Search for the company\'s website and look for information\r\nabout their affiliate program. You might find this information in the footer of\r\ntheir website, or you can try searching for \"company name affiliate\r\nprogram.\"<o:p></o:p></li><li>Follow the instructions to sign up for the affiliate\r\nprogram. This might involve filling out a form with your personal information,\r\nor you might need to create an account on their website.</li><li>Once you\'ve been approved as an affiliate, you\'ll receive a\r\nspecial link that you can use to promote their products. You can share this\r\nlink on your website, in your emails, or on social media.</li></ul><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\">The \"toy\" company will usually provide you with some tools and\r\nresources to help you promote their products, such as banners and images that\r\nyou can use on your website.<br></p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\"><span style=\"font-size: 14pt;\"><b>How I become successful and make it my full-time job?</b></span></p><p class=\"MsoNormal\">There are a few key things that can help you become\r\nsuccessful at affiliate marketing and make it your full-time job:</p><p class=\"MsoNormal\"><o:p></o:p></p><ul><li>Choose a niche that you are passionate about and\r\nknowledgeable about. This will make it easier for you to create content and\r\npromote products that you believe in.<br></li></ul><p class=\"MsoNormal\"><o:p></o:p></p><ul><li>Build a website or a YouTube channel and create high-quality\r\ncontent that is helpful and informative. This will help you attract visitors\r\nand build an audience.<br></li></ul><p class=\"MsoNormal\"><o:p></o:p></p><ul><li>Promote products that are relevant to your audience and that\r\nyou believe in. Don\'t just promote anything for the sake of making a\r\ncommission.<br></li></ul><p class=\"MsoNormal\"><o:p></o:p></p><ul><li>Use social media and other platforms to promote your content\r\nand reach more people.<br></li></ul><p class=\"MsoNormal\"><o:p></o:p></p><ul><li>Keep track of your progress and analyze your results. Use\r\ntools like Google Analytics to see how many people are visiting your website\r\nand how many are clicking on your affiliate links.<br></li></ul><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\">Keep learning and improving. There is always more to learn\r\nabout affiliate marketing, so make sure to stay up-to-date with the latest\r\ntrends and best practices.<br></p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoNormal\"><o:p>&nbsp;</o:p>By following these tips, you\'ll be on your way to becoming a\r\nsuccessful affiliate marketer. It will take time and effort, but if you are\r\ndedicated and consistent, you can turn it into a full-time job.</p><p class=\"MsoNormal\"><o:p></o:p></p>','2023-01-11 20:10:50','2023-01-11 20:22:32'),(3,'How does Rakuten (Ebates) work?','How-does-Rakuten--Ebates--work-','uploads/blog/idjWMam4udgvhJV7GxN6slmxjPHdOBBAKRWsxXyY.png','Get to know how the popular cashback site operates','<p class=\"MsoNormal\">Rakuten is an e-commerce company that operates a cashback\r\nand rewards platform. Here\'s how it works:<br></p><p class=\"MsoNormal\"><o:p></o:p></p><p class=\"MsoListParagraphCxSpFirst\" style=\"text-indent:-.25in;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>Consumers can sign up for a free Rakuten account\r\nat Rakuten.com.<o:p></o:p></p><p class=\"MsoListParagraphCxSpMiddle\" style=\"text-indent:-.25in;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>Once they are signed up, they can browse the Rakuten\r\nwebsite or mobile app to find deals and discounts from participating retailers.<o:p></o:p></p><p class=\"MsoListParagraphCxSpLast\" style=\"text-indent:-.25in;mso-list:l1 level1 lfo1\"><!--[if !supportLists]--><span style=\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\r\nSymbol\">·<span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span>When a consumer makes a purchase from a\r\nparticipating retailer through Rakuten, they can earn cashback or other\r\nrewards. The amount of cashback or rewards earned will vary depending on the\r\nretailer and the specific product or service being purchased.<o:p></o:p></p><p class=\"MsoNormal\">Rakuten also offers a referral program, which allows members\r\nto earn additional cashback or rewards by referring friends and family to the\r\nplatform.<o:p></o:p></p><p class=\"MsoNormal\">Once a member has earned a certain amount of cashback or\r\nrewards, they can request a payment through their Rakuten account. Payments can\r\ntypically be requested via check, PayPal, or direct deposit.<o:p></o:p></p><p class=\"MsoNormal\"><span style=\"font-size:14.0pt;line-height:107%\"><b>How does\r\nRakuten make money?<o:p></o:p></b></span></p><p class=\"MsoNormal\">Affiliate Marketing.&nbsp;\r\nRakuten/Ebates has managers that partner up with brands on Affiliate\r\nNetworks.&nbsp; So let’s say Mary at Rakuten\r\nwants to bring on Macys to promote on Rakuten.&nbsp;\r\nShe will then talk to Macys and let them know, “hey Rakuten.com wants to\r\npromote Macys on the website!”&nbsp; Macy’s\r\nagrees and Rakuten then uses an Affiliate link on their website.<o:p></o:p></p><p class=\"MsoNormal\">Whenever someone buys Macy’s through the Affiliate link,\r\nRakuten splits the commission with you, the buyer of a Macy’s product, and\r\nkeeps some of it for themselves.&nbsp; Rates\r\ncan vary from brand to brand but overall this is how they earn.&nbsp; <o:p></o:p></p><p class=\"MsoNormal\">Rakuten can also sell advertising space on their website to\r\npromote brands more prominently.<o:p></o:p></p><p class=\"MsoNormal\"><span style=\"font-size:14.0pt;line-height:107%\"><b>Do other\r\nwebsites do this?</b></span></p><p class=\"MsoNormal\"><span style=\"font-size:14.0pt;line-height:107%\"><b><br></b>\r\n</span>Yes! In fact there are quite a few cashback websites that do this exact\r\nstrategy (of splitting Affiliate commissions).&nbsp;\r\nHere are a few:</p><ul><li>Top Cash B</li><li><span style=\"text-indent: -0.25in;\">Honey.com</span></li><li><span style=\"text-indent: -0.25in;\">Lemoney.com</span></li><li><span style=\"text-indent: -0.25in;\">Capitaloneshopping.com</span></li></ul><p class=\"MsoListParagraphCxSpLast\" style=\"text-indent:-.25in;mso-list:l0 level1 lfo2\"><o:p></o:p></p><p>\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\">Some use points instead of cashback like Swagbucks.com!<o:p></o:p></p>','2023-01-11 20:15:06','2023-01-11 20:21:29');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions`
--

DROP TABLE IF EXISTS `commissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_commission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `date` date NOT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions`
--

LOCK TABLES `commissions` WRITE;
/*!40000 ALTER TABLE `commissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `commissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_metrics`
--

DROP TABLE IF EXISTS `contact_metrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_metrics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` bigint(20) NOT NULL,
  `metric_id` int(11) NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_metrics`
--

LOCK TABLES `contact_metrics` WRITE;
/*!40000 ALTER TABLE `contact_metrics` DISABLE KEYS */;
INSERT INTO `contact_metrics` VALUES (16,62,1,'100K',100000,'2022-09-07 21:47:30','2022-09-07 21:47:30'),(17,62,2,NULL,NULL,'2022-09-07 21:47:30','2022-09-07 21:47:30'),(18,62,3,NULL,NULL,'2022-09-07 21:47:30','2022-09-07 21:47:30'),(19,65,1,'131.2K',131200,'2022-09-09 00:03:30','2022-09-09 00:03:30'),(20,65,2,NULL,NULL,'2022-09-09 00:03:30','2022-09-09 00:03:30'),(21,65,3,NULL,NULL,'2022-09-09 00:03:30','2022-09-09 00:03:30'),(22,66,1,'25000',25000,'2022-09-09 02:48:56','2022-09-09 02:48:56'),(23,66,2,NULL,NULL,'2022-09-09 02:48:56','2022-09-09 02:48:56'),(24,66,3,NULL,NULL,'2022-09-09 02:48:56','2022-09-09 02:48:56'),(25,67,1,'227K',227000,'2022-09-12 17:25:03','2022-09-12 17:25:03'),(26,67,2,NULL,NULL,'2022-09-12 17:25:03','2022-09-12 17:25:03'),(27,67,3,NULL,NULL,'2022-09-12 17:25:03','2022-09-12 17:25:03'),(28,52,1,'239K',239000,'2022-09-12 18:05:51','2022-09-12 18:06:15'),(29,52,2,NULL,NULL,'2022-09-12 18:05:51','2022-09-12 18:05:51'),(30,52,3,NULL,NULL,'2022-09-12 18:05:51','2022-09-12 18:05:51'),(31,68,1,'10K',10000,'2022-09-12 18:34:42','2022-09-12 18:34:42'),(32,68,2,NULL,NULL,'2022-09-12 18:34:42','2022-09-12 18:34:42'),(33,68,3,NULL,NULL,'2022-09-12 18:34:42','2022-09-12 18:34:42'),(38,81,1,'105000',105000,'2022-11-15 23:55:25','2022-11-15 23:55:59'),(39,81,2,NULL,NULL,'2022-11-15 23:55:25','2022-11-15 23:55:25'),(40,81,3,NULL,NULL,'2022-11-15 23:55:25','2022-11-15 23:55:25'),(41,81,4,NULL,NULL,'2022-11-15 23:55:25','2022-11-15 23:55:25'),(42,66,4,NULL,NULL,'2022-11-15 23:56:15','2022-11-15 23:56:15'),(43,83,1,'7.5M',7500000,'2022-11-16 01:55:24','2022-11-16 20:18:14'),(44,83,2,NULL,NULL,'2022-11-16 01:55:24','2022-11-16 01:55:24'),(45,83,3,NULL,NULL,'2022-11-16 01:55:24','2022-11-16 01:55:24'),(46,83,4,NULL,NULL,'2022-11-16 01:55:24','2022-11-16 01:55:24'),(47,85,1,'160K',160000,'2022-12-06 23:09:03','2022-12-06 23:09:03'),(48,85,2,NULL,NULL,'2022-12-06 23:09:03','2022-12-06 23:09:03'),(49,85,3,NULL,NULL,'2022-12-06 23:09:03','2022-12-06 23:09:03'),(50,85,4,NULL,NULL,'2022-12-06 23:09:03','2022-12-06 23:09:03'),(51,86,1,'2M',2000000,'2022-12-07 23:26:39','2022-12-07 23:26:39'),(52,86,2,NULL,NULL,'2022-12-07 23:26:39','2022-12-07 23:26:39'),(53,86,3,NULL,NULL,'2022-12-07 23:26:39','2022-12-07 23:26:39'),(54,86,4,NULL,NULL,'2022-12-07 23:26:39','2022-12-07 23:26:39'),(55,65,4,NULL,NULL,'2022-12-13 23:29:11','2022-12-13 23:29:11'),(56,67,4,NULL,NULL,'2022-12-13 23:29:32','2022-12-13 23:29:32'),(57,52,4,NULL,NULL,'2022-12-14 01:20:58','2022-12-14 01:20:58'),(58,68,4,NULL,NULL,'2022-12-14 01:22:05','2022-12-14 01:22:05'),(60,93,1,'26M',26000000,'2023-01-02 23:15:15','2023-01-02 23:15:15'),(61,93,2,NULL,NULL,'2023-01-02 23:15:45','2023-01-02 23:15:45'),(62,93,3,NULL,NULL,'2023-01-02 23:15:45','2023-01-02 23:15:45'),(63,93,4,NULL,NULL,'2023-01-02 23:15:45','2023-01-02 23:15:45'),(64,94,1,'182K',182000,'2023-01-02 23:16:59','2023-01-02 23:16:59'),(65,94,2,NULL,NULL,'2023-01-02 23:17:55','2023-01-02 23:17:55'),(66,94,3,NULL,NULL,'2023-01-02 23:17:55','2023-01-02 23:17:55'),(67,94,4,NULL,NULL,'2023-01-02 23:17:55','2023-01-02 23:17:55'),(68,95,4,'3M',3000000,'2023-01-02 23:19:11','2023-01-02 23:19:11'),(69,96,1,'1M',1000000,'2023-01-02 23:27:41','2023-01-02 23:27:41'),(70,97,1,'250K',250000,'2023-01-02 23:29:04','2023-01-02 23:29:04'),(71,98,1,'24M',24000000,'2023-01-02 23:30:19','2023-01-02 23:30:19'),(72,99,1,'174K',174000,'2023-01-02 23:32:23','2023-01-02 23:32:23'),(73,100,1,'21K',21000,'2023-01-02 23:34:12','2023-01-02 23:34:12'),(74,101,3,'907K',907000,'2023-01-02 23:35:23','2023-01-02 23:35:23'),(75,102,4,'50M',50000000,'2023-01-02 23:40:17','2023-01-02 23:40:17'),(76,103,1,'10M',10000000,'2023-01-02 23:41:51','2023-01-02 23:41:51'),(77,104,1,'5M',5000000,'2023-01-02 23:42:49','2023-01-02 23:42:49'),(78,95,1,NULL,NULL,'2023-01-02 23:43:11','2023-01-02 23:43:11'),(79,95,2,NULL,NULL,'2023-01-02 23:43:11','2023-01-02 23:43:11'),(80,95,3,NULL,NULL,'2023-01-02 23:43:11','2023-01-02 23:43:11'),(81,101,1,NULL,NULL,'2023-01-02 23:43:31','2023-01-02 23:43:31'),(82,101,2,NULL,NULL,'2023-01-02 23:43:31','2023-01-02 23:43:31'),(83,101,4,NULL,NULL,'2023-01-02 23:43:31','2023-01-02 23:43:31'),(84,105,3,'2.1M',2100000,'2023-01-04 01:27:00','2023-01-04 01:27:00'),(85,106,2,'884K',884000,'2023-01-04 01:34:13','2023-01-04 01:34:13'),(86,107,3,'3M',3000000,'2023-01-04 01:36:40','2023-01-04 01:37:19'),(87,106,1,NULL,NULL,'2023-01-04 01:37:03','2023-01-04 01:37:03'),(88,106,3,NULL,NULL,'2023-01-04 01:37:03','2023-01-04 01:37:03'),(89,106,4,NULL,NULL,'2023-01-04 01:37:03','2023-01-04 01:37:03'),(90,107,1,NULL,NULL,'2023-01-04 01:37:19','2023-01-04 01:37:19'),(91,107,2,NULL,NULL,'2023-01-04 01:37:19','2023-01-04 01:37:19'),(92,107,4,NULL,NULL,'2023-01-04 01:37:19','2023-01-04 01:37:19'),(93,108,2,'25K',25000,'2023-01-05 21:54:17','2023-01-05 21:54:17'),(94,109,1,'14K',14000,'2023-01-05 21:56:15','2023-01-05 21:56:15'),(95,110,1,'50K',50000,'2023-01-05 21:57:32','2023-01-05 21:57:32'),(96,111,2,'5K',5000,'2023-01-05 21:59:22','2023-01-05 21:59:22'),(97,112,1,'8K',8000,'2023-01-05 22:00:25','2023-01-05 22:00:25'),(98,114,1,'500K',500000,'2023-01-10 20:55:31','2023-01-10 20:55:31'),(99,114,2,NULL,NULL,'2023-01-10 20:55:31','2023-01-10 20:55:31'),(100,114,3,NULL,NULL,'2023-01-10 20:55:31','2023-01-10 20:55:31'),(101,114,4,NULL,NULL,'2023-01-10 20:55:31','2023-01-10 20:55:31');
/*!40000 ALTER TABLE `contact_metrics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `code` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `offers` tinyint(1) NOT NULL DEFAULT 0,
  `posts` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (3,1,'App\\Models\\Admin','Brand','Greenlight','breanna.warren@greenlight.me','https://greenlight.com/','greenlight.com','uploads/brands/2TbDMYLFlWiM5t8VHZVb6XwauAplpzGxhPrUmRhV.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Finance, Kids',25,'$','Per Card Sign Up','https://greenlight-card.pxf.io/c/3060637/862955/11976?subId1={USERID}','RDXKotG4',0,0,0,1,'2022-06-07 14:05:26','2022-12-12 20:23:33'),(48,5,'App\\Models\\User','Creator','Partnerality','galen@partnerality.com','http://partnerality.com','partnerality.com','uploads/brands/ieu0QlVTjZpJANqqiRaZXc9vff28lo9WoVKLanY8.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Affiliate Service',NULL,'$','Per Sale',NULL,'oynkSqTP',0,0,0,0,'2022-07-18 15:54:08','2022-12-28 22:53:07'),(51,6,'App\\Models\\User','Brand','Sharper Image','mfernandes@sharperimageonline.com','https://www.sharperImage.com','www.sharperImage.com','uploads/brands/ZlOwNCH2ZaNI1Ku1KudLe4sZANxKLyV3KERx03pM.jpg',5,'Rakuten','https://rakutenadvertising.com/','Electronics, Technology',2,'%','Per Sale','https://click.linksynergy.com/fs-bin/click?id=T5wHpiRUtpw&offerid=291398.10000943&type=3&subid={USERID}','DquQl389',0,0,0,1,'2022-07-28 13:30:38','2022-12-12 20:26:45'),(52,7,'App\\Models\\User','Creator','The Budget Savvy Bride','jessica@thebudgetsavvybride.com','https://thebudgetsavvybride.com','thebudgetsavvybride.com',NULL,NULL,NULL,NULL,'Home, Finance',NULL,NULL,NULL,NULL,NULL,1,1,0,0,'2022-08-03 09:50:20','2023-01-02 23:43:02'),(53,8,'App\\Models\\User','Brand','HoneyBricks','jack.aldridge@honeybricks.com','https://www.honeybricks.com/','www.honeybricks.com','uploads/brands/FkiNnbGFx7lVAlIUrdi6LVfRwFfkSrDgRfzw3jVg.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Real Estate, Crypto',5,'$','Per Sign Up','https://honeybricks.pxf.io/c/3060637/1374318/16452?subId1={USERID}','5tC00xlT',0,0,0,1,'2022-08-06 09:14:52','2022-12-08 05:30:20'),(57,12,'App\\Models\\User','Brand','Kikoff','steven@kikoff.com','https://kikoff.com/','kikoff.com','uploads/brands/R0fmzp8vEXjIl9r4tYsmTeryjwifyLqMZ2Xw1Jye.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Finance, Credit',3,'$','Per Sign Up','https://kikoff.pxf.io/c/3060637/1404895/14994?subId1={USERID}','1OUQJQ32',0,0,0,1,'2022-08-18 05:49:01','2022-12-12 20:21:28'),(58,13,'App\\Models\\User','Brand','Rocket Money','jessica@rocketmoney.com','https://www.rocketmoney.com','www.rocketmoney.com','uploads/brands/4bLUlzA2U31nCHqIpwgSEQTgCam50UIBilWOvRmX.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Finance, Bills',5,'$','Per Account Link','https://rocketmoney.sjv.io/c/3060637/1432479/10034?subId1={USERID}','2IcOcSD1',0,0,0,1,'2022-08-24 08:59:02','2022-12-13 23:30:35'),(60,15,'App\\Models\\User','Brand','Acorns','conor.robbins.contractor@acorns.com','https://www.acorns.com/','www.acorns.com','uploads/brands/WCrNBh7xIVZVr0UKsVF214CCSjjFeGSPrfy01VZU.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Investing, Finance',25,'$','Per Funded Account','https://acorns.sjv.io/c/3060637/887205/5136?subId1={USERID}','wbJRnbjD',0,0,0,1,'2022-08-29 02:56:08','2022-12-13 23:30:44'),(62,17,'App\\Models\\User','Creator','Lady Boss Blogger','ladybossblogger@gmail.com','https://ladybossblogger.com/','ladybossblogger.com',NULL,NULL,NULL,NULL,'Blogging, Entrepreneurship',NULL,NULL,NULL,NULL,NULL,1,1,1,1,'2022-09-08 02:46:20','2022-09-08 02:49:54'),(64,19,'App\\Models\\User','Brand','Kovo Credit','partners@kovocredit.com','https://kovocredit.com/','kovocredit.com','uploads/brands/9Pf6z4xDgjPKoBx5OVmq4WJSBtqFUqUcVFaIhEyS.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Credit Builder, Finance',20,'$','Per Qualified Lead','https://kovo-credit.sjv.io/c/3060637/1477780/12274?subId1={USERID}','xnPi3odm',0,0,0,1,'2022-09-09 00:43:44','2022-12-12 20:20:50'),(65,20,'App\\Models\\User','Creator','Financial Panther','kevin@financialpanther.com','https://financialpanther.com/','financialpanther.com',NULL,NULL,NULL,NULL,'Side Hustle, Money',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2022-09-09 05:00:03','2022-12-13 23:29:11'),(66,21,'App\\Models\\User','Creator','Broke Girl Rich','brokeGIRLrich@gmail.com','https://brokegirlrich.com/','brokegirlrich.com',NULL,NULL,NULL,NULL,'Debt, Finance',NULL,NULL,NULL,NULL,NULL,1,1,1,1,'2022-09-09 07:46:49','2022-12-14 01:21:06'),(67,22,'App\\Models\\User','Creator','Eluxe Magazine','chere@eluxemagazine.com','https://eluxemagazine.com/','eluxemagazine.com',NULL,NULL,NULL,NULL,'Fashion, Women',NULL,NULL,NULL,NULL,NULL,1,1,1,1,'2022-09-12 22:24:09','2022-12-14 01:22:11'),(68,23,'App\\Models\\User','Creator','Mommy Gone Healthy','amberbattishill@gmail.com','https://mommygonehealthy.com/','mommygonehealthy.com',NULL,NULL,NULL,NULL,'DIY, Home',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2022-09-12 23:16:05','2022-12-14 01:22:05'),(70,25,'App\\Models\\User','Brand','Hatch','caroline@hatchbaby.com','https://www.hatch.co/','www.hatch.co','uploads/brands/w8uyMiD6IcqAxIj4TPqYKv4VQnIJX2PO6dFOFPGS.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Baby, Home',5,'%','Per Sale','https://hatch.sjv.io/c/3060637/1394242/13693?subId1={USERID}','t0M5dpfX',0,0,1,1,'2022-09-16 02:54:43','2022-12-12 20:14:26'),(72,27,'App\\Models\\User','Brand','Neighbor','affiliates@neighbor.com','https://www.neighbor.com/','www.neighbor.com','uploads/brands/OEiBWgWpgaXkfncKpzkt80n9X1x3ZrqNFnNIE2i8.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Side Hustle, Storage',25,'$','Per New Listing','https://neighbor.pxf.io/c/3060637/1109790/14066?subId1={USERID}','tnUQVOKk',0,0,0,1,'2022-09-19 23:13:43','2022-12-12 20:18:35'),(74,29,'App\\Models\\User','Brand','Survey Junkie','devon.n@surveyjunkie.com','https://www.surveyjunkie.com/','www.surveyjunkie.com','uploads/brands/WWiH6hZAGDrfFonfuKca5lyoIQZFEKYYf4HhwddQ.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Surveys, Side Hustle',1,'$','Per Sign Up','https://surveyjunkie.pxf.io/c/3060637/1303226/15490?subId1={USERID}','G19TWwkR',0,0,0,1,'2022-09-19 23:20:03','2022-12-12 20:22:27'),(79,34,'App\\Models\\User','Brand','Pub Recruiter Muffins','testpubrecruiter@pubrecruiter.com','https://prmuffins.com','prmuffins.com',NULL,2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925',NULL,NULL,NULL,NULL,NULL,'8ulDvszy',0,0,0,0,'2022-11-03 01:47:00','2022-11-03 02:02:54'),(80,35,'App\\Models\\User','Brand','Tinto','anish@drinktinto.com','https://drinktinto.com/','drinktinto.com','uploads/brands/4329gEtEgt7DyahbnUJh2SM3R9K4QQjApwPtrtSW.png',1,'ShareASale','https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}','Wine, Drinks',8,'%','Per Sale','https://shareasale.com/r.cfm?b=1772126&u=1574996&m=110484&urllink=&afftrack={USERID}','qGn5hxEy',0,0,1,1,'2022-11-10 05:08:42','2022-12-12 20:14:06'),(81,36,'App\\Models\\User','Creator','The Quality Edit','lauren@thequalityedit.com','https://www.thequalityedit.com/','www.thequalityedit.com',NULL,NULL,NULL,NULL,'Fashion, Shopping',NULL,NULL,NULL,NULL,NULL,1,1,1,1,'2022-11-16 05:54:45','2022-11-16 05:56:06'),(82,37,'App\\Models\\User','Brand','Keetsa','affiliatemanager@keetsa.com','https://www.keetsa.com/','www.keetsa.com','uploads/brands/JAHH77WXypWifZUyCrlN8Nvf2eK7seCf5vDdY2UM.png',1,'ShareASale','https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}','Mattresses, Furniture',4,'%','Per Sale','https://shareasale.com/r.cfm?b=1057527&u=1574996&m=72530&urllink=&afftrack={USERID}','ifOVE2CA',0,0,0,1,'2022-11-16 06:32:48','2022-12-12 20:15:48'),(83,38,'App\\Models\\User','Creator','Dealnews','scortazzo@dealnews.com','https://www.dealnews.com/','www.dealnews.com',NULL,NULL,NULL,NULL,'Deals, Shopping',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2022-11-16 07:54:57','2022-11-17 02:18:14'),(84,39,'App\\Models\\User','Brand','Augusta Precious Metals','fjeanbart@augustapreciousmetals.com','https://www.augustapreciousmetals.com/','www.augustapreciousmetals.com','uploads/brands/lNX2b6EvBj2i9hK2m8noBXDP4mMpNUJRz7vgW7d6.png',NULL,'N/A','https://apmaffiliates.com/apply/?ref=1124','Gold, Investing',1,'%','Per Trade','https://www.augustapreciousmetals.com/apm-lp/?apmtrkr_cid=1696&aff_id=1124&sub_id={USERID}','p7Ddf4xl',0,0,0,1,'2022-11-17 02:12:23','2023-01-11 23:32:02'),(85,40,'App\\Models\\User','Creator','RetirementLiving','ashley@retirementliving.com','https://www.retirementliving.com/','www.retirementliving.com',NULL,NULL,NULL,NULL,'Retirement, Finance',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2022-12-07 05:01:24','2022-12-07 05:09:03'),(86,41,'App\\Models\\User','Creator','UpSellit','cyoun@upsellit.com','https://upsellit.com/','us.upsellit.com',NULL,NULL,NULL,NULL,'Affiliate Solution',NULL,NULL,NULL,NULL,NULL,1,0,0,1,'2022-12-07 09:49:37','2022-12-13 23:29:19'),(87,42,'App\\Models\\User','Brand','Nani','affiliates@nanit.com','https://www.nanit.com/','www.nanit.com','uploads/brands/dggdRfblzp7lJbEcUb0wv3g5L3cNzZ7Ch7BoFzeu.png',1,'ShareASale','https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}','Baby, Electronics',6,'%','Per Sale','https://shareasale.com/r.cfm?b=2163758&u=1574996&m=68043&urllink=&afftrack={USERID}','tOMw73OZ',0,0,1,1,'2022-12-08 05:22:02','2022-12-12 20:14:13'),(88,43,'App\\Models\\User','Brand','Switchbot','affiliate@switch-bot.com','https://us.switch-bot.com/','us.switch-bot.com','uploads/brands/sGB1fgFn1S36cLjFJaP7OUVSuJEa70JMBmpQPtXM.png',6,'CJ','https://signup.cj.com/member/signup/publisher/','Smart Home, Electronics',10,'%','Per Sale','https://www.anrdoezrs.net/click-100526984-15052794?sid={USERID}',NULL,0,0,1,1,'2022-12-12 22:55:55','2022-12-13 23:30:57'),(89,44,'App\\Models\\User','Brand','Greenworks','affiliate@marcoregroup.com','https://www.greenworkstools.com/','www.greenworkstools.com','uploads/brands/KJKPaVb2dOa9v3yos2BGNZW4AbZtmLuhuslQGTvd.png',1,'ShareASale','https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}','Home, Yard',5,'%','Per Sale','https://shareasale.com/r.cfm?b=2128907&u=1574996&m=130099&urllink=&afftrack={USERID}',NULL,0,0,0,1,'2022-12-12 23:02:47','2022-12-13 23:32:24'),(90,45,'App\\Models\\User','Brand','Trustworthy','mariah@trustworthy.com','https://www.trustworthy.com/','www.trustworthy.com','uploads/brands/2C3S39HGe6v1A9X9wRItv1uxYuJ5fXJYQW2Q5zTt.png',2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','Family Documentation',50,'$','Per Sale','https://trustworthy.sjv.io/c/3060637/1304246/13594',NULL,0,0,0,1,'2022-12-14 00:08:52','2022-12-29 01:08:10'),(91,46,'App\\Models\\User','Brand','Gen3 Marketing','nyorgiadis@gen3marketing.com','https://gen3marketing.com/','gen3marketing.com','uploads/brands/w9SOhBJzclHU8RxZ6jAaBH0v86T8oLDMkSPOaQFR.png',NULL,'N/A','https://gen3marketing.com','Affiliate Agency',NULL,NULL,NULL,'',NULL,0,0,0,1,'2022-12-15 01:46:18','2023-01-11 23:29:55'),(93,1,'App\\Models\\Admin','Creator','Capital One Shopping','kelly.rodeck@capitalone.com','https://capitaloneshopping.com/','capitaloneshopping.com',NULL,NULL,NULL,NULL,'Cashback, Loyalty',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-02 23:15:15','2023-01-02 23:17:48'),(94,1,'App\\Models\\Admin','Creator','FlipGive','ekerr@flipgive.com','https://www.flipgive.com/','www.flipgive.com',NULL,NULL,NULL,NULL,'Donation, Loyalty',NULL,NULL,NULL,NULL,NULL,1,0,0,1,'2023-01-02 23:16:59','2023-01-02 23:17:55'),(95,1,'App\\Models\\Admin','Creator','Wickfire','ryan@wickfire.com','https://www.wickfire.com/','www.wickfire.com',NULL,NULL,NULL,NULL,'Paid Search, Coupon',NULL,NULL,NULL,NULL,NULL,1,0,0,0,'2023-01-02 23:19:11','2023-01-02 23:43:11'),(96,1,'App\\Models\\Admin','Creator','Dollar Sprout','jeff@dollarsprout.com','https://dollarsprout.com/','dollarsprout.com',NULL,NULL,NULL,NULL,'Finance, Side Hustle',NULL,NULL,NULL,NULL,NULL,1,0,0,1,'2023-01-02 23:27:41','2023-01-02 23:27:41'),(97,1,'App\\Models\\Admin','Creator','Bible Money Matters','peter@biblemoneymatters.com','https://www.biblemoneymatters.com/','www.biblemoneymatters.com',NULL,NULL,NULL,NULL,'Finance, Faith',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-02 23:29:04','2023-01-02 23:29:04'),(98,1,'App\\Models\\Admin','Creator','Ranker','jbaker@ranker.com','https://www.ranker.com/','www.ranker.com',NULL,NULL,NULL,NULL,'Lists, Pop Culture',NULL,NULL,NULL,NULL,NULL,0,1,0,1,'2023-01-02 23:30:19','2023-01-02 23:30:19'),(99,1,'App\\Models\\Admin','Creator','Active Junky','mike@activejunky.com','https://www.activejunky.com/','www.activejunky.com',NULL,NULL,NULL,NULL,'Cashback, Fitness',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-02 23:32:23','2023-01-02 23:32:23'),(100,1,'App\\Models\\Admin','Creator','Lemoney','affiliate@lemoney.com','https://www.lemoney.com/','www.lemoney.com',NULL,NULL,NULL,NULL,'Cashback, Loyalty',NULL,NULL,NULL,NULL,NULL,1,0,0,1,'2023-01-02 23:34:12','2023-01-02 23:34:12'),(101,1,'App\\Models\\Admin','Creator','Max Maher','support@maxmahershow.com','https://www.youtube.com/channel/UCLr9nHPNpj7U3096nEo8Qfg','https://www.youtube.com/channel/UCLr9nHPNpj7U3096nEo8Qfg',NULL,NULL,NULL,NULL,'YouTube, Finance',NULL,NULL,NULL,NULL,NULL,0,1,0,0,'2023-01-02 23:35:23','2023-01-02 23:43:31'),(102,1,'App\\Models\\Admin','Creator','ID.me','kelly.powers@id.me','https://www.id.me/','www.id.me',NULL,NULL,NULL,NULL,'Discount, Identity',NULL,NULL,NULL,NULL,NULL,1,1,0,0,'2023-01-02 23:40:17','2023-01-02 23:40:17'),(103,1,'App\\Models\\Admin','Creator','SmartAsset','mgoldstein@smartasset.com','https://smartasset.com/','smartasset.com',NULL,NULL,NULL,NULL,'Finance, Investments',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-02 23:41:51','2023-01-02 23:41:51'),(104,1,'App\\Models\\Admin','Creator','Hip2Save','adam.mankoff@hip2save.com','https://hip2save.com/','hip2save.com',NULL,NULL,NULL,NULL,'Deals, Lifestyle',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-02 23:42:49','2023-01-02 23:42:49'),(105,1,'App\\Models\\Admin','Creator','Seth\'s Bike Hacks','setha@sethsbikehacks.com','https://www.youtube.com/channel/UCu8YylsPiu9XfaQC74Hr_Gw','https://www.youtube.com/channel/UCu8YylsPiu9XfaQC74Hr_Gw',NULL,NULL,NULL,NULL,'Bikes, Outdoors',NULL,NULL,NULL,NULL,NULL,1,1,0,0,'2023-01-04 01:27:00','2023-01-04 01:27:00'),(106,1,'App\\Models\\Admin','Creator','Kids Deals on FB','kristin@whatkristinfound.com','https://www.facebook.com/groups/604796176348131','https://www.facebook.com/groups/604796176348131',NULL,NULL,NULL,NULL,'Kids, Deals, Facebook',NULL,NULL,NULL,NULL,NULL,1,0,0,0,'2023-01-04 01:34:13','2023-01-04 01:37:03'),(107,1,'App\\Models\\Admin','Creator','The Deal Guy','business@thedealguy.com','https://thedealguy.com/','thedealguy.com',NULL,NULL,NULL,NULL,'Deals, Influencer',NULL,NULL,NULL,NULL,NULL,1,1,0,0,'2023-01-04 01:36:40','2023-01-04 01:37:19'),(108,1,'App\\Models\\Admin','Creator','The Pink Envelope','info@jonathanivyphoto.com','https://thepinkenvelope.com/','thepinkenvelope.com',NULL,NULL,NULL,NULL,'Wine, Gifts',NULL,NULL,NULL,NULL,NULL,0,1,0,1,'2023-01-05 21:54:17','2023-01-05 21:54:17'),(109,1,'App\\Models\\Admin','Creator','Crafty Bartending','hello@craftybartending.com','https://craftybartending.com/','craftybartending.com',NULL,NULL,NULL,NULL,'Drinks, Wine',NULL,NULL,NULL,NULL,NULL,0,1,0,1,'2023-01-05 21:56:15','2023-01-05 21:56:15'),(110,1,'App\\Models\\Admin','Creator','The Fresh Cooky','kathleen@thefreshcooky.com','https://www.thefreshcooky.com/','www.thefreshcooky.com',NULL,NULL,NULL,NULL,'Food, Drinks',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-05 21:57:32','2023-01-05 21:57:32'),(111,1,'App\\Models\\Admin','Creator','Enjoy Red Wine','lateesha@enjoyredwine.com','http://www.enjoyredwine.com/','www.enjoyredwine.com',NULL,NULL,NULL,NULL,'Wine, Drinks',NULL,NULL,NULL,NULL,NULL,1,0,0,1,'2023-01-05 21:59:22','2023-01-05 21:59:22'),(112,1,'App\\Models\\Admin','Creator','Tasty Red Wine','joleigh@tastyredwine.com','http://tastyredwine.com/','tastyredwine.com',NULL,NULL,NULL,NULL,'Wine, Drinks',NULL,NULL,NULL,NULL,NULL,1,1,0,1,'2023-01-05 22:00:25','2023-01-05 22:00:25'),(114,48,'App\\Models\\User','Creator','Subscriboxer','ewen@venture4thmedia.com','https://subscriboxer.com/','subscriboxer.com',NULL,NULL,NULL,NULL,'Subscription, Home',NULL,NULL,NULL,NULL,NULL,1,1,1,1,'2023-01-10 20:55:01','2023-01-10 20:55:39');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (46,2,52,'2022-08-19 23:41:59','2022-08-19 23:41:59'),(49,26,66,'2022-09-20 21:11:54','2022-09-20 21:11:54'),(50,34,67,'2022-11-15 23:16:42','2022-11-15 23:16:42'),(51,34,66,'2022-11-15 23:16:56','2022-11-15 23:16:56'),(52,34,65,'2022-11-15 23:16:57','2022-11-15 23:16:57'),(53,34,81,'2022-11-15 23:59:19','2022-11-15 23:59:19');
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_time` tinyint(4) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` VALUES (1,1,'www.moneytalksnews.com',3,'Based in South Florida, he responds more to deals','2022-03-24 13:03:46','2022-03-24 13:03:46'),(2,1,'www.nav.com',2,NULL,'2022-03-25 11:59:00','2022-03-25 11:59:00'),(3,1,'www.affinity.solutions',2,NULL,'2022-03-25 12:01:01','2022-03-25 12:01:01'),(4,1,'www.paypal.com',3,NULL,'2022-03-25 12:38:43','2022-03-25 12:38:43'),(5,1,'www.buzzfeed.com',3,NULL,'2022-03-25 13:24:22','2022-03-25 13:24:22'),(6,1,'capitaloneshopping.com',2,NULL,'2022-03-25 14:21:57','2022-03-25 14:21:57'),(7,1,'thriftytraveler.com',3,NULL,'2022-03-26 12:49:14','2022-03-26 12:49:14'),(8,1,'pubrecruiter.com',1,'Hello!','2022-03-29 14:17:06','2022-03-30 08:54:32'),(9,1,'www.everflow.io',1,NULL,'2022-04-01 13:22:20','2022-04-01 13:22:20'),(10,1,'www.benzinga.com',2,NULL,'2022-04-05 10:06:43','2022-04-05 10:06:43'),(11,1,'https://www.youtube.com/channel/UCLr9nHPNpj7U3096nEo8Qfg',3,NULL,'2022-04-05 10:09:23','2022-04-05 10:09:23'),(12,1,'dollarflightclub.com',1,NULL,'2022-04-05 11:40:50','2022-04-05 11:40:50'),(13,1,'www.nytimes.com',2,NULL,'2022-04-08 09:41:24','2022-04-08 09:41:24'),(14,1,'slickdeals.net',2,NULL,'2022-04-08 18:42:59','2022-04-08 18:42:59'),(15,1,'www.lemonade.com',2,NULL,'2022-04-12 14:28:43','2022-04-12 14:28:43'),(16,1,'www.shopify.com',3,NULL,'2022-04-12 14:33:14','2022-04-12 14:33:14'),(17,1,'www.aspiration.com',2,NULL,'2022-04-13 10:57:09','2022-04-13 10:57:09'),(18,1,'vape.deals',3,NULL,'2022-04-13 12:21:08','2022-04-13 12:21:08'),(19,1,'www.magiclinks.com',2,NULL,'2022-04-13 12:59:40','2022-04-13 12:59:40'),(20,1,'cupofjo.com',3,NULL,'2022-04-13 13:05:25','2022-04-13 13:05:25'),(21,1,'practicalwanderlust.com',2,NULL,'2022-04-13 13:10:41','2022-04-13 13:10:41'),(22,1,'www.mattressclarity.com',3,NULL,'2022-04-14 15:55:41','2022-04-14 15:55:41'),(23,1,'www.carefulcents.com',4,NULL,'2022-04-14 15:59:31','2022-04-14 15:59:31'),(24,1,'sezzle.com',3,NULL,'2022-04-14 16:10:58','2022-04-14 16:10:58'),(25,1,'www.55haitao.com',2,NULL,'2022-04-14 16:14:09','2022-04-14 16:14:09'),(26,1,'www.makingsenseofcents.com',3,NULL,'2022-04-15 12:06:52','2022-04-15 12:06:52'),(27,1,'readthejoe.com',2,NULL,'2022-04-20 14:51:49','2022-04-20 14:51:49'),(28,1,'theplantbasedbeard.com',2,NULL,'2022-04-21 11:41:15','2022-04-21 11:41:15'),(29,1,'thesleepdoctor.com',3,NULL,'2022-04-21 14:28:14','2022-04-21 14:28:14'),(30,1,'https://www.youtube.com/c/MxRMods',3,NULL,'2022-04-21 14:32:34','2022-04-21 14:32:34'),(31,1,'www.investopedia.com',2,NULL,'2022-04-22 11:26:48','2022-04-22 11:26:48'),(32,1,'www.sleepfoundation.org',3,NULL,'2022-04-22 12:34:52','2022-04-22 12:34:52'),(33,1,'hormonesbalance.com',2,NULL,'2022-04-22 12:36:07','2022-04-22 12:36:07'),(34,1,'www.forbes.com',3,NULL,'2022-04-23 08:49:59','2022-04-23 08:49:59'),(35,1,'www.passportsandpreemies.com',2,NULL,'2022-04-26 10:19:41','2022-04-26 10:19:41'),(36,1,'www.ispyfabulous.com',2,NULL,'2022-04-26 10:20:44','2022-04-26 10:20:44'),(37,1,'https://www.instagram.com/dope__kitchen',2,NULL,'2022-04-26 10:21:52','2022-04-26 10:21:52'),(38,1,'www.shophermedia.com',2,NULL,'2022-04-29 11:23:40','2022-04-29 11:23:40'),(39,27,'www.thequalityedit.com',2,NULL,'2022-12-29 21:09:20','2022-12-29 21:09:20'),(40,27,'www.dealnews.com',2,NULL,'2022-12-29 21:10:06','2022-12-29 21:10:06');
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metrics`
--

DROP TABLE IF EXISTS `metrics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metrics` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metrics`
--

LOCK TABLES `metrics` WRITE;
/*!40000 ALTER TABLE `metrics` DISABLE KEYS */;
INSERT INTO `metrics` VALUES (1,'Monthly Visitors','2022-09-01 23:14:07','2022-09-01 23:16:43'),(2,'Followers','2022-09-01 23:14:12','2022-09-01 23:14:49'),(3,'YouTube Subs','2022-09-01 23:15:03','2022-09-13 23:11:17'),(4,'Newsletter Subs','2022-09-13 23:11:31','2022-09-13 23:11:31');
/*!40000 ALTER TABLE `metrics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2022_03_04_180651_create_admins_table',1),(6,'2022_03_04_180710_create_contacts_table',1),(7,'2022_03_04_182114_create_blacklists_table',1),(8,'2022_03_05_203158_create_settings_table',1),(9,'2022_03_22_220412_create_feedback_table',2),(10,'2022_04_06_172600_create_ads_table',3),(11,'2022_04_28_002141_create_outreaches_table',4),(12,'2022_05_04_094803_create_networks_table',5),(13,'2022_06_09_210036_create_favorites_table',6),(14,'2022_07_05_102847_create_nocontacts_table',7),(15,'2022_08_02_182012_create_opportunities_table',8),(16,'2022_08_24_205915_create_sub_records_table',9),(17,'2022_09_01_000501_create_metrics_table',10),(18,'2022_09_01_011437_create_contact_metrics_table',10),(19,'2022_09_13_213614_create_user_info_table',11),(20,'2022_09_13_213817_create_referral_codes_table',11),(21,'2022_12_06_201719_create_commissions_table',12),(22,'2023_01_09_095122_create_blogs_table',13),(23,'2023_01_10_175137_create_recommendations_table',13),(24,'2023_01_10_175318_create_resources_table',13);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `networks`
--

DROP TABLE IF EXISTS `networks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `networks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `networks`
--

LOCK TABLES `networks` WRITE;
/*!40000 ALTER TABLE `networks` DISABLE KEYS */;
INSERT INTO `networks` VALUES (1,'ShareASale','https://shareasale.com/r.cfm?b=44&u=1574996&m=47&urllink=&afftrack={USERID}','2022-05-05 20:32:42','2022-08-22 17:22:03'),(2,'Impact','https://impact-referral-partnerships.sjv.io/c/3060637/749882/10925','2022-05-05 20:33:31','2022-06-07 08:58:49'),(3,'Refersion','https://marketplace.refersion.com/?rfsn=6151486.587a716&utm_source=ambassador&utm_medium=referral&utm_campaign=6151486','2022-05-05 20:39:04','2022-06-07 09:10:01'),(4,'AWIN','https://www.awin1.com/awclick.php?gid=171448&mid=4032&awinaffid=1072681&linkid=362688&clickref=','2022-05-06 08:36:18','2022-06-07 09:11:32'),(5,'Rakuten','https://rakutenadvertising.com/','2022-05-06 08:37:52','2022-07-19 04:51:42'),(6,'CJ','https://signup.cj.com/member/signup/publisher/','2022-06-07 08:59:17','2022-06-07 08:59:17'),(7,'Partnerize','https://signup.partnerize.com/signup/en/phg','2022-07-20 05:55:53','2022-07-20 05:55:53'),(8,'Amazon Associates','https://affiliate-program.amazon.com/','2022-10-26 19:33:07','2022-10-26 19:33:07');
/*!40000 ALTER TABLE `networks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nocontacts`
--

DROP TABLE IF EXISTS `nocontacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nocontacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nocontacts`
--

LOCK TABLES `nocontacts` WRITE;
/*!40000 ALTER TABLE `nocontacts` DISABLE KEYS */;
INSERT INTO `nocontacts` VALUES (1,5,'www.goodshop.com','2022-08-03 02:48:04','2022-08-03 02:48:04'),(2,8,'realwealth.com','2022-08-16 19:53:57','2022-08-16 19:53:57'),(3,8,'goodmenproject.com','2022-08-18 00:59:56','2022-08-18 00:59:56'),(4,8,'smartasset.com','2022-08-18 21:37:33','2022-08-18 21:37:33'),(7,8,'www.businessinsider.com','2022-09-20 18:24:50','2022-09-20 18:24:50'),(8,8,'www.forbes.com','2022-09-20 18:25:01','2022-09-20 18:25:01'),(9,8,'www.bloomberg.com','2022-09-20 18:25:32','2022-09-20 18:25:32'),(10,8,'www.stakingrewards.com','2022-09-20 21:24:50','2022-09-20 21:24:50'),(11,8,'www.therealestatecrowdfundingreview.com','2022-09-20 21:25:11','2022-09-20 21:25:11'),(12,27,'www.benzinga.com','2022-11-02 20:59:48','2022-11-02 20:59:48'),(13,36,'www.billshark.com','2022-12-16 21:29:26','2022-12-16 21:29:26');
/*!40000 ALTER TABLE `nocontacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opportunities`
--

DROP TABLE IF EXISTS `opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost_type` enum('dollar','Contact for Pricing') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Contact for Pricing',
  `cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opportunities`
--

LOCK TABLES `opportunities` WRITE;
/*!40000 ALTER TABLE `opportunities` DISABLE KEYS */;
INSERT INTO `opportunities` VALUES (4,17,'Instagram photo + video post','Contact for Pricing',NULL,NULL,'2022-09-07 21:48:10','2022-09-07 21:48:10'),(5,17,'Instagram reel','Contact for Pricing',NULL,NULL,'2022-09-07 21:48:19','2022-09-07 21:48:19'),(6,17,'Youtube video','Contact for Pricing',NULL,NULL,'2022-09-07 21:48:30','2022-09-07 21:48:30'),(7,17,'TikTok video','Contact for Pricing',NULL,NULL,'2022-09-07 21:48:37','2022-09-07 21:48:37'),(8,21,'Sponsored Post with Content Provided by Company','dollar','100',NULL,'2022-09-09 02:47:51','2022-09-09 02:47:51'),(9,21,'Sponsored Post with Content Written by Mel','dollar','200',NULL,'2022-09-09 02:48:10','2022-09-09 02:48:10'),(10,22,'Banner Ads (200x300) 1 Month','dollar','75',NULL,'2022-09-12 21:54:40','2022-09-12 21:54:40'),(11,22,'Sponsored Post','dollar','275',NULL,'2022-09-12 21:54:54','2022-09-12 21:54:54'),(12,22,'Deluxe Competition Giveaway','dollar','175',NULL,'2022-09-12 21:55:15','2022-09-12 21:55:15'),(13,22,'Newsletter Blast','dollar','125',NULL,'2022-09-12 21:55:27','2022-09-12 21:55:27'),(14,22,'Homepage Takeover - 1 Month','dollar','450',NULL,'2022-09-12 21:55:44','2022-09-12 21:55:44'),(16,36,'Q1 Placements (see media kit)','Contact for Pricing',NULL,'2023-03-31','2022-11-15 23:58:57','2023-01-11 23:33:34');
/*!40000 ALTER TABLE `opportunities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outreaches`
--

DROP TABLE IF EXISTS `outreaches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `outreaches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) DEFAULT NULL,
  `owner_id` bigint(20) DEFAULT NULL,
  `owner_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opportunities` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_sent` tinyint(1) NOT NULL DEFAULT 0,
  `io_date` date DEFAULT NULL,
  `notes` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manual` tinyint(1) NOT NULL DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outreaches`
--

LOCK TABLES `outreaches` WRITE;
/*!40000 ALTER TABLE `outreaches` DISABLE KEYS */;
INSERT INTO `outreaches` VALUES (26,8,52,7,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-08-09 04:43:39','2022-08-09 04:43:39'),(27,3,53,8,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,1,'2022-08-10 02:11:02','2022-08-10 02:13:11'),(35,12,52,7,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-08-18 00:49:28','2022-08-18 00:49:28'),(83,26,66,21,'App\\Models\\User','8',1,NULL,'Still pending content',NULL,NULL,0,0,'2022-09-16 18:00:56','2022-09-16 18:06:17'),(85,8,65,20,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,1,'2022-09-20 17:54:54','2022-11-02 22:09:22'),(89,34,67,22,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-11-02 20:52:13','2022-11-02 20:52:13'),(90,34,66,21,'App\\Models\\User','9',1,'2022-11-15','Signed on Impact - awaiting completed content',NULL,NULL,0,0,'2022-11-02 20:52:27','2022-11-15 23:53:14'),(91,20,72,27,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,1,'2022-11-02 21:05:16','2022-11-02 22:09:03'),(92,35,52,7,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-11-11 01:08:15','2022-11-11 01:08:15'),(93,35,68,23,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,1,'2022-11-11 01:08:19','2022-11-11 19:01:49'),(94,23,70,25,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-11-11 19:01:34','2022-11-11 19:01:34'),(95,36,80,35,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-12-07 18:47:54','2022-12-07 18:47:54'),(96,36,70,25,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-12-07 18:48:10','2022-12-07 18:48:10'),(97,36,88,43,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-12-28 22:40:44','2022-12-28 22:40:44'),(98,27,68,23,'App\\Models\\User',NULL,0,NULL,NULL,NULL,NULL,0,0,'2022-12-29 20:12:14','2022-12-29 20:12:14'),(99,34,NULL,NULL,NULL,NULL,0,NULL,'Reached out on 10/21/22','Test','test@aol.com',1,1,'2023-01-11 23:46:20','2023-01-11 23:46:20');
/*!40000 ALTER TABLE `outreaches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (1,'user','anatoliydan9@gmail.com',NULL,'2022-03-10 20:10:08'),(2,'user','todd@pubrecruiter.com','zDJuPjOTOYVT7GR6siX14ZSkH99drmUE','2022-03-11 00:17:15'),(3,'user','todd@creditcardgamer.com','Z2OgYo19CxWCCYHCvAQAwWawuqxdAhu5','2022-06-06 06:25:28'),(4,'user','limmor.kfiri@fiverr.com','b9LHa3rcAFvhtWmb7kytD41Wdv6SImKi','2022-08-28 14:52:25'),(5,'user','brokegirlrich@gmail.com',NULL,'2022-09-09 18:54:00'),(6,'user','amberbattishill@gmail.com',NULL,'2022-11-11 18:59:51');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',2,'LaravelSanctumAuth','96671b80954a2a583ef5136b99bd2d9eba52628498bdf2dcde06113c7c801e86','[\"*\"]','2022-08-10 11:06:02','2022-08-10 05:15:51','2022-08-10 11:06:02'),(2,'App\\Models\\User',2,'LaravelSanctumAuth','1fccedb8aa2e2121dd3ae563e899ddb1b50127f40ba0fd1fb2e52c6be1f50bd7','[\"*\"]','2022-08-10 11:09:03','2022-08-10 11:06:51','2022-08-10 11:09:03'),(3,'App\\Models\\User',2,'LaravelSanctumAuth','a847f793c078516f3c346403c3b9ee37686d444fb0076b76d35b554758e39eda','[\"*\"]','2022-08-10 11:20:45','2022-08-10 11:20:26','2022-08-10 11:20:45'),(4,'App\\Models\\User',2,'LaravelSanctumAuth','8a3fe137b5c13340f5ce068b5b1bf73afc861a473f2a728f1ddb9a431fd87ef3','[\"*\"]','2022-08-10 11:23:11','2022-08-10 11:23:02','2022-08-10 11:23:11'),(5,'App\\Models\\User',2,'LaravelSanctumAuth','e253c99f5ed07b5bdd0d8dd46f26bfaac6c0dd6c99b162087610adefa65c84ba','[\"*\"]','2022-08-10 22:27:31','2022-08-10 22:27:15','2022-08-10 22:27:31'),(6,'App\\Models\\User',2,'LaravelSanctumAuth','808c718952c2af29da9214ab548dd926dedc5e5b88a90bd7b05b6ef543ba0f2d','[\"*\"]','2022-08-11 06:31:52','2022-08-11 01:28:19','2022-08-11 06:31:52'),(7,'App\\Models\\User',2,'LaravelSanctumAuth','47d7cbe8241e36245e682cbbbbf6a060972ba2e4d4a30c5e402def7624837da9','[\"*\"]','2022-08-15 22:40:13','2022-08-14 05:18:29','2022-08-15 22:40:13'),(8,'App\\Models\\User',1,'LaravelSanctumAuth','44a818e721bac477816d24b1fbc038ca4669f6a0f990a447cc88f0832dfb1ac5','[\"*\"]','2022-08-14 05:30:15','2022-08-14 05:28:29','2022-08-14 05:30:15'),(9,'App\\Models\\User',2,'LaravelSanctumAuth','de37c37a5ec19818f1f989432b1f6f1cd471c46ddf257dd8db78bcd69fee322f','[\"*\"]','2022-08-15 22:08:01','2022-08-14 05:30:20','2022-08-15 22:08:01'),(10,'App\\Models\\User',9,'LaravelSanctumAuth','20276a297e1df62b5ee42cd2cea75e641306cd8b5a9abb3592894f1a028acb27','[\"*\"]','2022-08-16 19:51:05','2022-08-15 22:08:11','2022-08-16 19:51:05'),(11,'App\\Models\\User',8,'LaravelSanctumAuth','b49a00cd8641fed66ab1703980e7d526f7a93984e2e84a52a6dd349f4b6aba5c','[\"*\"]','2022-11-01 19:10:03','2022-08-16 19:53:50','2022-11-01 19:10:03'),(12,'App\\Models\\User',1,'LaravelSanctumAuth','042c595b00f429deb9558be57f34283809af7e3d7cc83cea7d867b45234ad362','[\"*\"]','2022-08-16 21:42:13','2022-08-16 21:42:12','2022-08-16 21:42:13'),(13,'App\\Models\\User',2,'LaravelSanctumAuth','1ab6c79de5bbcb8c041a0a9b0af394d6c549caffd1d471aa12e2203cafbb459e','[\"*\"]','2022-08-18 02:36:43','2022-08-17 00:58:54','2022-08-18 02:36:43'),(14,'App\\Models\\User',1,'LaravelSanctumAuth','f288cb8cc6966fedc76244b8a06e3a7eed65c5e0b3263c0ff06405553cf20907','[\"*\"]','2022-08-18 19:57:33','2022-08-18 02:36:50','2022-08-18 19:57:33'),(15,'App\\Models\\User',2,'LaravelSanctumAuth','25b60fc0df6bab7a681923376584915815fffb5dd8f7cb872dcbb0f4ad1f2d45','[\"*\"]','2022-08-20 21:01:34','2022-08-18 19:57:44','2022-08-20 21:01:34'),(16,'App\\Models\\User',2,'LaravelSanctumAuth','830fb18f3b10fa26614d0af1819f2dc6d2009c9173fc07453b6d0a84bb2c4d67','[\"*\"]','2022-08-21 18:48:19','2022-08-21 18:41:53','2022-08-21 18:48:19'),(17,'App\\Models\\User',2,'LaravelSanctumAuth','c0bc9fcf0ab163c7b944730539fe51819b3b6183e0f8c9ed71c9bf93373846d2','[\"*\"]','2022-08-25 02:30:06','2022-08-21 18:48:37','2022-08-25 02:30:06'),(18,'App\\Models\\User',14,'LaravelSanctumAuth','59ee93043e8a8820bbff2864621e9ef2d9d95b9fa5b94faf33c1bcd7f758a268','[\"*\"]','2022-09-11 20:41:41','2022-08-25 18:31:40','2022-09-11 20:41:41'),(19,'App\\Models\\User',14,'LaravelSanctumAuth','a7d6f9dc2b5b2416e39feef9d9c6065d06f210b0fb7aca00f01483680ce6dddd','[\"*\"]','2022-09-14 20:33:50','2022-09-07 03:37:00','2022-09-14 20:33:50'),(20,'App\\Models\\User',5,'LaravelSanctumAuth','2804d760758861c32c5bd96cd2c547e43e385e883efedd607f706cd716412ae3','[\"*\"]','2023-01-12 02:34:28','2022-10-13 18:27:08','2023-01-12 02:34:28'),(21,'App\\Models\\User',31,'LaravelSanctumAuth','191395b78d6dea478304438acc4e0ea2732fb03a3787f8c67e32ca5ad6c30d9c','[\"*\"]','2022-12-12 22:15:50','2022-10-13 21:22:18','2022-12-12 22:15:50'),(22,'App\\Models\\User',32,'LaravelSanctumAuth','6bcdd513c511d318d1aa386ea96d358d8e41e184f62be46cba9a11bf99299b28','[\"*\"]','2022-11-21 18:44:46','2022-10-26 13:22:31','2022-11-21 18:44:46'),(23,'App\\Models\\User',27,'LaravelSanctumAuth','f053dc6a5897f3fd4b2752db7f7ba95e1231b161f633312bac5f861694dc7173','[\"*\"]','2022-11-02 22:09:03','2022-10-26 21:16:09','2022-11-02 22:09:03'),(24,'App\\Models\\User',34,'LaravelSanctumAuth','f84e9cc32f93e9c4109b883a3169b216baaaf38d77e7c513a840fcbe429b9ee2','[\"*\"]','2022-11-18 23:55:03','2022-11-15 23:15:44','2022-11-18 23:55:03'),(25,'App\\Models\\User',36,'LaravelSanctumAuth','4af302a7cff22623db45acb11fac8996e73f56430259be78bd03b88d415940dc','[\"*\"]','2022-12-01 23:27:27','2022-11-18 23:55:13','2022-12-01 23:27:27'),(26,'App\\Models\\User',37,'LaravelSanctumAuth','bc3fcdfb4ac8a2b82ed9a9d7c8d865d3aae3d704ee1ff6c93596a59a2329b4a7','[\"*\"]','2022-12-02 00:31:37','2022-12-01 23:29:00','2022-12-02 00:31:37'),(27,'App\\Models\\User',36,'LaravelSanctumAuth','6c1d0a8b9960942f0ab657390910997504ee791c436de2c918226c9192909e58','[\"*\"]','2022-12-07 18:14:14','2022-12-02 00:31:46','2022-12-07 18:14:14'),(28,'App\\Models\\User',36,'LaravelSanctumAuth','8b2617cc824e655c61fadcf3c8e9c6f29aee1122285ebbc841d87702d28422ee','[\"*\"]',NULL,'2022-12-07 18:16:52','2022-12-07 18:16:52'),(29,'App\\Models\\User',36,'LaravelSanctumAuth','f3f16404d3c3552d130022d2a54e5dd35de92134b33994cf31280634511397f7','[\"*\"]','2022-12-07 18:33:54','2022-12-07 18:17:54','2022-12-07 18:33:54'),(30,'App\\Models\\User',36,'LaravelSanctumAuth','42f1f4e67d8655e67a7f2d3504fafbb227a568f90d959a0fbb821731655d6dda','[\"*\"]','2022-12-07 18:47:46','2022-12-07 18:24:26','2022-12-07 18:47:46'),(31,'App\\Models\\User',36,'LaravelSanctumAuth','94247d7d846c5be6ceeb67548c607fce53a387a62bbf283d4265a113c20e44f7','[\"*\"]','2022-12-07 22:18:09','2022-12-07 18:44:47','2022-12-07 22:18:09'),(32,'App\\Models\\User',36,'LaravelSanctumAuth','3418ce7879ec9bbe22c16086eae4528d93f1d6ae4258e99d69a39aa0925a9dbf','[\"*\"]','2022-12-16 21:34:32','2022-12-07 22:18:49','2022-12-16 21:34:32'),(33,'App\\Models\\User',5,'LaravelSanctumAuth','4a28db79dcb688c2be16948ffbcf209cf5030f510bc5c2aa8480083d3d811d52','[\"*\"]','2023-01-12 00:24:35','2022-12-16 04:28:36','2023-01-12 00:24:35'),(34,'App\\Models\\User',36,'LaravelSanctumAuth','211fcc129bf7ee0152a9b8325874ff79b9cdcd9a6d3f3176ba62fb14c69b7109','[\"*\"]','2022-12-29 21:01:32','2022-12-29 20:35:05','2022-12-29 21:01:32'),(35,'App\\Models\\User',27,'LaravelSanctumAuth','45f142f88bb6d09d91ee80e5683df69b0a038882872fc34074f704a0c5ce5826','[\"*\"]','2022-12-29 21:08:47','2022-12-29 21:01:48','2022-12-29 21:08:47'),(36,'App\\Models\\User',27,'LaravelSanctumAuth','1e3ed6bae479c9f916e86d2d6e4a72ea30124a7624f54e0180a85b7d478b4c31','[\"*\"]','2022-12-29 21:14:30','2022-12-29 21:08:54','2022-12-29 21:14:30'),(37,'App\\Models\\User',27,'LaravelSanctumAuth','2336cc4ce07d8d51dc8b501a4f6a1b16725b6501138bbb6172c7f9262f4d3cd7','[\"*\"]','2023-01-11 03:05:52','2023-01-02 20:36:48','2023-01-11 03:05:52'),(38,'App\\Models\\User',27,'LaravelSanctumAuth','73bd996a6132d2de4ff7f62d91bba95875ffa4793f63385eaa50930b30e2114f','[\"*\"]','2023-01-12 02:51:17','2023-01-11 03:06:28','2023-01-12 02:51:17');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommendations`
--

DROP TABLE IF EXISTS `recommendations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recommendations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `recommendation_user_id` bigint(20) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_time` tinyint(4) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recommendations`
--

LOCK TABLES `recommendations` WRITE;
/*!40000 ALTER TABLE `recommendations` DISABLE KEYS */;
INSERT INTO `recommendations` VALUES (1,27,17,'ladybossblogger@gmail.com',1,'this one is gret',0,'2023-01-11 03:08:19','2023-01-11 03:08:19');
/*!40000 ALTER TABLE `recommendations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `referral_codes`
--

DROP TABLE IF EXISTS `referral_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referral_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referral_codes`
--

LOCK TABLES `referral_codes` WRITE;
/*!40000 ALTER TABLE `referral_codes` DISABLE KEYS */;
INSERT INTO `referral_codes` VALUES (1,'TEST213','2022-09-14 18:16:46','2022-09-14 20:45:09'),(2,'Dustin','2022-09-15 20:49:11','2022-09-15 20:49:11');
/*!40000 ALTER TABLE `referral_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Brand','Creator') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (1,'Affluent','https://shareasale.com/r.cfm?b=1388009&u=1574996&m=89107&urllink=&afftrack=','uploads/resource/bPLzThpTESxLIXuIs0uUeNBE8gzxh1tknaKFwGDZ.png','Aggregate your Affiliate data in one spot!','Brand','2023-01-11 03:11:45','2023-01-11 03:12:25'),(2,'Refersion Marketplace','https://marketplace.refersion.com/?rfsn=6151486.587a716&utm_source=ambassador&utm_medium=referral&utm_campaign=6151486','uploads/resource/Dz62GpIH5rNhxmDj27ZiIHPicJ4aS18gPmeH9cb2.png','1000\'s of Exclusive and exciting Affiliate Programs','Creator','2023-01-11 23:38:35','2023-01-11 23:38:54'),(3,'Impact.com','http://app.impact.com/campaign-mediapartner-signup/Refer-Your-Friends-Publisher-Referral-Program.brand?type=dm&io=RlISKNmm%2Fh89n%2BS9i5fNE3ZZuc60keNWHHRgSqYz3nStL96dHoTQj4Y9k5G7KxVL','uploads/resource/OWcumUXQpgIicFRtySuC2LmThLkU5iG9sE0Bo2g2.png','Join Affiliate Programs like Target, Kohls, Walmart, Coinbase and more!','Creator','2023-01-11 23:40:36','2023-01-11 23:40:36');
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','Pub Recruiter','2022-03-10 06:34:33','2022-03-10 06:34:33'),(2,'site_url','https://extension.pubrecruiter.com/','2022-03-10 06:34:33','2022-12-13 20:23:19'),(3,'site_logo','uploads/settings/1PX2uSDiSx9Wy3jOKv2HEudBmIju76XAhH50IVKK.png','2022-03-10 06:34:33','2022-06-18 07:19:35'),(4,'favicon','uploads/settings/SWqkx5UrkOWaRVRNTWaeEGtBZgu9totXfIh81RIt.png','2022-03-10 06:34:33','2022-06-18 07:32:15'),(5,'contact_email','Partnerships@PubRecruiter.com','2022-03-10 06:34:33','2022-08-16 18:15:01'),(6,'partnership_email','Partnerships@PubRecruiter.com','2022-03-10 12:34:33','2022-03-10 12:34:33'),(7,'extension_link','https://chrome.google.com/webstore/detail/pub-recruiter/chfobgdkgknlemijfomlmoicedemnhbk','2022-03-10 12:34:33','2022-03-10 12:34:33'),(8,'stripe_link','https://buy.stripe.com/14k9BB8zkbkteBO7su','2022-03-10 18:34:33','2023-01-03 23:40:58');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_records`
--

DROP TABLE IF EXISTS `sub_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `contact_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_records`
--

LOCK TABLES `sub_records` WRITE;
/*!40000 ALTER TABLE `sub_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `media_kit_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_kit_description` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referral_code_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (2,25,NULL,NULL,NULL,'2022-09-15 21:54:43','2022-09-15 21:54:43'),(3,26,NULL,NULL,NULL,'2022-09-16 18:00:00','2022-09-16 18:00:00'),(4,27,NULL,NULL,NULL,'2022-09-19 18:13:43','2022-09-19 18:13:43'),(6,29,NULL,NULL,NULL,'2022-09-19 18:20:03','2022-09-19 18:20:03'),(8,1,NULL,NULL,NULL,'2022-09-23 18:38:37','2022-09-23 18:38:37'),(11,23,NULL,NULL,NULL,'2022-10-26 19:37:12','2022-10-26 19:37:12'),(13,34,NULL,NULL,NULL,'2022-11-02 20:47:00','2022-11-02 20:47:00'),(14,35,NULL,NULL,NULL,'2022-11-09 23:08:42','2022-11-09 23:08:42'),(15,8,NULL,NULL,NULL,'2022-11-09 23:21:16','2022-11-09 23:21:16'),(16,36,'https://docsend.com/view/mv45sq76m5b54bqc','Q4 Media Offerings',NULL,'2022-11-15 23:54:45','2022-11-15 23:57:03'),(17,37,NULL,NULL,NULL,'2022-11-16 00:32:48','2022-11-16 00:32:48'),(18,38,NULL,NULL,NULL,'2022-11-16 01:54:57','2022-11-16 01:54:57'),(19,39,NULL,NULL,NULL,'2022-11-16 20:12:23','2022-11-16 20:12:23'),(20,40,NULL,NULL,NULL,'2022-12-06 23:01:24','2022-12-06 23:01:24'),(21,41,NULL,NULL,NULL,'2022-12-07 03:49:37','2022-12-07 03:49:37'),(22,42,NULL,NULL,NULL,'2022-12-07 23:22:02','2022-12-07 23:22:02'),(23,43,NULL,NULL,NULL,'2022-12-12 22:55:55','2022-12-12 22:55:55'),(24,44,NULL,NULL,NULL,'2022-12-12 23:02:47','2022-12-12 23:02:47'),(25,45,NULL,NULL,NULL,'2022-12-14 00:08:52','2022-12-14 00:08:52'),(26,46,NULL,NULL,NULL,'2022-12-15 01:46:18','2022-12-15 01:46:18'),(27,5,NULL,NULL,NULL,'2022-12-28 22:53:07','2022-12-28 22:53:07'),(29,48,NULL,NULL,NULL,'2023-01-10 20:55:01','2023-01-10 20:55:01');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Pub Recruiter Founder','todd@pubrecruiter.com',NULL,'$2y$10$AO/ybS/WQ6XiCc8BV61vIe7MR9R/NK4SG2sxFRpsdOmk1lVO.OWt2','Brand',NULL,NULL,1,1,NULL,'2022-03-10 20:11:10','2022-09-23 18:38:37'),(5,'Partnerality','galen@partnerality.com',NULL,'$2y$10$Z/ra8iOMyZ1ercYvH2Tjh.by8UHnDxmi0YjGVKuBzmgabO6x1va6K','Creator','2022-07-18','2029-07-25',1,1,NULL,'2022-07-18 10:54:08','2022-12-28 22:53:07'),(6,'Sharper Image','mfernandes@sharperimageonline.com',NULL,'$2y$10$n3cv2pW2y35VKcckTinp3.3Ahpgc5jORL2n9QmkWkAc0GRf/bNumC','Brand','2022-07-20','2041-03-01',1,1,NULL,'2022-07-28 08:30:38','2022-07-28 09:19:18'),(7,'The Budget Savvy Bride','jessica@thebudgetsavvybride.com',NULL,'$2y$10$rysnr6Nt7Ppf3BgQVoggQeLQZwoA4hyZSoJrlz.vM2zBaHmJO65Wi','Creator',NULL,NULL,1,1,NULL,'2022-08-03 04:50:20','2022-08-03 04:50:20'),(8,'HoneyBricks','ryan.kaldani@honeybricks.com',NULL,'$2y$10$4mKLK/8OLJPeW74TAR2se.do.bRO9P8L3P/WOiwWr8K0OPAThSZDG','Brand',NULL,NULL,1,1,NULL,'2022-08-06 04:14:52','2022-11-09 23:21:16'),(12,'Kikoff','steven@kikoff.com',NULL,'$2y$10$S522XtWDHoyOj/8JJLP9A.i6U2LVfM3FZTXuHcUOUd6ANUcedPvUy','Brand',NULL,NULL,1,1,NULL,'2022-08-18 00:49:01','2022-08-18 00:49:01'),(13,'Rocket Money','jessica@rocketmoney.com',NULL,'$2y$10$CLlAc7pBlt6dNoZGrEEHCOpm9bw.653WiyjFS4dT31QuvbO1eEHbC','Brand',NULL,NULL,1,1,NULL,'2022-08-24 03:59:02','2022-08-24 03:59:02'),(15,'Acorns','conor.robbins.contractor@acorns.com',NULL,'$2y$10$cl2qYEbVWIVvutW5tsvjdO5q58qYfZZ9JnqqTV3tp8aSjRZCc6a7q','Brand',NULL,NULL,1,1,NULL,'2022-08-28 21:56:08','2022-08-28 21:56:08'),(17,'Lady Boss Blogger','ladybossblogger@gmail.com',NULL,'$2y$10$k8oNsynKn7kgQFMM3AzFUOPm5CQgoKbisI/shxxX3ttPQU.3/XuwK','Creator',NULL,NULL,1,1,NULL,'2022-09-07 21:46:20','2022-09-07 21:46:20'),(19,'Kovo Credit','partners@kovocredit.com',NULL,'$2y$10$THOMYNOWk0VYS22KIxzk3u17nKBIH/NDjEe/QCT26LNNzohXb2sm.','Brand',NULL,NULL,1,1,NULL,'2022-09-08 19:43:44','2022-09-08 19:43:44'),(20,'Financial Panther','kevin@financialpanther.com',NULL,'$2y$10$pk377vexab8Z5QCpf42eEuWHi4FrUIhRa7Pkl1n8/XqrhNt1Gn/7W','Creator',NULL,NULL,1,1,NULL,'2022-09-09 00:00:03','2022-09-09 00:00:03'),(21,'Broke Girl Rich','brokeGIRLrich@gmail.com',NULL,'$2y$10$oD8ni/84WuJi.OyTI/6/xudFOgHzwuFmwSEeM9z9SCk8rb3K6Stn6','Creator',NULL,NULL,1,1,NULL,'2022-09-09 02:46:49','2022-09-09 18:54:21'),(22,'Eluxe Magazine','chere@eluxemagazine.com',NULL,'$2y$10$WhcNDRGpZDJN8Sp3KopaRONzqN2pKM9QRznzwdmPuCYqZ.NStJK2m','Creator',NULL,NULL,1,1,NULL,'2022-09-12 17:24:09','2022-09-12 17:24:09'),(23,'Mommy Gone Healthy','amberbattishill@gmail.com',NULL,'$2y$10$d4XwIj9B/NQH.IjOP/btKOEKa8JCaepJn6i8wGJOzDvgZ3eo8GDi.','Creator',NULL,NULL,1,1,NULL,'2022-09-12 18:16:05','2022-11-11 19:00:25'),(25,'Hatch','caroline@hatchbaby.com',NULL,'$2y$10$3Ua35.kZL5376f8L7Q/BPu0tqFLuJqJtgUt1RrVRxhw2eLL/1XMuq','Brand',NULL,NULL,1,1,NULL,'2022-09-15 21:54:43','2022-09-15 21:54:43'),(26,'Test Brand','testbrand@pubrecruiter.com',NULL,'$2y$10$bd7WLs15Fl0YJ83XJv0PFOi/pGy2TUe7w9B/RPm6xCBQk3XFQ3Is6','Brand',NULL,NULL,1,1,NULL,'2022-09-16 18:00:00','2022-09-16 18:00:00'),(27,'Neighbor','affiliates@neighbor.com',NULL,'$2y$10$YAA/Hbm4VFjCvumAVxzFHe63MrmexgTHZQSbPtSgHKDWOs1D4tuGe','Brand',NULL,NULL,1,1,NULL,'2022-09-19 18:13:43','2022-09-19 18:13:43'),(29,'Survey Junkie','devon.n@surveyjunkie.com',NULL,'$2y$10$I.Do/80j7rCL7.qVzXyHL.PmXTSiKgWLMVXRFc.Pfi46TtzBZgW1O','Brand',NULL,NULL,1,1,NULL,'2022-09-19 18:20:03','2022-09-19 18:20:03'),(34,'Pub Recruiter Muffins','testpubrecruiter@pubrecruiter.com',NULL,'$2y$10$HT4zZwalAsJyW7S.1ME4iOvQ6DDZvcYugSbMWvRhvY9G5QK8UJxSm','Brand',NULL,NULL,1,1,NULL,'2022-11-02 20:47:00','2023-01-11 23:44:15'),(35,'Tinto','info@drinktinto.com',NULL,'$2y$10$mHRdWDrXwYpYTBE9Vh.EDu.LRkVE4TsMWtoAJYBljsz2Fbo40NRYW','Brand',NULL,NULL,1,1,NULL,'2022-11-09 23:08:42','2022-11-11 22:56:41'),(36,'The Quality Edit','lauren@thequalityedit.com',NULL,'$2y$10$eGX8ICYuuboyw7QowdAogOfwXGCh5D6wW8UUIKaRrW6f4XqbDMSRi','Creator',NULL,NULL,1,1,NULL,'2022-11-15 23:54:45','2022-11-15 23:54:45'),(37,'Keetsa','affiliatemanager@keetsa.com',NULL,'$2y$10$6PVTKjcNcn1/HAK62Qx7Au4f9q8OOIfCnddxLcAmyxFAIqx/Em9o2','Brand',NULL,NULL,1,1,NULL,'2022-11-16 00:32:48','2022-11-16 00:32:48'),(38,'Dealnews','scortazzo@dealnews.com',NULL,'$2y$10$8E4l9lBKRYqfW4EGMq6KDuhQJ7J9YKXuxxfcOPnYbAWX2BuHIBwKW','Creator',NULL,NULL,1,1,NULL,'2022-11-16 01:54:57','2022-11-16 01:54:57'),(39,'Augusta Precious Metals','fjeanbart@augustapreciousmetals.com',NULL,'$2y$10$YlQ8YA6iR9xKrQal7omfu.BqhYxs0.a.rIeK7D6CyziVYPK4F7Kca','Brand',NULL,NULL,1,1,NULL,'2022-11-16 20:12:23','2022-11-16 20:12:23'),(40,'RetirementLiving','ashley@retirementliving.com',NULL,'$2y$10$zlGwrPYWf8xXkW2IpkXTbOhRzpO7kQnscvrf2OrZsAILwF41nZkc6','Creator',NULL,NULL,1,1,NULL,'2022-12-06 23:01:24','2022-12-06 23:01:24'),(41,'UpSellit','cyoun@upsellit.com',NULL,'$2y$10$a5TwlSGiq1lJJEFFLHqp6OWTkt7Q9UdhGscMHbpY4BW96313Rqxw.','Creator',NULL,NULL,1,1,NULL,'2022-12-07 03:49:37','2022-12-07 03:49:37'),(42,'Nanit','affiliates@nanit.com',NULL,'$2y$10$JIEDuGK0gHzqonxfpbkQzeOostcqrE2cmJOM8kFFKuFyvD6Vm3SK.','Brand',NULL,NULL,1,1,NULL,'2022-12-07 23:22:02','2022-12-08 00:06:12'),(43,'Switchbot','affiliate@switch-bot.com',NULL,'$2y$10$HkBcVAbDVdxZSrsOdaFrdu7q9lhXOcNAIJiH5RvriTB4RRdArsOEy','Brand',NULL,NULL,1,1,NULL,'2022-12-12 22:55:55','2022-12-12 22:55:55'),(44,'Greenworks','affiliate@marcoregroup.com',NULL,'$2y$10$7lr8PauPM8Ctz9wfGTtVOOxqvrciG5wQwTorZx.78xiNDsXVL0qwi','Brand',NULL,NULL,1,1,NULL,'2022-12-12 23:02:47','2022-12-12 23:02:47'),(45,'Trustworthy','mariah@trustworthy.com',NULL,'$2y$10$29RYx.tLjBlIUQcuQ8msxO0EPHoojtIUP3ee9uzofXLaHiIZfQuaS','Brand',NULL,NULL,1,1,NULL,'2022-12-14 00:08:52','2022-12-14 00:08:52'),(46,'Gen3 Marketing','nyorgiadis@gen3marketing.com',NULL,'$2y$10$0nS1GBJqKIx0gvpTbLJzCOlD7k6r8AcYdCJt1ntv3a7yCnqQA6u12','Brand',NULL,NULL,1,1,NULL,'2022-12-15 01:46:18','2022-12-15 01:46:18'),(48,'Subscriboxer','ewen@venture4thmedia.com',NULL,'$2y$10$yOPSnQiN4iMc95BqJ7cvtuoURQuxsynxpUVwJQhNM6IN5nRApK0Rm','Creator',NULL,NULL,1,1,NULL,'2023-01-10 20:55:01','2023-01-10 20:55:01');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-01-11 23:52:06
