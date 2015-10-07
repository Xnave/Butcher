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
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Zara','2015-08-12 16:02:13','2015-08-12 16:02:13'),(2,'Renuar','2015-08-12 16:10:49','2015-08-12 16:10:49'),(3,'Fox2','2015-08-12 16:12:34','2015-08-21 09:44:12'),(4,'Lee Cooper','2015-08-12 20:40:51','2015-08-12 20:40:53');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `brands_sales`
--

LOCK TABLES `brands_sales` WRITE;
/*!40000 ALTER TABLE `brands_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `brands_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `centers`
--

LOCK TABLES `centers` WRITE;
/*!40000 ALTER TABLE `centers` DISABLE KEYS */;
INSERT INTO `centers` VALUES (1,'Kenyon Holon','mifratz shlomo 5, Holon','0526595632','2015-08-12 16:04:02','2015-08-12 16:04:02'),(2,'Kenyon Hazaav','hankin 7, Holon','','2015-08-12 16:11:02','2015-08-12 16:11:02'),(3,'G center','Lazarov 1, Holon','03-5595644','2015-08-12 16:12:39','2015-08-21 07:38:26');
/*!40000 ALTER TABLE `centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_08_02_183717_create_brands_table',1),('2015_08_03_075800_create_centers_table',1),('2015_08_03_174416_create_stores_table',1),('2015_08_03_184921_create_sale_types_table',1),('2015_08_03_190244_create_sales_table',1),('2015_08_05_183943_create_brands_sales_table',1),('2015_08_06_194540_create_user_brands_table',1),('2015_08_06_194603_create_user_stores_table',1),('2015_08_06_201839_create_user_watched_sales_table',1),('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_08_02_183717_create_brands_table',1),('2015_08_03_075800_create_centers_table',1),('2015_08_03_174416_create_stores_table',1),('2015_08_03_184921_create_sale_types_table',1),('2015_08_03_190244_create_sales_table',1),('2015_08_05_183943_create_brands_sales_table',1),('2015_08_06_194540_create_user_brands_table',1),('2015_08_06_194603_create_user_stores_table',1),('2015_08_06_201839_create_user_watched_sales_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sale_types`
--

LOCK TABLES `sale_types` WRITE;
/*!40000 ALTER TABLE `sale_types` DISABLE KEYS */;
INSERT INTO `sale_types` VALUES (1,'percentage','2015-08-12 19:35:51','2015-08-12 19:39:57'),(2,'onePlusOne','2015-08-12 20:43:40','2015-08-12 20:43:42'),(3,'twoPlusOne','2015-08-12 20:44:57','2015-08-12 20:44:59');
/*!40000 ALTER TABLE `sale_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,1,1,1,50,NULL,'jeans,t-shirt','buy today!!','2015-08-12','2015-08-31','2015-08-12 16:45:21','2015-08-12 16:45:21'),(2,2,2,2,NULL,NULL,'shoes','nice shoes','2015-08-13','2015-08-17','2015-08-12 21:06:39','2015-08-12 21:06:40');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (1,NULL,'052-6595634','somwhere in holon',3,3,'2015-08-12 16:13:02','2015-08-12 16:13:02'),(2,'Rami Cloths','052-6595233','somewhere in eilat',NULL,1,'2015-08-12 20:47:16','2015-08-21 17:13:04'),(11,'nave shop',NULL,'ראשון לציון',NULL,2,'2015-08-21 17:14:24','2015-08-21 17:14:24');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_brands`
--

LOCK TABLES `user_brands` WRITE;
/*!40000 ALTER TABLE `user_brands` DISABLE KEYS */;
INSERT INTO `user_brands` VALUES (1,1,3,'2015-08-12 20:53:01','2015-08-12 20:53:02'),(2,1,5,'2015-08-12 20:54:44','2015-08-12 20:54:45'),(1,2,5,'2015-08-12 20:53:10','2015-08-12 20:53:12'),(2,2,2,'2015-08-12 20:55:03','2015-08-12 20:55:05'),(1,3,1,'2015-08-12 20:53:22','2015-08-12 20:53:24'),(2,3,4,'2015-08-12 20:55:30','2015-08-12 20:55:32');
/*!40000 ALTER TABLE `user_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_stores`
--

LOCK TABLES `user_stores` WRITE;
/*!40000 ALTER TABLE `user_stores` DISABLE KEYS */;
INSERT INTO `user_stores` VALUES (1,1,3,'2015-08-12 20:56:09','2015-08-12 20:56:11'),(2,1,5,'2015-08-12 20:56:20','2015-08-12 20:56:21');
/*!40000 ALTER TABLE `user_stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_watched_sales`
--

LOCK TABLES `user_watched_sales` WRITE;
/*!40000 ALTER TABLE `user_watched_sales` DISABLE KEYS */;
INSERT INTO `user_watched_sales` VALUES (1,1,5,'2015-08-12 21:06:59','2015-08-12 21:07:00'),(2,1,3,'2015-08-12 21:07:21','2015-08-12 21:07:22'),(1,2,1,'2015-08-12 21:07:11','2015-08-12 21:07:12'),(2,2,2,'2015-08-12 21:07:32','2015-08-12 21:07:33');
/*!40000 ALTER TABLE `user_watched_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'nave','eni','nave@eni.com','$2y$10$Ba7Xlp6bjNJS/5C48Nkkoe9TPRj9WZNSN9pC1QR4QZgUFBqs9qRoK','UC9PaaAnVhXyNOq4b6yY1ivwvhcg1HoHdjcn7GtbaTDrARjsAIDqh0F86okm','2015-08-12 17:52:03','2015-08-12 17:53:46'),(2,'doron','mor','doron@mor.com','$2y$10$tkrxkf/Wni7zdd3WVkk0uOFXe9GEn5IZ4SVuzyL1htCUWv2ZMckcy','CCIKYZolC4oR6Yzn5ssxabKjl1YbUSOW4nJmdpUZYQw0Ad3PQVCL01SIaycZ','2015-08-12 17:54:20','2015-08-22 11:49:15');
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

-- Dump completed on 2015-08-22 18:03:47
