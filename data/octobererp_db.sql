-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: octobererp
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_access_log`
--

LOCK TABLES `backend_access_log` WRITE;
/*!40000 ALTER TABLE `backend_access_log` DISABLE KEYS */;
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `is_new_user_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_unique` (`name`),
  KEY `code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_groups`
--

LOCK TABLES `backend_user_groups` WRITE;
/*!40000 ALTER TABLE `backend_user_groups` DISABLE KEYS */;
INSERT INTO `backend_user_groups` VALUES (4,'Inventory Administrator','2017-02-02 12:13:57','2017-12-19 06:55:27','inventory_administrator','',0),(5,'Project Encharge','2017-02-02 12:14:43','2017-11-18 04:42:30','project_incharge','',0),(6,'Project Accountant','2017-02-02 12:15:50','2017-11-18 04:41:41','project_accountant','',0),(7,'Inventory Supplier','2017-03-21 12:39:42','2017-03-31 10:33:37','inventory_supplier','',0),(8,'Inventory Customer','2017-03-21 12:40:06','2017-03-26 08:09:17','inventory_customer','',0),(9,'Employee','2017-06-25 03:22:55','2017-06-25 03:22:55','employee','',0),(10,'Head Office Accountant','2017-11-16 07:02:09','2017-12-19 07:05:46','ho_accountant','',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_preferences`
--

LOCK TABLES `backend_user_preferences` WRITE;
/*!40000 ALTER TABLE `backend_user_preferences` DISABLE KEYS */;
INSERT INTO `backend_user_preferences` VALUES (1,1,'backend','reportwidgets','dashboard','{\"welcome\":{\"class\":\"Backend\\\\ReportWidgets\\\\Welcome\",\"sortOrder\":50,\"configuration\":{\"ocWidgetWidth\":10}},\"report_container_dashboard_2\":{\"class\":\"System\\\\ReportWidgets\\\\Status\",\"configuration\":{\"title\":\"backend::lang.dashboard.status.widget_title_default\",\"ocWidgetWidth\":\"10\"},\"sortOrder\":51},\"report_container_dashboard_3\":{\"class\":\"Olabs\\\\Oims\\\\ReportWidgets\\\\DprSummary\",\"configuration\":{\"title\":\"DPR Summary Report\",\"ocWidgetWidth\":\"10\",\"ocWidgetNewRow\":null},\"sortOrder\":52},\"report_container_dashboard_4\":{\"class\":\"Olabs\\\\Oims\\\\ReportWidgets\\\\ProjectStatus\",\"configuration\":{\"title\":\"ProjectStatus\",\"ocWidgetWidth\":\"10\"},\"sortOrder\":53}}');
/*!40000 ALTER TABLE `backend_user_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backend_user_roles`
--

DROP TABLE IF EXISTS `backend_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backend_user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `permissions` text COLLATE utf8_unicode_ci,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_unique` (`name`),
  KEY `role_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_user_roles`
--

LOCK TABLES `backend_user_roles` WRITE;
/*!40000 ALTER TABLE `backend_user_roles` DISABLE KEYS */;
INSERT INTO `backend_user_roles` VALUES (1,'Publisher','publisher','Site editor with access to publishing tools.',NULL,0,NULL,NULL),(2,'Developer','developer','Site administrator with access to developer tools.',NULL,0,NULL,NULL),(3,'Inventory Administrator','inventory_administrator','','{\"backend.access_dashboard\":\"1\",\"backend.manage_users\":\"1\",\"olabs.oims.taxes\":\"1\",\"olabs.oims.units\":\"1\",\"olabs.oims.categories\":\"1\",\"olabs.oims.workgroups\":\"1\",\"olabs.oims.projects\":\"1\",\"olabs.oims.companies\":\"1\",\"olabs.oims.projectworks\":\"1\",\"olabs.oims.record_back_date_entry\":\"1\",\"olabs.oims.products\":\"1\",\"olabs.oims.offrole_employees\":\"1\",\"olabs.oims.employee_types\":\"1\",\"olabs.oims.suppliers\":\"1\",\"olabs.oims.access_settings\":\"1\",\"olabs.oims.record_submit_for_approval\":\"1\",\"olabs.oims.record_ho_approval\":\"1\",\"olabs.oims.record_update\":\"1\",\"olabs.oims.record_approval\":\"1\",\"olabs.oims.customers\":\"1\",\"olabs.oims.employees\":\"1\",\"olabs.oims.reports\":\"1\",\"olabs.oims.project_assets\":\"1\",\"olabs.oims.expenseonpcs\":\"1\",\"olabs.oims.manpowers\":\"1\",\"olabs.oims.expenseonmaterials\":\"1\",\"olabs.oims.purchases\":\"1\",\"olabs.oims.machineries\":\"1\",\"olabs.oims.pc_attendances\":\"1\",\"olabs.oims.attendances\":\"1\",\"olabs.oims.sales\":\"1\",\"olabs.oims.quotes\":\"1\",\"olabs.oims.projectprogress\":\"1\",\"reportico.reportico.manage_plugins\":\"1\",\"reportico.reports.reports\":\"1\"}',0,NULL,'2018-04-02 08:51:07'),(4,'Project Encharge','project_incharge','','{\"backend.access_dashboard\":\"1\",\"olabs.oims.projects\":\"1\",\"olabs.oims.companies\":\"1\",\"olabs.oims.projectworks\":\"1\",\"olabs.oims.products\":\"1\",\"olabs.oims.offrole_employees\":\"1\",\"olabs.oims.suppliers\":\"1\",\"olabs.oims.record_approval\":\"1\",\"olabs.oims.customers\":\"1\",\"olabs.oims.reports\":\"1\",\"olabs.oims.project_assets\":\"1\",\"olabs.oims.expenseonpcs\":\"1\",\"olabs.oims.manpowers\":\"1\",\"olabs.oims.expenseonmaterials\":\"1\",\"olabs.oims.machineries\":\"1\",\"olabs.oims.pc_attendances\":\"1\",\"olabs.oims.attendances\":\"1\",\"olabs.oims.purchases\":\"1\",\"olabs.oims.sales\":\"1\",\"olabs.oims.quotes\":\"1\",\"olabs.oims.projectprogress\":\"1\"}',0,NULL,'2018-03-23 06:36:56'),(5,'Project Accountant','project_accountant','','{\"backend.access_dashboard\":\"1\",\"olabs.oims.projectworks\":\"1\",\"olabs.oims.products\":\"1\",\"olabs.oims.offrole_employees\":\"1\",\"olabs.oims.suppliers\":\"1\",\"olabs.oims.record_submit_for_approval\":\"1\",\"olabs.oims.employees\":\"1\",\"olabs.oims.reports\":\"1\",\"olabs.oims.project_assets\":\"1\",\"olabs.oims.expenseonpcs\":\"1\",\"olabs.oims.manpowers\":\"1\",\"olabs.oims.expenseonmaterials\":\"1\",\"olabs.oims.machineries\":\"1\",\"olabs.oims.pc_attendances\":\"1\",\"olabs.oims.attendances\":\"1\",\"olabs.oims.purchases\":\"1\",\"olabs.oims.sales\":\"1\",\"olabs.oims.quotes\":\"1\",\"olabs.oims.projectprogress\":\"1\"}',0,NULL,'2018-03-23 06:37:12'),(6,'Inventory Supplier','inventory_supplier','','',0,NULL,NULL),(7,'Inventory Customer','inventory_customer','','',0,NULL,NULL),(8,'Employee','employee','','',0,NULL,NULL),(9,'Head Office Accountant','ho_accountant','','{\"backend.access_dashboard\":\"1\",\"olabs.oims.taxes\":\"1\",\"olabs.oims.units\":\"1\",\"olabs.oims.categories\":\"1\",\"olabs.oims.workgroups\":\"1\",\"olabs.oims.projects\":\"1\",\"olabs.oims.projectworks\":\"1\",\"olabs.oims.record_back_date_entry\":\"1\",\"olabs.oims.products\":\"1\",\"olabs.oims.offrole_employees\":\"1\",\"olabs.oims.employee_types\":\"1\",\"olabs.oims.suppliers\":\"1\",\"olabs.oims.record_ho_approval\":\"1\",\"olabs.oims.employees\":\"1\",\"olabs.oims.reports\":\"1\",\"olabs.oims.expenseonpcs\":\"1\",\"olabs.oims.manpowers\":\"1\",\"olabs.oims.expenseonmaterials\":\"1\",\"olabs.oims.machineries\":\"1\",\"olabs.oims.pc_attendances\":\"1\",\"olabs.oims.attendances\":\"1\",\"olabs.oims.purchases\":\"1\",\"olabs.oims.sales\":\"1\",\"olabs.oims.quotes\":\"1\",\"olabs.oims.projectprogress\":\"1\"}',0,NULL,'2018-03-23 02:43:31');
/*!40000 ALTER TABLE `backend_user_roles` ENABLE KEYS */;
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
INSERT INTO `backend_user_throttle` VALUES (1,1,'127.0.0.1',0,NULL,0,NULL,0,NULL);
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
  `tenant_id` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supplier_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_unique` (`login`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `act_code_index` (`activation_code`),
  KEY `reset_code_index` (`reset_password_code`),
  KEY `admin_role_index` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1119 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backend_users`
--

LOCK TABLES `backend_users` WRITE;
/*!40000 ALTER TABLE `backend_users` DISABLE KEYS */;
INSERT INTO `backend_users` VALUES (1,'Admin','Person','admin','anutech17@gmail.com','$2y$10$R/NlZb03EOVm9Y6xAmHoluImwVSoFvXxA..RhzLR5PvjcJVA0rJGy',NULL,'$2y$10$RLPPprcyliVcfgJQR9JisOWKgQ7wtijPG7V96NPmWwaADszSepqFG',NULL,'',1,NULL,'2018-04-06 03:28:04','2016-08-28 11:43:38','2018-04-06 03:28:04',1,NULL,'','','','','','','','','',NULL,NULL,NULL);
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
  `value` text COLLATE utf8_unicode_ci NOT NULL,
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
-- Table structure for table `cms_theme_logs`
--

DROP TABLE IF EXISTS `cms_theme_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_theme_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `old_template` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `old_content` longtext COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cms_theme_logs_type_index` (`type`),
  KEY `cms_theme_logs_theme_index` (`theme`),
  KEY `cms_theme_logs_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_theme_logs`
--

LOCK TABLES `cms_theme_logs` WRITE;
/*!40000 ALTER TABLE `cms_theme_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_theme_logs` ENABLE KEYS */;
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
  KEY `deferred_bindings_slave_id_index` (`slave_id`),
  KEY `deferred_bindings_session_key_index` (`session_key`)
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
  `exception` longtext COLLATE utf8_unicode_ci,
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
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`)
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
-- Table structure for table `keios_multisite_settings`
--

DROP TABLE IF EXISTS `keios_multisite_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keios_multisite_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` text COLLATE utf8_unicode_ci NOT NULL,
  `theme` text COLLATE utf8_unicode_ci NOT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keios_multisite_settings`
--

LOCK TABLES `keios_multisite_settings` WRITE;
/*!40000 ALTER TABLE `keios_multisite_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `keios_multisite_settings` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES ('2013_10_01_000001_Db_Deferred_Bindings',1),('2013_10_01_000002_Db_System_Files',1),('2013_10_01_000003_Db_System_Plugin_Versions',1),('2013_10_01_000004_Db_System_Plugin_History',1),('2013_10_01_000005_Db_System_Settings',1),('2013_10_01_000006_Db_System_Parameters',1),('2013_10_01_000007_Db_System_Add_Disabled_Flag',1),('2013_10_01_000008_Db_System_Mail_Templates',1),('2013_10_01_000009_Db_System_Mail_Layouts',1),('2014_10_01_000010_Db_Jobs',1),('2014_10_01_000011_Db_System_Event_Logs',1),('2014_10_01_000012_Db_System_Request_Logs',1),('2014_10_01_000013_Db_System_Sessions',1),('2015_10_01_000014_Db_System_Mail_Layout_Rename',1),('2015_10_01_000015_Db_System_Add_Frozen_Flag',1),('2015_10_01_000016_Db_Cache',1),('2015_10_01_000017_Db_System_Revisions',1),('2015_10_01_000018_Db_FailedJobs',1),('2016_10_01_000019_Db_System_Plugin_History_Detail_Text',1),('2016_10_01_000020_Db_System_Timestamp_Fix',1),('2013_10_01_000001_Db_Backend_Users',2),('2013_10_01_000002_Db_Backend_User_Groups',2),('2013_10_01_000003_Db_Backend_Users_Groups',2),('2013_10_01_000004_Db_Backend_User_Throttle',2),('2014_01_04_000005_Db_Backend_User_Preferences',2),('2014_10_01_000006_Db_Backend_Access_Log',2),('2014_10_01_000007_Db_Backend_Add_Description_Field',2),('2015_10_01_000008_Db_Backend_Add_Superuser_Flag',2),('2016_10_01_000009_Db_Backend_Timestamp_Fix',2),('2014_10_01_000001_Db_Cms_Theme_Data',3),('2016_10_01_000002_Db_Cms_Timestamp_Fix',3),('2017_10_01_000003_Db_Cms_Theme_Logs',4),('2017_08_04_121309_Db_Deferred_Bindings_Add_Index_Session',5),('2017_10_01_000021_Db_System_Sessions_Update',5),('2017_10_01_000022_Db_Jobs_FailedJobs_Update',5),('2017_10_01_000023_Db_System_Mail_Partials',5),('2017_10_01_000010_Db_Backend_User_Roles',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_attendances`
--

DROP TABLE IF EXISTS `olabs_oims_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `daily_wages` decimal(10,0) DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `total_working_hour` decimal(10,0) DEFAULT NULL,
  `total_wages` decimal(10,0) DEFAULT NULL,
  `overtime` decimal(10,0) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `working_hour` int(11) DEFAULT NULL,
  `employee_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `employee_id` (`employee_id`),
  KEY `check_in` (`check_in`),
  KEY `employee_type` (`employee_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_attendances`
--

LOCK TABLES `olabs_oims_attendances` WRITE;
/*!40000 ALTER TABLE `olabs_oims_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_bank_accounts`
--

DROP TABLE IF EXISTS `olabs_oims_bank_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_bank_accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_bank_accounts`
--

LOCK TABLES `olabs_oims_bank_accounts` WRITE;
/*!40000 ALTER TABLE `olabs_oims_bank_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_bank_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_brands`
--

DROP TABLE IF EXISTS `olabs_oims_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT NULL,
  `show_in_menu` tinyint(1) DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `short_description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_brands`
--

LOCK TABLES `olabs_oims_brands` WRITE;
/*!40000 ALTER TABLE `olabs_oims_brands` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_carriers`
--

DROP TABLE IF EXISTS `olabs_oims_carriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_carriers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `transit_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `speed_grade` int(11) DEFAULT NULL,
  `tracking_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `free_shipping` tinyint(1) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `billing` int(11) DEFAULT NULL,
  `billing_total_price` text COLLATE utf8_unicode_ci,
  `billing_weight` text COLLATE utf8_unicode_ci,
  `maximum_package_width` double DEFAULT NULL,
  `maximum_package_height` double DEFAULT NULL,
  `maximum_package_depth` double DEFAULT NULL,
  `maximum_package_weight` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_carriers`
--

LOCK TABLES `olabs_oims_carriers` WRITE;
/*!40000 ALTER TABLE `olabs_oims_carriers` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_carriers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_categories`
--

DROP TABLE IF EXISTS `olabs_oims_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT NULL,
  `show_in_menu` tinyint(1) DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `nest_left` int(11) NOT NULL DEFAULT '0',
  `nest_right` int(11) NOT NULL DEFAULT '0',
  `nest_depth` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `olabs_oims_categories_parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_categories`
--

LOCK TABLES `olabs_oims_categories` WRITE;
/*!40000 ALTER TABLE `olabs_oims_categories` DISABLE KEYS */;
INSERT INTO `olabs_oims_categories` VALUES (1,'2017-02-28 03:59:16','2017-03-16 11:39:58','Materials','materials','',1,1,'','','',NULL,1,4,0);
/*!40000 ALTER TABLE `olabs_oims_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_categories_users_sale`
--

DROP TABLE IF EXISTS `olabs_oims_categories_users_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_categories_users_sale` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `sale` double unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `olabs_oims_categories_users_sale_category_id_user_id_unique` (`category_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_categories_users_sale`
--

LOCK TABLES `olabs_oims_categories_users_sale` WRITE;
/*!40000 ALTER TABLE `olabs_oims_categories_users_sale` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_categories_users_sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_companies`
--

DROP TABLE IF EXISTS `olabs_oims_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_companies`
--

LOCK TABLES `olabs_oims_companies` WRITE;
/*!40000 ALTER TABLE `olabs_oims_companies` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_coupons`
--

DROP TABLE IF EXISTS `olabs_oims_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_coupons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid_from` timestamp NULL DEFAULT NULL,
  `valid_to` timestamp NULL DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT NULL,
  `minimum_value_basket` double DEFAULT NULL,
  `type_value` int(11) DEFAULT NULL,
  `value` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_coupons`
--

LOCK TABLES `olabs_oims_coupons` WRITE;
/*!40000 ALTER TABLE `olabs_oims_coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_coupons_categories`
--

DROP TABLE IF EXISTS `olabs_oims_coupons_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_coupons_categories` (
  `coupon_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`coupon_id`,`category_id`),
  KEY `olabs_oims_coupons_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `olabs_oims_coupons_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `olabs_oims_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `olabs_oims_coupons_categories_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `olabs_oims_coupons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_coupons_categories`
--

LOCK TABLES `olabs_oims_coupons_categories` WRITE;
/*!40000 ALTER TABLE `olabs_oims_coupons_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_coupons_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_coupons_products`
--

DROP TABLE IF EXISTS `olabs_oims_coupons_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_coupons_products` (
  `coupon_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`coupon_id`,`product_id`),
  KEY `olabs_oims_coupons_products_product_id_foreign` (`product_id`),
  CONSTRAINT `olabs_oims_coupons_products_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `olabs_oims_coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `olabs_oims_coupons_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `olabs_oims_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_coupons_products`
--

LOCK TABLES `olabs_oims_coupons_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_coupons_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_coupons_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_coupons_users`
--

DROP TABLE IF EXISTS `olabs_oims_coupons_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_coupons_users` (
  `coupon_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`coupon_id`,`user_id`),
  KEY `olabs_oims_coupons_users_user_id_foreign` (`user_id`),
  CONSTRAINT `olabs_oims_coupons_users_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `olabs_oims_coupons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `olabs_oims_coupons_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_coupons_users`
--

LOCK TABLES `olabs_oims_coupons_users` WRITE;
/*!40000 ALTER TABLE `olabs_oims_coupons_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_coupons_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_customers`
--

DROP TABLE IF EXISTS `olabs_oims_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_customers`
--

LOCK TABLES `olabs_oims_customers` WRITE;
/*!40000 ALTER TABLE `olabs_oims_customers` DISABLE KEYS */;
INSERT INTO `olabs_oims_customers` VALUES (1,'Tata Motor Customer','Test','1',NULL,NULL,'2017-02-28 23:46:52','2017-02-28 23:46:52');
/*!40000 ALTER TABLE `olabs_oims_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_employee_types`
--

DROP TABLE IF EXISTS `olabs_oims_employee_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_employee_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_employee_types`
--

LOCK TABLES `olabs_oims_employee_types` WRITE;
/*!40000 ALTER TABLE `olabs_oims_employee_types` DISABLE KEYS */;
INSERT INTO `olabs_oims_employee_types` VALUES (1,'MASON','mason',NULL,NULL,'2017-05-25 11:30:39','2018-03-23 01:24:50',NULL,'1');
/*!40000 ALTER TABLE `olabs_oims_employee_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_expense_on_material_products`
--

DROP TABLE IF EXISTS `olabs_oims_expense_on_material_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_expense_on_material_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expense_on_material_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_value` decimal(10,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_expense_on_material_products`
--

LOCK TABLES `olabs_oims_expense_on_material_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_expense_on_material_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_expense_on_material_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_expense_on_materials`
--

DROP TABLE IF EXISTS `olabs_oims_expense_on_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_expense_on_materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(10) unsigned DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_expense_on_materials`
--

LOCK TABLES `olabs_oims_expense_on_materials` WRITE;
/*!40000 ALTER TABLE `olabs_oims_expense_on_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_expense_on_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_expense_on_pc_products`
--

DROP TABLE IF EXISTS `olabs_oims_expense_on_pc_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_expense_on_pc_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expense_on_pc_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_value` decimal(10,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quote_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_expense_on_pc_products`
--

LOCK TABLES `olabs_oims_expense_on_pc_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_expense_on_pc_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_expense_on_pc_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_expense_on_pcs`
--

DROP TABLE IF EXISTS `olabs_oims_expense_on_pcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_expense_on_pcs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(10) unsigned DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `quote_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_expense_on_pcs`
--

LOCK TABLES `olabs_oims_expense_on_pcs` WRITE;
/*!40000 ALTER TABLE `olabs_oims_expense_on_pcs` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_expense_on_pcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_machineries`
--

DROP TABLE IF EXISTS `olabs_oims_machineries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_machineries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(10) unsigned DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_machineries`
--

LOCK TABLES `olabs_oims_machineries` WRITE;
/*!40000 ALTER TABLE `olabs_oims_machineries` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_machineries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_machinery_products`
--

DROP TABLE IF EXISTS `olabs_oims_machinery_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_machinery_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `machinery_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_value` decimal(10,2) DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_machinery_products`
--

LOCK TABLES `olabs_oims_machinery_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_machinery_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_machinery_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_manpower_products`
--

DROP TABLE IF EXISTS `olabs_oims_manpower_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_manpower_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manpower_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_value` decimal(10,2) DEFAULT NULL,
  `remark` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_manpower_products`
--

LOCK TABLES `olabs_oims_manpower_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_manpower_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_manpower_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_manpowers`
--

DROP TABLE IF EXISTS `olabs_oims_manpowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_manpowers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(10) unsigned DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_manpowers`
--

LOCK TABLES `olabs_oims_manpowers` WRITE;
/*!40000 ALTER TABLE `olabs_oims_manpowers` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_manpowers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_offrole_employees`
--

DROP TABLE IF EXISTS `olabs_oims_offrole_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_offrole_employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aadhaar_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pan_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `daily_wages` decimal(12,2) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `last_working_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `employee_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `employee_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_hour` int(11) DEFAULT NULL,
  `monthly_wages` decimal(12,2) DEFAULT NULL,
  `lunch_hour` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_offrole_employees`
--

LOCK TABLES `olabs_oims_offrole_employees` WRITE;
/*!40000 ALTER TABLE `olabs_oims_offrole_employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_offrole_employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_order_statuses`
--

DROP TABLE IF EXISTS `olabs_oims_order_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_order_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `send_email_to_customer` tinyint(1) DEFAULT NULL,
  `attach_invoice_pdf_to_email` tinyint(1) DEFAULT NULL,
  `mail_template_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `qty_increase_back` tinyint(1) NOT NULL DEFAULT '0',
  `qty_decrease` tinyint(1) NOT NULL DEFAULT '0',
  `disallow_for_gateway` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_order_statuses`
--

LOCK TABLES `olabs_oims_order_statuses` WRITE;
/*!40000 ALTER TABLE `olabs_oims_order_statuses` DISABLE KEYS */;
INSERT INTO `olabs_oims_order_statuses` VALUES (1,'2016-04-12 13:12:48','2016-05-08 13:20:48','New Order - Cash on Delivery','#f1c40f',1,1,0,NULL,0,0,0),(2,'2016-05-08 12:12:37','2016-05-08 13:20:40','New Order - PayPal','#f1c40f',1,1,0,NULL,0,0,0),(3,'2016-05-08 12:13:47','2016-05-08 13:20:32','New Order - Bank transfer','#f1c40f',1,1,0,NULL,0,0,0),(4,'2016-05-08 12:14:54','2016-05-08 13:20:24','Payment Received','#9b59b6',1,1,0,NULL,0,0,0),(5,'2016-05-08 12:15:13','2016-05-10 12:25:48','Cancel Order','#c0392b',1,1,0,NULL,0,0,0),(6,'2016-05-08 12:15:55','2016-05-08 13:20:00','Expedited Order','#2ecc71',1,1,1,NULL,0,0,0),(7,'2016-05-08 13:19:41','2016-05-08 13:19:41','Expedited Order - Cash on Delivery','#27ae60',1,1,1,NULL,0,0,0);
/*!40000 ALTER TABLE `olabs_oims_order_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_orders`
--

DROP TABLE IF EXISTS `olabs_oims_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `orderstatus_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(10) unsigned DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` timestamp NULL DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` double DEFAULT NULL,
  `coupon_id` int(10) unsigned DEFAULT NULL,
  `payment_gateway_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `olabs_oims_orders_coupon_id_foreign` (`coupon_id`),
  KEY `olabs_oims_orders_payment_gateway_id_foreign` (`payment_gateway_id`),
  CONSTRAINT `olabs_oims_orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `olabs_oims_coupons` (`id`) ON DELETE SET NULL,
  CONSTRAINT `olabs_oims_orders_payment_gateway_id_foreign` FOREIGN KEY (`payment_gateway_id`) REFERENCES `olabs_oims_payment_gateways` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_orders`
--

LOCK TABLES `olabs_oims_orders` WRITE;
/*!40000 ALTER TABLE `olabs_oims_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_payment_gateways`
--

DROP TABLE IF EXISTS `olabs_oims_payment_gateways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_payment_gateways` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_status_before_id` int(10) unsigned DEFAULT NULL,
  `order_status_after_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `gateway` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gateway_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gateway_currency` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_page` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `olabs_oims_payment_gateways_order_status_before_id_foreign` (`order_status_before_id`),
  KEY `olabs_oims_payment_gateways_order_status_after_id_foreign` (`order_status_after_id`),
  CONSTRAINT `olabs_oims_payment_gateways_order_status_after_id_foreign` FOREIGN KEY (`order_status_after_id`) REFERENCES `olabs_oims_order_statuses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `olabs_oims_payment_gateways_order_status_before_id_foreign` FOREIGN KEY (`order_status_before_id`) REFERENCES `olabs_oims_order_statuses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_payment_gateways`
--

LOCK TABLES `olabs_oims_payment_gateways` WRITE;
/*!40000 ALTER TABLE `olabs_oims_payment_gateways` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_payment_gateways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_payment_receivables`
--

DROP TABLE IF EXISTS `olabs_oims_payment_receivables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_payment_receivables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `received_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_payment_receivables`
--

LOCK TABLES `olabs_oims_payment_receivables` WRITE;
/*!40000 ALTER TABLE `olabs_oims_payment_receivables` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_payment_receivables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_pc_attendance_details`
--

DROP TABLE IF EXISTS `olabs_oims_pc_attendance_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_pc_attendance_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attendance_id` int(11) DEFAULT NULL,
  `employee_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `daily_wages` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `working_hour` decimal(12,2) DEFAULT NULL,
  `overtime` decimal(12,2) DEFAULT NULL,
  `total_working_hour` decimal(12,2) DEFAULT NULL,
  `total_wages` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_pc_attendance_details`
--

LOCK TABLES `olabs_oims_pc_attendance_details` WRITE;
/*!40000 ALTER TABLE `olabs_oims_pc_attendance_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_pc_attendance_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_pc_attendances`
--

DROP TABLE IF EXISTS `olabs_oims_pc_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_pc_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(11) DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_pc_attendances`
--

LOCK TABLES `olabs_oims_pc_attendances` WRITE;
/*!40000 ALTER TABLE `olabs_oims_pc_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_pc_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products`
--

DROP TABLE IF EXISTS `olabs_oims_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ean_13` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `on_sale` tinyint(1) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `available_for_order` tinyint(1) DEFAULT NULL,
  `show_price` tinyint(1) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL,
  `short_description` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `brand_id` int(11) DEFAULT NULL,
  `pre_tax_wholesale_price` decimal(12,2) DEFAULT NULL,
  `pre_tax_retail_price` decimal(12,2) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `retail_price_with_tax` decimal(12,2) DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `default_category_id` int(11) DEFAULT NULL,
  `package_width` decimal(12,2) DEFAULT NULL,
  `package_height` decimal(12,2) DEFAULT NULL,
  `package_depth` decimal(12,2) DEFAULT NULL,
  `package_weight` decimal(12,2) DEFAULT NULL,
  `additional_shipping_fees` decimal(12,2) DEFAULT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `when_out_of_stock` int(11) DEFAULT NULL,
  `minimum_quantity` int(10) unsigned NOT NULL,
  `availability_date` timestamp NULL DEFAULT NULL,
  `customization` text COLLATE utf8_unicode_ci,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4622 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products`
--

LOCK TABLES `olabs_oims_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products` DISABLE KEYS */;
INSERT INTO `olabs_oims_products` VALUES (1,'2017-02-28 04:00:53','2017-03-31 07:40:55','BRICKS','bricks','','',1,0,1,1,1,0,'','',1,4.00,4.00,1,4.20,'','','',1,NULL,NULL,NULL,NULL,NULL,100,0,1,NULL,'[]',NULL),(2,'2017-02-28 04:01:57','2017-04-06 09:52:50','CEMENT','cement','','',1,0,1,1,1,0,'','',1,200.00,200.00,1,290.00,'','','',1,NULL,NULL,NULL,NULL,NULL,90,0,1,NULL,'[]','bags'),(3,'2017-03-23 11:20:04','2017-05-13 16:16:47','WATER TANKER','water-tanker','','',1,0,1,1,1,0,'','',1,1000.00,1000.00,1,4.50,'','','',1,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,'[]','Ltr'),(4,'2017-03-24 10:15:52','2017-03-24 10:15:52','AGGREGATE 10 MM','aggregate-10-mm','','',1,1,1,1,1,0,'','',NULL,34.00,34.00,1,39.10,'','','',1,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,'[]',NULL),(5,'2017-03-24 10:17:02','2017-04-06 09:53:10','CORE SAND','core-sand','','',1,1,1,1,1,0,'','',NULL,68.00,68.00,1,78.20,'','','',1,NULL,NULL,NULL,NULL,NULL,0,0,1,NULL,'[]','cft');
/*!40000 ALTER TABLE `olabs_oims_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_accessories`
--

DROP TABLE IF EXISTS `olabs_oims_products_accessories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_accessories` (
  `product_id` int(10) unsigned NOT NULL,
  `accessory_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`accessory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_accessories`
--

LOCK TABLES `olabs_oims_products_accessories` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_accessories` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_accessories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_carriers_no`
--

DROP TABLE IF EXISTS `olabs_oims_products_carriers_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_carriers_no` (
  `product_id` int(10) unsigned NOT NULL,
  `carrier_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`carrier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_carriers_no`
--

LOCK TABLES `olabs_oims_products_carriers_no` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_carriers_no` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_carriers_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_categories`
--

DROP TABLE IF EXISTS `olabs_oims_products_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_categories` (
  `product_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_categories`
--

LOCK TABLES `olabs_oims_products_categories` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_featured`
--

DROP TABLE IF EXISTS `olabs_oims_products_featured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_featured` (
  `product_id` int(10) unsigned NOT NULL,
  `featured_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`featured_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_featured`
--

LOCK TABLES `olabs_oims_products_featured` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_featured` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_featured` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_options`
--

DROP TABLE IF EXISTS `olabs_oims_products_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_options` (
  `product_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `price_difference_with_tax` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`product_id`,`option_id`),
  KEY `olabs_oims_products_options_option_id_foreign` (`option_id`),
  CONSTRAINT `olabs_oims_products_options_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `olabs_oims_property_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `olabs_oims_products_options_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `olabs_oims_products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_options`
--

LOCK TABLES `olabs_oims_products_options` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_properties`
--

DROP TABLE IF EXISTS `olabs_oims_products_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_properties` (
  `product_id` int(10) unsigned NOT NULL,
  `property_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`property_id`),
  KEY `olabs_oims_products_properties_property_id_foreign` (`property_id`),
  CONSTRAINT `olabs_oims_products_properties_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `olabs_oims_products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `olabs_oims_products_properties_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `olabs_oims_properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_properties`
--

LOCK TABLES `olabs_oims_products_properties` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_products_users_price`
--

DROP TABLE IF EXISTS `olabs_oims_products_users_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_products_users_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `price` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `olabs_oims_products_users_price_product_id_user_id_unique` (`product_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_products_users_price`
--

LOCK TABLES `olabs_oims_products_users_price` WRITE;
/*!40000 ALTER TABLE `olabs_oims_products_users_price` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_products_users_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_asset_damages`
--

DROP TABLE IF EXISTS `olabs_oims_project_asset_damages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_asset_damages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_asset_damages`
--

LOCK TABLES `olabs_oims_project_asset_damages` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_asset_damages` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_asset_damages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_asset_monitoring`
--

DROP TABLE IF EXISTS `olabs_oims_project_asset_monitoring`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_asset_monitoring` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `condition_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_asset_monitoring`
--

LOCK TABLES `olabs_oims_project_asset_monitoring` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_asset_monitoring` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_asset_monitoring` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_asset_purchases`
--

DROP TABLE IF EXISTS `olabs_oims_project_asset_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_asset_purchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_asset_purchases`
--

LOCK TABLES `olabs_oims_project_asset_purchases` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_asset_purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_asset_purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_asset_transfers`
--

DROP TABLE IF EXISTS `olabs_oims_project_asset_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_asset_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `to_project_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_asset_transfers`
--

LOCK TABLES `olabs_oims_project_asset_transfers` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_asset_transfers` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_asset_transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_assets`
--

DROP TABLE IF EXISTS `olabs_oims_project_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_assets`
--

LOCK TABLES `olabs_oims_project_assets` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_progress`
--

DROP TABLE IF EXISTS `olabs_oims_project_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'daily',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_progress`
--

LOCK TABLES `olabs_oims_project_progress` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_progress_items`
--

DROP TABLE IF EXISTS `olabs_oims_project_progress_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_progress_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `work_id` int(11) DEFAULT NULL,
  `quantity` decimal(12,4) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `project_progress_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_progress_items`
--

LOCK TABLES `olabs_oims_project_progress_items` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_progress_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_progress_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_work_products`
--

DROP TABLE IF EXISTS `olabs_oims_project_work_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_work_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_work_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coefficient` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_work_products`
--

LOCK TABLES `olabs_oims_project_work_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_work_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_work_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_project_works`
--

DROP TABLE IF EXISTS `olabs_oims_project_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_project_works` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `work_group_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_project_works`
--

LOCK TABLES `olabs_oims_project_works` WRITE;
/*!40000 ALTER TABLE `olabs_oims_project_works` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_project_works` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_projects`
--

DROP TABLE IF EXISTS `olabs_oims_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fix_expense` decimal(10,0) DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_projects`
--

LOCK TABLES `olabs_oims_projects` WRITE;
/*!40000 ALTER TABLE `olabs_oims_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_properties`
--

DROP TABLE IF EXISTS `olabs_oims_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_properties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_properties`
--

LOCK TABLES `olabs_oims_properties` WRITE;
/*!40000 ALTER TABLE `olabs_oims_properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_property_options`
--

DROP TABLE IF EXISTS `olabs_oims_property_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_property_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `property_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_index` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `olabs_oims_property_options_property_id_index` (`property_id`),
  CONSTRAINT `olabs_oims_property_options_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `olabs_oims_properties` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_property_options`
--

LOCK TABLES `olabs_oims_property_options` WRITE;
/*!40000 ALTER TABLE `olabs_oims_property_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_property_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_purchase_products`
--

DROP TABLE IF EXISTS `olabs_oims_purchase_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_purchase_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quote_product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_purchase_products`
--

LOCK TABLES `olabs_oims_purchase_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_purchase_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_purchase_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_purchases`
--

DROP TABLE IF EXISTS `olabs_oims_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_purchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(11) DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `bill_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `thru_vehicle_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `arrived_on_date` date DEFAULT NULL,
  `driver_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `quote_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_purchases`
--

LOCK TABLES `olabs_oims_purchases` WRITE;
/*!40000 ALTER TABLE `olabs_oims_purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_quote_products`
--

DROP TABLE IF EXISTS `olabs_oims_quote_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_quote_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_quote_products`
--

LOCK TABLES `olabs_oims_quote_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_quote_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_quote_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_quotes`
--

DROP TABLE IF EXISTS `olabs_oims_quotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_quotes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(10) unsigned DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` timestamp NULL DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(10) unsigned DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `quote_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci,
  `loading` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `freight` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax_igst` decimal(12,2) DEFAULT NULL,
  `tax_cgst` decimal(12,2) DEFAULT NULL,
  `tax_sgst` decimal(12,2) DEFAULT NULL,
  `form_c` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `guaranty` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_terms` text COLLATE utf8_unicode_ci,
  `terms_condition` text COLLATE utf8_unicode_ci,
  `tax_igst_amount` decimal(10,2) DEFAULT NULL,
  `tax_cgst_amount` decimal(10,2) DEFAULT NULL,
  `tax_sgst_amount` decimal(10,2) DEFAULT NULL,
  `test_certificate` text COLLATE utf8_unicode_ci,
  `supplier_contact_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `challan_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_at` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_quotes`
--

LOCK TABLES `olabs_oims_quotes` WRITE;
/*!40000 ALTER TABLE `olabs_oims_quotes` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_quotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_sales`
--

DROP TABLE IF EXISTS `olabs_oims_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `carrier_id` int(11) DEFAULT NULL,
  `products_json` text COLLATE utf8_unicode_ci,
  `total_price_without_tax` decimal(12,2) DEFAULT NULL,
  `total_tax` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `shipping_price_without_tax` decimal(12,2) DEFAULT NULL,
  `shipping_tax` decimal(12,2) DEFAULT NULL,
  `shipping_price` decimal(12,2) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `paid_detail` text COLLATE utf8_unicode_ci,
  `payment_method` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_global_discount` decimal(12,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `payment_gateway_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reference_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `context_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_sales`
--

LOCK TABLES `olabs_oims_sales` WRITE;
/*!40000 ALTER TABLE `olabs_oims_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_sales_products`
--

DROP TABLE IF EXISTS `olabs_oims_sales_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_sales_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sales_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` int(11) DEFAULT NULL,
  `unit_price` decimal(12,2) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `total_price` decimal(12,2) DEFAULT NULL,
  `unit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_sales_products`
--

LOCK TABLES `olabs_oims_sales_products` WRITE;
/*!40000 ALTER TABLE `olabs_oims_sales_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_sales_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_status_history`
--

DROP TABLE IF EXISTS `olabs_oims_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_status_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) DEFAULT NULL,
  `entity_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_status_history`
--

LOCK TABLES `olabs_oims_status_history` WRITE;
/*!40000 ALTER TABLE `olabs_oims_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_statuses`
--

DROP TABLE IF EXISTS `olabs_oims_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_statuses`
--

LOCK TABLES `olabs_oims_statuses` WRITE;
/*!40000 ALTER TABLE `olabs_oims_statuses` DISABLE KEYS */;
INSERT INTO `olabs_oims_statuses` VALUES (1,'New','new',1,NULL,NULL,'2017-03-12 02:50:20','2017-03-12 02:50:20',NULL),(2,'Submitted','submitted',1,NULL,NULL,'2017-03-12 02:55:34','2017-03-12 02:55:34',NULL),(3,'Approved','approved',1,NULL,NULL,'2017-03-12 02:56:05','2017-03-12 02:56:05',NULL),(4,'Rejected','rejected',1,NULL,NULL,'2017-03-12 02:58:37','2017-03-12 02:58:37',NULL),(5,'HO Submitted','ho-submitted',1,NULL,NULL,'2017-11-18 04:39:00','2017-11-18 04:39:00',NULL),(6,'HO Approved','ho-approved',1,NULL,NULL,'2017-11-18 04:39:28','2017-11-18 04:39:28',NULL),(7,'HO Rejected','ho-rejected',1,NULL,NULL,'2017-11-18 04:39:49','2017-11-18 04:39:49',NULL);
/*!40000 ALTER TABLE `olabs_oims_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_suppliers`
--

DROP TABLE IF EXISTS `olabs_oims_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_suppliers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_suppliers`
--

LOCK TABLES `olabs_oims_suppliers` WRITE;
/*!40000 ALTER TABLE `olabs_oims_suppliers` DISABLE KEYS */;
INSERT INTO `olabs_oims_suppliers` VALUES (1,'Hardware Supplier','Test','1',NULL,NULL,'2017-02-28 23:46:02','2017-02-28 23:46:02'),(2,'SMARJEET DUBEY','KNP','1',NULL,NULL,'2017-03-24 10:20:04','2017-03-24 10:20:04'),(3,'LEO BUILDERS','KANPUR','1',NULL,NULL,'2017-03-24 10:20:35','2017-03-24 10:20:35');
/*!40000 ALTER TABLE `olabs_oims_suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_taxes`
--

DROP TABLE IF EXISTS `olabs_oims_taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `percent` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_taxes`
--

LOCK TABLES `olabs_oims_taxes` WRITE;
/*!40000 ALTER TABLE `olabs_oims_taxes` DISABLE KEYS */;
INSERT INTO `olabs_oims_taxes` VALUES (1,'2016-04-12 09:39:17','2016-04-12 09:39:17','Service Tax',1,15),(2,'2016-04-18 02:03:39','2016-04-18 02:03:39','GST',1,18);
/*!40000 ALTER TABLE `olabs_oims_taxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_units`
--

DROP TABLE IF EXISTS `olabs_oims_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_units`
--

LOCK TABLES `olabs_oims_units` WRITE;
/*!40000 ALTER TABLE `olabs_oims_units` DISABLE KEYS */;
INSERT INTO `olabs_oims_units` VALUES (1,'Per PC','per-pc','1',NULL,NULL,'2017-03-07 07:31:11','2017-03-30 06:27:18',NULL),(2,'Ltr','Ltr','1',1,1,'2017-03-13 03:11:23','2017-03-30 06:27:55',NULL),(3,'CFT','cft','1',NULL,NULL,'2017-03-26 04:05:07','2017-03-30 06:27:42',NULL),(4,'Meter','meter','1',NULL,NULL,'2017-03-30 06:28:42','2017-03-30 06:28:42',NULL),(5,'KG','kg','1',NULL,NULL,'2017-03-30 06:29:03','2017-03-30 06:29:03',NULL),(6,'HRS','hrs','1',NULL,NULL,'2017-03-30 06:29:46','2017-03-30 06:29:46',NULL),(7,'bags','bags','1',NULL,NULL,'2017-03-30 06:29:58','2017-03-30 06:29:58',NULL),(8,'SQM','sqm','1',NULL,NULL,'2017-04-14 10:53:02','2017-04-14 10:53:02',NULL),(9,'SFT','sft','1',NULL,NULL,'2017-04-14 10:53:24','2017-04-14 10:53:24',NULL),(10,'NOS','nos','1',NULL,NULL,'2017-04-14 10:53:44','2017-04-14 10:53:44',NULL),(11,'Feet','feet','1',NULL,NULL,'2017-04-14 13:09:01','2017-04-14 13:09:01',NULL),(12,'Sq Feet','sq-feet','1',NULL,NULL,'2017-04-14 13:09:34','2017-04-14 13:09:34',NULL),(13,'BDL','bdl','1',NULL,NULL,'2017-05-19 17:07:42','2017-05-19 17:07:42',NULL),(14,'CUM','cum','1',NULL,NULL,'2017-05-19 17:07:55','2017-05-19 17:07:55',NULL),(15,'DZN','dzn','1',NULL,NULL,'2017-05-19 17:08:07','2017-05-19 17:08:07',NULL),(16,'Pkt','pkt','1',NULL,NULL,'2017-05-22 08:36:00','2017-05-22 08:36:00',NULL),(17,'MT','mt','1',NULL,NULL,'2017-06-17 05:41:03','2017-06-17 05:41:03',NULL),(18,'PER VISIT','visit','1',NULL,NULL,'2017-11-27 02:03:53','2017-11-27 02:03:53',NULL);
/*!40000 ALTER TABLE `olabs_oims_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_user_projects`
--

DROP TABLE IF EXISTS `olabs_oims_user_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_user_projects` (
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_user_projects`
--

LOCK TABLES `olabs_oims_user_projects` WRITE;
/*!40000 ALTER TABLE `olabs_oims_user_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_user_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_oims_work_groups`
--

DROP TABLE IF EXISTS `olabs_oims_work_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_oims_work_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_oims_work_groups`
--

LOCK TABLES `olabs_oims_work_groups` WRITE;
/*!40000 ALTER TABLE `olabs_oims_work_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_oims_work_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_pusher_activity`
--

DROP TABLE IF EXISTS `olabs_pusher_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_pusher_activity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tenant_id` int(11) DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci,
  `action` text COLLATE utf8_unicode_ci,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channel_type` text COLLATE utf8_unicode_ci,
  `publish_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `retries` int(11) DEFAULT NULL,
  `published_date` datetime DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `extra` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_pusher_activity`
--

LOCK TABLES `olabs_pusher_activity` WRITE;
/*!40000 ALTER TABLE `olabs_pusher_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_pusher_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_pusher_platforms`
--

DROP TABLE IF EXISTS `olabs_pusher_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_pusher_platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `channel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reg_id` text COLLATE utf8_unicode_ci,
  `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `device_id` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_pusher_platforms`
--

LOCK TABLES `olabs_pusher_platforms` WRITE;
/*!40000 ALTER TABLE `olabs_pusher_platforms` DISABLE KEYS */;
INSERT INTO `olabs_pusher_platforms` VALUES (1,'gcm',NULL,'fv1zhsuCnWc:APA91bF1l6zc07noXKoWcstcvk6G7-M-QXHzJsnaiUATs4Aa-1CS_IxQOj2_dpA7sigsZsdFUS9Mfj3QgIkwYMOPSXwiVi-7A5p3sNV6PuIb3C1Mx57fa9mp4NRX2SsckoNI0YOBX8bu',NULL,NULL,NULL,NULL),(2,'gcm',NULL,'fv1zhsuCnWc:APA91bF1l6zc07noXKoWcstcvk6G7-M-QXHzJsnaiUATs4Aa-1CS_IxQOj2_dpA7sigsZsdFUS9Mfj3QgIkwYMOPSXwiVi-7A5p3sNV6PuIb3C1Mx57fa9mp4NRX2SsckoNI0YOBX8bu',NULL,NULL,'itgoa','yourOtherValue'),(3,'gcm',NULL,'cblTZ3THeBI:APA91bE_4ZnJlk_vd5hqdqZPGrgfGUQgBTqPznpOFu7sUD3c-M-nGx-CK8pder9nxacnaxNDTVXEPVXAgIPT8K3Cbf4mIbYNwnWQ-w3mdYu4hwRCniYPhpfd7iHHkofsKN1fOwgcC2Xc',NULL,NULL,'itgoa','f3c4a599-28fb-532a-7a49-434a20f11881');
/*!40000 ALTER TABLE `olabs_pusher_platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_shopify_orders`
--

DROP TABLE IF EXISTS `olabs_shopify_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_shopify_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `shop` text COLLATE utf8_unicode_ci,
  `order_id` text COLLATE utf8_unicode_ci NOT NULL,
  `order_number` text COLLATE utf8_unicode_ci,
  `customer_fname` text COLLATE utf8_unicode_ci,
  `customer_email` text COLLATE utf8_unicode_ci,
  `customer_phone` text COLLATE utf8_unicode_ci,
  `financial_status` text COLLATE utf8_unicode_ci,
  `shipping_code` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date_added` text COLLATE utf8_unicode_ci,
  `date_modified` text COLLATE utf8_unicode_ci,
  `customer_lname` text COLLATE utf8_unicode_ci,
  `shipping_address` text COLLATE utf8_unicode_ci,
  `total_price` text COLLATE utf8_unicode_ci,
  `shipping_address1` text COLLATE utf8_unicode_ci,
  `shipping_address2` text COLLATE utf8_unicode_ci,
  `shipping_city` text COLLATE utf8_unicode_ci,
  `shipping_state` text COLLATE utf8_unicode_ci,
  `shipping_country` text COLLATE utf8_unicode_ci,
  `shipping_zip` text COLLATE utf8_unicode_ci,
  `shipping_phone` text COLLATE utf8_unicode_ci,
  `shipping_first_name` text COLLATE utf8_unicode_ci,
  `shipping_last_name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_shopify_orders`
--

LOCK TABLES `olabs_shopify_orders` WRITE;
/*!40000 ALTER TABLE `olabs_shopify_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_shopify_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_shopify_shipping_updates`
--

DROP TABLE IF EXISTS `olabs_shopify_shipping_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_shopify_shipping_updates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_number` text COLLATE utf8_unicode_ci,
  `success` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `shipment_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `insurance` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `courier_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `service_id` text COLLATE utf8_unicode_ci,
  `courier_name` text COLLATE utf8_unicode_ci,
  `service_display_name` text COLLATE utf8_unicode_ci,
  `orders_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT NULL,
  `pickup_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pickup_date` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_shopify_shipping_updates`
--

LOCK TABLES `olabs_shopify_shipping_updates` WRITE;
/*!40000 ALTER TABLE `olabs_shopify_shipping_updates` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_shopify_shipping_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_shopify_shop`
--

DROP TABLE IF EXISTS `olabs_shopify_shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_shopify_shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop` text COLLATE utf8_unicode_ci,
  `shop_url` text COLLATE utf8_unicode_ci,
  `access_token` text COLLATE utf8_unicode_ci,
  `shop_domain` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_shopify_shop`
--

LOCK TABLES `olabs_shopify_shop` WRITE;
/*!40000 ALTER TABLE `olabs_shopify_shop` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_shopify_shop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tasks_logs`
--

DROP TABLE IF EXISTS `olabs_tasks_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tasks_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tasks_logs`
--

LOCK TABLES `olabs_tasks_logs` WRITE;
/*!40000 ALTER TABLE `olabs_tasks_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_tasks_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tasks_tasks`
--

DROP TABLE IF EXISTS `olabs_tasks_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tasks_tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_to` text COLLATE utf8_unicode_ci,
  `email_cc` text COLLATE utf8_unicode_ci,
  `email_bcc` text COLLATE utf8_unicode_ci,
  `email_subject` text COLLATE utf8_unicode_ci,
  `email_body` text COLLATE utf8_unicode_ci,
  `attachment_input1` text COLLATE utf8_unicode_ci,
  `attachment_input2` text COLLATE utf8_unicode_ci,
  `attachment_input3` text COLLATE utf8_unicode_ci,
  `attachment_input4` text COLLATE utf8_unicode_ci,
  `tenant_id` int(11) DEFAULT NULL,
  `schedule` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_from` text COLLATE utf8_unicode_ci,
  `attachment_input1_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment_input2_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment_input3_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attachment_input4_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tasks_tasks`
--

LOCK TABLES `olabs_tasks_tasks` WRITE;
/*!40000 ALTER TABLE `olabs_tasks_tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_tasks_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tenant_content_categories`
--

DROP TABLE IF EXISTS `olabs_tenant_content_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tenant_content_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` text COLLATE utf8_unicode_ci NOT NULL,
  `label` text COLLATE utf8_unicode_ci NOT NULL,
  `app` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tenant_content_categories`
--

LOCK TABLES `olabs_tenant_content_categories` WRITE;
/*!40000 ALTER TABLE `olabs_tenant_content_categories` DISABLE KEYS */;
INSERT INTO `olabs_tenant_content_categories` VALUES (1,'activities','Activities',NULL),(2,'facilities','Facilities',NULL),(3,'services','Services',NULL),(4,'home_section','Home Section',NULL),(5,'home_slider','Home Page Slider',NULL),(6,'itineraries','Itineraries',NULL);
/*!40000 ALTER TABLE `olabs_tenant_content_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tenant_contents`
--

DROP TABLE IF EXISTS `olabs_tenant_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tenant_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `tags` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `cover_photo` text COLLATE utf8_unicode_ci,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tenant_contents`
--

LOCK TABLES `olabs_tenant_contents` WRITE;
/*!40000 ALTER TABLE `olabs_tenant_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_tenant_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tenant_contents_categories`
--

DROP TABLE IF EXISTS `olabs_tenant_contents_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tenant_contents_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_categories_id` int(11) NOT NULL,
  `contents_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tenant_contents_categories`
--

LOCK TABLES `olabs_tenant_contents_categories` WRITE;
/*!40000 ALTER TABLE `olabs_tenant_contents_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_tenant_contents_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tenant_members`
--

DROP TABLE IF EXISTS `olabs_tenant_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tenant_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `org_id` int(11) NOT NULL,
  `app_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `circle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tenant_members`
--

LOCK TABLES `olabs_tenant_members` WRITE;
/*!40000 ALTER TABLE `olabs_tenant_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_tenant_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `olabs_tenant_organizations`
--

DROP TABLE IF EXISTS `olabs_tenant_organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olabs_tenant_organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `tenant_id` text COLLATE utf8_unicode_ci,
  `config_url` text COLLATE utf8_unicode_ci,
  `status` text COLLATE utf8_unicode_ci,
  `address_1` text COLLATE utf8_unicode_ci,
  `address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` text COLLATE utf8_unicode_ci,
  `zip` text COLLATE utf8_unicode_ci,
  `headline` text COLLATE utf8_unicode_ci,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_1` text COLLATE utf8_unicode_ci,
  `phone_2` text COLLATE utf8_unicode_ci,
  `website` text COLLATE utf8_unicode_ci,
  `short_name` text COLLATE utf8_unicode_ci,
  `map` text COLLATE utf8_unicode_ci,
  `profile_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banner_1` text COLLATE utf8_unicode_ci,
  `dname` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `olabs_tenant_organizations`
--

LOCK TABLES `olabs_tenant_organizations` WRITE;
/*!40000 ALTER TABLE `olabs_tenant_organizations` DISABLE KEYS */;
/*!40000 ALTER TABLE `olabs_tenant_organizations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_blog_categories`
--

DROP TABLE IF EXISTS `rainlab_blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_blog_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `nest_left` int(11) DEFAULT NULL,
  `nest_right` int(11) DEFAULT NULL,
  `nest_depth` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_blog_categories_slug_index` (`slug`),
  KEY `rainlab_blog_categories_parent_id_index` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_blog_categories`
--

LOCK TABLES `rainlab_blog_categories` WRITE;
/*!40000 ALTER TABLE `rainlab_blog_categories` DISABLE KEYS */;
INSERT INTO `rainlab_blog_categories` VALUES (1,'Uncategorized','uncategorized',NULL,NULL,NULL,1,2,0,'2016-08-28 12:33:49','2016-08-28 12:33:49',NULL),(2,'News','news',NULL,NULL,NULL,3,6,0,'2016-09-02 11:54:45','2016-09-02 12:21:20',NULL),(3,'Knowledge Bank','knowledge-bank',NULL,NULL,NULL,7,8,0,'2016-09-02 11:55:11','2016-09-02 12:21:20',NULL),(4,'Notices','notices',NULL,NULL,2,4,5,1,'2016-09-02 11:55:32','2016-09-02 12:21:20',NULL),(5,'Excursions','excursions',NULL,NULL,NULL,9,14,0,'2016-09-24 14:39:32','2016-09-27 10:49:34',4),(6,'Itiniraries','itiniraries',NULL,NULL,NULL,15,16,0,'2016-09-24 14:40:07','2016-09-27 10:49:28',4),(7,'Udaipur','udaipur',NULL,NULL,5,10,11,1,'2016-09-24 14:47:19','2016-09-27 10:49:41',4),(8,'Chittorgarh','chittorgrah',NULL,NULL,5,12,13,1,'2016-09-24 14:47:35','2016-09-27 10:49:46',4),(9,'Gallery','gallery',NULL,NULL,NULL,17,28,0,'2016-09-25 11:20:01','2016-10-20 14:51:12',4),(10,'Resort','resort',NULL,NULL,9,18,19,1,'2016-09-25 11:20:29','2016-09-27 10:48:50',4),(11,'Nearby Site seeing','nearby-site-seeing',NULL,NULL,9,20,21,1,'2016-09-25 11:20:59','2016-09-27 10:48:56',4),(12,'Village','village',NULL,NULL,9,22,23,1,'2016-09-25 11:21:12','2016-09-27 10:49:11',4),(13,'Activities','activities',NULL,NULL,9,24,25,1,'2016-09-25 11:21:36','2016-09-27 10:49:22',4),(14,'Nature','nature',NULL,NULL,9,26,27,1,'2016-10-20 14:50:36','2016-10-20 14:51:12',4),(15,'News & Circulars','news-circulars',NULL,NULL,NULL,29,30,0,'2016-12-31 13:32:27','2016-12-31 13:32:27',7),(16,'GS Corner','gs-corner',NULL,NULL,NULL,31,32,0,'2016-12-31 13:32:46','2016-12-31 13:32:46',7),(17,'Knowledge Bank','itgoa-knowledge-bank',NULL,NULL,NULL,33,34,0,'2016-12-31 13:33:33','2016-12-31 13:33:33',7),(18,'Team','itgoa-team',NULL,NULL,NULL,35,36,0,'2016-12-31 13:33:55','2016-12-31 13:34:12',7);
/*!40000 ALTER TABLE `rainlab_blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_blog_posts`
--

DROP TABLE IF EXISTS `rainlab_blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_blog_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `content_html` text COLLATE utf8_unicode_ci,
  `published_at` timestamp NULL DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_blog_posts_user_id_index` (`user_id`),
  KEY `rainlab_blog_posts_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_blog_posts`
--

LOCK TABLES `rainlab_blog_posts` WRITE;
/*!40000 ALTER TABLE `rainlab_blog_posts` DISABLE KEYS */;
INSERT INTO `rainlab_blog_posts` VALUES (1,NULL,'First blog post','first-blog-post','The first ever blog post is here. It might be a good idea to update this post with some more relevant content.','![gungun.png](/storage/app/uploads/public/57c/e68/4e2/57ce684e2ff0e904949691.png)\r\nThis is your first ever **blog post**! It might be a good idea to update this post with some more relevant content.\r\n\r\nYou can edit this content by selecting **Blog** from the administration back-end menu.\r\n\r\n*Enjoy the good times!*','<p><img src=\"/storage/app/uploads/public/57c/e68/4e2/57ce684e2ff0e904949691.png\" alt=\"gungun.png\" />\nThis is your first ever <strong>blog post</strong>! It might be a good idea to update this post with some more relevant content.</p>\n<p>You can edit this content by selecting <strong>Blog</strong> from the administration back-end menu.</p>\n<p><em>Enjoy the good times!</em></p>','2016-08-28 12:33:49',1,'2016-08-28 12:33:49','2016-09-06 10:55:29',NULL),(2,1,'Top 10 cloud tech','top-10-cloud-tech','','![arch.jpg](/storage/app/uploads/public/57c/2a3/9bc/57c2a39bc5153923015619.jpg)\r\n\r\nTest blog','<p><img src=\"/storage/app/uploads/public/57c/2a3/9bc/57c2a39bc5153923015619.jpg\" alt=\"arch.jpg\" /></p>\n<p>Test blog</p>','2016-08-28 12:41:34',1,'2016-08-28 12:42:08','2016-08-28 12:42:08',NULL),(3,1,'test blog','test-blog','','ok','<p>ok</p>',NULL,0,'2016-08-29 11:17:13','2016-08-29 11:17:13',NULL),(4,1,'Udaipur','udaipur','','Udaipur, formerly the capital of the Mewar Kingdom, is a city in the western Indian state of Rajasthan. Founded by Maharana Udai Singh II in 1559, it’s set around a series of artificial lakes and is known for its lavish royal residences. City Palace, overlooking Lake Pichola, is a monumental complex of 11 palaces, courtyards and gardens, famed for its intricate peacock mosaics.\r\n\r\n\r\nGetting there: 1 h 5 min flight from N Delhi, around ₹ 5,505.','<p>Udaipur, formerly the capital of the Mewar Kingdom, is a city in the western Indian state of Rajasthan. Founded by Maharana Udai Singh II in 1559, it’s set around a series of artificial lakes and is known for its lavish royal residences. City Palace, overlooking Lake Pichola, is a monumental complex of 11 palaces, courtyards and gardens, famed for its intricate peacock mosaics.</p>\n<p>Getting there: 1 h 5 min flight from N Delhi, around ₹ 5,505.</p>','2016-09-01 14:45:14',1,'2016-09-24 14:45:25','2016-09-27 10:37:28',4),(5,1,'Chittorgarh','chittorgarh','','Chittorgarh is a city and a municipality in Rajasthan state of western India. It lies on the Berach River, a tributary of the Banas, and is the administrative headquarters of Chittorgarh District and a former capital of the Sisodia Dynasty of Mewar.','<p>Chittorgarh is a city and a municipality in Rajasthan state of western India. It lies on the Berach River, a tributary of the Banas, and is the administrative headquarters of Chittorgarh District and a former capital of the Sisodia Dynasty of Mewar.</p>','2016-09-01 15:31:26',1,'2016-09-24 15:32:31','2016-09-27 10:37:18',4),(6,1,'Resort','resort','','Resort View','<p>Resort View</p>','2016-09-01 11:22:42',1,'2016-09-25 11:24:10','2016-09-27 10:37:39',4),(7,1,'Talawada Village','talawada-village','','Talawada Village View','<p>Talawada Village View</p>','2016-09-01 11:25:36',1,'2016-09-25 11:26:18','2016-09-27 10:37:33',4),(8,1,'Nature','nature','','About Nature','<p>About Nature</p>','2016-10-18 14:49:26',1,'2016-10-20 14:49:41','2016-10-20 14:49:41',4),(9,1,'People & Locals','people-locals','','People & Locals','<p>People &amp; Locals</p>','2016-10-18 14:53:33',1,'2016-10-20 14:56:04','2016-10-20 14:56:04',4),(10,1,'Locality & Village Activities','locality-village-activities','','Locality & Village Activities','<p>Locality &amp; Village Activities</p>','2016-10-19 14:57:47',1,'2016-10-20 14:59:07','2016-10-20 14:59:07',4),(11,1,'CPS Foundation Day','cps-foundation-day','','CPS Foundation Day','<p>CPS Foundation Day</p>','2016-10-17 13:42:56',1,'2016-10-31 13:43:05','2016-10-31 13:43:05',2),(12,1,'Sports Event','sports-event','','Sports Event','<p>Sports Event</p>','2016-10-17 14:10:57',1,'2016-10-31 14:11:09','2016-10-31 14:11:09',2),(13,1,'CPS Student selected in KVPY','cps-student-selected-kvpy','','CPS Student selected in KVPY','<p>CPS Student selected in KVPY</p>','2016-10-17 14:13:06',1,'2016-10-31 14:13:11','2016-10-31 14:13:11',2),(14,1,'test1','test1','','![](https://oims2dev.s3.amazonaws.com/media/avatar-1294776_960_720.png)','<p><img src=\"https://oims2dev.s3.amazonaws.com/media/avatar-1294776_960_720.png\" alt=\"\" /></p>','2017-03-21 14:46:24',1,'2017-03-22 14:44:58','2017-03-22 14:58:15',NULL);
/*!40000 ALTER TABLE `rainlab_blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_blog_posts_categories`
--

DROP TABLE IF EXISTS `rainlab_blog_posts_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_blog_posts_categories` (
  `post_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_blog_posts_categories`
--

LOCK TABLES `rainlab_blog_posts_categories` WRITE;
/*!40000 ALTER TABLE `rainlab_blog_posts_categories` DISABLE KEYS */;
INSERT INTO `rainlab_blog_posts_categories` VALUES (1,2),(1,4),(2,1),(4,5),(4,7),(5,5),(5,8),(6,9),(6,10),(7,9),(7,12),(8,9),(8,12),(8,14),(9,9),(9,12),(10,11),(10,12),(10,13),(11,9),(12,9),(13,9);
/*!40000 ALTER TABLE `rainlab_blog_posts_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_forum_channels`
--

DROP TABLE IF EXISTS `rainlab_forum_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_forum_channels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nest_left` int(11) DEFAULT NULL,
  `nest_right` int(11) DEFAULT NULL,
  `nest_depth` int(11) DEFAULT NULL,
  `count_topics` int(11) NOT NULL DEFAULT '0',
  `count_posts` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `is_moderated` tinyint(1) NOT NULL DEFAULT '0',
  `embed_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rainlab_forum_channels_slug_unique` (`slug`),
  KEY `rainlab_forum_channels_parent_id_index` (`parent_id`),
  KEY `rainlab_forum_channels_embed_code_index` (`embed_code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_forum_channels`
--

LOCK TABLES `rainlab_forum_channels` WRITE;
/*!40000 ALTER TABLE `rainlab_forum_channels` DISABLE KEYS */;
INSERT INTO `rainlab_forum_channels` VALUES (1,NULL,'Channel Orange','channel-orange','A root level forum channel',1,12,0,9,3,'2016-08-28 12:33:49','2017-04-12 16:19:07',0,0,NULL,NULL),(2,1,'Autumn Leaves','autumn-leaves','Disccusion about the season of falling leaves.',2,9,1,3,4,'2016-08-28 12:33:49','2016-09-05 11:47:50',0,0,NULL,NULL),(3,2,'September','september','The start of the fall season.',3,4,2,0,0,'2016-08-28 12:33:49','2016-08-28 12:33:49',0,0,NULL,NULL),(4,2,'October','october','The middle of the fall season.',5,6,2,0,0,'2016-08-28 12:33:49','2016-08-28 12:33:49',0,0,NULL,NULL),(5,2,'November','november','The end of the fall season.',7,8,2,0,0,'2016-08-28 12:33:49','2016-08-28 12:33:49',0,0,NULL,NULL),(6,1,'Summer Breeze','summer-breeze','Disccusion about the wind at the ocean.',10,11,1,0,0,'2016-08-28 12:33:49','2016-08-28 12:33:50',0,0,NULL,NULL),(7,NULL,'Channel Green','channel-green','A root level forum channel',13,18,0,0,0,'2016-08-28 12:33:50','2016-08-28 12:33:50',0,0,NULL,NULL),(8,7,'Winter Snow','winter-snow','Disccusion about the frosty snow flakes.',14,15,1,0,0,'2016-08-28 12:33:50','2016-08-28 12:33:50',0,0,NULL,NULL),(9,7,'Spring Trees','spring-trees','Disccusion about the blooming gardens.',16,17,1,0,0,'2016-08-28 12:33:50','2016-08-28 12:33:50',0,0,NULL,NULL),(10,NULL,'QUALITY FUEL POINT','quality-fuel-point','FUEL SUPPLIER',19,20,0,0,0,'2017-04-04 13:10:26','2017-04-04 13:10:26',0,0,NULL,NULL);
/*!40000 ALTER TABLE `rainlab_forum_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_forum_members`
--

DROP TABLE IF EXISTS `rainlab_forum_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_forum_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count_posts` int(11) NOT NULL DEFAULT '0',
  `count_topics` int(11) NOT NULL DEFAULT '0',
  `last_active_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_moderator` tinyint(1) NOT NULL DEFAULT '0',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rainlab_forum_members_user_id_index` (`user_id`),
  KEY `rainlab_forum_members_count_posts_index` (`count_posts`),
  KEY `rainlab_forum_members_count_topics_index` (`count_topics`),
  KEY `rainlab_forum_members_last_active_at_index` (`last_active_at`),
  KEY `rainlab_forum_members_is_moderator_index` (`is_moderator`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_forum_members`
--

LOCK TABLES `rainlab_forum_members` WRITE;
/*!40000 ALTER TABLE `rainlab_forum_members` DISABLE KEYS */;
INSERT INTO `rainlab_forum_members` VALUES (1,1,'lokendra1','lokendra1',7,3,'2016-09-05 08:14:26','2016-08-28 12:36:48','2016-09-05 12:14:26',0,0),(2,2,'qa12','qa12',0,0,NULL,'2016-08-28 12:49:40','2016-08-28 12:49:40',0,0),(3,4,'supplier4','supplier4',0,0,NULL,'2017-03-25 07:51:38','2017-03-25 07:51:38',0,0);
/*!40000 ALTER TABLE `rainlab_forum_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_forum_posts`
--

DROP TABLE IF EXISTS `rainlab_forum_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_forum_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `content_html` text COLLATE utf8_unicode_ci,
  `topic_id` int(10) unsigned DEFAULT NULL,
  `member_id` int(10) unsigned DEFAULT NULL,
  `edit_user_id` int(11) DEFAULT NULL,
  `delete_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rainlab_forum_posts_topic_id_index` (`topic_id`),
  KEY `rainlab_forum_posts_member_id_index` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_forum_posts`
--

LOCK TABLES `rainlab_forum_posts` WRITE;
/*!40000 ALTER TABLE `rainlab_forum_posts` DISABLE KEYS */;
INSERT INTO `rainlab_forum_posts` VALUES (1,'First blog post','d3dd3dd','<p>d3dd3dd</p>',1,1,NULL,NULL,'2016-08-28 12:36:56','2016-08-28 12:36:56',NULL),(2,NULL,'About Java Updates','<p>About Java Updates</p>',3,1,NULL,NULL,'2016-08-28 12:37:43','2016-08-28 12:37:43',NULL),(3,'Java Updates','tested','<p>tested</p>',3,1,NULL,NULL,'2016-08-29 10:55:52','2016-08-29 10:55:52',NULL),(4,NULL,'Android 6 features','<p>Android 6 features</p>',6,1,NULL,NULL,'2016-09-05 11:46:15','2016-09-05 11:46:15',NULL),(5,NULL,'Java 7 features discussion','<p>Java 7 features discussion</p>',7,1,NULL,NULL,'2016-09-05 11:47:50','2016-09-05 11:47:50',NULL),(6,'Top 10 cloud tech','nice blog','<p>nice blog</p>',4,1,NULL,NULL,'2016-09-05 12:14:18','2016-09-05 12:14:18',NULL),(7,'Top 10 cloud tech','nice2','<p>nice2</p>',4,1,NULL,NULL,'2016-09-05 12:14:26','2016-09-05 12:14:26',NULL);
/*!40000 ALTER TABLE `rainlab_forum_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_forum_topic_followers`
--

DROP TABLE IF EXISTS `rainlab_forum_topic_followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_forum_topic_followers` (
  `topic_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`topic_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_forum_topic_followers`
--

LOCK TABLES `rainlab_forum_topic_followers` WRITE;
/*!40000 ALTER TABLE `rainlab_forum_topic_followers` DISABLE KEYS */;
INSERT INTO `rainlab_forum_topic_followers` VALUES (1,1,'2016-08-28 12:36:56','2016-08-28 12:36:56'),(3,1,'2016-09-05 11:47:11','2016-09-05 11:47:11'),(4,1,'2016-09-05 12:14:18','2016-09-05 12:14:26'),(6,1,'2016-09-05 11:46:15','2016-09-05 11:46:15'),(7,1,'2016-09-05 11:47:50','2016-09-05 11:47:50');
/*!40000 ALTER TABLE `rainlab_forum_topic_followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_forum_topics`
--

DROP TABLE IF EXISTS `rainlab_forum_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_forum_topics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `channel_id` int(10) unsigned NOT NULL,
  `start_member_id` int(11) DEFAULT NULL,
  `last_post_id` int(11) DEFAULT NULL,
  `last_post_member_id` int(11) DEFAULT NULL,
  `last_post_at` datetime DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `is_sticky` tinyint(1) NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `count_posts` int(11) NOT NULL DEFAULT '0',
  `count_views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `embed_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rainlab_forum_topics_slug_unique` (`slug`),
  KEY `sticky_post_time` (`is_sticky`,`last_post_at`),
  KEY `rainlab_forum_topics_channel_id_index` (`channel_id`),
  KEY `rainlab_forum_topics_start_member_id_index` (`start_member_id`),
  KEY `rainlab_forum_topics_last_post_at_index` (`last_post_at`),
  KEY `rainlab_forum_topics_is_private_index` (`is_private`),
  KEY `rainlab_forum_topics_is_locked_index` (`is_locked`),
  KEY `rainlab_forum_topics_count_posts_index` (`count_posts`),
  KEY `rainlab_forum_topics_count_views_index` (`count_views`),
  KEY `rainlab_forum_topics_embed_code_index` (`embed_code`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_forum_topics`
--

LOCK TABLES `rainlab_forum_topics` WRITE;
/*!40000 ALTER TABLE `rainlab_forum_topics` DISABLE KEYS */;
INSERT INTO `rainlab_forum_topics` VALUES (1,'First blog post','first-blog-post',1,0,1,1,'2016-08-28 08:36:56',0,0,0,1,7,'2016-08-28 12:36:48','2016-08-28 12:36:56','first-blog-post',NULL),(3,'Java Updates','java-updates',2,1,3,1,'2016-08-29 06:55:52',0,0,0,2,43,'2016-08-28 12:37:43','2016-08-29 10:55:52',NULL,NULL),(4,'Top 10 cloud tech','top-10-cloud-tech',1,0,7,1,'2016-09-05 08:14:26',0,0,0,2,17,'2016-08-28 12:42:28','2016-09-05 12:14:26','top-10-cloud-tech',NULL),(6,'Android 6','android-6',2,1,4,1,'2016-09-05 07:46:15',0,0,0,1,5,'2016-09-05 11:46:15','2016-09-05 11:46:15',NULL,NULL),(7,'Java 7','java-7',2,1,5,1,'2016-09-05 07:47:50',0,0,0,1,4,'2016-09-05 11:47:50','2016-09-05 11:47:50',NULL,NULL),(8,'CPS Foundation Day','cps-foundation-day',1,0,NULL,NULL,NULL,0,0,0,0,2,'2016-10-31 14:06:09','2016-10-31 14:06:09','cps-foundation-day',NULL),(9,'CPS Student selected in KVPY','cps-student-selected-in-kvpy',1,0,NULL,NULL,NULL,0,0,0,0,1,'2016-11-04 08:43:50','2016-11-04 08:43:50','cps-student-selected-kvpy',NULL),(10,'Sports Event','sports-event',1,0,NULL,NULL,NULL,0,0,0,0,1,'2016-11-04 08:43:57','2016-11-04 08:43:57','sports-event',NULL),(11,'Chittorgarh','chittorgarh',1,0,NULL,NULL,NULL,0,0,0,0,1,'2016-11-05 15:24:03','2016-11-05 15:24:03','chittorgarh',NULL),(12,'Locality & Village Activities','locality-village-activities',1,0,NULL,NULL,NULL,0,0,0,0,3,'2016-11-05 15:24:11','2016-11-05 15:24:11','locality-village-activities',NULL),(13,'test1','test1',1,0,NULL,NULL,NULL,0,0,0,0,5,'2017-03-22 14:46:55','2017-03-22 14:46:55','test1',NULL),(14,'Nature','nature',1,0,NULL,NULL,NULL,0,0,0,0,1,'2017-04-12 16:19:07','2017-04-12 16:19:07','nature',NULL);
/*!40000 ALTER TABLE `rainlab_forum_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rainlab_principles_categories`
--

DROP TABLE IF EXISTS `rainlab_principles_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rainlab_principles_categories` (
  `principles_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`principles_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rainlab_principles_categories`
--

LOCK TABLES `rainlab_principles_categories` WRITE;
/*!40000 ALTER TABLE `rainlab_principles_categories` DISABLE KEYS */;
INSERT INTO `rainlab_principles_categories` VALUES (1,2),(1,4),(2,1),(3,2),(3,3),(3,4),(4,2),(4,4);
/*!40000 ALTER TABLE `rainlab_principles_categories` ENABLE KEYS */;
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
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8_unicode_ci,
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
INSERT INTO `system_mail_layouts` VALUES (1,'Default','default','<html>\n    <head>\n        <style type=\"text/css\" media=\"screen\">\n            {{ css|raw }}\n        </style>\n    </head>\n    <body>\n        {{ content|raw }}\n    </body>\n</html>','{{ content|raw }}','a, a:hover {\n    text-decoration: none;\n    color: #0862A2;\n    font-weight: bold;\n}\n\ntd, tr, th, table {\n    padding: 0px;\n    margin: 0px;\n}\n\np {\n    margin: 10px 0;\n}',1,'2016-08-28 11:43:38','2016-08-28 11:43:38'),(2,'System','system','<html>\n    <head>\n        <style type=\"text/css\" media=\"screen\">\n            {{ css|raw }}\n        </style>\n    </head>\n    <body>\n        {{ content|raw }}\n        <hr />\n        <p>This is an automatic message. Please do not reply to it.</p>\n    </body>\n</html>','{{ content|raw }}\n\n\n---\nThis is an automatic message. Please do not reply to it.','a, a:hover {\n    text-decoration: none;\n    color: #0862A2;\n    font-weight: bold;\n}\n\ntd, tr, th, table {\n    padding: 0px;\n    margin: 0px;\n}\n\np {\n    margin: 10px 0;\n}',1,'2016-08-28 11:43:38','2016-08-28 11:43:38');
/*!40000 ALTER TABLE `system_mail_layouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_mail_partials`
--

DROP TABLE IF EXISTS `system_mail_partials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_mail_partials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_html` text COLLATE utf8_unicode_ci,
  `content_text` text COLLATE utf8_unicode_ci,
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_mail_partials`
--

LOCK TABLES `system_mail_partials` WRITE;
/*!40000 ALTER TABLE `system_mail_partials` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_mail_partials` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_mail_templates`
--

LOCK TABLES `system_mail_templates` WRITE;
/*!40000 ALTER TABLE `system_mail_templates` DISABLE KEYS */;
INSERT INTO `system_mail_templates` VALUES (1,'backend::mail.invite',NULL,'Invitation for newly created administrators.',NULL,NULL,2,0,'2016-08-28 11:48:42','2016-08-28 11:48:42'),(2,'backend::mail.restore',NULL,'Password reset instructions for backend-end administrators.',NULL,NULL,2,0,'2016-08-28 11:48:42','2016-08-28 11:48:42'),(3,'rainlab.forum::mail.topic_reply',NULL,'Notification to followers when a post is made to a topic.',NULL,NULL,1,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(4,'rainlab.forum::mail.member_report',NULL,'Notification to moderators when a member is reported to be a spammer.',NULL,NULL,1,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(5,'rainlab.user::mail.activate',NULL,'Activation email sent to new users.',NULL,NULL,1,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(6,'rainlab.user::mail.welcome',NULL,'Welcome email sent when a user is activated.',NULL,NULL,1,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(7,'rainlab.user::mail.restore',NULL,'Password reset instructions for front-end users.',NULL,NULL,1,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(8,'rainlab.user::mail.new_user',NULL,'Sent to administrators when a new user joins.',NULL,NULL,2,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(9,'rainlab.user::mail.reactivate',NULL,'Notification for users who reactivate their account.',NULL,NULL,1,0,'2017-02-27 23:21:02','2017-02-27 23:21:02'),(10,'jiri.jkshop::mail.cancel',NULL,'Cancel Order.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03'),(11,'jiri.jkshop::mail.payment-received',NULL,'Payment Received.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03'),(12,'jiri.jkshop::mail.new-order-paypal',NULL,'New Order - PayPal.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03'),(13,'jiri.jkshop::mail.new-order-cash-on-delivery',NULL,'New Order - Cash on Delivery.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03'),(14,'jiri.jkshop::mail.new-order-bank-tranfer',NULL,'New Order - Bank Tranfer.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03'),(15,'jiri.jkshop::mail.expedited-order-cash-on-delivery',NULL,'Expedited Order - Cash on Delivery.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03'),(16,'jiri.jkshop::mail.expedited-order',NULL,'Expedited Order.',NULL,NULL,1,0,'2017-02-27 23:21:03','2017-02-27 23:21:03');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_parameters`
--

LOCK TABLES `system_parameters` WRITE;
/*!40000 ALTER TABLE `system_parameters` DISABLE KEYS */;
INSERT INTO `system_parameters` VALUES (1,'system','update','count','0'),(2,'system','core','hash','\"eb0dccd7698b8d533b4758b812ea10ad\"'),(3,'system','core','build','434'),(4,'system','update','retry','1523088321'),(5,'system','theme','history','{\"RainLab.Vanilla\":\"rainlab-vanilla\"}'),(6,'cms','theme','active','\"rainlab-vanilla\"'),(7,'system','project','id','\"1ZGHjAQtgZGx3ZQRgBQSxAGyxZ2SzZwV1AzZ0LJIuZmIxMJRjAJEvZJLlLzH\"'),(8,'system','project','name','\"oims\"'),(9,'system','project','owner','\"adventz77\"'),(10,'backend','reportwidgets','default.dashboard','{\"welcome\":{\"class\":\"Backend\\\\ReportWidgets\\\\Welcome\",\"sortOrder\":\"51\",\"configuration\":{\"ocWidgetWidth\":10}}}');
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
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_plugin_history`
--

LOCK TABLES `system_plugin_history` WRITE;
/*!40000 ALTER TABLE `system_plugin_history` DISABLE KEYS */;
INSERT INTO `system_plugin_history` VALUES (1,'October.Demo','comment','1.0.1','First version of Demo','2016-08-28 11:43:38'),(2,'RainLab.Builder','comment','1.0.1','Initialize plugin.','2016-08-28 11:56:31'),(3,'RainLab.Builder','comment','1.0.2','Fixes the problem with selecting a plugin. Minor localization corrections. Configuration files in the list and form behaviors are now autocomplete.','2016-08-28 11:56:31'),(4,'RainLab.Builder','comment','1.0.3','Improved handling of the enum data type.','2016-08-28 11:56:31'),(5,'RainLab.Builder','comment','1.0.4','Added user permissions to work with the Builder.','2016-08-28 11:56:31'),(6,'RainLab.Builder','comment','1.0.5','Fixed permissions registration.','2016-08-28 11:56:31'),(7,'RainLab.Builder','comment','1.0.6','Fixed front-end record ordering in the Record List component.','2016-08-28 11:56:31'),(8,'RainLab.Builder','comment','1.0.7','Builder settings are now protected with user permissions. The database table column list is scrollable now. Minor code cleanup.','2016-08-28 11:56:31'),(9,'RainLab.Builder','comment','1.0.8','Added the Reorder Controller behavior.','2016-08-28 11:56:31'),(10,'RainLab.Builder','comment','1.0.9','Minor API and UI updates.','2016-08-28 11:56:31'),(11,'RainLab.Builder','comment','1.0.10','Minor styling update.','2016-08-28 11:56:31'),(12,'RainLab.Builder','comment','1.0.11','Fixed a bug where clicking placeholder in a repeater would open Inspector. Fixed a problem with saving forms with repeaters in tabs. Minor style fix.','2016-08-28 11:56:31'),(16,'RainLab.User','script','1.0.1','create_users_table.php','2016-08-28 12:33:49'),(17,'RainLab.User','script','1.0.1','create_throttle_table.php','2016-08-28 12:33:49'),(18,'RainLab.User','comment','1.0.1','Initialize plugin.','2016-08-28 12:33:49'),(19,'RainLab.User','comment','1.0.2','Seed tables.','2016-08-28 12:33:49'),(20,'RainLab.User','comment','1.0.3','Translated hard-coded text to language strings.','2016-08-28 12:33:49'),(21,'RainLab.User','comment','1.0.4','Improvements to user-interface for Location manager.','2016-08-28 12:33:49'),(22,'RainLab.User','comment','1.0.5','Added contact details for users.','2016-08-28 12:33:49'),(23,'RainLab.User','script','1.0.6','create_mail_blockers_table.php','2016-08-28 12:33:49'),(24,'RainLab.User','comment','1.0.6','Added Mail Blocker utility so users can block specific mail templates.','2016-08-28 12:33:49'),(25,'RainLab.User','comment','1.0.7','Add back-end Settings page.','2016-08-28 12:33:49'),(26,'RainLab.User','comment','1.0.8','Updated the Settings page.','2016-08-28 12:33:49'),(27,'RainLab.User','comment','1.0.9','Adds new welcome mail message for users and administrators.','2016-08-28 12:33:49'),(28,'RainLab.User','comment','1.0.10','Adds administrator-only activation mode.','2016-08-28 12:33:49'),(29,'RainLab.User','script','1.0.11','users_add_login_column.php','2016-08-28 12:33:49'),(30,'RainLab.User','comment','1.0.11','Users now have an optional login field that defaults to the email field.','2016-08-28 12:33:49'),(31,'RainLab.User','script','1.0.12','users_rename_login_to_username.php','2016-08-28 12:33:49'),(32,'RainLab.User','comment','1.0.12','Create a dedicated setting for choosing the login mode.','2016-08-28 12:33:49'),(33,'RainLab.User','comment','1.0.13','Minor fix to the Account sign in logic.','2016-08-28 12:33:49'),(34,'RainLab.User','comment','1.0.14','Minor improvements to the code.','2016-08-28 12:33:49'),(35,'RainLab.User','script','1.0.15','users_add_surname.php','2016-08-28 12:33:49'),(36,'RainLab.User','comment','1.0.15','Adds last name column to users table (surname).','2016-08-28 12:33:49'),(37,'RainLab.User','comment','1.0.16','Require permissions for settings page too.','2016-08-28 12:33:49'),(38,'RainLab.User','comment','1.1.0','!!! Profile fields and Locations have been removed.','2016-08-28 12:33:49'),(39,'RainLab.User','script','1.1.1','create_user_groups_table.php','2016-08-28 12:33:49'),(40,'RainLab.User','script','1.1.1','seed_user_groups_table.php','2016-08-28 12:33:49'),(41,'RainLab.User','comment','1.1.1','Users can now be added to groups.','2016-08-28 12:33:49'),(42,'RainLab.User','comment','1.1.2','A raw URL can now be passed as the redirect property in the Account component.','2016-08-28 12:33:49'),(43,'RainLab.User','comment','1.1.3','Adds a super user flag to the users table, reserved for future use.','2016-08-28 12:33:49'),(44,'RainLab.User','comment','1.1.4','User list can be filtered by the group they belong to.','2016-08-28 12:33:49'),(45,'RainLab.User','comment','1.1.5','Adds a new permission to hide the User settings menu item.','2016-08-28 12:33:49'),(46,'RainLab.User','script','1.2.0','users_add_deleted_at.php','2016-08-28 12:33:49'),(47,'RainLab.User','comment','1.2.0','Users can now deactivate their own accounts.','2016-08-28 12:33:49'),(48,'RainLab.User','comment','1.2.1','New feature for checking if a user is recently active/online.','2016-08-28 12:33:49'),(49,'RainLab.User','comment','1.2.2','Add bulk action button to user list.','2016-08-28 12:33:49'),(50,'RainLab.User','comment','1.2.3','Included some descriptive paragraphs in the Reset Password component markup.','2016-08-28 12:33:49'),(51,'RainLab.User','comment','1.2.4','Added a checkbox for blocking all mail sent to the user.','2016-08-28 12:33:49'),(52,'RainLab.User','script','1.2.5','update_timestamp_nullable.php','2016-08-28 12:33:49'),(53,'RainLab.User','comment','1.2.5','Database maintenance. Updated all timestamp columns to be nullable.','2016-08-28 12:33:49'),(54,'RainLab.User','script','1.2.6','users_add_last_seen.php','2016-08-28 12:33:49'),(55,'RainLab.User','comment','1.2.6','Add a dedicated last seen column for users.','2016-08-28 12:33:49'),(56,'RainLab.User','comment','1.2.7','Minor fix to user timestamp attributes.','2016-08-28 12:33:49'),(57,'RainLab.User','comment','1.2.8','Add date range filter to users list. Introduced a logout event.','2016-08-28 12:33:49'),(58,'RainLab.Blog','script','1.0.1','create_posts_table.php','2016-08-28 12:33:49'),(59,'RainLab.Blog','script','1.0.1','create_categories_table.php','2016-08-28 12:33:49'),(60,'RainLab.Blog','script','1.0.1','seed_all_tables.php','2016-08-28 12:33:49'),(61,'RainLab.Blog','comment','1.0.1','Initialize plugin.','2016-08-28 12:33:49'),(62,'RainLab.Blog','comment','1.0.2','Added the processed HTML content column to the posts table.','2016-08-28 12:33:49'),(63,'RainLab.Blog','comment','1.0.3','Category component has been merged with Posts component.','2016-08-28 12:33:49'),(64,'RainLab.Blog','comment','1.0.4','Improvements to the Posts list management UI.','2016-08-28 12:33:49'),(65,'RainLab.Blog','comment','1.0.5','Removes the Author column from blog post list.','2016-08-28 12:33:49'),(66,'RainLab.Blog','comment','1.0.6','Featured images now appear in the Post component.','2016-08-28 12:33:49'),(67,'RainLab.Blog','comment','1.0.7','Added support for the Static Pages menus.','2016-08-28 12:33:49'),(68,'RainLab.Blog','comment','1.0.8','Added total posts to category list.','2016-08-28 12:33:49'),(69,'RainLab.Blog','comment','1.0.9','Added support for the Sitemap plugin.','2016-08-28 12:33:49'),(70,'RainLab.Blog','comment','1.0.10','Added permission to prevent users from seeing posts they did not create.','2016-08-28 12:33:49'),(71,'RainLab.Blog','comment','1.0.11','Deprecate \"idParam\" component property in favour of \"slug\" property.','2016-08-28 12:33:49'),(72,'RainLab.Blog','comment','1.0.12','Fixes issue where images cannot be uploaded caused by latest Markdown library.','2016-08-28 12:33:49'),(73,'RainLab.Blog','comment','1.0.13','Fixes problem with providing pages to Sitemap and Pages plugins.','2016-08-28 12:33:49'),(74,'RainLab.Blog','comment','1.0.14','Add support for CSRF protection feature added to core.','2016-08-28 12:33:49'),(75,'RainLab.Blog','comment','1.1.0','Replaced the Post editor with the new core Markdown editor.','2016-08-28 12:33:49'),(76,'RainLab.Blog','comment','1.1.1','Posts can now be imported and exported.','2016-08-28 12:33:49'),(77,'RainLab.Blog','comment','1.1.2','Posts are no longer visible if the published date has not passed.','2016-08-28 12:33:49'),(78,'RainLab.Blog','comment','1.1.3','Added a New Post shortcut button to the blog menu.','2016-08-28 12:33:49'),(79,'RainLab.Blog','script','1.2.0','categories_add_nested_fields.php','2016-08-28 12:33:49'),(80,'RainLab.Blog','comment','1.2.0','Categories now support nesting.','2016-08-28 12:33:49'),(81,'RainLab.Blog','comment','1.2.1','Post slugs now must be unique.','2016-08-28 12:33:49'),(82,'RainLab.Blog','comment','1.2.2','Fixes issue on new installs.','2016-08-28 12:33:49'),(83,'RainLab.Blog','comment','1.2.3','Minor user interface update.','2016-08-28 12:33:49'),(84,'RainLab.Blog','script','1.2.4','update_timestamp_nullable.php','2016-08-28 12:33:49'),(85,'RainLab.Blog','comment','1.2.4','Database maintenance. Updated all timestamp columns to be nullable.','2016-08-28 12:33:49'),(86,'RainLab.Blog','comment','1.2.5','Added translation support for blog posts.','2016-08-28 12:33:49'),(87,'RainLab.Blog','comment','1.2.6','The published field can now supply a time with the date.','2016-08-28 12:33:49'),(88,'RainLab.Blog','comment','1.2.7','Introduced a new RSS feed component.','2016-08-28 12:33:49'),(89,'RainLab.Blog','comment','1.2.8','Fixes issue with translated `content_html` attribute on blog posts.','2016-08-28 12:33:49'),(90,'RainLab.Blog','comment','1.2.9','Added translation support for blog categories.','2016-08-28 12:33:49'),(91,'RainLab.Forum','script','1.0.1','create_channels_table.php','2016-08-28 12:33:49'),(92,'RainLab.Forum','script','1.0.1','create_posts_table.php','2016-08-28 12:33:49'),(93,'RainLab.Forum','script','1.0.1','create_topics_table.php','2016-08-28 12:33:49'),(94,'RainLab.Forum','script','1.0.1','create_members_table.php','2016-08-28 12:33:49'),(95,'RainLab.Forum','script','1.0.1','seed_all_tables.php','2016-08-28 12:33:50'),(96,'RainLab.Forum','comment','1.0.1','First version of Forum','2016-08-28 12:33:50'),(97,'RainLab.Forum','script','1.0.2','create_topic_watches_table.php','2016-08-28 12:33:50'),(98,'RainLab.Forum','comment','1.0.2','Add unread flags to topics','2016-08-28 12:33:50'),(99,'RainLab.Forum','script','1.0.3','members_add_mod_and_ban.php','2016-08-28 12:33:50'),(100,'RainLab.Forum','comment','1.0.3','Users can now be made moderators or be banned','2016-08-28 12:33:50'),(101,'RainLab.Forum','script','1.0.4','channels_add_hidden_and_moderated.php','2016-08-28 12:33:50'),(102,'RainLab.Forum','comment','1.0.4','Channels can now be hidden or moderated','2016-08-28 12:33:50'),(103,'RainLab.Forum','script','1.0.5','add_embed_code.php','2016-08-28 12:33:50'),(104,'RainLab.Forum','comment','1.0.5','Introduced topic and channel embedding','2016-08-28 12:33:50'),(105,'RainLab.Forum','script','1.0.6','create_channel_watches_table.php','2016-08-28 12:33:50'),(106,'RainLab.Forum','comment','1.0.6','Add unread flags to channels','2016-08-28 12:33:50'),(107,'RainLab.Forum','script','1.0.7','create_topic_followers_table.php','2016-08-28 12:33:50'),(108,'RainLab.Forum','comment','1.0.7','Forum members can now follow topics','2016-08-28 12:33:50'),(109,'RainLab.Forum','comment','1.0.8','Added Channel name to the Topics component view','2016-08-28 12:33:50'),(110,'RainLab.Forum','comment','1.0.9','Updated the Settings page','2016-08-28 12:33:50'),(111,'RainLab.Forum','comment','1.0.10','Users can now report spammers who can be banned by moderators.','2016-08-28 12:33:50'),(112,'RainLab.Forum','comment','1.0.11','Users can now quote other posts.','2016-08-28 12:33:50'),(113,'RainLab.Forum','comment','1.0.12','Improve support for CDN asset hosting.','2016-08-28 12:33:50'),(114,'RainLab.Forum','comment','1.0.13','Fixes a bug where channels cannot be selected in the Embed component inspector.','2016-08-28 12:33:50'),(115,'RainLab.Forum','comment','1.0.14','Improve the pagination code used in the component default markup.','2016-08-28 12:33:50'),(116,'RainLab.Forum','comment','1.0.15','When a User is deleted, their Member profile and posts is also deleted.','2016-08-28 12:33:50'),(117,'RainLab.Forum','comment','1.0.16','Posting topics is now throttled allowing 3 new topics every 15 minutes.','2016-08-28 12:33:50'),(118,'RainLab.Forum','comment','1.0.17','Update channel reorder page to new system reordering feature.','2016-08-28 12:33:50'),(119,'RainLab.Forum','comment','1.0.18','Minor fix to embed topic component.','2016-08-28 12:33:50'),(120,'RainLab.Forum','script','1.0.19','update_timestamp_nullable.php','2016-08-28 12:33:50'),(121,'RainLab.Forum','comment','1.0.19','Database maintenance. Updated all timestamp columns to be nullable.','2016-08-28 12:33:50'),(122,'RainLab.Forum','script','1.1.0','drop_watches_tables.php','2016-08-28 12:33:50'),(123,'RainLab.Forum','comment','1.1.0','Major performance enhancements','2016-08-28 12:33:50'),(135,'Olabs.Tenant','comment','1.0.1','Initialize plugin.','2016-09-02 16:47:23'),(136,'Olabs.Tenant','script','1.0.2','builder_table_create_olabs_tenant_organization.php','2016-09-02 16:50:34'),(137,'Olabs.Tenant','comment','1.0.2','Created table olabs_tenant_organization','2016-09-02 16:50:34'),(138,'Olabs.Tenant','script','1.0.3','builder_table_update_olabs_tenant_organizations.php','2016-09-02 16:51:38'),(139,'Olabs.Tenant','comment','1.0.3','Updated table olabs_tenant_organization','2016-09-02 16:51:38'),(140,'Olabs.Tenant','script','1.0.4','builder_table_update_olabs_tenant_organizations_2.php','2016-09-02 16:52:56'),(141,'Olabs.Tenant','comment','1.0.4','Updated table olabs_tenant_organizations','2016-09-02 16:52:56'),(142,'Olabs.Tenant','script','1.0.5','builder_table_update_olabs_tenant_organizations_3.php','2016-09-02 16:53:21'),(143,'Olabs.Tenant','comment','1.0.5','Updated table olabs_tenant_organizations','2016-09-02 16:53:21'),(144,'Keios.Multisite','script','1.0.0','create_settings_table.php','2016-09-08 09:18:15'),(145,'Keios.Multisite','comment','1.0.0','First version of Multisite','2016-09-08 09:18:15'),(146,'Keios.Multisite','comment','1.0.1','Add is_protected value to all records','2016-09-08 09:18:15'),(147,'Keios.Multisite','script','1.0.2','Fixed migrations and not-installed bug','2016-09-08 09:18:15'),(148,'Keios.Multisite','comment','1.0.2','Added cache clear function','2016-09-08 09:18:15'),(149,'Keios.Multisite','comment','1.0.3','Added translations','2016-09-08 09:18:15'),(150,'Keios.Multisite','script','1.0.4','Transitioned to October RC','2016-09-08 09:18:15'),(151,'Keios.Multisite','script','1.0.4','keios_migrate.php','2016-09-08 09:18:15'),(152,'Keios.Multisite','comment','1.0.4','Rebranded to Keios','2016-09-08 09:18:15'),(153,'Keios.Multisite','comment','1.0.5','Minor bugfix','2016-09-08 09:18:15'),(154,'Keios.Multisite','script','1.1.0','October Stable event patch','2016-09-08 09:18:15'),(155,'Keios.Multisite','comment','1.1.0','Code inspect fixes','2016-09-08 09:18:15'),(156,'Olabs.Tenant','script','1.0.2','builder_table_update_olabs_tenant_organizations.php','2016-09-08 09:49:47'),(157,'Olabs.Tenant','script','1.0.3','builder_table_update_olabs_tenant_organizations_2.php','2016-09-08 09:50:05'),(158,'Olabs.Tenant','script','1.0.4','builder_table_update_olabs_tenant_organizations_3.php','2016-09-08 09:51:33'),(159,'October.Drivers','comment','1.0.1','First version of Drivers','2016-09-09 13:34:07'),(160,'October.Drivers','comment','1.0.2','Update Guzzle library to version 5.0','2016-09-09 13:34:07'),(161,'October.Drivers','comment','1.1.0','Update AWS library to version 3.0','2016-09-09 13:34:07'),(162,'October.Drivers','comment','1.1.1','Update Guzzle library to version 6.0','2016-09-09 13:34:07'),(163,'Olabs.Tenant','script','1.0.5','builder_table_update_olabs_tenant_organizations_4.php','2016-09-11 11:23:47'),(164,'Mohsin.Rest','comment','1.0.1','First version of RESTful','2016-09-14 14:37:15'),(165,'Olabs.Tenant','script','1.0.6','builder_table_create_olabs_tenant_contents.php','2016-09-23 13:40:46'),(166,'Olabs.Tenant','comment','1.0.6','Created table olabs_tenant_contents','2016-09-23 13:40:46'),(167,'Olabs.Tenant','script','1.0.7','builder_table_update_olabs_tenant_contents.php','2016-09-23 13:45:54'),(168,'Olabs.Tenant','comment','1.0.7','Updated table olabs_tenant_contents','2016-09-23 13:45:54'),(169,'Olabs.Tenant','script','1.0.8','builder_table_update_olabs_tenant_contents_2.php','2016-09-23 13:50:45'),(170,'Olabs.Tenant','comment','1.0.8','Updated table olabs_tenant_contents','2016-09-23 13:50:45'),(171,'Olabs.Tenant','script','1.0.9','builder_table_update_olabs_tenant_organizations_5.php','2016-09-24 11:35:55'),(172,'Olabs.Tenant','comment','1.0.9','Updated table olabs_tenant_organizations','2016-09-24 11:35:55'),(173,'Olabs.Parsers','comment','1.0.1','Initialize plugin.','2016-10-04 15:26:55'),(174,'Olabs.Pusher','comment','1.0.1','Initialize plugin.','2016-10-07 10:55:42'),(175,'Olabs.Pusher','script','1.0.2','builder_table_create_olabs_pusher_activity.php','2016-10-07 11:02:25'),(176,'Olabs.Pusher','comment','1.0.2','Created table olabs_pusher_activity','2016-10-07 11:02:25'),(177,'Olabs.Pusher','script','1.0.3','builder_table_update_olabs_pusher_activity.php','2016-10-07 11:04:33'),(178,'Olabs.Pusher','comment','1.0.3','Updated table olabs_pusher_activity','2016-10-07 11:04:33'),(179,'Olabs.Tenant','script','1.0.10','builder_table_update_olabs_tenant_organizations_6.php','2016-10-08 15:22:00'),(180,'Olabs.Tenant','comment','1.0.10','Updated table olabs_tenant_organizations','2016-10-08 15:22:00'),(181,'Olabs.Tenant','script','1.0.11','builder_table_update_olabs_tenant_organizations_7.php','2016-10-08 17:20:17'),(182,'Olabs.Tenant','comment','1.0.11','Updated table olabs_tenant_organizations','2016-10-08 17:20:17'),(198,'Olabs.Pusher','script','1.0.4','builder_table_create_olabs_pusher_registrations.php','2016-10-15 17:49:00'),(199,'Olabs.Pusher','comment','1.0.4','Created table olabs_pusher_registrations','2016-10-15 17:49:00'),(202,'Olabs.Pusher','script','1.0.5','builder_table_update_olabs_pusher_platforms.php','2016-10-23 15:39:42'),(203,'Olabs.Pusher','comment','1.0.5','Updated table olabs_pusher_registrations','2016-10-23 15:39:42'),(204,'Olabs.Pusher','script','1.0.6','builder_table_update_olabs_pusher_platforms_2.php','2016-10-23 15:50:13'),(205,'Olabs.Pusher','comment','1.0.6','Updated table olabs_pusher_platforms','2016-10-23 15:50:13'),(206,'Olabs.Tenant','script','1.0.12','builder_table_create_olabs_tenant_members.php','2016-10-24 17:07:27'),(207,'Olabs.Tenant','comment','1.0.12','Created table olabs_tenant_members','2016-10-24 17:07:27'),(208,'Olabs.Tenant','script','1.0.13','builder_table_update_olabs_tenant_members.php','2016-10-24 17:07:49'),(209,'Olabs.Tenant','comment','1.0.13','Updated table olabs_tenant_members','2016-10-24 17:07:49'),(210,'Olabs.Tenant','script','1.0.14','builder_table_update_olabs_tenant_members_2.php','2016-10-24 18:46:17'),(211,'Olabs.Tenant','comment','1.0.14','Updated table olabs_tenant_members','2016-10-24 18:46:17'),(215,'Olabs.App','comment','1.0.1','Initialize plugin.','2016-11-06 15:50:21'),(216,'Olabs.Tenant','script','1.0.15','builder_table_create_olabs_tenant_content_categories.php','2016-11-06 16:42:41'),(217,'Olabs.Tenant','comment','1.0.15','Created table olabs_tenant_content_categories','2016-11-06 16:42:41'),(218,'Olabs.Tenant','script','1.0.16','builder_table_update_olabs_tenant_content_categories.php','2016-11-06 16:48:35'),(219,'Olabs.Tenant','comment','1.0.16','Updated table olabs_tenant_content_categories','2016-11-06 16:48:35'),(220,'Olabs.Tenant','script','1.0.17','builder_table_create_olabs_tenant_contents_categories.php','2016-11-06 16:57:51'),(221,'Olabs.Tenant','comment','1.0.17','Created table olabs_tenant_contents_categories','2016-11-06 16:57:51'),(222,'Olabs.Tenant','script','1.0.18','builder_table_update_olabs_tenant_contents_categories.php','2016-11-06 16:58:44'),(223,'Olabs.Tenant','comment','1.0.18','Updated table olabs_tenant_contents_categories','2016-11-06 16:58:44'),(224,'Olabs.Tenant','script','1.0.19','builder_table_update_olabs_tenant_content_categories_2.php','2016-11-06 17:05:08'),(225,'Olabs.Tenant','comment','1.0.19','Updated table olabs_tenant_content_categories','2016-11-06 17:05:08'),(277,'Olabs.Oims','comment','1.0.1','Initialize plugin.','2017-01-09 19:03:02'),(278,'Olabs.Oims','script','1.0.2','builder_table_create_olabs_oims_projects.php','2017-01-09 19:06:03'),(279,'Olabs.Oims','comment','1.0.2','Created table olabs_oims_projects','2017-01-09 19:06:03'),(280,'Olabs.Oims','script','1.0.3','builder_table_create_olabs_oims_purchase_orders.php','2017-01-09 19:13:14'),(281,'Olabs.Oims','comment','1.0.3','Created table olabs_oims_purchase_orders','2017-01-09 19:13:14'),(282,'Olabs.Oims','script','1.0.4','builder_table_update_olabs_oims_purchase_orders.php','2017-01-09 19:14:35'),(283,'Olabs.Oims','comment','1.0.4','Updated table olabs_oims_purchase_orders','2017-01-09 19:14:35'),(284,'Olabs.Oims','script','1.0.5','builder_table_create_olabs_oims_item_categories.php','2017-01-13 16:26:55'),(285,'Olabs.Oims','comment','1.0.5','Created table olabs_oims_item_categories','2017-01-13 16:26:55'),(286,'Olabs.Oims','script','1.0.6','builder_table_create_olabs_oims_products.php','2017-01-13 16:29:26'),(287,'Olabs.Oims','comment','1.0.6','Created table olabs_oims_products','2017-01-13 16:29:26'),(288,'Olabs.Oims','script','1.0.7','builder_table_create_olabs_oims_purchase_order_items.php','2017-01-13 18:47:18'),(289,'Olabs.Oims','comment','1.0.7','Created table olabs_oims_purchase_order_items','2017-01-13 18:47:18'),(290,'Olabs.Oims','script','1.0.8','builder_table_update_olabs_oims_purchase_order_items.php','2017-01-13 18:51:51'),(298,'Mohsin.Rest','comment','1.0.2','!!! Contains breaking changes and adds default behaviour for index, store, show, update, destroy verbs.','2017-02-10 17:25:43'),(299,'Mohsin.Rest','comment','1.0.3','Added support for querying relations for the index and show verbs.','2017-02-10 17:25:43'),(300,'RainLab.Builder','comment','1.0.12','Added support for the Trigger property to the Media Finder widget configuration. Names of form fields and list columns definition files can now contain underscores.','2017-02-10 17:25:43'),(301,'RainLab.Builder','comment','1.0.13','Minor styling fix on the database editor.','2017-02-10 17:25:43'),(302,'RainLab.Builder','comment','1.0.14','Added support for published_at timestamp field','2017-02-10 17:25:43'),(303,'RainLab.Builder','comment','1.0.15','Fixed a bug where saving a localization string in Inspector could cause a JavaScript error. Added support for Timestamps and Soft Deleting for new models.','2017-02-10 17:25:43'),(304,'RainLab.Builder','comment','1.0.16','Fixed a bug when saving a form with the Repeater widget in a tab could create invalid fields in the form\'s outside area. Added a check that prevents creating localization strings inside other existing strings.','2017-02-10 17:25:43'),(305,'RainLab.Builder','comment','1.0.17','Added support Trigger attribute support for RecordFinder and Repeater form widgets.','2017-02-10 17:25:43'),(306,'RainLab.Builder','comment','1.0.18','Fixes a bug where \'::class\' notations in a model class definition could prevent the model from appearing in the Builder model list. Added emptyOption property support to the dropdown form control.','2017-02-10 17:25:43'),(307,'RainLab.Builder','comment','1.0.19','Added a feature allowing to add all database columns to a list definition. Added max length validation for database table and column names.','2017-02-10 17:25:43'),(308,'RainLab.Builder','comment','1.0.20','Fixes a bug where form the builder could trigger the \"current.hasAttribute is not a function\" error.','2017-02-10 17:25:43'),(309,'RainLab.User','comment','1.2.9','Add invitation mail for new accounts created in the back-end.','2017-02-10 17:25:43'),(310,'RainLab.User','script','1.3.0','users_add_guest_flag.php','2017-02-10 17:25:43'),(311,'RainLab.User','script','1.3.0','users_add_superuser_flag.php','2017-02-10 17:25:43'),(312,'RainLab.User','comment','1.3.0','Introduced guest user accounts.','2017-02-10 17:25:43'),(313,'RainLab.User','comment','1.3.1','User notification variables can now be extended.','2017-02-10 17:25:43'),(314,'RainLab.User','comment','1.3.2','Minor fix to the Auth::register method.','2017-02-10 17:25:43'),(315,'RainLab.User','comment','1.3.3','Allow prevention of concurrent user sessions via the user settings.','2017-02-10 17:25:43'),(316,'RainLab.User','comment','1.3.4','Added force secure protocol property to the account component.','2017-02-10 17:25:43'),(317,'RainLab.Blog','comment','1.2.10','Added translation support for post slugs.','2017-02-10 17:25:43'),(318,'RainLab.Blog','comment','1.2.11','Fixes bug where excerpt is not translated.','2017-02-10 17:25:43'),(319,'RainLab.Blog','comment','1.2.12','Description field added to category form.','2017-02-10 17:25:43'),(320,'RainLab.Blog','comment','1.2.13','Improved support for Static Pages menus, added a blog post and all blog posts.','2017-02-10 17:25:43'),(321,'RainLab.Blog','comment','1.2.14','Added post exception property to the post list component, useful for showing related posts.','2017-02-10 17:25:43'),(322,'RainLab.Forum','comment','1.1.1','Fixes bug throwing error when a forum topic has no posts.','2017-02-10 17:25:43'),(466,'Olabs.Oims','script','1.0.1','create_categories_table.php','2017-02-28 01:42:04'),(467,'Olabs.Oims','script','1.0.2','create_brands_table.php','2017-02-28 01:42:04'),(468,'Olabs.Oims','script','1.0.3','create_taxes_table.php','2017-02-28 01:42:05'),(469,'Olabs.Oims','script','1.0.4','create_carriers_table.php','2017-02-28 01:42:05'),(470,'Olabs.Oims','script','1.0.5','create_order_statuses_table.php','2017-02-28 01:42:05'),(471,'Olabs.Oims','script','1.0.6','create_products_table.php','2017-02-28 01:42:06'),(472,'Olabs.Oims','script','1.0.6','create_products_categories.php','2017-02-28 01:42:07'),(473,'Olabs.Oims','script','1.0.6','create_products_carriers_disallowed.php','2017-02-28 01:42:07'),(474,'Olabs.Oims','script','1.0.6','create_products_products_featured.php','2017-02-28 01:42:08'),(475,'Olabs.Oims','script','1.0.6','create_products_products_accessories.php','2017-02-28 01:42:09'),(476,'Olabs.Oims','script','1.0.7','create_orders_table.php','2017-02-28 01:42:09'),(477,'Olabs.Oims','script','1.0.8','create_products_users_price.php','2017-02-28 01:42:10'),(478,'Olabs.Oims','script','1.0.8','create_categories_users_sale.php','2017-02-28 01:42:11'),(479,'Olabs.Oims','comment','1.0.8','Add support RainLab.User (sale for category, individual prices)','2017-02-28 01:42:11'),(480,'Olabs.Oims','script','1.0.9','create_sample_data.php','2017-02-28 01:42:11'),(481,'Olabs.Oims','comment','1.0.9','First Release','2017-02-28 01:42:11'),(482,'Olabs.Oims','script','1.0.10','Component - My Orders - fix link on invoice','2017-02-28 01:42:11'),(483,'Olabs.Oims','comment','1.0.10','Fixes','2017-02-28 01:42:11'),(484,'Olabs.Oims','comment','1.0.11','Backend - language files [EN], Fixes: Links featured + accessories, Basket - work with product minimum quantity, Complete Order - check stock before order','2017-02-28 01:42:12'),(485,'Olabs.Oims','comment','1.0.12','Automatic rounding into order total price - Paypal allow max 2 decimal places','2017-02-28 01:42:12'),(486,'Olabs.Oims','comment','1.0.13','Orders - fix search, add hidden fields into order list (Email, Phone, First name, Address, Postcode, City, Country), all fields are searchable','2017-02-28 01:42:12'),(487,'Olabs.Oims','comment','1.0.14','Fixes: Order detail -  names on list of customers, Orders list - little UI bug','2017-02-28 01:42:12'),(488,'Olabs.Oims','comment','1.0.15','Fix: Carrier - free shipping; Add: Italian translation','2017-02-28 01:42:12'),(489,'Olabs.Oims','script','1.1.0','create_properties_table.php','2017-02-28 01:42:13'),(490,'Olabs.Oims','script','1.1.0','create_property_options_table.php','2017-02-28 01:42:13'),(491,'Olabs.Oims','script','1.1.0','create_products_properties.php','2017-02-28 01:42:16'),(492,'Olabs.Oims','comment','1.1.0','Properties - product properties: sizes, colors, etc.. (https://octobercms.com/plugin/olabs-oims#Properties)','2017-02-28 01:42:16'),(493,'Olabs.Oims','script','1.1.1','update_111.php','2017-02-28 01:42:17'),(494,'Olabs.Oims','comment','1.1.1','Add: Order - note, county; New page variables for components (Products By Category, Products By Brand)','2017-02-28 01:42:17'),(495,'Olabs.Oims','script','1.1.2','create_products_options.php','2017-02-28 01:42:18'),(496,'Olabs.Oims','comment','1.1.2','Add: Product - Advanced Properties ( You can add property options with pivot data: title, description, price difference, image ); Update Components: Basket, Product Detail','2017-02-28 01:42:18'),(497,'Olabs.Oims','comment','1.1.3','Fix: Advanced Properties - Options - Order by','2017-02-28 01:42:18'),(498,'Olabs.Oims','script','1.1.4','update_114.php','2017-02-28 01:42:19'),(499,'Olabs.Oims','comment','1.1.4','Add: Order - tracking number for tracking package','2017-02-28 01:42:19'),(500,'Olabs.Oims','comment','1.2.0','Add: Stripe payment gateway','2017-02-28 01:42:19'),(501,'Olabs.Oims','comment','1.2.1','Add: Czech translation','2017-02-28 01:42:19'),(502,'Olabs.Oims','script','1.2.2','create_rainlab_extend_users.php','2017-02-28 01:42:21'),(503,'Olabs.Oims','comment','1.2.2','Add: Settings - default image; Rainlab.User: save billing and delivery address into user; Products Components - add or extend order by','2017-02-28 01:42:21'),(504,'Olabs.Oims','comment','1.2.3','Small fixes and improvements: add some language texts, page 404 for non-existent slug - products, categories, brands','2017-02-28 01:42:21'),(505,'Olabs.Oims','comment','1.2.4','Fix: order list - order by order status','2017-02-28 01:42:21'),(506,'Olabs.Oims','comment','1.3.0','Added translation support','2017-02-28 01:42:21'),(507,'Olabs.Oims','comment','1.3.1','Small Fixes','2017-02-28 01:42:21'),(508,'Olabs.Oims','comment','1.3.2','Fix name of Users without surname','2017-02-28 01:42:21'),(509,'Olabs.Oims','script','1.4.0','create_coupons_table.php','2017-02-28 01:42:22'),(510,'Olabs.Oims','script','1.4.0','create_coupons_categories.php','2017-02-28 01:42:23'),(511,'Olabs.Oims','script','1.4.0','create_coupons_products.php','2017-02-28 01:42:25'),(512,'Olabs.Oims','script','1.4.0','create_coupons_users.php','2017-02-28 01:42:27'),(513,'Olabs.Oims','script','1.4.0','udpate_orders_140.php','2017-02-28 01:42:29'),(514,'Olabs.Oims','comment','1.4.0','Coupons - discount coupons (https://octobercms.com/plugin/olabs-oims#Coupons)','2017-02-28 01:42:29'),(515,'Olabs.Oims','comment','1.4.1','Small Fixes in Coupons','2017-02-28 01:42:29'),(516,'Olabs.Oims','comment','1.4.2','Increased character limits (name, title, etc.) to 255','2017-02-28 01:42:29'),(517,'Olabs.Oims','comment','1.4.3','Add: German translation','2017-02-28 01:42:29'),(518,'Olabs.Oims','script','1.4.4','update_144.php','2017-02-28 01:42:29'),(519,'Olabs.Oims','comment','1.4.4','Add Components: BrandDetails, BrandsList. Thanks to Nick Gavanozov','2017-02-28 01:42:29'),(520,'Olabs.Oims','comment','1.4.5','Small Fix in Coupons - datepicker issue','2017-02-28 01:42:30'),(521,'Olabs.Oims','comment','1.4.6','Add Components: BreadcrumbsCategory, BreadcrumbsProduct','2017-02-28 01:42:30'),(522,'Olabs.Oims','comment','1.4.7','Component BreadcrumbsProduct - fix URL','2017-02-28 01:42:30'),(523,'Olabs.Oims','script','1.5.0','create_payment_gateways_table.php','2017-02-28 01:42:31'),(524,'Olabs.Oims','script','1.5.0','update_orders_150.php','2017-02-28 01:42:33'),(525,'Olabs.Oims','comment','1.5.0','Check upgrade guide before upgrading: Add payment gateways, remove previous payment system (https://octobercms.com/plugin/olabs-oims#upgrade)','2017-02-28 01:42:33'),(526,'Olabs.Oims','comment','1.5.1','Basket component: moved htm files into basket folder, for easy overriding. Payment Gateways: gateway title is translatable.','2017-02-28 01:42:33'),(527,'Olabs.Oims','script','1.5.2','update_152.php','2017-02-28 01:42:37'),(528,'Olabs.Oims','comment','1.5.2','Small fixes: MyOrderDetail component, MyOrders component - if user or id order is bad, return 404, Add Foreign keys','2017-02-28 01:42:37'),(529,'Olabs.Oims','comment','1.5.3','Basket Component: added method \'onGetSessionBasket\' - now you can easy call this method and get complete basket as JSON','2017-02-28 01:42:37'),(530,'Olabs.Oims','comment','1.5.4','Upgrade: Omnipay payment gateways, Small Fixes in Components','2017-02-28 01:42:37'),(531,'Olabs.Oims','comment','1.5.5','Add payment gateways: TwoCheckoutPlus, TwoCheckoutPlus_Token','2017-02-28 01:42:37'),(532,'Olabs.Oims','comment','1.5.6','Fixed DB error on some MySQL databases','2017-02-28 01:42:38'),(533,'Olabs.Oims','comment','1.5.7','Small fixes: Product Detail component fixed URL for accessories and featured products','2017-02-28 01:42:38'),(534,'Olabs.Oims','comment','1.5.8','Add: French translation (thanks Théo Corée)','2017-02-28 01:42:38'),(535,'Olabs.Oims','comment','1.5.9','Add security checks for payment components','2017-02-28 01:42:38'),(536,'Olabs.Oims','script','1.6.0','update_statuses_160.php','2017-02-28 01:42:39'),(537,'Olabs.Oims','comment','1.6.0','Add Extended Inventory Management. OrderStatus - add new fields: disallow for gateway, qty decrease, qty increase back','2017-02-28 01:42:39'),(538,'Olabs.Oims','script','1.7.0','create_companies_table.php','2017-02-28 02:00:58'),(539,'Olabs.Oims','comment','1.7.0','Array','2017-02-28 02:00:58'),(540,'Olabs.Oims','script','1.6.1','builder_table_create_olabs_oims_companies.php','2017-02-28 03:16:49'),(541,'Olabs.Oims','comment','1.6.1','Created table olabs_oims_companies','2017-02-28 03:16:49'),(542,'Olabs.Oims','script','1.6.2','builder_table_create_olabs_oims_projects.php','2017-02-28 03:16:50'),(543,'Olabs.Oims','comment','1.6.2','Created table olabs_oims_projects','2017-02-28 03:16:50'),(544,'Olabs.Oims','script','1.6.3','create_quotes_table.php','2017-02-28 04:06:32'),(545,'Olabs.Oims','comment','1.6.3','Add quotes','2017-02-28 04:06:32'),(546,'Olabs.Oims','script','1.6.4','builder_table_update_olabs_oims_quotes.php','2017-02-28 04:14:42'),(547,'Olabs.Oims','comment','1.6.4','Updated table olabs_oims_quotes','2017-02-28 04:14:42'),(548,'Olabs.Oims','script','1.6.5','builder_table_create_olabs_oims_quote_products.php','2017-02-28 06:23:35'),(549,'Olabs.Oims','comment','1.6.5','Created table olabs_oims_quote_products','2017-02-28 06:23:36'),(550,'Olabs.Oims','script','1.6.6','builder_table_update_olabs_oims_quotes_2.php','2017-02-28 13:34:02'),(551,'Olabs.Oims','comment','1.6.6','Updated table olabs_oims_quotes','2017-02-28 13:34:02'),(552,'Olabs.Oims','script','1.6.7','builder_table_update_olabs_oims_quotes_3.php','2017-02-28 22:58:50'),(553,'Olabs.Oims','comment','1.6.7','Updated table olabs_oims_quotes','2017-02-28 22:58:50'),(554,'Olabs.Oims','script','1.7.0','builder_table_create_olabs_oims_customers.php','2017-02-28 23:36:44'),(555,'Olabs.Oims','script','1.7.1','builder_table_create_olabs_oims_suppliers.php','2017-02-28 23:37:52'),(556,'Olabs.Oims','comment','1.7.1','Created table olabs_oims_suppliers','2017-02-28 23:37:52'),(557,'Olabs.Oims','script','1.7.2','builder_table_update_olabs_oims_customers.php','2017-02-28 23:38:03'),(558,'Olabs.Oims','comment','1.7.2','Updated table olabs_oims_customers','2017-02-28 23:38:03'),(559,'Olabs.Oims','script','1.7.3','builder_table_create_olabs_oims_purchases.php','2017-03-01 00:35:52'),(560,'Olabs.Oims','comment','1.7.3','Created table olabs_oims_purchases','2017-03-01 00:35:52'),(561,'Olabs.Oims','script','1.7.4','builder_table_create_olabs_oims_purchase_products.php','2017-03-01 00:38:45'),(562,'Olabs.Oims','comment','1.7.4','Created table olabs_oims_purchase_products','2017-03-01 00:38:45'),(563,'Olabs.Oims','script','1.7.5','builder_table_create_olabs_oims_sales.php','2017-03-01 00:42:34'),(564,'Olabs.Oims','comment','1.7.5','Created table olabs_oims_sales','2017-03-01 00:42:34'),(565,'Olabs.Oims','script','1.7.6','builder_table_create_olabs_oims_sale_products.php','2017-03-01 00:42:34'),(566,'Olabs.Oims','comment','1.7.6','Created table olabs_oims_sale_products','2017-03-01 00:42:35'),(567,'Olabs.Oims','script','1.7.7','builder_table_update_olabs_oims_sales_products.php','2017-03-01 00:48:30'),(568,'Olabs.Oims','comment','1.7.7','Updated table olabs_oims_sale_products','2017-03-01 00:48:31'),(569,'Olabs.Oims','script','1.7.8','builder_table_create_olabs_oims_work_groups.php','2017-03-07 06:55:29'),(570,'Olabs.Oims','comment','1.7.8','Created table olabs_oims_work_groups','2017-03-07 06:55:29'),(571,'Olabs.Oims','script','1.7.9','builder_table_create_olabs_oims_project_works.php','2017-03-07 07:15:00'),(572,'Olabs.Oims','comment','1.7.9','Created table olabs_oims_project_works','2017-03-07 07:15:00'),(573,'Olabs.Oims','script','1.7.10','builder_table_create_olabs_oims_units.php','2017-03-07 07:16:22'),(574,'Olabs.Oims','comment','1.7.10','Created table olabs_oims_units','2017-03-07 07:16:22'),(575,'Olabs.Oims','script','1.7.11','builder_table_update_olabs_oims_units.php','2017-03-07 07:20:07'),(576,'Olabs.Oims','comment','1.7.11','Updated table olabs_oims_units','2017-03-07 07:20:07'),(577,'Olabs.Oims','script','1.7.12','builder_table_update_olabs_oims_units_2.php','2017-03-07 07:31:00'),(578,'Olabs.Oims','comment','1.7.12','Updated table olabs_oims_units','2017-03-07 07:31:00'),(579,'Olabs.Oims','script','1.7.13','builder_table_create_olabs_oims_project_work_materials.php','2017-03-07 07:35:18'),(580,'Olabs.Oims','comment','1.7.13','Created table olabs_oims_project_work_materials','2017-03-07 07:35:18'),(581,'Olabs.Oims','script','1.7.14','builder_table_update_olabs_oims_project_work_products.php','2017-03-07 08:57:15'),(582,'Olabs.Oims','comment','1.7.14','Updated table olabs_oims_project_work_materials','2017-03-07 08:57:15'),(583,'Olabs.Oims','script','1.7.15','builder_table_create_olabs_oims_project_progress.php','2017-03-09 04:18:14'),(584,'Olabs.Oims','comment','1.7.15','Created table olabs_oims_project_progress','2017-03-09 04:18:14'),(585,'Olabs.Oims','script','1.7.16','builder_table_create_olabs_oims_project_progress_items.php','2017-03-09 04:20:56'),(586,'Olabs.Oims','comment','1.7.16','Created table olabs_oims_project_progress_items','2017-03-09 04:20:56'),(587,'Olabs.Oims','script','1.7.17','builder_table_update_olabs_oims_project_progress.php','2017-03-09 04:26:34'),(588,'Olabs.Oims','comment','1.7.17','Updated table olabs_oims_project_progress','2017-03-09 04:26:35'),(589,'Olabs.Oims','script','1.7.18','builder_table_create_olabs_oims_statuses.php','2017-03-12 02:40:44'),(590,'Olabs.Oims','comment','1.7.18','Created table olabs_oims_statuses','2017-03-12 02:40:44'),(591,'Olabs.Oims','script','1.7.19','builder_table_create_olabs_oims_status_history.php','2017-03-12 03:28:14'),(592,'Olabs.Oims','comment','1.7.19','Created table olabs_oims_status_history','2017-03-12 03:28:14'),(593,'Olabs.Oims','script','1.7.20','builder_table_create_olabs_oims_user_projects.php','2017-03-13 03:51:39'),(594,'Olabs.Oims','comment','1.7.20','Created table olabs_oims_user_projects','2017-03-13 03:51:39'),(595,'Olabs.Oims','script','1.7.21','builder_table_update_olabs_oims_quotes_4.php','2017-03-21 12:34:39'),(596,'Olabs.Oims','comment','1.7.21','Updated table olabs_oims_quotes','2017-03-21 12:34:39'),(597,'Olabs.Oims','script','1.7.22','builder_table_update_olabs_oims_quotes_5.php','2017-03-21 12:34:39'),(598,'Olabs.Oims','comment','1.7.22','Updated table olabs_oims_quotes','2017-03-21 12:34:39'),(599,'Olabs.Oims','script','1.7.23','builder_table_update_olabs_oims_quotes_6.php','2017-03-21 12:34:39'),(600,'Olabs.Oims','comment','1.7.23','Updated table olabs_oims_quotes','2017-03-21 12:34:39'),(601,'Olabs.Oims','script','1.7.24','builder_table_update_olabs_oims_quotes_7.php','2017-03-21 12:34:39'),(602,'Olabs.Oims','comment','1.7.24','Updated table olabs_oims_quotes','2017-03-21 12:34:39'),(603,'Olabs.Oims','script','1.7.25','builder_table_update_olabs_oims_purchases.php','2017-03-21 12:34:39'),(604,'Olabs.Oims','comment','1.7.25','Updated table olabs_oims_purchases','2017-03-21 12:34:39'),(605,'Olabs.Oims','script','1.7.26','builder_table_update_olabs_oims_sales.php','2017-03-21 12:34:39'),(606,'Olabs.Oims','comment','1.7.26','Updated table olabs_oims_sales','2017-03-21 12:34:39'),(607,'Olabs.Oims','script','1.7.27','builder_table_update_olabs_oims_sales_2.php','2017-03-21 12:34:39'),(608,'Olabs.Oims','comment','1.7.27','Updated table olabs_oims_sales','2017-03-21 12:34:39'),(609,'Olabs.Oims','script','1.7.28','builder_table_update_olabs_oims_sales_3.php','2017-03-21 12:34:39'),(610,'Olabs.Oims','comment','1.7.28','Updated table olabs_oims_sales','2017-03-21 12:34:39'),(611,'Olabs.Oims','script','1.7.29','builder_table_update_olabs_oims_products.php','2017-03-31 07:42:34'),(612,'Olabs.Oims','comment','1.7.29','Updated table olabs_oims_products','2017-03-31 07:42:34'),(613,'Olabs.Oims','script','1.7.30','builder_table_update_olabs_oims_purchase_products.php','2017-03-31 07:42:34'),(614,'Olabs.Oims','comment','1.7.30','Updated table olabs_oims_purchase_products','2017-03-31 07:42:34'),(615,'Olabs.Oims','script','1.7.31','builder_table_update_olabs_oims_sales_products_2.php','2017-03-31 07:42:34'),(616,'Olabs.Oims','comment','1.7.31','Updated table olabs_oims_sales_products','2017-03-31 07:42:34'),(617,'Olabs.Oims','script','1.7.32','builder_table_update_olabs_oims_quote_products.php','2017-03-31 07:42:34'),(618,'Olabs.Oims','comment','1.7.32','Updated table olabs_oims_quote_products','2017-03-31 07:42:34'),(619,'Olabs.Oims','script','1.7.33','builder_table_update_olabs_oims_purchases_2.php','2017-04-02 07:01:06'),(620,'Olabs.Oims','comment','1.7.33','Updated table olabs_oims_purchases','2017-04-02 07:01:06'),(621,'Olabs.Oims','script','1.7.34','builder_table_update_backend_users.php','2017-04-16 10:21:43'),(622,'Olabs.Oims','comment','1.7.34','Updated table backend_users','2017-04-16 10:21:43'),(623,'Olabs.Oims','script','1.7.35','builder_table_update_olabs_oims_companies.php','2017-04-16 10:21:43'),(624,'Olabs.Oims','comment','1.7.35','Updated table olabs_oims_companies','2017-04-16 10:21:43'),(625,'Olabs.Oims','script','1.7.36','builder_table_update_olabs_oims_projects.php','2017-04-16 10:21:43'),(626,'Olabs.Oims','comment','1.7.36','Updated table olabs_oims_projects','2017-04-16 10:21:43'),(627,'Olabs.Oims','script','1.7.37','builder_table_update_backend_users_2.php','2017-04-16 10:36:45'),(628,'Olabs.Oims','comment','1.7.37','Updated table backend_users','2017-04-16 10:36:45'),(629,'Olabs.Oims','script','1.7.38','builder_table_update_olabs_oims_companies_2.php','2017-04-16 10:36:45'),(630,'Olabs.Oims','comment','1.7.38','Updated table olabs_oims_companies','2017-04-16 10:36:45'),(631,'Olabs.Oims','script','1.7.39','builder_table_create_olabs_oims_machineries.php','2017-04-20 18:14:54'),(632,'Olabs.Oims','comment','1.7.39','Created table olabs_oims_machineries','2017-04-20 18:14:54'),(633,'Olabs.Oims','script','1.7.40','builder_table_create_olabs_oims_manpowers.php','2017-04-20 18:14:54'),(634,'Olabs.Oims','comment','1.7.40','Created table olabs_oims_manpowers','2017-04-20 18:14:54'),(635,'Olabs.Oims','script','1.7.41','builder_table_create_olabs_oims_machinery_products.php','2017-04-20 18:14:54'),(636,'Olabs.Oims','comment','1.7.41','Created table olabs_oims_machinery_products','2017-04-20 18:14:54'),(637,'Olabs.Oims','script','1.7.42','builder_table_create_olabs_oims_manpower_products.php','2017-04-20 18:14:54'),(638,'Olabs.Oims','comment','1.7.42','Created table olabs_oims_manpower_products','2017-04-20 18:14:54'),(639,'Cyd293.Extenders','comment','1.0.1','Initialize plugin.','2017-04-28 04:32:08'),(640,'RainLab.Blog','comment','1.2.15','Back-end navigation sort order updated.','2017-04-28 04:32:08'),(641,'RainLab.Blog','comment','1.2.16','Added `nextPost` and `previousPost` to the blog post component.','2017-04-28 04:32:08'),(642,'RainLab.Builder','comment','1.0.21','Back-end navigation sort order updated.','2017-04-28 04:32:08'),(644,'Reportico.Reports','comment','1.0.1','Initialize plugin.','2017-05-10 04:55:45'),(645,'Reportico.Reports','comment','1.1.0','Improved Styling.','2017-05-10 04:55:45'),(646,'Olabs.Oims','script','1.7.43','builder_table_create_olabs_oims_employee_type.php','2017-05-25 11:27:36'),(647,'Olabs.Oims','comment','1.7.43','Created table olabs_oims_employee_type','2017-05-25 11:27:36'),(648,'Olabs.Oims','script','1.7.44','builder_table_update_olabs_oims_employee_type.php','2017-05-25 11:27:36'),(649,'Olabs.Oims','comment','1.7.44','Updated table olabs_oims_employee_type','2017-05-25 11:27:36'),(650,'Olabs.Oims','script','1.7.45','builder_table_update_olabs_oims_employee_types.php','2017-05-25 11:27:36'),(651,'Olabs.Oims','comment','1.7.45','Updated table olabs_oims_employee_type','2017-05-25 11:27:36'),(652,'Olabs.Oims','script','1.8.1','builder_table_create_olabs_oims_offrole_employees.php','2017-05-25 11:27:36'),(653,'Olabs.Oims','comment','1.8.1','Created table olabs_oims_offrole_employees','2017-05-25 11:27:36'),(654,'Olabs.Oims','script','1.8.2','builder_table_update_olabs_oims_offrole_employees.php','2017-05-25 11:27:36'),(655,'Olabs.Oims','comment','1.8.2','Updated table olabs_oims_offrole_employees','2017-05-25 11:27:36'),(656,'Olabs.Oims','script','1.8.3','builder_table_update_backend_users_3.php','2017-05-25 11:27:36'),(657,'Olabs.Oims','comment','1.8.3','Updated table backend_users','2017-05-25 11:27:36'),(658,'Olabs.Oims','script','1.8.4','builder_table_update_olabs_oims_offrole_employees_2.php','2017-05-25 11:27:36'),(659,'Olabs.Oims','comment','1.8.4','Updated table olabs_oims_offrole_employees','2017-05-25 11:27:36'),(660,'Olabs.Oims','script','1.8.5','builder_table_create_olabs_oims_attendances.php','2017-05-25 11:27:36'),(661,'Olabs.Oims','comment','1.8.5','Created table olabs_oims_attendances','2017-05-25 11:27:36'),(662,'Olabs.Tasks','comment','1.0.1','Initialize plugin.','2017-05-25 11:27:36'),(663,'Olabs.Tasks','script','1.0.2','builder_table_create_olabs_tasks_logs.php','2017-05-25 11:27:36'),(664,'Olabs.Tasks','comment','1.0.2','Created table olabs_tasks_logs','2017-05-25 11:27:36'),(665,'Olabs.Tasks','script','1.0.3','builder_table_create_olabs_tasks_tasks.php','2017-05-25 11:27:36'),(666,'Olabs.Tasks','comment','1.0.3','Created table olabs_tasks_tasks','2017-05-25 11:27:36'),(667,'Olabs.Tasks','script','1.0.4','builder_table_update_olabs_tasks_tasks.php','2017-05-25 11:27:36'),(668,'Olabs.Tasks','comment','1.0.4','Updated table olabs_tasks_tasks','2017-05-25 11:27:36'),(669,'Olabs.Tasks','script','1.0.5','builder_table_update_olabs_tasks_tasks_2.php','2017-05-25 11:27:36'),(670,'Olabs.Tasks','comment','1.0.5','Updated table olabs_tasks_tasks','2017-05-25 11:27:36'),(671,'Olabs.Oims','script','1.8.6','builder_table_update_olabs_oims_offrole_employees_3.php','2017-06-02 09:25:52'),(672,'Olabs.Oims','comment','1.8.6','Updated table olabs_oims_offrole_employees','2017-06-02 09:25:52'),(673,'Olabs.Oims','script','1.8.7','builder_table_update_olabs_oims_attendances.php','2017-06-02 09:25:52'),(674,'Olabs.Oims','comment','1.8.7','Updated table olabs_oims_attendances','2017-06-02 09:25:52'),(675,'Olabs.Oims','script','1.8.8','builder_table_create_olabs_oims_expense_on_materials.php','2017-06-10 06:27:56'),(676,'Olabs.Oims','comment','1.8.8','Created table olabs_oims_expense_on_materials','2017-06-10 06:27:56'),(677,'Olabs.Oims','script','1.8.9','builder_table_create_olabs_oims_expense_on_material_products.php','2017-06-10 06:27:56'),(678,'Olabs.Oims','comment','1.8.9','Created table olabs_oims_expense_on_material_products','2017-06-10 06:27:56'),(679,'Olabs.Oims','script','1.8.10','builder_table_create_olabs_oims_expense_on_pc_products.php','2017-06-10 06:27:56'),(680,'Olabs.Oims','comment','1.8.10','Created table olabs_oims_expense_on_pc_products','2017-06-10 06:27:56'),(681,'Olabs.Oims','script','1.8.11','builder_table_create_olabs_oims_expense_on_pcs.php','2017-06-10 06:27:56'),(682,'Olabs.Oims','comment','1.8.11','Created table olabs_oims_expense_on_pcs','2017-06-10 06:27:56'),(683,'Olabs.Oims','script','1.8.12','builder_table_update_olabs_oims_attendances_2.php','2017-06-25 03:22:10'),(684,'Olabs.Oims','comment','1.8.12','Updated table olabs_oims_attendances','2017-06-25 03:22:10'),(687,'Olabs.Oims','script','1.8.13','builder_table_update_olabs_oims_offrole_employees_4.php','2017-06-25 12:54:04'),(688,'Olabs.Oims','comment','1.8.13','Updated table olabs_oims_offrole_employees','2017-06-25 12:54:04'),(689,'Olabs.Oims','script','1.8.14','builder_table_update_olabs_oims_offrole_employees_5.php','2017-07-02 07:17:24'),(690,'Olabs.Oims','comment','1.8.14','Updated table olabs_oims_offrole_employees','2017-07-02 07:17:24'),(691,'Olabs.Oims','script','1.8.15','builder_table_update_olabs_oims_projects_2.php','2017-07-15 12:52:24'),(692,'Olabs.Oims','comment','1.8.15','Updated table olabs_oims_projects','2017-07-15 12:52:24'),(693,'Olabs.Oims','script','1.8.16','BuilderTableUpdateOlabsOimsCompanies2.php','2017-07-20 03:19:53'),(694,'Olabs.Oims','comment','1.8.16','Updated table olabs_oims_companies','2017-07-20 03:19:53'),(695,'Olabs.Oims','script','1.8.17','builder_table_create_olabs_oims_bank_accounts.php','2017-08-22 09:56:36'),(696,'Olabs.Oims','comment','1.8.17','Created table olabs_oims_bank_accounts','2017-08-22 09:56:36'),(697,'Olabs.Oims','script','1.8.18','builder_table_create_olabs_oims_payment_receivables.php','2017-08-22 09:56:36'),(698,'Olabs.Oims','comment','1.8.18','Created table olabs_oims_payment_receivables','2017-08-22 09:56:36'),(699,'Olabs.Oims','script','1.8.19','builder_table_update_olabs_oims_payment_receivables.php','2017-08-22 09:56:36'),(700,'Olabs.Oims','comment','1.8.19','Updated table olabs_oims_payment_receivables','2017-08-22 09:56:36'),(701,'Olabs.Oims','script','1.9.0','builder_table_update_olabs_oims_quotes_8.php','2017-11-26 08:13:44'),(702,'Olabs.Oims','comment','1.9.0','Updated table olabs_oims_quotes','2017-11-26 08:13:44'),(703,'Olabs.Oims','script','1.9.1','builder_table_update_olabs_oims_expense_on_pcs.php','2017-11-26 08:13:44'),(704,'Olabs.Oims','comment','1.9.1','Updated table olabs_oims_expense_on_pcs','2017-11-26 08:13:44'),(705,'Olabs.Oims','script','1.9.2','builder_table_update_olabs_oims_quotes_9.php','2017-11-26 08:13:44'),(706,'Olabs.Oims','comment','1.9.2','Updated table olabs_oims_quotes','2017-11-26 08:13:44'),(707,'Olabs.Oims','script','1.9.3','builder_table_update_olabs_oims_quotes_10.php','2017-11-26 08:13:44'),(708,'Olabs.Oims','comment','1.9.3','Updated table olabs_oims_quotes','2017-11-26 08:13:44'),(709,'Olabs.Oims','script','1.9.4','builder_table_update_olabs_oims_expense_on_pc_products.php','2017-11-26 08:13:44'),(710,'Olabs.Oims','comment','1.9.4','Updated table olabs_oims_expense_on_pc_products','2017-11-26 08:13:44'),(711,'Olabs.Oims','script','1.9.5','builder_table_update_olabs_oims_purchases_3.php','2017-11-26 08:56:21'),(712,'Olabs.Oims','comment','1.9.5','Updated table olabs_oims_purchases','2017-11-26 08:56:21'),(713,'Olabs.Oims','script','1.9.6','builder_table_update_olabs_oims_purchase_products_2.php','2017-11-26 08:56:21'),(714,'Olabs.Oims','comment','1.9.6','Updated table olabs_oims_purchase_products','2017-11-26 08:56:21'),(715,'Olabs.Oims','script','1.9.7','builder_table_update_olabs_oims_quotes_11.php','2017-11-28 05:44:47'),(716,'Olabs.Oims','comment','1.9.7','Updated table olabs_oims_quotes','2017-11-28 05:44:47'),(717,'Olabs.Oims','script','1.9.8','builder_table_update_olabs_oims_quotes_12.php','2017-11-28 05:44:47'),(718,'Olabs.Oims','comment','1.9.8','Updated table olabs_oims_quotes','2017-11-28 05:44:47'),(719,'Olabs.Oims','script','1.9.9','builder_table_update_olabs_oims_quotes_13.php','2017-11-28 05:44:47'),(720,'Olabs.Oims','comment','1.9.9','Updated table olabs_oims_quotes','2017-11-28 05:44:47'),(721,'Olabs.Oims','script','1.9.10','builder_table_update_olabs_oims_quotes_14.php','2017-11-28 05:44:47'),(722,'Olabs.Oims','comment','1.9.10','Updated table olabs_oims_quotes','2017-11-28 05:44:47'),(723,'Olabs.Oims','script','1.9.11','builder_table_update_olabs_oims_projects_3.php','2017-11-28 05:44:47'),(724,'Olabs.Oims','comment','1.9.11','Updated table olabs_oims_projects','2017-11-28 05:44:47'),(725,'Olabs.Oims','script','1.9.12','builder_table_update_backend_users_4.php','2017-11-28 05:44:47'),(726,'Olabs.Oims','comment','1.9.12','Updated table backend_users','2017-11-28 05:44:47'),(727,'Olabs.Oims','script','1.9.13','builder_table_update_olabs_oims_quotes_15.php','2017-11-28 06:02:46'),(728,'Olabs.Oims','comment','1.9.13','Updated table olabs_oims_quotes','2017-11-28 06:02:46'),(729,'Olabs.Oims','script','1.9.14','builder_table_update_olabs_oims_projects_4.php','2017-12-01 03:13:54'),(730,'Olabs.Oims','comment','1.9.14','Updated table olabs_oims_projects','2017-12-01 03:13:54'),(731,'Olabs.Oims','script','1.9.15','builder_table_update_olabs_oims_quote_products_2.php','2017-12-04 01:06:36'),(732,'Olabs.Oims','comment','1.9.15','Updated table olabs_oims_quote_products','2017-12-04 01:06:36'),(733,'Olabs.Oims','script','1.9.16','builder_table_update_olabs_oims_quotes_16.php','2017-12-04 01:06:37'),(734,'Olabs.Oims','comment','1.9.16','Updated table olabs_oims_quotes','2017-12-04 01:06:37'),(735,'Olabs.Oims','script','1.9.17','builder_table_update_olabs_oims_purchase_products_3.php','2017-12-04 01:06:40'),(736,'Olabs.Oims','comment','1.9.17','Updated table olabs_oims_purchase_products','2017-12-04 01:06:40'),(737,'Olabs.Oims','script','1.9.18','builder_table_update_olabs_oims_purchases_4.php','2017-12-04 01:06:40'),(738,'Olabs.Oims','comment','1.9.18','Updated table olabs_oims_purchases','2017-12-04 01:06:40'),(739,'Olabs.Oims','script','1.9.19','builder_table_update_olabs_oims_sales_4.php','2017-12-04 01:06:40'),(740,'Olabs.Oims','comment','1.9.19','Updated table olabs_oims_sales','2017-12-04 01:06:40'),(741,'Olabs.Oims','script','1.9.20','builder_table_update_olabs_oims_sales_products_3.php','2017-12-04 01:06:41'),(742,'Olabs.Oims','comment','1.9.20','Updated table olabs_oims_sales_products','2017-12-04 01:06:41'),(743,'Olabs.Oims','script','1.9.21','builder_table_update_olabs_oims_products_2.php','2017-12-04 01:06:41'),(744,'Olabs.Oims','comment','1.9.21','Updated table olabs_oims_products','2017-12-04 01:06:41'),(745,'Olabs.Oims','script','1.9.22','builder_table_update_olabs_oims_project_work_products_2.php','2017-12-04 01:06:41'),(746,'Olabs.Oims','comment','1.9.22','Updated table olabs_oims_project_work_products','2017-12-04 01:06:41'),(747,'Olabs.Oims','script','1.9.23','builder_table_update_olabs_oims_products_options.php','2017-12-04 01:06:41'),(748,'Olabs.Oims','comment','1.9.23','Updated table olabs_oims_products_options','2017-12-04 01:06:41'),(749,'Olabs.Oims','script','1.9.24','builder_table_update_olabs_oims_products_users_price.php','2017-12-04 01:06:41'),(750,'Olabs.Oims','comment','1.9.24','Updated table olabs_oims_products_users_price','2017-12-04 01:06:41'),(751,'Olabs.Oims','script','1.9.25','builder_table_update_olabs_oims_expense_on_material_products.php','2017-12-04 01:06:41'),(752,'Olabs.Oims','comment','1.9.25','Updated table olabs_oims_expense_on_material_products','2017-12-04 01:06:41'),(753,'Olabs.Oims','script','1.9.26','builder_table_update_olabs_oims_expense_on_materials.php','2017-12-04 01:06:41'),(754,'Olabs.Oims','comment','1.9.26','Updated table olabs_oims_expense_on_materials','2017-12-04 01:06:41'),(755,'Olabs.Oims','script','1.9.27','builder_table_update_olabs_oims_expense_on_pc_products_2.php','2017-12-04 01:06:41'),(756,'Olabs.Oims','comment','1.9.27','Updated table olabs_oims_expense_on_pc_products','2017-12-04 01:06:41'),(757,'Olabs.Oims','script','1.9.28','builder_table_update_olabs_oims_expense_on_pcs_2.php','2017-12-04 01:06:41'),(758,'Olabs.Oims','comment','1.9.28','Updated table olabs_oims_expense_on_pcs','2017-12-04 01:06:41'),(759,'Olabs.Oims','script','1.9.29','builder_table_update_olabs_oims_machineries.php','2017-12-04 01:06:41'),(760,'Olabs.Oims','comment','1.9.29','Updated table olabs_oims_machineries','2017-12-04 01:06:41'),(761,'Olabs.Oims','script','1.9.30','builder_table_update_olabs_oims_machinery_products.php','2017-12-04 01:06:41'),(762,'Olabs.Oims','comment','1.9.30','Updated table olabs_oims_machinery_products','2017-12-04 01:06:41'),(763,'Olabs.Oims','script','1.9.31','builder_table_update_olabs_oims_manpower_products.php','2017-12-04 01:06:41'),(764,'Olabs.Oims','comment','1.9.31','Updated table olabs_oims_manpower_products','2017-12-04 01:06:41'),(765,'Olabs.Oims','script','1.9.32','builder_table_update_olabs_oims_manpowers.php','2017-12-04 01:06:41'),(766,'Olabs.Oims','comment','1.9.32','Updated table olabs_oims_manpowers','2017-12-04 01:06:41'),(767,'Olabs.Oims','script','1.9.33','builder_table_update_olabs_oims_offrole_employees_6.php','2017-12-04 01:06:41'),(768,'Olabs.Oims','comment','1.9.33','Updated table olabs_oims_offrole_employees','2017-12-04 01:06:41'),(769,'Olabs.Oims','script','1.9.34','builder_table_update_olabs_oims_orders.php','2017-12-04 01:06:41'),(770,'Olabs.Oims','comment','1.9.34','Updated table olabs_oims_orders','2017-12-04 01:06:41'),(771,'Olabs.Oims','script','1.9.35','builder_table_update_olabs_oims_project_works.php','2017-12-04 01:06:41'),(772,'Olabs.Oims','comment','1.9.35','Updated table olabs_oims_project_works','2017-12-04 01:06:41'),(773,'Olabs.Oims','script','1.9.36','builder_table_update_olabs_oims_payment_receivables_2.php','2017-12-04 01:06:41'),(774,'Olabs.Oims','comment','1.9.36','Updated table olabs_oims_payment_receivables','2017-12-04 01:06:41'),(775,'Olabs.Oims','script','1.10.1','builder_table_create_olabs_oims_assets.php','2017-12-23 09:03:19'),(776,'Olabs.Oims','comment','1.10.1','Created table olabs_oims_assets','2017-12-23 09:03:19'),(777,'RainLab.Blog','comment','1.2.17','Improved the next and previous logic to sort by the published date.','2018-01-18 06:30:19'),(778,'RainLab.Blog','comment','1.2.18','Minor change to internals.','2018-01-18 06:30:19'),(779,'RainLab.Blog','comment','1.2.19','Improved support for Build 420+','2018-01-18 06:30:19'),(780,'RainLab.User','comment','1.4.0','!!! The Notifications tab in User settings has been removed.','2018-01-18 06:30:19'),(781,'RainLab.User','comment','1.4.1','Added support for user impersonation.','2018-01-18 06:30:19'),(782,'RainLab.User','comment','1.4.2','Fixes security bug in Password Reset component.','2018-01-18 06:30:19'),(783,'RainLab.User','comment','1.4.3','Fixes session handling for AJAX requests.','2018-01-18 06:30:19'),(784,'RainLab.User','comment','1.4.4','Fixes bug where impersonation touches the last seen timestamp.','2018-01-18 06:30:19'),(785,'RainLab.User','comment','1.4.5','Added token fallback process to Account / Reset Password components when parameter is missing.','2018-01-18 06:30:19'),(786,'Kocholes.BarcodeGenerator','comment','1.0.1','Initialize plugin.','2018-01-29 00:26:37'),(787,'Olabs.Oims','script','1.10.2','builder_table_update_olabs_oims_project_assets.php','2018-01-29 00:26:37'),(788,'Olabs.Oims','comment','1.10.2','Updated table olabs_oims_assets','2018-01-29 00:26:37'),(789,'Olabs.Oims','script','1.10.3','builder_table_delete_olabs_oims_assets_BIN.php','2018-01-29 00:26:37'),(790,'Olabs.Oims','comment','1.10.3','Drop table olabs_oims_assets_BIN','2018-01-29 00:26:37'),(791,'Olabs.Oims','script','1.10.4','builder_table_update_olabs_oims_project_assets_2.php','2018-01-29 00:26:37'),(792,'Olabs.Oims','comment','1.10.4','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(793,'Olabs.Oims','script','1.10.5','builder_table_update_olabs_oims_project_assets_3.php','2018-01-29 00:26:37'),(794,'Olabs.Oims','comment','1.10.5','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(795,'Olabs.Oims','script','1.10.6','builder_table_update_olabs_oims_project_assets_4.php','2018-01-29 00:26:37'),(796,'Olabs.Oims','comment','1.10.6','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(797,'Olabs.Oims','script','1.10.7','builder_table_update_olabs_oims_project_assets_5.php','2018-01-29 00:26:37'),(798,'Olabs.Oims','comment','1.10.7','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(799,'Olabs.Oims','script','1.10.8','builder_table_update_olabs_oims_project_assets_6.php','2018-01-29 00:26:37'),(800,'Olabs.Oims','comment','1.10.8','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(801,'Olabs.Oims','script','1.10.9','builder_table_update_olabs_oims_project_assets_7.php','2018-01-29 00:26:37'),(802,'Olabs.Oims','comment','1.10.9','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(803,'Olabs.Oims','script','1.10.10','builder_table_create_olabs_oims_project_asset_transfers.php','2018-01-29 00:26:37'),(804,'Olabs.Oims','comment','1.10.10','Created table olabs_oims_project_asset_transfers','2018-01-29 00:26:37'),(805,'Olabs.Oims','script','1.10.11','builder_table_update_olabs_oims_project_asset_transfers.php','2018-01-29 00:26:37'),(806,'Olabs.Oims','comment','1.10.11','Updated table olabs_oims_project_asset_transfers','2018-01-29 00:26:37'),(807,'Olabs.Oims','script','1.10.12','builder_table_create_olabs_oims_project_asset_damages.php','2018-01-29 00:26:37'),(808,'Olabs.Oims','comment','1.10.12','Created table olabs_oims_project_asset_damages','2018-01-29 00:26:37'),(809,'Olabs.Oims','script','1.10.13','builder_table_update_olabs_oims_project_asset_damages.php','2018-01-29 00:26:37'),(810,'Olabs.Oims','comment','1.10.13','Updated table olabs_oims_project_asset_damages','2018-01-29 00:26:37'),(811,'Olabs.Oims','script','1.10.14','builder_table_create_olabs_oims_project_asset_monitoring.php','2018-01-29 00:26:37'),(812,'Olabs.Oims','comment','1.10.14','Created table olabs_oims_project_asset_monitoring','2018-01-29 00:26:37'),(813,'Olabs.Oims','script','1.10.15','builder_table_update_olabs_oims_project_asset_transfers_2.php','2018-01-29 00:26:37'),(814,'Olabs.Oims','comment','1.10.15','Updated table olabs_oims_project_asset_transfers','2018-01-29 00:26:37'),(815,'Olabs.Oims','script','1.10.16','builder_table_update_olabs_oims_project_asset_monitoring.php','2018-01-29 00:26:37'),(816,'Olabs.Oims','comment','1.10.16','Updated table olabs_oims_project_asset_monitoring','2018-01-29 00:26:37'),(817,'Olabs.Oims','script','1.10.17','builder_table_update_olabs_oims_project_asset_monitoring_2.php','2018-01-29 00:26:37'),(818,'Olabs.Oims','comment','1.10.17','Updated table olabs_oims_project_asset_monitoring','2018-01-29 00:26:37'),(819,'Olabs.Oims','script','1.10.18','builder_table_update_olabs_oims_project_assets_8.php','2018-01-29 00:26:37'),(820,'Olabs.Oims','comment','1.10.18','Updated table olabs_oims_project_assets','2018-01-29 00:26:37'),(821,'Olabs.Oims','script','1.10.19','builder_table_update_olabs_oims_project_asset_transfers_3.php','2018-01-29 00:26:37'),(822,'Olabs.Oims','comment','1.10.19','Updated table olabs_oims_project_asset_transfers','2018-01-29 00:26:37'),(823,'Olabs.Oims','script','1.10.20','builder_table_update_olabs_oims_project_asset_monitoring_3.php','2018-01-29 00:26:37'),(824,'Olabs.Oims','comment','1.10.20','Updated table olabs_oims_project_asset_monitoring','2018-01-29 00:26:37'),(825,'Olabs.Oims','script','1.10.21','builder_table_update_olabs_oims_project_asset_damages_2.php','2018-01-29 00:26:37'),(826,'Olabs.Oims','comment','1.10.21','Updated table olabs_oims_project_asset_damages','2018-01-29 00:26:37'),(827,'Olabs.Oims','script','1.10.22','builder_table_update_olabs_oims_project_asset_purchases.php','2018-02-01 07:07:22'),(828,'Olabs.Oims','comment','1.10.22','Updated table olabs_oims_project_assets','2018-02-01 07:07:22'),(829,'Olabs.Oims','script','1.10.23','builder_table_create_olabs_oims_project_assets.php','2018-02-01 07:07:22'),(830,'Olabs.Oims','comment','1.10.23','Created table olabs_oims_project_assets','2018-02-01 07:07:22'),(831,'Olabs.Oims','script','1.10.24','builder_table_update_olabs_oims_project_asset_damages_3.php','2018-02-01 07:07:22'),(832,'Olabs.Oims','comment','1.10.24','Updated table olabs_oims_project_asset_damages','2018-02-01 07:07:22'),(833,'Olabs.Oims','script','1.10.25','builder_table_update_olabs_oims_project_asset_transfers_4.php','2018-02-01 07:07:22'),(834,'Olabs.Oims','comment','1.10.25','Updated table olabs_oims_project_asset_transfers','2018-02-01 07:07:22'),(835,'Olabs.Oims','script','1.10.26','builder_table_update_olabs_oims_project_assets_9.php','2018-02-01 07:07:22'),(836,'Olabs.Oims','comment','1.10.26','Updated table olabs_oims_project_assets','2018-02-01 07:07:22'),(837,'Olabs.Oims','script','1.10.27','builder_table_update_olabs_oims_project_asset_purchases_2.php','2018-02-01 07:07:22'),(838,'Olabs.Oims','comment','1.10.27','Updated table olabs_oims_project_asset_purchases','2018-02-01 07:07:22'),(839,'Autumn.Api','comment','1.0.1','First version of Api','2018-03-03 01:49:20'),(840,'Olabs.Oimsapi','comment','1.0.1','Initialize plugin.','2018-03-03 01:49:20'),(841,'Olabs.Oims','script','1.11.1','builder_table_update_olabs_oims_project_works_2.php','2018-03-17 03:39:28'),(842,'Olabs.Oims','comment','1.11.1','Updated table olabs_oims_project_works','2018-03-17 03:39:28'),(843,'Olabs.Oims','script','1.11.2','builder_table_create_olabs_oims_pc_attendance.php','2018-03-23 02:41:33'),(844,'Olabs.Oims','comment','1.11.2','Created table olabs_oims_pc_attendance','2018-03-23 02:41:33'),(845,'Olabs.Oims','script','1.11.3','builder_table_create_olabs_oims_pc_attendance_details.php','2018-03-23 02:41:33'),(846,'Olabs.Oims','comment','1.11.3','Created table olabs_oims_pc_attendance_details','2018-03-23 02:41:33'),(847,'Olabs.Oims','script','1.11.4','builder_table_update_olabs_oims_pc_attendances.php','2018-03-23 02:41:33'),(848,'Olabs.Oims','comment','1.11.4','Updated table olabs_oims_pc_attendance','2018-03-23 02:41:33'),(849,'Olabs.Oims','script','1.11.5','builder_table_update_olabs_oims_pc_attendance_details.php','2018-03-23 02:41:33'),(850,'Olabs.Oims','comment','1.11.5','Updated table olabs_oims_pc_attendance_details','2018-03-23 02:41:33'),(851,'Olabs.Oims','script','1.11.6','builder_table_update_olabs_oims_pc_attendance_details_2.php','2018-03-23 05:24:54'),(852,'Olabs.Oims','comment','1.11.6','Updated table olabs_oims_pc_attendance_details','2018-03-23 05:24:54'),(853,'Olabs.Oims','script','1.11.7','builder_table_update_olabs_oims_pc_attendance_details_3.php','2018-03-23 05:24:55'),(854,'Olabs.Oims','comment','1.11.7','Updated table olabs_oims_pc_attendance_details','2018-03-23 05:24:55'),(855,'Olabs.Oims','script','1.11.8','builder_table_update_olabs_oims_pc_attendance_details_4.php','2018-03-23 05:24:55'),(856,'Olabs.Oims','comment','1.11.8','Updated table olabs_oims_pc_attendance_details','2018-03-23 05:24:55'),(857,'Olabs.Oims','script','1.11.9','builder_table_update_olabs_oims_project_progress_2.php','2018-03-23 05:24:55'),(858,'Olabs.Oims','comment','1.11.9','Updated table olabs_oims_project_progress','2018-03-23 05:24:55'),(899,'RainLab.Builder','comment','1.0.22','Added scopeValue property to the RecordList component.','2018-04-06 03:09:07');
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_plugin_versions`
--

LOCK TABLES `system_plugin_versions` WRITE;
/*!40000 ALTER TABLE `system_plugin_versions` DISABLE KEYS */;
INSERT INTO `system_plugin_versions` VALUES (1,'October.Demo','1.0.1','2016-08-28 11:43:38',0,0),(2,'RainLab.Builder','1.0.22','2018-04-06 03:09:08',0,0),(4,'RainLab.User','1.4.5','2018-01-18 06:30:19',0,0),(5,'RainLab.Blog','1.2.19','2018-01-18 06:30:19',0,0),(6,'RainLab.Forum','1.1.1','2017-02-10 17:25:43',0,0),(8,'Olabs.Tenant','1.0.19','2016-11-06 17:05:08',0,0),(9,'Keios.Multisite','1.1.0','2016-09-08 09:18:15',0,0),(10,'October.Drivers','1.1.1','2016-09-09 13:34:07',0,0),(11,'Mohsin.Rest','1.0.3','2017-02-10 17:25:43',0,0),(12,'Olabs.Parsers','1.0.1','2016-10-04 15:26:55',0,0),(13,'Olabs.Pusher','1.0.6','2016-10-23 15:50:13',0,0),(16,'Olabs.App','1.0.1','2016-11-06 15:50:21',0,0),(18,'Olabs.Oims','1.11.9','2018-03-23 05:24:55',0,0),(20,'Cyd293.Extenders','1.0.1','2017-04-28 04:32:08',0,0),(21,'Reportico.Reports','1.2.0','2018-01-26 21:59:45',0,0),(22,'Olabs.Tasks','1.0.5','2017-05-25 11:27:36',0,0),(24,'Kocholes.BarcodeGenerator','1.0.1','2018-01-29 00:26:37',0,0),(25,'Autumn.Api','1.0.1','2018-03-03 01:49:20',0,0),(26,'Olabs.Oimsapi','1.0.1','2018-03-03 01:49:20',0,0);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_request_logs`
--

LOCK TABLES `system_request_logs` WRITE;
/*!40000 ALTER TABLE `system_request_logs` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'rainlab_builder_settings','{\"author_name\":\"olabs\",\"author_namespace\":\"Olabs\"}'),(3,'olabs_oims_settings','{\"number_format_thousands_sep\":\",\",\"number_format_decimals\":\"2\",\"number_format_dec_point\":\".\",\"bank_transfer_details_content\":\"\",\"paypal_use_sandbox\":\"1\",\"paypal_debug\":\"1\",\"paypal_business\":\"\",\"invoice_template_content\":\"<!--Header-->\\r\\n\\r\\n<table class=\\\"invoice-box header\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"logo\\\"><img src=\\\"{{logo_src}}\\\" style=\\\"width: 100%; max-width: 300px;\\\" alt=\\\"\\\" class=\\\"fr-fic fr-dii\\\"><\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"company\\\">\\r\\n\\r\\n\\t\\t\\t\\t\\t<h2 class=\\\"name\\\">{{company_name}}<\\/h2>\\r\\n\\t\\t\\t\\t\\t<div>{{company_address}}, {{company_address2}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div>{{company_city}} - {{company_postcode}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div>{{company_contact_phone}}, <a href=\\\"mailto:{{company_contact_email}}\\\">{{company_contact_email}}<\\/a><\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"billings\\\">\\r\\n\\r\\n\\t\\t\\t\\t\\t<h4 class=\\\"name\\\">Billing Address:<\\/h4>\\r\\n\\t\\t\\t\\t\\t<div>{{project_billing_address}}, {{project_billing_address2}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div>{{project_billing_city}} - {{project_billing_postcode}}<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n<!--Invoice Details-->\\r\\n\\r\\n<table class=\\\"invoice-box\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"client\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"to\\\">TO,<\\/div>\\r\\n\\r\\n\\t\\t\\t\\t\\t<h2 class=\\\"name\\\">{{supplier}}<\\/h2>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"address\\\">{{supplier_full_address}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"email\\\">{{supplier_contact_phone}}, <a href=\\\"mailto:{{supplier_contact_email}}\\\">{{supplier_contact_email}}<\\/a><\\/div>\\r\\n\\t\\t\\t\\t\\t<div>Kindly Attn : {{supplier_contact_person}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div>GST: {{supplier_gst_number}}<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"invoice\\\">\\r\\n\\r\\n\\t\\t\\t\\t\\t<h1>{{order_label}}: {{order_id}}<\\/h1>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"date\\\">Date: {{context_date}}<\\/div>\\r\\n\\r\\n\\t\\t\\t\\t\\t<h2 class=\\\"name\\\">Project: {{project_name}}<\\/h2>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"address\\\">{{project_full_address}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div>Contract Person: {{project_contact_person}}<\\/div>\\r\\n\\t\\t\\t\\t\\t<div>{{project_contact_phone}}, <a href=\\\"mailto:{{project_contact_email}}\\\">{{project_contact_email}}<\\/a><\\/div>\\r\\n\\t\\t\\t\\t\\t<div>GST: {{project_gst_number}}<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n<!--Subjects-->\\r\\n\\r\\n<table class=\\\"invoice-box\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"subject\\\">Please prepare challan \\/ bill in the name of: {{challan_name}}<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"subject\\\">\\r\\n\\r\\n\\t\\t\\t\\t\\t<h4>Subject : {{subject}}<\\/h4>\\r\\n\\r\\n\\t\\t\\t\\t\\t<p>Dear Sir,\\r\\n\\t\\t\\t\\t\\t\\t<br>We are please to place Work Order for the above said(subject) along with under mentioned terms &amp; conditions.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n<!--Descriptions-->\\r\\n\\r\\n<table class=\\\"invoice-box items\\\">\\r\\n\\t<thead>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th class=\\\"no\\\">#<\\/th>\\r\\n\\t\\t\\t<th class=\\\"desc\\\">DESCRIPTION<\\/th>\\r\\n\\t\\t\\t<th class=\\\"unit\\\">UNIT<\\/th>\\r\\n\\t\\t\\t<th class=\\\"qty\\\">QUANTITY<\\/th>\\r\\n\\t\\t\\t<th class=\\\"unit\\\">UNIT PRICE<\\/th>\\r\\n\\t\\t\\t<th class=\\\"total\\\">TOTAL<\\/th>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/thead>\\r\\n\\t<tbody>\\r\\n\\t\\t<tr class=\\\"products_row\\\">\\r\\n\\t\\t\\t<td class=\\\"no\\\">{{product_sno}}<\\/td>\\r\\n\\t\\t\\t<td class=\\\"desc\\\">{{product_title}}<\\/td>\\r\\n\\t\\t\\t<td class=\\\"unit\\\">{{product_unit}}<\\/td>\\r\\n\\t\\t\\t<td class=\\\"qty\\\">{{product_qty}}<\\/td>\\r\\n\\t\\t\\t<td class=\\\"unit\\\">{{product_rate}}<\\/td>\\r\\n\\t\\t\\t<td class=\\\"total\\\">{{product_total_price}}<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"3\\\">\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td class=\\\"summary_heading\\\" colspan=\\\"2\\\">SUBTOTAL<\\/td>\\r\\n\\t\\t\\t<td class=\\\"summary_heading\\\">{{total_price_without_tax}}<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr class=\\\"tax_row\\\">\\r\\n\\t\\t\\t<td colspan=\\\"3\\\">\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td colspan=\\\"2\\\">{{tax_label}}<\\/td>\\r\\n\\t\\t\\t<td>{{tax_amount}}<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"3\\\">\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td class=\\\"summary_heading\\\" colspan=\\\"2\\\">GRAND TOTAL<\\/td>\\r\\n\\t\\t\\t<td class=\\\"summary_heading\\\">{{total_price}}<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n<!--Footer-->\\r\\n\\r\\n<table class=\\\"invoice-box\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>\\r\\n\\r\\n\\t\\t\\t\\t<table class=\\\"invoice_detail_table\\\">\\r\\n\\t\\t\\t\\t\\t<tbody>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Remaks if any:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{note}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Loading:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{loading}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Freight:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{freight}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Form \\\"C\\\":<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{form_c}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Delivery Time<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{delivery_time}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t<\\/tbody>\\r\\n\\t\\t\\t\\t<\\/table>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td>\\r\\n\\r\\n\\t\\t\\t\\t<table class=\\\"invoice_detail_table\\\">\\r\\n\\t\\t\\t\\t\\t<tbody>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Guaranty \\/ Warranty:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{guaranty}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Test Certificate:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{test_certificate}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Payment Terms:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{payment_terms}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Terms &amp; Condition:<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{terms_condition}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t\\t<tr>\\r\\n\\t\\t\\t\\t\\t\\t\\t<th>Delivery At<\\/th>\\r\\n\\t\\t\\t\\t\\t\\t\\t<td>{{delivery_at}}<\\/td>\\r\\n\\t\\t\\t\\t\\t\\t<\\/tr>\\r\\n\\t\\t\\t\\t\\t<\\/tbody>\\r\\n\\t\\t\\t\\t<\\/table>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n\\r\\n<table class=\\\"invoice-box authorize_signatory_table\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<th>AUTHORISED SIGNATORY<\\/th>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\\r\\n\\r\\n<table class=\\\"invoice-box\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td>\\r\\n\\t\\t\\t\\t<div class=\\\"footer\\\">Invoice was created on a computer and is valid without the signature and seal.<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\",\"cash_on_delivery_order_status_before_id\":\"-1\",\"cash_on_delivery_order_status_after_id\":\"-1\",\"bank_transfer_order_status_before_id\":\"-1\",\"bank_transfer_order_status_after_id\":\"-1\",\"paypal_order_status_before_id\":\"-1\",\"paypal_order_status_after_id\":\"-1\",\"currency_char\":\"$\",\"currency_char_position\":\"1\",\"copy_all_order_emails_to\":\"\",\"invoice_template_style\":\"@page { margin: 0px; }    \\r\\n    .invoice-box {\\r\\n        max-width: 800px;\\r\\n        \\/*border: 1px solid #eee;*\\/\\r\\n        line-height: 14px;\\r\\n        font-family: \'Helvetica Neue\', \'Helvetica\', \'Arial\', \'sans-serif\';\\r\\n        color: #555;\\r\\n        position: relative;\\r\\n        margin: 10px; \\r\\n        background: #FFFFFF; \\r\\n        font-size: 11px; \\r\\n        width: 100%;\\r\\n    }\\r\\n    \\/*    table { width: 100%; border-collapse: collapse;}\\r\\n        td, th { border: 1px solid #ccc; }*\\/\\r\\n\\r\\n.invoice-box  td{\\r\\n        vertical-align: top;\\r\\n    }\\r\\n    .logo {\\r\\n        float: left;\\r\\n        margin-top: 2px;\\r\\n        width: 80px;\\r\\n    }\\r\\n\\r\\n    .logo img {\\r\\n        height: 60px;\\r\\n    }\\r\\n\\r\\n    .company {\\r\\n\\r\\n        text-align: center;\\r\\n\\r\\n    }\\r\\n\\r\\n    .billings {\\r\\n\\r\\n        text-align: right;\\r\\n    }\\r\\n\\r\\n    .client {\\r\\n        padding-left: 6px;\\r\\n        \\r\\n    }\\r\\n\\r\\n    .client .to {\\r\\n        color: #777777;\\r\\n    }\\r\\n\\r\\n    .invoice {\\r\\n        float: right;\\r\\n        text-align: right;\\r\\n    }\\r\\n\\r\\n    .invoice h1 {\\r\\n        color: #0087C3;\\r\\n        font-size: 1.4em;\\r\\n        line-height: 1em;\\r\\n        font-weight: normal;\\r\\n        margin: 0 0 5px 0;\\r\\n    }\\r\\n\\r\\n    .invoice .date {\\r\\n        font-size: 1.1em;\\r\\n        color: #555;\\r\\n       \\r\\n        margin-bottom: 7px;\\r\\n    }\\r\\n\\r\\n\\r\\n    .subject {\\r\\n        padding-left: 6px;\\r\\n        border-left: 6px; \\r\\n    }\\r\\n\\r\\n    .clearfix:after {\\r\\n        content: \\\"\\\";\\r\\n        display: table;\\r\\n        clear: both;\\r\\n    }\\r\\n\\r\\n    a {\\r\\n        color: #0087C3;\\r\\n        text-decoration: none;\\r\\n    }\\r\\n\\r\\n    \\/*border-bottom: 1px solid #eee; margin-bottom: 10px;*\\/\\r\\n    .header {\\r\\n        padding: 10px 0;\\r\\n        margin-bottom: 10px;\\r\\n        border-bottom: 1px solid #AAAAAA;\\r\\n    }\\r\\n\\r\\n    .details {\\r\\n        margin-bottom: 10px;\\r\\n    }\\r\\n\\r\\n    h2.name {\\r\\n        font-size: 1.4em;\\r\\n        font-weight: normal;\\r\\n        margin: 0;\\r\\n    }\\r\\n    h4.name {\\r\\n        font-size: 1.0em;\\r\\n        font-weight: normal;\\r\\n        margin: 0;\\r\\n    }\\r\\n\\r\\n\\r\\n\\r\\n    .items  {\\r\\n        width: 100%;\\r\\n        border-collapse: collapse;\\r\\n        border-spacing: 0;\\r\\n        margin-bottom: 20px;\\r\\n    }\\r\\n\\r\\n    .items th,\\r\\n    .items td {\\r\\n        padding: 10px;\\r\\n        background: #fff;\\r\\n        text-align: center;\\r\\n        border-bottom: 1px solid #eee;\\r\\n    }\\r\\n\\r\\n    .items th {\\r\\n        white-space: nowrap;        \\r\\n        font-weight: bold;\\r\\n    }\\r\\n\\r\\n    .items  td {\\r\\n        text-align: right;\\r\\n    }\\r\\n\\r\\n    .items  td h3{\\r\\n        color: #57B223;\\r\\n        font-size: 1.2em;\\r\\n        font-weight: normal;\\r\\n        margin: 0 0 0.2em 0;\\r\\n    }\\r\\n\\r\\n.items .summary_heading {\\r\\n        white-space: nowrap;        \\r\\n        font-weight: bold;\\r\\n    }\\r\\n\\r\\n    .items  .no {\\r\\n        \\/*        color: #FFFFFF;\\r\\n                font-size: 1.6em;\\r\\n                background: #57B223;*\\/\\r\\n    }\\r\\n\\r\\n    .items  .desc {\\r\\n        text-align: left;\\r\\n    }\\r\\n\\r\\n    .items  .unit {\\r\\n        \\/*background: #DDDDDD;*\\/\\r\\n    }\\r\\n\\r\\n    .items  .qty {\\r\\n    }\\r\\n\\r\\n    .items  .total {\\r\\n        \\/*        background: #57B223;\\r\\n                color: #FFFFFF;*\\/\\r\\n    }\\r\\n\\r\\n    .items  td.unit,\\r\\n    .items  td.qty,\\r\\n    .items  td.total {\\r\\n        font-size: 1.0em;\\r\\n    }\\r\\n\\r\\n    .items  tbody tr:last-child td {\\r\\n        border: none;\\r\\n    }\\r\\n\\r\\n    .items  tfoot td {\\r\\n        padding: 10px 20px;\\r\\n        background: #FFFFFF;\\r\\n        border-bottom: none;\\r\\n        font-size: 1.2em;\\r\\n        white-space: nowrap; \\r\\n        border-top: 1px solid #AAAAAA; \\r\\n    }\\r\\n\\r\\n    .items  tfoot tr:first-child td {\\r\\n        border-top: none; \\r\\n    }\\r\\n\\r\\n    .items  tfoot tr:last-child td {\\r\\n        color: #57B223;\\r\\n        font-size: 1.4em;\\r\\n        border-top: 1px solid #57B223; \\r\\n\\r\\n    }\\r\\n\\r\\n    .items  tfoot tr td:first-child {\\r\\n        border: none;\\r\\n    }\\r\\n\\r\\n    .invoice_details{\\r\\n        \\/*margin-bottom: 10px;*\\/\\r\\n    }\\r\\n    .invoice_detail_left{\\r\\n        \\/*float: left;*\\/\\r\\n        width: 48%\\r\\n    }\\r\\n    .invoice_detail_right{\\r\\n        \\/*float: right;*\\/\\r\\n        width: 48%\\r\\n    }\\r\\n\\r\\n\\r\\n    .invoice_detail_table  {\\r\\n        width: 100%;\\r\\n        border-collapse: collapse;\\r\\n        border-spacing: 0;\\r\\n        font-size: 1.0em;\\r\\n\\r\\n        \\/*margin-bottom: 20px;*\\/\\r\\n    }\\r\\n\\r\\n    .invoice_detail_table th{\\r\\n        width: 140px;\\r\\n        text-align: left;\\r\\n        \\/*border-bottom: 1px solid #c2c2c2;*\\/\\r\\n        padding: 10px;\\r\\n        color: #555;\\r\\n    }\\r\\n\\r\\n    .invoice_detail_table td{\\r\\n        text-align: left;\\r\\n        border-bottom: 1px solid #c2c2c2;\\r\\n        padding: 10px;\\r\\n        color: #555;\\r\\n    }\\r\\n\\r\\n    .authorize_signatory_table th{\\r\\n        width: 160px;\\r\\n        text-align: left;\\r\\n        \\/*border-bottom: 1px solid #c2c2c2;*\\/\\r\\n        padding: 10px;\\r\\n        color: #555;\\r\\n    }\\r\\n\\r\\n    .authorize_signatory_table td{\\r\\n        text-align: left;\\r\\n        border-bottom: 1px solid #c2c2c2;\\r\\n        padding: 10px;\\r\\n        color: #555;\\r\\n    }\\r\\n\\r\\n    #thanks{\\r\\n        font-size: 2em;\\r\\n        margin-bottom: 50px;\\r\\n    }\\r\\n\\r\\n    #notices{\\r\\n        padding-left: 6px;\\r\\n        border-left: 6px solid #0087C3;  \\r\\n    }\\r\\n\\r\\n    #notices .notice {\\r\\n        font-size: 1.2em;\\r\\n    }\\r\\n\\r\\n    .footer {\\r\\n        color: #777777;\\r\\n        width: 100%;\\r\\n        height: 30px;\\r\\n        position: fixed;\\r\\n        bottom: 0px;\\r\\n        border-top: 1px solid #AAAAAA;\\r\\n        padding: 8px 0;\\r\\n        text-align: center;\\r\\n    }\",\"cash_on_delivery_active\":\"1\",\"bank_transfer_active\":\"1\",\"paypal_active\":\"0\",\"paypal_currency_code\":\"USD\",\"paypal_return_url\":\"\",\"extended_inventory_management\":\"0\",\"stripe_order_status_before_id\":\"-1\",\"stripe_order_status_after_id\":\"-1\",\"material_receipt_template_style\":\".product-title { width: 315px; display: inline-block; }\\r\\n.product-quantity { width: 50px; display: inline-block; }\\r\\n.product-price-without-tax { width: 100px; display: inline-block; text-align: right; }\\r\\n.product-tax { width: 100px; display: inline-block; text-align: right; }\\r\\n.product-price { width: 130px; display: inline-block; text-align: right; }\\r\\ntable { width: 100%; border-collapse: collapse;}\\r\\ntd, th { border: 1px solid #ccc; }\",\"material_receipt_template_content\":\"<table style=\\\"width: 100%;\\\">\\r\\n\\t<tbody>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"5\\\" style=\\\"vertical-align: middle; width: 100.414%;\\\">\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t\\t<div style=\\\"text-align: center;\\\"><strong>VSS BUILDCON PVT LTD<\\/strong><\\/div>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"4\\\" style=\\\"width: 65.4602%;\\\">\\r\\n\\t\\t\\t\\t<div style=\\\"text-align: left;\\\"><strong>&nbsp; Material Receipt :&nbsp;<\\/strong>{{m_r_number}}<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td colspan=\\\"1\\\" style=\\\"width: 34.4364%;\\\">\\r\\n\\t\\t\\t\\t<div style=\\\"text-align: left;\\\"><strong>&nbsp; Date :&nbsp;<\\/strong>{{context_date}}<\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"2\\\" style=\\\"width: 40.7446%;\\\"><strong>&nbsp; Supplied By M\\/s :&nbsp;<\\/strong>{{supplier}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td colspan=\\\"2\\\" style=\\\"width: 24.819%;\\\"><strong>&nbsp; Bill\\/Challan No :&nbsp;<\\/strong>{{bill_number}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 34.4364%;\\\"><strong>&nbsp; Bill Date :&nbsp;<\\/strong>{{bill_date}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"2\\\" style=\\\"width: 40.7446%;\\\"><strong>&nbsp; Thru Vehicle No :&nbsp;<\\/strong>{{thru_vehicle_number}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td colspan=\\\"2\\\" style=\\\"width: 24.819%;\\\"><strong>&nbsp; Driver Name :&nbsp;<\\/strong>{{driver_name}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 34.4364%;\\\"><strong>&nbsp; Arrived Date :&nbsp;<\\/strong>{{arrived_on_date}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"5\\\" style=\\\"width: 100.414%;\\\">\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td style=\\\"width: 29.0589%;\\\"><strong>&nbsp; Description<\\/strong>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 11.5822%;\\\"><strong>&nbsp; Unit<\\/strong>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 12.6163%;\\\"><strong>&nbsp; Qty<\\/strong>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 12.2027%;\\\"><strong>&nbsp; Rate<\\/strong>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 34.4364%;\\\"><strong>&nbsp; Amount<\\/strong>\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr id=\\\"products_row\\\">\\r\\n\\t\\t\\t<td style=\\\"width: 29.0589%;\\\">&nbsp; {{product_title}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 11.5822%;\\\">&nbsp; {{product_unit}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 12.6163%;\\\">&nbsp; {{product_qty}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 12.2027%;\\\">&nbsp; {{product_rate}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 34.4364%;\\\">&nbsp; {{product_total_price}}\\r\\n\\t\\t\\t\\t<br>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"4\\\" style=\\\"width: 65.4602%;\\\">\\r\\n\\t\\t\\t\\t<div style=\\\"text-align: right;\\\"><strong>Total Price &nbsp;<\\/strong><\\/div>\\r\\n\\t\\t\\t<\\/td>\\r\\n\\t\\t\\t<td style=\\\"width: 34.4364%;\\\">&nbsp; {{total_price}}<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t\\t<tr>\\r\\n\\t\\t\\t<td colspan=\\\"5\\\" style=\\\"width: 100.414%;\\\">&nbsp; <strong>Remarks :&nbsp;<\\/strong>{{note}}<\\/td>\\r\\n\\t\\t<\\/tr>\\r\\n\\t<\\/tbody>\\r\\n<\\/table>\"}'),(4,'backend_brand_settings','{\"app_name\":\"Inventory Management System\",\"app_tagline\":\"OctoberERP\",\"primary_color\":\"#34495e\",\"secondary_color\":\"#e67e22\",\"accent_color\":\"#3498db\",\"menu_mode\":\"inline\",\"custom_css\":\"\"}');
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
INSERT INTO `user_groups` VALUES (1,'Supplier','supplier','Sample group for website users.','2016-08-28 12:33:49','2017-03-25 07:42:58'),(2,'Customer','customer','','2017-03-25 07:43:07','2017-03-25 07:43:07');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_throttle`
--

LOCK TABLES `user_throttle` WRITE;
/*!40000 ALTER TABLE `user_throttle` DISABLE KEYS */;
INSERT INTO `user_throttle` VALUES (1,1,NULL,0,NULL,0,NULL,0,NULL),(2,2,NULL,0,NULL,0,NULL,0,NULL),(3,3,NULL,0,NULL,0,NULL,0,NULL);
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
  `jkshop_ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `jkshop_contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_ds_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_address_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_postcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_is_county` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `oims_contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
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

-- Dump completed on 2018-04-06 14:32:42
