-- MySQL dump 10.13  Distrib 8.0.21, for Win64 (x86_64)
--
-- Host: localhost    Database: sg
-- ------------------------------------------------------
-- Server version	8.0.21

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `comment` text NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,3,'Este é um comentário teste.','approved','2024-06-13 08:29:32','2024-06-13 08:29:32'),(2,4,'Outro comentário para teste.','approved','2024-06-13 08:29:32','2024-06-13 08:29:34'),(3,3,'Mais um comentário de teste.','rejected','2024-06-13 08:29:32','2024-06-13 08:29:32'),(4,9,'Parabéns!!! Seu site está muito legal!!!','approved','2024-06-19 01:29:40','2024-06-19 01:29:40'),(5,10,'Gostei muito do seu site','rejected','2024-06-19 01:29:40','2024-06-19 01:29:45'),(6,9,'Parabéns!!! Seu site está muito legal!!!','rejected','2024-06-19 01:29:59','2024-06-19 01:30:03'),(7,10,'Gostei muito do seu site','rejected','2024-06-19 01:29:59','2024-06-19 01:30:04'),(8,11,'Testando com junior','approved','2024-06-19 02:22:56','2024-06-19 02:24:43'),(9,9,'Parabéns!!! Seu site está muito legal!!!','rejected','2024-06-19 02:25:02','2024-06-19 02:25:08'),(10,10,'Gostei muito do seu site','approved','2024-06-19 02:25:02','2024-06-19 02:25:12'),(11,3,'Dosadkosadksadsa','rejected','2024-06-20 06:23:35','2024-06-20 06:24:07'),(12,3,'Este é um comentário teste.','approved','2024-06-20 06:24:21','2024-06-20 06:24:21'),(13,4,'Outro comentário para teste.','approved','2024-06-20 06:24:21','2024-06-20 06:24:21'),(14,3,'Mais um comentário de teste.','rejected','2024-06-20 06:24:21','2024-06-20 06:24:21'),(15,9,'Parabéns!!! Seu site está muito legal!!!','approved','2024-06-20 06:24:21','2024-06-20 06:24:21'),(16,10,'Gostei muito do seu site','rejected','2024-06-20 06:24:21','2024-06-20 06:24:21'),(17,9,'Parabéns!!! Seu site está muito legal!!!','rejected','2024-06-20 06:24:21','2024-06-20 06:24:21'),(18,10,'Gostei muito do seu site','rejected','2024-06-20 06:24:21','2024-06-20 06:24:21'),(19,11,'Testando com junior','approved','2024-06-20 06:24:21','2024-06-20 06:24:21'),(20,9,'Parabéns!!! Seu site está muito legal!!!','rejected','2024-06-20 06:24:21','2024-06-20 06:24:21'),(21,10,'Gostei muito do seu site','approved','2024-06-20 06:24:21','2024-06-20 06:24:21');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-21  0:14:46
