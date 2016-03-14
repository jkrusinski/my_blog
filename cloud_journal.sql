-- MySQL dump 10.13  Distrib 5.6.26, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: cloud_journal
-- ------------------------------------------------------
-- Server version	5.6.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES UTF8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `author` text,
  `date` text,
  `date_mod` text,
  `contents` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (12,'Let\'s see','uber','Wed, 29 Jul 2015, 11:42','Wed, 26 Aug 2015, 14:12','Does add post still work? blah'),(13,'New Post for Today','newest','Thu, 30 Jul 2015, 18:46','Sat, 15 Aug 2015, 22:47','Example goes here'),(14,'Brand New Post','jkrusinski','Thu, 30 Jul 2015, 19:04','Fri, 11 Sep 2015, 13:17','How about this? huh...?'),(16,'Does add_ids work','uber','Fri, 31 Jul 2015, 13:30','Fri, 09 Oct 2015, 18:13','LET US SEE, update 1'),(17,'Brand New Post','newest','Tue, 4 Aug 2015, 18:42','Sun, 16 Aug 2015, 01:31','Enter your post here... new update1'),(19,'Newest Post','jkrusinski','Tue, 11 Aug 2015, 20:10','Wed, 12 Aug 2015, 12:50','OMG THIS IS A POST'),(25,'Tag work','uber','Wed, 12 Aug 2015, 12:40','Fri, 11 Sep 2015, 13:41','I am so proud of this website! It\'s looking so cool, and it has actual functionality! YEAH BOI'),(26,'newww','newest','Wed, 12 Aug 2015, 14:09','Thu, 13 Aug 2015, 19:27','i got to stop making these. Update'),(30,'This is a double check','jkrusinski','Sat, 15 Aug 2015, 18:55','Fri, 11 Sep 2015, 15:05','Blah'),(31,'This is really starting to look good!!','uber','Sat, 15 Aug 2015, 22:45','Sat, 15 Aug 2015, 22:46','I have added a lot of UI and now it\'s really starting to look and feel like an app!'),(34,'Usernames Are Now Up','jkrusinski','Wed, 26 Aug 2015, 14:13','Fri, 11 Sep 2015, 11:47','Something goes here.'),(38,'New Post','lana','Fri, 11 Sep 2015, 11:22','Fri, 11 Sep 2015, 11:22','This is my newest post'),(40,'How To Build A Website','user123','Mon, 12 Oct 2015, 12:34','Mon, 12 Oct 2015, 12:41','Well this is it, I\'m starting my journey as a web developer. Where do I start? All of this information is overwhelming. I guess I will start with HTML. This seems simple enough! Oh this is going to be easy!'),(41,'HTML... Well That\'s Static','user123','Mon, 12 Oct 2015, 12:41','Mon, 12 Oct 2015, 12:44','So HTML isn\'t bad at all! Except those forms, how the heck do those work? Reading through my HTML book and I can\'t figure out how to make a form actually do something. It seems like that\'s where some functionality would appear, because all my website looks like now is just some plain text. I could do that with Microsoft Word and make it look way better! Let\'s see what CSS can do for me. '),(42,'CSS Beautifies','user123','Mon, 12 Oct 2015, 12:45','Mon, 12 Oct 2015, 12:47','So working with CSS now and my page is starting to look pretty! That\'s exciting. I can move elements around, give them borders, backgrounds, etc! It\'s looking better, but my website still doesn\'t do anything. Right now I\'m better off just putting a PDF on the web and letting everyone download that. Those forms are still irking me. Why won\'t they just doing something!?'),(43,'Javascript, Now This Is Programming','user123','Mon, 12 Oct 2015, 12:47','Mon, 12 Oct 2015, 12:54','Ah javascript. This is what I have been waiting for. I can make my website feel like an application now. I even made a dropdown menu! That\'s pretty cool. Except I don\'t get this whole DOM thing. And what\'s with all the cross-browser inconstancies? Those are super frustrating. Hopefully there\'s an easier way to control elements. '),(44,'jQuery To The Rescue','user123','Mon, 12 Oct 2015, 12:54','Mon, 12 Oct 2015, 12:57','Phew! I don\'t need to worry about those cross-browser inconsistencies anymore. The jQuery library is absolutely beautiful! Now I can use CSS selectors to grab elements and manipulate them with jQuery and javascript! Whoever came up with this is a genius. '),(45,'Let\'s Explore The Back End','user123','Mon, 12 Oct 2015, 12:57','Mon, 12 Oct 2015, 13:08','So learning the front end was fun. Now I know how to make a web page do some really cool things. I could probably make a pretty cool game with all these technologies! Maybe something military themed, simple to play yet addicting? I don\'t know, we\'ll see what comes up. But I still feel like there\'s so much missing. I mean, how do I make user logins? What about databases, I want to be able to store information that gets passed through my website. I want to make full fledged web applications! I think it\'s time to explore the back end.'),(46,'The Power of PHP','user123','Mon, 12 Oct 2015, 13:09','Mon, 12 Oct 2015, 13:14','Everything is starting to come together with PHP, especially forms! I FINALLY get forms! HTML forms is the UI that takes information from the user and passes it to the server where all the wonderful appy-ness takes place. And PHP is a template language, so I can use information that is stored on a server to actually build html pages specific to the user! This is crazy exciting. Now all I need to do is figure out what the heck an HTTP request is and the difference between GET and POST.'),(47,'I\'ve Learned So Much','user123','Mon, 12 Oct 2015, 13:15','Mon, 12 Oct 2015, 13:21','Now I\'m starting to feel like a true developer. I just signed up for amazon web services and started my own instance! I have complete control over an actual server, how cool is that! I\'m getting really strong at using the command line interface and learning a lot about unix machines. Learning the back end really gives you the tools to master computers and networks in general, not just how to code a website. This is exciting. '),(48,'AJAX','user123','Mon, 12 Oct 2015, 13:24','Mon, 12 Oct 2015, 13:29','It\'s unbelievable how much I\'ve learned so far, but yet with so much more to go. I just discovered AJAX and does that blow forms right out of the water. Now, instead of having to reload a page every time I want to communicate with the server, all I have to do is make an AJAX request. It really makes the sites feel responsive, further increasing the app feel. I\'m not building websites any more, I\'m building true web applications. '),(50,'New Post',NULL,'Sat, 14 Nov 2015, 21:44','Sat, 14 Nov 2015, 21:44','Your post goes here...'),(51,'New Post',NULL,'Thu, 17 Dec 2015, 00:26','Thu, 17 Dec 2015, 00:26','Your post goes here...'),(52,'New Post',NULL,'Sat, 26 Dec 2015, 17:17','Sat, 26 Dec 2015, 17:17','Your post goes here...'),(53,'New Post',NULL,'Tue, 5 Jan 2016, 08:10','Tue, 5 Jan 2016, 08:10','Your post goes here...'),(54,'New Post',NULL,'Thu, 14 Jan 2016, 02:43','Thu, 14 Jan 2016, 02:43','Your post goes here...'),(55,'New Post',NULL,'Wed, 10 Feb 2016, 08:40','Wed, 10 Feb 2016, 08:40','Your post goes here...'),(56,'New Post',NULL,'Fri, 19 Feb 2016, 11:49','Fri, 19 Feb 2016, 11:49','Your post goes here...'),(57,'New Post',NULL,'Fri, 11 Mar 2016, 02:01','Fri, 11 Mar 2016, 02:01','Your post goes here...');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_to_tags`
--

DROP TABLE IF EXISTS `posts_to_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_to_tags` (
  `post_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_to_tags`
--

LOCK TABLES `posts_to_tags` WRITE;
/*!40000 ALTER TABLE `posts_to_tags` DISABLE KEYS */;
INSERT INTO `posts_to_tags` VALUES (17,2),(17,5),(16,4),(16,11),(19,2),(25,17),(25,13),(25,6),(25,20),(26,4),(26,19),(26,2),(1,7),(25,5),(25,7),(25,11),(4,4),(25,10),(25,23),(14,3),(14,6),(14,11),(27,4),(1,5),(1,24),(29,2),(29,4),(1,25),(1,26),(1,27),(1,28),(30,6),(30,11),(30,5),(30,14),(31,2),(31,3),(31,4),(14,7),(25,2),(25,3),(17,6),(17,10),(17,0),(17,0),(17,12),(17,15),(17,13),(12,5),(12,6),(12,2),(34,2),(34,29),(35,11),(35,3),(35,4),(35,25),(36,31),(38,32),(14,5),(34,11),(16,3),(40,33),(40,34),(40,35),(41,33),(41,34),(41,35),(41,36),(41,37),(42,33),(42,36),(42,37),(42,34),(43,38),(43,39),(43,40),(43,41),(43,34),(43,33),(43,42),(44,43),(44,38),(44,39),(44,40),(44,44),(44,36),(44,33),(44,34),(45,40),(45,45),(45,39),(46,46),(46,47),(46,48),(46,33),(46,49),(46,34),(46,37),(46,39),(46,45),(47,45),(47,50),(47,51),(47,34),(47,52),(47,39),(47,46),(48,34),(48,37),(48,53),(48,52),(48,39),(48,45),(48,40);
/*!40000 ALTER TABLE `posts_to_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (2,'tech'),(3,'professional'),(4,'personal'),(5,'pets'),(6,'memes'),(7,'recipes'),(10,'new_tag'),(11,'lana'),(12,'ghost'),(13,'rue'),(14,'ash'),(15,'blue'),(16,'austin'),(17,'apple'),(18,'newer'),(19,'newest'),(20,'own'),(21,'owner'),(22,'met'),(23,'blankets'),(24,'lauren'),(25,'table'),(26,'chair'),(27,'monkey'),(28,'bonobo'),(29,'blog'),(30,'p'),(31,'yeast'),(32,'new_tag'),(33,'html'),(34,'developer'),(35,'getting started'),(36,'css'),(37,'forms'),(38,'javascript'),(39,'web app'),(40,'front end'),(41,'dropdown'),(42,'dom'),(43,'jquery'),(44,'css selectors'),(45,'back end'),(46,'php'),(47,'http request'),(48,'get vs post'),(49,'template language'),(50,'amazon web services'),(51,'ec2'),(52,'servers'),(53,'ajax');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_logins`
--

DROP TABLE IF EXISTS `user_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_logins` (
  `username` text,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_logins`
--

LOCK TABLES `user_logins` WRITE;
/*!40000 ALTER TABLE `user_logins` DISABLE KEYS */;
INSERT INTO `user_logins` VALUES ('jkrusinski','password'),('uber','driver'),('newest','user'),('lana','krusinski'),('ghost','krusinski'),('user123','developer');
/*!40000 ALTER TABLE `user_logins` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-14 23:21:20
