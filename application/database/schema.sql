-- MySQL dump 10.13  Distrib 5.5.46, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: scraper
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
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` text NOT NULL,
  `registar_name` text NOT NULL,
  `whoisserver` text NOT NULL,
  `domainstatus` text NOT NULL,
  `nameservers` text NOT NULL,
  `registarydomainid` text NOT NULL,
  `registarurl` text NOT NULL,
  `updateddate` text NOT NULL,
  `creationdata` text NOT NULL,
  `expirationdata` text NOT NULL,
  `registarIANAID` text NOT NULL,
  `abuseemail` text NOT NULL,
  `abusephone` text NOT NULL,
  `registrantid` text NOT NULL,
  `registrantname` text NOT NULL,
  `registrantorg` text NOT NULL,
  `registrantstreet` text NOT NULL,
  `registrantcity` text NOT NULL,
  `registrantstate` text NOT NULL,
  `registrantpostal` text NOT NULL,
  `registrantcountry` text NOT NULL,
  `registrantphone` text NOT NULL,
  `registrantphoneext` text NOT NULL,
  `registrantfax` text NOT NULL,
  `registrantfaxext` text NOT NULL,
  `registrantemail` text NOT NULL,
  `registryadminid` text NOT NULL,
  `adminname` text NOT NULL,
  `adminorganization` text NOT NULL,
  `adminstreet` text NOT NULL,
  `admincity` text NOT NULL,
  `adminstate` text NOT NULL,
  `adminpostalcode` text NOT NULL,
  `admincountry` text NOT NULL,
  `adminphone` text NOT NULL,
  `adminphoneext` text NOT NULL,
  `adminfax` text NOT NULL,
  `adminfaxext` text NOT NULL,
  `adminemail` text NOT NULL,
  `registrarytechid` text NOT NULL,
  `techname` text NOT NULL,
  `techorganization` text NOT NULL,
  `techstreet` text NOT NULL,
  `techcity` text NOT NULL,
  `techstate` text NOT NULL,
  `techpostal` text NOT NULL,
  `techcountry` text NOT NULL,
  `techphone` text NOT NULL,
  `techphoneext` text NOT NULL,
  `techfax` text NOT NULL,
  `techfaxext` text NOT NULL,
  `techemail` text NOT NULL,
  `dnssec` text NOT NULL,
  `export` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `site` (`site`(255))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mydata`
--

DROP TABLE IF EXISTS `mydata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mydata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` text NOT NULL,
  `regno` text NOT NULL,
  `created` text NOT NULL,
  `expired` text NOT NULL,
  `modified` text NOT NULL,
  `admincode` text NOT NULL,
  `admincol1` text NOT NULL,
  `admincol2` text NOT NULL,
  `admintel` text NOT NULL,
  `adminfax` text NOT NULL,
  `adminemail` text NOT NULL,
  `admincol3` text NOT NULL,
  `billingcode` text NOT NULL,
  `billingcol1` text NOT NULL,
  `billingcol2` text NOT NULL,
  `billingtel` text NOT NULL,
  `billingfax` text NOT NULL,
  `billingemail` text NOT NULL,
  `billingcol3` text NOT NULL,
  `techcode` text NOT NULL,
  `techcol1` text NOT NULL,
  `techcol2` text NOT NULL,
  `techtel` text NOT NULL,
  `techfax` text NOT NULL,
  `techemail` text NOT NULL,
  `techcol3` text NOT NULL,
  `registrantcode` text NOT NULL,
  `registrantcol1` text NOT NULL,
  `registrantcol2` text NOT NULL,
  `registranttel` text NOT NULL,
  `registrantfax` text NOT NULL,
  `registrantemail` text NOT NULL,
  `registrantcol3` text NOT NULL,
  `export` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `site` (`site`(255))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sgdata`
--

DROP TABLE IF EXISTS `sgdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sgdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` text NOT NULL,
  `creation` text NOT NULL,
  `modification` text NOT NULL,
  `expiration` text NOT NULL,
  `domainstatus` text NOT NULL,
  `registrantname` text NOT NULL,
  `adminname` text NOT NULL,
  `techname` text NOT NULL,
  `techemail` text NOT NULL,
  `nameservers` text NOT NULL,
  `export` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `site` (`site`(200))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sites`
--

DROP TABLE IF EXISTS `sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site` (`site`(250))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-28 13:53:45
