-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: db    Database: tic_tac_toe
-- ------------------------------------------------------
-- Server version	5.7.17

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
-- Table structure for table `board`
--

DROP TABLE IF EXISTS `board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board` (
  `id_board` int(11) NOT NULL,
  `row` int(1) NOT NULL,
  `col` int(1) NOT NULL,
  `figure` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_board`,`row`,`col`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board`
--

LOCK TABLES `board` WRITE;
/*!40000 ALTER TABLE `board` DISABLE KEYS */;
INSERT INTO `board` VALUES (1,2,1,'o'),(1,2,2,'o'),(1,2,3,'x'),(1,3,1,'o'),(1,3,2,'x'),(1,3,3,'o'),(2,2,1,'o'),(2,2,2,'o'),(2,2,3,'x'),(2,3,1,'x'),(2,3,2,'o'),(3,1,2,'x'),(3,1,3,'o'),(3,2,1,'o'),(3,2,2,'o'),(3,2,3,'x'),(3,3,1,'o'),(3,3,3,'x'),(4,1,1,'o'),(4,1,2,'x'),(4,2,2,'x'),(4,2,3,'x'),(4,3,1,'o'),(4,3,2,'x'),(4,3,3,'o'),(5,1,1,'o'),(5,1,3,'o'),(5,2,2,'o'),(5,2,3,'x'),(5,3,3,'o'),(6,1,1,'x'),(6,1,2,'x'),(6,1,3,'o'),(6,2,1,'x'),(6,2,2,'o'),(6,2,3,'x'),(6,3,3,'x'),(7,1,2,'x'),(7,1,3,'x'),(7,2,1,'o'),(7,2,2,'o'),(7,3,2,'o'),(8,1,2,'x'),(8,1,3,'x'),(8,2,2,'o'),(8,2,3,'o'),(8,3,1,'o'),(8,3,3,'x'),(9,1,2,'x'),(9,2,1,'o'),(9,3,1,'x'),(9,3,2,'o'),(9,3,3,'o'),(10,1,1,'o'),(10,1,2,'o'),(10,2,2,'x'),(10,3,1,'o'),(10,3,3,'o');
/*!40000 ALTER TABLE `board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `board_has_figures`
--

DROP TABLE IF EXISTS `board_has_figures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `board_has_figures` (
  `board_id_board` int(11) NOT NULL,
  `figures_id_figure` int(11) NOT NULL,
  PRIMARY KEY (`board_id_board`,`figures_id_figure`),
  KEY `fk_board_has_figures_figures1_idx` (`figures_id_figure`),
  KEY `fk_board_has_figures_board1_idx` (`board_id_board`),
  CONSTRAINT `fk_board_has_figures_board1` FOREIGN KEY (`board_id_board`) REFERENCES `board` (`id_board`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_board_has_figures_figures1` FOREIGN KEY (`figures_id_figure`) REFERENCES `figures` (`id_figure`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board_has_figures`
--

LOCK TABLES `board_has_figures` WRITE;
/*!40000 ALTER TABLE `board_has_figures` DISABLE KEYS */;
INSERT INTO `board_has_figures` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2);
/*!40000 ALTER TABLE `board_has_figures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `figures`
--

DROP TABLE IF EXISTS `figures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `figures` (
  `id_figure` int(11) NOT NULL,
  `figure` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_figure`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `figures`
--

LOCK TABLES `figures` WRITE;
/*!40000 ALTER TABLE `figures` DISABLE KEYS */;
INSERT INTO `figures` VALUES (1,'x'),(2,'o');
/*!40000 ALTER TABLE `figures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id_game` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `board_id_board` int(11) NOT NULL,
  PRIMARY KEY (`id_game`),
  KEY `fk_games_board_idx` (`board_id_board`),
  CONSTRAINT `fk_games_board` FOREIGN KEY (`board_id_board`) REFERENCES `board` (`id_board`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'2016-08-08','2016-10-12',1),(2,'2016-05-20','2016-10-23',2),(3,'2016-10-31','2017-02-21',3),(4,'2016-06-21','2016-05-16',4),(5,'2017-03-06','2016-07-03',5),(6,'2016-03-29','2016-09-19',6),(7,'2016-08-07','2016-05-17',7),(8,'2016-08-06','2016-04-20',8),(9,'2017-01-25','2016-05-04',9),(10,'2016-11-08','2016-04-02',10);
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games_has_users`
--

DROP TABLE IF EXISTS `games_has_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games_has_users` (
  `games_id_game` int(11) NOT NULL,
  `users_id_user` int(11) NOT NULL,
  PRIMARY KEY (`games_id_game`,`users_id_user`),
  KEY `fk_games_has_users_users1_idx` (`users_id_user`),
  KEY `fk_games_has_users_games1_idx` (`games_id_game`),
  CONSTRAINT `fk_games_has_users_games1` FOREIGN KEY (`games_id_game`) REFERENCES `games` (`id_game`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_games_has_users_users1` FOREIGN KEY (`users_id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games_has_users`
--

LOCK TABLES `games_has_users` WRITE;
/*!40000 ALTER TABLE `games_has_users` DISABLE KEYS */;
INSERT INTO `games_has_users` VALUES (1,1),(1,2),(2,3),(2,4),(3,5),(3,6),(4,7),(4,8),(5,9),(5,10);
/*!40000 ALTER TABLE `games_has_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `number` varchar(1) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1','Teresa','Hernandez','2016-11-12','2017-01-03'),(2,'1','Fred','Barnes','2016-08-27','2017-02-08'),(3,'2','Teresa','King','2016-05-31','2016-08-10'),(4,'1','Jeremy','Lawrence','2016-05-30','2016-07-09'),(5,'1','Bobby','Patterson','2016-04-03','2016-09-23'),(6,'1','Julia','Scott','2016-06-19','2016-06-11'),(7,'2','Paul','Simpson','2016-12-15','2016-09-07'),(8,'1','Charles','Weaver','2016-10-08','2016-04-05'),(9,'2','Kimberly','Larson','2017-03-06','2016-08-23'),(10,'2','Linda','Rodriguez','2016-07-07','2016-09-16');
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

-- Dump completed on 2017-03-22 12:20:42
