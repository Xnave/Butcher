-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: sales
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Zara','2015-08-12 16:02:13','2015-08-12 16:02:13'),(2,'Renuar','2015-08-12 16:10:49','2015-08-12 16:10:49'),(3,'Fox','2015-08-12 16:12:34','2015-08-12 16:12:34'),(4,'Lee Cooper','2015-08-12 20:40:51','2015-08-12 20:40:53');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands_sales`
--

DROP TABLE IF EXISTS `brands_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands_sales` (
  `brand_id` int(10) unsigned NOT NULL,
  `sale_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`brand_id`,`sale_id`),
  KEY `brands_sales_sale_id_foreign` (`sale_id`),
  CONSTRAINT `brands_sales_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`),
  CONSTRAINT `brands_sales_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands_sales`
--

LOCK TABLES `brands_sales` WRITE;
/*!40000 ALTER TABLE `brands_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `brands_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centers`
--

DROP TABLE IF EXISTS `centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centers`
--

LOCK TABLES `centers` WRITE;
/*!40000 ALTER TABLE `centers` DISABLE KEYS */;
INSERT INTO `centers` VALUES (1,'Kenyon Holon','mifratz shlomo 5, Holon','0526595632','2015-08-12 16:04:02','2015-08-12 16:04:02'),(2,'Kenyon Hazaav','hankin 7, Holon',NULL,'2015-08-12 16:11:02','2015-08-12 16:11:02'),(3,'G center','Lazarov 1, Holon','03-5595644','2015-08-12 16:12:39','2015-08-12 16:12:39');
/*!40000 ALTER TABLE `centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_08_02_183717_create_brands_table',1),('2015_08_03_075800_create_centers_table',1),('2015_08_03_174416_create_stores_table',1),('2015_08_03_184921_create_sale_types_table',1),('2015_08_03_190244_create_sales_table',1),('2015_08_05_183943_create_brands_sales_table',1),('2015_08_06_194540_create_user_brands_table',1),('2015_08_06_194603_create_user_stores_table',1),('2015_08_06_201839_create_user_watched_sales_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale_types`
--

DROP TABLE IF EXISTS `sale_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale_types`
--

LOCK TABLES `sale_types` WRITE;
/*!40000 ALTER TABLE `sale_types` DISABLE KEYS */;
INSERT INTO `sale_types` VALUES (1,'percentage','2015-08-12 19:35:51','2015-08-12 19:39:57'),(2,'onePlusOne','2015-08-12 20:43:40','2015-08-12 20:43:42'),(3,'twoPlusOne','2015-08-12 20:44:57','2015-08-12 20:44:59');
/*!40000 ALTER TABLE `sale_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `store_id` int(10) unsigned DEFAULT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `percentage` tinyint(4) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `start_day` date NOT NULL,
  `end_day` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `sales_user_id_foreign` (`user_id`),
  KEY `sales_store_id_foreign` (`store_id`),
  KEY `sales_type_id_foreign` (`type_id`),
  CONSTRAINT `sales_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `sale_types` (`id`),
  CONSTRAINT `sales_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,1,1,1,50,NULL,'jeans,t-shirt','buy today!!','2015-08-12','2015-08-31','2015-08-12 16:45:21','2015-08-12 16:45:21'),(2,2,2,2,NULL,NULL,'shoes','nice shoes','2015-08-13','2015-08-17','2015-08-12 21:06:39','2015-08-12 21:06:40');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `brand_id` int(10) unsigned DEFAULT NULL,
  `center_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `stores_brand_id_foreign` (`brand_id`),
  KEY `stores_center_id_foreign` (`center_id`),
  CONSTRAINT `stores_center_id_foreign` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`),
  CONSTRAINT `stores_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (1,NULL,'052-6595634','somwhere in holon',3,3,'2015-08-12 16:13:02','2015-08-12 16:13:02'),(2,'Rami Cloths','052-6595234','somewhere in eilat',NULL,1,'2015-08-12 20:47:16','2015-08-12 20:47:18');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_brands`
--

DROP TABLE IF EXISTS `user_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_brands` (
  `user_id` int(10) unsigned NOT NULL,
  `brand_id` int(10) unsigned NOT NULL,
  `grading` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`brand_id`,`user_id`),
  KEY `user_brands_user_id_foreign` (`user_id`),
  CONSTRAINT `user_brands_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_brands`
--

LOCK TABLES `user_brands` WRITE;
/*!40000 ALTER TABLE `user_brands` DISABLE KEYS */;
INSERT INTO `user_brands` VALUES (1,1,3,'2015-08-12 20:53:01','2015-08-12 20:53:02'),(2,1,5,'2015-08-12 20:54:44','2015-08-12 20:54:45'),(1,2,5,'2015-08-12 20:53:10','2015-08-12 20:53:12'),(2,2,2,'2015-08-12 20:55:03','2015-08-12 20:55:05'),(1,3,1,'2015-08-12 20:53:22','2015-08-12 20:53:24'),(2,3,4,'2015-08-12 20:55:30','2015-08-12 20:55:32');
/*!40000 ALTER TABLE `user_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_stores`
--

DROP TABLE IF EXISTS `user_stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_stores` (
  `user_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `grading` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`store_id`,`user_id`),
  KEY `user_stores_user_id_foreign` (`user_id`),
  CONSTRAINT `user_stores_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_stores_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_stores`
--

LOCK TABLES `user_stores` WRITE;
/*!40000 ALTER TABLE `user_stores` DISABLE KEYS */;
INSERT INTO `user_stores` VALUES (1,1,3,'2015-08-12 20:56:09','2015-08-12 20:56:11'),(2,1,5,'2015-08-12 20:56:20','2015-08-12 20:56:21');
/*!40000 ALTER TABLE `user_stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_watched_sales`
--

DROP TABLE IF EXISTS `user_watched_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_watched_sales` (
  `user_id` int(10) unsigned NOT NULL,
  `sale_id` int(10) unsigned NOT NULL,
  `grading` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`sale_id`,`user_id`),
  KEY `user_watched_sales_user_id_foreign` (`user_id`),
  CONSTRAINT `user_watched_sales_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_watched_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_watched_sales`
--

LOCK TABLES `user_watched_sales` WRITE;
/*!40000 ALTER TABLE `user_watched_sales` DISABLE KEYS */;
INSERT INTO `user_watched_sales` VALUES (1,1,5,'2015-08-12 21:06:59','2015-08-12 21:07:00'),(2,1,3,'2015-08-12 21:07:21','2015-08-12 21:07:22'),(1,2,1,'2015-08-12 21:07:11','2015-08-12 21:07:12'),(2,2,2,'2015-08-12 21:07:32','2015-08-12 21:07:33');
/*!40000 ALTER TABLE `user_watched_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'nave','eni','nave@eni.com','$2y$10$Ba7Xlp6bjNJS/5C48Nkkoe9TPRj9WZNSN9pC1QR4QZgUFBqs9qRoK','UC9PaaAnVhXyNOq4b6yY1ivwvhcg1HoHdjcn7GtbaTDrARjsAIDqh0F86okm','2015-08-12 17:52:03','2015-08-12 17:53:46'),(2,'doron','mor','doron@mor.com','$2y$10$tkrxkf/Wni7zdd3WVkk0uOFXe9GEn5IZ4SVuzyL1htCUWv2ZMckcy',NULL,'2015-08-12 17:54:20','2015-08-12 17:54:20');
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

-- Dump completed on 2015-08-13  0:11:15
