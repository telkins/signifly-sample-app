CREATE DATABASE  IF NOT EXISTS `signifly_sample` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `signifly_sample`;
-- MySQL dump 10.13  Distrib 5.6.22, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: signifly_sample
-- ------------------------------------------------------
-- Server version	5.5.27-log

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
-- Table structure for table `area_of_expertise`
--

DROP TABLE IF EXISTS `area_of_expertise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_of_expertise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_of_expertise`
--

LOCK TABLES `area_of_expertise` WRITE;
/*!40000 ALTER TABLE `area_of_expertise` DISABLE KEYS */;
INSERT INTO `area_of_expertise` VALUES (1,'project management'),(2,'software development'),(3,'photography'),(4,'graphic design'),(5,'digital design'),(6,'accounting'),(7,'strategy'),(8,'consulting'),(9,'film production');
/*!40000 ALTER TABLE `area_of_expertise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `profile_image_url` varchar(45) DEFAULT NULL,
  `years_with_signifly` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,'Michael','Valentin','Managing partner & konsulent','+45 28 19 29 66','mv@signifly.com','http://signifly.com/public/img/people/mv.jpg',6),(2,'Patrick','Rønning','Partner & konsulent','+45 40 31 24 98','plr@signifly.com','http://signifly.com/public/img/people/plr.jpg',6),(3,'Christian','Nielsen','Konsulent','+45 71 99 05 69','csn@signifly.com','http://signifly.com/public/img/people/csn.jpg',5),(4,'Alexander','Spliid','Partner & designer','+45 22 76 51 74','as@signifly.com','http://signifly.com/public/img/people/as.jpg',6),(5,'Kristian','Larsen','Producer','+45 22 37 37 35','ksl@signifly.com','http://signifly.com/public/img/people/ksl.jpg',5),(6,'Nikolaj','Karstenberg','Fotograf & klipper','+45 41 17 00 41','ntk@signifly.com','http://signifly.com/public/img/people/ntk.jpg',4),(7,'Christian','Wienberg','Fotograf & producer','+45 20 51 72 16','cw@signifly.com','http://signifly.com/public/img/people/cw.jpg',5),(8,'Line','Hybler','Udvikler','+45 28 21 54 45','lh@signifly.com','http://signifly.com/public/img/people/lh.jpg',3),(9,'Niklas','Markussen','Udvikler','+45 50 70 33 73','njm@signifly.com','http://signifly.com/public/img/people/njm.jpg',3),(10,'Emil','Andersen','Strategi & regnskab','+45 30 24 63 45','ep@signifly.com','http://signifly.com/public/img/people/ep.jpg',4),(11,'Bjarke','Kristensen','Grafisk designer','+45 22 73 58 73','bk@signifly.com','http://signifly.com/public/img/people/bk.jpg',4),(12,'Søren','Schrøder','Digital designer','+45 31 70 04 28','ss@signifly.com','http://signifly.com/public/img/people/ss.jpg',2),(13,'Trine','Rønsholdt','Digital designer','+45 29 85 07 40','tr@signifly.com','http://signifly.com/public/img/people/tr.jpg',2),(14,'Simone','Tonnesen','Juniorkonsulent','+45 30 24 96 49','st@signifly.com','http://signifly.com/public/img/people/st.jpg',1),(15,'Mads','Kjærgaard','Juniorkonsulent','+45 27 85 15 29','mk@signifly.com','http://signifly.com/public/img/people/mk.jpg',1);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_expertise`
--

DROP TABLE IF EXISTS `member_expertise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_expertise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `area_of_expertise_id` int(11) DEFAULT NULL,
  `proficiency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_expertise`
--

LOCK TABLES `member_expertise` WRITE;
/*!40000 ALTER TABLE `member_expertise` DISABLE KEYS */;
INSERT INTO `member_expertise` VALUES (1,1,1,3),(2,1,2,3),(3,1,8,3),(4,2,1,3),(5,3,1,3),(6,4,1,2),(7,4,4,3),(8,4,5,3),(9,5,9,3),(10,6,3,3),(11,6,9,2),(12,6,4,1),(13,6,5,1),(14,7,3,3),(15,7,9,3),(16,8,2,3),(17,9,2,3),(18,10,6,3),(19,10,7,3),(20,11,4,3),(21,12,5,3),(22,13,5,3),(23,14,8,2),(24,15,8,2);
/*!40000 ALTER TABLE `member_expertise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_technology`
--

DROP TABLE IF EXISTS `member_technology`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_technology` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `technology_id` int(11) DEFAULT NULL,
  `proficiency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_technology`
--

LOCK TABLES `member_technology` WRITE;
/*!40000 ALTER TABLE `member_technology` DISABLE KEYS */;
INSERT INTO `member_technology` VALUES (25,1,1,3),(26,1,2,3),(27,1,3,3),(28,1,4,3),(29,8,1,2),(30,8,8,3),(31,8,6,3),(32,8,7,3),(33,9,1,3),(34,9,2,3),(35,9,3,3),(36,9,9,2);
/*!40000 ALTER TABLE `member_technology` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_member`
--

DROP TABLE IF EXISTS `project_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_member`
--

LOCK TABLES `project_member` WRITE;
/*!40000 ALTER TABLE `project_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `technology`
--

DROP TABLE IF EXISTS `technology`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `technology` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `technology`
--

LOCK TABLES `technology` WRITE;
/*!40000 ALTER TABLE `technology` DISABLE KEYS */;
INSERT INTO `technology` VALUES (1,'php'),(2,'mysql'),(3,'database'),(4,'sql'),(5,'python'),(6,'jquery'),(7,'css'),(8,'javascript'),(9,'ruby'),(10,'rest'),(11,'aws'),(12,'api'),(13,'ms office'),(14,'ms word'),(15,'ms excel'),(16,'salesforce'),(17,'photoshop'),(18,'oracle'),(19,'mssql'),(20,'angular'),(21,'html'),(22,'html5'),(23,'zend framework'),(24,'symfony'),(25,'laravel'),(26,'git'),(27,'composer'),(28,'oauth2'),(29,'apache'),(30,'nginx'),(31,'vagrant'),(32,'docker'),(33,'jenkins'),(34,'illustrator'),(35,'hudson');
/*!40000 ALTER TABLE `technology` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'signifly_sample'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-15 10:54:51
