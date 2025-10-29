-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bgoc_outdoor_system
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `billboard_bookings`
--

DROP TABLE IF EXISTS `billboard_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billboard_bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `billboard_id` bigint(20) unsigned NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  `job_order_no` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL,
  `artwork_by` varchar(255) NOT NULL,
  `dbp_approval` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `billboard_bookings_billboard_id_foreign` (`billboard_id`),
  KEY `billboard_bookings_company_id_foreign` (`company_id`),
  KEY `billboard_bookings_created_by_foreign` (`created_by`),
  KEY `billboard_bookings_updated_by_foreign` (`updated_by`),
  CONSTRAINT `billboard_bookings_billboard_id_foreign` FOREIGN KEY (`billboard_id`) REFERENCES `billboards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billboard_bookings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `client_companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billboard_bookings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billboard_bookings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billboard_bookings`
--

LOCK TABLES `billboard_bookings` WRITE;
/*!40000 ALTER TABLE `billboard_bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `billboard_bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billboard_images`
--

DROP TABLE IF EXISTS `billboard_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billboard_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `billboard_id` bigint(20) unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `billboard_images_billboard_id_foreign` (`billboard_id`),
  CONSTRAINT `billboard_images_billboard_id_foreign` FOREIGN KEY (`billboard_id`) REFERENCES `billboards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billboard_images`
--

LOCK TABLES `billboard_images` WRITE;
/*!40000 ALTER TABLE `billboard_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `billboard_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billboards`
--

DROP TABLE IF EXISTS `billboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `billboards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` bigint(20) unsigned NOT NULL,
  `site_number` varchar(255) NOT NULL,
  `gps_latitude` varchar(255) NOT NULL,
  `gps_longitude` varchar(255) NOT NULL,
  `traffic_volume` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `lighting` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `billboards_location_id_foreign` (`location_id`),
  KEY `billboards_created_by_foreign` (`created_by`),
  KEY `billboards_updated_by_foreign` (`updated_by`),
  CONSTRAINT `billboards_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billboards_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `billboards_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billboards`
--

LOCK TABLES `billboards` WRITE;
/*!40000 ALTER TABLE `billboards` DISABLE KEYS */;
INSERT INTO `billboards` VALUES (2,2,'TB-NSN-0001-MBS-A','2.8240058','101.7997796','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 09:47:22','2025-09-02 09:47:22'),(3,3,'TB-NSN-0002-MBS-A','2.6937479','101.9128172','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 09:48:59','2025-09-02 09:48:59'),(4,4,'TB-SEL-0001-MPKJ-A','3.0329924','101.4371395','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:04:58','2025-09-02 10:04:58'),(5,5,'TB-SEL-0002-MPKJ-A','2.6937479','101.9128172','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:06:23','2025-09-02 10:06:23'),(6,6,'TB-SEL-0003-MPKJ-A','3.0355219','101.4412962','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:07:51','2025-09-02 10:07:51'),(7,7,'TB-SEL-0004-MPAJ-A','3.2000921','101.7777082','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:08:59','2025-09-02 10:08:59'),(8,8,'TB-SEL-0005-MPAJ-A','3.1193678','101.743002','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:10:18','2025-09-02 10:10:18'),(9,9,'TB-SEL-0006-MPKJ-A','3.0053881','101.7855107','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:12:05','2025-09-02 10:12:05'),(10,10,'TB-SEL-0007-MPKJ-A','3.0429246','101.7913962','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:13:38','2025-09-02 10:13:38'),(11,11,'TB-SEL-0008-MPKJ-A','2.9034731','101.7205781','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:15:00','2025-09-02 10:15:00'),(12,12,'TB-SEL-0009-MPKJ-A','2.90688328','101.7111656','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:16:18','2025-09-02 10:16:18'),(13,13,'TB-SEL-0010-MDKS-A','3.2365763','101.4892308','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:17:51','2025-09-02 10:17:51'),(14,14,'TB-SEL-0011-MDKS-A','3.2125204','101.4603459','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:19:44','2025-09-02 10:19:44'),(15,15,'TB-SEL-0012-MDKS-A','3.050381','101.774039','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:21:59','2025-09-02 10:21:59'),(16,16,'TB-SEL-0013-MPS-A','3.2343738','101.6792048','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:23:46','2025-09-02 10:23:46'),(17,17,'TB-SEL-0014-MPS-A','3.2446152','101.6588715','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:25:19','2025-09-02 10:25:19'),(18,18,'TB-SEL-0015-MPS-A','3.2774129','101.4532294','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:27:11','2025-09-02 10:27:11'),(19,19,'TB-SEL-0016-MPS-A','3.3040428','101.5962887','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:29:05','2025-09-02 10:29:05'),(20,20,'TB-SEL-0017-MPS-A','3.313655','101.536189','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 10:30:23','2025-09-02 10:30:23'),(21,21,'TB-SEL-0018-MPS-A','3.278255','101.452702','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:25:51','2025-09-02 16:25:51'),(22,22,'TB-SEL-0019-MDSK-A','3.0328652','101.6788969','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:29:04','2025-09-02 16:29:04'),(23,23,'TB-SEL-0020-MDSK-A','2.9846137','101.662668','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:31:34','2025-09-02 16:31:34'),(24,24,'TB-SEL-0021-MDSK-A','3.0192353','101.7187767','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:33:48','2025-09-02 16:33:48'),(25,25,'TB-SEL-0022-MDSK-A','2.9932365','101.6631793','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:35:56','2025-09-02 16:35:56'),(26,26,'TB-SEL-0023-MDSK-A','3.0192353','101.7187767','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:38:00','2025-09-02 16:38:00'),(27,27,'TB-SEL-0024-MDSK-A','3.0281329','101.7112692','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:39:29','2025-09-02 16:39:29'),(28,28,'TB-SEL-0025-MDSK-A','2.979036','101.661632','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:41:02','2025-09-02 16:41:02'),(29,29,'TB-SEL-0026-MPSepang-A','2.939875','101.661101','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:43:02','2025-09-02 16:43:02'),(30,30,'TB-SEL-0027-MBSJ-A','3.073378','101.598044','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:45:20','2025-09-02 16:45:20'),(31,31,'TB-SEL-0028-MBSJ-A','3.042591','101.700457','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:46:44','2025-09-02 16:46:44'),(32,32,'TB-SEL-0029-MBSJ-A','3.073568','101.586389','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:48:28','2025-09-02 16:48:28'),(33,33,'TB-SEL-0030-MBSJ-A','3.081834','101.587295','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:53:07','2025-09-02 16:53:07'),(34,34,'TB-SEL-0031-MBSJ-A','3.0633005','101.5567981','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:55:15','2025-09-02 16:55:15'),(35,35,'TB-SEL-0032-MBSJ-A','3.063180','101.614262','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:56:55','2025-09-02 16:56:55'),(36,30,'TB-SEL-0033-MBSJ-A','3.073345','101.599071','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 16:58:33','2025-09-02 16:58:33'),(37,36,'TB-SEL-0034-MBSJ-A','3.073568','101.586389','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:00:28','2025-09-02 17:00:28'),(38,35,'TB-SEL-0035-MBSJ-A','3.067533','101.613756','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:02:12','2025-09-02 17:02:12'),(39,37,'TB-SEL-0036-MBSJ-A','3.0547506','101.5553248','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:05:02','2025-09-02 17:05:02'),(40,38,'TB-SEL-0037-MPKJ-A','2.958522','101.755191','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:07:01','2025-09-02 17:07:01'),(41,39,'TB-SEL-0038-MPKJ-A','2.9627245','101.7597266','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:13:18','2025-09-02 17:13:18'),(42,40,'TB-SEL-0039-MPKJ-A','2.9337328','101.7643152','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:14:43','2025-09-02 17:14:43'),(44,41,'TB-SEL-0040-MPKJ-A','2.965029','101.7741285','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:16:29','2025-09-02 17:16:29'),(45,42,'TB-SEL-0041-MBPJ-A','3.1856917','101.5805882','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:17:49','2025-09-02 17:17:49'),(46,43,'TB-SEL-0042-MBPJ-A','3.0651524','101.6135091','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:19:16','2025-09-02 17:19:16'),(47,44,'TB-SEL-0043-MBPJ-A','3.159036','101.5639578','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:20:43','2025-09-02 17:20:43'),(48,45,'TB-SEL-0044-MBPJ-A','3.1499926','101.5890136','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:22:04','2025-09-02 17:22:04'),(49,46,'TB-SEL-0045-MBPJ-A','3.0651524','101.6135091','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:23:21','2025-09-02 17:23:21'),(50,47,'TB-SEL-0046-MBPJ-A','3.126378','101.623150','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:24:36','2025-09-02 17:24:36'),(51,48,'TB-SEL-0047-MBPJ-A','3.0327015','101.6188575','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:26:11','2025-09-02 17:26:11'),(52,49,'TB-SEL-0048-MBPJ-A','3.1746209','101.5741036','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:28:39','2025-09-02 17:28:39'),(53,50,'TB-SEL-0049-MBPJ-A','3.112912','101.611370','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:31:55','2025-09-02 17:31:55'),(54,51,'TB-SEL-0050-MBPJ-A','3.096351','101.630452','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:33:22','2025-09-02 17:33:22'),(55,52,'TB-SEL-0051-MBPJ-A','3.1089317','101.5830461','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:34:46','2025-09-02 17:34:46'),(56,53,'TB-SEL-0052-MBSA-A','3.1387451','101.5291488','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:36:32','2025-09-02 17:36:32'),(57,54,'TB-SEL-0053-MBSA-A','3.0785115','101.5498325','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:38:07','2025-09-02 17:38:07'),(58,55,'TB-SEL-0054-MBPJ-A','3.1240018','101.4677356','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:39:28','2025-09-02 17:39:28'),(59,56,'TB-SEL-0055-MBSA-A','3.0808516','101.554549','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:41:03','2025-09-02 17:41:03'),(60,57,'TB-SEL-0056-MBSA-A','3.0581526','101.4947346','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:42:10','2025-09-02 17:42:10'),(61,58,'TB-SEL-0057-MBSA-A','3.0018893','101.5436451','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:43:29','2025-09-02 17:43:29'),(62,59,'TB-SEL-0058-MBSA-A','3.0961194','101.5553248','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:44:58','2025-09-02 17:44:58'),(63,60,'TB-SEL-0059-MBSA-A','3.0813264','101.4814574','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:46:31','2025-09-02 17:46:31'),(64,61,'TB-SEL-0060-MBSA-A','3.0452481','101.546617','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:47:44','2025-09-02 17:47:44'),(65,62,'TB-SEL-0061-MBSA-A','3.0878517','101.5484577','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:48:55','2025-09-02 17:48:55'),(66,63,'TB-SEL-0062-MBSA-A','3.078750','101.494611','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:50:29','2025-09-02 17:50:29'),(67,64,'TB-SEL-0063-MBSA-A','3.0749583','101.5492168','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:51:47','2025-09-02 17:51:47'),(68,65,'TB-SEL-0064-MBSA-A','3.1234065','101.6831768','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:52:52','2025-09-02 17:52:52'),(69,66,'TB-SEL-0065-MBSA-A','3.0800488','101.5512115','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:54:17','2025-09-02 17:54:17'),(70,67,'TB-SEL-0066-MBSA-A','3.0509579','101.5352087','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:55:32','2025-09-02 17:55:32'),(71,68,'TB-SEL-0067-MBPJ-A','3.1591131','101.5167731','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 17:56:41','2025-09-02 17:56:41'),(72,69,'TB-SEL-0068-MBSA-A','3.0879669','101.5531685','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 18:02:44','2025-09-02 18:02:44'),(73,70,'TB-SEL-0069-MBPJ-A','3.070836','101.542362','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 18:10:20','2025-09-02 18:10:20'),(74,71,'TB-SEL-0070-MBSA-A','3.077323','101.561581','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 18:11:53','2025-09-02 18:11:53'),(75,72,'TB-KUL-0001-DBKL-A','3.160370','101.722102','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 18:14:13','2025-09-02 18:14:13'),(76,73,'TB-KUL-0002-DBKL-A','3.176000','101.676677','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-02 18:15:39','2025-09-02 18:15:39'),(77,74,'BB-KUL-0003-DBKL-A','3.0403118','101.6726286','1','15x10','Billboard','BB','None','1',1,NULL,'2025-09-02 18:16:38','2025-09-02 18:16:38'),(78,75,'TB-KUL-0004-DBKL-A','3.158355','101.681570','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:19:45','2025-09-03 09:19:45'),(79,76,'TB-KUL-0005-DBKL-A','3.170379','101.663522','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:21:05','2025-09-03 09:21:05'),(80,77,'TB-KUL-0006-DBKL-A','3.117296','101.723634','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:22:13','2025-09-03 09:22:13'),(81,78,'TB-KUL-0007-DBKL-A','3.143678','101.706713','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:26:08','2025-09-03 09:26:08'),(82,79,'TB-KUL-0008-DBKL-A','3.136078','101.672511','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:41:14','2025-09-03 09:41:14'),(83,80,'TB-KUL-0009-DBKL-A','3.164042','101.668339','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:42:18','2025-09-03 09:42:18'),(84,81,'TB-KUL-0010-DBKL-A','3.055952','101.660079','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:44:01','2025-09-03 09:44:01'),(85,82,'TB-KUL-0011-DBKL-A','3.164139','101.6872694','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:51:59','2025-09-03 09:51:59'),(86,83,'TB-KUL-0012-DBKL-A','3.1903054','101.6213004','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:53:06','2025-09-03 09:53:06'),(87,84,'TB-KUL-0013-DBKL-A','3.1699976','101.6908087','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:54:32','2025-09-03 09:54:32'),(88,85,'TB-KUL-0014-DBKL-A','3.1547317','101.7336345','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:55:37','2025-09-03 09:55:37'),(89,86,'TB-KUL-0015-DBKL-A','2.9974415','101.786724','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:56:49','2025-09-03 09:56:49'),(90,87,'TB-KUL-0016-DBKL-A','3.0799153','101.7427843','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:58:04','2025-09-03 09:58:04'),(91,88,'TB-KUL-0017-DBKL-A','3.1179386','101.6660729','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 09:59:16','2025-09-03 09:59:16'),(92,89,'TB-KUL-0018-DBKL-A','3.047856','101.5319981','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:00:29','2025-09-03 10:00:29'),(93,90,'TB-KUL-0019-DBKL-A','3.1339781','101.7346265','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:01:58','2025-09-03 10:01:58'),(94,91,'TB-KUL-0020-DBKL-A','3.1092588','101.728191','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:02:41','2025-09-03 10:02:41'),(95,92,'TB-KUL-0021-DBKL-A','3.1081915','101.7429508','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:04:02','2025-09-03 10:04:02'),(96,93,'TB-KUL-0022-DBKL-A','3.1261691','101.7250801','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:04:54','2025-09-03 10:04:54'),(97,94,'TB-KUL-0023-DBKL-A','3.065906','101.7650463','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:06:22','2025-09-03 10:06:22'),(98,95,'TB-KUL-0024-DBKL-A','3.0508673','101.7742741','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:07:26','2025-09-03 10:07:26'),(99,73,'TB-KUL-0025-DBKL-A','3.1754957','101.6763801','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:07:58','2025-09-03 10:07:58'),(100,96,'TB-KUL-0026-DBKL-A','3.0764651','101.6893671','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:10:42','2025-09-03 10:10:42'),(101,97,'TB-KUL-0027-DBKL-A','3.075073','101.7360847','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:11:40','2025-09-03 10:11:40'),(102,98,'TB-KUL-0028-DBKL-A','3.1011833','101.7229068','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:12:42','2025-09-03 10:12:42'),(103,99,'TB-KUL-0029-DBKL-A','3.216368','101.6892622','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:13:35','2025-09-03 10:13:35'),(104,74,'TB-KUL-0030-DBKL-A','3.0364053','101.6766034','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:14:26','2025-09-03 10:14:26'),(105,100,'TB-KUL-0031-DBKL-A','3.1591459','101.6268433','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:15:35','2025-09-03 10:15:35'),(106,76,'TB-KUL-0032-DBKL-A','3.1704031','101.6636608','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:16:47','2025-09-03 10:16:47'),(107,101,'TB-KUL-0033-DBKL-A','3.1700156','101.670723','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:17:47','2025-09-03 10:17:47'),(108,102,'TB-KUL-0034-DBKL-A','3.2103522','101.7292407','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:19:06','2025-09-03 10:19:06'),(109,103,'TB-KUL-0035-DBKL-A','3.045923','101.647036','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:20:20','2025-09-03 10:20:20'),(110,104,'TB-KUL-0036-DBKL-A','3.134333','101.713389','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:21:44','2025-09-03 10:21:44'),(111,105,'TB-KUL-0037-DBKL-A','3.1234065','101.6831768','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:22:55','2025-09-03 10:22:55'),(112,106,'TB-KUL-0038-DBKL-A','3.2251027','101.6893468','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:23:58','2025-09-03 10:23:58'),(113,107,'TB-KUL-0039-DBKL-A','3.139726','101.681255','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:25:03','2025-09-03 10:25:03'),(114,108,'TB-KUL-0040-DBKL-A','3.2251027','101.6893468','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:26:10','2025-09-03 10:26:10'),(115,109,'TB-KUL-0041-DBKL-A','3.187576','101.669958','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:27:06','2025-09-03 10:27:06'),(116,110,'TB-KUL-0042-DBKL-A','3.135672','101.703921','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:28:14','2025-09-03 10:28:14'),(117,111,'TB-KUL-0043-DBKL-A','3.160667','101.732162','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:29:23','2025-09-03 10:29:23'),(118,112,'TB-KUL-0044-DBKL-A','3.081804','101.732504','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:30:45','2025-09-03 10:30:45'),(119,113,'TB-KUL-0045-DBKL-A','3.154403','101.681134','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:31:50','2025-09-03 10:31:50'),(120,114,'TB-KUL-0046-DBKL-A','3.143729','101.706048','1','15x10','Tempboard','TB','None','1',1,NULL,'2025-09-03 10:32:47','2025-09-03 10:32:47'),(121,115,'BB-SEL-0001-MBPJ-A','3.113721','101.600321','3604680','30x20','Billboard','BB','TNB','1',1,NULL,'2025-09-03 15:11:18','2025-09-03 15:11:50'),(122,116,'BB-SEL-0002-MBPJ-A','3.113721','101.600321','3604680','30x20','Billboard','BB','TNB','1',1,NULL,'2025-09-03 15:14:11','2025-09-03 15:14:11'),(123,117,'BB-SEL-0005-MBPJ-A','3.110951','101.579143','4866690','30x20','Billboard','BB','SOLAR','1',1,NULL,'2025-09-03 15:24:18','2025-09-03 15:24:29'),(124,118,'BB-SEL-0006-MBPJ-A','3.110951','101.579143','4866690','30x20','Billboard','BB','SOLAR','1',1,NULL,'2025-09-03 15:25:41','2025-09-03 15:25:41'),(125,119,'BB-SEL-0008-MPS-A','3.2324279','101.6757559','4820220','30x20','Billboard','BB','TNB','1',1,NULL,'2025-09-03 15:27:01','2025-09-03 15:29:06'),(126,120,'BB-SEL-0009-MPS-A','3.2324279','101.6757559','4820220','30x20','Billboard','BB','TNB','1',1,NULL,'2025-09-03 15:28:15','2025-09-03 15:29:12'),(127,121,'BB-SEL-0010-MBSJ-A','3.023945','101.712352','5386286','30x20','Billboard','BB','SOLAR','1',1,NULL,'2025-09-03 15:30:20','2025-09-03 15:30:20'),(128,122,'BB-SEL-0011-MBSJ-A','3.023945','101.712352','5386286','30x20','Billboard','BB','SOLAR','1',1,NULL,'2025-09-03 15:31:29','2025-09-03 15:31:29'),(129,123,'BB-SEL-0012-MBSJ-A','2.972684','101.574003','5386286','30x20','Billboard','BB','SOLAR','1',1,NULL,'2025-09-03 15:32:34','2025-09-03 15:32:34'),(130,124,'BB-SEL-0013-MBSJ-A','2.972684','101.574003','5386286','30x20','Billboard','BB','SOLAR','1',1,NULL,'2025-09-03 15:34:27','2025-09-03 15:34:27'),(131,125,'BB-SEL-0018-MBSJ-A','2.9933778','101.615991','3024460','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 15:35:34','2025-09-03 15:35:45'),(132,126,'BB-SEL-0019-MBSJ-A','2.9933778','101.615991','3024460','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 15:36:41','2025-09-03 15:36:41'),(133,127,'BB-SEL-0016-MBSJ-A','2.945823','101.592001','5386286','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 15:57:28','2025-09-03 15:58:45'),(134,128,'BB-SEL-0017-MBSJ-A','2.945823','101.592001','5386286','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 15:58:35','2025-09-03 15:58:49'),(135,129,'BB-SEL-0014-MBSJ-A','3.151153','101.597376','3810550','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:01:04','2025-09-03 16:01:19'),(136,130,'BB-SEL-0015-MBSJ-A','3.151153','101.597376','3810550','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:07:30','2025-09-03 16:07:30'),(137,131,'BB-WPK-0003-DBKL-A','3.173047','101.619260','3604680','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:09:26','2025-09-03 16:09:38'),(138,132,'BB-WPK-0001-DBKL-A','3.055123','101.667378','3185255','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:11:26','2025-09-03 16:11:41'),(139,133,'BB-KUL-0002-DBKL-A','3.055123','101.667378','3185255','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:12:34','2025-09-03 16:12:34'),(140,134,'BB-SEL-0022-MBPJ-A','3.157432','101.5724969','2424420','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:21:30','2025-09-03 16:21:44'),(141,135,'BB-SEL-0023-MBPJ-A','3.157432','101.5724969','2424460','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:23:40','2025-09-03 16:23:40'),(142,136,'BB-SEL-0024-MBPJ-A','3.157432','101.5724969','1026640','30x20','Billboard','BB','None','1',1,NULL,'2025-09-03 16:25:05','2025-09-03 16:25:05');
/*!40000 ALTER TABLE `billboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_companies`
--

DROP TABLE IF EXISTS `client_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_companies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_prefix` varchar(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_companies_company_prefix_unique` (`company_prefix`),
  UNIQUE KEY `client_companies_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_companies`
--

LOCK TABLES `client_companies` WRITE;
/*!40000 ALTER TABLE `client_companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `company_id` bigint(20) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_company_id_foreign` (`company_id`),
  CONSTRAINT `clients_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `client_companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contractors`
--

DROP TABLE IF EXISTS `contractors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contractors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contractors`
--

LOCK TABLES `contractors` WRITE;
/*!40000 ALTER TABLE `contractors` DISABLE KEYS */;
/*!40000 ALTER TABLE `contractors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `councils`
--

DROP TABLE IF EXISTS `councils`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `councils` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `abbreviation` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `councils_state_id_foreign` (`state_id`),
  CONSTRAINT `councils_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `councils`
--

LOCK TABLES `councils` WRITE;
/*!40000 ALTER TABLE `councils` DISABLE KEYS */;
INSERT INTO `councils` VALUES (1,1,'Majlis Bandaraya Petaling Jaya','MBPJ','2025-09-02 01:40:23','2025-09-02 01:40:23'),(2,1,'Majlis Bandaraya Shah Alam','MBSA','2025-09-02 01:40:23','2025-09-02 01:40:23'),(3,1,'Majlis Bandaraya Subang Jaya','MBSJ','2025-09-02 01:40:23','2025-09-02 01:40:23'),(4,1,'Majlis Perbandaran Klang','MPDK','2025-09-02 01:40:23','2025-09-02 01:40:23'),(5,1,'Majlis Perbandaran Ampang Jaya','MPAJ','2025-09-02 01:40:23','2025-09-02 01:40:23'),(6,1,'Majlis Perbandaran Selayang','MPS','2025-09-02 01:40:23','2025-09-02 01:40:23'),(7,1,'Majlis Daerah Kuala Selangor','MDKS','2025-09-02 01:40:23','2025-09-02 01:40:23'),(8,1,'Majlis Daerah Hulu Selangor','MDHS','2025-09-02 01:40:23','2025-09-02 01:40:23'),(9,1,'Majlis Perbandaran Kajang','MPKJ','2025-09-02 01:40:23','2025-09-02 01:40:23'),(10,1,'Majlis Daerah Sabak Bernam','MDSB','2025-09-02 01:40:23','2025-09-02 01:40:23'),(11,1,'Majlis Daerah Seri Kembangan','MDSK','2025-09-02 01:40:23','2025-09-02 01:40:23'),(12,1,'Majlis Daerah Sepang','MPSepang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(13,1,'Majlis Daerah Kuala Langat','MDKL','2025-09-02 01:40:24','2025-09-02 01:40:24'),(14,2,'Dewan Bandaraya Kuala Lumpur','DBKL','2025-09-02 01:40:24','2025-09-02 01:40:24'),(15,3,'Perbadanan Putrajaya','PPJ','2025-09-02 01:40:24','2025-09-02 01:40:24'),(16,4,'Perbadanan Labuan','PL','2025-09-02 01:40:24','2025-09-02 01:40:24'),(17,5,'Majlis Bandaraya Johor Bahru','MBJB','2025-09-02 01:40:24','2025-09-02 01:40:24'),(18,5,'Majlis Bandaraya Iskandar Puteri','MBIP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(19,5,'Majlis Perbandaran Batu Pahat','MPBP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(20,5,'Majlis Perbandaran Kluang','MPKluang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(21,5,'Majlis Perbandaran Muar','MPMuar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(22,5,'Majlis Perbandaran Segamat','MPSegamat','2025-09-02 01:40:24','2025-09-02 01:40:24'),(23,5,'Majlis Perbandaran Kulai','MPKulai','2025-09-02 01:40:24','2025-09-02 01:40:24'),(24,5,'Majlis Perbandaran Pontian','MPPn','2025-09-02 01:40:24','2025-09-02 01:40:24'),(25,5,'Majlis Perbandaran Pengerang','MPPengerang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(26,5,'Majlis Bandaraya Pasir Gudang','MBPG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(27,5,'Majlis Daerah Kota Tinggi','MDKT','2025-09-02 01:40:24','2025-09-02 01:40:24'),(28,5,'Majlis Daerah Mersing','MDMersing','2025-09-02 01:40:24','2025-09-02 01:40:24'),(29,5,'Majlis Daerah Tangkak','MDTangkak','2025-09-02 01:40:24','2025-09-02 01:40:24'),(30,5,'Majlis Daerah Simpang Renggam','MDSR','2025-09-02 01:40:24','2025-09-02 01:40:24'),(31,5,'Majlis Daerah Labis','MDLabis','2025-09-02 01:40:24','2025-09-02 01:40:24'),(32,5,'Majlis Daerah Yong Peng','MDYP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(33,6,'Majlis Bandaraya Pulau Pinang','MBPP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(34,6,'Majlis Bandaraya Seberang Perai','MBSP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(35,7,'Majlis Bandaraya Ipoh','MBI','2025-09-02 01:40:24','2025-09-02 01:40:24'),(36,7,'Majlis Perbandaran Taiping','MPTaiping','2025-09-02 01:40:24','2025-09-02 01:40:24'),(37,7,'Majlis Perbandaran Manjung','MPM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(38,7,'Majlis Daerah Perak Tengah','MDPT','2025-09-02 01:40:24','2025-09-02 01:40:24'),(39,7,'Majlis Perbandaran Kuala Kangsar','MPKKPK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(40,7,'Majlis Daerah Selama','MDSelama','2025-09-02 01:40:24','2025-09-02 01:40:24'),(41,7,'Majlis Daerah Batu Gajah','MDBG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(42,7,'Majlis Daerah Kampar','MDKampar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(43,7,'Majlis Daerah Gerik','MDG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(44,7,'Majlis Daerah Lenggong','MDLG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(45,7,'Majlis Daerah Pengkalan Hulu','MDPH','2025-09-02 01:40:24','2025-09-02 01:40:24'),(46,7,'Majlis Daerah Tapah','MDTapah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(47,7,'Majlis Daerah Tanjong Malim','MDTM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(48,7,'Majlis Perbandaran Teluk Intan','MPTI','2025-09-02 01:40:24','2025-09-02 01:40:24'),(49,7,'Majlis Daerah Kerian','MDKerian','2025-09-02 01:40:24','2025-09-02 01:40:24'),(50,8,'Majlis Bandaraya Kuantan','MBK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(51,8,'Majlis Perbandaran Temerloh','MPT','2025-09-02 01:40:24','2025-09-02 01:40:24'),(52,8,'Majlis Perbandaran Bentong','MPBENTONG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(53,8,'Majlis Perbandaran Pekan Bandar Diraja','MPPekan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(54,8,'Majlis Daerah Lipis','MDLipis','2025-09-02 01:40:24','2025-09-02 01:40:24'),(55,8,'Majlis Daerah Cameron Highlands','MDCH','2025-09-02 01:40:24','2025-09-02 01:40:24'),(56,8,'Majlis Daerah Raub','MDRaub','2025-09-02 01:40:24','2025-09-02 01:40:24'),(57,8,'Majlis Daerah Bera','MDBera','2025-09-02 01:40:24','2025-09-02 01:40:24'),(58,8,'Majlis Daerah Maran','MDMaran','2025-09-02 01:40:24','2025-09-02 01:40:24'),(59,8,'Majlis Daerah Rompin','MDRompin','2025-09-02 01:40:24','2025-09-02 01:40:24'),(60,8,'Majlis Daerah Jerantut','MDJerantut','2025-09-02 01:40:24','2025-09-02 01:40:24'),(61,9,'Majlis Bandaraya Alor Setar','MBAS','2025-09-02 01:40:24','2025-09-02 01:40:24'),(62,9,'Majlis Perbandaran Sungai Petani','MPSPK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(63,9,'Majlis Perbandaran Kulim','MPKK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(64,9,'Majlis Perbandaran Kubang Pasu','MPKPasu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(65,9,'Majlis Perbandaran Langkawi Bandaraya Pelancongan','MPL','2025-09-02 01:40:24','2025-09-02 01:40:24'),(66,9,'Majlis Daerah Baling','MDBaling','2025-09-02 01:40:24','2025-09-02 01:40:24'),(67,9,'Majlis Daerah Yan','MDYan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(68,9,'Majlis Daerah Sik','MDSik','2025-09-02 01:40:24','2025-09-02 01:40:24'),(69,9,'Majlis Daerah Pendang','MDPendang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(70,9,'Majlis Daerah Padang Terap','MDPTerap','2025-09-02 01:40:24','2025-09-02 01:40:24'),(71,9,'Majlis Daerah Bandar Baharu','MDBB','2025-09-02 01:40:24','2025-09-02 01:40:24'),(72,10,'Majlis Perbandaran Kota Bharu - Bandar Raya Islam','MPKBBRI','2025-09-02 01:40:24','2025-09-02 01:40:24'),(73,10,'Majlis Daerah Bachok Bandar Pelancongan Islam','MDBachok','2025-09-02 01:40:24','2025-09-02 01:40:24'),(74,10,'Majlis Daerah Gua Musang','MDGM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(75,10,'Majlis Daerah Jeli','MDJeli','2025-09-02 01:40:24','2025-09-02 01:40:24'),(76,10,'Majlis Daerah Ketereh - Perbandaran Islam','MDKetereh','2025-09-02 01:40:24','2025-09-02 01:40:24'),(77,10,'Majlis Daerah Dabong','MDDabong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(78,10,'Majlis Daerah Kuala Krai','MDKK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(79,10,'Majlis Daerah Machang','MDMachang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(80,10,'Majlis Daerah Pasir Mas','MDPM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(81,10,'Majlis Daerah Pasir Puteh','MDPP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(82,10,'Majlis Daerah Tanah Merah','MDTMerah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(83,10,'Majlis Daerah Tumpat','MDTumpat','2025-09-02 01:40:24','2025-09-02 01:40:24'),(84,11,'Majlis Bandaraya Kuala Terengganu','MBKT','2025-09-02 01:40:24','2025-09-02 01:40:24'),(85,11,'Majlis Daerah Besut','MDBesut','2025-09-02 01:40:24','2025-09-02 01:40:24'),(86,11,'Majlis Daerah Setiu','MDSetiu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(87,11,'Majlis Perbandaran Dungun','MPDungun','2025-09-02 01:40:24','2025-09-02 01:40:24'),(88,11,'Majlis Daerah Hulu Terengganu','MDHT','2025-09-02 01:40:24','2025-09-02 01:40:24'),(89,11,'Majlis Perbandaran Kemaman','MPKemaman','2025-09-02 01:40:24','2025-09-02 01:40:24'),(90,11,'Majlis Daerah Marang','MDMarang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(91,12,'Majlis Bandaraya Melaka Bersejarah','MBMB','2025-09-02 01:40:24','2025-09-02 01:40:24'),(92,12,'Majlis Perbandaran Alor Gajah','MPAG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(93,12,'Majlis Perbandaran Majlis Perbandaran Hang Tuah Jaya','	MPHTJ','2025-09-02 01:40:24','2025-09-02 01:40:24'),(94,12,'Majlis Perbandaran Jasin','MPJ','2025-09-02 01:40:24','2025-09-02 01:40:24'),(95,13,'Majlis Bandaraya Seremban','MBS','2025-09-02 01:40:24','2025-09-02 01:40:24'),(96,13,'Majlis Daerah Kuala Pilah','MDKP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(97,13,'Majlis Daerah Tampin','MDTampin','2025-09-02 01:40:24','2025-09-02 01:40:24'),(98,13,'Majlis Perbandaran Port Dickson','MPPD','2025-09-02 01:40:24','2025-09-02 01:40:24'),(99,13,'Majlis Daerah Jelebu','MDJelebu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(100,13,'Majlis Daerah Rembau','MDR','2025-09-02 01:40:24','2025-09-02 01:40:24'),(101,13,'Majlis Perbandaran Jempol','MPJL','2025-09-02 01:40:24','2025-09-02 01:40:24'),(102,14,'Majlis Perbandaran Kangar','MPKgr','2025-09-02 01:40:24','2025-09-02 01:40:24'),(103,15,'Dewan Bandaraya Kota Kinabalu','DBKK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(104,15,'Majlis Perbandaran Sandakan','MPS','2025-09-02 01:40:24','2025-09-02 01:40:24'),(105,15,'Majlis Perbandaran Tawau','MPT','2025-09-02 01:40:24','2025-09-02 01:40:24'),(106,15,'Lembaga Bandaran Kudat','LBK','2025-09-02 01:40:24','2025-09-02 01:40:24'),(107,15,'Majlis Daerah Beaufort','MDBeaufort','2025-09-02 01:40:24','2025-09-02 01:40:24'),(108,15,'Majlis Daerah Beluran','MDBeluran','2025-09-02 01:40:24','2025-09-02 01:40:24'),(109,15,'Majlis Daerah Keningau','MDKeningau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(110,15,'Majlis Daerah Kinabatangan','MDKinabatangan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(111,15,'Majlis Daerah Kota Belud','MDKB','2025-09-02 01:40:24','2025-09-02 01:40:24'),(112,15,'Majlis Daerah Kota Marudu','MDKM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(113,15,'Majlis Daerah Kuala Penyu','MDKPenyu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(114,15,'Majlis Daerah Kunak','MDKunak','2025-09-02 01:40:24','2025-09-02 01:40:24'),(115,15,'Majlis Daerah Lahad Datu','MDLD','2025-09-02 01:40:24','2025-09-02 01:40:24'),(116,15,'Majlis Daerah Nabawan','MDN','2025-09-02 01:40:24','2025-09-02 01:40:24'),(117,15,'Majlis Daerah Papar','MDPapar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(118,15,'Majlis Perbandaran Penampang','MPPenampang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(119,15,'Majlis Daerah Ranau','MDRanau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(120,15,'Majlis Daerah Semporna','MDSemporna','2025-09-02 01:40:24','2025-09-02 01:40:24'),(121,15,'Majlis Daerah Sipitang','MDSipitang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(122,15,'Majlis Daerah Tambunan','MDTambunan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(123,15,'Majlis Daerah Tenom','MDTenom','2025-09-02 01:40:24','2025-09-02 01:40:24'),(124,15,'Majlis Daerah Tuaran','MDTuaran','2025-09-02 01:40:24','2025-09-02 01:40:24'),(125,15,'Majlis Daerah Putatan','MDPutatan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(126,15,'Majlis Daerah Pitas','MDPitas','2025-09-02 01:40:24','2025-09-02 01:40:24'),(127,15,'Majlis Daerah Tongod','MDTongod','2025-09-02 01:40:24','2025-09-02 01:40:24'),(128,15,'Majlis Daerah Telupid','MDTelupid','2025-09-02 01:40:24','2025-09-02 01:40:24'),(129,16,'Lembaga Kemajuan Bintulu','BDA','2025-09-02 01:40:24','2025-09-02 01:40:24'),(130,16,'Dewan Bandaraya Kuching Utara','DBKU','2025-09-02 01:40:24','2025-09-02 01:40:24'),(131,16,'Majlis Bandaraya Kuching Selatan','MBKS','2025-09-02 01:40:24','2025-09-02 01:40:24'),(132,16,'Majlis Perbandaran Padawan','MPP','2025-09-02 01:40:24','2025-09-02 01:40:24'),(133,16,'Majlis Perbandaran Sibu','SMC','2025-09-02 01:40:24','2025-09-02 01:40:24'),(134,16,'Majlis Bandaraya Miri','MBM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(135,16,'Majlis Daerah Bau','BAUDC','2025-09-02 01:40:24','2025-09-02 01:40:24'),(136,16,'Majlis Daerah Betong','MDBetong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(137,16,'Majlis Daerah Dalat & Mukah','MDDM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(138,16,'Majlis Daerah Kanowit','MDKanowit','2025-09-02 01:40:24','2025-09-02 01:40:24'),(139,16,'Majlis Daerah Kapit','MDKapit','2025-09-02 01:40:24','2025-09-02 01:40:24'),(140,16,'Majlis Daerah Lawas','MDLawas','2025-09-02 01:40:24','2025-09-02 01:40:24'),(141,16,'Majlis Daerah Limbang','MDLimbang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(142,16,'Majlis Daerah Lubok Antu','MDLA','2025-09-02 01:40:24','2025-09-02 01:40:24'),(143,16,'Majlis Daerah Lundu','MDLundu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(144,16,'Majlis Daerah Maradong & Julau','MDMJ','2025-09-02 01:40:24','2025-09-02 01:40:24'),(145,16,'Majlis Daerah Marudi','MDM','2025-09-02 01:40:24','2025-09-02 01:40:24'),(146,16,'Majlis Daerah Matu & Daro','MDMD','2025-09-02 01:40:24','2025-09-02 01:40:24'),(147,16,'Majlis Daerah Saratok','MDSaratok','2025-09-02 01:40:24','2025-09-02 01:40:24'),(148,16,'Majlis Perbandaran Kota Samarahan','MPKS','2025-09-02 01:40:24','2025-09-02 01:40:24'),(149,16,'Majlis Daerah Serian','MDSerian','2025-09-02 01:40:24','2025-09-02 01:40:24'),(150,16,'Majlis Daerah Sarikei','MDSarikei','2025-09-02 01:40:24','2025-09-02 01:40:24'),(151,16,'Majlis Daerah Simunjan','MDSimunjan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(152,16,'Majlis Daerah Sri Aman','MDSA','2025-09-02 01:40:24','2025-09-02 01:40:24'),(153,16,'Majlis Daerah Subis','MDSubis','2025-09-02 01:40:24','2025-09-02 01:40:24'),(154,16,'Majlis Daerah Luar Bandar Sibu','MDLBS','2025-09-02 01:40:24','2025-09-02 01:40:24'),(155,16,'Majlis Daerah Gedong','MDG','2025-09-02 01:40:24','2025-09-02 01:40:24'),(156,NULL,'Kementerian Kerja Raya','KKR','2025-09-02 01:40:24','2025-09-02 01:40:24');
/*!40000 ALTER TABLE `councils` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `districts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_state_id_foreign` (`state_id`),
  CONSTRAINT `districts_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (1,1,'Petaling','2025-09-02 01:40:23','2025-09-02 01:40:23'),(2,1,'Klang','2025-09-02 01:40:23','2025-09-02 01:40:23'),(3,1,'Hulu Langat','2025-09-02 01:40:23','2025-09-02 01:40:23'),(4,1,'Gombak','2025-09-02 01:40:23','2025-09-02 01:40:23'),(5,1,'Kuala Selangor','2025-09-02 01:40:23','2025-09-02 01:40:23'),(6,1,'Sabak Bernam','2025-09-02 01:40:23','2025-09-02 01:40:23'),(7,1,'Kuala Langat','2025-09-02 01:40:23','2025-09-02 01:40:23'),(8,1,'Hulu Selangor','2025-09-02 01:40:23','2025-09-02 01:40:23'),(9,1,'Ampang Jaya','2025-09-02 01:40:23','2025-09-02 01:40:23'),(10,1,'Kajang','2025-09-02 01:40:23','2025-09-02 01:40:23'),(11,1,'Seri Kembangan','2025-09-02 01:40:23','2025-09-02 01:40:23'),(12,1,'Sepang','2025-09-02 01:40:23','2025-09-02 01:40:23'),(13,2,'Kuala Lumpur','2025-09-02 01:40:24','2025-09-02 01:40:24'),(14,2,'Cheras','2025-09-02 01:40:24','2025-09-02 01:40:24'),(15,2,'Kepong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(16,2,'Lembah Pantai','2025-09-02 01:40:24','2025-09-02 01:40:24'),(17,2,'Segambut','2025-09-02 01:40:24','2025-09-02 01:40:24'),(18,2,'Setiawangsa','2025-09-02 01:40:24','2025-09-02 01:40:24'),(19,2,'Titiwangsa','2025-09-02 01:40:24','2025-09-02 01:40:24'),(20,2,'Wangsa Maju','2025-09-02 01:40:24','2025-09-02 01:40:24'),(21,3,'Precinct 1','2025-09-02 01:40:24','2025-09-02 01:40:24'),(22,3,'Precinct 2','2025-09-02 01:40:24','2025-09-02 01:40:24'),(23,3,'Precinct 3','2025-09-02 01:40:24','2025-09-02 01:40:24'),(24,3,'Precinct 4','2025-09-02 01:40:24','2025-09-02 01:40:24'),(25,4,'Labuan Town','2025-09-02 01:40:24','2025-09-02 01:40:24'),(26,5,'Johor Bahru','2025-09-02 01:40:24','2025-09-02 01:40:24'),(27,5,'Batu Pahat','2025-09-02 01:40:24','2025-09-02 01:40:24'),(28,5,'Kluang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(29,5,'Muar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(30,5,'Segamat','2025-09-02 01:40:24','2025-09-02 01:40:24'),(31,5,'Pontian','2025-09-02 01:40:24','2025-09-02 01:40:24'),(32,5,'Kulai','2025-09-02 01:40:24','2025-09-02 01:40:24'),(33,5,'Kota Tinggi','2025-09-02 01:40:24','2025-09-02 01:40:24'),(34,5,'Mersing','2025-09-02 01:40:24','2025-09-02 01:40:24'),(35,5,'Tangkak','2025-09-02 01:40:24','2025-09-02 01:40:24'),(36,6,'Timur Laut','2025-09-02 01:40:24','2025-09-02 01:40:24'),(37,6,'Barat Daya','2025-09-02 01:40:24','2025-09-02 01:40:24'),(38,6,'Seberang Perai Utara','2025-09-02 01:40:24','2025-09-02 01:40:24'),(39,6,'Seberang Perai Tengah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(40,6,'Seberang Perai Selatan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(41,7,'Kinta','2025-09-02 01:40:24','2025-09-02 01:40:24'),(42,7,'Larut Matang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(43,7,'Hilir Perak','2025-09-02 01:40:24','2025-09-02 01:40:24'),(44,7,'Kuala Kangsar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(45,7,'Manjung','2025-09-02 01:40:24','2025-09-02 01:40:24'),(46,7,'Perak Tengah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(47,7,'Selama','2025-09-02 01:40:24','2025-09-02 01:40:24'),(48,7,'Batu Gajah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(49,7,'Kampar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(50,7,'Gerik','2025-09-02 01:40:24','2025-09-02 01:40:24'),(51,7,'Lenggong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(52,7,'Pengkalan Hulu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(53,7,'Tapah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(54,7,'Tanjong Malim','2025-09-02 01:40:24','2025-09-02 01:40:24'),(55,7,'Kerian','2025-09-02 01:40:24','2025-09-02 01:40:24'),(56,8,'Kuantan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(57,8,'Temerloh','2025-09-02 01:40:24','2025-09-02 01:40:24'),(58,8,'Bentong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(59,8,'Pekan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(60,8,'Kuala Lipis','2025-09-02 01:40:24','2025-09-02 01:40:24'),(61,8,'Cameron Highlands','2025-09-02 01:40:24','2025-09-02 01:40:24'),(62,8,'Raub','2025-09-02 01:40:24','2025-09-02 01:40:24'),(63,8,'Bera','2025-09-02 01:40:24','2025-09-02 01:40:24'),(64,8,'Maran','2025-09-02 01:40:24','2025-09-02 01:40:24'),(65,8,'Rompin','2025-09-02 01:40:24','2025-09-02 01:40:24'),(66,8,'Jerantut','2025-09-02 01:40:24','2025-09-02 01:40:24'),(67,9,'Alor Setar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(68,9,'Sungai Petani','2025-09-02 01:40:24','2025-09-02 01:40:24'),(69,9,'Kulim','2025-09-02 01:40:24','2025-09-02 01:40:24'),(70,9,'Kubang Pasu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(71,9,'Baling','2025-09-02 01:40:24','2025-09-02 01:40:24'),(72,9,'Yan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(73,9,'Sik','2025-09-02 01:40:24','2025-09-02 01:40:24'),(74,9,'Pendang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(75,9,'Padang Terap','2025-09-02 01:40:24','2025-09-02 01:40:24'),(76,9,'Bandar Baharu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(77,9,'Langkawi','2025-09-02 01:40:24','2025-09-02 01:40:24'),(78,10,'Kota Bharu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(79,10,'Bachok','2025-09-02 01:40:24','2025-09-02 01:40:24'),(80,10,'Gua Musang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(81,10,'Jeli','2025-09-02 01:40:24','2025-09-02 01:40:24'),(82,10,'Ketereh','2025-09-02 01:40:24','2025-09-02 01:40:24'),(83,10,'Dabong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(84,10,'Kuala Krai','2025-09-02 01:40:24','2025-09-02 01:40:24'),(85,10,'Machang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(86,10,'Pasir Mas','2025-09-02 01:40:24','2025-09-02 01:40:24'),(87,10,'Pasir Puteh','2025-09-02 01:40:24','2025-09-02 01:40:24'),(88,10,'Tanah Merah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(89,10,'Tumpat','2025-09-02 01:40:24','2025-09-02 01:40:24'),(90,11,'Kuala Terengganu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(91,11,'Besut','2025-09-02 01:40:24','2025-09-02 01:40:24'),(92,11,'Setiu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(93,11,'Dungun','2025-09-02 01:40:24','2025-09-02 01:40:24'),(94,11,'Hulu Terengganu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(95,11,'Kemaman','2025-09-02 01:40:24','2025-09-02 01:40:24'),(96,11,'Marang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(97,12,'Melaka Tengah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(98,12,'Alor Gajah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(99,12,'Jasin','2025-09-02 01:40:24','2025-09-02 01:40:24'),(100,12,'Majlis Perbandaran Hang Tuah Jaya','2025-09-02 01:40:24','2025-09-02 01:40:24'),(101,13,'Seremban','2025-09-02 01:40:24','2025-09-02 01:40:24'),(102,13,'Port Dickson','2025-09-02 01:40:24','2025-09-02 01:40:24'),(103,13,'Jempol','2025-09-02 01:40:24','2025-09-02 01:40:24'),(104,13,'Kuala Pilah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(105,13,'Tampin','2025-09-02 01:40:24','2025-09-02 01:40:24'),(106,13,'Jelebu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(107,13,'Rembau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(108,14,'Kangar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(109,14,'Arau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(110,14,'Padang Besar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(111,15,'Kota Kinabalu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(112,15,'Sandakan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(113,15,'Tawau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(114,15,'Kudat','2025-09-02 01:40:24','2025-09-02 01:40:24'),(115,15,'Beaufort','2025-09-02 01:40:24','2025-09-02 01:40:24'),(116,15,'Beluran','2025-09-02 01:40:24','2025-09-02 01:40:24'),(117,15,'Keningau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(118,15,'Kinabatangan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(119,15,'Kota Belud','2025-09-02 01:40:24','2025-09-02 01:40:24'),(120,15,'Kota Marudu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(121,15,'Kuala Penyu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(122,15,'Kunak','2025-09-02 01:40:24','2025-09-02 01:40:24'),(123,15,'Lahad Datu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(124,15,'Nabawan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(125,15,'Papar','2025-09-02 01:40:24','2025-09-02 01:40:24'),(126,15,'Penampang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(127,15,'Ranau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(128,15,'Semporna','2025-09-02 01:40:24','2025-09-02 01:40:24'),(129,15,'Sipitang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(130,15,'Tambunan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(131,15,'Tenom','2025-09-02 01:40:24','2025-09-02 01:40:24'),(132,15,'Tuaran','2025-09-02 01:40:24','2025-09-02 01:40:24'),(133,15,'Putatan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(134,15,'Pitas','2025-09-02 01:40:24','2025-09-02 01:40:24'),(135,15,'Tongod','2025-09-02 01:40:24','2025-09-02 01:40:24'),(136,15,'Telupid','2025-09-02 01:40:24','2025-09-02 01:40:24'),(137,16,'Bintulu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(138,16,'Kuching','2025-09-02 01:40:24','2025-09-02 01:40:24'),(139,16,'Sibu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(140,16,'Miri','2025-09-02 01:40:24','2025-09-02 01:40:24'),(141,16,'Bau','2025-09-02 01:40:24','2025-09-02 01:40:24'),(142,16,'Betong','2025-09-02 01:40:24','2025-09-02 01:40:24'),(143,16,'Mukah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(144,16,'Kanowit','2025-09-02 01:40:24','2025-09-02 01:40:24'),(145,16,'Kapit','2025-09-02 01:40:24','2025-09-02 01:40:24'),(146,16,'Lawas','2025-09-02 01:40:24','2025-09-02 01:40:24'),(147,16,'Limbang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(148,16,'Lubok Antu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(149,16,'Lundu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(150,16,'Bintangor','2025-09-02 01:40:24','2025-09-02 01:40:24'),(151,16,'Baram','2025-09-02 01:40:24','2025-09-02 01:40:24'),(152,16,'Matu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(153,16,'Saratok','2025-09-02 01:40:24','2025-09-02 01:40:24'),(154,16,'Kota Samarahan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(155,16,'Serian','2025-09-02 01:40:24','2025-09-02 01:40:24'),(156,16,'Sarikei','2025-09-02 01:40:24','2025-09-02 01:40:24'),(157,16,'Simunjan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(158,16,'Sri Aman','2025-09-02 01:40:24','2025-09-02 01:40:24'),(159,16,'Bekenu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(160,16,'Gedong','2025-09-02 01:40:24','2025-09-02 01:40:24');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
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
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `council_id` bigint(20) unsigned NOT NULL,
  `district_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `updated_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locations_council_id_foreign` (`council_id`),
  KEY `locations_district_id_foreign` (`district_id`),
  KEY `locations_created_by_foreign` (`created_by`),
  KEY `locations_updated_by_foreign` (`updated_by`),
  CONSTRAINT `locations_council_id_foreign` FOREIGN KEY (`council_id`) REFERENCES `councils` (`id`) ON DELETE CASCADE,
  CONSTRAINT `locations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `locations_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `locations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,4,2,'Persiaran Raja Muda Musa - Klang',NULL,NULL,'2025-09-02 01:45:36','2025-09-02 01:45:36'),(2,95,101,'Persiaran Pusat Bandar – Nilai',NULL,NULL,'2025-09-02 01:47:22','2025-09-02 01:47:22'),(3,95,101,'Seremban 2 Persiaran S2/B3 (Near Uncle Don)',NULL,NULL,'2025-09-02 01:48:59','2025-09-02 01:48:59'),(4,9,2,'Persiaran Raja Muda Musa - Klang',NULL,NULL,'2025-09-02 02:04:58','2025-09-02 02:04:58'),(5,9,2,'Exit Persiaran Rajawali (Near Roundabout), Klang',NULL,NULL,'2025-09-02 02:06:23','2025-09-02 02:06:23'),(6,9,2,'Klang',NULL,NULL,'2025-09-02 02:07:51','2025-09-02 02:07:51'),(7,5,9,'39 Jalan Ukay Perdana, Ampang Jaya',NULL,NULL,'2025-09-02 02:08:59','2025-09-02 02:08:59'),(8,5,9,'Jalan Perdana 1 – Pandan Perdana',NULL,NULL,'2025-09-02 02:10:18','2025-09-02 02:10:18'),(9,9,10,'Persiaran Saujana Impian, Kajang (Opposite Lotus)',NULL,NULL,'2025-09-02 02:12:05','2025-09-02 02:12:05'),(10,9,10,'Sungai Long',NULL,NULL,'2025-09-02 02:13:38','2025-09-02 02:13:38'),(11,9,10,'Jalan Bukit Dugang – Before Turning right to Persiaran Selatan Putrajaya',NULL,NULL,'2025-09-02 02:15:00','2025-09-02 02:15:00'),(12,9,10,'Desa Pinggiran Putra – Before turning Left to Persiaran Timur',NULL,NULL,'2025-09-02 02:16:18','2025-09-02 02:16:18'),(13,7,5,'Near KIP Mall – Laluan 54 – Jalan Kuala Selangor',NULL,NULL,'2025-09-02 02:17:51','2025-09-02 02:17:51'),(14,7,5,'Jalan Metro Prima (AEON Kepong)',NULL,NULL,'2025-09-02 02:19:44','2025-09-02 02:19:44'),(15,7,3,'Lebuh Utama  Tun Hussien Onn',NULL,NULL,'2025-09-02 02:21:59','2025-09-02 02:21:59'),(16,6,9,'MRR2 – Towards Ampang',NULL,NULL,'2025-09-02 02:23:46','2025-09-02 02:23:46'),(17,6,9,'Jln Kuching – Towards Rawang (Near Caltex & Warta)',NULL,NULL,'2025-09-02 02:25:19','2025-09-02 02:25:19'),(18,6,9,'Jalan Kuasa Selangor',NULL,NULL,'2025-09-02 02:27:11','2025-09-02 02:27:11'),(19,6,9,'Jalan Rawang Before Tuning to Lotus (Tesco)',NULL,NULL,'2025-09-02 02:29:05','2025-09-02 02:29:05'),(20,6,9,'Persiaran Angun – Rawang',NULL,NULL,'2025-09-02 02:30:23','2025-09-02 02:30:23'),(21,6,9,'Jalan Batu Arang (heading to KL)',NULL,NULL,'2025-09-02 08:25:51','2025-09-02 08:25:51'),(22,11,11,'Persiaran Puncak Jalil',NULL,NULL,'2025-09-02 08:29:04','2025-09-02 08:29:04'),(23,11,11,'Jalan Putra Permai – Seri Kembangan (Opposite Giant)',NULL,NULL,'2025-09-02 08:31:34','2025-09-02 08:31:34'),(24,11,11,'Jalan Robson – Towards Mid Valley',NULL,NULL,'2025-09-02 08:33:48','2025-09-02 08:33:48'),(25,11,11,'Persiaran Lestari Perdana',NULL,NULL,'2025-09-02 08:35:56','2025-09-02 08:35:56'),(26,11,11,'Seri Kembangan – NS Highway (Towards Seremban)',NULL,NULL,'2025-09-02 08:38:00','2025-09-02 08:38:00'),(27,11,11,'Seri Kembangan – near Mines',NULL,NULL,'2025-09-02 08:39:29','2025-09-02 08:39:29'),(28,11,11,'Lebuhraya Putrajaya – Cyberjaya (heading to KLIA)',NULL,NULL,'2025-09-02 08:41:02','2025-09-02 08:41:02'),(29,12,11,'Jalan Teknokrat 1/1 (towards Limkokwing University, Cyberjaya)',NULL,NULL,'2025-09-02 08:43:02','2025-09-02 08:43:02'),(30,3,1,'Along NPE (from Subang Jaya to Bandar Sunway)',NULL,NULL,'2025-09-02 08:45:20','2025-09-02 08:45:20'),(31,3,1,'Jalan Perindustrian Bukit Serdang',NULL,NULL,'2025-09-02 08:46:44','2025-09-02 08:46:44'),(32,3,1,'Persiaran Jengka towards Inti International College Subang Jaya)',NULL,NULL,'2025-09-02 08:48:28','2025-09-02 08:48:28'),(33,3,1,'Subang Jaya SS15',NULL,NULL,'2025-09-02 08:53:07','2025-09-02 08:53:07'),(34,3,1,'Before Tunnel towards Persiaran Teknologi Subang (Subang Hi-Tech)',NULL,NULL,'2025-09-02 08:55:15','2025-09-02 08:55:15'),(35,3,1,'Jalan Taylors (towards Taylors College, PJS7)',NULL,NULL,'2025-09-02 08:56:55','2025-09-02 08:56:55'),(36,3,1,'Persiaran Jengka towards Inti International College Subang Jaya',NULL,NULL,'2025-09-02 09:00:28','2025-09-02 09:00:28'),(37,3,1,'Jln Batu 3 Lama, Near Sek 19, Shah Alam',NULL,NULL,'2025-09-02 09:05:02','2025-09-02 09:05:02'),(38,9,10,'Persiaran Kemajuan Bangi',NULL,NULL,'2025-09-02 09:07:01','2025-09-02 09:07:01'),(39,9,10,'Persiaran Bangi',NULL,NULL,'2025-09-02 09:13:18','2025-09-02 09:13:18'),(40,9,10,'Roundabout Near Bangi Exit to Plus Highway',NULL,NULL,'2025-09-02 09:14:43','2025-09-02 09:14:43'),(41,9,10,'Bulatan Sek 7 Bangi',NULL,NULL,'2025-09-02 09:15:50','2025-09-02 09:15:50'),(42,1,1,'Sek 9, Kota Damansara – Turning From Sg.Buloh (PJ)',NULL,NULL,'2025-09-02 09:17:49','2025-09-02 09:17:49'),(43,1,1,'From Sunway to Puchong PJ',NULL,NULL,'2025-09-02 09:19:16','2025-09-02 09:19:16'),(44,1,1,'Jln Hevea – Jln Sg. Buloh (Near Kwasa Land)',NULL,NULL,'2025-09-02 09:20:43','2025-09-02 09:20:43'),(45,1,1,'Persiaran Surian – Towards Jln Mahogani PJ',NULL,NULL,'2025-09-02 09:22:04','2025-09-02 09:22:04'),(46,1,1,'Persiaran Tropicana Petaling Jaya',NULL,NULL,'2025-09-02 09:23:21','2025-09-02 09:23:21'),(47,1,1,'Petaling Jaya',NULL,NULL,'2025-09-02 09:24:36','2025-09-02 09:24:36'),(48,1,1,'Jalan Puchong – Near Uptown Night Bazar',NULL,NULL,'2025-09-02 09:26:11','2025-09-02 09:26:11'),(49,1,1,'Jalan Sungai Buloh – Persiaran Jati',NULL,NULL,'2025-09-02 09:28:39','2025-09-02 09:28:39'),(50,1,1,'Jalan SS 24/2, Tmn Megah, PJ',NULL,NULL,'2025-09-02 09:31:55','2025-09-02 09:31:55'),(51,1,1,'Persiaran PP Narayanan, Jalan 222 PJ heading to Federal Highway',NULL,NULL,'2025-09-02 09:33:22','2025-09-02 09:33:22'),(52,1,1,'Jln Lapangan Terbang – Towards Airport',NULL,NULL,'2025-09-02 09:34:46','2025-09-02 09:34:46'),(53,2,1,'Jalan Pekan Subang – In Front of Econsave',NULL,NULL,'2025-09-02 09:36:32','2025-09-02 09:36:32'),(54,2,1,'Section 13 Shah Alam (Persiaran Akuatik – Persiaran Sukan, Seksyen 13',NULL,NULL,'2025-09-02 09:38:07','2025-09-02 09:38:07'),(55,1,1,'Persiaran Shah Alam (1.8km to Setia City Mall)',NULL,NULL,'2025-09-02 09:39:28','2025-09-02 09:39:28'),(56,2,1,'Section 13 Shah Alam (Jalan Subang to Persiaran Sukan)',NULL,NULL,'2025-09-02 09:41:03','2025-09-02 09:41:03'),(57,2,1,'Padang Jawa – Persiaran Selangor',NULL,NULL,'2025-09-02 09:42:10','2025-09-02 09:42:10'),(58,2,1,'Kota Kemuning – Persiaran Anggerik Mokara',NULL,NULL,'2025-09-02 09:43:29','2025-09-02 09:43:29'),(59,2,1,'Jalan Monfort – Near Patron TTDI Shah Alam',NULL,NULL,'2025-09-02 09:44:58','2025-09-02 09:44:58'),(60,2,1,'Jalan Pegaga U12 Shah Alam',NULL,NULL,'2025-09-02 09:46:30','2025-09-02 09:46:30'),(61,2,1,'Jalan SU 4, Near Nippon Before Turning Left to Per Tengku Ampuan',NULL,NULL,'2025-09-02 09:47:44','2025-09-02 09:47:44'),(62,2,1,'Jalan Lompat Galah 13/36 – Near Acapella Hotel',NULL,NULL,'2025-09-02 09:48:55','2025-09-02 09:48:55'),(63,2,1,'Shah Alam (sekyen 7)',NULL,NULL,'2025-09-02 09:50:29','2025-09-02 09:50:29'),(64,2,1,'Persiaran Akuatik 2 – Near AEON Mall',NULL,NULL,'2025-09-02 09:51:47','2025-09-02 09:51:47'),(65,2,1,'Jalan Nyiur, Sek 18 Shah Alam (Near KTM Shah Alam & Selangor Bus Stop)',NULL,NULL,'2025-09-02 09:52:52','2025-09-02 09:52:52'),(66,2,1,'Persiaran Sukan – Before Turning to Highway',NULL,NULL,'2025-09-02 09:54:17','2025-09-02 09:54:17'),(67,2,1,'Jalan Nelayan, Sek 19 Shah Alam (Near Shell De’ Palma)',NULL,NULL,'2025-09-02 09:55:32','2025-09-02 09:55:32'),(68,1,1,'Persiaran Elektron Towards Caltex Petrol Station',NULL,NULL,'2025-09-02 09:56:41','2025-09-02 09:56:41'),(69,2,1,'GCE Seksyen 13 – Towards Bukit Jelutong – Near TTDI Shah Alam',NULL,NULL,'2025-09-02 10:02:44','2025-09-02 10:02:44'),(70,1,1,'Federal Highway (towards Shah Alam)',NULL,NULL,'2025-09-02 10:10:20','2025-09-02 10:10:20'),(71,2,1,'Batu Tiga Federal Highway (Shah AlamPJ)',NULL,NULL,'2025-09-02 10:11:53','2025-09-02 10:11:53'),(72,14,13,'Jalan Ampang (2 km towards Raffles College KL)',NULL,NULL,'2025-09-02 10:14:13','2025-09-02 10:14:13'),(73,14,13,'Jalan Tuanku Abdul Halim',NULL,NULL,'2025-09-02 10:15:39','2025-09-02 10:15:39'),(74,14,13,'Persiaran Puncak Jalil',NULL,NULL,'2025-09-02 10:16:38','2025-09-02 10:16:38'),(75,14,13,'Lebuhraya Sultan Iskandar (heading City Centre – 6.1km to MITEC)',NULL,NULL,'2025-09-03 01:19:45','2025-09-03 01:19:45'),(76,14,13,'Jalan Dutamas 1 – Near Publika',NULL,NULL,'2025-09-03 01:21:05','2025-09-03 01:21:05'),(77,14,13,'Jalan Loke Yew (heading City Centre – 11 km to MITEC)',NULL,NULL,'2025-09-03 01:22:13','2025-09-03 01:22:13'),(78,14,13,'Jalan Pudu (heading to Kotaraya – 7.4 km to MITEC)',NULL,NULL,'2025-09-03 01:26:08','2025-09-03 01:26:08'),(79,14,13,'Bangsar Kuala Lumpur',NULL,NULL,'2025-09-03 01:41:14','2025-09-03 01:41:14'),(80,14,13,'Jalan Tuanku Abdul Halim (Site 2)',NULL,NULL,'2025-09-03 01:42:18','2025-09-03 01:42:18'),(81,14,13,'Lebuhraya Bukit Jalil (heading to Pavilion Bukit Jalil) – 6.4 km to Pinehill International School',NULL,NULL,'2025-09-03 01:44:01','2025-09-03 01:44:01'),(82,14,13,'Bukit Tunku – Towards PWTC',NULL,NULL,'2025-09-03 01:51:59','2025-09-03 01:51:59'),(83,14,13,'Desa Park City – Jalan 1/62b',NULL,NULL,'2025-09-03 01:53:06','2025-09-03 01:53:06'),(84,14,13,'Lebuhraya Sultan Iskandar KL – Near 	Maxwell School',NULL,NULL,'2025-09-03 01:54:32','2025-09-03 01:54:32'),(85,14,13,'Jalan U Thant 2, KL  (Near Royal Embassy of The Kingdom of Cambodia',NULL,NULL,'2025-09-03 01:55:37','2025-09-03 01:55:37'),(86,14,13,'Jalan Cheras (From Kajang to Stadium Towards Sj Impian)',NULL,NULL,'2025-09-03 01:56:49','2025-09-03 01:56:49'),(87,14,13,'Taman Len Seng',NULL,NULL,'2025-09-03 01:58:04','2025-09-03 01:58:04'),(88,14,13,'Jalan Lingkungan Budi – Towards Mid Valley',NULL,NULL,'2025-09-03 01:59:16','2025-09-03 01:59:16'),(89,14,13,'Persiaran Perusahaan – Before Turning 	right to Sek 19',NULL,NULL,'2025-09-03 02:00:29','2025-09-03 02:00:29'),(90,14,13,'Taman Maluri',NULL,NULL,'2025-09-03 02:01:58','2025-09-03 02:01:58'),(91,14,13,'Towards Rehabilitasi Cheras',NULL,NULL,'2025-09-03 02:02:41','2025-09-03 02:02:41'),(92,14,13,'Bulatan Jalan Kuari',NULL,NULL,'2025-09-03 02:04:02','2025-09-03 02:04:02'),(93,14,13,'Near Sunway Medical Center Velocity',NULL,NULL,'2025-09-03 02:04:54','2025-09-03 02:04:54'),(94,14,13,'Jln Cheras Perdana',NULL,NULL,'2025-09-03 02:06:22','2025-09-03 02:06:22'),(95,14,13,'Lebuh Utama Tun Hussien Onn',NULL,NULL,'2025-09-03 02:07:26','2025-09-03 02:07:26'),(96,14,13,'Jalan Selesaria 1, Sri Petaling',NULL,NULL,'2025-09-03 02:10:42','2025-09-03 02:10:42'),(97,14,13,'Persiaran Alam Damai',NULL,NULL,'2025-09-03 02:11:40','2025-09-03 02:11:40'),(98,14,13,'Towards HUKM Cheras',NULL,NULL,'2025-09-03 02:12:42','2025-09-03 02:12:42'),(99,14,13,'Jln 46/10, Near Mosque',NULL,NULL,'2025-09-03 02:13:35','2025-09-03 02:13:35'),(100,14,13,'Jalan Tun Dr. Ismail, KL',NULL,NULL,'2025-09-03 02:15:35','2025-09-03 02:15:35'),(101,14,13,'Jalan Dutamas 1 – Near Publika (Site 2)District : Kuala Lumpur',NULL,NULL,'2025-09-03 02:17:47','2025-09-03 02:17:47'),(102,14,13,'Jln Genting Klang – (Near Army Camp) Towards Setapak Danau Kota',NULL,NULL,'2025-09-03 02:19:06','2025-09-03 02:19:06'),(103,14,13,'Jalan Kinrara 5A, Bandar Kinrara, Puchong – 19.6 km to MITEC',NULL,NULL,'2025-09-03 02:20:20','2025-09-03 02:20:20'),(104,14,13,'Jalan Pudu',NULL,NULL,'2025-09-03 02:21:44','2025-09-03 02:21:44'),(105,14,13,'Jalan Robson – Towards Mid Valley',NULL,NULL,'2025-09-03 02:22:55','2025-09-03 02:22:55'),(106,14,13,'Jln 46/10, Near Tmn Koperasi Polis',NULL,NULL,'2025-09-03 02:23:58','2025-09-03 02:23:58'),(107,14,13,'Jalan Damansara (next to Jalan Kelantan)',NULL,NULL,'2025-09-03 02:25:03','2025-09-03 02:25:03'),(108,14,13,'Near Petronas Wangsa Melawati @ MRR2 Towards Setapak',NULL,NULL,'2025-09-03 02:26:10','2025-09-03 02:26:10'),(109,14,13,'Jalan Kuching (heading to City Centre)',NULL,NULL,'2025-09-03 02:27:06','2025-09-03 02:27:06'),(110,14,13,'Jalan Loke Yew (turn to Jalan Dewan Bahasa dan Pustaka)',NULL,NULL,'2025-09-03 02:28:14','2025-09-03 02:28:14'),(111,14,13,'Jalan Ampang (opposite Russian Embassy)',NULL,NULL,'2025-09-03 02:29:23','2025-09-03 02:29:23'),(112,14,13,'Taman Connaught',NULL,NULL,'2025-09-03 02:30:45','2025-09-03 02:30:45'),(113,14,13,'Jalan Sultan Salahuddin (towards Lebuhraya Sultan Iskandar)',NULL,NULL,'2025-09-03 02:31:50','2025-09-03 02:31:50'),(114,14,13,'Jalan Pudu (turn into Jalan Galloway)',NULL,NULL,'2025-09-03 02:32:47','2025-09-03 02:32:47'),(115,1,1,'Lebuhraya Damansara-Puchong, Taman Mayang',NULL,NULL,'2025-09-03 07:11:18','2025-09-03 07:11:18'),(116,1,1,'Lebuhraya Damansara-Puchong, Taman Mayang 2',NULL,NULL,'2025-09-03 07:14:11','2025-09-03 07:14:11'),(117,1,1,'Ara Damansara 1',NULL,NULL,'2025-09-03 07:24:18','2025-09-03 07:24:18'),(118,1,1,'Ara Damansara 2',NULL,NULL,'2025-09-03 07:25:41','2025-09-03 07:25:41'),(119,6,1,'MRR2, Batu Caves 1',NULL,NULL,'2025-09-03 07:27:01','2025-09-03 07:27:01'),(120,1,1,'MRR2, Batu Caves 2',NULL,NULL,'2025-09-03 07:28:15','2025-09-03 07:28:15'),(121,3,1,'Lebuhraya Sungai Besi 1',NULL,NULL,'2025-09-03 07:30:20','2025-09-03 07:30:20'),(122,3,1,'Lebuhraya Sungai Besi 2',NULL,NULL,'2025-09-03 07:31:29','2025-09-03 07:31:29'),(123,3,1,'Lebuhraya ELITE 1',NULL,NULL,'2025-09-03 07:32:34','2025-09-03 07:32:34'),(124,3,1,'Lebuhraya ELITE 2',NULL,NULL,'2025-09-03 07:34:27','2025-09-03 07:34:27'),(125,3,1,'Persiaran Puchong Utama 1 – Exit to LDP',NULL,NULL,'2025-09-03 07:35:34','2025-09-03 07:35:34'),(126,3,1,'Persiaran Puchong Utama 2 – From LDP',NULL,NULL,'2025-09-03 07:36:41','2025-09-03 07:36:41'),(127,3,1,'Lebuhraya ELITE – Near BSP  1',NULL,NULL,'2025-09-03 07:57:28','2025-09-03 07:57:28'),(128,3,1,'Lebuhraya ELITE – Near BSP 2',NULL,NULL,'2025-09-03 07:58:35','2025-09-03 07:58:35'),(129,3,1,'NKVE 1 – Towards Sg Buloh',NULL,NULL,'2025-09-03 08:01:04','2025-09-03 08:01:04'),(130,3,1,'NKVE 2 – Towards Sg Buloh',NULL,NULL,'2025-09-03 08:07:30','2025-09-03 08:07:30'),(131,14,13,'LDP – BUKIT LANJAN 1 – Towards PJ',NULL,NULL,'2025-09-03 08:09:26','2025-09-03 08:09:26'),(132,14,13,'Lebuhraya Bukit Jalil 1',NULL,NULL,'2025-09-03 08:11:26','2025-09-03 08:11:26'),(133,14,13,'Lebuhraya Bukit Jalil 2',NULL,NULL,'2025-09-03 08:12:34','2025-09-03 08:12:34'),(134,1,1,'Persiaran Surian 1 - Near Emporis Kota Damansara (From Thomson Medical Centre)',NULL,NULL,'2025-09-03 08:21:30','2025-09-03 08:21:30'),(135,1,1,'Persiaran Surian 2 - Near Emporis Kota Damansara (From Sungai Buloh)',NULL,NULL,'2025-09-03 08:23:40','2025-09-03 08:23:40'),(136,1,1,'Persiaran Surian 3 - Near Emporis Kota 	Damansara (From Uptown Damansara)',NULL,NULL,'2025-09-03 08:25:05','2025-09-03 08:25:05');
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2016_06_01_000001_create_oauth_auth_codes_table',1),(2,'2016_06_01_000002_create_oauth_access_tokens_table',1),(3,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(4,'2016_06_01_000004_create_oauth_clients_table',1),(5,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(6,'2019_12_14_000001_create_personal_access_tokens_table',1),(7,'2023_11_06_062133_create_projects',1),(8,'2023_11_16_100218_add_type_to_users_table',1),(9,'2025_07_22_000000_create_users_table',1),(10,'2025_07_22_000001_create_password_reset_tokens_table',1),(11,'2025_07_22_000002_create_password_resets_table',1),(12,'2025_07_22_000003_create_failed_jobs_table',1),(13,'2025_07_22_000004_create_personal_access_tokens_table',1),(14,'2025_07_22_000005_create_client_company',1),(15,'2025_07_22_000005_create_locations',1),(16,'2025_07_22_000006_create_billboards',1),(17,'2025_07_22_000007_create_permission_tables',1),(18,'2025_07_22_000008_add_last_login_at_to_users_table',1),(19,'2025_07_22_000009_create_push_notification_table',1),(20,'2025_07_22_000010_create_notifications_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3),(4,'App\\Models\\User',4);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_ongoing_jobs`
--

DROP TABLE IF EXISTS `monthly_ongoing_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monthly_ongoing_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `month` tinyint(3) unsigned NOT NULL,
  `year` year(4) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `monthly_ongoing_jobs_booking_id_foreign` (`booking_id`),
  CONSTRAINT `monthly_ongoing_jobs_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `billboard_bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_ongoing_jobs`
--

LOCK TABLES `monthly_ongoing_jobs` WRITE;
/*!40000 ALTER TABLE `monthly_ongoing_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthly_ongoing_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_history`
--

DROP TABLE IF EXISTS `notification_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notification_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notification_content` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_history`
--

LOCK TABLES `notification_history` WRITE;
/*!40000 ALTER TABLE `notification_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
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
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'dashboard.view','web','dashboard','2025-09-02 01:40:22','2025-09-02 01:40:22'),(2,'dashboard.edit','web','dashboard','2025-09-02 01:40:22','2025-09-02 01:40:22'),(3,'user.create','web','user','2025-09-02 01:40:22','2025-09-02 01:40:22'),(4,'user.view','web','user','2025-09-02 01:40:22','2025-09-02 01:40:22'),(5,'user.edit','web','user','2025-09-02 01:40:22','2025-09-02 01:40:22'),(6,'user.delete','web','user','2025-09-02 01:40:22','2025-09-02 01:40:22'),(7,'role.create','web','role','2025-09-02 01:40:22','2025-09-02 01:40:22'),(8,'role.view','web','role','2025-09-02 01:40:22','2025-09-02 01:40:22'),(9,'role.edit','web','role','2025-09-02 01:40:22','2025-09-02 01:40:22'),(10,'role.delete','web','role','2025-09-02 01:40:22','2025-09-02 01:40:22'),(11,'profile.view','web','profile','2025-09-02 01:40:22','2025-09-02 01:40:22'),(12,'profile.edit','web','profile','2025-09-02 01:40:22','2025-09-02 01:40:22'),(13,'client.create','web','client','2025-09-02 01:40:22','2025-09-02 01:40:22'),(14,'client.view','web','client','2025-09-02 01:40:22','2025-09-02 01:40:22'),(15,'client.edit','web','client','2025-09-02 01:40:22','2025-09-02 01:40:22'),(16,'client.delete','web','client','2025-09-02 01:40:22','2025-09-02 01:40:22'),(17,'client_company.create','web','client_company','2025-09-02 01:40:22','2025-09-02 01:40:22'),(18,'client_company.view','web','client_company','2025-09-02 01:40:22','2025-09-02 01:40:22'),(19,'client_company.edit','web','client_company','2025-09-02 01:40:22','2025-09-02 01:40:22'),(20,'client_company.delete','web','client_company','2025-09-02 01:40:22','2025-09-02 01:40:22'),(21,'billboard.create','web','billboard','2025-09-02 01:40:22','2025-09-02 01:40:22'),(22,'billboard.view','web','billboard','2025-09-02 01:40:23','2025-09-02 01:40:23'),(23,'billboard.edit','web','billboard','2025-09-02 01:40:23','2025-09-02 01:40:23'),(24,'billboard.delete','web','billboard','2025-09-02 01:40:23','2025-09-02 01:40:23'),(25,'billboard_booking.create','web','billboard_booking','2025-09-02 01:40:23','2025-09-02 01:40:23'),(26,'billboard_booking.view','web','billboard_booking','2025-09-02 01:40:23','2025-09-02 01:40:23'),(27,'billboard_booking.edit','web','billboard_booking','2025-09-02 01:40:23','2025-09-02 01:40:23'),(28,'billboard_booking.delete','web','billboard_booking','2025-09-02 01:40:23','2025-09-02 01:40:23');
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
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
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
-- Table structure for table `push_notification`
--

DROP TABLE IF EXISTS `push_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `push_notification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `push_notification`
--

LOCK TABLES `push_notification` WRITE;
/*!40000 ALTER TABLE `push_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `push_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(1,2),(1,3),(1,4),(2,1),(2,2),(2,3),(2,4),(3,1),(4,1),(4,3),(5,1),(5,3),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(11,2),(11,3),(11,4),(12,1),(12,2),(12,3),(12,4),(13,1),(14,1),(14,2),(14,3),(15,1),(15,2),(16,1),(17,1),(18,1),(18,2),(19,1),(19,2),(20,1),(21,1),(21,3),(22,1),(22,3),(22,4),(23,1),(23,3),(23,4),(24,1),(24,3),(25,1),(25,2),(25,3),(26,1),(26,2),(26,3),(26,4),(27,1),(27,2),(27,3),(27,4),(28,1),(28,2),(28,3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin','web','2025-09-02 01:40:22','2025-09-02 01:40:22'),(2,'admin','web','2025-09-02 01:40:23','2025-09-02 01:40:23'),(3,'sales','web','2025-09-02 01:40:23','2025-09-02 01:40:23'),(4,'marketing','web','2025-09-02 01:40:23','2025-09-02 01:40:23');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `states` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `states_prefix_unique` (`prefix`),
  UNIQUE KEY `states_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'SEL','Selangor','2025-09-02 01:40:23','2025-09-02 01:40:23'),(2,'KUL','Kuala Lumpur','2025-09-02 01:40:24','2025-09-02 01:40:24'),(3,'PJA','Putrajaya','2025-09-02 01:40:24','2025-09-02 01:40:24'),(4,'LAB','Labuan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(5,'JOH','Johor','2025-09-02 01:40:24','2025-09-02 01:40:24'),(6,'PNG','Pulau Pinang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(7,'PRK','Perak','2025-09-02 01:40:24','2025-09-02 01:40:24'),(8,'PHG','Pahang','2025-09-02 01:40:24','2025-09-02 01:40:24'),(9,'KDH','Kedah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(10,'KTN','Kelantan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(11,'TRG','Terengganu','2025-09-02 01:40:24','2025-09-02 01:40:24'),(12,'MLK','Melaka','2025-09-02 01:40:24','2025-09-02 01:40:24'),(13,'NSN','Negeri Sembilan','2025-09-02 01:40:24','2025-09-02 01:40:24'),(14,'PLS','Perlis','2025-09-02 01:40:24','2025-09-02 01:40:24'),(15,'SBH','Sabah','2025-09-02 01:40:24','2025-09-02 01:40:24'),(16,'SWK','Sarawak','2025-09-02 01:40:24','2025-09-02 01:40:24');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_inventories`
--

DROP TABLE IF EXISTS `stock_inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_inventories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `contractor_id` bigint(20) unsigned NOT NULL,
  `balance_contractor` int(10) unsigned NOT NULL DEFAULT 0,
  `balance_bgoc` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_inventories_contractor_id_foreign` (`contractor_id`),
  CONSTRAINT `stock_inventories_contractor_id_foreign` FOREIGN KEY (`contractor_id`) REFERENCES `contractors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_inventories`
--

LOCK TABLES `stock_inventories` WRITE;
/*!40000 ALTER TABLE `stock_inventories` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_inventory_transactions`
--

DROP TABLE IF EXISTS `stock_inventory_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_inventory_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `stock_inventory_id` bigint(20) unsigned NOT NULL,
  `billboard_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `from_contractor_id` bigint(20) unsigned DEFAULT NULL,
  `to_contractor_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 0,
  `transaction_date` datetime NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_inventory_transactions_stock_inventory_id_foreign` (`stock_inventory_id`),
  KEY `stock_inventory_transactions_billboard_id_foreign` (`billboard_id`),
  KEY `stock_inventory_transactions_client_id_foreign` (`client_id`),
  KEY `stock_inventory_transactions_from_contractor_id_foreign` (`from_contractor_id`),
  KEY `stock_inventory_transactions_to_contractor_id_foreign` (`to_contractor_id`),
  KEY `stock_inventory_transactions_created_by_foreign` (`created_by`),
  CONSTRAINT `stock_inventory_transactions_billboard_id_foreign` FOREIGN KEY (`billboard_id`) REFERENCES `billboards` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_inventory_transactions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `client_companies` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_inventory_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_inventory_transactions_from_contractor_id_foreign` FOREIGN KEY (`from_contractor_id`) REFERENCES `contractors` (`id`) ON DELETE SET NULL,
  CONSTRAINT `stock_inventory_transactions_stock_inventory_id_foreign` FOREIGN KEY (`stock_inventory_id`) REFERENCES `stock_inventories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_inventory_transactions_to_contractor_id_foreign` FOREIGN KEY (`to_contractor_id`) REFERENCES `contractors` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_inventory_transactions`
--

LOCK TABLES `stock_inventory_transactions` WRITE;
/*!40000 ALTER TABLE `stock_inventory_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_inventory_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','superadmin@bluedale.com.my','superadmin',NULL,1,NULL,'$2y$12$RL9trLgVNOYzqSvZo7pnseNhy1kddtAoOp.BXlo2j9n5ZY3Zfh6pW',NULL,'2025-09-02 01:40:22','2025-09-03 07:00:21','2025-09-03 07:00:21'),(2,'Admin','admin@bluedale.com.my','admin',NULL,1,NULL,'$2y$12$ACFhU/QM/dIaZiDaStp4uOzOB8J3d4CB8/ArIvvPB8/.bkXRwubXS',NULL,'2025-09-02 01:40:22','2025-09-02 01:40:22',NULL),(3,'Sales','sales@bluedale.com.my','sales',NULL,1,NULL,'$2y$12$9L8k/JQxdJsZDN/aUYEHXOyZdEVceSI9cjTTA6PpEyq1PMZvyN7Gu',NULL,'2025-09-02 01:40:22','2025-09-02 01:40:22',NULL),(4,'Marketing','marketing@bluedale.com.my','marketing',NULL,1,NULL,'$2y$12$5yfy5.0S6JuX3e95JttdN.sY7Jb7NsAoc7QO4nGBQa4jOk.frC.hW',NULL,'2025-09-02 01:40:24','2025-09-02 01:40:24',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'bgoc_outdoor_system'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-14 21:10:26
