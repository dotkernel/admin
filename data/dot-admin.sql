--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `firstName` varchar(150) DEFAULT NULL,
  `lastName` varchar(150) DEFAULT NULL,
  `role` enum('superuser','admin') NOT NULL DEFAULT 'admin',
  `status` enum('pending','active','inactive','deleted') NOT NULL DEFAULT 'active',
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin@admin.com','$2y$11$mPxSiRXjgCRFnyzCsS/85epxA0uiOJnZsAxzk28sBj63rszgC0XRi','Admin','Admin','superuser','active','2016-10-28 17:42:40');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_admin_action`
--

DROP TABLE IF EXISTS `log_admin_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_admin_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(150) NOT NULL,
  `agentId` int(11) DEFAULT NULL,
  `agentName` varchar(150) DEFAULT NULL,
  `type` enum('login','logout','create','update','delete') NOT NULL,
  `targetId` varchar(150) DEFAULT NULL,
  `target` mediumtext,
  `message` mediumtext NOT NULL,
  `status` enum('ok','error') DEFAULT 'ok',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;