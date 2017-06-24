-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: hoa
-- ------------------------------------------------------
-- Server version	5.7.18-log

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
-- Dumping data for table `collection`
--

LOCK TABLES `collection` WRITE;
/*!40000 ALTER TABLE `collection` DISABLE KEYS */;
INSERT INTO `collection` VALUES (1,'CARSTICKER',27,'HOMEOWNER','1','2017-06-19',NULL,NULL,NULL,12500.44,'\0','\0','hi','2017-06-19 05:12:03',NULL,'2017-06-18 21:12:03','2017-06-18 21:12:03'),(2,'MONTHLYDUES',32,'OUTSIDE','2','2017-06-20',NULL,NULL,NULL,109.00,'\0','',NULL,'2017-06-20 15:20:54',NULL,'2017-06-20 07:20:54','2017-06-20 07:20:54'),(12,'SAMPLE',27,'HOMEOWNER','3','2017-06-20',NULL,NULL,NULL,159.00,'','\0',NULL,'2017-06-20 15:26:56',NULL,'2017-06-20 07:26:56','2017-06-20 07:26:56'),(13,'SAMPLE',28,'HOMEOWNER','4','2017-06-20',NULL,NULL,NULL,100.00,'','',NULL,'2017-06-20 20:02:20',NULL,'2017-06-20 12:02:20','2017-06-20 12:02:20'),(16,'SAMPLE',28,'HOMEOWNER','4','2017-06-20',NULL,NULL,NULL,100.00,'','\0',NULL,'2017-06-20 20:08:24',NULL,'2017-06-20 12:08:24','2017-06-20 12:08:24'),(17,'MONTHLYDUES',32,'OUTSIDE','5','2017-06-20',NULL,NULL,NULL,1000.00,'','\0',NULL,'2017-06-20 20:28:51',NULL,'2017-06-20 12:28:51','2017-06-20 12:28:51'),(18,'MONTHLYDUES',41,'HOMEOWNER','6','2017-06-21',NULL,NULL,NULL,1500.75,'','\0','This monthyl dues','2017-06-21 18:27:42',NULL,'2017-06-21 10:27:42','2017-06-21 10:27:42'),(19,'MONTHLYDUES',41,'HOMEOWNER','7','2017-06-22',NULL,NULL,NULL,50.00,'','\0','This for monthly dues','2017-06-22 04:04:14',NULL,'2017-06-21 20:04:14','2017-06-21 20:04:14'),(20,'MONTHLYDUES',41,'HOMEOWNER','7','2017-06-22',NULL,NULL,NULL,50.00,'','','This for monthly dues','2017-06-22 04:04:14',NULL,'2017-06-21 20:04:14','2017-06-21 20:04:14'),(21,'MONTHLYDUES',41,'HOMEOWNER','8','2017-06-22',NULL,NULL,NULL,60.00,'','\0','This for may','2017-06-22 04:05:44',NULL,'2017-06-21 20:05:44','2017-06-21 20:05:44'),(22,'CARSTICKER',41,'HOMEOWNER','9','2017-06-22',NULL,NULL,NULL,40.00,'','\0','Car sticker','2017-06-22 04:12:50',NULL,'2017-06-21 20:12:50','2017-06-21 20:12:50'),(23,'MONTHLYDUES',41,'HOMEOWNER','10','2017-06-22',NULL,NULL,NULL,10.00,'','\0','This for desc','2017-06-22 04:15:12',NULL,'2017-06-21 20:15:12','2017-06-21 20:15:12'),(24,'CARSTICKER',41,'HOMEOWNER','12','2017-06-22',NULL,NULL,NULL,10.00,'','\0',NULL,'2017-06-22 04:44:02',NULL,'2017-06-21 20:44:02','2017-06-21 20:44:02'),(25,'SAMPLE',27,'HOMEOWNER','11','2017-07-01',NULL,NULL,NULL,100.00,'','\0',NULL,'2017-06-24 10:19:56',NULL,'2017-06-24 02:19:56','2017-06-24 02:19:56'),(26,'SAMPLE',27,'HOMEOWNER','13','2017-08-01',NULL,NULL,NULL,50.00,'','\0',NULL,'2017-06-24 10:20:36',NULL,'2017-06-24 02:20:36','2017-06-24 02:20:36');
/*!40000 ALTER TABLE `collection` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-24 15:48:08