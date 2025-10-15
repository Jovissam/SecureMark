-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: securemark
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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'2025-08-14 11:12:18','moderator','joj573466@gmail.com','89ff781733da4f0a761996697d0cbc093b41d220');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lectureId` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `status` enum('present','absent') DEFAULT 'absent',
  `checkedInAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `lectureId` (`lectureId`,`studentId`),
  KEY `studentId` (`studentId`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`lectureId`) REFERENCES `lectures` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`studentId`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (11,19,1,'absent','2025-10-08 21:08:34');
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;

--
-- Table structure for table `courseregistrations`
--

DROP TABLE IF EXISTS `courseregistrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courseregistrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `studentId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `registrationDate` date DEFAULT curdate(),
  `status` enum('pending','approved') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_registration` (`studentId`,`courseId`),
  KEY `courseId` (`courseId`),
  CONSTRAINT `courseregistrations_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courseregistrations_ibfk_2` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courseregistrations`
--

/*!40000 ALTER TABLE `courseregistrations` DISABLE KEYS */;
INSERT INTO `courseregistrations` VALUES (1,1,1,'2025-08-29','approved'),(2,1,5,'2025-08-29','approved'),(3,2,1,'2025-09-11','approved'),(4,2,5,'2025-09-13','pending');
/*!40000 ALTER TABLE `courseregistrations` ENABLE KEYS */;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `facultyId` int(11) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `lecturerId` int(11) NOT NULL,
  `sessionId` int(11) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `courseTitle` varchar(50) DEFAULT NULL,
  `units` int(5) NOT NULL,
  `semester` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `facultyId` (`facultyId`),
  KEY `departmentId` (`departmentId`),
  KEY `lecturerId` (`lecturerId`),
  KEY `sessionId` (`sessionId`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`facultyId`) REFERENCES `faculties` (`id`),
  CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`departmentId`) REFERENCES `departments` (`id`),
  CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`lecturerId`) REFERENCES `lecturers` (`id`),
  CONSTRAINT `courses_ibfk_4` FOREIGN KEY (`sessionId`) REFERENCES `sessions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'2025-08-20 21:47:52',1,1,1,1,'SEN 101','Data Structures',3,'1st'),(5,'2025-08-21 20:51:17',1,1,1,2,'CSC 211','critical thinking',1,'2nd');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `facultyId` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,1,'computer Science'),(2,2,'chemistry');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculties` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `create_time` datetime DEFAULT current_timestamp() COMMENT 'Create Time',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES (1,'2025-08-12 14:29:24','computing'),(2,'2025-08-12 14:29:45','science');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `lecturerId` varchar(20) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lecturerId` (`lecturerId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturers`
--

/*!40000 ALTER TABLE `lecturers` DISABLE KEYS */;
INSERT INTO `lecturers` VALUES (1,'2025-08-14 10:56:02','12345','jovis','jovis','joj573466@gmail.com','89ff781733da4f0a761996697d0cbc093b41d220');
/*!40000 ALTER TABLE `lecturers` ENABLE KEYS */;

--
-- Table structure for table `lectures`
--

DROP TABLE IF EXISTS `lectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseId` int(11) NOT NULL,
  `lecturerId` int(11) NOT NULL,
  `topic` varchar(255) NOT NULL,
  `venue` varchar(100) NOT NULL,
  `lectureDate` date NOT NULL,
  `startTime` varchar(10) NOT NULL,
  `endTime` varchar(10) NOT NULL,
  `qrCode` varchar(255) DEFAULT NULL,
  `qrExpiresAt` int(25) DEFAULT NULL,
  `qrCodeDuration` int(11) NOT NULL,
  `qrImageUrl` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,9) DEFAULT NULL,
  `longitude` decimal(11,9) DEFAULT NULL,
  `locationRadius` decimal(10,2) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `courseId` (`courseId`),
  KEY `lecturerId` (`lecturerId`),
  CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lectures_ibfk_2` FOREIGN KEY (`lecturerId`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lectures`
--

/*!40000 ALTER TABLE `lectures` DISABLE KEYS */;
INSERT INTO `lectures` VALUES (19,5,1,'District Tactics Facilitator','Ipsum non rem.','2025-11-17','18:41','11:10','463619',1760044949,6,'assets/qrcodes/lecture_1760044589.png',4.890000000,6.980000000,0.02,'2025-10-08 21:08:34','2025-10-09 21:16:30');
/*!40000 ALTER TABLE `lectures` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (1,'2025-08-20 20:38:38','2023/2024','academic session for new student'),(2,'2025-08-20 20:38:59','2022/2023','academic'),(3,'2025-08-22 20:56:46','2024/2025','lol');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `level` int(11) DEFAULT NULL,
  `facultyId` int(11) DEFAULT NULL,
  `departmentId` int(11) DEFAULT NULL,
  `matNo` varchar(20) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` text DEFAULT NULL,
  `deviceId` text DEFAULT NULL,
  `lastChange` int(20) DEFAULT NULL,
  `pendingDevice` text DEFAULT NULL,
  `pendingDeviceChange` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `matNo` (`matNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'2025-08-13 11:05:22',400,1,1,'CMP2203102','jovis','jovis','89ff781733da4f0a761996697d0cbc093b41d220','1280x720',1755190192,NULL,NULL),(2,'2025-09-11 19:36:50',300,1,1,'CMP57755','ewe','onyekachukwu','68bcb97459232a7062a1452b56739aef23a60f38','1280x720',1757619466,NULL,NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;

--
-- Dumping routines for database 'securemark'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-10 20:59:18
