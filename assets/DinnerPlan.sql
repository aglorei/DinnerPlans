CREATE DATABASE dinnerplans;

USE dinnerplans;

-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: MYSQL35.MEDIA3.NET    Database: dinnerplans
-- ------------------------------------------------------
-- Server version	5.5.40

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
-- Table structure for table `bids`
--

DROP TABLE IF EXISTS `bids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` float DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_bids_users1_idx` (`user_id`),
  KEY `fk_bids_items1_idx` (`meal_id`),
  CONSTRAINT `fk_bids_items1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bids_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bids`
--

LOCK TABLES `bids` WRITE;
/*!40000 ALTER TABLE `bids` DISABLE KEYS */;
INSERT INTO `bids` VALUES (1,125,5,1,'2015-03-25 13:28:51'),(2,130,5,1,'2015-03-25 13:37:45'),(3,155,6,1,'2015-03-25 13:45:51'),(4,225,2,9,'2015-03-26 10:10:57'),(5,120,2,2,'2015-03-26 10:15:05'),(6,140,2,2,'2015-03-26 10:25:44'),(8,10,6,7,'2015-03-26 10:53:47'),(9,30,2,10,'2015-03-26 11:02:36'),(15,30,6,10,'2015-03-26 12:44:34'),(16,45.23,6,10,'2015-03-26 13:00:16'),(17,212,3,9,'2015-03-26 13:40:21'),(18,225,3,9,'2015-03-26 13:41:27'),(19,300,4,9,'2015-03-26 13:44:40'),(20,113.25,5,2,'2015-03-26 13:49:28'),(21,40,2,10,'2015-03-26 14:22:09'),(22,100,2,10,'2015-03-26 14:22:24'),(23,235,3,9,'2015-03-26 18:19:44'),(24,130.33,5,2,'2015-03-26 19:03:42');
/*!40000 ALTER TABLE `bids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) DEFAULT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'North African','2015-03-24 17:23:04','2015-03-24 17:23:04'),(2,'American','2015-03-24 17:23:15','2015-03-24 17:23:15'),(3,'French','2015-03-24 17:23:30','2015-03-24 17:23:30'),(4,'Tapas','2015-03-24 17:23:37','2015-03-24 17:23:37'),(5,'Indian','2015-03-24 17:23:43','2015-03-24 17:23:43'),(7,'Comfort Food','2015-03-24 17:29:27','2015-03-24 17:29:27'),(8,'Italian','2015-03-24 17:29:37','2015-03-24 17:29:37');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(145) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,'default_profile','/assets/images/default_profile.png','2015-03-24 17:03:14'),(4,'10258651_10152718814356501_4593570967621025241_o2.jpg','/uploads/10258651_10152718814356501_4593570967621025241_o2.jpg','2015-03-25 01:39:24'),(5,'kanye_west_amp_10-28-2013-160031.jpg','/uploads/kanye_west_amp_10-28-2013-160031.jpg','2015-03-25 01:44:09'),(6,'logo-ac6abf3301c05f3f70ae827520bb123b.png','/uploads/logo-ac6abf3301c05f3f70ae827520bb123b.png','2015-03-25 01:46:13'),(7,'nelson-mandela-400.jpg','/uploads/nelson-mandela-400.jpg','2015-03-25 21:40:46'),(8,'1bdca8cefa722f10cb0997e1ea757f5d.jpg','/uploads/1bdca8cefa722f10cb0997e1ea757f5d.jpg','2015-03-26 02:48:41'),(9,'badwolf32.png','/uploads/badwolf32.png','2015-03-26 02:51:53'),(10,'laughing.png','/uploads/laughing.png','2015-03-26 03:08:26'),(13,'pizza1.png','/uploads/pizza1.png','2015-03-26 04:26:23'),(14,'homemade-chicken-pot-pie-l.jpg','/uploads/homemade-chicken-pot-pie-l.jpg','2015-03-26 04:32:57'),(15,'iu1f7brY_400x400.png','/uploads/iu1f7brY_400x400.png','2015-03-26 04:46:27'),(17,'how-to-order-healthier-indian-food.jpg','/uploads/how-to-order-healthier-indian-food.jpg','2015-03-26 05:07:45'),(18,'my_photo.jpg','/uploads/my_photo.jpg','2015-03-26 10:45:50'),(19,'french-food.jpg','/uploads/french-food.jpg','2015-03-26 17:17:20'),(20,'merica-fuckyea.jpg','/uploads/merica-fuckyea.jpg','2015-03-26 17:26:36'),(21,'how-to-order-healthier-indian-food1.jpg','/uploads/how-to-order-healthier-indian-food1.jpg','2015-03-26 18:17:36'),(22,'katy-perry.jpg','/uploads/katy-perry.jpg','2015-03-26 21:21:52');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_has_images`
--

DROP TABLE IF EXISTS `meal_has_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meal_has_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meal_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`meal_id`,`image_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_meals_has_images_images1_idx` (`image_id`),
  KEY `fk_meals_has_images_meals1_idx` (`meal_id`),
  CONSTRAINT `fk_meals_has_images_meals1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meals_has_images_images1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_has_images`
--

LOCK TABLES `meal_has_images` WRITE;
/*!40000 ALTER TABLE `meal_has_images` DISABLE KEYS */;
INSERT INTO `meal_has_images` VALUES (5,7,13),(6,8,14),(7,9,17),(8,10,18),(9,2,19),(10,11,20),(11,12,21);
/*!40000 ALTER TABLE `meal_has_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meal_has_options`
--

DROP TABLE IF EXISTS `meal_has_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meal_has_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meal_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`meal_id`,`option_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_meals_has_options_options1_idx` (`option_id`),
  KEY `fk_meals_has_options_meals1_idx` (`meal_id`),
  CONSTRAINT `fk_meals_has_options_meals1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_meals_has_options_options1` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meal_has_options`
--

LOCK TABLES `meal_has_options` WRITE;
/*!40000 ALTER TABLE `meal_has_options` DISABLE KEYS */;
INSERT INTO `meal_has_options` VALUES (1,1,1),(2,1,3),(4,7,1),(5,7,2),(6,7,3),(7,8,1),(8,8,2),(9,9,5),(10,10,3),(11,12,2);
/*!40000 ALTER TABLE `meal_has_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meals`
--

DROP TABLE IF EXISTS `meals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meal` varchar(125) DEFAULT NULL,
  `description` text,
  `user_id` int(11) NOT NULL,
  `highest_bidder` int(11) DEFAULT NULL,
  `initial_price` float DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `current_price` float DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `meal_date` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_items_users_idx` (`user_id`),
  KEY `fk_items_categories1_idx` (`category_id`),
  CONSTRAINT `fk_items_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_items_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meals`
--

LOCK TABLES `meals` WRITE;
/*!40000 ALTER TABLE `meals` DISABLE KEYS */;
INSERT INTO `meals` VALUES (1,'Moroccan Dinner for 6-8','This personal dining experience is sure to be a feast for all the senses.Your choice of Tagine of Chicken Honey and Prunes, served with light honey sauce, almonds, prunes, and sesame seeds, or Tagine of Lamb, braised in ginger, saffron and garlic sauce with fried eggplant. Served with our house Couscous Marrakesh, Dessert and Mint Tea.',3,6,125,1,'2015-03-24 17:32:32',130,'2015-03-26 02:05:06','2015-04-04 14:06:43',1),(2,'Traditional French Dinner for 2','Dang, \'Ye even knows how to cook French cuisine! Can you imagine that? He still cannot read, but -damn- can he work up a good steak au poivre.',3,2,90,3,'2015-03-25 18:47:41',130.33,NULL,'2015-03-31 18:12:22',4),(7,'Artisan Mac and Cheese Night for the Ninjas','I wanted to take the chance to spoil you guys a little bit for being such great coding ninjas. I\'m very good at making MnC, so let\'s have a fun night with good food and maybe Settlers.',4,6,10,8,'2015-03-26 04:26:23',10,NULL,'2015-03-31 18:15:00',12),(8,'From the Grave Themed Party For 8','Since I\'m dead (unfortunately), I want to have a death themed party. There\'s going to be lots of comfort food (because us South Africans love comfort) and drinks and entertainment.',7,NULL,40,7,'2015-03-26 04:32:56',40,NULL,'2015-04-01 20:00:00',8),(9,'The Presidential Treatment for 3','Even though I have a crazy job, I want to get home one day and cook delicious Indian (wtf) cuisine for you. Think traditional masalas and curries, with a spicy bloody mary to top it off. My treat, because the Coding Dojo deserves it! Afterwards, League of Legends.',8,4,200,5,'2015-03-26 05:07:44',235,NULL,'2015-04-01 00:14:00',1),(10,'Fancy Pants Dinner Party with Me!','Cucumber sammies and cool cocktails.',1,2,25,4,'2015-03-26 10:45:50',50.23,NULL,'2015-03-28 19:00:00',2),(11,'\'Merika! for the whole planet','Fuck yea!',5,NULL,250,2,'2015-03-26 17:26:36',250,NULL,'2015-07-04 18:06:00',20),(12,'Crazy Indian Food for 8 People','This is Kanye West and I don\'t read books.',3,NULL,150,5,'2015-03-26 18:17:35',150,NULL,'2015-05-01 20:00:00',12);
/*!40000 ALTER TABLE `meals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`to_user_id`,`from_user_id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_messages_users2_idx` (`from_user_id`),
  KEY `fk_messages_users1` (`to_user_id`),
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,2,1,'This is a test message from Sara to Tien','2015-03-25 11:06:44','2015-03-25 11:06:44'),(2,3,1,'This is a test message from Sara to Kanye','2015-03-25 11:07:07','2015-03-25 11:07:07'),(3,4,1,'This is a test message from Sara to Michael','2015-03-25 11:07:32','2015-03-25 11:07:32'),(4,1,2,'This is a test message from Tien to Sarah','2015-03-25 11:07:48','2015-03-25 11:07:48'),(5,3,2,'This is a test message from Tien to Kanye','2015-03-25 11:08:01','2015-03-25 11:08:01'),(6,4,2,'This is a test message from Tien to Michael','2015-03-25 11:08:08','2015-03-25 11:08:08'),(7,1,3,'This is a test message from Kanye to Sarah','2015-03-25 11:08:26','2015-03-25 11:08:26'),(8,2,3,'This is a test message from Kanye to Tien','2015-03-25 11:08:33','2015-03-25 11:08:33'),(9,4,3,'This is a test message from Kanye to Michael','2015-03-25 11:09:08','2015-03-25 11:09:08'),(10,3,2,'Thanks for the message, Kanye! This is a message to test the reply function.','2015-03-25 14:39:54','2015-03-25 14:39:54'),(11,4,2,'Hi Michael! Just Tien here, checking on the messaging function.','2015-03-25 14:40:26','2015-03-25 14:40:26'),(15,2,7,'Nelson Mandela wants to apply to be a host! What do you think?','2015-03-25 18:31:11','2015-03-25 18:31:11'),(17,6,3,'Congratulations, you are the highest bidder for Moroccan Dinner for 6-8! Please proceed to checkout at your earliest convenience. Contact your host for further details.','2015-03-26 02:05:06','2015-03-26 02:05:06'),(18,3,6,'Your auction for Moroccan Dinner for 6-8 has ended and Joe Logan is the highest bidder. They may contact you for further details.','2015-03-26 02:05:07','2015-03-26 02:05:07'),(19,7,2,'You\'re a host!','2015-03-26 03:10:13','2015-03-26 03:10:13'),(20,2,8,'Hey, what\'s the dealio?','2015-03-26 04:51:36','2015-03-26 04:51:36'),(21,2,8,'Barack Obama wants to apply to be a host! What do you think?','2015-03-26 04:58:54','2015-03-26 04:58:54'),(22,2,8,'Barack Obama wants to apply to be a host! What do you think?','2015-03-26 05:01:37','2015-03-26 05:01:37'),(23,2,8,'Barack Obama wants to apply to be a host! What do you think?','2015-03-26 05:02:17','2015-03-26 05:02:17'),(24,2,1,'Sarah Zephir-Thomason wants to apply to be a host! What do you think?','2015-03-26 10:42:23','2015-03-26 10:42:23'),(25,1,2,'You are now a host. Yay.','2015-03-26 10:42:49','2015-03-26 10:42:49'),(26,2,2,'Bad news, you\'ve been outbid on Fancy Pants Dinner Party with Me!. There is still time to increase your bid and win that delicious meal!','2015-03-26 13:00:16','2015-03-26 13:00:16'),(27,2,2,'Bad news, you\'ve been outbid on The Presidential Treatment for 3. There is still time to increase your bid and win that delicious meal!','2015-03-26 13:44:41','2015-03-26 13:44:41'),(28,6,2,'Bad news, you\'ve been outbid on Fancy Pants Dinner Party with Me!. There is still time to increase your bid and win that delicious meal!','2015-03-26 14:22:24','2015-03-26 14:22:24'),(29,2,6,'Joe Logan wants to apply to be a host! What do you think?','2015-03-26 16:17:00','2015-03-26 16:17:00'),(30,2,6,'Joe Logan wants to apply to be a host! What do you think?','2015-03-26 16:17:20','2015-03-26 16:17:20'),(31,2,6,'Joe Logan wants to apply to be a host! What do you think?','2015-03-26 16:17:34','2015-03-26 16:17:34'),(32,2,5,'Jason Franz wants to apply to be a host! What do you think?','2015-03-26 17:11:01','2015-03-26 17:11:01'),(33,2,9,'Katy Perry wants to apply to be a host! What do you think?','2015-03-26 18:11:52','2015-03-26 18:11:52'),(34,2,6,'Joe Logan wants to apply to be a host! What do you think?','2015-03-26 18:14:16','2015-03-26 18:14:16');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,'Vegetarian'),(2,'Vegan'),(3,'Gluten-free'),(4,'Dairy-free'),(5,'Paleo');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_users1_idx` (`user_id`),
  KEY `fk_orders_meals1_idx` (`meal_id`),
  CONSTRAINT `fk_orders_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_meals1` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `review` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `reviewer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reviews_users1_idx` (`reviewer_id`),
  KEY `fk_reviews_users2_idx` (`user_id`),
  CONSTRAINT `fk_reviews_users1` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reviews_users2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '4',
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_id` int(11) DEFAULT '1',
  `rating` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_users_images1_idx` (`image_id`),
  CONSTRAINT `fk_users_images1` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,5,'Sarah','Zephir-Thomason','sarahzt22@gmail.com','My name is Sarah and I work really hard on this stuff.','eeQE5vJgyKhag','2015-03-24 17:15:04','2015-03-25 12:29:59',10,0),(2,9,'Tienlong','Pham','tien@dojo.com','This is me, updating my awesome description about how awesome I am, because it makes me an awesome person.','e0s6ejedvC1Sg','2015-03-25 00:43:58','2015-03-25 01:39:46',4,0),(3,5,'Kanye','West','kwest@dojo.com','This is Kanye West! I\'m looking forward to having dope parties as a dope host, because I know dope people and I\'m a dope person. No reading!','c1QwOgHoax4j6','2015-03-25 01:41:54','2015-03-25 13:19:38',5,0),(4,5,'Michael','Choi','mchoi@dojo.com','Hello! Who do you think I love? Well. I love my dojo-ers/ninjas!','e9NQuXHW777qE','2015-03-25 01:43:11','2015-03-26 05:03:44',6,0),(5,5,'Jason','Franz','some@email.com','My Name is Jason and I\'m an awesome person who sleeps sometimes.','b4Zagq1r5YJrU','2015-03-25 11:41:39','2015-03-25 12:31:07',8,0),(6,4,'Joe','Logan','jl@email.com','Hi! This is a dummy account that bids on a lot of listings, but only has user privileges.','11fzdpvsGNKVI','2015-03-25 13:42:37','2015-03-26 21:20:22',9,0),(7,5,'Nelson','Mandela','nmandela@dojo.com','Nelson Rolihlahla Mandela was a South African anti-apartheid revolutionary, politician and philanthropist who served as President of South Africa from 1994 to 1999.','f9r8dsq5C884U','2015-03-25 18:22:35','2015-03-26 21:28:00',7,0),(8,5,'Barack','Obama','bobama@dojo.com','Barack Hussein Obama II is the 44th and current President of the United States, and the first African American to hold the office.\r\n','c1QwOgHoax4j6','2015-03-26 04:45:12','2015-03-26 21:24:47',15,0),(9,4,'Katy','Perry','kperry@dojo.com','Katheryn Elizabeth Hudson, better known by her stage name Katy Perry, is an American singer, songwriter and occasional actress.','62/ae65KyXoAM','2015-03-26 18:11:01','2015-03-26 21:23:29',22,0);
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

-- Dump completed on 2015-03-27  8:31:41
