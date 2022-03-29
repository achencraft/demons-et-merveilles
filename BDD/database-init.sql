
--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jour` tinyint(1) NOT NULL,
  `valeur` varchar(50) NOT NULL,
  `valide` tinyint(1) NOT NULL,
  `jour_associe` varchar(50) NOT NULL,
  `heure` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `configuration`
--

LOCK TABLES `configuration` WRITE;
INSERT INTO `configuration` VALUES (1,1,'Lundi',0,'',0),(2,1,'Mardi',0,'',0),(3,1,'Mercredi',0,'',0),(4,1,'Jeudi',0,'',0),(5,1,'Vendredi',0,'',0),(6,1,'Samedi',1,'',0),(7,1,'Dimanche',1,'',0),(8,0,'0h00',0,'Lundi',1),(9,0,'0h30',0,'Lundi',1),(10,0,'1h00',0,'Lundi',1),(11,0,'1h30',0,'Lundi',1),(12,0,'2h00',0,'Lundi',1),(13,0,'2h30',0,'Lundi',1),(14,0,'3h00',0,'Lundi',1),(15,0,'3h30',0,'Lundi',1),(16,0,'4h00',0,'Lundi',1),(17,0,'4h30',0,'Lundi',1),(18,0,'5h00',0,'Lundi',1),(19,0,'5h30',0,'Lundi',1),(20,0,'6h00',0,'Lundi',1),(21,0,'6h30',0,'Lundi',1),(22,0,'7h00',0,'Lundi',1),(23,0,'7h30',0,'Lundi',1),(24,0,'8h00',0,'Lundi',1),(25,0,'8h30',0,'Lundi',1),(26,0,'9h00',0,'Lundi',1),(27,0,'9h30',0,'Lundi',1),(28,0,'10h00',0,'Lundi',1),(29,0,'10h30',0,'Lundi',1),(30,0,'11h00',0,'Lundi',1),(31,0,'11h30',0,'Lundi',1),(32,0,'12h00',0,'Lundi',1),(33,0,'12h30',0,'Lundi',1),(34,0,'13h00',0,'Lundi',1),(35,0,'13h30',0,'Lundi',1),(36,0,'14h00',0,'Lundi',1),(37,0,'14h30',0,'Lundi',1),(38,0,'15h00',0,'Lundi',1),(39,0,'15h30',0,'Lundi',1),(40,0,'16h00',0,'Lundi',1),(41,0,'16h30',0,'Lundi',1),(42,0,'17h00',0,'Lundi',1),(43,0,'17h30',0,'Lundi',1),(44,0,'18h00',0,'Lundi',1),(45,0,'18h30',0,'Lundi',1),(46,0,'19h00',0,'Lundi',1),(47,0,'19h30',0,'Lundi',1),(48,0,'20h00',0,'Lundi',1),(49,0,'20h30',0,'Lundi',1),(50,0,'21h00',0,'Lundi',1),(51,0,'21h30',0,'Lundi',1),(52,0,'22h00',0,'Lundi',1),(53,0,'22h30',0,'Lundi',1),(54,0,'23h00',0,'Lundi',1),(55,0,'23h30',0,'Lundi',1),(56,0,'0h00',0,'Mardi',1),(57,0,'0h30',0,'Mardi',1),(58,0,'1h00',0,'Mardi',1),(59,0,'1h30',0,'Mardi',1),(60,0,'2h00',0,'Mardi',1),(61,0,'2h30',0,'Mardi',1),(62,0,'3h00',0,'Mardi',1),(63,0,'3h30',0,'Mardi',1),(64,0,'4h00',0,'Mardi',1),(65,0,'4h30',0,'Mardi',1),(66,0,'5h00',0,'Mardi',1),(67,0,'5h30',0,'Mardi',1),(68,0,'6h00',0,'Mardi',1),(69,0,'6h30',0,'Mardi',1),(70,0,'7h00',0,'Mardi',1),(71,0,'7h30',0,'Mardi',1),(72,0,'8h00',0,'Mardi',1),(73,0,'8h30',0,'Mardi',1),(74,0,'9h00',0,'Mardi',1),(75,0,'9h30',0,'Mardi',1),(76,0,'10h00',0,'Mardi',1),(77,0,'10h30',0,'Mardi',1),(78,0,'11h00',0,'Mardi',1),(79,0,'11h30',0,'Mardi',1),(80,0,'12h00',0,'Mardi',1),(81,0,'12h30',0,'Mardi',1),(82,0,'13h00',0,'Mardi',1),(83,0,'13h30',0,'Mardi',1),(84,0,'14h00',0,'Mardi',1),(85,0,'14h30',0,'Mardi',1),(86,0,'15h00',0,'Mardi',1),(87,0,'15h30',0,'Mardi',1),(88,0,'16h00',0,'Mardi',1),(89,0,'16h30',0,'Mardi',1),(90,0,'17h00',0,'Mardi',1),(91,0,'17h30',0,'Mardi',1),(92,0,'18h00',0,'Mardi',1),(93,0,'18h30',0,'Mardi',1),(94,0,'19h00',0,'Mardi',1),(95,0,'19h30',0,'Mardi',1),(96,0,'20h00',0,'Mardi',1),(97,0,'20h30',0,'Mardi',1),(98,0,'21h00',0,'Mardi',1),(99,0,'21h30',0,'Mardi',1),(100,0,'22h00',0,'Mardi',1),(101,0,'22h30',0,'Mardi',1),(102,0,'23h00',0,'Mardi',1),(103,0,'23h30',0,'Mardi',1),(104,0,'0h00',0,'Mercredi',1),(105,0,'0h30',0,'Mercredi',1),(106,0,'1h00',0,'Mercredi',1),(107,0,'1h30',0,'Mercredi',1),(108,0,'2h00',0,'Mercredi',1),(109,0,'2h30',0,'Mercredi',1),(110,0,'3h00',0,'Mercredi',1),(111,0,'3h30',0,'Mercredi',1),(112,0,'4h00',0,'Mercredi',1),(113,0,'4h30',0,'Mercredi',1),(114,0,'5h00',0,'Mercredi',1),(115,0,'5h30',0,'Mercredi',1),(116,0,'6h00',0,'Mercredi',1),(117,0,'6h30',0,'Mercredi',1),(118,0,'7h00',0,'Mercredi',1),(119,0,'7h30',0,'Mercredi',1),(120,0,'8h00',0,'Mercredi',1),(121,0,'8h30',0,'Mercredi',1),(122,0,'9h00',0,'Mercredi',1),(123,0,'9h30',0,'Mercredi',1),(124,0,'10h00',0,'Mercredi',1),(125,0,'10h30',0,'Mercredi',1),(126,0,'11h00',0,'Mercredi',1),(127,0,'11h30',0,'Mercredi',1),(128,0,'12h00',0,'Mercredi',1),(129,0,'12h30',0,'Mercredi',1),(130,0,'13h00',0,'Mercredi',1),(131,0,'13h30',0,'Mercredi',1),(132,0,'14h00',0,'Mercredi',1),(133,0,'14h30',0,'Mercredi',1),(134,0,'15h00',0,'Mercredi',1),(135,0,'15h30',0,'Mercredi',1),(136,0,'16h00',0,'Mercredi',1),(137,0,'16h30',0,'Mercredi',1),(138,0,'17h00',0,'Mercredi',1),(139,0,'17h30',0,'Mercredi',1),(140,0,'18h00',0,'Mercredi',1),(141,0,'18h30',0,'Mercredi',1),(142,0,'19h00',0,'Mercredi',1),(143,0,'19h30',0,'Mercredi',1),(144,0,'20h00',0,'Mercredi',1),(145,0,'20h30',0,'Mercredi',1),(146,0,'21h00',0,'Mercredi',1),(147,0,'21h30',0,'Mercredi',1),(148,0,'22h00',0,'Mercredi',1),(149,0,'22h30',0,'Mercredi',1),(150,0,'23h00',0,'Mercredi',1),(151,0,'23h30',0,'Mercredi',1),(152,0,'0h00',0,'Jeudi',1),(153,0,'0h30',0,'Jeudi',1),(154,0,'1h00',0,'Jeudi',1),(155,0,'1h30',0,'Jeudi',1),(156,0,'2h00',0,'Jeudi',1),(157,0,'2h30',0,'Jeudi',1),(158,0,'3h00',0,'Jeudi',1),(159,0,'3h30',0,'Jeudi',1),(160,0,'4h00',0,'Jeudi',1),(161,0,'4h30',0,'Jeudi',1),(162,0,'5h00',0,'Jeudi',1),(163,0,'5h30',0,'Jeudi',1),(164,0,'6h00',0,'Jeudi',1),(165,0,'6h30',0,'Jeudi',1),(166,0,'7h00',0,'Jeudi',1),(167,0,'7h30',0,'Jeudi',1),(168,0,'8h00',0,'Jeudi',1),(169,0,'8h30',0,'Jeudi',1),(170,0,'9h00',0,'Jeudi',1),(171,0,'9h30',0,'Jeudi',1),(172,0,'10h00',0,'Jeudi',1),(173,0,'10h30',0,'Jeudi',1),(174,0,'11h00',0,'Jeudi',1),(175,0,'11h30',0,'Jeudi',1),(176,0,'12h00',0,'Jeudi',1),(177,0,'12h30',0,'Jeudi',1),(178,0,'13h00',0,'Jeudi',1),(179,0,'13h30',0,'Jeudi',1),(180,0,'14h00',0,'Jeudi',1),(181,0,'14h30',0,'Jeudi',1),(182,0,'15h00',0,'Jeudi',1),(183,0,'15h30',0,'Jeudi',1),(184,0,'16h00',0,'Jeudi',1),(185,0,'16h30',0,'Jeudi',1),(186,0,'17h00',0,'Jeudi',1),(187,0,'17h30',0,'Jeudi',1),(188,0,'18h00',0,'Jeudi',1),(189,0,'18h30',0,'Jeudi',1),(190,0,'19h00',0,'Jeudi',1),(191,0,'19h30',0,'Jeudi',1),(192,0,'20h00',0,'Jeudi',1),(193,0,'20h30',0,'Jeudi',1),(194,0,'21h00',0,'Jeudi',1),(195,0,'21h30',0,'Jeudi',1),(196,0,'22h00',0,'Jeudi',1),(197,0,'22h30',0,'Jeudi',1),(198,0,'23h00',0,'Jeudi',1),(199,0,'23h30',0,'Jeudi',1),(200,0,'0h00',0,'Vendredi',1),(201,0,'0h30',0,'Vendredi',1),(202,0,'1h00',0,'Vendredi',1),(203,0,'1h30',0,'Vendredi',1),(204,0,'2h00',0,'Vendredi',1),(205,0,'2h30',0,'Vendredi',1),(206,0,'3h00',0,'Vendredi',1),(207,0,'3h30',0,'Vendredi',1),(208,0,'4h00',0,'Vendredi',1),(209,0,'4h30',0,'Vendredi',1),(210,0,'5h00',0,'Vendredi',1),(211,0,'5h30',0,'Vendredi',1),(212,0,'6h00',0,'Vendredi',1),(213,0,'6h30',0,'Vendredi',1),(214,0,'7h00',0,'Vendredi',1),(215,0,'7h30',0,'Vendredi',1),(216,0,'8h00',0,'Vendredi',1),(217,0,'8h30',0,'Vendredi',1),(218,0,'9h00',0,'Vendredi',1),(219,0,'9h30',0,'Vendredi',1),(220,0,'10h00',0,'Vendredi',1),(221,0,'10h30',0,'Vendredi',1),(222,0,'11h00',0,'Vendredi',1),(223,0,'11h30',0,'Vendredi',1),(224,0,'12h00',0,'Vendredi',1),(225,0,'12h30',0,'Vendredi',1),(226,0,'13h00',0,'Vendredi',1),(227,0,'13h30',0,'Vendredi',1),(228,0,'14h00',0,'Vendredi',1),(229,0,'14h30',0,'Vendredi',1),(230,0,'15h00',0,'Vendredi',1),(231,0,'15h30',0,'Vendredi',1),(232,0,'16h00',0,'Vendredi',1),(233,0,'16h30',0,'Vendredi',1),(234,0,'17h00',0,'Vendredi',1),(235,0,'17h30',0,'Vendredi',1),(236,0,'18h00',0,'Vendredi',1),(237,0,'18h30',0,'Vendredi',1),(238,0,'19h00',0,'Vendredi',1),(239,0,'19h30',0,'Vendredi',1),(240,0,'20h00',0,'Vendredi',1),(241,0,'20h30',0,'Vendredi',1),(242,0,'21h00',0,'Vendredi',1),(243,0,'21h30',0,'Vendredi',1),(244,0,'22h00',0,'Vendredi',1),(245,0,'22h30',0,'Vendredi',1),(246,0,'23h00',0,'Vendredi',1),(247,0,'23h30',0,'Vendredi',1),(248,0,'0h00',0,'Samedi',1),(249,0,'0h30',0,'Samedi',1),(250,0,'1h00',0,'Samedi',1),(251,0,'1h30',0,'Samedi',1),(252,0,'2h00',0,'Samedi',1),(253,0,'2h30',0,'Samedi',1),(254,0,'3h00',0,'Samedi',1),(255,0,'3h30',0,'Samedi',1),(256,0,'4h00',0,'Samedi',1),(257,0,'4h30',0,'Samedi',1),(258,0,'5h00',0,'Samedi',1),(259,0,'5h30',0,'Samedi',1),(260,0,'6h00',0,'Samedi',1),(261,0,'6h30',0,'Samedi',1),(262,0,'7h00',0,'Samedi',1),(263,0,'7h30',0,'Samedi',1),(264,0,'8h00',0,'Samedi',1),(265,0,'8h30',0,'Samedi',1),(266,0,'9h00',0,'Samedi',1),(267,0,'9h30',1,'Samedi',1),(268,0,'10h00',0,'Samedi',1),(269,0,'10h30',0,'Samedi',1),(270,0,'11h00',0,'Samedi',1),(271,0,'11h30',0,'Samedi',1),(272,0,'12h00',0,'Samedi',1),(273,0,'12h30',0,'Samedi',1),(274,0,'13h00',0,'Samedi',1),(275,0,'13h30',0,'Samedi',1),(276,0,'14h00',0,'Samedi',1),(277,0,'14h30',0,'Samedi',1),(278,0,'15h00',0,'Samedi',1),(279,0,'15h30',0,'Samedi',1),(280,0,'16h00',0,'Samedi',1),(281,0,'16h30',1,'Samedi',1),(282,0,'17h00',0,'Samedi',1),(283,0,'17h30',0,'Samedi',1),(284,0,'18h00',0,'Samedi',1),(285,0,'18h30',0,'Samedi',1),(286,0,'19h00',0,'Samedi',1),(287,0,'19h30',0,'Samedi',1),(288,0,'20h00',0,'Samedi',1),(289,0,'20h30',0,'Samedi',1),(290,0,'21h00',0,'Samedi',1),(291,0,'21h30',0,'Samedi',1),(292,0,'22h00',0,'Samedi',1),(293,0,'22h30',0,'Samedi',1),(294,0,'23h00',0,'Samedi',1),(295,0,'23h30',0,'Samedi',1),(296,0,'0h00',1,'Dimanche',1),(297,0,'0h30',0,'Dimanche',1),(298,0,'1h00',0,'Dimanche',1),(299,0,'1h30',0,'Dimanche',1),(300,0,'2h00',0,'Dimanche',1),(301,0,'2h30',0,'Dimanche',1),(302,0,'3h00',0,'Dimanche',1),(303,0,'3h30',0,'Dimanche',1),(304,0,'4h00',0,'Dimanche',1),(305,0,'4h30',0,'Dimanche',1),(306,0,'5h00',0,'Dimanche',1),(307,0,'5h30',0,'Dimanche',1),(308,0,'6h00',0,'Dimanche',1),(309,0,'6h30',0,'Dimanche',1),(310,0,'7h00',0,'Dimanche',1),(311,0,'7h30',0,'Dimanche',1),(312,0,'8h00',0,'Dimanche',1),(313,0,'8h30',0,'Dimanche',1),(314,0,'9h00',0,'Dimanche',1),(315,0,'9h30',1,'Dimanche',1),(316,0,'10h00',0,'Dimanche',1),(317,0,'10h30',0,'Dimanche',1),(318,0,'11h00',0,'Dimanche',1),(319,0,'11h30',0,'Dimanche',1),(320,0,'12h00',0,'Dimanche',1),(321,0,'12h30',0,'Dimanche',1),(322,0,'13h00',0,'Dimanche',1),(323,0,'13h30',0,'Dimanche',1),(324,0,'14h00',0,'Dimanche',1),(325,0,'14h30',0,'Dimanche',1),(326,0,'15h00',0,'Dimanche',1),(327,0,'15h30',0,'Dimanche',1),(328,0,'16h00',0,'Dimanche',1),(329,0,'16h30',0,'Dimanche',1),(330,0,'17h00',0,'Dimanche',1),(331,0,'17h30',0,'Dimanche',1),(332,0,'18h00',0,'Dimanche',1),(333,0,'18h30',0,'Dimanche',1),(334,0,'19h00',0,'Dimanche',1),(335,0,'19h30',0,'Dimanche',1),(336,0,'20h00',0,'Dimanche',1),(337,0,'20h30',0,'Dimanche',1),(338,0,'21h00',0,'Dimanche',1),(339,0,'21h30',0,'Dimanche',1),(340,0,'22h00',0,'Dimanche',1),(341,0,'22h30',0,'Dimanche',1),(342,0,'23h00',0,'Dimanche',1),(343,0,'23h30',0,'Dimanche',1);
UNLOCK TABLES;

--
-- Table structure for table `creneaux`
--

DROP TABLE IF EXISTS `creneaux`;
CREATE TABLE `creneaux` (
  `id` int(11) NOT NULL,
  `debut` int(11) NOT NULL,
  `fin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `creneaux`
--

LOCK TABLES `creneaux` WRITE;
INSERT INTO `creneaux` VALUES (1,1554539400,1554562800),(2,1554564600,1554588000),(3,1554591600,1554620400),(4,1554625800,1554649200);
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `histoire_id` int(11) NOT NULL,
  `table_id` int(11) DEFAULT '-1',
  `creneau_id` int(11) DEFAULT '-1',
  `nbr_joueur_courant` int(11) NOT NULL DEFAULT '0',
  `est_publie` tinyint(1) NOT NULL DEFAULT '0',
  `est_supprime` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `histoires`
--

DROP TABLE IF EXISTS `histoires`;
CREATE TABLE `histoires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  `nom_mj` varchar(50) NOT NULL,
  `niveau_mj` varchar(50) NOT NULL,
  `nbr_joueur_min` int(11) NOT NULL,
  `nbr_joueur_max` int(11) NOT NULL,
  `duree` varchar(10) NOT NULL,
  `jour` varchar(20) NOT NULL,
  `heure` varchar(10) NOT NULL,
  `description_courte` longtext NOT NULL,
  `description_longue` longtext NOT NULL,
  `id_image` int(11) DEFAULT '-1',
  `valide_par_admin` tinyint(1) NOT NULL DEFAULT '0',
  `valide_par_user` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE `inscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `debut` int(11) NOT NULL,
  `fin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `nbr_place` int(11) NOT NULL,
  `emplacement` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  `date_naissance` int(10) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `signup_date` int(10) NOT NULL,
  `valide` tinyint(1) NOT NULL DEFAULT '0',
  `confirm_cle` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES (1,'demo','$2a$10$/MCjtTQessDO7X206OlGAuBUHOtg5j2YAe/grrLLkMLk2uiXn3aae','demo@demo.demo','0000000000',1548975600,1,1,1548975600,1,'91fc725f958acad72c16759f5d19faae');
UNLOCK TABLES;
