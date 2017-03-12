-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: xtraice-compras
-- ------------------------------------------------------
-- Server version	5.5.46-0ubuntu0.14.04.2

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
-- Table structure for table `backend_access_log`
--

DROP TABLE IF EXISTS `backend_access_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_access_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_access_log`
--

LOCK TABLES `backend_access_log` WRITE;
/*!40000 ALTER TABLE `backend_access_log` DISABLE KEYS */;
INSERT INTO `backend_access_log` VALUES (1,1,'192.168.33.1','2017-03-12 10:51:27','2017-03-12 10:51:27');
/*!40000 ALTER TABLE `backend_access_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backend_user_groups`
--

DROP TABLE IF EXISTS `backend_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_new_user_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_unique` (`name`),
  KEY `code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_groups`
--

LOCK TABLES `backend_user_groups` WRITE;
/*!40000 ALTER TABLE `backend_user_groups` DISABLE KEYS */;
INSERT INTO `backend_user_groups` VALUES (1,'Owners',NULL,'2017-03-12 10:50:59','2017-03-12 10:50:59','owners','Default group for website owners.',0);
/*!40000 ALTER TABLE `backend_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backend_user_preferences`
--

DROP TABLE IF EXISTS `backend_user_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_user_preferences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `namespace` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_item_index` (`user_id`,`namespace`,`group`,`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_preferences`
--

LOCK TABLES `backend_user_preferences` WRITE;
/*!40000 ALTER TABLE `backend_user_preferences` DISABLE KEYS */;
/*!40000 ALTER TABLE `backend_user_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backend_user_throttle`
--

DROP TABLE IF EXISTS `backend_user_throttle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_user_throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backend_user_throttle_user_id_index` (`user_id`),
  KEY `backend_user_throttle_ip_address_index` (`ip_address`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_throttle`
--

LOCK TABLES `backend_user_throttle` WRITE;
/*!40000 ALTER TABLE `backend_user_throttle` DISABLE KEYS */;
INSERT INTO `backend_user_throttle` VALUES (1,1,'192.168.33.1',0,NULL,0,NULL,0,NULL);
/*!40000 ALTER TABLE `backend_user_throttle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backend_users`
--

DROP TABLE IF EXISTS `backend_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_unique` (`login`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `act_code_index` (`activation_code`),
  KEY `reset_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_users`
--

LOCK TABLES `backend_users` WRITE;
/*!40000 ALTER TABLE `backend_users` DISABLE KEYS */;
INSERT INTO `backend_users` VALUES (1,'Admin','Person','admin','admin@domain.tld','$2y$10$XgfNhplfg/WV6hsU2GdJ1etpVWLolwxsNsxdLh1iri3RrrA9IGdBy',NULL,'$2y$10$Mf5OoDM6QdiIX66HMsPZR.DzT7AkoNb121OBH4C/FAAqkz5dWoSGW',NULL,'',1,NULL,'2017-03-12 10:51:26','2017-03-12 10:50:59','2017-03-12 10:51:26',1),(2,'Andrés','Rangel','soporte','soporte@istheweb.com','$2y$10$TVwavX39VKgW8cQvf4cAnuwd3mS7ZCLuio/ITZ3.t96prSBZb7l/G',NULL,NULL,NULL,'',0,NULL,NULL,'2017-03-12 11:05:59','2017-03-12 11:05:59',1);
/*!40000 ALTER TABLE `backend_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backend_users_groups`
--

DROP TABLE IF EXISTS `backend_users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `user_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_users_groups`
--

LOCK TABLES `backend_users_groups` WRITE;
/*!40000 ALTER TABLE `backend_users_groups` DISABLE KEYS */;
INSERT INTO `backend_users_groups` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `backend_users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_theme_data`
--

DROP TABLE IF EXISTS `cms_theme_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_theme_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_theme_data_theme_index` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_theme_data`
--

LOCK TABLES `cms_theme_data` WRITE;
/*!40000 ALTER TABLE `cms_theme_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_theme_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deferred_bindings`
--

DROP TABLE IF EXISTS `deferred_bindings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deferred_bindings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `master_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `master_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slave_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slave_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `session_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_bind` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deferred_bindings_master_type_index` (`master_type`),
  KEY `deferred_bindings_master_field_index` (`master_field`),
  KEY `deferred_bindings_slave_type_index` (`slave_type`),
  KEY `deferred_bindings_slave_id_index` (`slave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deferred_bindings`
--

LOCK TABLES `deferred_bindings` WRITE;
/*!40000 ALTER TABLE `deferred_bindings` DISABLE KEYS */;
/*!40000 ALTER TABLE `deferred_bindings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2013_10_01_000001_Db_Deferred_Bindings',1),('2013_10_01_000002_Db_System_Files',1),('2013_10_01_000003_Db_System_Plugin_Versions',1),('2013_10_01_000004_Db_System_Plugin_History',1),('2013_10_01_000005_Db_System_Settings',1),('2013_10_01_000006_Db_System_Parameters',1),('2013_10_01_000007_Db_System_Add_Disabled_Flag',1),('2013_10_01_000008_Db_System_Mail_Templates',1),('2013_10_01_000009_Db_System_Mail_Layouts',1),('2014_10_01_000010_Db_Jobs',1),('2014_10_01_000011_Db_System_Event_Logs',1),('2014_10_01_000012_Db_System_Request_Logs',1),('2014_10_01_000013_Db_System_Sessions',1),('2015_10_01_000014_Db_System_Mail_Layout_Rename',1),('2015_10_01_000015_Db_System_Add_Frozen_Flag',1),('2015_10_01_000016_Db_Cache',1),('2015_10_01_000017_Db_System_Revisions',1),('2015_10_01_000018_Db_FailedJobs',1),('2016_10_01_000019_Db_System_Plugin_History_Detail_Text',1),('2016_10_01_000020_Db_System_Timestamp_Fix',1),('2013_10_01_000001_Db_Backend_Users',2),('2013_10_01_000002_Db_Backend_User_Groups',2),('2013_10_01_000003_Db_Backend_Users_Groups',2),('2013_10_01_000004_Db_Backend_User_Throttle',2),('2014_01_04_000005_Db_Backend_User_Preferences',2),('2014_10_01_000006_Db_Backend_Access_Log',2),('2014_10_01_000007_Db_Backend_Add_Description_Field',2),('2015_10_01_000008_Db_Backend_Add_Superuser_Flag',2),('2016_10_01_000009_Db_Backend_Timestamp_Fix',2),('2014_10_01_000001_Db_Cms_Theme_Data',3),('2016_10_01_000002_Db_Cms_Timestamp_Fix',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_location_countries`
--

DROP TABLE IF EXISTS `rainlab_location_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_location_countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rainlab_location_countries_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_location_countries`
--

LOCK TABLES `rainlab_location_countries` WRITE;
/*!40000 ALTER TABLE `rainlab_location_countries` DISABLE KEYS */;
INSERT INTO `rainlab_location_countries` VALUES (1,1,'Australia','AU',1),(2,1,'Canada','CA',1),(3,1,'United Kingdom','GB',1),(4,1,'United States','US',1),(5,0,'Afghanistan','AF',0),(6,0,'Aland Islands ','AX',0),(7,0,'Albania','AL',0),(8,0,'Algeria','DZ',0),(9,0,'American Samoa','AS',0),(10,0,'Andorra','AD',0),(11,0,'Angola','AO',0),(12,0,'Anguilla','AI',0),(13,0,'Antarctica','AQ',0),(14,0,'Antigua and Barbuda','AG',0),(15,0,'Argentina','AR',0),(16,0,'Armenia','AM',0),(17,0,'Aruba','AW',0),(18,0,'Austria','AT',0),(19,0,'Azerbaijan','AZ',0),(20,0,'Bahamas','BS',0),(21,0,'Bahrain','BH',0),(22,0,'Bangladesh','BD',0),(23,0,'Barbados','BB',0),(24,0,'Belarus','BY',0),(25,0,'Belgium','BE',0),(26,0,'Belize','BZ',0),(27,0,'Benin','BJ',0),(28,0,'Bermuda','BM',0),(29,0,'Bhutan','BT',0),(30,0,'Bolivia, Plurinational State of','BO',0),(31,0,'Bonaire, Sint Eustatius and Saba','BQ',0),(32,0,'Bosnia and Herzegovina','BA',0),(33,0,'Botswana','BW',0),(34,0,'Bouvet Island','BV',0),(35,0,'Brazil','BR',0),(36,0,'British Indian Ocean Territory','IO',0),(37,0,'Brunei Darussalam','BN',0),(38,0,'Bulgaria','BG',0),(39,0,'Burkina Faso','BF',0),(40,0,'Burundi','BI',0),(41,0,'Cambodia','KH',0),(42,0,'Cameroon','CM',0),(43,0,'Cape Verde','CV',0),(44,0,'Cayman Islands','KY',0),(45,0,'Central African Republic','CF',0),(46,0,'Chad','TD',0),(47,0,'Chile','CL',0),(48,0,'China','CN',0),(49,0,'Christmas Island','CX',0),(50,0,'Cocos (Keeling) Islands','CC',0),(51,0,'Colombia','CO',0),(52,0,'Comoros','KM',0),(53,0,'Congo','CG',0),(54,0,'Congo, the Democratic Republic of the','CD',0),(55,0,'Cook Islands','CK',0),(56,0,'Costa Rica','CR',0),(57,0,'Cote d\'Ivoire','CI',0),(58,0,'Croatia','HR',0),(59,0,'Cuba','CU',0),(60,0,'Curaçao','CW',0),(61,0,'Cyprus','CY',0),(62,0,'Czech Republic','CZ',0),(63,0,'Denmark','DK',0),(64,0,'Djibouti','DJ',0),(65,0,'Dominica','DM',0),(66,0,'Dominican Republic','DO',0),(67,0,'Ecuador','EC',0),(68,0,'Egypt','EG',0),(69,0,'El Salvador','SV',0),(70,0,'Equatorial Guinea','GQ',0),(71,0,'Eritrea','ER',0),(72,0,'Estonia','EE',0),(73,0,'Ethiopia','ET',0),(74,0,'Falkland Islands (Malvinas)','FK',0),(75,0,'Faroe Islands','FO',0),(76,0,'Finland','FI',0),(77,0,'Fiji','FJ',0),(78,1,'France','FR',0),(79,0,'French Guiana','GF',0),(80,0,'French Polynesia','PF',0),(81,0,'French Southern Territories','TF',0),(82,0,'Gabon','GA',0),(83,0,'Gambia','GM',0),(84,0,'Georgia','GE',0),(85,0,'Germany','DE',0),(86,0,'Ghana','GH',0),(87,0,'Gibraltar','GI',0),(88,0,'Greece','GR',0),(89,0,'Greenland','GL',0),(90,0,'Grenada','GD',0),(91,0,'Guadeloupe','GP',0),(92,0,'Guam','GU',0),(93,0,'Guatemala','GT',0),(94,0,'Guernsey','GG',0),(95,0,'Guinea','GN',0),(96,0,'Guinea-Bissau','GW',0),(97,0,'Guyana','GY',0),(98,0,'Haiti','HT',0),(99,0,'Heard Island and McDonald Islands','HM',0),(100,0,'Holy See (Vatican City State)','VA',0),(101,0,'Honduras','HN',0),(102,0,'Hong Kong','HK',0),(103,1,'Hungary','HU',0),(104,0,'Iceland','IS',0),(105,1,'India','IN',0),(106,0,'Indonesia','ID',0),(107,0,'Iran, Islamic Republic of','IR',0),(108,0,'Iraq','IQ',0),(109,1,'Ireland','IE',0),(110,0,'Isle of Man','IM',0),(111,0,'Israel','IL',0),(112,0,'Italy','IT',0),(113,0,'Jamaica','JM',0),(114,0,'Japan','JP',0),(115,0,'Jersey','JE',0),(116,0,'Jordan','JO',0),(117,0,'Kazakhstan','KZ',0),(118,0,'Kenya','KE',0),(119,0,'Kiribati','KI',0),(120,0,'Korea, Democratic People\'s Republic of','KP',0),(121,0,'Korea, Republic of','KR',0),(122,0,'Kuwait','KW',0),(123,0,'Kyrgyzstan','KG',0),(124,0,'Lao People\'s Democratic Republic','LA',0),(125,0,'Latvia','LV',0),(126,0,'Lebanon','LB',0),(127,0,'Lesotho','LS',0),(128,0,'Liberia','LR',0),(129,0,'Libyan Arab Jamahiriya','LY',0),(130,0,'Liechtenstein','LI',0),(131,0,'Lithuania','LT',0),(132,0,'Luxembourg','LU',0),(133,0,'Macao','MO',0),(134,0,'Macedonia','MK',0),(135,0,'Madagascar','MG',0),(136,0,'Malawi','MW',0),(137,0,'Malaysia','MY',0),(138,0,'Maldives','MV',0),(139,0,'Mali','ML',0),(140,0,'Malta','MT',0),(141,0,'Marshall Islands','MH',0),(142,0,'Martinique','MQ',0),(143,0,'Mauritania','MR',0),(144,0,'Mauritius','MU',0),(145,0,'Mayotte','YT',0),(146,0,'Mexico','MX',0),(147,0,'Micronesia, Federated States of','FM',0),(148,0,'Moldova, Republic of','MD',0),(149,0,'Monaco','MC',0),(150,0,'Mongolia','MN',0),(151,0,'Montenegro','ME',0),(152,0,'Montserrat','MS',0),(153,0,'Morocco','MA',0),(154,0,'Mozambique','MZ',0),(155,0,'Myanmar','MM',0),(156,0,'Namibia','NA',0),(157,0,'Nauru','NR',0),(158,0,'Nepal','NP',0),(159,1,'Netherlands','NL',0),(160,0,'New Caledonia','NC',0),(161,1,'New Zealand','NZ',0),(162,0,'Nicaragua','NI',0),(163,0,'Niger','NE',0),(164,0,'Nigeria','NG',0),(165,0,'Niue','NU',0),(166,0,'Norfolk Island','NF',0),(167,0,'Northern Mariana Islands','MP',0),(168,0,'Norway','NO',0),(169,0,'Oman','OM',0),(170,0,'Pakistan','PK',0),(171,0,'Palau','PW',0),(172,0,'Palestine','PS',0),(173,0,'Panama','PA',0),(174,0,'Papua New Guinea','PG',0),(175,0,'Paraguay','PY',0),(176,0,'Peru','PE',0),(177,0,'Philippines','PH',0),(178,0,'Pitcairn','PN',0),(179,0,'Poland','PL',0),(180,0,'Portugal','PT',0),(181,0,'Puerto Rico','PR',0),(182,0,'Qatar','QA',0),(183,0,'Reunion','RE',0),(184,1,'Romania','RO',0),(185,0,'Russian Federation','RU',0),(186,0,'Rwanda','RW',0),(187,0,'Saint Barthélemy','BL',0),(188,0,'Saint Helena','SH',0),(189,0,'Saint Kitts and Nevis','KN',0),(190,0,'Saint Lucia','LC',0),(191,0,'Saint Martin (French part)','MF',0),(192,0,'Saint Pierre and Miquelon','PM',0),(193,0,'Saint Vincent and the Grenadines','VC',0),(194,0,'Samoa','WS',0),(195,0,'San Marino','SM',0),(196,0,'Sao Tome and Principe','ST',0),(197,0,'Saudi Arabia','SA',0),(198,0,'Senegal','SN',0),(199,0,'Serbia','RS',0),(200,0,'Seychelles','SC',0),(201,0,'Sierra Leone','SL',0),(202,0,'Singapore','SG',0),(203,0,'Sint Maarten (Dutch part)','SX',0),(204,0,'Slovakia','SK',0),(205,0,'Slovenia','SI',0),(206,0,'Solomon Islands','SB',0),(207,0,'Somalia','SO',0),(208,0,'South Africa','ZA',0),(209,0,'South Georgia and the South Sandwich Islands','GS',0),(210,1,'Spain','ES',1),(211,0,'Sri Lanka','LK',0),(212,0,'Sudan','SD',0),(213,0,'Suriname','SR',0),(214,0,'Svalbard and Jan Mayen','SJ',0),(215,0,'Swaziland','SZ',0),(216,0,'Sweden','SE',0),(217,0,'Switzerland','CH',0),(218,0,'Syrian Arab Republic','SY',0),(219,0,'Taiwan, Province of China','TW',0),(220,0,'Tajikistan','TJ',0),(221,0,'Tanzania, United Republic of','TZ',0),(222,0,'Thailand','TH',0),(223,0,'Timor-Leste','TL',0),(224,0,'Togo','TG',0),(225,0,'Tokelau','TK',0),(226,0,'Tonga','TO',0),(227,0,'Trinidad and Tobago','TT',0),(228,0,'Tunisia','TN',0),(229,0,'Turkey','TR',0),(230,0,'Turkmenistan','TM',0),(231,0,'Turks and Caicos Islands','TC',0),(232,0,'Tuvalu','TV',0),(233,0,'Uganda','UG',0),(234,0,'Ukraine','UA',0),(235,0,'United Arab Emirates','AE',0),(236,0,'United States Minor Outlying Islands','UM',0),(237,0,'Uruguay','UY',0),(238,0,'Uzbekistan','UZ',0),(239,0,'Vanuatu','VU',0),(240,0,'Venezuela, Bolivarian Republic of','VE',0),(241,0,'Viet Nam','VN',0),(242,0,'Virgin Islands, British','VG',0),(243,0,'Virgin Islands, U.S.','VI',0),(244,0,'Wallis and Futuna','WF',0),(245,0,'Western Sahara','EH',0),(246,0,'Yemen','YE',0),(247,0,'Zambia','ZM',0),(248,0,'Zimbabwe','ZW',0);
/*!40000 ALTER TABLE `rainlab_location_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_location_states`
--

DROP TABLE IF EXISTS `rainlab_location_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_location_states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_location_states_country_id_index` (`country_id`),
  KEY `rainlab_location_states_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=403 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_location_states`
--

LOCK TABLES `rainlab_location_states` WRITE;
/*!40000 ALTER TABLE `rainlab_location_states` DISABLE KEYS */;
INSERT INTO `rainlab_location_states` VALUES (1,4,'Alabama','AL'),(2,4,'Alaska','AK'),(3,4,'American Samoa','AS'),(4,4,'Arizona','AZ'),(5,4,'Arkansas','AR'),(6,4,'California','CA'),(7,4,'Colorado','CO'),(8,4,'Connecticut','CT'),(9,4,'Delaware','DE'),(10,4,'Dist. of Columbia','DC'),(11,4,'Florida','FL'),(12,4,'Georgia','GA'),(13,4,'Guam','GU'),(14,4,'Hawaii','HI'),(15,4,'Idaho','ID'),(16,4,'Illinois','IL'),(17,4,'Indiana','IN'),(18,4,'Iowa','IA'),(19,4,'Kansas','KS'),(20,4,'Kentucky','KY'),(21,4,'Louisiana','LA'),(22,4,'Maine','ME'),(23,4,'Maryland','MD'),(24,4,'Marshall Islands','MH'),(25,4,'Massachusetts','MA'),(26,4,'Michigan','MI'),(27,4,'Micronesia','FM'),(28,4,'Minnesota','MN'),(29,4,'Mississippi','MS'),(30,4,'Missouri','MO'),(31,4,'Montana','MT'),(32,4,'Nebraska','NE'),(33,4,'Nevada','NV'),(34,4,'New Hampshire','NH'),(35,4,'New Jersey','NJ'),(36,4,'New Mexico','NM'),(37,4,'New York','NY'),(38,4,'North Carolina','NC'),(39,4,'North Dakota','ND'),(40,4,'Northern Marianas','MP'),(41,4,'Ohio','OH'),(42,4,'Oklahoma','OK'),(43,4,'Oregon','OR'),(44,4,'Palau','PW'),(45,4,'Pennsylvania','PA'),(46,4,'Puerto Rico','PR'),(47,4,'Rhode Island','RI'),(48,4,'South Carolina','SC'),(49,4,'South Dakota','SD'),(50,4,'Tennessee','TN'),(51,4,'Texas','TX'),(52,4,'Utah','UT'),(53,4,'Vermont','VT'),(54,4,'Virginia','VA'),(55,4,'Virgin Islands','VI'),(56,4,'Washington','WA'),(57,4,'West Virginia','WV'),(58,4,'Wisconsin','WI'),(59,4,'Wyoming','WY'),(60,35,'Acre','AC'),(61,35,'Alagoas','AL'),(62,35,'Amapá','AP'),(63,35,'Amazonas','AM'),(64,35,'Bahia','BA'),(65,35,'Ceará','CE'),(66,35,'Distrito Federal','DF'),(67,35,'Espírito Santo','ES'),(68,35,'Goiás','GO'),(69,35,'Maranhão','MA'),(70,35,'Mato Grosso','MT'),(71,35,'Mato Grosso do Sul','MS'),(72,35,'Minas Gerais','MG'),(73,35,'Pará','PA'),(74,35,'Paraíba','PB'),(75,35,'Paraná','PR'),(76,35,'Pernambuco','PE'),(77,35,'Piauí','PI'),(78,35,'Rio de Janeiro','RJ'),(79,35,'Rio Grande do Norte','RN'),(80,35,'Rio Grande do Sul','RS'),(81,35,'Rondônia','RO'),(82,35,'Roraima','RR'),(83,35,'Santa Catarina','SC'),(84,35,'São Paulo','SP'),(85,35,'Sergipe','SE'),(86,35,'Tocantins','TO'),(87,2,'Alberta','AB'),(88,2,'British Columbia','BC'),(89,2,'Manitoba','MB'),(90,2,'New Brunswick','NB'),(91,2,'Newfoundland and Labrador','NL'),(92,2,'Northwest Territories','NT'),(93,2,'Nova Scotia','NS'),(94,2,'Nunavut','NU'),(95,2,'Ontario','ON'),(96,2,'Prince Edward Island','PE'),(97,2,'Quebec','QC'),(98,2,'Saskatchewan','SK'),(99,2,'Yukon','YT'),(100,1,'New South Wales','NSW'),(101,1,'Queensland','QLD'),(102,1,'South Australia','SA'),(103,1,'Tasmania','TAS'),(104,1,'Victoria','VIC'),(105,1,'Western Australia','WA'),(106,1,'Northern Territory','NT'),(107,1,'Australian Capital Territory','ACT'),(108,85,'Baden-Württemberg','BW'),(109,85,'Bavaria','BY'),(110,85,'Berlin','BE'),(111,85,'Brandenburg','BB'),(112,85,'Bremen','HB'),(113,85,'Hamburg','HH'),(114,85,'Hesse','HE'),(115,85,'Mecklenburg-Vorpommern','MV'),(116,85,'Lower Saxony','NI'),(117,85,'North Rhine-Westphalia','NW'),(118,85,'Rhineland-Palatinate','RP'),(119,85,'Saarland','SL'),(120,85,'Saxony','SN'),(121,85,'Saxony-Anhalt','ST'),(122,85,'Schleswig-Holstein','SH'),(123,85,'Thuringia','TH'),(124,72,'Harju','HA'),(125,72,'Hiiu','HI'),(126,72,'Ida-Viru','IV'),(127,72,'Jõgeva','JR'),(128,72,'Järva','JN'),(129,72,'Lääne','LN'),(130,72,'Lääne-Viru','LV'),(131,72,'Põlva','PL'),(132,72,'Pärnu','PR'),(133,72,'Rapla','RA'),(134,72,'Saare','SA'),(135,72,'Tartu','TA'),(136,72,'Valga','VG'),(137,72,'Viljandi','VD'),(138,72,'Võru','VR'),(139,109,'Dublin','D'),(140,109,'Wicklow','WW'),(141,109,'Wexford','WX'),(142,109,'Carlow','CW'),(143,109,'Kildare','KE'),(144,109,'Meath','MH'),(145,109,'Louth','LH'),(146,109,'Monaghan','MN'),(147,109,'Cavan','CN'),(148,109,'Longford','LD'),(149,109,'Westmeath','WH'),(150,109,'Offaly','OY'),(151,109,'Laois','LS'),(152,109,'Kilkenny','KK'),(153,109,'Waterford','WD'),(154,109,'Cork','C'),(155,109,'Kerry','KY'),(156,109,'Limerick','LK'),(157,109,'North Tipperary','TN'),(158,109,'South Tipperary','TS'),(159,109,'Clare','CE'),(160,109,'Galway','G'),(161,109,'Mayo','MO'),(162,109,'Roscommon','RN'),(163,109,'Sligo','SO'),(164,109,'Leitrim','LM'),(165,109,'Donegal','DL'),(166,159,'Drenthe','DR'),(167,159,'Flevoland','FL'),(168,159,'Friesland','FR'),(169,159,'Gelderland','GE'),(170,159,'Groningen','GR'),(171,159,'Limburg','LI'),(172,159,'Noord-Brabant','NB'),(173,159,'Noord-Holland','NH'),(174,159,'Overijssel','OV'),(175,159,'Utrecht','UT'),(176,159,'Zeeland','ZE'),(177,159,'Zuid-Holland','ZH'),(178,3,'Aberdeenshire','ABE'),(179,3,'Anglesey','ALY'),(180,3,'Angus','ANG'),(181,3,'Argyll','ARG'),(182,3,'Ayrshire','AYR'),(183,3,'Banffshire','BAN'),(184,3,'Bedfordshire','BED'),(185,3,'Berkshire','BER'),(186,3,'Berwickshire','BWS'),(187,3,'Brecknockshire','BRE'),(188,3,'Buckinghamshire','BUC'),(189,3,'Bute','BUT'),(190,3,'Caernarfonshire','CAE'),(191,3,'Caithness','CAI'),(192,3,'Cambridgeshire','CAM'),(193,3,'Cardiganshire','CAR'),(194,3,'Carmarthenshire','CMS'),(195,3,'Cheshire','CHE'),(196,3,'Clackmannanshire','CLA'),(197,3,'Cleveland','CLE'),(198,3,'Cornwall','COR'),(199,3,'Cromartyshire','CRO'),(200,3,'Cumberland','CBR'),(201,3,'Cumbria','CUM'),(202,3,'Denbighshire','DEN'),(203,3,'Derbyshire','DER'),(204,3,'Devon','DEV'),(205,3,'Dorset','DOR'),(206,3,'Dumbartonshire','DBS'),(207,3,'Dumfriesshire','DUM'),(208,3,'Durham','DUR'),(209,3,'East Lothian','ELO'),(210,3,'Essex','ESS'),(211,3,'Flintshire','FLI'),(212,3,'Fife','FIF'),(213,3,'Glamorgan','GLA'),(214,3,'Gloucestershire','GLO'),(215,3,'Hampshire','HAM'),(216,3,'Herefordshire','HER'),(217,3,'Hertfordshire','HTF'),(218,3,'Huntingdonshire','HUN'),(219,3,'Inverness','INV'),(220,3,'Kent','KEN'),(221,3,'Kincardineshire','KCD'),(222,3,'Kinross-shire','KIN'),(223,3,'Kirkcudbrightshire','KIR'),(224,3,'Lanarkshire','LKS'),(225,3,'Lancashire','LAN'),(226,3,'Leicestershire','LEI'),(227,3,'Lincolnshire','LIN'),(228,3,'London','LON'),(229,3,'Manchester','MAN'),(230,3,'Merionethshire','MER'),(231,3,'Merseyside','MSY'),(232,3,'Middlesex','MDX'),(233,3,'Midlands','MID'),(234,3,'Midlothian','MLT'),(235,3,'Monmouthshire','MON'),(236,3,'Montgomeryshire','MGY'),(237,3,'Moray','MOR'),(238,3,'Nairnshire','NAI'),(239,3,'Norfolk','NOR'),(240,3,'Northamptonshire','NMP'),(241,3,'Northumberland','NUM'),(242,3,'Nottinghamshire','NOT'),(243,3,'Orkney','ORK'),(244,3,'Oxfordshire','OXF'),(245,3,'Peebleshire','PEE'),(246,3,'Pembrokeshire','PEM'),(247,3,'Perthshire','PER'),(248,3,'Radnorshire','RAD'),(249,3,'Renfrewshire','REN'),(250,3,'Ross & Cromarty','ROS'),(251,3,'Roxburghshire','ROX'),(252,3,'Rutland','RUT'),(253,3,'Selkirkshire','SEL'),(254,3,'Shetland','SHE'),(255,3,'Shropshire','SHR'),(256,3,'Somerset','SOM'),(257,3,'Staffordshire','STA'),(258,3,'Stirlingshire','STI'),(259,3,'Suffolk','SUF'),(260,3,'Surrey','SUR'),(261,3,'Sussex','SUS'),(262,3,'Sutherland','SUT'),(263,3,'Tyne & Wear','TYN'),(264,3,'Warwickshire','WAR'),(265,3,'West Lothian','WLO'),(266,3,'Westmorland','WES'),(267,3,'Wigtownshire','WIG'),(268,3,'Wiltshire','WIL'),(269,3,'Worcestershire','WOR'),(270,3,'Yorkshire','YOR'),(271,184,'Alba','AB'),(272,184,'Arad','AR'),(273,184,'Arges','AG'),(274,184,'Bacău','BC'),(275,184,'Bihor','BH'),(276,184,'Bistrita - Nasaud Bistrita','BN'),(277,184,'Botosani','BT'),(278,184,'Brasov','BV'),(279,184,'Braila','BR'),(280,184,'Bucuresti','B'),(281,184,'Buzau','BZ'),(282,184,'Caras - Severin','CS'),(283,184,'Calarasi','CL'),(284,184,'Cluj','CJ'),(285,184,'Constanta','CT'),(286,184,'Covasna Sfantu Gheorghe','CV'),(287,184,'Dambovita','DB'),(288,184,'Dolj','DJ'),(289,184,'Galati','GL'),(290,184,'Giurgiu','GR'),(291,184,'Gorj','GJ'),(292,184,'Harghita','HR'),(293,184,'Hunedoara','HD'),(294,184,'Ialomita','IL'),(295,184,'Iasi','IS'),(296,184,'Ilfov','IF'),(297,184,'Maramures','MM'),(298,184,'Mehedinti','MH'),(299,184,'Mures','MS'),(300,184,'Neamt','NT'),(301,184,'Olt','OT'),(302,184,'Prahova Ploiesti','PH'),(303,184,'Satu Mare','SM'),(304,184,'Salaj','SJ'),(305,184,'Sibiu','SB'),(306,184,'Suceava','SV'),(307,184,'Teleorman','TR'),(308,184,'Timis','TM'),(309,184,'Tulcea','TL'),(310,184,'Vaslui','VS'),(311,184,'Valcea','VL'),(312,184,'Vrancea','VN'),(313,103,'Budapest','BUD'),(314,103,'Baranya','BAR'),(315,103,'Bács-Kiskun','BKM'),(316,103,'Békés','BEK'),(317,103,'Borsod-Abaúj-Zemplén','BAZ'),(318,103,'Csongrád','CSO'),(319,103,'Fejér','FEJ'),(320,103,'Győr-Moson-Sopron','GMS'),(321,103,'Hajdú-Bihar','HBM'),(322,103,'Heves','HEV'),(323,103,'Jász-Nagykun-Szolnok','JNS'),(324,103,'Komárom-Esztergom','KEM'),(325,103,'Nógrád','NOG'),(326,103,'Pest','PES'),(327,103,'Somogy','SOM'),(328,103,'Szabolcs-Szatmár-Bereg','SSB'),(329,103,'Tolna','TOL'),(330,103,'Vas','VAS'),(331,103,'Veszprém','VES'),(332,103,'Zala','ZAL'),(333,105,'Andhra Pradesh','AP'),(334,105,'Arunachal Pradesh','AR'),(335,105,'Assam','AS'),(336,105,'Bihar','BR'),(337,105,'Chhattisgarh','CT'),(338,105,'Goa','GA'),(339,105,'Gujarat','GJ'),(340,105,'Haryana','HR'),(341,105,'Himachal Pradesh','HP'),(342,105,'Jammu and Kashmir','JK'),(343,105,'Jharkhand','JH'),(344,105,'Karnataka','KA'),(345,105,'Kerala','KL'),(346,105,'Madhya Pradesh','MP'),(347,105,'Maharashtra','MH'),(348,105,'Manipur','MN'),(349,105,'Meghalaya','ML'),(350,105,'Mizoram','MZ'),(351,105,'Nagaland','NL'),(352,105,'Odisha','OR'),(353,105,'Punjab','PB'),(354,105,'Rajasthan','RJ'),(355,105,'Sikkim','SK'),(356,105,'Tamil Nadu','TN'),(357,105,'Telangana','TG'),(358,105,'Tripura','TR'),(359,105,'Uttarakhand','UT'),(360,105,'Uttar Pradesh','UP'),(361,105,'West Bengal','WB'),(362,105,'Andaman and Nicobar Islands','AN'),(363,105,'Chandigarh','CH'),(364,105,'Dadra and Nagar Haveli','DN'),(365,105,'Daman and Diu','DD'),(366,105,'Delhi','DL'),(367,105,'Lakshadweep','LD'),(368,105,'Puducherry','PY'),(369,78,'Auvergne-Rhône-Alpes','ARA'),(370,78,'Bourgogne-Franche-Comté','BFC'),(371,78,'Bretagne','BZH'),(372,78,'Centre–Val-de-Loire','CVL'),(373,78,'Corse','COR'),(374,78,'Guadeloupe','GP'),(375,78,'Guyane','GF'),(376,78,'Grand-Est','GE'),(377,78,'Hauts-de-France','HF'),(378,78,'Île-de-France','IDF'),(379,78,'Martinique','MQ'),(380,78,'Mayotte','YT'),(381,78,'Normandie','NOR'),(382,78,'Pays-de-la-Loire','PL'),(383,78,'Nouvelle-Aquitaine','NA'),(384,78,'Occitanie','OCC'),(385,78,'Provence-Alpes-Côte-d\'Azur','PACA'),(386,78,'Réunion','RE'),(387,161,'Northland','NTL'),(388,161,'Auckland','AUK'),(389,161,'Waikato','WKO'),(390,161,'Bay of Plenty','BOP'),(391,161,'Gisborne','GIS'),(392,161,'Hawke\'s Bay','HKB'),(393,161,'Taranaki','TKI'),(394,161,'Manawatu-Wanganui','MWT'),(395,161,'Wellington','WGN'),(396,161,'Tasman','TAS'),(397,161,'Nelson','NSN'),(398,161,'Marlborough','MBH'),(399,161,'West Coast','WTC'),(400,161,'Canterbury','CAN'),(401,161,'Otago Otago','OTA'),(402,161,'Southland','STL');
/*!40000 ALTER TABLE `rainlab_location_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_translate_attributes`
--

DROP TABLE IF EXISTS `rainlab_translate_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_translate_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attribute_data` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `rainlab_translate_attributes_locale_index` (`locale`),
  KEY `rainlab_translate_attributes_model_id_index` (`model_id`),
  KEY `rainlab_translate_attributes_model_type_index` (`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_translate_attributes`
--

LOCK TABLES `rainlab_translate_attributes` WRITE;
/*!40000 ALTER TABLE `rainlab_translate_attributes` DISABLE KEYS */;
/*!40000 ALTER TABLE `rainlab_translate_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_translate_indexes`
--

DROP TABLE IF EXISTS `rainlab_translate_indexes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_translate_indexes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `rainlab_translate_indexes_locale_index` (`locale`),
  KEY `rainlab_translate_indexes_model_id_index` (`model_id`),
  KEY `rainlab_translate_indexes_model_type_index` (`model_type`),
  KEY `rainlab_translate_indexes_item_index` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_translate_indexes`
--

LOCK TABLES `rainlab_translate_indexes` WRITE;
/*!40000 ALTER TABLE `rainlab_translate_indexes` DISABLE KEYS */;
/*!40000 ALTER TABLE `rainlab_translate_indexes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_translate_locales`
--

DROP TABLE IF EXISTS `rainlab_translate_locales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_translate_locales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rainlab_translate_locales_code_index` (`code`),
  KEY `rainlab_translate_locales_name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_translate_locales`
--

LOCK TABLES `rainlab_translate_locales` WRITE;
/*!40000 ALTER TABLE `rainlab_translate_locales` DISABLE KEYS */;
INSERT INTO `rainlab_translate_locales` VALUES (1,'en','English',1,1),(2,'es','Español',0,1);
/*!40000 ALTER TABLE `rainlab_translate_locales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_translate_messages`
--

DROP TABLE IF EXISTS `rainlab_translate_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_translate_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message_data` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `rainlab_translate_messages_code_index` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_translate_messages`
--

LOCK TABLES `rainlab_translate_messages` WRITE;
/*!40000 ALTER TABLE `rainlab_translate_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `rainlab_translate_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_user_mail_blockers`
--

DROP TABLE IF EXISTS `rainlab_user_mail_blockers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_user_mail_blockers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_user_mail_blockers_email_index` (`email`),
  KEY `rainlab_user_mail_blockers_template_index` (`template`),
  KEY `rainlab_user_mail_blockers_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_user_mail_blockers`
--

LOCK TABLES `rainlab_user_mail_blockers` WRITE;
/*!40000 ALTER TABLE `rainlab_user_mail_blockers` DISABLE KEYS */;
/*!40000 ALTER TABLE `rainlab_user_mail_blockers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci,
  `last_activity` int(11) DEFAULT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_event_logs`
--

DROP TABLE IF EXISTS `system_event_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_event_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `details` mediumtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_event_logs_level_index` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_event_logs`
--

LOCK TABLES `system_event_logs` WRITE;
/*!40000 ALTER TABLE `system_event_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_event_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_files`
--

DROP TABLE IF EXISTS `system_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `disk_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_size` int(11) NOT NULL,
  `content_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `field` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_files_field_index` (`field`),
  KEY `system_files_attachment_id_index` (`attachment_id`),
  KEY `system_files_attachment_type_index` (`attachment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_files`
--

LOCK TABLES `system_files` WRITE;
/*!40000 ALTER TABLE `system_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_mail_layouts`
--

DROP TABLE IF EXISTS `system_mail_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_mail_layouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_html` text COLLATE utf8_unicode_ci,
  `content_text` text COLLATE utf8_unicode_ci,
  `content_css` text COLLATE utf8_unicode_ci,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_mail_layouts`
--

LOCK TABLES `system_mail_layouts` WRITE;
/*!40000 ALTER TABLE `system_mail_layouts` DISABLE KEYS */;
INSERT INTO `system_mail_layouts` VALUES (1,'Default','default','<html>\n    <head>\n        <style type=\"text/css\" media=\"screen\">\n            {{ css|raw }}\n        </style>\n    </head>\n    <body>\n        {{ content|raw }}\n    </body>\n</html>','{{ content|raw }}','a, a:hover {\n    text-decoration: none;\n    color: #0862A2;\n    font-weight: bold;\n}\n\ntd, tr, th, table {\n    padding: 0px;\n    margin: 0px;\n}\n\np {\n    margin: 10px 0;\n}',1,'2017-03-12 10:50:59','2017-03-12 10:50:59'),(2,'System','system','<html>\n    <head>\n        <style type=\"text/css\" media=\"screen\">\n            {{ css|raw }}\n        </style>\n    </head>\n    <body>\n        {{ content|raw }}\n        <hr />\n        <p>This is an automatic message. Please do not reply to it.</p>\n    </body>\n</html>','{{ content|raw }}\n\n\n---\nThis is an automatic message. Please do not reply to it.','a, a:hover {\n    text-decoration: none;\n    color: #0862A2;\n    font-weight: bold;\n}\n\ntd, tr, th, table {\n    padding: 0px;\n    margin: 0px;\n}\n\np {\n    margin: 10px 0;\n}',1,'2017-03-12 10:50:59','2017-03-12 10:50:59');
/*!40000 ALTER TABLE `system_mail_layouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_mail_templates`
--

DROP TABLE IF EXISTS `system_mail_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_mail_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `content_html` text COLLATE utf8_unicode_ci,
  `content_text` text COLLATE utf8_unicode_ci,
  `layout_id` int(11) DEFAULT NULL,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_mail_templates_layout_id_index` (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_mail_templates`
--

LOCK TABLES `system_mail_templates` WRITE;
/*!40000 ALTER TABLE `system_mail_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_mail_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_parameters`
--

DROP TABLE IF EXISTS `system_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_parameters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `item_index` (`namespace`,`group`,`item`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_parameters`
--

LOCK TABLES `system_parameters` WRITE;
/*!40000 ALTER TABLE `system_parameters` DISABLE KEYS */;
INSERT INTO `system_parameters` VALUES (1,'system','update','count','0'),(2,'system','update','retry','1489402293'),(3,'system','core','hash','\"ff812962c9de7932015f2f6620d2ca3b\"'),(4,'system','core','build','\"396\"');
/*!40000 ALTER TABLE `system_parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_plugin_history`
--

DROP TABLE IF EXISTS `system_plugin_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_plugin_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_plugin_history_code_index` (`code`),
  KEY `system_plugin_history_type_index` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_plugin_history`
--

LOCK TABLES `system_plugin_history` WRITE;
/*!40000 ALTER TABLE `system_plugin_history` DISABLE KEYS */;
INSERT INTO `system_plugin_history` VALUES (1,'October.Demo','comment','1.0.1','First version of Demo','2017-03-12 10:50:58'),(2,'RainLab.User','script','1.0.1','create_users_table.php','2017-03-12 11:01:41'),(3,'RainLab.User','script','1.0.1','create_throttle_table.php','2017-03-12 11:01:41'),(4,'RainLab.User','comment','1.0.1','Initialize plugin.','2017-03-12 11:01:41'),(5,'RainLab.User','comment','1.0.2','Seed tables.','2017-03-12 11:01:41'),(6,'RainLab.User','comment','1.0.3','Translated hard-coded text to language strings.','2017-03-12 11:01:41'),(7,'RainLab.User','comment','1.0.4','Improvements to user-interface for Location manager.','2017-03-12 11:01:41'),(8,'RainLab.User','comment','1.0.5','Added contact details for users.','2017-03-12 11:01:41'),(9,'RainLab.User','script','1.0.6','create_mail_blockers_table.php','2017-03-12 11:01:41'),(10,'RainLab.User','comment','1.0.6','Added Mail Blocker utility so users can block specific mail templates.','2017-03-12 11:01:41'),(11,'RainLab.User','comment','1.0.7','Add back-end Settings page.','2017-03-12 11:01:41'),(12,'RainLab.User','comment','1.0.8','Updated the Settings page.','2017-03-12 11:01:41'),(13,'RainLab.User','comment','1.0.9','Adds new welcome mail message for users and administrators.','2017-03-12 11:01:41'),(14,'RainLab.User','comment','1.0.10','Adds administrator-only activation mode.','2017-03-12 11:01:41'),(15,'RainLab.User','script','1.0.11','users_add_login_column.php','2017-03-12 11:01:41'),(16,'RainLab.User','comment','1.0.11','Users now have an optional login field that defaults to the email field.','2017-03-12 11:01:41'),(17,'RainLab.User','script','1.0.12','users_rename_login_to_username.php','2017-03-12 11:01:42'),(18,'RainLab.User','comment','1.0.12','Create a dedicated setting for choosing the login mode.','2017-03-12 11:01:42'),(19,'RainLab.User','comment','1.0.13','Minor fix to the Account sign in logic.','2017-03-12 11:01:42'),(20,'RainLab.User','comment','1.0.14','Minor improvements to the code.','2017-03-12 11:01:42'),(21,'RainLab.User','script','1.0.15','users_add_surname.php','2017-03-12 11:01:42'),(22,'RainLab.User','comment','1.0.15','Adds last name column to users table (surname).','2017-03-12 11:01:42'),(23,'RainLab.User','comment','1.0.16','Require permissions for settings page too.','2017-03-12 11:01:42'),(24,'RainLab.User','comment','1.1.0','!!! Profile fields and Locations have been removed.','2017-03-12 11:01:42'),(25,'RainLab.User','script','1.1.1','create_user_groups_table.php','2017-03-12 11:01:42'),(26,'RainLab.User','script','1.1.1','seed_user_groups_table.php','2017-03-12 11:01:42'),(27,'RainLab.User','comment','1.1.1','Users can now be added to groups.','2017-03-12 11:01:42'),(28,'RainLab.User','comment','1.1.2','A raw URL can now be passed as the redirect property in the Account component.','2017-03-12 11:01:42'),(29,'RainLab.User','comment','1.1.3','Adds a super user flag to the users table, reserved for future use.','2017-03-12 11:01:42'),(30,'RainLab.User','comment','1.1.4','User list can be filtered by the group they belong to.','2017-03-12 11:01:42'),(31,'RainLab.User','comment','1.1.5','Adds a new permission to hide the User settings menu item.','2017-03-12 11:01:42'),(32,'RainLab.User','script','1.2.0','users_add_deleted_at.php','2017-03-12 11:01:42'),(33,'RainLab.User','comment','1.2.0','Users can now deactivate their own accounts.','2017-03-12 11:01:42'),(34,'RainLab.User','comment','1.2.1','New feature for checking if a user is recently active/online.','2017-03-12 11:01:42'),(35,'RainLab.User','comment','1.2.2','Add bulk action button to user list.','2017-03-12 11:01:42'),(36,'RainLab.User','comment','1.2.3','Included some descriptive paragraphs in the Reset Password component markup.','2017-03-12 11:01:42'),(37,'RainLab.User','comment','1.2.4','Added a checkbox for blocking all mail sent to the user.','2017-03-12 11:01:42'),(38,'RainLab.User','script','1.2.5','update_timestamp_nullable.php','2017-03-12 11:01:43'),(39,'RainLab.User','comment','1.2.5','Database maintenance. Updated all timestamp columns to be nullable.','2017-03-12 11:01:43'),(40,'RainLab.User','script','1.2.6','users_add_last_seen.php','2017-03-12 11:01:43'),(41,'RainLab.User','comment','1.2.6','Add a dedicated last seen column for users.','2017-03-12 11:01:43'),(42,'RainLab.User','comment','1.2.7','Minor fix to user timestamp attributes.','2017-03-12 11:01:43'),(43,'RainLab.User','comment','1.2.8','Add date range filter to users list. Introduced a logout event.','2017-03-12 11:01:43'),(44,'RainLab.User','comment','1.2.9','Add invitation mail for new accounts created in the back-end.','2017-03-12 11:01:43'),(45,'RainLab.User','script','1.3.0','users_add_guest_flag.php','2017-03-12 11:01:43'),(46,'RainLab.User','script','1.3.0','users_add_superuser_flag.php','2017-03-12 11:01:43'),(47,'RainLab.User','comment','1.3.0','Introduced guest user accounts.','2017-03-12 11:01:43'),(48,'RainLab.User','comment','1.3.1','User notification variables can now be extended.','2017-03-12 11:01:43'),(49,'RainLab.User','comment','1.3.2','Minor fix to the Auth::register method.','2017-03-12 11:01:43'),(50,'RainLab.User','comment','1.3.3','Allow prevention of concurrent user sessions via the user settings.','2017-03-12 11:01:43'),(51,'RainLab.User','comment','1.3.4','Added force secure protocol property to the account component.','2017-03-12 11:01:43'),(52,'RainLab.Location','comment','1.0.1','Initialize plugin.','2017-03-12 11:02:22'),(53,'RainLab.Location','script','1.0.2','create_states_table.php','2017-03-12 11:02:23'),(54,'RainLab.Location','script','1.0.2','create_countries_table.php','2017-03-12 11:02:23'),(55,'RainLab.Location','comment','1.0.2','Create database tables.','2017-03-12 11:02:23'),(56,'RainLab.Location','script','1.0.3','seed_all_tables.php','2017-03-12 11:02:24'),(57,'RainLab.Location','comment','1.0.3','Add seed data for countries and states.','2017-03-12 11:02:24'),(58,'RainLab.Location','comment','1.0.4','Satisfy the new Google API key requirement.','2017-03-12 11:02:24'),(59,'RainLab.Location','script','1.0.5','add_country_pinned_flag.php','2017-03-12 11:02:24'),(60,'RainLab.Location','comment','1.0.5','Countries can now be pinned to make them appear at the top of the list.','2017-03-12 11:02:24'),(61,'RainLab.Location','comment','1.0.6','Added support for defining a default country and state.','2017-03-12 11:02:24'),(62,'RainLab.Location','comment','1.0.7','Added basic geocoding method to the Country model.','2017-03-12 11:02:24'),(63,'RainLab.Translate','script','1.0.1','create_messages_table.php','2017-03-12 11:03:05'),(64,'RainLab.Translate','script','1.0.1','create_attributes_table.php','2017-03-12 11:03:05'),(65,'RainLab.Translate','script','1.0.1','create_locales_table.php','2017-03-12 11:03:05'),(66,'RainLab.Translate','script','1.0.1','seed_all_tables.php','2017-03-12 11:03:05'),(67,'RainLab.Translate','comment','1.0.1','First version of Translate','2017-03-12 11:03:05'),(68,'RainLab.Translate','comment','1.0.2','Languages and Messages can now be deleted.','2017-03-12 11:03:05'),(69,'RainLab.Translate','comment','1.0.3','Minor updates for latest October release.','2017-03-12 11:03:05'),(70,'RainLab.Translate','comment','1.0.4','Locale cache will clear when updating a language.','2017-03-12 11:03:05'),(71,'RainLab.Translate','comment','1.0.5','Add Spanish language and fix plugin config.','2017-03-12 11:03:05'),(72,'RainLab.Translate','comment','1.0.6','Minor improvements to the code.','2017-03-12 11:03:05'),(73,'RainLab.Translate','comment','1.0.7','Fixes major bug where translations are skipped entirely!','2017-03-12 11:03:05'),(74,'RainLab.Translate','comment','1.0.8','Minor bug fixes.','2017-03-12 11:03:05'),(75,'RainLab.Translate','comment','1.0.9','Fixes an issue where newly created models lose their translated values.','2017-03-12 11:03:05'),(76,'RainLab.Translate','comment','1.0.10','Minor fix for latest build.','2017-03-12 11:03:05'),(77,'RainLab.Translate','comment','1.0.11','Fix multilingual rich editor when used in stretch mode.','2017-03-12 11:03:05'),(78,'RainLab.Translate','comment','1.1.0','Introduce compatibility with RainLab.Pages plugin.','2017-03-12 11:03:05'),(79,'RainLab.Translate','comment','1.1.1','Minor UI fix to the language picker.','2017-03-12 11:03:05'),(80,'RainLab.Translate','comment','1.1.2','Add support for translating Static Content files.','2017-03-12 11:03:05'),(81,'RainLab.Translate','comment','1.1.3','Improved support for the multilingual rich editor.','2017-03-12 11:03:05'),(82,'RainLab.Translate','comment','1.1.4','Adds new multilingual markdown editor.','2017-03-12 11:03:05'),(83,'RainLab.Translate','comment','1.1.5','Minor update to the multilingual control API.','2017-03-12 11:03:05'),(84,'RainLab.Translate','comment','1.1.6','Minor improvements in the message editor.','2017-03-12 11:03:05'),(85,'RainLab.Translate','comment','1.1.7','Fixes bug not showing content when first loading multilingual textarea controls.','2017-03-12 11:03:05'),(86,'RainLab.Translate','comment','1.2.0','CMS pages now support translating the URL.','2017-03-12 11:03:05'),(87,'RainLab.Translate','comment','1.2.1','Minor update in the rich editor and code editor language control position.','2017-03-12 11:03:05'),(88,'RainLab.Translate','comment','1.2.2','Static Pages now support translating the URL.','2017-03-12 11:03:05'),(89,'RainLab.Translate','comment','1.2.3','Fixes Rich Editor when inserting a page link.','2017-03-12 11:03:05'),(90,'RainLab.Translate','script','1.2.4','create_indexes_table.php','2017-03-12 11:03:05'),(91,'RainLab.Translate','comment','1.2.4','Translatable attributes can now be declared as indexes.','2017-03-12 11:03:05'),(92,'RainLab.Translate','comment','1.2.5','Adds new multilingual repeater form widget.','2017-03-12 11:03:05'),(93,'RainLab.Translate','comment','1.2.6','Fixes repeater usage with static pages plugin.','2017-03-12 11:03:05'),(94,'RainLab.Translate','comment','1.2.7','Fixes placeholder usage with static pages plugin.','2017-03-12 11:03:05'),(95,'RainLab.Translate','comment','1.2.8','Improvements to code for latest October build compatibility.','2017-03-12 11:03:05'),(96,'RainLab.Translate','comment','1.2.9','Fixes context for translated strings when used with Static Pages.','2017-03-12 11:03:05'),(97,'RainLab.Translate','comment','1.2.10','Minor UI fix to the multilingual repeater.','2017-03-12 11:03:05');
/*!40000 ALTER TABLE `system_plugin_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_plugin_versions`
--

DROP TABLE IF EXISTS `system_plugin_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_plugin_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `is_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_frozen` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `system_plugin_versions_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_plugin_versions`
--

LOCK TABLES `system_plugin_versions` WRITE;
/*!40000 ALTER TABLE `system_plugin_versions` DISABLE KEYS */;
INSERT INTO `system_plugin_versions` VALUES (1,'October.Demo','1.0.1','2017-03-12 10:50:58',0,0),(2,'RainLab.User','1.3.4','2017-03-12 11:01:43',0,0),(3,'RainLab.Location','1.0.7','2017-03-12 11:02:24',0,0),(4,'RainLab.Translate','1.2.10','2017-03-12 11:03:05',0,0);
/*!40000 ALTER TABLE `system_plugin_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_request_logs`
--

DROP TABLE IF EXISTS `system_request_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_request_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status_code` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `referer` text COLLATE utf8_unicode_ci,
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_request_logs`
--

LOCK TABLES `system_request_logs` WRITE;
/*!40000 ALTER TABLE `system_request_logs` DISABLE KEYS */;
INSERT INTO `system_request_logs` VALUES (1,404,'http://192.168.33.10/favicon.ico','[\"http:\\/\\/192.168.33.10\\/backend\\/backend\\/auth\\/signin\"]',1,'2017-03-12 10:51:22','2017-03-12 10:51:22');
/*!40000 ALTER TABLE `system_request_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_revisions`
--

DROP TABLE IF EXISTS `system_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cast` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `old_value` text COLLATE utf8_unicode_ci,
  `new_value` text COLLATE utf8_unicode_ci,
  `revisionable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `revisionable_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `system_revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`),
  KEY `system_revisions_user_id_index` (`user_id`),
  KEY `system_revisions_field_index` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_revisions`
--

LOCK TABLES `system_revisions` WRITE;
/*!40000 ALTER TABLE `system_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `system_settings_item_index` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_groups_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Guest','guest','Default group for guest users.','2017-03-12 11:01:42','2017-03-12 11:01:42'),(2,'Registered','registered','Default group for registered users.','2017-03-12 11:01:42','2017-03-12 11:01:42');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_throttle`
--

DROP TABLE IF EXISTS `user_throttle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_throttle_user_id_index` (`user_id`),
  KEY `user_throttle_ip_address_index` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_throttle`
--

LOCK TABLES `user_throttle` WRITE;
/*!40000 ALTER TABLE `user_throttle` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_throttle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `is_guest` tinyint(1) NOT NULL DEFAULT '0',
  `is_superuser` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_login_unique` (`username`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`),
  KEY `users_login_index` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `user_id` int(10) unsigned NOT NULL,
  `user_group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-12 11:18:00
