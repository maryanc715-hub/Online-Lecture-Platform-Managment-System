-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: lecture_platform
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 03:16:56','2026-08-04 03:16:56'),(2,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 03:16:56','2026-08-04 03:16:56'),(3,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-04 03:34:02','2026-08-04 03:34:02'),(4,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-04 03:34:02','2026-08-04 03:34:02'),(5,1,'logout',NULL,NULL,'User logged out','127.0.0.1','2026-08-04 03:48:46','2026-08-04 03:48:46'),(6,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 03:50:30','2026-08-04 03:50:30'),(7,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 03:50:30','2026-08-04 03:50:30'),(8,1,'login',NULL,NULL,'User logged in','::1','2026-08-04 03:52:52','2026-08-04 03:52:52'),(9,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 03:52:52','2026-08-04 03:52:52'),(10,2,'logout',NULL,NULL,'User logged out','::1','2026-08-04 04:18:30','2026-08-04 04:18:30'),(11,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 04:18:57','2026-08-04 04:18:57'),(12,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 04:18:57','2026-08-04 04:18:57'),(13,2,'logout',NULL,NULL,'User logged out','::1','2026-08-04 04:19:19','2026-08-04 04:19:19'),(14,1,'login',NULL,NULL,'User logged in','::1','2026-08-04 04:20:33','2026-08-04 04:20:33'),(15,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 04:20:33','2026-08-04 04:20:33'),(16,1,'user.updated','App\\Models\\User',2,'Updated user Maryan Isse','::1','2026-08-04 04:21:17','2026-08-04 04:21:17'),(17,1,'PUT admin/users/2',NULL,NULL,'User performed an action on admin/users/2','::1','2026-08-04 04:21:17','2026-08-04 04:21:17'),(18,1,'user.created','App\\Models\\User',3,'Created user SudaisSD','::1','2026-08-04 04:31:24','2026-08-04 04:31:24'),(19,1,'POST admin/users',NULL,NULL,'User performed an action on admin/users','::1','2026-08-04 04:31:24','2026-08-04 04:31:24'),(20,1,'logout',NULL,NULL,'User logged out','::1','2026-08-04 04:39:35','2026-08-04 04:39:35'),(21,3,'login',NULL,NULL,'User logged in','::1','2026-08-04 04:39:58','2026-08-04 04:39:58'),(22,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 04:39:58','2026-08-04 04:39:58'),(23,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-04 05:01:27','2026-08-04 05:01:27'),(24,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-04 05:01:27','2026-08-04 05:01:27'),(25,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-04 05:02:18','2026-08-04 05:02:18'),(26,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-04 05:02:18','2026-08-04 05:02:18'),(27,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-04 05:02:45','2026-08-04 05:02:45'),(28,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-04 05:02:45','2026-08-04 05:02:45'),(29,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-04 05:02:58','2026-08-04 05:02:58'),(30,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-04 05:02:58','2026-08-04 05:02:58'),(31,1,'user.updated','App\\Models\\User',6,'Updated user Abdirahman Omar','::1','2026-08-04 05:03:19','2026-08-04 05:03:19'),(32,1,'PUT admin/users/6',NULL,NULL,'User performed an action on admin/users/6','::1','2026-08-04 05:03:19','2026-08-04 05:03:19'),(33,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-04 05:03:39','2026-08-04 05:03:39'),(34,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-04 05:03:39','2026-08-04 05:03:39'),(35,1,'user.deleted',NULL,NULL,'Deleted user Temp Instructor','::1','2026-08-04 05:03:42','2026-08-04 05:03:42'),(36,1,'DELETE admin/users/8',NULL,NULL,'User performed an action on admin/users/8','::1','2026-08-04 05:03:42','2026-08-04 05:03:42'),(37,1,'course_category.created','App\\Models\\CourseCategory',6,'Created category Computer Science','::1','2026-08-04 05:34:41','2026-08-04 05:34:41'),(38,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:34:41','2026-08-04 05:34:41'),(39,1,'course_category.created','App\\Models\\CourseCategory',7,'Created category Information Technology','::1','2026-08-04 05:35:09','2026-08-04 05:35:09'),(40,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:35:09','2026-08-04 05:35:09'),(41,1,'course_category.created','App\\Models\\CourseCategory',8,'Created category Business Administration','::1','2026-08-04 05:39:49','2026-08-04 05:39:49'),(42,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:39:49','2026-08-04 05:39:49'),(43,1,'course_category.created','App\\Models\\CourseCategory',9,'Created category Health Sciences','::1','2026-08-04 05:40:07','2026-08-04 05:40:07'),(44,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:40:07','2026-08-04 05:40:07'),(45,1,'course_category.created','App\\Models\\CourseCategory',10,'Created category Engineering','::1','2026-08-04 05:40:29','2026-08-04 05:40:29'),(46,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:40:29','2026-08-04 05:40:29'),(47,1,'course_category.created','App\\Models\\CourseCategory',11,'Created category Islamic Studies','::1','2026-08-04 05:40:51','2026-08-04 05:40:51'),(48,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:40:51','2026-08-04 05:40:51'),(49,1,'course.created','App\\Models\\Course',7,'Created course Introduction to Computer Science','::1','2026-08-04 05:44:18','2026-08-04 05:44:18'),(50,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:44:18','2026-08-04 05:44:18'),(51,1,'course.created','App\\Models\\Course',8,'Created course Programming Fundamentals','::1','2026-08-04 05:44:53','2026-08-04 05:44:53'),(52,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:44:53','2026-08-04 05:44:53'),(53,1,'course.created','App\\Models\\Course',9,'Created course Programming Fundamentals','::1','2026-08-04 05:44:53','2026-08-04 05:44:53'),(54,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:44:53','2026-08-04 05:44:53'),(55,1,'course.deleted',NULL,NULL,'Deleted course Programming Fundamentals','::1','2026-08-04 05:45:03','2026-08-04 05:45:03'),(56,1,'DELETE admin/courses/9',NULL,NULL,'User performed an action on admin/courses/9','::1','2026-08-04 05:45:03','2026-08-04 05:45:03'),(57,1,'course.created','App\\Models\\Course',10,'Created course Computer Networks','::1','2026-08-04 05:46:15','2026-08-04 05:46:15'),(58,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:46:15','2026-08-04 05:46:15'),(59,1,'course.created','App\\Models\\Course',11,'Created course Cyber Security Fundamentals','::1','2026-08-04 05:46:50','2026-08-04 05:46:50'),(60,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:46:50','2026-08-04 05:46:50'),(61,1,'course.created','App\\Models\\Course',12,'Created course Marketing Fundamentals','::1','2026-08-04 05:47:48','2026-08-04 05:47:48'),(62,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:47:48','2026-08-04 05:47:48'),(63,1,'course_category.created','App\\Models\\CourseCategory',12,'Created category Accounting & Finance','::1','2026-08-04 05:48:22','2026-08-04 05:48:22'),(64,1,'POST admin/course-categories',NULL,NULL,'User performed an action on admin/course-categories','::1','2026-08-04 05:48:22','2026-08-04 05:48:22'),(65,1,'course.created','App\\Models\\Course',13,'Created course Financial Accounting','::1','2026-08-04 05:49:20','2026-08-04 05:49:20'),(66,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:49:20','2026-08-04 05:49:20'),(67,1,'course.created','App\\Models\\Course',14,'Created course Human Anatomy','::1','2026-08-04 05:49:58','2026-08-04 05:49:58'),(68,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:49:58','2026-08-04 05:49:58'),(69,1,'course.created','App\\Models\\Course',15,'Created course Civil Engineering Fundamentals','::1','2026-08-04 05:50:51','2026-08-04 05:50:51'),(70,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:50:51','2026-08-04 05:50:51'),(71,1,'course.created','App\\Models\\Course',16,'Created course Quranic Studies','::1','2026-08-04 05:51:58','2026-08-04 05:51:58'),(72,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-04 05:51:58','2026-08-04 05:51:58'),(73,2,'POST student/support-tickets',NULL,NULL,'User performed an action on student/support-tickets','::1','2026-08-04 05:57:25','2026-08-04 05:57:25'),(74,1,'POST admin/reports/generate',NULL,NULL,'User performed an action on admin/reports/generate','::1','2026-08-04 05:58:57','2026-08-04 05:58:57'),(75,1,'POST admin/reports/generate',NULL,NULL,'User performed an action on admin/reports/generate','::1','2026-08-04 05:58:57','2026-08-04 05:58:57'),(76,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 12:19:37','2026-08-04 12:19:37'),(77,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 12:19:38','2026-08-04 12:19:38'),(78,2,'logout',NULL,NULL,'User logged out','::1','2026-08-04 12:19:44','2026-08-04 12:19:44'),(79,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 12:41:12','2026-08-04 12:41:12'),(80,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 12:41:12','2026-08-04 12:41:12'),(81,2,'logout',NULL,NULL,'User logged out','::1','2026-08-04 12:42:22','2026-08-04 12:42:22'),(82,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 12:42:31','2026-08-04 12:42:31'),(83,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 12:42:31','2026-08-04 12:42:31'),(84,2,'logout',NULL,NULL,'User logged out','::1','2026-08-04 12:42:44','2026-08-04 12:42:44'),(85,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 12:49:23','2026-08-04 12:49:23'),(86,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 12:49:23','2026-08-04 12:49:23'),(87,2,'logout',NULL,NULL,'User logged out','::1','2026-08-04 12:49:50','2026-08-04 12:49:50'),(88,2,'login',NULL,NULL,'User logged in','::1','2026-08-04 13:24:36','2026-08-04 13:24:36'),(89,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-04 13:24:36','2026-08-04 13:24:36'),(90,2,'login',NULL,NULL,'User logged in','::1','2026-08-05 02:05:28','2026-08-05 02:05:28'),(91,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 02:05:28','2026-08-05 02:05:28'),(92,3,'login',NULL,NULL,'User logged in','::1','2026-08-05 02:22:46','2026-08-05 02:22:46'),(93,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 02:22:46','2026-08-05 02:22:46'),(104,1,'login',NULL,NULL,'User logged in','127.0.0.1','2026-08-05 02:24:53','2026-08-05 02:24:53'),(105,1,'POST login',NULL,NULL,'User performed an action on login','127.0.0.1','2026-08-05 02:24:53','2026-08-05 02:24:53'),(106,1,'logout',NULL,NULL,'User logged out','127.0.0.1','2026-08-05 02:24:53','2026-08-05 02:24:53'),(107,1,'login',NULL,NULL,'User logged in','::1','2026-08-05 02:31:08','2026-08-05 02:31:08'),(108,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 02:31:08','2026-08-05 02:31:08'),(117,1,'logout',NULL,NULL,'User logged out','::1','2026-08-05 02:40:12','2026-08-05 02:40:12'),(118,3,'login',NULL,NULL,'User logged in','::1','2026-08-05 02:40:18','2026-08-05 02:40:18'),(119,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 02:40:18','2026-08-05 02:40:18'),(120,3,'POST email/verify',NULL,NULL,'User performed an action on email/verify','127.0.0.1','2026-08-05 02:41:29','2026-08-05 02:41:29'),(121,3,'POST email/verify',NULL,NULL,'User performed an action on email/verify','::1','2026-08-05 02:55:45','2026-08-05 02:55:45'),(122,3,'POST support/tickets/5/assign-self',NULL,NULL,'User performed an action on support/tickets/5/assign-self','::1','2026-08-05 02:59:05','2026-08-05 02:59:05'),(123,3,'POST support/tickets/5/status',NULL,NULL,'User performed an action on support/tickets/5/status','::1','2026-08-05 02:59:16','2026-08-05 02:59:16'),(124,3,'POST support/tickets/5/respond',NULL,NULL,'User performed an action on support/tickets/5/respond','::1','2026-08-05 03:00:29','2026-08-05 03:00:29'),(125,3,'logout',NULL,NULL,'User logged out','::1','2026-08-05 03:07:55','2026-08-05 03:07:55'),(126,1,'login',NULL,NULL,'User logged in','::1','2026-08-05 03:08:01','2026-08-05 03:08:01'),(127,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 03:08:01','2026-08-05 03:08:01'),(128,1,'logout',NULL,NULL,'User logged out','::1','2026-08-05 03:23:02','2026-08-05 03:23:02'),(129,1,'login',NULL,NULL,'User logged in','::1','2026-08-05 03:23:06','2026-08-05 03:23:06'),(130,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 03:23:06','2026-08-05 03:23:06'),(131,1,'user.updated','App\\Models\\User',6,'Updated user Abdirahman Omar','::1','2026-08-05 03:26:46','2026-08-05 03:26:46'),(132,1,'PUT admin/users/6',NULL,NULL,'User performed an action on admin/users/6','::1','2026-08-05 03:26:46','2026-08-05 03:26:46'),(133,1,'user.deleted',NULL,NULL,'Deleted user Abdirahman Omar','::1','2026-08-05 03:28:42','2026-08-05 03:28:42'),(134,1,'DELETE admin/users/6',NULL,NULL,'User performed an action on admin/users/6','::1','2026-08-05 03:28:42','2026-08-05 03:28:42'),(135,1,'POST admin/users',NULL,NULL,'User performed an action on admin/users','::1','2026-08-05 03:29:29','2026-08-05 03:29:29'),(136,1,'POST admin/users',NULL,NULL,'User performed an action on admin/users','::1','2026-08-05 03:30:47','2026-08-05 03:30:47'),(137,1,'user.created','App\\Models\\User',10,'Created user Abdirahman Omar','::1','2026-08-05 03:33:18','2026-08-05 03:33:18'),(138,1,'POST admin/users',NULL,NULL,'User performed an action on admin/users','::1','2026-08-05 03:33:18','2026-08-05 03:33:18'),(139,10,'login',NULL,NULL,'User logged in','::1','2026-08-05 03:35:27','2026-08-05 03:35:27'),(140,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 03:35:27','2026-08-05 03:35:27'),(141,10,'POST email/verify',NULL,NULL,'User performed an action on email/verify','::1','2026-08-05 03:35:44','2026-08-05 03:35:44'),(142,10,'POST email/verify',NULL,NULL,'User performed an action on email/verify','::1','2026-08-05 03:38:02','2026-08-05 03:38:02'),(143,1,'course.updated','App\\Models\\Course',16,'Updated course Quranic Studies','::1','2026-08-05 03:38:54','2026-08-05 03:38:54'),(144,1,'course.updated','App\\Models\\Course',16,'Updated course Quranic Studies','::1','2026-08-05 03:38:54','2026-08-05 03:38:54'),(145,1,'PUT admin/courses/16',NULL,NULL,'User performed an action on admin/courses/16','::1','2026-08-05 03:38:54','2026-08-05 03:38:54'),(146,1,'PUT admin/courses/16',NULL,NULL,'User performed an action on admin/courses/16','::1','2026-08-05 03:38:54','2026-08-05 03:38:54'),(147,1,'course.updated','App\\Models\\Course',15,'Updated course Civil Engineering Fundamentals','::1','2026-08-05 03:39:03','2026-08-05 03:39:03'),(148,1,'PUT admin/courses/15',NULL,NULL,'User performed an action on admin/courses/15','::1','2026-08-05 03:39:03','2026-08-05 03:39:03'),(149,1,'course.updated','App\\Models\\Course',7,'Updated course Introduction to Computer Science','::1','2026-08-05 03:39:15','2026-08-05 03:39:15'),(150,1,'PUT admin/courses/7',NULL,NULL,'User performed an action on admin/courses/7','::1','2026-08-05 03:39:15','2026-08-05 03:39:15'),(151,1,'course.updated','App\\Models\\Course',11,'Updated course Cyber Security Fundamentals','::1','2026-08-05 03:39:34','2026-08-05 03:39:34'),(152,1,'PUT admin/courses/11',NULL,NULL,'User performed an action on admin/courses/11','::1','2026-08-05 03:39:34','2026-08-05 03:39:34'),(153,1,'course.updated','App\\Models\\Course',13,'Updated course Financial Accounting','::1','2026-08-05 03:39:43','2026-08-05 03:39:43'),(154,1,'PUT admin/courses/13',NULL,NULL,'User performed an action on admin/courses/13','::1','2026-08-05 03:39:43','2026-08-05 03:39:43'),(155,1,'course.updated','App\\Models\\Course',8,'Updated course Programming Fundamentals','::1','2026-08-05 03:39:53','2026-08-05 03:39:53'),(156,1,'PUT admin/courses/8',NULL,NULL,'User performed an action on admin/courses/8','::1','2026-08-05 03:39:53','2026-08-05 03:39:53'),(157,1,'course.updated','App\\Models\\Course',14,'Updated course Human Anatomy','::1','2026-08-05 03:40:01','2026-08-05 03:40:01'),(158,1,'PUT admin/courses/14',NULL,NULL,'User performed an action on admin/courses/14','::1','2026-08-05 03:40:01','2026-08-05 03:40:01'),(159,1,'course.updated','App\\Models\\Course',12,'Updated course Marketing Fundamentals','::1','2026-08-05 03:40:09','2026-08-05 03:40:09'),(160,1,'PUT admin/courses/12',NULL,NULL,'User performed an action on admin/courses/12','::1','2026-08-05 03:40:09','2026-08-05 03:40:09'),(161,1,'course.updated','App\\Models\\Course',10,'Updated course Computer Networks','::1','2026-08-05 03:40:17','2026-08-05 03:40:17'),(162,1,'PUT admin/courses/10',NULL,NULL,'User performed an action on admin/courses/10','::1','2026-08-05 03:40:17','2026-08-05 03:40:17'),(163,10,'POST email/verify',NULL,NULL,'User performed an action on email/verify','::1','2026-08-05 03:40:45','2026-08-05 03:40:45'),(164,NULL,'register','App\\Models\\User',11,'New student account created (pending approval)','127.0.0.1','2026-08-05 03:48:01','2026-08-05 03:48:01'),(165,NULL,'POST register',NULL,NULL,'User performed an action on register','127.0.0.1','2026-08-05 03:48:01','2026-08-05 03:48:01'),(166,NULL,'user.approved','App\\Models\\User',13,'Approved user Pending Student','127.0.0.1','2026-08-05 03:48:01','2026-08-05 03:48:01'),(167,NULL,'POST admin/users/13/approve',NULL,NULL,'User performed an action on admin/users/13/approve','127.0.0.1','2026-08-05 03:48:01','2026-08-05 03:48:01'),(168,NULL,'register','App\\Models\\User',17,'New student account created (pending approval)','127.0.0.1','2026-08-05 03:48:45','2026-08-05 03:48:45'),(169,NULL,'POST register',NULL,NULL,'User performed an action on register','127.0.0.1','2026-08-05 03:48:45','2026-08-05 03:48:45'),(170,NULL,'user.approved','App\\Models\\User',19,'Approved user Pending Student','127.0.0.1','2026-08-05 03:48:46','2026-08-05 03:48:46'),(171,NULL,'POST admin/users/19/approve',NULL,NULL,'User performed an action on admin/users/19/approve','127.0.0.1','2026-08-05 03:48:46','2026-08-05 03:48:46'),(172,1,'user.approved','App\\Models\\User',11,'Approved user New Student','::1','2026-08-05 03:50:39','2026-08-05 03:50:39'),(173,1,'POST admin/users/11/approve',NULL,NULL,'User performed an action on admin/users/11/approve','::1','2026-08-05 03:50:39','2026-08-05 03:50:39'),(174,1,'user.updated','App\\Models\\User',1,'Updated user System Administrator','::1','2026-08-05 03:52:11','2026-08-05 03:52:11'),(175,1,'PUT admin/users/1',NULL,NULL,'User performed an action on admin/users/1','::1','2026-08-05 03:52:11','2026-08-05 03:52:11'),(176,10,'lecture.created','App\\Models\\LectureMaterial',4,'Created lecture material: Intro to Computer Networking!','::1','2026-08-05 04:00:20','2026-08-05 04:00:20'),(177,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-05 04:00:20','2026-08-05 04:00:20'),(178,2,'enrollment.created','App\\Models\\Course',7,'Student Maryan Isse enrolled in Introduction to Computer Science','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(179,2,'POST student/courses/7/enroll',NULL,NULL,'User performed an action on student/courses/7/enroll','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(180,2,'enrollment.created','App\\Models\\Course',7,'Student Maryan Isse enrolled in Introduction to Computer Science','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(181,2,'POST student/courses/7/enroll',NULL,NULL,'User performed an action on student/courses/7/enroll','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(182,2,'enrollment.deleted','App\\Models\\Course',7,'Student Maryan Isse left Introduction to Computer Science','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(183,2,'POST student/courses/7/unenroll',NULL,NULL,'User performed an action on student/courses/7/unenroll','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(184,2,'POST student/courses/10/enroll',NULL,NULL,'User performed an action on student/courses/10/enroll','127.0.0.1','2026-08-05 04:04:45','2026-08-05 04:04:45'),(185,10,'assignment.created','App\\Models\\Assignment',5,'Created assignment: Network Topology Design and IP Addressing Assignment','::1','2026-08-05 04:07:18','2026-08-05 04:07:18'),(186,10,'POST instructor/assignments',NULL,NULL,'User performed an action on instructor/assignments','::1','2026-08-05 04:07:18','2026-08-05 04:07:18'),(187,1,'course.updated','App\\Models\\Course',10,'Updated course Computer Networking','::1','2026-08-05 04:07:41','2026-08-05 04:07:41'),(188,1,'PUT admin/courses/10',NULL,NULL,'User performed an action on admin/courses/10','::1','2026-08-05 04:07:41','2026-08-05 04:07:41'),(189,2,'enrollment.created','App\\Models\\Course',10,'Student Maryan Isse enrolled in Computer Networking','::1','2026-08-05 04:50:49','2026-08-05 04:50:49'),(190,2,'POST student/courses/10/enroll',NULL,NULL,'User performed an action on student/courses/10/enroll','::1','2026-08-05 04:50:49','2026-08-05 04:50:49'),(191,1,'course.updated','App\\Models\\Course',10,'Updated course Computer Networking','::1','2026-08-05 04:54:52','2026-08-05 04:54:52'),(192,1,'PUT admin/courses/10',NULL,NULL,'User performed an action on admin/courses/10','::1','2026-08-05 04:54:52','2026-08-05 04:54:52'),(193,1,'course.updated','App\\Models\\Course',16,'Updated course Quranic Studies','::1','2026-08-05 05:28:19','2026-08-05 05:28:19'),(194,1,'PUT admin/courses/16',NULL,NULL,'User performed an action on admin/courses/16','::1','2026-08-05 05:28:19','2026-08-05 05:28:19'),(195,1,'course.updated','App\\Models\\Course',15,'Updated course Civil Engineering Fundamentals','::1','2026-08-05 05:28:46','2026-08-05 05:28:46'),(196,1,'PUT admin/courses/15',NULL,NULL,'User performed an action on admin/courses/15','::1','2026-08-05 05:28:46','2026-08-05 05:28:46'),(197,1,'PUT admin/courses/14',NULL,NULL,'User performed an action on admin/courses/14','::1','2026-08-05 05:29:05','2026-08-05 05:29:05'),(198,1,'course.updated','App\\Models\\Course',13,'Updated course Financial Accounting','::1','2026-08-05 05:29:31','2026-08-05 05:29:31'),(199,1,'PUT admin/courses/13',NULL,NULL,'User performed an action on admin/courses/13','::1','2026-08-05 05:29:31','2026-08-05 05:29:31'),(200,1,'course.updated','App\\Models\\Course',13,'Updated course Financial Accounting','::1','2026-08-05 05:29:31','2026-08-05 05:29:31'),(201,1,'PUT admin/courses/13',NULL,NULL,'User performed an action on admin/courses/13','::1','2026-08-05 05:29:31','2026-08-05 05:29:31'),(202,1,'course.updated','App\\Models\\Course',12,'Updated course Marketing Fundamentals','::1','2026-08-05 05:29:48','2026-08-05 05:29:48'),(203,1,'PUT admin/courses/12',NULL,NULL,'User performed an action on admin/courses/12','::1','2026-08-05 05:29:48','2026-08-05 05:29:48'),(204,1,'course.updated','App\\Models\\Course',11,'Updated course Cyber Security Fundamentals','::1','2026-08-05 05:30:15','2026-08-05 05:30:15'),(205,1,'PUT admin/courses/11',NULL,NULL,'User performed an action on admin/courses/11','::1','2026-08-05 05:30:15','2026-08-05 05:30:15'),(206,1,'course.updated','App\\Models\\Course',8,'Updated course Programming Fundamentals','::1','2026-08-05 05:30:32','2026-08-05 05:30:32'),(207,1,'PUT admin/courses/8',NULL,NULL,'User performed an action on admin/courses/8','::1','2026-08-05 05:30:32','2026-08-05 05:30:32'),(208,1,'course.updated','App\\Models\\Course',7,'Updated course Introduction to Computer Science','::1','2026-08-05 05:30:46','2026-08-05 05:30:46'),(209,1,'PUT admin/courses/7',NULL,NULL,'User performed an action on admin/courses/7','::1','2026-08-05 05:30:46','2026-08-05 05:30:46'),(210,1,'course.updated','App\\Models\\Course',14,'Updated course Human Anatomy','::1','2026-08-05 05:32:00','2026-08-05 05:32:00'),(211,1,'PUT admin/courses/14',NULL,NULL,'User performed an action on admin/courses/14','::1','2026-08-05 05:32:00','2026-08-05 05:32:00'),(212,10,'lecture.updated','App\\Models\\LectureMaterial',4,'Updated lecture material: Intro to Computer Networking!','::1','2026-08-05 05:41:15','2026-08-05 05:41:15'),(213,10,'PUT instructor/lectures/4',NULL,NULL,'User performed an action on instructor/lectures/4','::1','2026-08-05 05:41:15','2026-08-05 05:41:15'),(214,10,'lecture.updated','App\\Models\\LectureMaterial',4,'Updated lecture material: Intro to Computer Networking!','::1','2026-08-05 05:42:39','2026-08-05 05:42:39'),(215,10,'PUT instructor/lectures/4',NULL,NULL,'User performed an action on instructor/lectures/4','::1','2026-08-05 05:42:39','2026-08-05 05:42:39'),(216,1,'backup.run',NULL,NULL,'Manual database backup triggered','::1','2026-08-05 05:48:09','2026-08-05 05:48:09'),(217,1,'POST admin/backup/run',NULL,NULL,'User performed an action on admin/backup/run','::1','2026-08-05 05:48:09','2026-08-05 05:48:09'),(218,1,'announcement.created','App\\Models\\Announcement',4,'Created announcement Upcoming Computer Networking Practical Lab','::1','2026-08-05 05:53:35','2026-08-05 05:53:35'),(219,1,'POST admin/announcements',NULL,NULL,'User performed an action on admin/announcements','::1','2026-08-05 05:53:35','2026-08-05 05:53:35'),(220,2,'enrollment.created','App\\Models\\Course',12,'Student Maryan Isse enrolled in Marketing Fundamentals','::1','2026-08-05 05:54:49','2026-08-05 05:54:49'),(221,2,'POST student/courses/12/enroll',NULL,NULL,'User performed an action on student/courses/12/enroll','::1','2026-08-05 05:54:49','2026-08-05 05:54:49'),(222,2,'logout',NULL,NULL,'User logged out','::1','2026-08-05 06:12:41','2026-08-05 06:12:41'),(223,10,'login',NULL,NULL,'User logged in','::1','2026-08-05 06:12:53','2026-08-05 06:12:53'),(224,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 06:12:53','2026-08-05 06:12:53'),(225,10,'logout',NULL,NULL,'User logged out','::1','2026-08-05 06:13:03','2026-08-05 06:13:03'),(226,1,'login',NULL,NULL,'User logged in','::1','2026-08-05 06:34:23','2026-08-05 06:34:23'),(227,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-05 06:34:23','2026-08-05 06:34:23'),(228,3,'login',NULL,NULL,'User logged in','::1','2026-08-06 02:33:04','2026-08-06 02:33:04'),(229,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-06 02:33:04','2026-08-06 02:33:04'),(230,3,'logout',NULL,NULL,'User logged out','::1','2026-08-06 02:33:22','2026-08-06 02:33:22'),(231,2,'login',NULL,NULL,'User logged in','::1','2026-08-06 02:33:28','2026-08-06 02:33:28'),(232,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-06 02:33:28','2026-08-06 02:33:28'),(233,1,'login',NULL,NULL,'User logged in','::1','2026-08-06 02:49:44','2026-08-06 02:49:44'),(234,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-06 02:49:44','2026-08-06 02:49:44'),(235,10,'login',NULL,NULL,'User logged in','::1','2026-08-06 02:50:59','2026-08-06 02:50:59'),(236,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-06 02:50:59','2026-08-06 02:50:59'),(237,10,'lecture.updated','App\\Models\\LectureMaterial',4,'Updated lecture material: Introduction to Computer Networks','::1','2026-08-06 02:54:41','2026-08-06 02:54:41'),(238,10,'PUT instructor/lectures/4',NULL,NULL,'User performed an action on instructor/lectures/4','::1','2026-08-06 02:54:41','2026-08-06 02:54:41'),(239,10,'lecture.created','App\\Models\\LectureMaterial',5,'Created lecture material: Computer Networks - Basic Characteristics','::1','2026-08-06 02:56:07','2026-08-06 02:56:07'),(240,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 02:56:07','2026-08-06 02:56:07'),(241,10,'lecture.created','App\\Models\\LectureMaterial',6,'Created lecture material: Network Protocols & Communications (Part 1)','::1','2026-08-06 02:57:08','2026-08-06 02:57:08'),(242,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 02:57:08','2026-08-06 02:57:08'),(243,2,'lesson.completed','App\\Models\\LectureMaterial',4,'Student Maryan Isse completed lesson Introduction to Computer Networks','127.0.0.1','2026-08-06 03:08:54','2026-08-06 03:08:54'),(244,2,'lesson.completed','App\\Models\\LectureMaterial',5,'Student Maryan Isse completed lesson Computer Networks - Basic Characteristics','127.0.0.1','2026-08-06 03:08:54','2026-08-06 03:08:54'),(245,2,'lesson.completed','App\\Models\\LectureMaterial',6,'Student Maryan Isse completed lesson Network Protocols & Communications (Part 1)','127.0.0.1','2026-08-06 03:08:54','2026-08-06 03:08:54'),(246,2,'lesson.uncompleted','App\\Models\\LectureMaterial',4,'Student Maryan Isse marked lesson Introduction to Computer Networks as incomplete','127.0.0.1','2026-08-06 03:09:00','2026-08-06 03:09:00'),(247,2,'lesson.completed','App\\Models\\LectureMaterial',4,'Student Maryan Isse completed lesson Introduction to Computer Networks','127.0.0.1','2026-08-06 03:09:00','2026-08-06 03:09:00'),(248,2,'lesson.uncompleted','App\\Models\\LectureMaterial',6,'Student Maryan Isse marked lesson Network Protocols & Communications (Part 1) as incomplete','::1','2026-08-06 03:12:07','2026-08-06 03:12:07'),(249,2,'DELETE student/lectures/6/complete',NULL,NULL,'User performed an action on student/lectures/6/complete','::1','2026-08-06 03:12:07','2026-08-06 03:12:07'),(250,2,'lesson.uncompleted','App\\Models\\LectureMaterial',4,'Student Maryan Isse marked lesson Introduction to Computer Networks as incomplete','::1','2026-08-06 03:12:28','2026-08-06 03:12:28'),(251,2,'DELETE student/lectures/4/complete',NULL,NULL,'User performed an action on student/lectures/4/complete','::1','2026-08-06 03:12:28','2026-08-06 03:12:28'),(252,2,'lesson.uncompleted','App\\Models\\LectureMaterial',5,'Student Maryan Isse marked lesson Computer Networks - Basic Characteristics as incomplete','::1','2026-08-06 03:12:30','2026-08-06 03:12:30'),(253,2,'DELETE student/lectures/5/complete',NULL,NULL,'User performed an action on student/lectures/5/complete','::1','2026-08-06 03:12:30','2026-08-06 03:12:30'),(254,10,'lecture.updated','App\\Models\\LectureMaterial',4,'Updated lecture material: Intro to Computer Networking!','::1','2026-08-06 03:27:32','2026-08-06 03:27:32'),(255,10,'PUT instructor/lectures/4',NULL,NULL,'User performed an action on instructor/lectures/4','::1','2026-08-06 03:27:32','2026-08-06 03:27:32'),(256,10,'lecture.deleted',NULL,NULL,'Deleted lecture material: Computer Networks - Basic Characteristics','::1','2026-08-06 03:28:07','2026-08-06 03:28:07'),(257,10,'DELETE instructor/lectures/5',NULL,NULL,'User performed an action on instructor/lectures/5','::1','2026-08-06 03:28:07','2026-08-06 03:28:07'),(258,10,'lecture.deleted',NULL,NULL,'Deleted lecture material: Network Protocols & Communications (Part 1)','::1','2026-08-06 03:28:11','2026-08-06 03:28:11'),(259,10,'DELETE instructor/lectures/6',NULL,NULL,'User performed an action on instructor/lectures/6','::1','2026-08-06 03:28:11','2026-08-06 03:28:11'),(260,10,'lecture.created','App\\Models\\LectureMaterial',7,'Created lecture material: Basic Networking Functionality Explained','::1','2026-08-06 03:28:55','2026-08-06 03:28:55'),(261,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 03:28:55','2026-08-06 03:28:55'),(262,10,'lecture.created','App\\Models\\LectureMaterial',8,'Created lecture material: Network Ports Explained 🔌 TCP, UDP, Ranges & Scanning','::1','2026-08-06 03:30:01','2026-08-06 03:30:01'),(263,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 03:30:01','2026-08-06 03:30:01'),(264,10,'module.updated','App\\Models\\LectureModule',2,'Updated module Network Ports','::1','2026-08-06 03:31:32','2026-08-06 03:31:32'),(265,10,'PUT instructor/modules/2',NULL,NULL,'User performed an action on instructor/modules/2','::1','2026-08-06 03:31:32','2026-08-06 03:31:32'),(266,10,'lecture.deleted',NULL,NULL,'Deleted lecture material: Network Ports Explained 🔌 TCP, UDP, Ranges & Scanning','::1','2026-08-06 03:54:28','2026-08-06 03:54:28'),(267,10,'DELETE instructor/lectures/8',NULL,NULL,'User performed an action on instructor/lectures/8','::1','2026-08-06 03:54:28','2026-08-06 03:54:28'),(268,10,'lecture.deleted',NULL,NULL,'Deleted lecture material: Basic Networking Functionality Explained','::1','2026-08-06 03:54:31','2026-08-06 03:54:31'),(269,10,'DELETE instructor/lectures/7',NULL,NULL,'User performed an action on instructor/lectures/7','::1','2026-08-06 03:54:31','2026-08-06 03:54:31'),(270,10,'lecture.created','App\\Models\\LectureMaterial',9,'Created lecture material: Basic Networking Functionality Explained','::1','2026-08-06 03:59:07','2026-08-06 03:59:07'),(271,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 03:59:07','2026-08-06 03:59:07'),(272,10,'lecture.created','App\\Models\\LectureMaterial',10,'Created lecture material: Network Ports Explained 🔌 TCP, UDP, Ranges & Scanning','::1','2026-08-06 03:59:53','2026-08-06 03:59:53'),(273,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 03:59:53','2026-08-06 03:59:53'),(274,2,'lesson.completed','App\\Models\\LectureMaterial',4,'Student Maryan Isse completed lesson Intro to Computer Networking!','::1','2026-08-06 04:01:18','2026-08-06 04:01:18'),(275,2,'POST student/lectures/4/complete',NULL,NULL,'User performed an action on student/lectures/4/complete','::1','2026-08-06 04:01:18','2026-08-06 04:01:18'),(276,1,'course.created','App\\Models\\Course',18,'Created course Computer Networking Fundamentals','::1','2026-08-06 04:03:21','2026-08-06 04:03:21'),(277,1,'POST admin/courses',NULL,NULL,'User performed an action on admin/courses','::1','2026-08-06 04:03:21','2026-08-06 04:03:21'),(278,1,'course.updated','App\\Models\\Course',18,'Updated course Computer Networking Fundamentals','::1','2026-08-06 04:04:31','2026-08-06 04:04:31'),(279,1,'PUT admin/courses/18',NULL,NULL,'User performed an action on admin/courses/18','::1','2026-08-06 04:04:31','2026-08-06 04:04:31'),(280,10,'module.created','App\\Models\\LectureModule',3,'Created module Module 1: Introduction to Computer Networks','::1','2026-08-06 04:07:10','2026-08-06 04:07:10'),(281,10,'POST instructor/modules',NULL,NULL,'User performed an action on instructor/modules','::1','2026-08-06 04:07:10','2026-08-06 04:07:10'),(282,10,'lecture.created','App\\Models\\LectureMaterial',11,'Created lecture material: Lesson 1: What is Computer Networking?','::1','2026-08-06 04:09:07','2026-08-06 04:09:07'),(283,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:09:07','2026-08-06 04:09:07'),(284,2,'enrollment.created','App\\Models\\Course',18,'Student Maryan Isse enrolled in Computer Networking Fundamentals','::1','2026-08-06 04:09:15','2026-08-06 04:09:15'),(285,2,'POST student/courses/18/enroll',NULL,NULL,'User performed an action on student/courses/18/enroll','::1','2026-08-06 04:09:15','2026-08-06 04:09:15'),(286,10,'lecture.updated','App\\Models\\LectureMaterial',11,'Updated lecture material: Lesson 1: What is Computer Networking?','::1','2026-08-06 04:09:41','2026-08-06 04:09:41'),(287,10,'PUT instructor/lectures/11',NULL,NULL,'User performed an action on instructor/lectures/11','::1','2026-08-06 04:09:41','2026-08-06 04:09:41'),(288,10,'lecture.updated','App\\Models\\LectureMaterial',11,'Updated lecture material: Lesson 1: What is Computer Networking?','::1','2026-08-06 04:10:10','2026-08-06 04:10:10'),(289,10,'PUT instructor/lectures/11',NULL,NULL,'User performed an action on instructor/lectures/11','::1','2026-08-06 04:10:10','2026-08-06 04:10:10'),(290,10,'module.updated','App\\Models\\LectureModule',3,'Updated module Module 1: Introduction to Computer Networks','::1','2026-08-06 04:10:24','2026-08-06 04:10:24'),(291,10,'PUT instructor/modules/3',NULL,NULL,'User performed an action on instructor/modules/3','::1','2026-08-06 04:10:24','2026-08-06 04:10:24'),(292,10,'lecture.created','App\\Models\\LectureMaterial',12,'Created lecture material: Lesson 2: Types of Computer Networks (LAN, WAN, MAN)','::1','2026-08-06 04:11:22','2026-08-06 04:11:22'),(293,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:11:22','2026-08-06 04:11:22'),(294,10,'lecture.updated','App\\Models\\LectureMaterial',12,'Updated lecture material: Lesson 2: Types of Computer Networks (LAN, WAN, MAN)','::1','2026-08-06 04:13:25','2026-08-06 04:13:25'),(295,10,'PUT instructor/lectures/12',NULL,NULL,'User performed an action on instructor/lectures/12','::1','2026-08-06 04:13:25','2026-08-06 04:13:25'),(296,10,'lecture.created','App\\Models\\LectureMaterial',13,'Created lecture material: Lesson 3: Network Devices Overview','::1','2026-08-06 04:14:15','2026-08-06 04:14:15'),(297,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:14:15','2026-08-06 04:14:15'),(298,10,'module.created','App\\Models\\LectureModule',4,'Created module Module 2: OSI Model and TCP/IP','::1','2026-08-06 04:14:54','2026-08-06 04:14:54'),(299,10,'POST instructor/modules',NULL,NULL,'User performed an action on instructor/modules','::1','2026-08-06 04:14:54','2026-08-06 04:14:54'),(300,10,'lecture.created','App\\Models\\LectureMaterial',14,'Created lecture material: Lesson 1: OSI Model Explained','::1','2026-08-06 04:16:35','2026-08-06 04:16:35'),(301,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:16:35','2026-08-06 04:16:35'),(302,10,'module.created','App\\Models\\LectureModule',5,'Created module Module 3: IP Addressing and Routing','::1','2026-08-06 04:22:00','2026-08-06 04:22:00'),(303,10,'POST instructor/modules',NULL,NULL,'User performed an action on instructor/modules','::1','2026-08-06 04:22:00','2026-08-06 04:22:00'),(304,10,'module.created','App\\Models\\LectureModule',6,'Created module Module 4: Switching, Security and Practical Networking','::1','2026-08-06 04:22:35','2026-08-06 04:22:35'),(305,10,'POST instructor/modules',NULL,NULL,'User performed an action on instructor/modules','::1','2026-08-06 04:22:35','2026-08-06 04:22:35'),(306,10,'lecture.created','App\\Models\\LectureMaterial',15,'Created lecture material: Lesson 1: IPv4 Addressing Basics','::1','2026-08-06 04:24:02','2026-08-06 04:24:02'),(307,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:24:02','2026-08-06 04:24:02'),(308,10,'lecture.created','App\\Models\\LectureMaterial',16,'Created lecture material: Lesson 2: Subnetting Fundamentals','::1','2026-08-06 04:28:26','2026-08-06 04:28:26'),(309,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:28:26','2026-08-06 04:28:26'),(310,10,'lecture.created','App\\Models\\LectureMaterial',17,'Created lecture material: Lesson 3: Routing Concepts','::1','2026-08-06 04:29:15','2026-08-06 04:29:15'),(311,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:29:15','2026-08-06 04:29:15'),(312,10,'lecture.created','App\\Models\\LectureMaterial',18,'Created lecture material: Lesson 1: Switch Configuration Basics','::1','2026-08-06 04:30:11','2026-08-06 04:30:11'),(313,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:30:11','2026-08-06 04:30:11'),(314,10,'lecture.created','App\\Models\\LectureMaterial',19,'Created lecture material: Lesson 2: Network Security Fundamentals','::1','2026-08-06 04:30:55','2026-08-06 04:30:55'),(315,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:30:55','2026-08-06 04:30:55'),(316,10,'lecture.created','App\\Models\\LectureMaterial',20,'Created lecture material: Lesson 3: Network Troubleshooting','::1','2026-08-06 04:35:42','2026-08-06 04:35:42'),(317,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:35:42','2026-08-06 04:35:42'),(318,10,'lecture.created','App\\Models\\LectureMaterial',21,'Created lecture material: Lesson 4: Final Networking Project','::1','2026-08-06 04:37:07','2026-08-06 04:37:07'),(319,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:37:07','2026-08-06 04:37:07'),(320,10,'lecture.updated','App\\Models\\LectureMaterial',21,'Updated lecture material: Lesson 4: Final Networking Project','::1','2026-08-06 04:38:03','2026-08-06 04:38:03'),(321,10,'PUT instructor/lectures/21',NULL,NULL,'User performed an action on instructor/lectures/21','::1','2026-08-06 04:38:03','2026-08-06 04:38:03'),(322,10,'lecture.created','App\\Models\\LectureMaterial',22,'Created lecture material: Lesson 2: TCP/IP Model','::1','2026-08-06 04:39:47','2026-08-06 04:39:47'),(323,10,'POST instructor/lectures',NULL,NULL,'User performed an action on instructor/lectures','::1','2026-08-06 04:39:47','2026-08-06 04:39:47'),(324,10,'lecture.updated','App\\Models\\LectureMaterial',22,'Updated lecture material: Lesson 2: TCP/IP Model','::1','2026-08-06 04:40:04','2026-08-06 04:40:04'),(325,10,'PUT instructor/lectures/22',NULL,NULL,'User performed an action on instructor/lectures/22','::1','2026-08-06 04:40:04','2026-08-06 04:40:04'),(326,10,'lecture.updated','App\\Models\\LectureMaterial',12,'Updated lecture material: Lesson 2: Types of Computer Networks (LAN, WAN, MAN)','::1','2026-08-06 04:41:59','2026-08-06 04:41:59'),(327,10,'PUT instructor/lectures/12',NULL,NULL,'User performed an action on instructor/lectures/12','::1','2026-08-06 04:41:59','2026-08-06 04:41:59'),(328,10,'assignment.updated','App\\Models\\Assignment',5,'Updated assignment: Assignment 1: Network Fundamentals Research','::1','2026-08-06 04:56:14','2026-08-06 04:56:14'),(329,10,'PUT instructor/assignments/5',NULL,NULL,'User performed an action on instructor/assignments/5','::1','2026-08-06 04:56:14','2026-08-06 04:56:14'),(330,10,'assignment.created','App\\Models\\Assignment',6,'Created assignment: Assignment 2: OSI Model and TCP/IP Analysis','::1','2026-08-06 04:57:36','2026-08-06 04:57:36'),(331,10,'POST instructor/assignments',NULL,NULL,'User performed an action on instructor/assignments','::1','2026-08-06 04:57:36','2026-08-06 04:57:36'),(332,10,'assignment.created','App\\Models\\Assignment',7,'Created assignment: Assignment 3: Network Design Project','::1','2026-08-06 04:58:42','2026-08-06 04:58:42'),(333,10,'POST instructor/assignments',NULL,NULL,'User performed an action on instructor/assignments','::1','2026-08-06 04:58:42','2026-08-06 04:58:42'),(334,10,'assignment.updated','App\\Models\\Assignment',6,'Updated assignment: Assignment 2: OSI Model and TCP/IP Analysis','::1','2026-08-06 04:59:08','2026-08-06 04:59:08'),(335,10,'PUT instructor/assignments/6',NULL,NULL,'User performed an action on instructor/assignments/6','::1','2026-08-06 04:59:08','2026-08-06 04:59:08'),(336,10,'assignment.updated','App\\Models\\Assignment',5,'Updated assignment: Assignment 1: Network Fundamentals Research','::1','2026-08-06 04:59:29','2026-08-06 04:59:29'),(337,10,'PUT instructor/assignments/5',NULL,NULL,'User performed an action on instructor/assignments/5','::1','2026-08-06 04:59:29','2026-08-06 04:59:29'),(338,10,'assignment.created','App\\Models\\Assignment',8,'Created assignment: Assignment 2: OSI Model and TCP/IP Analysis','::1','2026-08-06 05:04:41','2026-08-06 05:04:41'),(339,10,'POST instructor/assignments',NULL,NULL,'User performed an action on instructor/assignments','::1','2026-08-06 05:04:41','2026-08-06 05:04:41'),(340,10,'assignment.deleted',NULL,NULL,'Deleted assignment: Assignment 2: OSI Model and TCP/IP Analysis','::1','2026-08-06 05:05:07','2026-08-06 05:05:07'),(341,10,'DELETE instructor/assignments/8',NULL,NULL,'User performed an action on instructor/assignments/8','::1','2026-08-06 05:05:07','2026-08-06 05:05:07'),(342,10,'PUT instructor/assignments/5',NULL,NULL,'User performed an action on instructor/assignments/5','::1','2026-08-06 05:12:18','2026-08-06 05:12:18'),(343,10,'assignment.updated','App\\Models\\Assignment',5,'Updated assignment: Assignment 1: Network Fundamentals Research','::1','2026-08-06 05:12:38','2026-08-06 05:12:38'),(344,10,'PUT instructor/assignments/5',NULL,NULL,'User performed an action on instructor/assignments/5','::1','2026-08-06 05:12:38','2026-08-06 05:12:38'),(345,10,'PUT instructor/assignments/6',NULL,NULL,'User performed an action on instructor/assignments/6','::1','2026-08-06 05:12:51','2026-08-06 05:12:51'),(346,10,'assignment.updated','App\\Models\\Assignment',6,'Updated assignment: Assignment 2: OSI Model and TCP/IP Analysis','::1','2026-08-06 05:12:57','2026-08-06 05:12:57'),(347,10,'PUT instructor/assignments/6',NULL,NULL,'User performed an action on instructor/assignments/6','::1','2026-08-06 05:12:57','2026-08-06 05:12:57'),(348,10,'assignment.updated','App\\Models\\Assignment',7,'Updated assignment: Assignment 3: Network Design Project','::1','2026-08-06 05:13:09','2026-08-06 05:13:09'),(349,10,'PUT instructor/assignments/7',NULL,NULL,'User performed an action on instructor/assignments/7','::1','2026-08-06 05:13:09','2026-08-06 05:13:09'),(350,1,'backup.run',NULL,NULL,'Manual database backup triggered','::1','2026-08-06 05:22:40','2026-08-06 05:22:40'),(351,1,'POST admin/backup/run',NULL,NULL,'User performed an action on admin/backup/run','::1','2026-08-06 05:22:40','2026-08-06 05:22:40'),(352,1,'backup.run',NULL,NULL,'Database backup downloaded: lecture-platform-backup-2026-08-06_082542.sql','127.0.0.1','2026-08-06 05:25:42','2026-08-06 05:25:42'),(353,1,'backup.run',NULL,NULL,'Database backup downloaded: lecture-platform-backup-2026-08-06_082605.sql','::1','2026-08-06 05:26:05','2026-08-06 05:26:05'),(354,1,'POST admin/backup/run',NULL,NULL,'User performed an action on admin/backup/run','::1','2026-08-06 05:26:05','2026-08-06 05:26:05'),(355,1,'backup.run',NULL,NULL,'Database backup downloaded: lecture-platform-backup-2026-08-06_082859.sql','::1','2026-08-06 05:28:59','2026-08-06 05:28:59'),(356,1,'POST admin/backup/run',NULL,NULL,'User performed an action on admin/backup/run','::1','2026-08-06 05:28:59','2026-08-06 05:28:59'),(357,1,'backup.run',NULL,NULL,'Database backup downloaded: lecture-platform-backup-2026-08-06_083617.sql','::1','2026-08-06 05:36:17','2026-08-06 05:36:17'),(358,1,'POST admin/backup/run',NULL,NULL,'User performed an action on admin/backup/run','::1','2026-08-06 05:36:17','2026-08-06 05:36:17'),(359,10,'logout',NULL,NULL,'User logged out','::1','2026-08-06 05:38:45','2026-08-06 05:38:45'),(360,3,'login',NULL,NULL,'User logged in','::1','2026-08-06 05:39:10','2026-08-06 05:39:10'),(361,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-06 05:39:10','2026-08-06 05:39:10'),(362,10,'message.sent','App\\Models\\Message',2,'Sent message to user #2','127.0.0.1','2026-08-06 06:05:26','2026-08-06 06:05:26'),(363,1,'announcement.created','App\\Models\\Announcement',5,'Created announcement Test Announcement','127.0.0.1','2026-08-06 06:08:04','2026-08-06 06:08:04'),(364,1,'announcement.updated','App\\Models\\Announcement',4,'Updated announcement Upcoming Computer Networking Practical Lab','::1','2026-08-06 06:08:58','2026-08-06 06:08:58'),(365,1,'PUT admin/announcements/4',NULL,NULL,'User performed an action on admin/announcements/4','::1','2026-08-06 06:08:58','2026-08-06 06:08:58'),(366,2,'POST notifications/6bdb7c28-6bd9-4360-8541-54d19c674e78/read',NULL,NULL,'User performed an action on notifications/6bdb7c28-6bd9-4360-8541-54d19c674e78/read','::1','2026-08-06 06:10:44','2026-08-06 06:10:44'),(367,1,'announcement.created','App\\Models\\Announcement',6,'Created announcement Test','::1','2026-08-06 06:12:18','2026-08-06 06:12:18'),(368,1,'POST admin/announcements',NULL,NULL,'User performed an action on admin/announcements','::1','2026-08-06 06:12:18','2026-08-06 06:12:18'),(369,1,'announcement.deleted',NULL,NULL,'Deleted announcement Test','::1','2026-08-06 06:14:02','2026-08-06 06:14:02'),(370,1,'DELETE admin/announcements/6',NULL,NULL,'User performed an action on admin/announcements/6','::1','2026-08-06 06:14:02','2026-08-06 06:14:02'),(371,1,'announcement.created','App\\Models\\Announcement',7,'Created announcement test 2','::1','2026-08-06 06:16:05','2026-08-06 06:16:05'),(372,1,'POST admin/announcements',NULL,NULL,'User performed an action on admin/announcements','::1','2026-08-06 06:16:05','2026-08-06 06:16:05'),(373,1,'announcement.deleted',NULL,NULL,'Deleted announcement test 2','::1','2026-08-06 06:16:24','2026-08-06 06:16:24'),(374,1,'DELETE admin/announcements/7',NULL,NULL,'User performed an action on admin/announcements/7','::1','2026-08-06 06:16:24','2026-08-06 06:16:24'),(375,2,'lesson.completed','App\\Models\\LectureMaterial',11,'Student Maryan Isse completed lesson Lesson 1: What is Computer Networking?','::1','2026-08-06 06:17:30','2026-08-06 06:17:30'),(376,2,'POST student/lectures/11/complete',NULL,NULL,'User performed an action on student/lectures/11/complete','::1','2026-08-06 06:17:30','2026-08-06 06:17:30'),(377,2,'message.sent','App\\Models\\Message',3,'Sent message to user #10','::1','2026-08-06 06:18:02','2026-08-06 06:18:02'),(378,2,'POST messages',NULL,NULL,'User performed an action on messages','::1','2026-08-06 06:18:02','2026-08-06 06:18:02'),(379,3,'logout',NULL,NULL,'User logged out','::1','2026-08-06 06:18:16','2026-08-06 06:18:16'),(380,10,'login',NULL,NULL,'User logged in','::1','2026-08-06 06:18:25','2026-08-06 06:18:25'),(381,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-06 06:18:25','2026-08-06 06:18:25'),(382,1,'login',NULL,NULL,'User logged in','::1','2026-08-08 02:09:32','2026-08-08 02:09:32'),(383,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-08 02:09:32','2026-08-08 02:09:32'),(384,1,'POST admin/reports/generate',NULL,NULL,'User performed an action on admin/reports/generate','::1','2026-08-08 02:10:04','2026-08-08 02:10:04'),(385,2,'login',NULL,NULL,'User logged in','::1','2026-08-08 05:04:44','2026-08-08 05:04:44'),(386,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-08 05:04:44','2026-08-08 05:04:44'),(387,2,'POST student/assignments/5/submit',NULL,NULL,'User performed an action on student/assignments/5/submit','::1','2026-08-08 05:05:54','2026-08-08 05:05:54'),(388,2,'POST student/assignments/5/submit',NULL,NULL,'User performed an action on student/assignments/5/submit','::1','2026-08-08 05:08:07','2026-08-08 05:08:07'),(389,2,'logout',NULL,NULL,'User logged out','::1','2026-08-08 05:08:56','2026-08-08 05:08:56'),(390,2,'logout',NULL,NULL,'User logged out','::1','2026-08-08 05:08:56','2026-08-08 05:08:56'),(391,3,'login',NULL,NULL,'User logged in','::1','2026-08-08 05:09:39','2026-08-08 05:09:39'),(392,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-08 05:09:39','2026-08-08 05:09:39'),(393,3,'logout',NULL,NULL,'User logged out','::1','2026-08-08 05:09:47','2026-08-08 05:09:47'),(394,3,'login',NULL,NULL,'User logged in','::1','2026-08-08 13:42:55','2026-08-08 13:42:55'),(395,3,'login',NULL,NULL,'User logged in','::1','2026-08-08 13:42:55','2026-08-08 13:42:55'),(396,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-08 13:42:55','2026-08-08 13:42:55'),(397,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-08 13:42:55','2026-08-08 13:42:55'),(398,2,'login',NULL,NULL,'User logged in','::1','2026-08-13 04:30:19','2026-08-13 04:30:19'),(399,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-08-13 04:30:19','2026-08-13 04:30:19'),(400,3,'login',NULL,NULL,'User logged in','::1','2026-09-15 05:31:34','2026-09-15 05:31:34'),(401,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 05:31:34','2026-09-15 05:31:34'),(402,3,'logout',NULL,NULL,'User logged out','::1','2026-09-15 05:45:19','2026-09-15 05:45:19'),(403,1,'login',NULL,NULL,'User logged in','::1','2026-09-15 05:47:19','2026-09-15 05:47:19'),(404,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 05:47:19','2026-09-15 05:47:19'),(405,1,'logout',NULL,NULL,'User logged out','::1','2026-09-15 06:05:31','2026-09-15 06:05:31'),(406,3,'login',NULL,NULL,'User logged in','::1','2026-09-15 06:07:52','2026-09-15 06:07:52'),(407,3,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 06:07:52','2026-09-15 06:07:52'),(408,3,'logout',NULL,NULL,'User logged out','::1','2026-09-15 06:08:25','2026-09-15 06:08:25'),(409,10,'login',NULL,NULL,'User logged in','::1','2026-09-15 06:08:47','2026-09-15 06:08:47'),(410,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 06:08:47','2026-09-15 06:08:47'),(411,10,'POST instructor/live-sessions',NULL,NULL,'User performed an action on instructor/live-sessions','::1','2026-09-15 06:17:14','2026-09-15 06:17:14'),(412,10,'live_session.created','App\\Models\\LiveSession',1,'Created live session Weak 1','::1','2026-09-15 06:17:23','2026-09-15 06:17:23'),(413,10,'POST instructor/live-sessions',NULL,NULL,'User performed an action on instructor/live-sessions','::1','2026-09-15 06:17:23','2026-09-15 06:17:23'),(414,10,'logout',NULL,NULL,'User logged out','::1','2026-09-15 06:18:52','2026-09-15 06:18:52'),(415,2,'login',NULL,NULL,'User logged in','::1','2026-09-15 06:19:29','2026-09-15 06:19:29'),(416,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 06:19:29','2026-09-15 06:19:29'),(417,2,'logout',NULL,NULL,'User logged out','::1','2026-09-15 06:19:41','2026-09-15 06:19:41'),(418,1,'login',NULL,NULL,'User logged in','::1','2026-09-15 06:19:46','2026-09-15 06:19:46'),(419,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 06:19:46','2026-09-15 06:19:46'),(420,1,'user.updated','App\\Models\\User',10,'Updated user Abdirahman Omar','::1','2026-09-15 06:20:32','2026-09-15 06:20:32'),(421,1,'PUT admin/users/10',NULL,NULL,'User performed an action on admin/users/10','::1','2026-09-15 06:20:32','2026-09-15 06:20:32'),(422,1,'user.updated','App\\Models\\User',10,'Updated user Instructor','::1','2026-09-15 06:20:42','2026-09-15 06:20:42'),(423,1,'PUT admin/users/10',NULL,NULL,'User performed an action on admin/users/10','::1','2026-09-15 06:20:42','2026-09-15 06:20:42'),(424,1,'user.updated','App\\Models\\User',3,'Updated user Support Staff','::1','2026-09-15 06:21:15','2026-09-15 06:21:15'),(425,1,'PUT admin/users/3',NULL,NULL,'User performed an action on admin/users/3','::1','2026-09-15 06:21:15','2026-09-15 06:21:15'),(426,10,'login',NULL,NULL,'User logged in','::1','2026-09-15 14:13:24','2026-09-15 14:13:24'),(427,10,'login',NULL,NULL,'User logged in','::1','2026-09-15 14:13:24','2026-09-15 14:13:24'),(428,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 14:13:24','2026-09-15 14:13:24'),(429,10,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 14:13:24','2026-09-15 14:13:24'),(430,10,'POST notifications/248ab927-eb9b-4e9c-ae59-42051d835833/read',NULL,NULL,'User performed an action on notifications/248ab927-eb9b-4e9c-ae59-42051d835833/read','::1','2026-09-15 14:13:47','2026-09-15 14:13:47'),(431,10,'POST notifications/b52874ad-3db7-4c28-8130-913a6f291196/read',NULL,NULL,'User performed an action on notifications/b52874ad-3db7-4c28-8130-913a6f291196/read','::1','2026-09-15 14:13:49','2026-09-15 14:13:49'),(432,2,'login',NULL,NULL,'User logged in','::1','2026-09-15 14:15:16','2026-09-15 14:15:16'),(433,2,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-15 14:15:16','2026-09-15 14:15:16'),(434,10,'live_session.updated','App\\Models\\LiveSession',1,'Updated live session Weak 1','::1','2026-09-15 14:17:04','2026-09-15 14:17:04'),(435,10,'PUT instructor/live-sessions/1',NULL,NULL,'User performed an action on instructor/live-sessions/1','::1','2026-09-15 14:17:04','2026-09-15 14:17:04'),(436,10,'live_session.updated','App\\Models\\LiveSession',1,'Updated live session Weak 1','::1','2026-09-15 14:17:43','2026-09-15 14:17:43'),(437,10,'PUT instructor/live-sessions/1',NULL,NULL,'User performed an action on instructor/live-sessions/1','::1','2026-09-15 14:17:43','2026-09-15 14:17:43'),(438,10,'PUT instructor/live-sessions/1',NULL,NULL,'User performed an action on instructor/live-sessions/1','::1','2026-09-15 14:18:11','2026-09-15 14:18:11'),(439,10,'live_session.updated','App\\Models\\LiveSession',1,'Updated live session Weak 1','::1','2026-09-15 14:18:19','2026-09-15 14:18:19'),(440,10,'PUT instructor/live-sessions/1',NULL,NULL,'User performed an action on instructor/live-sessions/1','::1','2026-09-15 14:18:19','2026-09-15 14:18:19'),(441,10,'live_session.updated','App\\Models\\LiveSession',1,'Updated live session Weak 1','::1','2026-09-15 14:18:38','2026-09-15 14:18:38'),(442,10,'PUT instructor/live-sessions/1',NULL,NULL,'User performed an action on instructor/live-sessions/1','::1','2026-09-15 14:18:38','2026-09-15 14:18:38'),(443,10,'live_session.updated','App\\Models\\LiveSession',1,'Updated live session Weak 1','::1','2026-09-15 14:19:19','2026-09-15 14:19:19'),(444,10,'PUT instructor/live-sessions/1',NULL,NULL,'User performed an action on instructor/live-sessions/1','::1','2026-09-15 14:19:19','2026-09-15 14:19:19'),(445,10,'live_session.started','App\\Models\\LiveSession',1,'Started live session Weak 1','::1','2026-09-15 14:19:34','2026-09-15 14:19:34'),(446,10,'POST instructor/live-sessions/1/start',NULL,NULL,'User performed an action on instructor/live-sessions/1/start','::1','2026-09-15 14:19:34','2026-09-15 14:19:34'),(447,10,'live_session.ended','App\\Models\\LiveSession',1,'Ended live session Weak 1','::1','2026-09-15 14:23:47','2026-09-15 14:23:47'),(448,10,'POST instructor/live-sessions/1/end',NULL,NULL,'User performed an action on instructor/live-sessions/1/end','::1','2026-09-15 14:23:47','2026-09-15 14:23:47'),(449,1,'login',NULL,NULL,'User logged in','::1','2026-09-16 02:50:19','2026-09-16 02:50:19'),(450,1,'POST login',NULL,NULL,'User performed an action on login','::1','2026-09-16 02:50:19','2026-09-16 02:50:19');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `audience` enum('all','students','instructors','support_staff') NOT NULL DEFAULT 'all',
  `course_id` bigint(20) unsigned DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_created_by_foreign` (`created_by`),
  KEY `announcements_course_id_foreign` (`course_id`),
  CONSTRAINT `announcements_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL,
  CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (4,1,'Upcoming Computer Networking Practical Lab','Dear Students,\r\n\r\nPlease be informed that the Computer Networking course assignment has been published and is now available on the course page. Ensure that you carefully review the assignment instructions and submit your work before the deadline.\r\n\r\nAdditionally, the practical networking lab session will be held this week, where we will cover network topologies, IPv4 addressing, subnetting, routers, switches, and basic network configuration. Attendance is highly recommended, as the lab exercises will help you complete your assignment and prepare for the upcoming assessment.\r\n\r\nIf you have any questions or experience technical issues accessing the course materials, please contact your instructor or submit a support ticket through the Student Support Center.\r\n\r\nPosted By: Abdirahman Omar\r\nAudience: Students Enrolled in Computer Networking\r\nStatus: Published','students',10,1,'2026-08-05 05:53:35','2026-08-05 05:53:35','2026-08-05 05:53:35');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignment_submissions`
--

DROP TABLE IF EXISTS `assignment_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignment_submissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `assignment_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `submission_note` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('submitted','late','graded') NOT NULL DEFAULT 'submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assignment_submissions_assignment_id_student_id_unique` (`assignment_id`,`student_id`),
  KEY `assignment_submissions_student_id_foreign` (`student_id`),
  CONSTRAINT `assignment_submissions_assignment_id_foreign` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignment_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignment_submissions`
--

LOCK TABLES `assignment_submissions` WRITE;
/*!40000 ALTER TABLE `assignment_submissions` DISABLE KEYS */;
INSERT INTO `assignment_submissions` VALUES (3,5,2,'submissions/2/MYiQNOQ1QBSXPUvDHL8O49TLkr5UZbGsG1QJaoZv.pdf','Assignment','2026-08-08 05:08:06','submitted','2026-08-08 05:08:06','2026-08-08 05:08:06');
/*!40000 ALTER TABLE `assignment_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assignments`
--

DROP TABLE IF EXISTS `assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assignments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `instructor_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `total_marks` decimal(6,2) NOT NULL DEFAULT 100.00,
  `due_date` datetime NOT NULL,
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `sort_order` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `assignments_course_id_foreign` (`course_id`),
  KEY `assignments_instructor_id_foreign` (`instructor_id`),
  KEY `assignments_sort_order_index` (`sort_order`),
  CONSTRAINT `assignments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assignments_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assignments`
--

LOCK TABLES `assignments` WRITE;
/*!40000 ALTER TABLE `assignments` DISABLE KEYS */;
INSERT INTO `assignments` VALUES (5,18,10,'Assignment 1: Network Fundamentals Research','Students will research and explain the basic concepts of computer networking, including network types, network devices, and network topologies. The assignment requires students to describe how different networks work and provide real-world examples of LAN, WAN, MAN, and other network structures.',NULL,20.00,'2026-08-10 08:00:00','active',1,'2026-08-05 04:07:18','2026-08-06 05:12:38',NULL),(6,18,10,'Assignment 2: OSI Model and TCP/IP Analysis','Students will analyze the OSI and TCP/IP models and understand how data communication happens between network devices. This assignment focuses on understanding network layers, protocols, and their roles in communication.',NULL,30.00,'2026-08-08 10:00:00','active',2,'2026-08-06 04:57:36','2026-08-06 05:12:57',NULL),(7,18,10,'Assignment 3: Network Design Project','Students will design a complete network infrastructure for a small business. The project requires applying networking concepts including device selection, IP planning, security configuration, and network documentation.',NULL,50.00,'2026-08-20 00:00:00','active',3,'2026-08-06 04:58:42','2026-08-06 05:13:09',NULL),(8,18,10,'Assignment 2: OSI Model and TCP/IP Analysis','Students will analyze the OSI and TCP/IP models and understand how data communication happens between network devices. This assignment focuses on understanding network layers, protocols, and their roles in communication.',NULL,100.00,'2026-08-25 11:04:00','active',NULL,'2026-08-06 05:04:41','2026-08-06 05:05:07','2026-08-06 05:05:07');
/*!40000 ALTER TABLE `assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_categories`
--

DROP TABLE IF EXISTS `course_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_categories`
--

LOCK TABLES `course_categories` WRITE;
/*!40000 ALTER TABLE `course_categories` DISABLE KEYS */;
INSERT INTO `course_categories` VALUES (6,'Computer Science','computer-science','Learn programming, software development, databases, AI, and modern computing technologies.','2026-08-04 05:34:41','2026-08-04 05:34:41'),(7,'Information Technology','information-technology','Study computer systems, networking, cybersecurity, and IT infrastructure management.','2026-08-04 05:35:09','2026-08-04 05:35:09'),(8,'Business Administration','business-administration','Develop leadership, management, marketing, and entrepreneurship skills for business success.','2026-08-04 05:39:49','2026-08-04 05:39:49'),(9,'Health Sciences','health-sciences','Gain knowledge in healthcare, anatomy, public health, and medical sciences.','2026-08-04 05:40:07','2026-08-04 05:40:07'),(10,'Engineering','engineering','Learn engineering principles, design, innovation, and problem-solving techniques.','2026-08-04 05:40:29','2026-08-04 05:40:29'),(11,'Islamic Studies','islamic-studies','Study Islamic teachings, history, ethics, and principles for personal and academic development.','2026-08-04 05:40:51','2026-08-04 05:40:51'),(12,'Accounting & Finance','accounting-finance','Master financial reporting, budgeting, auditing, taxation, and business finance.','2026-08-04 05:48:22','2026-08-04 05:48:22');
/*!40000 ALTER TABLE `course_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_enrollments`
--

DROP TABLE IF EXISTS `course_enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_enrollments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `status` enum('active','completed','dropped') NOT NULL DEFAULT 'active',
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_enrollments_course_id_student_id_unique` (`course_id`,`student_id`),
  KEY `course_enrollments_student_id_foreign` (`student_id`),
  CONSTRAINT `course_enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_enrollments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_enrollments`
--

LOCK TABLES `course_enrollments` WRITE;
/*!40000 ALTER TABLE `course_enrollments` DISABLE KEYS */;
INSERT INTO `course_enrollments` VALUES (6,10,2,'active','2026-08-05 07:50:49',NULL,NULL),(7,12,2,'active','2026-08-05 08:54:49',NULL,NULL),(8,18,2,'active','2026-08-06 07:09:15',NULL,NULL);
/*!40000 ALTER TABLE `course_enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `instructor_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courses_slug_unique` (`slug`),
  KEY `courses_category_id_foreign` (`category_id`),
  KEY `courses_instructor_id_foreign` (`instructor_id`),
  CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `course_categories` (`id`),
  CONSTRAINT `courses_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (7,6,10,'Introduction to Computer Science','introduction-to-computer-science-nYspk','Learn programming, software development, databases, and modern computing technologies.','8 weeks','course-thumbnails/tytCyIfbnajLky7vnLfR0f47frpj9NTMDVRZth8V.jpg','published','2026-07-28','2026-08-01','2026-08-04 05:44:18','2026-08-05 05:30:46',NULL),(8,6,10,'Programming Fundamentals','programming-fundamentals-L2dBK','Learn programming, software development, databases, and modern computing technologies.','12 weeks','course-thumbnails/0fe8OP0by8iBbP6zRaACkzlJFnLzF8HQhUOqkmxv.jpg','published','2026-08-01','2026-08-31','2026-08-04 05:44:53','2026-08-05 05:30:32',NULL),(9,6,6,'Programming Fundamentals','programming-fundamentals-shnET','Learn programming, software development, databases, and modern computing technologies.',NULL,NULL,'published','2026-08-01','2026-08-31','2026-08-04 05:44:53','2026-08-04 05:45:03','2026-08-04 05:45:03'),(10,7,10,'Computer Networking','computer-networks-5dRzA','Study networking, cybersecurity, system administration, and IT infrastructure.','10 weeks','course-thumbnails/tPw3Earz659SfMAOcrxxU1PLNydg6WdAOabZW1yR.jpg','published','2026-07-23','2026-08-24','2026-08-04 05:46:15','2026-08-05 04:54:52',NULL),(11,7,10,'Cyber Security Fundamentals','cyber-security-fundamentals-fkkHz','Study networking, cybersecurity, system administration, and IT infrastructure.','8 weeks','course-thumbnails/9N5n34KFSU0djASn2Cj8Pd51qfckOuR89Qbnputl.png','published','2026-08-04','2026-08-31','2026-08-04 05:46:50','2026-08-05 05:30:15',NULL),(12,8,10,'Marketing Fundamentals','marketing-fundamentals-OwfHh','Develop leadership, management, marketing, and entrepreneurship skills.','6 weeks','course-thumbnails/ljnDqBgcdt5QggdsfsklTixU4afRtaR9ctT3sgfS.png','published','2026-08-01','2026-10-31','2026-08-04 05:47:48','2026-08-05 05:29:48',NULL),(13,12,10,'Financial Accounting','financial-accounting-O9ojJ','Master accounting, auditing, taxation, budgeting, and financial management.','10 weeks','course-thumbnails/hLQUCPqcwkSqKtDlEgqjQjBsWa6uHZH3KtamAaPG.jpg','published','2026-07-30','2026-09-01','2026-08-04 05:49:20','2026-08-05 05:29:31',NULL),(14,9,10,'Human Anatomy','human-anatomy-Xn0B6','Gain knowledge in healthcare, anatomy, physiology, and public health.','12 weeks','course-thumbnails/c0WHXjgIjR7xTkA3KBc5bczgtf7iFKLvDrD4zPIC.jpg','published','2026-08-01','2026-10-31','2026-08-04 05:49:58','2026-08-05 05:32:00',NULL),(15,10,10,'Civil Engineering Fundamentals','civil-engineering-fundamentals-wrfEf','Learn engineering principles, technical design, and innovative problem-solving.','8 weeks','course-thumbnails/gvgZsxW7nVAs1Qk8CnZfNBXlx7ajtaYlvPTMYSOW.png','published','2026-07-29','2026-09-05','2026-08-04 05:50:51','2026-08-05 05:28:46',NULL),(16,11,10,'Quranic Studies','quranic-studies-5atCV','Study Islamic teachings, ethics, history, and principles for personal development.','6 weeks','course-thumbnails/aJtiX1uSzMoV6Kswqmh5KCWN3zOLUuEtpQs7GrGv.jpg','published','2026-08-01','2026-10-01','2026-08-04 05:51:58','2026-08-05 05:28:19',NULL),(18,7,10,'Computer Networking Fundamentals','computer-networking-fundamentals-EMxdt','This course introduces the fundamental concepts of computer networking, including network types, OSI and TCP/IP models, IP addressing, routing, switching, network security, and practical networking skills. Students will learn through video lessons, slides, documents, and notes to build a strong foundation in networking.','8 weeks',NULL,'published','2026-08-01','2026-10-01','2026-08-06 04:03:21','2026-08-06 04:04:31',NULL);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` bigint(20) unsigned NOT NULL,
  `graded_by` bigint(20) unsigned NOT NULL,
  `marks_obtained` decimal(6,2) NOT NULL,
  `feedback` text DEFAULT NULL,
  `graded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_submission_id_foreign` (`submission_id`),
  KEY `grades_graded_by_foreign` (`graded_by`),
  CONSTRAINT `grades_graded_by_foreign` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grades_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `assignment_submissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_completions`
--

DROP TABLE IF EXISTS `lecture_completions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecture_completions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `lecture_material_id` bigint(20) unsigned NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecture_completions_student_id_lecture_material_id_unique` (`student_id`,`lecture_material_id`),
  KEY `lecture_completions_lecture_material_id_foreign` (`lecture_material_id`),
  CONSTRAINT `lecture_completions_lecture_material_id_foreign` FOREIGN KEY (`lecture_material_id`) REFERENCES `lecture_materials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lecture_completions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_completions`
--

LOCK TABLES `lecture_completions` WRITE;
/*!40000 ALTER TABLE `lecture_completions` DISABLE KEYS */;
INSERT INTO `lecture_completions` VALUES (5,2,4,'2026-08-06 04:01:17','2026-08-06 04:01:17','2026-08-06 04:01:17'),(6,2,11,'2026-08-06 06:17:30','2026-08-06 06:17:30','2026-08-06 06:17:30');
/*!40000 ALTER TABLE `lecture_completions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_materials`
--

DROP TABLE IF EXISTS `lecture_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecture_materials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `module_id` bigint(20) unsigned DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `instructor_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `type` enum('document','video','notes','other') NOT NULL DEFAULT 'document',
  `file_path` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `visibility` enum('public','private') NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lecture_materials_course_id_foreign` (`course_id`),
  KEY `lecture_materials_instructor_id_foreign` (`instructor_id`),
  KEY `lecture_materials_module_id_foreign` (`module_id`),
  CONSTRAINT `lecture_materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lecture_materials_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lecture_materials_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `lecture_modules` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_materials`
--

LOCK TABLES `lecture_materials` WRITE;
/*!40000 ALTER TABLE `lecture_materials` DISABLE KEYS */;
INSERT INTO `lecture_materials` VALUES (4,10,1,0,10,'Intro to Computer Networking!',NULL,NULL,'video','lectures/423e170f-38a2-4daf-85d5-33d5b2c3900a.pdf','https://youtu.be/nt0xqeHmWBY?si=R5AbfFPGQNh5c0VN','4','public','2026-08-05 04:00:20','2026-08-06 04:22:06',NULL),(5,10,1,0,10,'Computer Networks - Basic Characteristics',NULL,NULL,'video',NULL,'https://youtu.be/m8eNwVel5xI?si=7j7Ji31LkKpl3a9j',NULL,'public','2026-08-06 02:56:07','2026-08-06 03:28:07','2026-08-06 03:28:07'),(6,10,2,0,10,'Network Protocols & Communications (Part 1)',NULL,NULL,'video',NULL,'https://youtu.be/ly8ikWtAY7s?si=fGMyhPTOxeomR3pk',NULL,'public','2026-08-06 02:57:08','2026-08-06 03:28:11','2026-08-06 03:28:11'),(7,10,1,0,10,'Basic Networking Functionality Explained',NULL,NULL,'video',NULL,'https://youtu.be/rp6d1fBhnjI?si=GyAxCCMuPY9vFHyc',NULL,'public','2026-08-06 03:28:55','2026-08-06 03:54:31','2026-08-06 03:54:31'),(8,10,2,0,10,'Network Ports Explained 🔌 TCP, UDP, Ranges & Scanning',NULL,NULL,'video',NULL,'https://youtu.be/Hbov_1k1hH4?si=ZMB8rbHm_8cy-Vw8',NULL,'public','2026-08-06 03:30:01','2026-08-06 03:54:28','2026-08-06 03:54:28'),(9,10,1,0,10,'Basic Networking Functionality Explained',NULL,NULL,'video',NULL,'https://youtu.be/rp6d1fBhnjI?si=a2emt97QMJXcEsGQ',NULL,'public','2026-08-06 03:59:07','2026-08-06 03:59:07',NULL),(10,10,2,0,10,'Network Ports Explained 🔌 TCP, UDP, Ranges & Scanning',NULL,NULL,'video',NULL,'https://youtu.be/Hbov_1k1hH4?si=lv1laE5FC12oC6LG',NULL,'public','2026-08-06 03:59:53','2026-08-06 03:59:53',NULL),(11,18,3,0,10,'Lesson 1: What is Computer Networking?','Introduction to computer networks, how devices communicate, and why networking is important.',NULL,'video',NULL,'https://youtu.be/3QhU9jd03a0?si=ATwIqYSmngH0sBaF',NULL,'public','2026-08-06 04:09:07','2026-08-06 04:10:10',NULL),(12,18,3,0,10,'Lesson 2: Types of Computer Networks (LAN, WAN, MAN)',NULL,NULL,'document','lectures/f8ba1649-f4ec-405a-8dd3-7ef37ecce578.pdf',NULL,NULL,'public','2026-08-06 04:11:22','2026-08-06 04:41:59',NULL),(13,18,3,0,10,'Lesson 3: Network Devices Overview',NULL,NULL,'document',NULL,NULL,NULL,'public','2026-08-06 04:14:15','2026-08-06 04:14:15',NULL),(14,18,4,0,10,'Lesson 1: OSI Model Explained','Topics:\r\n\r\n7 Layers of OSI Model\r\nLayer Functions\r\nData Encapsulation',NULL,'video',NULL,'https://www.youtube.com/watch?v=vv4y_uOneC0',NULL,'public','2026-08-06 04:16:35','2026-08-06 04:16:35',NULL),(15,18,5,0,10,'Lesson 1: IPv4 Addressing Basics','Topics:\r\n\r\nIP Address\r\nNetwork ID\r\nHost ID\r\nPublic vs Private IP',NULL,'video',NULL,'https://www.youtube.com/watch?v=thG8vQ7qYqA',NULL,'public','2026-08-06 04:24:02','2026-08-06 04:24:02',NULL),(16,18,5,0,10,'Lesson 2: Subnetting Fundamentals',NULL,'Content:\r\n\r\nSubnet Mask\r\nCIDR\r\nNetwork Calculation','notes',NULL,NULL,NULL,'public','2026-08-06 04:28:26','2026-08-06 04:28:26',NULL),(17,18,5,0,10,'Lesson 3: Routing Concepts',NULL,'Topics:\r\n\r\nStatic Routing\r\nDynamic Routing\r\nRouting Table','notes',NULL,NULL,NULL,'public','2026-08-06 04:29:15','2026-08-06 04:29:15',NULL),(18,18,6,0,10,'Lesson 1: Switch Configuration Basics',NULL,NULL,'video',NULL,'https://www.youtube.com/watch?v=H7eYfG9K5jM',NULL,'public','2026-08-06 04:30:11','2026-08-06 04:30:11',NULL),(19,18,6,0,10,'Lesson 2: Network Security Fundamentals',NULL,'Topics:\r\n\r\nFirewall\r\nVPN\r\nEncryption\r\nAuthentication','notes',NULL,NULL,NULL,'public','2026-08-06 04:30:55','2026-08-06 04:30:55',NULL),(20,18,6,0,10,'Lesson 3: Network Troubleshooting',NULL,'**Commands:\r\n\r\nping\r\ntracert/traceroute\r\nipconfig\r\nnslookup','notes',NULL,NULL,NULL,'public','2026-08-06 04:35:42','2026-08-06 04:35:42',NULL),(21,18,6,0,10,'Lesson 4: Final Networking Project',NULL,'Design a small office network:\r\n\r\nRouter\r\nSwitch\r\nPCs\r\nIP Address Plan\r\nSecurity Configuration','notes',NULL,NULL,NULL,'public','2026-08-06 04:37:07','2026-08-06 04:38:03',NULL),(22,18,4,0,10,'Lesson 2: TCP/IP Model',NULL,'Content:\r\n\r\nApplication Layer\r\nTransport Layer\r\nInternet Layer\r\nNetwork Access Layer','notes',NULL,NULL,NULL,'public','2026-08-06 04:39:47','2026-08-06 04:40:04',NULL);
/*!40000 ALTER TABLE `lecture_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecture_modules`
--

DROP TABLE IF EXISTS `lecture_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecture_modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lecture_modules_course_id_foreign` (`course_id`),
  CONSTRAINT `lecture_modules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecture_modules`
--

LOCK TABLES `lecture_modules` WRITE;
/*!40000 ALTER TABLE `lecture_modules` DISABLE KEYS */;
INSERT INTO `lecture_modules` VALUES (1,10,'Introduction to Networking','Foundational concepts of computer networks.',1,'2026-08-06 03:09:08','2026-08-06 03:09:08',NULL),(2,10,'Network Ports',NULL,2,'2026-08-06 03:09:08','2026-08-06 03:31:32',NULL),(3,18,'Module 1: Introduction to Computer Networks',NULL,1,'2026-08-06 04:07:10','2026-08-06 04:10:24',NULL),(4,18,'Module 2: OSI Model and TCP/IP',NULL,2,'2026-08-06 04:14:54','2026-08-06 04:14:54',NULL),(5,18,'Module 3: IP Addressing and Routing',NULL,3,'2026-08-06 04:22:00','2026-08-06 04:22:00',NULL),(6,18,'Module 4: Switching, Security and Practical Networking',NULL,4,'2026-08-06 04:22:35','2026-08-06 04:22:35',NULL);
/*!40000 ALTER TABLE `lecture_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `live_sessions`
--

DROP TABLE IF EXISTS `live_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `live_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `instructor_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int(10) unsigned NOT NULL DEFAULT 60,
  `jitsi_room_id` varchar(255) NOT NULL,
  `status` enum('scheduled','live','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `live_sessions_jitsi_room_id_unique` (`jitsi_room_id`),
  KEY `live_sessions_course_id_foreign` (`course_id`),
  KEY `live_sessions_instructor_id_foreign` (`instructor_id`),
  CONSTRAINT `live_sessions_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `live_sessions_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `live_sessions`
--

LOCK TABLES `live_sessions` WRITE;
/*!40000 ALTER TABLE `live_sessions` DISABLE KEYS */;
INSERT INTO `live_sessions` VALUES (1,18,10,'Weak 1','This course introduces the fundamental concepts of computer networking, including network types, OSI and TCP/IP models, IP addressing, routing, switching, network security, and practical networking skills. Students will learn through video lessons, slides, documents, and notes to build a strong foundation in networking.','2026-09-15 20:20:00',120,'weak-1-pHVeXK7u','completed',NULL,NULL,'2026-09-15 06:17:23','2026-09-15 14:23:47');
/*!40000 ALTER TABLE `live_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) unsigned NOT NULL,
  `receiver_id` bigint(20) unsigned NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (2,10,2,'Test','Hello student',NULL,1,'2026-08-06 06:10:56','2026-08-06 06:05:26','2026-08-06 06:10:56'),(3,2,10,'Re: Test','test 2',NULL,1,'2026-08-06 06:18:35','2026-08-06 06:18:02','2026-08-06 06:18:35');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2024_01_01_000001_create_roles_table',1),(3,'2024_01_01_000002_create_users_table',1),(4,'2024_01_01_000003_create_courses_tables',1),(5,'2024_01_01_000004_create_lecture_materials_table',1),(6,'2024_01_01_000005_create_assignments_tables',1),(7,'2024_01_01_000006_create_support_tables',1),(8,'2024_01_01_000007_create_communication_tables',1),(9,'2024_01_01_000008_create_system_tables',1),(10,'2026_08_04_000001_update_lecture_materials_enums',2),(11,'2026_08_05_000001_add_pending_user_status',3),(12,'2026_08_05_000002_add_duration_to_courses',4),(13,'2026_08_06_000001_create_lecture_modules_table',5),(14,'2026_08_06_000002_add_module_to_lecture_materials_table',5),(15,'2026_08_06_000003_create_lecture_completions_table',5),(16,'2026_08_06_000004_replace_slides_with_notes',6),(17,'2026_08_06_000005_add_sort_order_to_assignments',7),(19,'2026_09_15_000001_create_live_sessions_table',8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('01f534c0-2657-43c1-bcfc-0ffff7fa9fdb','announcement',2,'New announcement','{\"title\":\"New announcement\",\"message\":\"Test\"}',NULL,'2026-08-06 06:12:18','2026-08-06 06:12:18'),('248ab927-eb9b-4e9c-ae59-42051d835833','submission',10,'New assignment submission','{\"title\":\"New assignment submission\",\"message\":\"Maryan Isse submitted \\\"Assignment 1: Network Fundamentals Research\\\".\"}','2026-09-15 14:13:47','2026-08-08 05:08:07','2026-08-08 05:08:07'),('6bdb7c28-6bd9-4360-8541-54d19c674e78','message',2,'New message','{\"title\":\"New message\",\"message\":\"Abdirahman Omar sent you a message: Hello student\"}','2026-08-06 06:10:44','2026-08-06 06:05:26','2026-08-06 06:05:26'),('b52874ad-3db7-4c28-8130-913a6f291196','message',10,'New message','{\"title\":\"New message\",\"message\":\"Maryan Isse sent you a message: test 2\"}','2026-09-15 14:13:49','2026-08-06 06:18:02','2026-08-06 06:18:02'),('dbb31282-0af4-4b85-aeed-e83662e8f436','announcement',2,'New announcement','{\"title\":\"New announcement\",\"message\":\"test 2\"}',NULL,'2026-08-06 06:16:05','2026-08-06 06:16:05'),('e72d6a04-d81a-4d44-8233-138d47bd8484','live_session',2,'New Live Session Scheduled','{\"title\":\"New Live Session Scheduled\",\"message\":\"A new live session \\\"Weak 1\\\" has been scheduled for Sep 15, 2026 8:20 PM in Computer Networking Fundamentals.\"}',NULL,'2026-09-15 06:17:23','2026-09-15 06:17:23');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('sudaissd99@gmail.com','$2y$12$a1n0HyRPVk8BK/J0G6ex0etz/wpcvW.DrgQV1NVmYiHCsaV3Qxttq','2026-08-05 03:27:07'),('sudaissd998@gmail.com','$2y$12$nwDwFF7NPqaqXL9WTA83c.1Kv1XKZANrWM5pUmoxPRylIHtyhZ.Ci','2026-08-04 12:48:56');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_role_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,1,3,NULL,NULL),(4,1,4,NULL,NULL),(5,1,5,NULL,NULL),(6,1,6,NULL,NULL),(7,1,7,NULL,NULL),(8,1,8,NULL,NULL),(9,1,9,NULL,NULL),(10,1,10,NULL,NULL),(11,1,11,NULL,NULL),(12,1,12,NULL,NULL),(13,1,13,NULL,NULL),(14,1,14,NULL,NULL),(15,2,9,NULL,NULL),(16,2,6,NULL,NULL),(17,2,5,NULL,NULL),(18,2,4,NULL,NULL),(19,2,13,NULL,NULL),(20,2,14,NULL,NULL),(21,3,13,NULL,NULL),(22,3,14,NULL,NULL),(23,4,13,NULL,NULL),(24,4,7,NULL,NULL),(25,4,8,NULL,NULL);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'users.manage','Users Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(2,'courses.manage','Courses Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(3,'categories.manage','Categories Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(4,'lectures.manage','Lectures Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(5,'assignments.manage','Assignments Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(6,'assignments.grade','Assignments Grade','2026-08-04 03:12:09','2026-08-04 03:12:09'),(7,'tickets.manage','Tickets Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(8,'tickets.respond','Tickets Respond','2026-08-04 03:12:09','2026-08-04 03:12:09'),(9,'announcements.manage','Announcements Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(10,'reports.manage','Reports Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(11,'settings.manage','Settings Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(12,'roles.manage','Roles Manage','2026-08-04 03:12:09','2026-08-04 03:12:09'),(13,'messages.send','Messages Send','2026-08-04 03:12:09','2026-08-04 03:12:09'),(14,'progress.view','Progress View','2026-08-04 03:12:09','2026-08-04 03:12:09');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `generated_by` bigint(20) unsigned NOT NULL,
  `type` enum('student','instructor','course','assignment','support','system') NOT NULL,
  `title` varchar(255) NOT NULL,
  `filters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`filters`)),
  `file_path` varchar(255) DEFAULT NULL,
  `format` enum('pdf','excel') NOT NULL DEFAULT 'pdf',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_generated_by_foreign` (`generated_by`),
  CONSTRAINT `reports_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrator','Full system access','2026-08-04 03:12:09','2026-08-04 03:12:09'),(2,'instructor','Instructor','Manages courses and grades','2026-08-04 03:12:09','2026-08-04 03:12:09'),(3,'student','Student','Enrolled learner','2026-08-04 03:12:09','2026-08-04 03:12:09'),(4,'support_staff','Support Staff','Handles support tickets','2026-08-04 03:12:09','2026-08-04 03:12:09');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('C8moBmKbKi3uPieuf2sAbEHvs39zCg3KMBCUA5qa',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQno3R095eURBam5jRzhxT2NKdTZNS1dWZ1RrMGk4R2c4blZCeVdGbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3QvbGVjdHVyZS1wbGF0Zm9ybS9wdWJsaWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1789537784),('PQMGRW5UrtwLYc3xaDjyGKSh6kQGyTcCA4twYad0',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUNqd2RBalRRbHo1SW9Zc0R0Y0JyT2hYMFBmZkFNOEwxYTR5OElBMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3QvbGVjdHVyZS1wbGF0Zm9ybS9wdWJsaWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1789537784),('WAMM5Cv0NNgPxmXMecDytNbKrtS5KtxSIiH4SfXG',1,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieUVnTVl3VEpqaUsxeXBDeWk4RW1BTXYzUVRBY2MzSVVtd0NESFdUWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly9sb2NhbGhvc3QvbGVjdHVyZS1wbGF0Zm9ybS9wdWJsaWMvYWRtaW4vYmFja3VwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1789537823);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_progress`
--

DROP TABLE IF EXISTS `student_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_progress` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `completion_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `lectures_completed` int(11) NOT NULL DEFAULT 0,
  `assignments_completed` int(11) NOT NULL DEFAULT 0,
  `average_grade` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_progress_student_id_course_id_unique` (`student_id`,`course_id`),
  KEY `student_progress_course_id_foreign` (`course_id`),
  CONSTRAINT `student_progress_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_progress_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_progress`
--

LOCK TABLES `student_progress` WRITE;
/*!40000 ALTER TABLE `student_progress` DISABLE KEYS */;
INSERT INTO `student_progress` VALUES (5,2,10,33.00,1,0,NULL,'2026-08-05 04:50:49','2026-08-06 04:01:18'),(6,2,12,0.00,0,0,NULL,'2026-08-05 05:54:49','2026-08-05 05:54:49'),(7,2,18,8.00,1,0,NULL,'2026-08-06 04:09:15','2026-08-06 06:17:30');
/*!40000 ALTER TABLE `student_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_categories`
--

DROP TABLE IF EXISTS `support_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_categories`
--

LOCK TABLES `support_categories` WRITE;
/*!40000 ALTER TABLE `support_categories` DISABLE KEYS */;
INSERT INTO `support_categories` VALUES (1,'Academic','2026-08-04 03:12:10','2026-08-04 03:12:10'),(2,'Technical','2026-08-04 03:12:10','2026-08-04 03:12:10'),(3,'Administrative','2026-08-04 03:12:10','2026-08-04 03:12:10');
/*!40000 ALTER TABLE `support_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(255) NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `assigned_to` bigint(20) unsigned DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `status` enum('pending','in_progress','resolved','closed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `support_tickets_ticket_number_unique` (`ticket_number`),
  KEY `support_tickets_student_id_foreign` (`student_id`),
  KEY `support_tickets_category_id_foreign` (`category_id`),
  KEY `support_tickets_assigned_to_foreign` (`assigned_to`),
  CONSTRAINT `support_tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `support_tickets_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `support_categories` (`id`),
  CONSTRAINT `support_tickets_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

LOCK TABLES `support_tickets` WRITE;
/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
INSERT INTO `support_tickets` VALUES (5,'TKT-1785833845',2,2,3,'Unable to Upload Assignment','I am experiencing a technical issue while trying to upload my assignment. Every time I select the file and click the upload button, the process fails and displays an \"Upload Failed\" error message. I have tried using different browsers and refreshed the page several times, but the issue persists. Please investigate and resolve this problem as soon as possible since the assignment deadline is approaching.','high','resolved','2026-08-04 05:57:25','2026-08-05 02:59:16');
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_responses`
--

DROP TABLE IF EXISTS `ticket_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_responses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ticket_responses_ticket_id_foreign` (`ticket_id`),
  KEY `ticket_responses_user_id_foreign` (`user_id`),
  CONSTRAINT `ticket_responses_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_responses`
--

LOCK TABLES `ticket_responses` WRITE;
/*!40000 ALTER TABLE `ticket_responses` DISABLE KEYS */;
INSERT INTO `ticket_responses` VALUES (2,5,3,'Thank you for reporting this issue. We have received your support request and investigated the problem. The upload service has been restored, and the issue preventing assignment uploads has been resolved. Please clear your browser cache, refresh the page, and try uploading your assignment again. If the problem continues, kindly reply to this ticket with the file type, file size, and a screenshot of the error message so we can provide further assistance. We apologize for the inconvenience and appreciate your patience.',NULL,'2026-08-05 03:00:29','2026-08-05 03:00:29');
/*!40000 ALTER TABLE `ticket_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','pending','inactive','suspended') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_student_id_unique` (`student_id`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'System Administrator','admin@lectureplatform.com',NULL,NULL,NULL,'2026-08-04 03:12:10','$2y$12$r5WgqEusjUiGLqNWcMN8gubISJnDl2haiKCMaQChg/Tz8JjZsqr6K','active','ZrFF15AerNVzpP8aHPf9QM1KZHaTYMZdGWdm85x2KrnuKBryy1Nfmnm9ENSf','2026-07-20 21:00:00','2026-08-05 03:52:11',NULL),(2,3,'Maryan Isse','maryanisse998@gmail.com',NULL,NULL,NULL,'2026-08-04 06:14:27','$2y$12$Cxwtqxp7kERLoVFQKs7YCuxkoKS1N3Zq0sAQ6FX2uMvyu0YAIT002','active','75yWMvg8vKoIYr9ZxUmuxYxK3tASz5X9FgpfcQehDR3Zp5b2PA2NmBIzoCZc','2026-07-24 21:00:00','2026-08-04 05:05:00',NULL),(3,4,'Support Staff','staff@lectureplatform.com',NULL,NULL,NULL,'2026-08-05 02:41:29','$2y$12$MgLfCdyQoaY6YpSMJTtiBut.BmtPUHc4qQRjze3gl2sGmdxi4jGfW','active','iDnUAyrRGyFXdYDfXV6GpjsQtSnxf5kKH5WbNEKTiBtB18YG2Ts1V1SEUVeC','2026-08-04 04:31:24','2026-09-15 06:21:15',NULL),(6,2,'Abdirahman Omar','sudaissd99@gmail.com',NULL,NULL,NULL,'2026-08-05 02:41:47','$2y$12$Hz9VXBxM4LfaianRj2BdYutXLfz4breIpv30ydLi7otra2W7EiCV6','active',NULL,'2026-07-29 21:00:00','2026-08-05 03:28:42','2026-08-05 03:28:42'),(10,2,'Instructor','Instructor@lectureplatform.com',NULL,NULL,NULL,NULL,'$2y$12$2P1zDquEsk.3Z2BrsrsTIO2IKygeD3/DfN61gWNXucl8x48Bosmwq','active',NULL,'2026-08-05 03:33:18','2026-09-15 06:20:42',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'lecture_platform'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-16  8:50:28
