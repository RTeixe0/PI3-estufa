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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2024-06-08 17:42:28','$2y$12$ymMgSi.9/xYdmqhXS3Ydz.hMSo009edWS.879DmEjZCGFf5gTtKyu','2oJmRuvWDq','2024-06-08 17:42:28','2024-06-08 17:42:28'),(3,'Eric Cesar Da Silva Junior','eric.faria2003@gmail.com',NULL,'$2y$12$ayGMsfyYgMxtNpUd7S8AMeZEvUHq/RHCH4jn02TYo08hfOeixPfc2',NULL,'2024-06-10 00:34:43','2024-06-10 00:34:43'),(4,'Brayan','brayan.faria2008@gmail.com',NULL,'$2y$12$.kXKVlD6nVnr0RAwUfVp5ev/kJzet/XAxyEYVTeKtIhCycHCOaAvK',NULL,'2024-06-10 05:29:34','2024-06-10 05:29:34'),(5,'teste12','teste@teste.com',NULL,'$2y$12$Rz4gWl8PIVCrveshN28Pv.TK8btWQorGlpjYpFbI5zkF0MyZ9oghi',NULL,'2024-06-11 08:55:11','2024-06-11 08:55:11'),(6,'rafael','rafael@hotmail.com',NULL,'$2y$12$I3ESQu6wTwpAiCYbxvZY0OlbPyVz1oC4LCUr1YILQv1CTCTNeZXuu',NULL,'2024-06-12 03:43:17','2024-06-12 03:43:17'),(9,'Júnior Gonçalves','junior@ig.com.br',NULL,'$2y$12$klVM9E0hTGTTbdTODI6L3eRZn1aqgdLEwcSYH5tWBf1KFoyJeQKPK',NULL,'2024-06-19 01:22:04','2024-06-19 01:22:04'),(10,'Joaquim Firmino','joaquimfirmino@ig.com.br',NULL,'$2y$12$Ezy.x1mRBsNdfd1Q8uE84u/uJK0w5zuEN8nKEXy862yG8S1YvW262',NULL,'2024-06-19 01:28:10','2024-06-19 01:28:10'),(11,'ze','ze@gmail.com.br',NULL,'$2y$12$f1FFhB3sq2rdpHLnttoAMetjKpYmG4gV/8N1d13SU5IZY/FkCNBPO',NULL,'2024-06-19 02:22:41','2024-06-19 02:22:41');
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

-- Dump completed on 2024-06-21  0:14:46
