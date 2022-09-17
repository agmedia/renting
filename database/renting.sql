-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: localhost    Database: renting
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `abilities`
--

DROP TABLE IF EXISTS `abilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `abilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `only_owned` tinyint(1) NOT NULL DEFAULT '0',
  `options` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `abilities_scope_index` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `abilities`
--

LOCK TABLES `abilities` WRITE;
/*!40000 ALTER TABLE `abilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `abilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_actions`
--

DROP TABLE IF EXISTS `apartment_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(15,4) DEFAULT NULL,
  `extra` decimal(15,4) DEFAULT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `links` text COLLATE utf8mb4_unicode_ci,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `badge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logged` tinyint(1) NOT NULL DEFAULT '0',
  `uses_customer` int(10) unsigned NOT NULL DEFAULT '1',
  `viewed` int(10) unsigned NOT NULL DEFAULT '0',
  `clicked` int(10) unsigned NOT NULL DEFAULT '0',
  `repeat` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_actions`
--

LOCK TABLES `apartment_actions` WRITE;
/*!40000 ALTER TABLE `apartment_actions` DISABLE KEYS */;
INSERT INTO `apartment_actions` VALUES (1,'P',10.0000,10.0000,'apartment','[\"3\"]','2022-09-13 22:00:00','2022-09-15 22:00:00',NULL,0,1,0,0,0,0,'2022-09-15 15:57:07','2022-09-16 16:05:16'),(2,'P',0.0000,10.0000,'all','[\"all\"]','2022-08-31 22:00:00','2022-09-30 22:00:00',NULL,0,1,0,0,0,1,'2022-09-15 16:23:44','2022-09-17 14:50:32');
/*!40000 ALTER TABLE `apartment_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_actions_translations`
--

DROP TABLE IF EXISTS `apartment_actions_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_actions_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_action_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_actions_translations_apartment_action_id_index` (`apartment_action_id`),
  CONSTRAINT `apartment_actions_translations_apartment_action_id_foreign` FOREIGN KEY (`apartment_action_id`) REFERENCES `apartment_actions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_actions_translations`
--

LOCK TABLES `apartment_actions_translations` WRITE;
/*!40000 ALTER TABLE `apartment_actions_translations` DISABLE KEYS */;
INSERT INTO `apartment_actions_translations` VALUES (1,1,'hr','Hrvatski','2022-09-15 15:57:07','2022-09-16 16:05:16'),(2,1,'en','Testing','2022-09-15 15:57:07','2022-09-16 16:05:16'),(3,2,'hr','Hrv. Naslov Akcije','2022-09-15 16:23:44','2022-09-17 14:50:32'),(4,2,'en','Eng. Action Title','2022-09-15 16:23:44','2022-09-17 14:50:32');
/*!40000 ALTER TABLE `apartment_actions_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_details`
--

DROP TABLE IF EXISTS `apartment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery_id` int(10) unsigned DEFAULT NULL,
  `amenity` tinyint(1) NOT NULL DEFAULT '0',
  `favorite` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_details_apartment_id_index` (`apartment_id`),
  CONSTRAINT `apartment_details_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=381 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_details`
--

LOCK TABLES `apartment_details` WRITE;
/*!40000 ALTER TABLE `apartment_details` DISABLE KEYS */;
INSERT INTO `apartment_details` VALUES (299,3,'0','1','hair_dryer.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(300,3,'0','40','bidet.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(301,3,'0','61','bathtub.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(302,3,'0','9','extra_pillows_and_blankets.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(303,3,'0','10','iron.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(304,3,'0','16','carbon_monoxide_alarm.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(305,3,'0','24','dishes_and_silverware.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(306,3,'0','47','mini_fridge.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(307,3,'0','56','private_patio_or_balcony.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(308,3,'0','57','outdoor_furniture.svg',0,1,0,1,'2022-09-13 12:29:55','2022-09-13 12:29:55'),(367,13,'0','14','heating.svg',0,1,0,1,'2022-09-13 19:13:38','2022-09-13 19:13:38'),(368,13,'0','16','carbon_monoxide_alarm.svg',0,1,0,1,'2022-09-13 19:13:38','2022-09-13 19:13:38'),(375,2,'0','1','hair_dryer.svg',0,1,0,1,'2022-09-16 16:29:52','2022-09-16 16:29:52'),(376,2,'0','39','cleaning_products.svg',0,1,0,1,'2022-09-16 16:29:52','2022-09-16 16:29:52'),(377,2,'0','43','clothing_storage.svg',0,1,0,1,'2022-09-16 16:29:52','2022-09-16 16:29:52'),(378,2,'0','21','refrigerator.svg',0,1,0,1,'2022-09-16 16:29:52','2022-09-16 16:29:52'),(379,2,'0','32','ev_charger.svg',0,1,0,1,'2022-09-16 16:29:52','2022-09-16 16:29:52'),(380,2,'0','34','self_check_in.svg',0,1,0,1,'2022-09-16 16:29:52','2022-09-16 16:29:52');
/*!40000 ALTER TABLE `apartment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_details_translations`
--

DROP TABLE IF EXISTS `apartment_details_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_details_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_detail_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `group_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_details_translations_apartment_detail_id_index` (`apartment_detail_id`),
  CONSTRAINT `apartment_details_translations_apartment_detail_id_foreign` FOREIGN KEY (`apartment_detail_id`) REFERENCES `apartment_details` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=761 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_details_translations`
--

LOCK TABLES `apartment_details_translations` WRITE;
/*!40000 ALTER TABLE `apartment_details_translations` DISABLE KEYS */;
INSERT INTO `apartment_details_translations` VALUES (597,299,'hr','Sušilo','','Kupaonica','2022-09-13 12:29:55','2022-09-13 12:29:55'),(598,299,'en','Hair dryer','','Bathroom','2022-09-13 12:29:55','2022-09-13 12:29:55'),(599,300,'hr','Bidet','','Kupaonica','2022-09-13 12:29:55','2022-09-13 12:29:55'),(600,300,'en','Bidet','','Bathroom','2022-09-13 12:29:55','2022-09-13 12:29:55'),(601,301,'hr','Kada','','Kupaonica','2022-09-13 12:29:55','2022-09-13 12:29:55'),(602,301,'en','Bathtub','','Bathroom','2022-09-13 12:29:55','2022-09-13 12:29:55'),(603,302,'hr','Dodatni jastuci i deke','','Spavaća soba i praonica rublja','2022-09-13 12:29:55','2022-09-13 12:29:55'),(604,302,'en','Extra pillows and blankets','','Bedroom and laundry','2022-09-13 12:29:55','2022-09-13 12:29:55'),(605,303,'hr','Pegla','','Spavaća soba i praonica rublja','2022-09-13 12:29:55','2022-09-13 12:29:55'),(606,303,'en','Iron','','Bedroom and laundry','2022-09-13 12:29:55','2022-09-13 12:29:55'),(607,304,'hr','Alarm za ugljični monoksid','','Sigurnost','2022-09-13 12:29:55','2022-09-13 12:29:55'),(608,304,'en','Carbon monoxide alarm','','Home safety','2022-09-13 12:29:55','2022-09-13 12:29:55'),(609,305,'hr','Posuđe i srebrnina','Zdjele, štapići, tanjuri, šalice itd.','Kuhinja','2022-09-13 12:29:55','2022-09-13 12:29:55'),(610,305,'en','Dishes and silverware','Bowls, chopsticks, plates, cups, etc.','Kitchen and dining','2022-09-13 12:29:55','2022-09-13 12:29:55'),(611,306,'hr','Mini hladnjak','','Kuhinja','2022-09-13 12:29:55','2022-09-13 12:29:55'),(612,306,'en','Mini fridge','','Kitchen and dining','2022-09-13 12:29:55','2022-09-13 12:29:55'),(613,307,'hr','Kuća na jednom katu','','Vanjski sadržaji','2022-09-13 12:29:55','2022-09-13 12:29:55'),(614,307,'en','Private patio or balcony','','Outdoor','2022-09-13 12:29:55','2022-09-13 12:29:55'),(615,308,'hr','Vanjski namještaj','','Vanjski sadržaji','2022-09-13 12:29:55','2022-09-13 12:29:55'),(616,308,'en','Outdoor furniture','','Outdoor','2022-09-13 12:29:55','2022-09-13 12:29:55'),(733,367,'hr','Grijanje','','Grijanje i hlađenje','2022-09-13 19:13:38','2022-09-13 19:13:38'),(734,367,'en','Heating','','Heating and cooling','2022-09-13 19:13:38','2022-09-13 19:13:38'),(735,368,'hr','Alarm za ugljični monoksid','','Sigurnost','2022-09-13 19:13:38','2022-09-13 19:13:38'),(736,368,'en','Carbon monoxide alarm','','Home safety','2022-09-13 19:13:38','2022-09-13 19:13:38'),(749,375,'hr','Sušilo','','Kupaonica','2022-09-16 16:29:52','2022-09-16 16:29:52'),(750,375,'en','Hair dryer','','Bathroom','2022-09-16 16:29:52','2022-09-16 16:29:52'),(751,376,'hr','Sredstva za čišćenje','','Kupaonica','2022-09-16 16:29:52','2022-09-16 16:29:52'),(752,376,'en','Cleaning products','','Bathroom','2022-09-16 16:29:52','2022-09-16 16:29:52'),(753,377,'hr','Spremište za odjeću: ormar','','Spavaća soba i praonica rublja','2022-09-16 16:29:52','2022-09-16 16:29:52'),(754,377,'en','Clothing storage: closet and wardrobe','','Bedroom and laundry','2022-09-16 16:29:52','2022-09-16 16:29:52'),(755,378,'hr','Hladnjak','','Kuhinja','2022-09-16 16:29:52','2022-09-16 16:29:52'),(756,378,'en','Refrigerator','','Kitchen and dining','2022-09-16 16:29:52','2022-09-16 16:29:52'),(757,379,'hr','Punjač za električna vozila','Gosti mogu puniti svoja električna vozila na imanju.','Parking i dodatni sadržaji','2022-09-16 16:29:52','2022-09-16 16:29:52'),(758,379,'en','EV charger','Guests can charge their electric vehicles on the property.','Parking and facilities','2022-09-16 16:29:52','2022-09-16 16:29:52'),(759,380,'hr','Samostalna prijava','','Usluge','2022-09-16 16:29:52','2022-09-16 16:29:52'),(760,380,'en','Self check-in','','Services','2022-09-16 16:29:52','2022-09-16 16:29:52');
/*!40000 ALTER TABLE `apartment_details_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_images`
--

DROP TABLE IF EXISTS `apartment_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_images_apartment_id_index` (`apartment_id`),
  CONSTRAINT `apartment_images_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_images`
--

LOCK TABLES `apartment_images` WRITE;
/*!40000 ALTER TABLE `apartment_images` DISABLE KEYS */;
INSERT INTO `apartment_images` VALUES (7,2,'media/img/apartment/2/testing-apartment-1-QTyO.jpg',1,1,0,'2022-09-05 07:35:39','2022-09-16 16:29:52'),(8,2,'media/img/apartment/2/testing-apartment-1-k9bf.jpg',0,1,1,'2022-09-05 07:35:39','2022-09-16 16:29:52'),(10,3,'media/img/apartment/3/apartment-2-5Xp8.jpg',1,1,0,'2022-09-13 12:29:38','2022-09-13 12:29:55'),(11,3,'media/img/apartment/3/apartment-2-1dmT.jpg',0,1,1,'2022-09-13 12:29:38','2022-09-13 12:29:55'),(12,3,'media/img/apartment/3/apartment-2-aDe5.jpg',0,1,2,'2022-09-13 12:29:38','2022-09-13 12:29:55'),(13,13,'media/img/apartment/13/testing-apartment-3-COZP.jpg',0,1,0,'2022-09-13 19:13:38','2022-09-13 19:13:38'),(14,13,'media/img/apartment/13/testing-apartment-3-82jO.jpg',1,1,1,'2022-09-13 19:13:39','2022-09-13 19:13:39'),(15,13,'media/img/apartment/13/testing-apartment-3-15oH.jpg',0,1,2,'2022-09-13 19:13:39','2022-09-13 19:13:39');
/*!40000 ALTER TABLE `apartment_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_images_translations`
--

DROP TABLE IF EXISTS `apartment_images_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_images_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_image_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_images_translations_apartment_image_id_index` (`apartment_image_id`),
  CONSTRAINT `apartment_images_translations_apartment_image_id_foreign` FOREIGN KEY (`apartment_image_id`) REFERENCES `apartment_images` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_images_translations`
--

LOCK TABLES `apartment_images_translations` WRITE;
/*!40000 ALTER TABLE `apartment_images_translations` DISABLE KEYS */;
INSERT INTO `apartment_images_translations` VALUES (13,7,'hr','Testing apartment 1','Testing apartment 1','2022-09-05 07:35:39','2022-09-16 16:29:52'),(14,7,'en','Testing apartment 1','Testing apartment 1','2022-09-05 07:35:39','2022-09-16 16:29:52'),(15,8,'hr','Testing apartment 1','Testing apartment 1','2022-09-05 07:35:39','2022-09-16 16:29:52'),(16,8,'en','Testing apartment 1','Testing apartment 1','2022-09-05 07:35:39','2022-09-16 16:29:52'),(19,10,'hr','Apartment 2','Apartment 2','2022-09-13 12:29:38','2022-09-13 12:29:55'),(20,10,'en','Apartment 2','Apartment 2','2022-09-13 12:29:38','2022-09-13 12:29:55'),(21,11,'hr','Apartment 2','Apartment 2','2022-09-13 12:29:38','2022-09-13 12:29:55'),(22,11,'en','Apartment 2','Apartment 2','2022-09-13 12:29:38','2022-09-13 12:29:55'),(23,12,'hr','Apartment 2','Apartment 2','2022-09-13 12:29:38','2022-09-13 12:29:55'),(24,12,'en','Apartment 2','Apartment 2','2022-09-13 12:29:38','2022-09-13 12:29:55'),(25,13,'hr','Testing apartment 3','Testing apartment 3','2022-09-13 19:13:38','2022-09-13 19:13:38'),(26,13,'en','Testing apartment 3','Testing apartment 3','2022-09-13 19:13:38','2022-09-13 19:13:38'),(27,14,'hr','Testing apartment 3','Testing apartment 3','2022-09-13 19:13:39','2022-09-13 19:13:39'),(28,14,'en','Testing apartment 3','Testing apartment 3','2022-09-13 19:13:39','2022-09-13 19:13:39'),(29,15,'hr','Testing apartment 3','Testing apartment 3','2022-09-13 19:13:39','2022-09-13 19:13:39'),(30,15,'en','Testing apartment 3','Testing apartment 3','2022-09-13 19:13:39','2022-09-13 19:13:39');
/*!40000 ALTER TABLE `apartment_images_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_to_category`
--

DROP TABLE IF EXISTS `apartment_to_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_to_category` (
  `apartment_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  KEY `apartment_to_category_apartment_id_index` (`apartment_id`),
  KEY `apartment_to_category_category_id_index` (`category_id`),
  CONSTRAINT `apartment_to_category_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`),
  CONSTRAINT `apartment_to_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_to_category`
--

LOCK TABLES `apartment_to_category` WRITE;
/*!40000 ALTER TABLE `apartment_to_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `apartment_to_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartment_translations`
--

DROP TABLE IF EXISTS `apartment_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartment_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `apartment_translations_apartment_id_index` (`apartment_id`),
  CONSTRAINT `apartment_translations_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartment_translations`
--

LOCK TABLES `apartment_translations` WRITE;
/*!40000 ALTER TABLE `apartment_translations` DISABLE KEYS */;
INSERT INTO `apartment_translations` VALUES (3,2,'hr','Hrv. Apartman Jedan',NULL,NULL,NULL,'hrv-apartman-jedan','/hrv-apartman-jedan','null','2022-08-28 14:30:15','2022-09-16 16:29:52'),(4,2,'en','Eng. Apartment One',NULL,NULL,NULL,'eng-apartment-one','/eng-apartment-one','null','2022-08-28 14:30:15','2022-09-16 16:29:52'),(5,3,'hr','Apartment 2',NULL,NULL,NULL,'apartment-2','/apartment-2','null','2022-09-13 12:26:30','2022-09-13 12:29:55'),(6,3,'en','Apartment 2',NULL,NULL,NULL,'apartment-2','/apartment-2','null','2022-09-13 12:26:30','2022-09-13 12:29:55'),(25,13,'hr','Testing apartment 3',NULL,NULL,NULL,'testing-apartment-3','/testing-apartment-3','null','2022-09-13 19:13:11','2022-09-13 19:13:38'),(26,13,'en','Testing apartment 3',NULL,NULL,NULL,'testing-apartment-3','/testing-apartment-3','null','2022-09-13 19:13:11','2022-09-13 19:13:38');
/*!40000 ALTER TABLE `apartment_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartments`
--

DROP TABLE IF EXISTS `apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `apartments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  `target` int(10) unsigned NOT NULL DEFAULT '0',
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_regular` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `price_weekends` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `price_per` int(10) unsigned NOT NULL DEFAULT '0',
  `tax_id` int(10) unsigned NOT NULL DEFAULT '0',
  `special` decimal(15,4) DEFAULT NULL,
  `special_from` timestamp NULL DEFAULT NULL,
  `special_to` timestamp NULL DEFAULT NULL,
  `m2` int(10) unsigned NOT NULL DEFAULT '0',
  `beds` int(10) unsigned NOT NULL DEFAULT '0',
  `rooms` int(10) unsigned NOT NULL DEFAULT '0',
  `baths` int(10) unsigned NOT NULL DEFAULT '0',
  `adults` int(10) unsigned NOT NULL DEFAULT '0',
  `children` int(10) unsigned NOT NULL DEFAULT '0',
  `viewed` int(10) unsigned NOT NULL DEFAULT '0',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartments`
--

LOCK TABLES `apartments` WRITE;
/*!40000 ALTER TABLE `apartments` DISABLE KEYS */;
INSERT INTO `apartments` VALUES (2,2,'M5008','Gundulićeva ulica, 28','10000','Zagreb',NULL,'Croatia',1,1,'15.9717215','45.8090709','ddd',100.0000,120.0000,1,1,NULL,NULL,NULL,230,8,4,2,2,2,0,0,1,1,'2022-08-28 14:30:15','2022-09-16 14:21:55'),(3,0,'09809','Prilaz Gjure Deželića, 48','10000','Zagreb',NULL,'Croatia',1,1,'15.9628380','45.8107461',NULL,200.0000,250.0000,1,1,NULL,NULL,NULL,230,4,2,2,0,0,0,0,0,1,'2022-09-13 12:26:30','2022-09-16 16:05:16'),(13,0,'sdfasdfas','Ulica Andrije Hebranga, 16','10000','Zagreb',NULL,'Croatia',1,1,'15.9754551','45.8094299',NULL,180.0000,220.0000,1,1,NULL,NULL,NULL,230,8,4,2,0,0,0,0,0,0,'2022-09-13 19:13:11','2022-09-13 19:13:11');
/*!40000 ALTER TABLE `apartments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assigned_roles`
--

DROP TABLE IF EXISTS `assigned_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `assigned_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `entity_id` bigint(20) unsigned NOT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `restricted_to_id` bigint(20) unsigned DEFAULT NULL,
  `restricted_to_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_roles_entity_index` (`entity_id`,`entity_type`,`scope`),
  KEY `assigned_roles_role_id_index` (`role_id`),
  KEY `assigned_roles_scope_index` (`scope`),
  CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assigned_roles`
--

LOCK TABLES `assigned_roles` WRITE;
/*!40000 ALTER TABLE `assigned_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `assigned_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'media/avatars/avatar0.jpg',
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--

DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_translations_category_id_index` (`category_id`),
  KEY `category_translations_slug_index` (`slug`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (1,'FAQ','0',1,'2022-08-20 19:14:44','2022-08-20 19:14:44');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq_translations`
--

DROP TABLE IF EXISTS `faq_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `faq_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faq_translations_faq_id_index` (`faq_id`),
  CONSTRAINT `faq_translations_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faq` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_translations`
--

LOCK TABLES `faq_translations` WRITE;
/*!40000 ALTER TABLE `faq_translations` DISABLE KEYS */;
INSERT INTO `faq_translations` VALUES (1,1,'hr','Test hr','<p>Opis test hr.</p>','2022-08-20 19:14:44','2022-08-20 19:14:44'),(2,1,'en','Test en','<p>Desc. test en</p>','2022-08-20 19:14:44','2022-08-20 19:14:44');
/*!40000 ALTER TABLE `faq_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_images_gallery_id_index` (`gallery_id`),
  CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_translations`
--

DROP TABLE IF EXISTS `gallery_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hr',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_translations_gallery_id_index` (`gallery_id`),
  CONSTRAINT `gallery_translations_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_translations`
--

LOCK TABLES `gallery_translations` WRITE;
/*!40000 ALTER TABLE `gallery_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_log`
--

DROP TABLE IF EXISTS `history_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` bigint(20) NOT NULL DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changes` longtext COLLATE utf8mb4_unicode_ci,
  `old_model` longtext COLLATE utf8mb4_unicode_ci,
  `new_model` longtext COLLATE utf8mb4_unicode_ci,
  `badge` tinyint(4) NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_log`
--

LOCK TABLES `history_log` WRITE;
/*!40000 ALTER TABLE `history_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `history_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2020_01_02_223800_create_bouncer_tables',1),(7,'2020_01_02_223900_create_faq_table',1),(8,'2020_01_02_223911_create_categories_table',1),(9,'2020_01_02_223921_create_apartment_actions_table',1),(10,'2020_01_02_223922_create_apartments_table',1),(11,'2020_11_07_114044_create_orders_table',1),(12,'2021_05_16_200208_create_sessions_table',1),(13,'2021_06_11_211244_create_settings_table',1),(14,'2021_06_11_211245_create_pages_table',1),(15,'2021_08_30_104610_create_widgets_table',1),(16,'2021_09_10_104000_create_temp_table_table',1),(17,'2021_10_10_105000_create_history_log_table',1),(18,'2021_11_11_211245_create_galleries_table',1),(20,'2021_11_11_211255_create_reviews_table',2),(21,'2021_11_11_211265_create_options_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_to_apartment`
--

DROP TABLE IF EXISTS `option_to_apartment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `option_to_apartment` (
  `option_id` bigint(20) unsigned NOT NULL,
  `apartment_id` bigint(20) unsigned NOT NULL,
  KEY `option_to_apartment_option_id_index` (`option_id`),
  KEY `option_to_apartment_apartment_id_index` (`apartment_id`),
  CONSTRAINT `option_to_apartment_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`),
  CONSTRAINT `option_to_apartment_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_to_apartment`
--

LOCK TABLES `option_to_apartment` WRITE;
/*!40000 ALTER TABLE `option_to_apartment` DISABLE KEYS */;
INSERT INTO `option_to_apartment` VALUES (4,3),(5,2),(5,3),(5,13);
/*!40000 ALTER TABLE `option_to_apartment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_translations`
--

DROP TABLE IF EXISTS `option_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `option_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `option_translations_option_id_index` (`option_id`),
  CONSTRAINT `option_translations_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_translations`
--

LOCK TABLES `option_translations` WRITE;
/*!40000 ALTER TABLE `option_translations` DISABLE KEYS */;
INSERT INTO `option_translations` VALUES (1,4,'hr','Hrvatski','htthththththth','2022-09-17 14:22:01','2022-09-17 15:09:08'),(2,4,'en','Testing','ererererererere','2022-09-17 14:22:01','2022-09-17 15:09:08'),(3,5,'hr','Hrv','hrhrhrhrhrhrhr','2022-09-17 15:11:20','2022-09-17 17:14:16'),(4,5,'en','Eng','enenenenene','2022-09-17 15:11:20','2022-09-17 17:14:16');
/*!40000 ALTER TABLE `option_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `links` text COLLATE utf8mb4_unicode_ci,
  `badge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (4,'apartment',120.0000,'[\"3\"]',NULL,0,1,1,'2022-09-17 14:22:01','2022-09-17 15:08:52'),(5,'all',65.0000,'[\"all\"]',NULL,0,0,1,'2022-09-17 15:11:20','2022-09-17 17:14:16');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_history`
--

DROP TABLE IF EXISTS `order_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_history_order_id_foreign` (`order_id`),
  KEY `order_history_user_id_foreign` (`user_id`),
  CONSTRAINT `order_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `order_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_history`
--

LOCK TABLES `order_history` WRITE;
/*!40000 ALTER TABLE `order_history` DISABLE KEYS */;
INSERT INTO `order_history` VALUES (2,15,1,1,'Status promijenjen... ','2022-09-13 09:33:35','2022-09-13 09:33:35');
/*!40000 ALTER TABLE `order_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_total`
--

DROP TABLE IF EXISTS `order_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_total` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_total_order_id_foreign` (`order_id`),
  CONSTRAINT `order_total_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_total`
--

LOCK TABLES `order_total` WRITE;
/*!40000 ALTER TABLE `order_total` DISABLE KEYS */;
INSERT INTO `order_total` VALUES (1,13,'subtotal',1240.0000,0,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(2,13,'tax',310.0000,1,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(3,13,'total',1550.0000,2,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(4,14,'subtotal',1240.0000,0,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(5,14,'tax',310.0000,1,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(6,14,'total',1550.0000,2,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(7,15,'subtotal',1240.0000,0,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(8,15,'tax',310.0000,1,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(9,15,'total',1550.0000,2,'2022-08-28 14:44:42','2022-08-28 14:44:42');
/*!40000 ALTER TABLE `order_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_transactions`
--

DROP TABLE IF EXISTS `order_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `success` tinyint(4) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `signature` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_plan` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_partner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `approval_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pg_order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_transactions_order_id_foreign` (`order_id`),
  CONSTRAINT `order_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_transactions`
--

LOCK TABLES `order_transactions` WRITE;
/*!40000 ALTER TABLE `order_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `affiliate_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `order_status_id` int(10) unsigned NOT NULL,
  `invoice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_from` timestamp NULL DEFAULT NULL,
  `date_to` timestamp NULL DEFAULT NULL,
  `payment_fname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_lname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_card` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_installment` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oib` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `approved_user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_apartment_id_foreign` (`apartment_id`),
  KEY `orders_date_from_index` (`date_from`),
  KEY `orders_date_to_index` (`date_to`),
  CONSTRAINT `orders_apartment_id_foreign` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (13,2,0,0,1,NULL,1550.0000,'2022-08-21 14:44:42','2022-08-31 14:44:42','Ime','Prezima','Neka adresa','10000','Zagreb','9999999999','ime.prezima@test.hr','bank','bank','',0,'','',NULL,0,0,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(14,2,0,0,1,NULL,1550.0000,'2022-09-11 14:44:42','2022-09-24 14:44:42','Ime','Prezima','Neka adresa','10000','Zagreb','9999999999','ime.prezima@test.hr','wspay','wspay','VISA',0,'','',NULL,0,0,'2022-08-28 14:44:42','2022-08-28 14:44:42'),(15,3,0,0,1,NULL,1550.0000,'2022-09-22 14:44:42','2022-09-27 14:44:42','Testko','Testić','Neka adresa','10000','Zagreb','9999999999','ime.prezima@test.hr','bank','bank','VISA',0,'','',NULL,0,0,'2022-08-28 14:44:42','2022-09-13 09:33:35');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_translations`
--

DROP TABLE IF EXISTS `page_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_translations_page_id_index` (`page_id`),
  KEY `page_translations_slug_index` (`slug`),
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_translations`
--

LOCK TABLES `page_translations` WRITE;
/*!40000 ALTER TABLE `page_translations` DISABLE KEYS */;
INSERT INTO `page_translations` VALUES (1,1,'hr','Title test','','<p>asdgdafsgsdfg</p>',NULL,NULL,'title-test-hr','','2022-08-21 10:07:45','2022-09-14 15:32:01'),(2,1,'en','Title test','','<p>asdgdafsgsdfg</p>',NULL,NULL,'title-test','','2022-08-21 10:07:45','2022-09-14 15:32:01');
/*!40000 ALTER TABLE `page_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publish_date` timestamp NULL DEFAULT NULL,
  `viewed` int(10) unsigned NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,'HEALTH INFORMATION',NULL,NULL,0,0,1,'2022-08-21 10:07:45','2022-08-21 10:08:19');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ability_id` bigint(20) unsigned NOT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `entity_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forbidden` tinyint(1) NOT NULL DEFAULT '0',
  `scope` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_entity_index` (`entity_id`,`entity_type`,`scope`),
  KEY `permissions_ability_id_index` (`ability_id`),
  KEY `permissions_scope_index` (`scope`),
  CONSTRAINT `permissions_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `abilities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `order_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hr',
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'media/avatar.jpg',
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stars` decimal(4,2) NOT NULL DEFAULT '0.00',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_apartment_id_index` (`apartment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,0,0,0,'hr','Filip','Jankoski','filip.jankoski@gmail.com','media/avatar.jpg','<p>Neka rečenica koja u listi ne bi trebala biti dulja od 100 znakova. Mada je 100 znakova tek tu negdje.</p>',3.60,0,1,1,'2022-09-16 20:44:34','2022-09-17 15:22:17');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  `scope` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`,`scope`),
  KEY `roles_scope_index` (`scope`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0yECaCJyIYNoN69S3rLGWh3JOnZ78ShF0SuliJEt',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.81 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiU3FjVkd4VGI4MDR6YnZHVVZXbndDUmZRSnloY1ZJRE05WExCblBwUyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJGdMU1ExSHV4NXhjUkxnZHJYdjFRZXVzZEJ2Y0pFQ2tuYVJPTkM1bGdWSmxRZ0pETC44Q1I2IjtzOjY6ImxvY2FsZSI7czoyOiJlbiI7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkZ0xTUTFIdXg1eGNSTGdkclh2MVFldXNkQnZjSkVDa25hUk9OQzVsZ1ZKbFFnSkRMLjhDUjYiO3M6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQxOiJodHRwOi8vcmVudC5hZ20vZW4vYWRtaW4vYXBhcnRtZW50LzIvZWRpdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToibWFpbl9jdXJyIjtPOjg6InN0ZENsYXNzIjo5OntzOjI6ImlkIjtpOjE7czo1OiJ0aXRsZSI7Tzo4OiJzdGRDbGFzcyI6Mjp7czoyOiJociI7czoxMzoiSHJ2YXRza2Ega3VuYSI7czoyOiJlbiI7czoxMzoiQ3JvYXRpYW4ga3VuYSI7fXM6NDoiY29kZSI7czozOiJIUksiO3M6Njoic3RhdHVzIjtiOjE7czo0OiJtYWluIjtiOjE7czoxMToic3ltYm9sX2xlZnQiO047czoxMjoic3ltYm9sX3JpZ2h0IjtzOjI6ImtuIjtzOjU6InZhbHVlIjtzOjE6IjEiO3M6MTQ6ImRlY2ltYWxfcGxhY2VzIjtzOjE6IjIiO319',1663434881);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,0,'action','group_list','[{\"id\":\"apartment\",\"title\":\"Apartment\"}]',1,'2022-08-16 09:25:46','2022-08-16 09:25:46'),(2,0,'action','type_list','[{\"id\":\"P\",\"title\":\"Percentage\"},{\"id\":\"F\",\"title\":\"Fixed\"}]',1,'2022-08-16 09:25:46','2022-08-16 09:25:46'),(4,0,'payment','list.bank','[{\"title\":{\"hr\":\"Op\\u0107om uplatnicom \\/ Virmanom \\/ Internet bankarstvom\",\"en\":\"Bank transfer\"},\"code\":\"bank\",\"min\":\"100\",\"data\":{\"price\":\"0\",\"short_description\":{\"hr\":\"Uplatite direktno na na\\u0161 bankovni ra\\u010dun. Uputstva i uplatnice vam sti\\u017ee putem maila.\",\"en\":\"Some short desc...\"},\"description\":{\"hr\":null,\"en\":null}},\"geo_zone\":\"1\",\"status\":true,\"sort_order\":\"1\"}]',1,'2022-08-16 09:25:46','2022-08-20 17:50:28'),(5,0,'payment','list.wspay','[{\"title\":{\"hr\":\"WsPay\",\"en\":\"WsPay\"},\"code\":\"wspay\",\"min\":\"100\",\"data\":{\"price\":\"0\",\"short_description\":{\"hr\":null,\"en\":null},\"description\":[],\"shop_id\":\"AGMEFRMTST\",\"secret_key\":\"2770f6a0a56c4V\",\"callback\":\"http:\\/\\/antikvarijat.agm\\/narudzba\",\"test\":\"0\"},\"geo_zone\":\"1\",\"status\":true,\"sort_order\":\"0\"}]',1,'2022-08-16 09:25:46','2022-08-20 18:44:39'),(6,0,'pay','list.pickup','[{\"title\":\"Platite prilikom preuzimanja\",\"code\":\"pickup\",\"min\":null,\"data\":{\"price\":\"0\",\"short_description\":\"Platiti mou017eete gotovinom ili karticama na POS ureu0111ajima\",\"description\":null},\"geo_zone\":\"1\",\"status\":false,\"sort_order\":\"0\"}]',1,'2022-08-16 09:25:46','2022-08-17 06:56:59'),(7,0,'currency','list','[{\"id\":1,\"title\":{\"hr\":\"Hrvatska kuna\",\"en\":\"Croatian kuna\"},\"code\":\"HRK\",\"status\":true,\"main\":true,\"symbol_left\":null,\"symbol_right\":\"kn\",\"value\":\"1\",\"decimal_places\":\"2\"},{\"id\":2,\"title\":{\"hr\":\"Euro\",\"en\":\"Euro\"},\"code\":\"EUR\",\"status\":true,\"main\":false,\"symbol_left\":\"\\u20ac\",\"symbol_right\":null,\"value\":\"0.13272280\",\"decimal_places\":\"2\"}]',1,'2022-08-16 09:25:46','2022-09-14 07:27:48'),(8,0,'language','list','[{\"id\":1,\"title\":{\"hr\":\"Hrvatski\",\"en\":\"Croatian\"},\"code\":\"hr\",\"status\":true,\"main\":false},{\"id\":2,\"title\":{\"hr\":\"Engleski\",\"en\":\"English\"},\"code\":\"en\",\"status\":true,\"main\":false}]',1,'2022-08-16 09:25:46','2022-08-16 09:25:46'),(9,0,'order','statuses','{\"0\":{\"id\":1,\"title\":{\"hr\":\"Novo\",\"en\":\"New\"},\"sort_order\":\"0\",\"color\":\"info\"},\"1\":{\"id\":2,\"title\":{\"hr\":\"\\u010ceka uplatu\",\"en\":\"Pending\"},\"sort_order\":\"1\",\"color\":\"warning\"},\"2\":{\"id\":3,\"title\":{\"hr\":\"Pla\\u010deno\",\"en\":\"Paid\"},\"sort_order\":\"3\",\"color\":\"success\"},\"4\":{\"id\":5,\"title\":{\"hr\":\"Otkazano\",\"en\":\"Canceled\"},\"sort_order\":\"5\",\"color\":\"dark\"},\"6\":{\"id\":7,\"title\":{\"hr\":\"Odbijeno\",\"en\":\"Declined\"},\"sort_order\":\"2\",\"color\":\"danger\"},\"7\":{\"id\":8,\"title\":{\"hr\":\"Nedovr\\u0161ena\",\"en\":\"Unfinished\"},\"sort_order\":\"7\",\"color\":\"secondary\"}}',1,'2022-08-16 09:25:46','2022-09-12 09:18:28'),(10,0,'tax','list','{\"1\":{\"id\":1,\"geo_zone\":\"1\",\"title\":{\"hr\":\"PDV 25%\",\"en\":\"Vat 25%\"},\"rate\":\"25\",\"sort_order\":\"0\",\"status\":true}}',1,'2022-08-16 09:25:46','2022-08-20 08:37:01'),(11,0,'geo_zone','list','{\"0\":{\"status\":true,\"title\":{\"hr\":\"Hrvatska\",\"en\":\"Croatia\"},\"description\":{\"hr\":null,\"en\":null},\"state\":{\"3\":\"Croatia\"},\"id\":1},\"2\":{\"title\":{\"hr\":\"Ostatak svijeta\",\"en\":\"World\"},\"description\":{\"hr\":null,\"en\":null},\"id\":3,\"status\":true,\"state\":[]}}',1,'2022-08-16 09:25:46','2022-08-19 16:41:29'),(12,0,'payment','list.payway','[{\"title\":{\"hr\":\"Payway\",\"en\":\"PayWay\"},\"code\":\"payway\",\"min\":\"100\",\"data\":{\"price\":\"30\",\"short_description\":{\"hr\":null,\"en\":null},\"description\":{\"hr\":null,\"en\":null},\"shop_id\":null,\"secret_key\":null,\"callback\":null,\"test\":\"0\"},\"geo_zone\":\"1\",\"status\":false,\"sort_order\":\"2\"}]',1,'2022-08-17 06:43:00','2022-08-20 18:58:51'),(14,0,'amenity','list','{\"1\":{\"id\":1,\"title\":{\"hr\":\"Su\\u0161ilo\",\"en\":\"Hair dryer\"},\"icon\":\"hair_dryer.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":true,\"status\":0},\"2\":{\"id\":2,\"title\":{\"en\":\"Shampoo\",\"hr\":\"\\u0160ampon za kosu\"},\"icon\":\"shampoo.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":0,\"status\":0},\"3\":{\"id\":3,\"title\":{\"en\":\"Hot water\",\"hr\":\"Topla voda\"},\"icon\":\"hot_water.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":0,\"status\":0},\"4\":{\"id\":4,\"title\":{\"en\":\"Shower gel\",\"hr\":\"Gel za tu\\u0161iranje\"},\"icon\":\"shower_gel.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":0,\"status\":0},\"5\":{\"id\":5,\"title\":{\"en\":\"Washer\",\"hr\":\"Perilica rublja\"},\"icon\":\"washer.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"6\":{\"id\":6,\"title\":{\"en\":\"Essentials\",\"hr\":\"Osnove\"},\"description\":{\"en\":\"Towels, bed sheets, soap, and toilet paper\",\"hr\":\"Ru\\u010dnici, posteljina, sapun i toaletni papir\"},\"icon\":\"essentials.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"7\":{\"id\":7,\"title\":{\"en\":\"Hangers\",\"hr\":\"Vje\\u0161alice\"},\"icon\":\"hangers.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"8\":{\"id\":8,\"title\":{\"en\":\"Bed linens\",\"hr\":\"Posteljina\"},\"icon\":\"bad_linens.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"9\":{\"id\":9,\"title\":{\"en\":\"Extra pillows and blankets\",\"hr\":\"Dodatni jastuci i deke\"},\"icon\":\"extra_pillows_and_blankets.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"10\":{\"id\":10,\"title\":{\"en\":\"Iron\",\"hr\":\"Pegla\"},\"icon\":\"iron.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"11\":{\"id\":11,\"title\":{\"en\":\"TV\",\"hr\":\"TV\"},\"icon\":\"tv.svg\",\"group\":\"Entertainment\",\"group_title\":{\"en\":\"Entertainment\",\"hr\":\"Zabava\"},\"featured\":0,\"status\":0},\"12\":{\"id\":12,\"title\":{\"en\":\"Pack \\u2019n play\\/Travel crib - available upon request\",\"hr\":\"Prijenosni dje\\u010dji kreveti\\u0107\"},\"icon\":\"crib.svg\",\"group\":\"Family\",\"group_title\":{\"en\":\"Family\",\"hr\":\"Obitelj\"},\"featured\":0,\"status\":0},\"13\":{\"id\":13,\"title\":{\"en\":\"Air conditioning\",\"hr\":\"Klima\"},\"icon\":\"air_conditioning.svg\",\"group\":\"Heating and cooling\",\"group_title\":{\"en\":\"Heating and cooling\",\"hr\":\"Grijanje i hla\\u0111enje\"},\"featured\":0,\"status\":0},\"14\":{\"id\":14,\"title\":{\"en\":\"Heating\",\"hr\":\"Grijanje\"},\"icon\":\"heating.svg\",\"group\":\"Heating and cooling\",\"group_title\":{\"en\":\"Heating and cooling\",\"hr\":\"Grijanje i hla\\u0111enje\"},\"featured\":0,\"status\":0},\"15\":{\"id\":15,\"title\":{\"en\":\"Smoke alarm\",\"hr\":\"Alarm za dim\"},\"icon\":\"smoke_alarm.svg\",\"group\":\"Home safety\",\"group_title\":{\"en\":\"Home safety\",\"hr\":\"Sigurnost\"},\"featured\":0,\"status\":0},\"16\":{\"id\":16,\"title\":{\"en\":\"Carbon monoxide alarm\",\"hr\":\"Alarm za uglji\\u010dni monoksid\"},\"icon\":\"carbon_monoxide_alarm.svg\",\"group\":\"Home safety\",\"group_title\":{\"en\":\"Home safety\",\"hr\":\"Sigurnost\"},\"featured\":0,\"status\":0},\"17\":{\"id\":17,\"title\":{\"en\":\"Fire extinguisher\",\"hr\":\"Aparat za ga\\u0161enje po\\u017eara\"},\"icon\":\"fire_extinguisher.svg\",\"group\":\"Home safety\",\"group_title\":{\"en\":\"Home safety\",\"hr\":\"Sigurnost\"},\"featured\":0,\"status\":0},\"18\":{\"id\":18,\"title\":{\"en\":\"First aid kit\",\"hr\":\"Prva pomo\\u0107\"},\"icon\":\"first_aid_kit.svg\",\"group\":\"Home safety\",\"group_title\":{\"en\":\"Home safety\",\"hr\":\"Sigurnost\"},\"featured\":0,\"status\":0},\"19\":{\"id\":19,\"title\":{\"en\":\"Wifi\",\"hr\":\"Wifi\"},\"icon\":\"wifi.svg\",\"group\":\"Internet and office\",\"group_title\":{\"en\":\"Internet and office\",\"hr\":\"Wifi\"},\"featured\":0,\"status\":0},\"20\":{\"id\":20,\"title\":{\"en\":\"Kitchen\",\"hr\":\"Kuhinja\"},\"description\":{\"en\":\"Space where guests can cook their own meals\",\"hr\":\"Prostor u kojem gosti mogu sami kuhati obroke\"},\"icon\":\"kitchen.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"21\":{\"id\":21,\"title\":{\"en\":\"Refrigerator\",\"hr\":\"Hladnjak\"},\"icon\":\"refrigerator.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"22\":{\"id\":22,\"title\":{\"en\":\"Microwave\",\"hr\":\"Mikrovalna pe\\u0107nica\"},\"icon\":\"microwave.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"23\":{\"id\":23,\"title\":{\"en\":\"Cooking basics\",\"hr\":\"Osnove za kuhanje\"},\"description\":{\"en\":\"Pots and pans, oil, salt and pepper\",\"hr\":\"Lonci i tave, ulje, sol i papar\"},\"icon\":\"cooking_basics.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"24\":{\"id\":24,\"title\":{\"en\":\"Dishes and silverware\",\"hr\":\"Posu\\u0111e i srebrnina\"},\"description\":{\"en\":\"Bowls, chopsticks, plates, cups, etc.\",\"hr\":\"Zdjele, \\u0161tapi\\u0107i, tanjuri, \\u0161alice itd.\"},\"icon\":\"dishes_and_silverware.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"25\":{\"id\":25,\"title\":{\"en\":\"Dishwasher\",\"hr\":\"Perilica su\\u0111a\"},\"icon\":\"dishwasher.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"26\":{\"id\":26,\"title\":{\"en\":\"Stove\",\"hr\":\"\\u0160tednjak\"},\"icon\":\"stove.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"27\":{\"id\":27,\"title\":{\"en\":\"Private entrance\",\"hr\":\"Privatni ulaz\"},\"description\":{\"en\":\"Separate street or building entrance\",\"hr\":\"Poseban ulaz s ulice ili zgrade\"},\"icon\":\"private_entrance.svg\",\"group\":\"Location features\",\"group_title\":{\"en\":\"Location features\",\"hr\":\"Zna\\u010dajke lokacije\"},\"featured\":0,\"status\":0},\"28\":{\"id\":28,\"title\":{\"en\":\"Free parking on premises\",\"hr\":\"Besplatan parking u sklopu objekta\"},\"icon\":\"free_parking_on_premises.svg\",\"group\":\"Parking and facilities\",\"group_title\":{\"en\":\"Parking and facilities\",\"hr\":\"Parking i dodatni sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"29\":{\"id\":29,\"title\":{\"en\":\"Free street parking\",\"hr\":\"Besplatan parking na ulici\"},\"icon\":\"free_parking_on_premises.svg\",\"group\":\"Parking and facilities\",\"group_title\":{\"en\":\"Parking and facilities\",\"hr\":\"Parking i dodatni sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"30\":{\"id\":30,\"title\":{\"en\":\"Pool\",\"hr\":\"Bazen\"},\"icon\":\"pool.svg\",\"group\":\"Parking and facilities\",\"group_title\":{\"en\":\"Parking and facilities\",\"hr\":\"Parking i dodatni sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"31\":{\"id\":31,\"title\":{\"en\":\"Hot tub\",\"hr\":\"Vru\\u0107a kupelj\"},\"icon\":\"hot_tub.svg\",\"group\":\"Parking and facilities\",\"group_title\":{\"en\":\"Parking and facilities\",\"hr\":\"Parking i dodatni sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"32\":{\"id\":32,\"title\":{\"en\":\"EV charger\",\"hr\":\"Punja\\u010d za elektri\\u010dna vozila\"},\"description\":{\"en\":\"Guests can charge their electric vehicles on the property.\",\"hr\":\"Gosti mogu puniti svoja elektri\\u010dna vozila na imanju.\"},\"icon\":\"ev_charger.svg\",\"group\":\"Parking and facilities\",\"group_title\":{\"en\":\"Parking and facilities\",\"hr\":\"Parking i dodatni sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"33\":{\"id\":33,\"title\":{\"en\":\"Luggage dropoff allowed\",\"hr\":\"Dopu\\u0161ten predaja prtljage\"},\"description\":{\"en\":\"For guests convenience when they have early arrival or late departure\",\"hr\":\"Za udobnost gostiju kada imaju rani dolazak ili kasni odlazak\"},\"icon\":\"luggage_dropoff_allowed.svg\",\"group\":\"Services\",\"group_title\":{\"en\":\"Services\",\"hr\":\"Usluge\"},\"featured\":0,\"status\":0},\"34\":{\"id\":34,\"title\":{\"en\":\"Self check-in\",\"hr\":\"Samostalna prijava\"},\"icon\":\"self_check_in.svg\",\"group\":\"Services\",\"group_title\":{\"en\":\"Services\",\"hr\":\"Usluge\"},\"featured\":0,\"status\":0},\"35\":{\"id\":35,\"title\":{\"en\":\"Keypad\",\"hr\":\"Tipkovnica za ulaz\"},\"description\":{\"en\":\"Check yourself into the home with a door code\",\"hr\":\"Prijavite se u dom pomo\\u0107u koda na vratima\"},\"icon\":\"keypad.svg\",\"group\":\"Services\",\"group_title\":{\"en\":\"Services\",\"hr\":\"Usluge\"},\"featured\":0,\"status\":0},\"36\":{\"id\":36,\"title\":{\"en\":\"Long term stays allowed\",\"hr\":\"Dugotrajni boravci dozvoljeni\"},\"description\":{\"en\":\"Allow stay for 28 days or more\",\"hr\":\"Dozvoljen boravak 28 dana ili vi\\u0161e\"},\"icon\":\"long_term_stays_allowed.svg\",\"group\":\"Services\",\"group_title\":{\"en\":\"Services\",\"hr\":\"Usluge\"},\"featured\":0,\"status\":0},\"37\":{\"id\":37,\"title\":{\"en\":\"Security cameras on property\",\"hr\":\"Sigurnosna kamera\"},\"icon\":\"security_cameras_on_property.svg\",\"group\":\"Not included\",\"group_title\":{\"en\":\"Not included\",\"hr\":\"Nije uklju\\u010deno\"},\"featured\":0,\"status\":0},\"38\":{\"id\":38,\"title\":{\"en\":\"City skyline view\",\"hr\":\"Panoramski pogled\"},\"icon\":\"city_skyline_view.svg\",\"group\":\"Scenic views\",\"group_title\":{\"en\":\"Scenic views\",\"hr\":\"Slikoviti pogled\"},\"featured\":0,\"status\":0},\"39\":{\"id\":39,\"title\":{\"en\":\"Cleaning products\",\"hr\":\"Sredstva za \\u010di\\u0161\\u0107enje\"},\"icon\":\"cleaning_products.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":0,\"status\":0},\"40\":{\"id\":40,\"title\":{\"en\":\"Bidet\",\"hr\":\"Bidet\"},\"icon\":\"bidet.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":0,\"status\":0},\"41\":{\"id\":41,\"title\":{\"hr\":\"Vanjski tu\\u0161\",\"en\":\"Outdoor shower\"},\"icon\":\"outdoor_shower.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":true,\"status\":0},\"42\":{\"id\":42,\"title\":{\"en\":\"Room-darkening shades\",\"hr\":\"Sjenila za zamra\\u010divanje prostora\"},\"icon\":\"room_darkening_shades.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"43\":{\"id\":43,\"title\":{\"en\":\"Clothing storage: closet and wardrobe\",\"hr\":\"Spremi\\u0161te za odje\\u0107u: ormar\"},\"icon\":\"clothing_storage.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"44\":{\"id\":44,\"title\":{\"en\":\"Ethernet connection\",\"hr\":\"Ethernet veza\"},\"icon\":\"ethernet_connection.svg\",\"group\":\"Entertainment\",\"group_title\":{\"en\":\"Entertainment\",\"hr\":\"Zabava\"},\"featured\":0,\"status\":0},\"45\":{\"id\":45,\"title\":{\"en\":\"50\\\" HDTV with Netflix, premium cable, standard cable\",\"hr\":\"50\\\" HDTV s Netflixom, premium kabel, standardni kabel\"},\"icon\":\"tv.svg\",\"group\":\"Entertainment\",\"group_title\":{\"en\":\"Entertainment\",\"hr\":\"Zabava\"},\"featured\":0,\"status\":0},\"46\":{\"id\":469,\"title\":{\"en\":\"Dedicated workspace\",\"hr\":\"Namjenski radni prostor\"},\"icon\":\"dedicated_workspace.svg\",\"group\":\"Internet and office\",\"group_title\":{\"en\":\"Internet and office\",\"hr\":\"Wifi\"},\"featured\":0,\"status\":0},\"47\":{\"id\":47,\"title\":{\"en\":\"Mini fridge\",\"hr\":\"Mini hladnjak\"},\"icon\":\"mini_fridge.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"48\":{\"id\":48,\"title\":{\"en\":\"Freezer\",\"hr\":\"Zamrziva\\u010d\"},\"icon\":\"refrigerator.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"49\":{\"id\":49,\"title\":{\"en\":\"Stainless steel oven\",\"hr\":\"Pe\\u0107nica od nehr\\u0111aju\\u0107eg \\u010delika\"},\"icon\":\"stainless_steel_oven.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"50\":{\"id\":50,\"title\":{\"en\":\"Hot water kettle\",\"hr\":\"Kuhalo za toplu vodu\"},\"icon\":\"hot_water_kettle.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"51\":{\"id\":51,\"title\":{\"en\":\"Wine glasses\",\"hr\":\"\\u010ca\\u0161e za vino\"},\"icon\":\"wine_glasses.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"52\":{\"id\":52,\"title\":{\"en\":\"Baking sheet\",\"hr\":\"Folija za pe\\u010denje\"},\"icon\":\"baking_sheet.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"53\":{\"id\":53,\"title\":{\"en\":\"Barbecue utensils\",\"hr\":\"Ro\\u0161tilj i pribor\"},\"description\":{\"en\":\"Grill, charcoal, bamboo skewers\\/iron skewers, etc.\",\"hr\":\"Ro\\u0161tilj, drveni ugljen, bambusovi ra\\u017enji\\u0107i\\/\\u017eeljezni ra\\u017enji\\u0107i itd.\"},\"icon\":\"barbecue_utensils.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"54\":{\"id\":54,\"title\":{\"en\":\"Dining table\",\"hr\":\"Blagovaonski stol\"},\"icon\":\"dining_table.svg\",\"group\":\"Kitchen and dining\",\"group_title\":{\"en\":\"Kitchen and dining\",\"hr\":\"Kuhinja\"},\"featured\":0,\"status\":0},\"55\":{\"id\":55,\"title\":{\"en\":\"Single level home\",\"hr\":\"Ku\\u0107a na jednom katu\"},\"description\":{\"en\":\"No stairs in home\",\"hr\":\"Nema stepenica u ku\\u0107i\"},\"icon\":\"single_level_home.svg\",\"group\":\"Parking and facilities\",\"group_title\":{\"en\":\"Parking and facilities\",\"hr\":\"Parking i dodatni sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"56\":{\"id\":56,\"title\":{\"en\":\"Private patio or balcony\",\"hr\":\"Ku\\u0107a na jednom katu\"},\"icon\":\"private_patio_or_balcony.svg\",\"group\":\"Outdoor\",\"group_title\":{\"en\":\"Outdoor\",\"hr\":\"Vanjski sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"57\":{\"id\":57,\"title\":{\"en\":\"Outdoor furniture\",\"hr\":\"Vanjski namje\\u0161taj\"},\"icon\":\"outdoor_furniture.svg\",\"group\":\"Outdoor\",\"group_title\":{\"en\":\"Outdoor\",\"hr\":\"Vanjski sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"58\":{\"id\":58,\"title\":{\"en\":\"Outdoor dining area\",\"hr\":\"Vanjska blagovaonica\"},\"icon\":\"outdoor_furniture.svg\",\"group\":\"Outdoor\",\"group_title\":{\"en\":\"Outdoor\",\"hr\":\"Vanjski sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"59\":{\"id\":59,\"title\":{\"en\":\"BBQ grill\",\"hr\":\"Vanjski ro\\u0161tilj\"},\"icon\":\"bbq_grill.svg\",\"group\":\"Outdoor\",\"group_title\":{\"en\":\"Outdoor\",\"hr\":\"Vanjski sadr\\u017eaji\"},\"featured\":0,\"status\":0},\"60\":{\"id\":60,\"title\":{\"en\":\"Dryer\",\"hr\":\"Su\\u0161ilica rublja\"},\"icon\":\"dryer.svg\",\"group\":\"Bedroom and laundry\",\"group_title\":{\"en\":\"Bedroom and laundry\",\"hr\":\"Spava\\u0107a soba i praonica rublja\"},\"featured\":0,\"status\":0},\"61\":{\"id\":61,\"title\":{\"hr\":\"Kada\",\"en\":\"Bathtub\"},\"icon\":\"bathtub.svg\",\"group\":\"Bathroom\",\"group_title\":{\"en\":\"Bathroom\",\"hr\":\"Kupaonica\"},\"featured\":true,\"status\":0}}',1,'2022-08-19 08:25:27','2022-09-15 08:21:59');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_table`
--

DROP TABLE IF EXISTS `temp_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_table` (
  `product_id` bigint(20) NOT NULL,
  `special` decimal(15,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_table`
--

LOCK TABLES `temp_table` WRITE;
/*!40000 ALTER TABLE `temp_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `temp_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `fname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliate` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/avatars/default_avatar.jpg',
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `social` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_details_user_id_foreign` (`user_id`),
  CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (1,1,'Filip','Jankoski','Kovačića 23','44320','Kutina','Croatia','000','','media/avatars/avatar0.jpg','Lorem ipsum...','790117367','admin',1,'2022-08-16 09:25:46','2022-08-16 09:25:46'),(2,2,'Tomislav','Jureša','Malešnica bb','10000','Zagreb','Croatia','000','','media/avatars/avatar0.jpg','Lorem ipsum...','','admin',1,'2022-08-16 09:25:46','2022-08-16 09:25:46');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Filip Jankoski','filip@agmedia.hr',NULL,'$2y$10$gLSQ1Hux5xcRLgdrXv1QeusdBvcJECknaRONC5lgVJlQgJDL.8CR6',NULL,NULL,'srwLz5yALqYTwy07MzkZoAzrp8jGXm8RXISWTFuuDWDhDqzwWLD422d2n0pP',NULL,NULL,'2022-08-16 09:25:46','2022-08-16 09:25:46'),(2,'Tomislav Jureša','tomislav@agmedia.hr',NULL,'$2y$10$/SdnuOkCZukeBOTRRgzLGOSmW27i5ka2YUicJawQ0P3oDB4pciMXu',NULL,NULL,'',NULL,NULL,'2022-08-16 09:25:46','2022-08-16 09:25:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widget_groups`
--

DROP TABLE IF EXISTS `widget_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widget_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_groups_template_index` (`template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widget_groups`
--

LOCK TABLES `widget_groups` WRITE;
/*!40000 ALTER TABLE `widget_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `widget_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widget_translations`
--

DROP TABLE IF EXISTS `widget_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widget_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `widget_id` bigint(20) unsigned NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `data` text COLLATE utf8mb4_unicode_ci,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_translations_widget_id_index` (`widget_id`),
  KEY `widget_translations_title_index` (`title`),
  CONSTRAINT `widget_translations_widget_id_foreign` FOREIGN KEY (`widget_id`) REFERENCES `widgets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widget_translations`
--

LOCK TABLES `widget_translations` WRITE;
/*!40000 ALTER TABLE `widget_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `widget_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets`
--

DROP TABLE IF EXISTS `widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_id` int(11) DEFAULT NULL,
  `badge` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `width` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `widgets_group_id_index` (`group_id`),
  CONSTRAINT `widgets_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `widget_groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets`
--

LOCK TABLES `widgets` WRITE;
/*!40000 ALTER TABLE `widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `widgets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-17 19:22:48
