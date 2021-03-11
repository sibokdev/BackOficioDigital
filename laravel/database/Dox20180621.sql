-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: aa1jbwqdxhd38yy.cyvblk9724yo.us-west-2.rds.amazonaws.com    Database: ebdb
-- ------------------------------------------------------
-- Server version	5.6.27-log

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
-- Table structure for table `audits`
--

DROP TABLE IF EXISTS `audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `paid` tinyint(4) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audits`
--

LOCK TABLES `audits` WRITE;
/*!40000 ALTER TABLE `audits` DISABLE KEYS */;
INSERT INTO `audits` VALUES (1,197,'2018-06-22 16:00:00',2,'',1,'2018-06-21 01:29:02','2018-06-21 01:35:32'),(2,197,'2018-06-30 16:50:00',0,'ahi le caugo',0,'2018-06-21 01:50:40','2018-06-21 01:50:40');
/*!40000 ALTER TABLE `audits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audits_has_documents`
--

DROP TABLE IF EXISTS `audits_has_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audits_has_documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `audit_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audits_has_documents`
--

LOCK TABLES `audits_has_documents` WRITE;
/*!40000 ALTER TABLE `audits_has_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `audits_has_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards2openpay`
--

DROP TABLE IF EXISTS `cards2openpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards2openpay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `number` varchar(4) NOT NULL,
  `expiration_month` varchar(2) NOT NULL,
  `expiration_year` varchar(2) NOT NULL,
  `token` varchar(25) NOT NULL,
  `id_api_card` varchar(255) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `main` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `device_session_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards2openpay`
--

LOCK TABLES `cards2openpay` WRITE;
/*!40000 ALTER TABLE `cards2openpay` DISABLE KEYS */;
INSERT INTO `cards2openpay` VALUES (1,'Roberto Avalos Sánchez','2424','01','21','knvfpphrt5gxjagnx9dh','knvfpphrt5gxjagnx9dh',197,'2018-06-20 21:56:25','2018-06-20 21:56:25',1,1,'texto prueba');
/*!40000 ALTER TABLE `cards2openpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clarifications`
--

DROP TABLE IF EXISTS `clarifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clarifications` (
  `folio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `clarification_type` int(11) NOT NULL,
  `content` text NOT NULL,
  `solution_type` int(11) DEFAULT NULL,
  `description_solution` text,
  `status` int(11) NOT NULL COMMENT '1:pendiente 2:aclarado 3:cancelado',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`folio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clarifications`
--

LOCK TABLES `clarifications` WRITE;
/*!40000 ALTER TABLE `clarifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `clarifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_service_cost`
--

DROP TABLE IF EXISTS `custom_service_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_service_cost` (
  `unique_service_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `cost_type` int(11) DEFAULT NULL COMMENT '1:annual quote , 2:reception_cost , 3:delibery_cost.',
  `cost` float DEFAULT NULL,
  `begin_promotion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_promotion` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`unique_service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_service_cost`
--

LOCK TABLES `custom_service_cost` WRITE;
/*!40000 ALTER TABLE `custom_service_cost` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_service_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expedition` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `expiration` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `picture_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) DEFAULT '1',
  `id_user` int(11) unsigned NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `folio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_document_users1_idx` (`id_user`),
  CONSTRAINT `fk_document_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,'Comida','','','','esta es una nota','2018-06-20 19:11:49','2018-06-20 22:55:36',0,197,'Cliente','Factura','Automóvil','5'),(2,'Fhch','2018-06-20 00:00:00','','file-document-197-1529533142-1529533107jpg.jpg','Ninguna','2018-06-20 22:19:02','2018-06-20 22:55:27',0,197,'Cliente','Factura','Automóvil',NULL),(3,'Fed','2018-06-20 00:00:00','','','Ninguna','2018-06-20 22:29:36','2018-06-20 22:55:32',0,197,'Cliente','Factura','Automóvil',NULL),(4,'Mi Casa','2018-06-13 00:00:00','','','ninguna','2018-06-20 23:40:20','2018-06-20 23:40:20',0,197,'Cliente','Escritura','Servicios',NULL),(5,'Kia','2018-06-20 00:00:00','','','Ninguna','2018-06-20 23:59:10','2018-06-20 23:59:10',0,197,'Cliente','Factura','Automóvil',NULL),(6,'Comidas','2018-06-20 00:00:00','','','Ninguna','2018-06-21 00:00:55','2018-06-21 00:00:55',0,197,'Cliente','Factura','Otro',NULL),(7,'Jff','2018-06-20 00:00:00','','','Ninguna','2018-06-21 00:01:43','2018-06-21 00:01:43',0,197,'Cliente','Factura','Automóvil',NULL),(8,'Kgkgkg','2018-06-20 00:00:00','','','Ninguna','2018-06-21 00:40:21','2018-06-21 00:40:21',0,197,'Cliente','Factura','Automóvil',NULL),(9,'Foto Prueba Dos','2018-06-20 00:00:00','','','Hhh','2018-06-21 00:42:33','2018-06-21 00:42:33',0,197,'Cliente','Factura','Automóvil',NULL),(10,'Quinta','2018-06-20 00:00:00','','file-document-197-1529542414-1529542394jpg.jpg','Ninguna','2018-06-21 00:53:34','2018-06-21 00:53:34',0,197,'Cliente','Factura','Automóvil',NULL),(11,'Hghchgfthhh','2018-06-20 00:00:00','','file-document-197-1529542463-1529542452jpg.jpg','Ninguna','2018-06-21 00:54:23','2018-06-21 00:54:23',0,197,'Cliente','Factura','Automóvil',NULL),(12,'Mi Casa 2','2018-06-20 00:00:00','2018-06-29 00:00:00.000-05:00','file-document-197-1529542610-1529542590jpg.jpg','ninguna','2018-06-21 00:56:50','2018-06-21 01:25:12',0,197,'Cliente','Factura','Factura',NULL),(13,'Campestre comala','2018-06-20 00:00:00','2018-06-30 00:00:00.000-05:00','file-document-197-1529543111-1529543099jpg.jpg','Ninguna','2018-06-21 01:05:11','2018-06-21 01:25:16',0,197,'Cliente','Factura','Factura',NULL),(14,'Mi Casa','2018-06-30 00:00:00','','file-document-197-1529544469-1529544458jpg.jpg','Ninguna','2018-06-21 01:27:49','2018-06-21 01:30:08',0,197,'Cliente','Escritura','Servicios',NULL),(15,'Hgjj','2018-06-20 00:00:00','','file-document-197-1529545549-1529545522jpg.jpg','Ninguna','2018-06-21 01:45:49','2018-06-21 01:45:49',0,197,'Cliente','Factura','Automóvil',NULL),(16,'Hghhh','2018-06-20 00:00:00','','','Ninguna','2018-06-21 01:47:52','2018-06-21 01:47:52',0,197,'Cliente','Factura','Automóvil',NULL),(17,'Mi Casa norte','2018-06-20 00:00:00','2018-06-30 00:00:00','file-document-197-1529546971-1529546959jpg.jpg','Ninguna','2018-06-21 02:09:31','2018-06-21 02:44:26',0,197,'Cliente','Factura','Factura',NULL),(18,'Cartilla','2018-06-29 00:00:00','2018-11-30 00:00:00','','Ninguna','2018-06-21 02:10:58','2018-06-21 02:11:04',0,197,'Cliente','Otro','Cartilla',NULL),(19,'Kia','2018-06-20 00:00:00','2018-10-31 00:00:00','file-document-197-1529547092-1529547082jpg.jpg','Ninguna','2018-06-21 02:11:32','2018-06-21 02:44:22',0,197,'Cliente','Factura','Automóvil',NULL),(20,'Leon','2018-06-20 00:00:00','2018-06-22 00:00:00','file-document-197-1529549119-1529549091jpg.jpg','Seat Leon Cupra','2018-06-21 02:45:19','2018-06-21 04:20:47',1,197,'Cliente','Factura','Automóvil','9');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents_inout`
--

DROP TABLE IF EXISTS `documents_inout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_inout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `folio` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents_inout`
--

LOCK TABLES `documents_inout` WRITE;
/*!40000 ALTER TABLE `documents_inout` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents_inout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents_movements`
--

DROP TABLE IF EXISTS `documents_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents_movements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `document_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `new_location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents_movements`
--

LOCK TABLES `documents_movements` WRITE;
/*!40000 ALTER TABLE `documents_movements` DISABLE KEYS */;
INSERT INTO `documents_movements` VALUES (1,'2018-06-20 21:35:59','2018-06-20 21:35:59',1,'2018-06-21 16:25:00','Cliente'),(2,'2018-06-20 21:58:09','2018-06-20 21:58:09',1,'2018-06-20 16:56:00','Cliente'),(3,'2018-06-21 04:21:50','2018-06-21 04:21:50',20,'2018-06-21 12:02:00','Cliente');
/*!40000 ALTER TABLE `documents_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) CHARACTER SET utf8 NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_04_24_110151_create_oauth_scopes_table',1),('2014_04_24_110304_create_oauth_grants_table',1),('2014_04_24_110403_create_oauth_grant_scopes_table',1),('2014_04_24_110459_create_oauth_clients_table',1),('2014_04_24_110557_create_oauth_client_endpoints_table',1),('2014_04_24_110705_create_oauth_client_scopes_table',1),('2014_04_24_110817_create_oauth_client_grants_table',1),('2014_04_24_111002_create_oauth_sessions_table',1),('2014_04_24_111109_create_oauth_session_scopes_table',1),('2014_04_24_111254_create_oauth_auth_codes_table',1),('2014_04_24_111403_create_oauth_auth_code_scopes_table',1),('2014_04_24_111518_create_oauth_access_tokens_table',1),('2014_04_24_111657_create_oauth_access_token_scopes_table',1),('2014_04_24_111810_create_oauth_refresh_tokens_table',1),('2016_11_24_175052_drop_types_table',2),('2016_11_24_175103_drop_subtypes_table',2),('2016_11_24_175347_rename_documents_table',2),('2016_11_24_180532_update_add_drop_columns_documents_movtos_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_token_scopes`
--

DROP TABLE IF EXISTS `oauth_access_token_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_token_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_access_token_scopes_access_token_id_index` (`access_token_id`),
  KEY `oauth_access_token_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_access_token_scopes_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_access_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_token_scopes`
--

LOCK TABLES `oauth_access_token_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_access_token_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_token_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_access_tokens_id_session_id_unique` (`id`,`session_id`),
  KEY `oauth_access_tokens_session_id_index` (`session_id`),
  CONSTRAINT `oauth_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('Atc5nBpU08tGWd0SyaQ5Zmlt78j5oGGYRftoAM8d',178,1492036936,'2017-03-13 22:42:16','2017-03-13 22:42:16'),('GRb5e92JzcRvt0Eq5VExiFe194mOFctqN82zdYo1',179,1492038627,'2017-03-13 23:10:27','2017-03-13 23:10:27'),('Gxr4TCTkiy3uy1ZJblbQaegmBAob1k5VZnMLFf2t',200,1493492559,'2017-03-30 19:02:39','2017-03-30 19:02:39'),('GZMpXkvJEDoHNBCyyZpy13p4N2fdzrAvaG5JPF0u',227,1532134817,'2018-06-21 01:00:17','2018-06-21 01:00:17'),('kMASVLpY3tc91Xx1U5SluLPiL1qmusRqvR14XMdn',201,1493493171,'2017-03-30 19:12:51','2017-03-30 19:12:51'),('n1wyt5zc4lMhrXIkhAM0Vji7lgImaeL78iBEPMoQ',208,1493828486,'2018-06-20 16:21:26','2018-06-20 16:21:26'),('oWTjGewxetQ81x2SBruxbjZOanKN5YenK9p96S9m',181,1492041508,'2017-03-13 23:58:28','2017-03-13 23:58:28'),('sSujNLGcxECiIEFMglPYosfDC1rh3atPHhMhPe56',195,1493423896,'2017-03-29 23:58:16','2017-03-29 23:58:16'),('SYWzY99nrjODvWfPaIhD8nAIiw0306VgKaQ2bao6',212,1494020371,'2017-04-05 21:39:31','2017-04-05 21:39:31'),('TGmdOYtSqsmDrMCXw3HUy43yQkexosW9kfM22MsB',187,1492376260,'2017-03-17 20:57:40','2017-03-17 20:57:40'),('W7LviFDt0vqe7itwtIqOUTsTbeRxDnm5nVqECwy0',196,1493450122,'2017-03-30 07:15:22','2017-03-30 07:15:22'),('Xy0slJCJjZgppqOPv9JQw4IOSTePsH33dMr6SDzO',184,1492210473,'2017-03-15 22:54:33','2017-03-15 22:54:33'),('YQFvB5Oztqyw44UD5WYtF4QomdVYZyvbB8DTvjFX',218,1494611154,'2017-04-12 17:45:54','2017-04-12 17:45:54'),('YWW6Gb8xYD6vXCtn5AyYUUDUndp3FLmnZdSNYg64',228,1532136407,'2018-06-21 01:26:47','2018-06-21 01:26:47'),('zbKr3u1wRh9f249rYoSr0kPXjkBCngtWBbjck5LL',186,1492217370,'2017-03-16 00:49:30','2017-03-16 00:49:30');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_code_scopes`
--

DROP TABLE IF EXISTS `oauth_auth_code_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_code_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_code_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_auth_code_scopes_auth_code_id_index` (`auth_code_id`),
  KEY `oauth_auth_code_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_auth_code_scopes_auth_code_id_foreign` FOREIGN KEY (`auth_code_id`) REFERENCES `oauth_auth_codes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_auth_code_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_code_scopes`
--

LOCK TABLES `oauth_auth_code_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_code_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_code_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_session_id_index` (`session_id`),
  CONSTRAINT `oauth_auth_codes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_endpoints`
--

DROP TABLE IF EXISTS `oauth_client_endpoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_endpoints` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_client_endpoints_client_id_redirect_uri_unique` (`client_id`,`redirect_uri`),
  CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_endpoints`
--

LOCK TABLES `oauth_client_endpoints` WRITE;
/*!40000 ALTER TABLE `oauth_client_endpoints` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_endpoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_grants`
--

DROP TABLE IF EXISTS `oauth_client_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_grants_client_id_index` (`client_id`),
  KEY `oauth_client_grants_grant_id_index` (`grant_id`),
  CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_grants`
--

LOCK TABLES `oauth_client_grants` WRITE;
/*!40000 ALTER TABLE `oauth_client_grants` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_client_scopes`
--

DROP TABLE IF EXISTS `oauth_client_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_client_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_scopes_client_id_index` (`client_id`),
  KEY `oauth_client_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_client_scopes`
--

LOCK TABLES `oauth_client_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_client_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_client_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_clients_id_secret_unique` (`id`,`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES ('g3b259fde3ed5ff3843839b','3d7f5f8f793d29c25502c0ae8c4a95b','Website','2016-11-15 22:18:13','2016-11-15 22:18:13'),('g3b259fde3ed7ff3843839b','3d7f5f8f793d59c25502c0ae8c4a95b','iOS','2016-11-15 22:18:13','2016-11-15 22:18:13'),('g3b259fde3ed9ff3843839b','3d7f5f8f793d59c25502c0ae8c4a95b','Android','2016-11-15 22:18:13','2016-11-15 22:18:13');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_grant_scopes`
--

DROP TABLE IF EXISTS `oauth_grant_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_grant_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_grant_scopes_grant_id_index` (`grant_id`),
  KEY `oauth_grant_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_grant_scopes`
--

LOCK TABLES `oauth_grant_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_grant_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_grant_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_grants`
--

DROP TABLE IF EXISTS `oauth_grants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_grants` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_grants`
--

LOCK TABLES `oauth_grants` WRITE;
/*!40000 ALTER TABLE `oauth_grants` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_grants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`access_token_id`),
  UNIQUE KEY `oauth_refresh_tokens_id_unique` (`id`),
  CONSTRAINT `oauth_refresh_tokens_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_refresh_tokens` VALUES ('GOyVbcoh9NhsZx1bD1UNteSx0nCSuMPt8ZbF6fg5','GZMpXkvJEDoHNBCyyZpy13p4N2fdzrAvaG5JPF0u',1532134817,'2018-06-21 01:00:17','2018-06-21 01:00:17'),('RVEqgsMnXKxUxpgTyOjG1xwsAKVUko6JtlaHgJwG','YWW6Gb8xYD6vXCtn5AyYUUDUndp3FLmnZdSNYg64',1532136407,'2018-06-21 01:26:47','2018-06-21 01:26:47');
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_scopes`
--

DROP TABLE IF EXISTS `oauth_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_scopes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_scopes`
--

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_session_scopes`
--

DROP TABLE IF EXISTS `oauth_session_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_session_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_session_scopes_session_id_index` (`session_id`),
  KEY `oauth_session_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_session_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_session_scopes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_session_scopes`
--

LOCK TABLES `oauth_session_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_session_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_session_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_sessions`
--

DROP TABLE IF EXISTS `oauth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` enum('client','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_redirect_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`,`owner_type`,`owner_id`),
  CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_sessions`
--

LOCK TABLES `oauth_sessions` WRITE;
/*!40000 ALTER TABLE `oauth_sessions` DISABLE KEYS */;
INSERT INTO `oauth_sessions` VALUES (178,'g3b259fde3ed9ff3843839b','user','154',NULL,'2017-03-13 22:42:16','2017-03-13 22:42:16'),(179,'g3b259fde3ed9ff3843839b','user','176',NULL,'2017-03-13 23:10:27','2017-03-13 23:10:27'),(181,'g3b259fde3ed9ff3843839b','user','178',NULL,'2017-03-13 23:58:28','2017-03-13 23:58:28'),(184,'g3b259fde3ed9ff3843839b','user','179',NULL,'2017-03-15 22:54:33','2017-03-15 22:54:33'),(186,'g3b259fde3ed9ff3843839b','user','180',NULL,'2017-03-16 00:49:30','2017-03-16 00:49:30'),(187,'g3b259fde3ed9ff3843839b','user','181',NULL,'2017-03-17 20:57:40','2017-03-17 20:57:40'),(195,'g3b259fde3ed9ff3843839b','user','183',NULL,'2017-03-29 23:58:16','2017-03-29 23:58:16'),(196,'g3b259fde3ed9ff3843839b','user','157',NULL,'2017-03-30 07:15:22','2017-03-30 07:15:22'),(200,'g3b259fde3ed9ff3843839b','user','186',NULL,'2017-03-30 19:02:39','2017-03-30 19:02:39'),(201,'g3b259fde3ed9ff3843839b','user','192',NULL,'2017-03-30 19:12:51','2017-03-30 19:12:51'),(208,'g3b259fde3ed9ff3843839b','user','156',NULL,'2017-04-03 16:21:26','2017-04-03 16:21:26'),(212,'g3b259fde3ed9ff3843839b','user','195',NULL,'2017-04-05 21:39:31','2017-04-05 21:39:31'),(218,'g3b259fde3ed9ff3843839b','user','189',NULL,'2017-04-12 17:45:54','2017-04-12 17:45:54'),(227,'g3b259fde3ed9ff3843839b','user','148',NULL,'2018-06-21 01:00:17','2018-06-21 01:00:17'),(228,'g3b259fde3ed9ff3843839b','user','197',NULL,'2018-06-21 01:26:47','2018-06-21 01:26:47');
/*!40000 ALTER TABLE `oauth_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `messenger_user_id` int(11) NOT NULL,
  `cost` varchar(255) CHARACTER SET utf8 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_order_users1_idx` (`id_user`),
  CONSTRAINT `fk_order_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_has_document`
--

DROP TABLE IF EXISTS `order_has_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_has_document` (
  `order_id` int(10) unsigned NOT NULL,
  `document_id` int(10) unsigned NOT NULL,
  KEY `fk_order_has_document_order1_idx` (`order_id`),
  KEY `fk_order_has_document_document1_idx` (`document_id`),
  CONSTRAINT `fk_order_has_document_document1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_has_document_order1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_has_document`
--

LOCK TABLES `order_has_document` WRITE;
/*!40000 ALTER TABLE `order_has_document` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_has_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `services_order_id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `payment_type` varchar(45) DEFAULT NULL,
  `discount` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 NOT NULL,
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` double(8,2) NOT NULL,
  `payment_method` tinyint(4) NOT NULL,
  `transaction_id` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `source_id` varchar(40) NOT NULL,
  `order_id` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` timestamp NOT NULL,
  `end_date` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,197,'2018-06-20 21:56:46',50.00,1,'801585','Pago de servicio urgente','knvfpphrt5gxjagnx9dh','DOX-197-1-2018-06-20 21:56:41',1,1,'2018-06-20 21:56:46','2018-06-20 21:56:46','2018-06-20 21:56:46','2018-06-20 21:56:46');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments_methods`
--

DROP TABLE IF EXISTS `payments_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments_methods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_payment_method` int(11) DEFAULT NULL COMMENT '0:Paypal|1:Tarjeta',
  `default` int(11) DEFAULT '0' COMMENT 'si:1 no:0',
  `email` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `payments_methods_customer_id_foreign` (`id_user`),
  CONSTRAINT `fk_payments_methods_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments_methods`
--

LOCK TABLES `payments_methods` WRITE;
/*!40000 ALTER TABLE `payments_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_cost`
--

DROP TABLE IF EXISTS `service_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_cost` (
  `id` int(11) NOT NULL,
  `annual_cost` float DEFAULT NULL,
  `reception_cost` float DEFAULT NULL,
  `delivery_cost` float DEFAULT NULL,
  `mixed_cost` float DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_cost`
--

LOCK TABLES `service_cost` WRITE;
/*!40000 ALTER TABLE `service_cost` DISABLE KEYS */;
INSERT INTO `service_cost` VALUES (1,1299,50,50,50,'0000-00-00 00:00:00','2017-02-08 23:32:45');
/*!40000 ALTER TABLE `service_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services2documents`
--

DROP TABLE IF EXISTS `services2documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services2documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services2documents`
--

LOCK TABLES `services2documents` WRITE;
/*!40000 ALTER TABLE `services2documents` DISABLE KEYS */;
INSERT INTO `services2documents` VALUES (1,4,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,5,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,6,12,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,7,14,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,8,17,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,8,19,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,9,20,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `services2documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services_orders`
--

DROP TABLE IF EXISTS `services_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `notes` text,
  `folio` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `service_type` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `urgent` tinyint(1) DEFAULT '0',
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `id_courier` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services_orders`
--

LOCK TABLES `services_orders` WRITE;
/*!40000 ALTER TABLE `services_orders` DISABLE KEYS */;
INSERT INTO `services_orders` VALUES (3,197,'2018-06-20 18:30:00','1',NULL,NULL,3,6,0,NULL,NULL,NULL,'2018-06-20 21:25:21','2018-06-20 21:24:30'),(4,197,'2018-06-21 16:25:00','1','rápido',NULL,2,6,0,0,0,148,'2018-06-20 21:35:59','2018-06-20 21:25:41'),(5,197,'2018-06-20 16:56:00','2','Ninguna',NULL,2,6,1,19.2561,-103.719,148,'2018-06-20 21:58:09','2018-06-20 21:56:47'),(6,197,'2018-06-22 16:00:00','3','Ninguna',NULL,2,6,0,19.2472,-103.725,NULL,'2018-06-21 01:05:42','2018-06-21 00:58:36'),(7,197,'2018-06-22 16:28:00','3','Ninguna',NULL,2,6,0,19.2472,-103.725,NULL,'2018-06-21 01:28:28','2018-06-21 01:28:28'),(8,197,'2018-06-21 16:18:00','4','Ninguna',NULL,2,5,0,19.2402,-103.724,NULL,'2018-06-21 03:50:53','2018-06-21 02:18:51'),(9,197,'2018-06-21 12:02:00','2','Frágil',NULL,2,4,0,19.2561,-103.719,148,'2018-06-21 04:21:50','2018-06-21 04:03:42');
/*!40000 ALTER TABLE `services_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services_statuses`
--

DROP TABLE IF EXISTS `services_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiration_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL COMMENT '1:Vencido, 2:Liquidado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services_statuses`
--

LOCK TABLES `services_statuses` WRITE;
/*!40000 ALTER TABLE `services_statuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `services_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subtypes`
--

DROP TABLE IF EXISTS `subtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subtypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtypes`
--

LOCK TABLES `subtypes` WRITE;
/*!40000 ALTER TABLE `subtypes` DISABLE KEYS */;
INSERT INTO `subtypes` VALUES (1,'Automóvil',1,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(2,'Elctrónicos',1,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(3,'Servicios',1,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(4,'Mobiliario',1,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(5,'Otro',1,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(6,'Vida',2,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(7,'Casa',2,'2017-01-04 23:37:23','2017-01-04 23:37:23'),(8,'Auto',2,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(9,'Educación',2,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(10,'Ahorro',2,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(11,'Gastos médicos',2,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(12,'Servicios funerarios',2,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(13,'Otro',2,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(14,'Anterior',3,'2017-01-04 23:37:24','2017-01-04 23:37:24'),(15,'Vigente',3,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(16,'Terreno',4,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(17,'Departamento',4,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(18,'Casa',4,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(19,'Oficinas',4,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(20,'Edificio',4,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(21,'Otro',4,'2017-01-04 23:37:25','2017-01-04 23:37:25'),(22,'Nacimiento',5,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(23,'Matrimonio',5,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(24,'Defunción',5,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(25,'Constitutiva',5,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(26,'Asamblea',5,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(27,'Otro',5,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(28,'Declaración',6,'2017-01-04 23:37:26','2017-01-04 23:37:26'),(29,'Tenencia',6,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(30,'Predial',6,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(31,'Otro',6,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(32,'Servicios',7,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(33,'Proveedores',7,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(34,'Otro',7,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(35,'Acciones',8,'2017-01-04 23:37:27','2017-01-04 23:37:27'),(36,'Cartilla',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(37,'Contrato',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(38,'Convenio',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(39,'Llave de refacción',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(40,'Manuales',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(41,'Poderes',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(42,'Títulos de crédito',8,'2017-01-04 23:37:28','2017-01-04 23:37:28'),(43,'Otro',8,'2017-01-04 23:37:29','2017-01-04 23:37:29');
/*!40000 ALTER TABLE `subtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types`
--

LOCK TABLES `types` WRITE;
/*!40000 ALTER TABLE `types` DISABLE KEYS */;
INSERT INTO `types` VALUES (1,'Factura','2017-01-04 23:37:05','2017-01-04 23:37:05'),(2,'Póliza','2017-01-04 23:37:05','2017-01-04 23:37:05'),(3,'Testamento','2017-01-04 23:37:05','2017-01-04 23:37:05'),(4,'Escritura','2017-01-04 23:37:05','2017-01-04 23:37:05'),(5,'Acta','2017-01-04 23:37:05','2017-01-04 23:37:05'),(6,'Impuestos','2017-01-04 23:37:05','2017-01-04 23:37:05'),(7,'Pagos','2017-01-04 23:37:06','2017-01-04 23:37:06'),(8,'Otro','2017-01-04 23:37:07','2017-01-04 23:37:07');
/*!40000 ALTER TABLE `types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_activities`
--

DROP TABLE IF EXISTS `user_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `charge` float NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `id_transaction` int(11) NOT NULL,
  `id_payment_method` int(11) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_user_activities_users1_idx` (`id_user`),
  KEY `fk_user_activities_payments_methods1_idx` (`id_payment_method`),
  CONSTRAINT `fk_user_activities_payments_methods1` FOREIGN KEY (`id_payment_method`) REFERENCES `payments_methods` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_activities_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_activities`
--

LOCK TABLES `user_activities` WRITE;
/*!40000 ALTER TABLE `user_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_addresses`
--

DROP TABLE IF EXISTS `user_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_addresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) DEFAULT NULL,
  `address` varchar(200) NOT NULL,
  `longitude` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `eliminated` tinyint(1) DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user_idx` (`id_user`),
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_addresses`
--

LOCK TABLES `user_addresses` WRITE;
/*!40000 ALTER TABLE `user_addresses` DISABLE KEYS */;
INSERT INTO `user_addresses` VALUES (1,'This is a description','Medellin 293',NULL,NULL,0,'2016-11-09 01:05:08','2016-11-09 01:05:08',197),(2,'Oficina','Enrique González Martínez',-103.7186067,19.2560927,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',197),(3,'Oficinas','Avenida Constitución',-103.724737,19.2472434,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',197),(4,'Casa','Calle Francisco I. Madero',-103.7236329,19.2402245,0,'0000-00-00 00:00:00','0000-00-00 00:00:00',197);
/*!40000 ALTER TABLE `user_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_membership`
--

DROP TABLE IF EXISTS `user_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `due_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `fk_user_membership_users1_idx` (`id_user`),
  CONSTRAINT `fk_user_membership_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_membership`
--

LOCK TABLES `user_membership` WRITE;
/*!40000 ALTER TABLE `user_membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `surname1` varchar(100) DEFAULT NULL,
  `surname2` varchar(100) DEFAULT NULL,
  `birthday` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `gender` tinyint(1) DEFAULT '1',
  `phone` varchar(12) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_security_question` int(11) DEFAULT NULL,
  `security_question_answer` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `remember_token` varchar(100) DEFAULT NULL,
  `active_status` tinyint(1) DEFAULT '0',
  `pay_status` tinyint(1) DEFAULT '0',
  `profile_status` tinyint(1) DEFAULT '0',
  `main_method_payment` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Cristian','Olivares','Villa',NULL,'c.ivan_la@hotmail.com','$2y$10$TtFYqX4p8/FOL9Hj7dHi8.DZLtVbE3rsGZNdZAghW6FCbZspN8kZC',1,NULL,1,NULL,NULL,'2016-07-26 03:05:40','2016-08-29 08:10:30',NULL,0,0,0,0),(16,'Ruben','Becerra','Medina',NULL,'ruben@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-01 23:09:41','2016-08-16 04:27:47',NULL,0,0,0,0),(17,'Eduardo','Muñoz','Islas',NULL,'eduardo@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-01 23:12:09','2016-08-01 23:12:09',NULL,0,0,0,0),(18,'Felipe','Muñoz','Islas',NULL,'felipe@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-08-01 23:15:55','2016-08-01 23:15:55',NULL,0,0,0,0),(21,'Erick','Torres','Galvan',NULL,'emaus@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-08-01 23:46:27','2016-08-01 23:46:27',NULL,0,0,0,0),(23,'Francisco','Villa','Cerda',NULL,'fran@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-02 00:03:40','2016-08-11 02:02:28',NULL,0,0,0,0),(24,'Raul','Trujillo','Perez',NULL,'rul@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-08-02 00:07:51','2016-08-16 04:24:45',NULL,0,0,0,0),(25,'Mario','Torres','Santillan',NULL,'mario@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-02 00:15:35','2016-08-11 00:18:51',NULL,0,0,0,0),(26,'Ricardo','Garcia','Cruz',NULL,'ricardo@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-02 00:20:19','2016-08-16 04:37:20',NULL,0,0,0,0),(27,'Rene','Najera','Montaño',NULL,'rene@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,2,NULL,NULL,'2016-08-02 02:26:48','2016-08-11 00:17:22',NULL,0,0,0,0),(33,'David','Pedroza','Nuñez',NULL,'david@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3319012340',3,0,NULL,'2016-08-02 03:18:34','2016-08-02 03:18:34',NULL,0,0,0,0),(34,'Lourdes','Garcia','Oñate',NULL,'lourdes@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,5,NULL,NULL,'2016-08-02 03:20:06','2016-08-02 03:20:07',NULL,0,0,0,0),(35,'Cecilia','Cerda','Pantoja',NULL,'ceci_cerda@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,5,NULL,NULL,'2016-08-16 04:20:52','2016-08-16 04:20:52',NULL,0,0,0,0),(36,'Saúl ','Castellanos','Orozco',NULL,'saul@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-08-16 04:29:05','2016-08-16 04:29:05',NULL,0,0,0,0),(37,'Jorge ','Mendoza','Zarate',NULL,'george@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-08-16 04:31:13','2016-08-16 04:31:13',NULL,0,0,0,0),(38,'Larisa','Tejada','Ortega',NULL,'larisa@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,5,NULL,NULL,'2016-08-16 04:34:10','2016-08-16 04:34:10',NULL,0,0,0,0),(39,'Guadalupe ','Garcia','Velasco',NULL,'lupe_garcia@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,1,NULL,NULL,'2016-08-16 04:36:44','2016-08-16 04:36:44',NULL,0,0,0,0),(40,'Alejandra',NULL,NULL,NULL,'ale_ontiveros@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,4,NULL,NULL,'2016-08-16 18:55:46','2016-08-16 18:55:46',NULL,0,0,0,0),(41,'Guillermo','Olivares',' Trujillo',NULL,'memo@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-16 19:06:33','2016-08-16 19:06:33',NULL,0,0,0,0),(42,'Silvia','Jara',' Martinez',NULL,'silvia@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,4,NULL,NULL,'2016-08-16 19:13:07','2016-08-16 19:13:07',NULL,0,0,0,0),(43,'Fernando','Suarez','Lopez',NULL,'fernan@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-16 19:14:45','2016-09-01 22:52:17',NULL,1,0,0,0),(44,'Martin','Trujillo','Garcia',NULL,'martin@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-16 19:16:17','2016-08-16 19:16:17',NULL,0,0,0,0),(45,'Carlos','Aguilar','Estrada',NULL,'aguilar_carlos_r@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-16 19:20:15','2016-09-08 01:47:05',NULL,0,0,0,0),(46,'Miguel','Segura','Martinez',NULL,'martinez_migue@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-29 23:14:15','2016-08-29 23:14:15',NULL,0,0,0,0),(47,'Gustavo','Manrriquez','Amezcua',NULL,'manrriquez@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-29 23:18:51','2016-08-29 23:18:51',NULL,0,0,0,0),(48,'Marisela','Velasco','Torres',NULL,'marisela@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,1,NULL,NULL,'2016-08-30 02:29:35','2016-08-30 02:29:35',NULL,0,0,0,0),(49,'Margarita','Zavala','Hernandez',NULL,'zavala@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,1,NULL,NULL,'2016-08-30 02:37:08','2016-08-30 02:37:08',NULL,0,0,0,0),(50,'Karina','Villaseñor','Vaca',NULL,'kari_villa@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,1,NULL,NULL,'2016-08-30 02:48:11','2016-08-30 02:48:11',NULL,0,0,0,0),(51,'Jose Maria','Marron','Gavilanes',NULL,'chema@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-30 03:00:28','2016-08-30 03:00:28',NULL,0,0,0,0),(52,'Tirsa','Trujillo','Garcia',NULL,'tirsa@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,4,NULL,NULL,'2016-08-30 03:09:25','2016-08-30 03:09:25',NULL,0,0,0,0),(53,'Marcelo ','Alatorre','Diaz',NULL,'alatorre@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-30 03:14:49','2016-08-30 03:14:49',NULL,0,0,0,0),(57,'Camerino ','Diaz','Perez',NULL,'camerino@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-30 03:50:51','2016-08-30 03:50:51',NULL,0,0,0,0),(58,'Benito ','Ruiz','Zavala',NULL,'Ruiz@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-08-30 03:55:10','2016-08-30 03:55:10',NULL,0,0,0,0),(59,'Gerardo ','Mercado','Mariscal',NULL,'mercado@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-30 04:01:50','2016-09-01 22:04:50',NULL,0,0,0,0),(61,'Gerardo ','Acuña','Vaca',NULL,'mall@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-08-30 04:02:18','2016-09-01 22:05:03',NULL,0,0,0,0),(62,'Nadia','Carmonaasdas','Perez',NULL,'carmona_nadia@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,4,NULL,NULL,'2016-08-30 04:08:10','2016-08-30 04:08:10',NULL,0,0,0,0),(63,'Daniel','Mendoza','Cerda',NULL,'gvtrry@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-09-01 23:33:15','2016-09-01 23:33:15',NULL,0,0,0,0),(64,'Magdalena ','Pedroza','Diaz',NULL,'magdalena@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,NULL,4,NULL,NULL,'2016-09-05 23:49:18','2016-09-05 23:49:18',NULL,0,0,0,0),(65,'Gabriel ','Avalos','Flores',NULL,'gabriel_avalos@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'2016-09-05 23:52:11','2016-09-05 23:52:11',NULL,0,0,0,0),(68,'Paulino','Arzate','Arias',NULL,'paulino@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-09-05 23:55:59','2016-09-05 23:55:59',NULL,0,0,0,0),(75,'Carlos Alberto','Moreno','Covarrubias',NULL,'carlos.moreno@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3314562890',3,0,NULL,'2016-09-13 03:43:14','2016-09-13 03:43:14',NULL,0,0,0,0),(76,'Marco','Fabian','De la Mora','1989-09-23 05:00:00','fabian_marco@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3315676123',3,0,NULL,'2016-09-13 03:47:00','2016-09-14 00:56:45',NULL,0,0,0,0),(77,'Ramses','Medina','Perez',NULL,'Ramses@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3939293456',3,0,NULL,'2016-09-14 03:28:31','2016-09-14 03:28:31',NULL,0,0,0,0),(78,'Reynaldo','Marquez','Diaz',NULL,'reynaldo_marquez@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-09-16 03:15:17','2016-09-16 03:30:00',NULL,0,0,0,0),(81,'Silvia','Pinal',NULL,NULL,'silvia@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,'123123123123',3,0,NULL,'2016-11-07 19:11:46','2016-11-07 19:11:46',NULL,0,0,0,0),(82,'fernando','vela','jfkfkd','0000-00-00 00:00:00','fel@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'5656565656',3,0,NULL,'2016-11-07 20:29:20','2016-11-07 20:29:20',NULL,0,0,1,0),(85,'asd','asd','asd',NULL,'asd@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,4,NULL,NULL,'2016-11-08 20:01:56','2016-11-08 20:01:56',NULL,0,0,0,0),(86,'asdasd','adasd','asdad',NULL,'asda@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'2016-11-08 22:37:49','2016-11-08 22:37:49',NULL,0,0,0,0),(119,'hector','cuevas','morfin','2016-11-08 00:00:00','poncho@hotmail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3125933821',3,3,'puppy','2016-11-25 23:51:39','2016-11-25 23:51:39',NULL,0,0,0,0),(131,'Fer','velazquez','baron',NULL,'nando0727@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,0,0,0,0),(142,'test','test','test','2004-06-07 00:00:00','emailtest@test.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3125933821',3,1,'cande','2016-11-30 16:37:48','2016-11-30 16:37:48',NULL,0,0,1,0),(143,'testing','test','test','0000-00-00 00:00:00','testing@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'65656565',3,2,'azul','2016-11-30 16:40:06','2016-11-30 16:40:06',NULL,0,0,1,0),(144,'test','test','test','2016-11-30 00:00:00','test@test.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3125933821',3,1,'cande','2016-11-30 16:41:07','2016-11-30 16:41:07',NULL,0,0,1,0),(145,'test','testing','tedting','0000-00-00 00:00:00','test2@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'6566565',3,4,'manza','2016-11-30 17:07:00','2016-11-30 17:07:00',NULL,0,0,1,0),(147,'hdjdjd','igitit','jfifjdjd','2002-11-30 00:00:00','test3@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'323232',3,2,'rojo','2016-11-30 17:17:16','2016-11-30 17:17:16',NULL,1,1,1,0),(148,'Carlos Hugo','Gonzalez','Castell',NULL,'carlos.gonzalez@varangard.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,1,0,0,0),(149,'Usuario','Para Pruebas','Pruebas',NULL,'admin@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,2,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','wFjN5dzAc4GHj9Q9kmZpeBmfCpHeYlkFrzHsmvypYQF15NBSKmsKAoxwOBSQ',1,0,0,0),(150,'',NULL,NULL,NULL,'alma@gmail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,1,'emma','2016-12-06 01:54:10','2016-12-06 01:54:10',NULL,0,0,0,0),(151,'',NULL,NULL,NULL,'almamerino@gmail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,1,'emma','2016-12-06 01:54:34','2016-12-06 01:54:34',NULL,0,0,0,0),(152,'hector','zazueta','vidal','0000-00-00 00:00:00','test5@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'5563164718',3,1,'candelaria','2016-12-06 02:21:16','2016-12-06 02:21:16',NULL,0,0,1,0),(153,'pedro','infante','hshaha','0000-00-00 00:00:00','infante@appdata.mx','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'312542516',3,1,'Hola mundo!','2016-12-09 23:54:33','2016-12-09 23:54:33',NULL,0,0,1,0),(156,'Prueba :) ','Correcto','Usar',NULL,'mensajero-dox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,5,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00',NULL,1,1,1,0),(157,'Cliente','Apellido','Apellido2',NULL,'cliente-dox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','SQlOWbwGUXwMB16vBHQpDJNIBcjFsKCyAETafllLCDeBJV7EGt1M6SLUilde',1,1,1,0),(158,'Admin','Apellido','Apellido2',NULL,'admin-dox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,1,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','WaZ35v3OEBb4ILBdBurnQkYgbKuGRmg7WmyOqAYSmVskemwQ2iJCXJpSZBFo',1,1,1,0),(159,'Super Admin','Apellido','Apellido2',NULL,'superadmin-dox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,2,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','E265yfW7nymzfKWsV9wkcsggvP6T0kn0I83jPD2ICfQ06iZntrA6YimnZlFI',1,1,1,0),(163,'Cliente','Cliente','clientacho','0000-00-00 00:00:00','cliente@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,'312842136449',3,4,'colima','2017-01-13 18:35:21','2017-01-13 18:35:21',NULL,0,1,1,0),(164,'fygyy','yghgh','ghgg','0000-00-00 00:00:00','dox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'255366',3,1,'bsjqjanaka','2017-01-13 19:09:35','2017-01-13 19:09:35',NULL,0,1,1,0),(165,'Dox','Xod','Doxod','0000-00-00 00:00:00','cdox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'99949494',3,1,'bjajaiwis','2017-01-13 19:17:23','2017-01-13 19:17:23',NULL,0,1,1,0),(166,'djjdjdh','ujdhdhe','hdjdhjjd','0000-00-00 00:00:00','cox@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'21325445',3,1,'dudjdjdjd','2017-01-13 19:25:30','2017-01-13 19:25:30',NULL,0,1,1,0),(169,'Juan','Martinez','Ochoa','1993-01-16 00:00:00','juan_ener33@hotmail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3125933822',3,1,'asdf','2017-01-16 22:01:40','2017-01-16 22:01:40',NULL,0,1,1,0),(170,'no','bxnxn','bend','2017-01-18 00:00:00','test4@test.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'612548884',3,1,'dhd','2017-01-19 03:28:51','2017-01-19 03:28:51',NULL,0,1,1,0),(171,'hector','cuevas','morfin','2017-01-30 00:00:00','hector@demo.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'3125933821',3,1,'cande','2017-01-30 15:16:58','2017-01-30 15:16:58',NULL,0,1,1,0),(172,'Héctor ','zazueta','Vidal ','1971-12-18 00:00:00','Hector.zazueta@hotmail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'5563164718',3,1,'Olga','2017-02-09 01:29:05','2017-02-09 01:29:05',NULL,1,1,1,0),(173,'fulano','fulin','fulon','0000-00-00 00:00:00','fulano@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'1245733465',3,3,'hola k ase','2017-02-09 01:43:30','2017-02-09 01:43:30',NULL,1,1,1,0),(174,'',NULL,NULL,NULL,'mailx@mailx.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,1,'nfnd','2017-03-08 18:00:24','2017-03-08 18:00:24',NULL,0,0,0,0),(177,'',NULL,NULL,NULL,'pablo@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,4,'no se','2017-03-13 23:55:20','2017-03-13 23:55:20',NULL,0,0,0,0),(178,'',NULL,NULL,NULL,'hello@test.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,1,'snns','2017-03-13 23:58:11','2017-03-13 23:58:11',NULL,0,0,0,0),(182,'dox','dox','dox','0000-00-00 00:00:00','dox2@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'95346497',3,1,'jcjfuf','2017-03-21 18:10:49','2017-03-21 18:10:49',NULL,0,1,1,0),(183,'',NULL,NULL,NULL,'mail@mail.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,NULL,3,1,'response','2017-03-29 23:58:01','2017-03-29 23:58:01',NULL,0,0,0,0),(194,'Alma','Merino','Cedeño','1982-08-25 00:00:00','alma.merino@varangard.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,'5548773182',3,2,'negro','2017-04-03 16:15:37','2017-04-03 16:15:37',NULL,1,0,1,0),(196,'jdhxj','ifkxj','ifkfi','2017-04-05 00:00:00','natanahel.lopez@varangard.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',1,'9897676768',3,1,'fuighdogfj','2017-04-05 22:01:41','2017-04-05 22:01:41',NULL,1,1,1,0),(197,'Roberto','Avalos','Sanchez','2017-04-10 00:00:00','roberto.avalos@varangard.com','$2y$10$ot13hLHJmRb07XE1o1VhVeAcXPzJ2WTuabV6N3LBWpXiq4BYy4dQu',2,'131231231',3,1,'lahjas','2017-04-10 21:23:56','2017-04-10 21:23:56',NULL,1,1,1,2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users2openpay`
--

DROP TABLE IF EXISTS `users2openpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users2openpay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_id` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users2openpay`
--

LOCK TABLES `users2openpay` WRITE;
/*!40000 ALTER TABLE `users2openpay` DISABLE KEYS */;
INSERT INTO `users2openpay` VALUES (1,197,'aqffsvnivitfl1f5hz89','cliente-dox@mail.com','2017-01-11 21:52:25','2017-01-11 21:52:25');
/*!40000 ALTER TABLE `users2openpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_referreds`
--

DROP TABLE IF EXISTS `users_referreds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_referreds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `id_referred_user` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_id_UNIQUE` (`id`),
  KEY `fk_users_referreds_users1_idx` (`id_user`),
  CONSTRAINT `fk_users_referreds_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_referreds`
--

LOCK TABLES `users_referreds` WRITE;
/*!40000 ALTER TABLE `users_referreds` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_referreds` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-21  9:46:00
