CREATE DATABASE  IF NOT EXISTS `bnbs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;
USE `bnbs`;
-- MySQL dump 10.13  Distrib 8.0.15, for Win64 (x86_64)
--
-- Host: localhost    Database: bnbs
-- ------------------------------------------------------
-- Server version	8.0.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `images` (
  `image_name` varchar(50) NOT NULL,
  `id` int(11) DEFAULT NULL,
  PRIMARY KEY (`image_name`),
  KEY `fk_images_id_items_id_idx` (`id`),
  CONSTRAINT `fk_images_id_items_id` FOREIGN KEY (`id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES ('5cc61b20622ce',NULL),('5cc61b2063f21',NULL),('5cc61b2065930',NULL),('5cc622f4e06ab',NULL),('5cc622f4e1572',NULL),('5cc622f4e2cff',NULL),('5c8f305e263f8',19),('5c8f305e26aa2',19),('5c8f305e27082',19),('5c8f0596e1c3d',20),('5c8f0596e1c3e',20),('5c8f0596e1c3f',20),('5c8f0596e1c40',21),('5c8f0596e1c41',21),('5c8f0596e1c42',21),('5c8f0596e1c43',22),('5c8f0596e1c44',23),('5c8f0596e1c45',23),('5c8f0596e1c46',23),('5c8f0596e1c47',24),('5c8f0596e1c48',24),('5c8f0596e1c49',24),('5c8f0596e1c4a',25),('5c8f0596e1c4b',25),('5c8f0596e1c4c',25),('5c8f0596e1c4d',26),('5c8f0596e1c4e',26),('5c8f0596e1c4f',26),('5c8f0596e1c50',27),('5c8f0596e1c51',27),('5c8f0596e1c52',27),('5c8f0596e1c53',28),('5c8f0596e1c54',28),('5c8f0596e1c55',28),('5cc626e36ac21',34),('5cc626e36c94b',34),('5cc626e36de90',34);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `bedrooms` int(11) NOT NULL DEFAULT '1',
  `beds` int(11) NOT NULL DEFAULT '1',
  `baths` int(11) NOT NULL DEFAULT '0',
  `superhosted` tinyint(4) NOT NULL DEFAULT '0',
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (19,'Cozy Camper on The Hill',1,2,1,0,'Nice little camper set on-top of a small hill. Scenic water feature and space. Enjoy a night under the stars sitting around a fire. Great for a perfect little getaway or an inexpensive overnight for those passing through. A stones throw from MoKan Speedway and half way between Joplin MO and Pittsburg KS.'),(20,'Cozy studio apartment near downtown Pittsburg',1,1,1,0,'700 ft studio apartment. 1 full size bed with sheets and comforter, a living and kitchen area, bathroom and closet. In an apartment complex close to a main road in Pittsburg. Super easy to navigate around and should be sufficient for a short vacation to Pittsburg!'),(21,'Large basement apt near Med School/I-44/hospitals',2,2,1,1,'An entire private basement in our family home with a private entrance!I started hosting on Airbnb when myvcareer as a trial attorney led me to a job working mostly from home, which allows me to spend more time making a home for us & others. My goal is to make this space an incredible value with homey, personal touches.'),(22,'Terri Place',1,1,0,1,'It\'s comfortable non smoking free wifi and cable tv in your room . When pool season starts you can use our pool and deck we have grills to barbecue.. you have a fridge in your room large closet and a microwave . If you like casinos we have several in the area . We are close to Route 66.'),(23,'Charming Studio Apartment in Roanoke Terrace',1,1,1,1,'Newly renovated adorable studio apartment above our 2-car detached garage. We are located in scenic Roanoke Terrace neighborhood, one of the safest neighborhoods in Joplin. Large trees, character, and beautiful houses await you. We are within short driving distance to both hospitals and walking distance to historic downtown Joplin and Ozark Christian College. Private entry and charming decor in a fresh and new space.'),(24,'Near airport & trail - Private bath - pets welcome',1,1,1,0,'Small private room with TV & WiFi. No cable No one shares your bath but it is across the hallway. Shower NO tub.More information Keyless entry for late check in Safe, quiet, convenient area. 20 acres inside city limits. Walking distance to a Trail if you want to walk, run or ride. Easy access to downtown, the airport, MSSU, mall and OCC. We are very happy to socialize but also are totally respectful of your privacy. Any pets welcome as long as they are friendly. We have med/large indoor dogs.'),(25,'Private room and private bathroom, no cleaning fee',1,2,1,1,'This private guest room with queen bed, desk, walk in closet, and private bathroom is the only room we rent. The bathroom is not shared with anyone. Our home was completed in 2017. It is on one level without stairs and parking is safe in our low traffic residential area. Also, covered front and back patios. No cleaning fees. '),(26,'Spacious private guest room & private bathroom',1,1,1,1,'Private & spacious guest bedroom with private full bathroom in cozy home! Extremely comfortable queen bed with memory foam topper! Large room with an empty dresser and plenty of closet space. Available for short or long-term stays!'),(27,'Chateau de Pearl~ Short/Long Term for Any & All',1,1,2,0,'Hey oh! Super cute home with private bedroom/bathroom available. All rent includes: heat/air, WIFI, electric, gas, trash, street parking, and a super cool roommate. I do have a few rules, I\'m super clean and pretty easygoing. Minutes away from both hospitals. Holla if you\'re interested.'),(28,'The Edge at Rouse',4,4,4,1,'This luxury student housing community is located near Pittsburg State University.'),(34,'Guy Fieri\'s House',1,1,1,0,'Welcome to Flavor Town! ');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-28 17:28:02
