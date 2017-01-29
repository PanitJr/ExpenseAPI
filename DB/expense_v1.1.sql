-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

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
-- Table structure for table `cc_documentapproves`
--

DROP TABLE IF EXISTS `cc_documentapproves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_documentapproves` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_documentapproves`
--

LOCK TABLES `cc_documentapproves` WRITE;
/*!40000 ALTER TABLE `cc_documentapproves` DISABLE KEYS */;
/*!40000 ALTER TABLE `cc_documentapproves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_documentgenerate`
--

DROP TABLE IF EXISTS `cc_documentgenerate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_documentgenerate` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_documentgenerate`
--

LOCK TABLES `cc_documentgenerate` WRITE;
/*!40000 ALTER TABLE `cc_documentgenerate` DISABLE KEYS */;
INSERT INTO `cc_documentgenerate` VALUES (8,'test');
/*!40000 ALTER TABLE `cc_documentgenerate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_documents`
--

DROP TABLE IF EXISTS `cc_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_documents` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` int(11) NOT NULL,
  `submit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_documents`
--

LOCK TABLES `cc_documents` WRITE;
/*!40000 ALTER TABLE `cc_documents` DISABLE KEYS */;
INSERT INTO `cc_documents` VALUES (7,'กข-122','http://localhost:3001/Doc/file/7/7.docx',6,'');
/*!40000 ALTER TABLE `cc_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_documenttemplates`
--

DROP TABLE IF EXISTS `cc_documenttemplates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_documenttemplates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_template` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_documenttemplates`
--

LOCK TABLES `cc_documenttemplates` WRITE;
/*!40000 ALTER TABLE `cc_documenttemplates` DISABLE KEYS */;
INSERT INTO `cc_documenttemplates` VALUES (6,'test demo','http://localhost:3001/Doc/file/6/6.docx');
/*!40000 ALTER TABLE `cc_documenttemplates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_expenses`
--

DROP TABLE IF EXISTS `cc_expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_expenses` (
  `id` int(11) NOT NULL,
  `expensename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `supervisor_approve` tinyint(1) NOT NULL,
  `admin_approve` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `opportunity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_expenses`
--

LOCK TABLES `cc_expenses` WRITE;
/*!40000 ALTER TABLE `cc_expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `cc_expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_items`
--

DROP TABLE IF EXISTS `cc_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_items` (
  `id` int(11) NOT NULL,
  `itemname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opportunity` int(11) NOT NULL,
  `cost` decimal(8,2) NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `date` date NOT NULL,
  `expense_id` int(11) NOT NULL,
  `subtype` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_items`
--

LOCK TABLES `cc_items` WRITE;
/*!40000 ALTER TABLE `cc_items` DISABLE KEYS */;
INSERT INTO `cc_items` VALUES (31,'Pnit01','1',24,20.00,'dasda','',1,'0000-00-00',0,1,0);
/*!40000 ALTER TABLE `cc_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_leaves`
--

DROP TABLE IF EXISTS `cc_leaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_leaves` (
  `id` int(11) NOT NULL,
  `leavename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `start_time` time NOT NULL,
  `attchment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_leaves`
--

LOCK TABLES `cc_leaves` WRITE;
/*!40000 ALTER TABLE `cc_leaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `cc_leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cc_opportunitys`
--

DROP TABLE IF EXISTS `cc_opportunitys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cc_opportunitys` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cc_opportunitys`
--

LOCK TABLES `cc_opportunitys` WRITE;
/*!40000 ALTER TABLE `cc_opportunitys` DISABLE KEYS */;
INSERT INTO `cc_opportunitys` VALUES (24,'MQDC',1),(25,'SLC',1),(26,'SMPH',1);
/*!40000 ALTER TABLE `cc_opportunitys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customview`
--

DROP TABLE IF EXISTS `customview`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customview` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `viewname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setdefault` tinyint(1) NOT NULL,
  `objectid` int(10) unsigned NOT NULL,
  `userid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customview_objectid_foreign` (`objectid`),
  CONSTRAINT `customview_objectid_foreign` FOREIGN KEY (`objectid`) REFERENCES `objects_model` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customview`
--

LOCK TABLES `customview` WRITE;
/*!40000 ALTER TABLE `customview` DISABLE KEYS */;
INSERT INTO `customview` VALUES (1,'All',1,1,NULL),(2,'All',1,2,NULL),(3,'All',1,3,NULL),(4,'All',1,4,NULL),(5,'All',1,6,NULL),(6,'All',1,7,NULL),(7,'All',1,8,NULL),(8,'All',1,9,NULL),(9,'All',1,10,NULL),(10,'All',1,11,NULL);
/*!40000 ALTER TABLE `customview` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customview_columnslist`
--

DROP TABLE IF EXISTS `customview_columnslist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customview_columnslist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cvid` int(10) unsigned NOT NULL,
  `columnindex` int(11) NOT NULL,
  `columnname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customview_columnslist_cvid_foreign` (`cvid`),
  CONSTRAINT `customview_columnslist_cvid_foreign` FOREIGN KEY (`cvid`) REFERENCES `customview` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customview_columnslist`
--

LOCK TABLES `customview_columnslist` WRITE;
/*!40000 ALTER TABLE `customview_columnslist` DISABLE KEYS */;
INSERT INTO `customview_columnslist` VALUES (1,1,0,'code'),(2,2,0,'name'),(3,3,0,'code'),(4,4,0,'name'),(5,5,0,'profilename'),(6,6,0,'name'),(7,7,0,'itemname'),(8,8,0,'expensename'),(9,9,0,'leavename'),(10,10,0,'name');
/*!40000 ALTER TABLE `customview_columnslist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entitys`
--

DROP TABLE IF EXISTS `entitys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entitys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) NOT NULL,
  `createid` int(11) NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entitys`
--

LOCK TABLES `entitys` WRITE;
/*!40000 ALTER TABLE `entitys` DISABLE KEYS */;
INSERT INTO `entitys` VALUES (1,1,1,9,'2016-12-20 17:00:00','2017-01-28 09:55:50',0,'ERPS DEMO'),(2,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,'profile'),(3,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,'profile'),(4,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,' role'),(5,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,' role'),(6,1,1,1,'2016-11-09 04:54:16','2016-11-09 04:54:16',0,'test demo'),(7,1,1,1,'2016-11-09 06:03:44','2016-11-09 06:03:44',0,'กข-122'),(8,1,1,1,'2016-12-19 02:01:28','2016-12-19 02:01:28',0,'test'),(9,1,1,9,'2016-12-24 05:41:51','2017-01-28 09:51:08',0,'Panit Jaijaroen'),(10,1,1,0,'2016-12-24 06:25:20','2016-12-24 06:25:20',0,' '),(11,1,1,0,'2016-12-24 06:31:54','2016-12-24 06:31:54',0,' '),(12,1,1,0,'2017-01-10 04:55:26','2017-01-10 04:55:26',0,' '),(13,1,1,0,'2017-01-10 04:58:20','2017-01-10 04:58:20',0,' '),(14,1,1,0,'2017-01-10 05:00:21','2017-01-10 05:00:21',0,' '),(15,9,9,9,'2017-01-25 08:18:15','2017-01-28 09:54:55',0,'Pai PaiPai'),(16,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,' '),(19,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,' role'),(20,9,9,9,'2017-01-25 08:21:22','2017-01-25 08:21:23',0,'profile'),(23,9,9,9,'2017-01-28 16:42:35','2017-01-28 16:42:35',0,'test test'),(24,9,9,9,'2017-01-28 19:38:17','2017-01-28 19:38:18',0,'Opportunity'),(25,9,9,9,'2017-01-28 19:38:30','2017-01-28 19:38:30',0,'Opportunity'),(26,9,9,9,'2017-01-28 19:38:38','2017-01-28 19:38:39',0,'Opportunity'),(31,9,9,9,'2017-01-29 13:27:35','2017-01-29 13:27:35',0,'Item');
/*!40000 ALTER TABLE `entitys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_category`
--

DROP TABLE IF EXISTS `item_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_category`
--

LOCK TABLES `item_category` WRITE;
/*!40000 ALTER TABLE `item_category` DISABLE KEYS */;
INSERT INTO `item_category` VALUES (1,'Travel'),(2,'Service'),(3,'Medical'),(4,'Other');
/*!40000 ALTER TABLE `item_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicals`
--

DROP TABLE IF EXISTS `medicals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicals` (
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicals`
--

LOCK TABLES `medicals` WRITE;
/*!40000 ALTER TABLE `medicals` DISABLE KEYS */;
/*!40000 ALTER TABLE `medicals` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_03_07_041713_update_user_table',1),('2016_03_08_090353_CreateTableRoles',1),('2016_03_08_090615_CreateTableUserRoles',1),('2016_03_09_072632_CreaetTebleObjectModule',1),('2016_03_10_035203_UpdateFieldObjetModelToUnique',1),('2016_03_11_022212_CreateTableField',1),('2016_03_11_024004_CreateTableBlock',1),('2016_03_11_052219_UpdateBlockInObjectField',1),('2016_03_11_090721_CreateEntityTable',1),('2016_03_14_135241_CreateAccountObject',1),('2016_03_16_064158_createprofile',1),('2016_03_16_064739_CreateCustomView',1),('2016_04_21_040407_UpdateObjectFieldForFieldType',2),('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_03_07_041713_update_user_table',1),('2016_03_08_090353_CreateTableRoles',1),('2016_03_08_090615_CreateTableUserRoles',1),('2016_03_09_072632_CreaetTebleObjectModule',1),('2016_03_10_035203_UpdateFieldObjetModelToUnique',1),('2016_03_11_022212_CreateTableField',1),('2016_03_11_024004_CreateTableBlock',1),('2016_03_11_052219_UpdateBlockInObjectField',1),('2016_03_11_090721_CreateEntityTable',1),('2016_03_14_135241_CreateAccountObject',1),('2016_03_16_064158_createprofile',1),('2016_03_16_064739_CreateCustomView',1),('2016_04_21_040407_UpdateObjectFieldForFieldType',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object_block`
--

DROP TABLE IF EXISTS `object_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_block` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `objectid` int(10) unsigned NOT NULL,
  `blocklabel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `object_block_objectid_foreign` (`objectid`),
  CONSTRAINT `object_block_objectid_foreign` FOREIGN KEY (`objectid`) REFERENCES `objects_model` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object_block`
--

LOCK TABLES `object_block` WRITE;
/*!40000 ALTER TABLE `object_block` DISABLE KEYS */;
INSERT INTO `object_block` VALUES (1,1,'Document Information',1),(2,2,'DocumentTemplate Information',1),(3,3,'DocumentApprove Information',1),(4,4,'DocumentManager Information',1),(5,5,'User Manager',1),(6,6,'Profile Information',1),(7,7,'role Information',1),(8,8,'Item Information',1),(9,9,'Expense Information',1),(10,10,'Leave Information',1),(11,6,'Profile Permission',2),(12,11,'Opportunity Information',1);
/*!40000 ALTER TABLE `object_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object_field`
--

DROP TABLE IF EXISTS `object_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `objectid` int(10) unsigned NOT NULL,
  `fieldname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fieldlabel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `blockid` int(10) unsigned DEFAULT NULL,
  `type` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `object_field_objectid_foreign` (`objectid`),
  KEY `object_field_blockid_index` (`blockid`),
  KEY `object_field_type_index` (`type`),
  CONSTRAINT `object_field_blockid_foreign` FOREIGN KEY (`blockid`) REFERENCES `object_block` (`id`) ON DELETE SET NULL,
  CONSTRAINT `object_field_objectid_foreign` FOREIGN KEY (`objectid`) REFERENCES `objects_model` (`id`) ON DELETE CASCADE,
  CONSTRAINT `object_field_type_foreign` FOREIGN KEY (`type`) REFERENCES `object_field_type` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object_field`
--

LOCK TABLES `object_field` WRITE;
/*!40000 ALTER TABLE `object_field` DISABLE KEYS */;
INSERT INTO `object_field` VALUES (1,1,'code','Code',1,1,NULL),(2,2,'name','Name',1,2,NULL),(3,3,'code','code',1,3,NULL),(4,2,'file_template','File Template',2,2,NULL),(5,1,'file','file',2,1,NULL),(6,1,'template','temaplte',3,1,NULL),(7,1,'template','template',4,1,NULL),(8,1,'submit','submit',5,1,NULL),(9,4,'name','Name',1,4,NULL),(10,5,'email','Email',2,5,4),(11,5,'user_name','Username',1,5,4),(12,5,'firstname','First Name',5,5,4),(13,5,'lastname','Last Name',6,5,4),(16,6,'profilename','profilename',1,6,NULL),(17,6,'description','Description',2,6,NULL),(18,7,'name','name',1,7,NULL),(19,7,'role_description','Role Description',2,7,NULL),(20,7,'parent_role','Parent Role',3,7,NULL),(21,5,'role_id','Role',7,5,5),(22,8,'itemname','item_name',1,8,NULL),(23,9,'expensename','expense_name',1,9,NULL),(24,10,'leavename','leave_name',1,10,NULL),(25,5,'supervisor_id','supervisor',8,5,5),(26,8,'category','category',2,8,5),(27,8,'opportunity','opportunity',3,8,5),(28,8,'cost','cost',4,8,NULL),(29,8,'description','description',5,8,NULL),(30,8,'attachment','attachment',6,8,NULL),(31,8,'status','status',7,8,NULL),(32,8,'date','date',8,8,NULL),(33,8,'expense_id','expense_id',9,8,NULL),(34,9,'category','category',2,9,NULL),(37,9,'total_price','total_price',4,9,NULL),(38,9,'supervisor_approve','supervisor_approve',5,9,NULL),(39,9,'admin_approve','admin_approve',6,9,NULL),(40,9,'user_id','user_id',7,9,NULL),(41,9,'status','status',8,9,NULL),(42,9,'opportunity','opportunity',9,9,NULL),(43,9,'user_id','user_id',10,9,NULL),(44,10,'user_id','user_id',2,10,NULL),(45,10,'type','type',3,10,NULL),(46,10,'start_date','start_date',4,10,NULL),(47,10,'end_date','end_date',5,10,NULL),(48,10,'end_time','end_time',6,10,NULL),(49,10,'start_time','start_time',7,10,NULL),(50,10,'attchment','attachment',8,10,NULL),(51,10,'description','description',9,10,NULL),(52,10,'description','description',10,10,NULL),(53,5,'status','status',9,5,5),(54,11,'name','name',1,12,NULL),(55,11,'active','active',2,12,NULL),(56,8,'subtype','subtype',10,8,5),(57,8,'type','type',11,8,5);
/*!40000 ALTER TABLE `object_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object_field_type`
--

DROP TABLE IF EXISTS `object_field_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_field_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fieldtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object_field_type`
--

LOCK TABLES `object_field_type` WRITE;
/*!40000 ALTER TABLE `object_field_type` DISABLE KEYS */;
INSERT INTO `object_field_type` VALUES (1,'reference'),(2,'image'),(3,'password'),(4,'text'),(5,'picklist');
/*!40000 ALTER TABLE `object_field_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects_model`
--

DROP TABLE IF EXISTS `objects_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects_model` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tablename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fieldname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'extension',
  `objsequence` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `objects_model_name_unique` (`name`),
  KEY `objsequence` (`objsequence`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects_model`
--

LOCK TABLES `objects_model` WRITE;
/*!40000 ALTER TABLE `objects_model` DISABLE KEYS */;
INSERT INTO `objects_model` VALUES (1,'Document','cc_documents','code','Document','description',3),(2,'DocumentTemplate','cc_documenttemplates','name','Doc Template','library_books',2),(3,'DocumentApprove','cc_documentapproves','code','Doc Approve','verified_user',4),(4,'DocumentGenerate','cc_documentgenerate','name','Doc Generate','art_track',1),(5,'Users','users','email','Users','people',6),(6,'Profiles','profiles','profilename','Profiles','extension',0),(7,'Role','roles','name','Role','extension',0),(8,'Item','cc_items','itemname','Item','extension',0),(9,'Expense','cc_expenses','expensename','Expense','extension',0),(10,'Leave','cc_leaves','leavename','Leave','extension',0),(11,'Opportunity','cc_opportunitys','name','Opportunity','extension',0);
/*!40000 ALTER TABLE `objects_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `others`
--

DROP TABLE IF EXISTS `others`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `others` (
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `others`
--

LOCK TABLES `others` WRITE;
/*!40000 ALTER TABLE `others` DISABLE KEYS */;
/*!40000 ALTER TABLE `others` ENABLE KEYS */;
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `objectid` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,4,'view','View Record Object'),(2,4,'edit','Add/Edit Record Object'),(3,4,'delete','Delete Record Object'),(4,2,'view','View Record Object'),(5,2,'edit','Add/Edit Record Object'),(6,2,'delete','Delete Record Object'),(7,1,'view','View Record Object'),(8,1,'edit','Add/Edit Record Object'),(9,1,'delete','Delete Record Object'),(10,3,'view','View Record Object'),(11,3,'edit','Add/Edit Record Object'),(12,3,'delete','Delete Record Object'),(13,8,'view','View Record Item'),(14,8,'edit','Edit Record Object'),(15,8,'delete','delete Record item'),(16,8,'create','create Record Object'),(17,9,'view','view Record Object'),(18,9,'edit','Edit Record Object'),(19,9,'delete','delete Record Object'),(20,9,'create','create Record Object'),(21,10,'view','view Record Object'),(22,10,'create','create Record Object'),(23,5,'view','view user'),(24,5,'edit','edit user'),(25,5,'create','create user'),(26,5,'delete','delete user'),(27,6,'view','view profiles'),(28,6,'edit','edit profiles'),(29,6,'create','create profiles'),(30,6,'delete','delete profiles'),(31,7,'view','view roles'),(32,7,'edit','edit roles'),(33,7,'create','create roles'),(34,7,'delete','delete roles');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_object`
--

DROP TABLE IF EXISTS `profile_object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_object` (
  `profile_id` int(10) NOT NULL,
  `object_id` int(10) NOT NULL,
  KEY `profile_id` (`profile_id`),
  KEY `object_id` (`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_object`
--

LOCK TABLES `profile_object` WRITE;
/*!40000 ALTER TABLE `profile_object` DISABLE KEYS */;
INSERT INTO `profile_object` VALUES (1,1),(1,2);
/*!40000 ALTER TABLE `profile_object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_object_field_permission`
--

DROP TABLE IF EXISTS `profile_object_field_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_object_field_permission` (
  `profile_id` int(10) NOT NULL,
  `object_id` int(10) NOT NULL,
  `field_id` int(10) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_object_field_permission`
--

LOCK TABLES `profile_object_field_permission` WRITE;
/*!40000 ALTER TABLE `profile_object_field_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `profile_object_field_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_object_permission`
--

DROP TABLE IF EXISTS `profile_object_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_object_permission` (
  `profile_id` int(10) NOT NULL,
  `object_id` int(10) NOT NULL,
  `permission_id` int(10) NOT NULL,
  UNIQUE KEY `profile_id_2` (`profile_id`,`object_id`,`permission_id`),
  KEY `profile_id` (`profile_id`),
  KEY `object_id` (`object_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_object_permission`
--

LOCK TABLES `profile_object_permission` WRITE;
/*!40000 ALTER TABLE `profile_object_permission` DISABLE KEYS */;
INSERT INTO `profile_object_permission` VALUES (2,5,23),(2,5,24),(2,5,25),(2,5,26),(2,6,27),(2,6,28),(2,6,29),(2,6,30),(2,7,31),(2,7,32),(2,7,33),(2,7,34),(2,8,13),(2,8,14),(2,8,15),(2,8,16),(2,9,17),(2,9,18),(2,9,19),(2,9,20),(2,10,21),(2,10,22),(3,5,23),(3,5,24),(3,8,13),(3,8,14),(3,8,15),(3,8,16),(3,9,17),(3,9,18),(3,9,20),(3,10,21),(3,10,22),(20,5,23),(20,5,24),(20,8,13),(20,8,14),(20,8,15),(20,8,16),(20,9,17),(20,9,20),(20,10,21),(20,10,22);
/*!40000 ALTER TABLE `profile_object_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profilename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (2,'Admin','Admin'),(3,'Supervisor','Supervisor\n'),(20,'Emmployee','Emmployee');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_description` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_role` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (4,'Admin','System Admininstator',4),(5,'Supervisor','Supervisor is a head of department',4),(19,'Employees','Employees of company',5);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travel_sub_type`
--

DROP TABLE IF EXISTS `travel_sub_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `travel_sub_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travel_sub_type`
--

LOCK TABLES `travel_sub_type` WRITE;
/*!40000 ALTER TABLE `travel_sub_type` DISABLE KEYS */;
INSERT INTO `travel_sub_type` VALUES (1,'BTS'),(2,'MRT');
/*!40000 ALTER TABLE `travel_sub_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travel_type`
--

DROP TABLE IF EXISTS `travel_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `travel_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travel_type`
--

LOCK TABLES `travel_type` WRITE;
/*!40000 ALTER TABLE `travel_type` DISABLE KEYS */;
INSERT INTO `travel_type` VALUES (1,'Public Transport'),(2,'Private Transport');
/*!40000 ALTER TABLE `travel_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travels`
--

DROP TABLE IF EXISTS `travels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `travels` (
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travels`
--

LOCK TABLES `travels` WRITE;
/*!40000 ALTER TABLE `travels` DISABLE KEYS */;
INSERT INTO `travels` VALUES (31);
/*!40000 ALTER TABLE `travels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profile` (
  `user_id` int(10) NOT NULL,
  `profile_id` int(10) NOT NULL,
  UNIQUE KEY `user_id_2` (`user_id`,`profile_id`),
  KEY `user_id` (`user_id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,2),(9,2),(14,3),(15,20),(16,20),(23,20);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_status`
--

DROP TABLE IF EXISTS `user_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_status`
--

LOCK TABLES `user_status` WRITE;
/*!40000 ALTER TABLE `user_status` DISABLE KEYS */;
INSERT INTO `user_status` VALUES (1,'active'),(2,'inactive');
/*!40000 ALTER TABLE `user_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `confirm_password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` int(10) NOT NULL,
  `role_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'erp','erp@mail.com','$2y$10$zrZFgE9KbbyN0iOBvMlFruatr0WZOuEMrl0UTQcUaoO0rEkndcqEO','','boQNvyC7AtzLVifmOG0WXXfwUnhnbdPnaw1PLO7W4Op5JkF7VGqvUgWaoRq7',NULL,'2016-12-16 13:04:46','ERPS','DEMO',0,4,1,1),(9,'panit@crm-c.club','panit@crm-c.club','$2y$10$1jzXOjLF9OjNm9ZwSodv/.n60f9wtw7drBk51vzefjgabFUBgJp0G','','fL2JV8IyLzvV13TTmAkGNG2RY3CpufMjRFQQgo38fzdMQqVOgDyrRzckAhYx',NULL,'2016-12-24 07:25:25','Panit','Jaijaroen',0,4,1,2),(14,'waitingforthen@gmail.com','waitingforthen@gmail.com','$2y$10$u2t80cORxdCrFpk2Pq1Blu5eh7bwJOniF2bkywecvc.DGiG6Qp2fK','','Ruc8K14mxHuUfRbywWF1Z1PtARCIImvhW0chg5fGLvpHSGebgYGZhV803ylg',NULL,'2017-01-10 05:05:48','พณิช','ใจเจริญ',0,5,9,0),(15,'chanakan@crm-c.club','chanakan@crm-c.club','','',NULL,NULL,NULL,'Pai','PaiPai',0,19,9,1),(16,'June','viparat@crm-c.club','','',NULL,NULL,NULL,'','',0,19,14,0),(23,'test@crm-c.club','test@crm-c.club','','',NULL,NULL,NULL,'test','test',0,19,0,1);
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

-- Dump completed on 2017-01-29 21:56:48
