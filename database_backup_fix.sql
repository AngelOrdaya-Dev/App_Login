-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: applogin
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
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `status` enum('presente','ausente','tardanza') NOT NULL DEFAULT 'presente',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `attendances_user_id_course_id_date_unique` (`user_id`,`course_id`,`date`),
  KEY `attendances_course_id_foreign` (`course_id`),
  CONSTRAINT `attendances_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_logs`
--

LOCK TABLES `audit_logs` WRITE;
/*!40000 ALTER TABLE `audit_logs` DISABLE KEYS */;
INSERT INTO `audit_logs` VALUES (1,5,'Registro de Docente','Se registró al docente Mauricio Alva (maurialva33@senati.pe)','132.191.0.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','2026-05-10 04:28:46','2026-05-10 04:28:46'),(2,5,'Registro de Docente','Se registró al docente Leonard vidal (leovidal22@senati.pe)','132.191.0.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','2026-05-10 04:32:52','2026-05-10 04:32:52'),(3,5,'Registro de Docente','Se registró al docente Edgar Carrillo (Eddycarrillo44@senati.pe)','132.191.0.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','2026-05-10 04:36:46','2026-05-10 04:36:46'),(4,5,'Aprobación de Pago','Se aprobó el pago de S/ 50.00 del usuario Angel Ordaya','132.191.0.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','2026-05-10 09:02:01','2026-05-10 09:02:01');
/*!40000 ALTER TABLE `audit_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `careers`
--

DROP TABLE IF EXISTS `careers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `careers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `careers`
--

LOCK TABLES `careers` WRITE;
/*!40000 ALTER TABLE `careers` DISABLE KEYS */;
INSERT INTO `careers` VALUES (1,'Informática y Desarrollo de Aplicaciones Web','2026-05-07 05:47:48','2026-05-07 05:47:48'),(2,'Ingeniería de Sistemas','2026-05-07 05:47:48','2026-05-07 05:47:48'),(3,'Diseño Gráfico y Multimedia','2026-05-07 05:47:48','2026-05-07 05:47:48'),(4,'Administración de Negocios Internacionales','2026-05-07 05:47:48','2026-05-07 05:47:48'),(5,'Psicología Organizacional','2026-05-07 05:47:48','2026-05-07 05:47:48'),(6,'Contabilidad y Finanzas','2026-05-07 05:47:48','2026-05-07 05:47:48'),(7,'Derecho y Ciencias Políticas','2026-05-07 05:47:48','2026-05-07 05:47:48'),(8,'Arquitectura y Urbanismo','2026-05-07 05:47:48','2026-05-07 05:47:48'),(9,'Ingeniería Civil','2026-05-07 05:47:48','2026-05-07 05:47:48'),(10,'Marketing y Gestión Comercial','2026-05-07 05:47:48','2026-05-07 05:47:48');
/*!40000 ALTER TABLE `careers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classrooms`
--

DROP TABLE IF EXISTS `classrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classrooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 30,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classrooms`
--

LOCK TABLES `classrooms` WRITE;
/*!40000 ALTER TABLE `classrooms` DISABLE KEYS */;
INSERT INTO `classrooms` VALUES (1,'Aula 1',30,1,'2026-05-07 02:08:28','2026-05-07 02:08:28'),(2,'Aula 2',30,1,'2026-05-07 02:08:28','2026-05-07 02:08:28'),(3,'Aula 3',30,1,'2026-05-07 02:08:28','2026-05-07 02:08:28'),(4,'Aula 4',30,1,'2026-05-07 02:08:28','2026-05-07 02:08:28'),(5,'Aula 5',30,1,'2026-05-07 02:08:28','2026-05-07 02:08:28'),(6,'Aula 6',30,1,'2026-05-09 11:00:31','2026-05-09 11:00:31'),(8,'Aula 7',30,1,'2026-05-09 11:09:39','2026-05-09 11:09:39'),(9,'Aula 8',30,1,'2026-05-09 11:09:59','2026-05-09 11:09:59'),(10,'Aula 9',30,1,'2026-05-09 11:10:13','2026-05-09 11:10:13');
/*!40000 ALTER TABLE `classrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `career_id` bigint(20) unsigned NOT NULL,
  `credits` int(11) NOT NULL DEFAULT 4,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `teacher_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_career_id_foreign` (`career_id`),
  KEY `courses_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `courses_career_id_foreign` FOREIGN KEY (`career_id`) REFERENCES `careers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'Algoritmos y Estructura de Datos',1,5,'2026-05-09 02:01:22','2026-05-10 04:33:15',13),(2,'Base de Datos I',1,4,'2026-05-09 02:01:22','2026-05-10 04:30:58',12),(3,'Desarrollo Web Fullstack',1,6,'2026-05-09 02:01:22','2026-05-10 03:11:45',9),(4,'Matemática Discreta',1,4,'2026-05-09 02:01:22','2026-05-10 04:37:08',14);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `career_id` bigint(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `enrollments_user_id_foreign` (`user_id`),
  KEY `enrollments_career_id_foreign` (`career_id`),
  CONSTRAINT `enrollments_career_id_foreign` FOREIGN KEY (`career_id`) REFERENCES `careers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

LOCK TABLES `enrollments` WRITE;
/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
INSERT INTO `enrollments` VALUES (3,1,4,'reingreso','pending','2026-05-09 11:12:53','2026-05-09 11:12:53'),(4,1,1,'regular','pending','2026-05-10 08:27:43','2026-05-10 08:27:43');
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_user_id_foreign` (`user_id`),
  KEY `grades_course_id_foreign` (`course_id`),
  CONSTRAINT `grades_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `grades_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (5,1,1,20.00,'pass','2026-05-09 04:47:00','2026-05-09 04:47:00'),(6,2,4,16.00,'pass','2026-05-09 11:34:09','2026-05-09 11:34:09'),(7,3,2,14.00,'pass','2026-05-09 22:10:22','2026-05-09 22:10:22');
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
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
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_course_id_foreign` (`course_id`),
  KEY `materials_user_id_foreign` (`user_id`),
  CONSTRAINT `materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (1,'Tarea Pendiente','/storage/materials/ij22JsA8sRlNiC14Nb2rONS6zfyY1C1NMLGZKYak.pdf','Guía',2,5,'2026-05-10 01:55:40','2026-05-10 01:55:40');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0000_01_01_000000_create_careers_table',1),(2,'0001_01_01_000000_create_users_table',1),(3,'0001_01_01_000001_create_cache_table',1),(4,'0001_01_01_000002_create_jobs_table',1),(5,'2026_05_07_005944_add_avatar_to_users_table',2),(6,'2026_05_07_020252_create_classrooms_table',3),(7,'2026_05_07_041057_create_notifications_table',4),(8,'2026_05_08_011706_add_social_ids_to_users_table',5),(9,'2026_05_08_180442_add_notifications_enabled_to_users_table',6),(10,'2026_05_08_202930_add_role_to_users_table',7),(11,'2026_05_08_203631_create_payments_table',8),(12,'2026_05_08_203632_create_enrollments_table',8),(13,'2026_05_08_205756_create_courses_table',9),(14,'2026_05_08_205758_create_grades_table',9),(15,'2026_05_08_210222_add_two_factor_to_users_table',10),(16,'2026_05_09_062920_add_user_id_to_notifications_table',11),(17,'2026_05_09_185833_add_teacher_id_to_courses_table',12),(18,'2026_05_09_192227_create_schedules_table',13),(19,'2026_05_09_192229_create_attendances_table',13),(20,'2026_05_09_193709_create_audit_logs_table',14),(21,'2026_05_09_201915_add_two_factor_enabled_to_users_table',15),(22,'2026_05_09_204253_create_materials_table',16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'info',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'Sistema Actualizado','Bienvenido al nuevo panel administrativo premium.','success',0,'2026-05-07 09:14:41','2026-05-07 09:14:41',NULL),(2,'Nueva Carrera','Se ha añadido la carrera de Diseño Gráfico.','info',1,'2026-05-07 09:14:41','2026-05-09 01:17:27',NULL),(3,'Recordatorio','Recuerda revisar la lista de matrículas pendientes.','warning',1,'2026-05-07 09:14:41','2026-05-09 04:24:44',NULL),(4,'Estudiante Eliminado','Se ha eliminado el registro de Test User del sistema.','warning',1,'2026-05-07 10:04:08','2026-05-08 23:47:16',NULL),(5,'Estudiante Eliminado','Se ha eliminado el registro de Leo Blanck del sistema.','warning',1,'2026-05-07 20:52:55','2026-05-08 23:47:12',NULL),(6,'Estudiante Eliminado','Se ha eliminado el registro de Ordaya Blanck del sistema.','warning',1,'2026-05-08 01:57:12','2026-05-08 23:28:28',NULL),(7,'Carrera Asignada','Te has inscrito exitosamente en la carrera de Psicología Organizacional.','success',1,'2026-05-09 01:19:00','2026-05-09 01:21:36',NULL),(8,'Carrera Asignada','Te has inscrito exitosamente en la carrera de Marketing y Gestión Comercial.','success',1,'2026-05-09 01:19:50','2026-05-09 01:21:38',NULL),(9,'Código de Verificación (Social)','Tu código de acceso es: 997847','warning',1,'2026-05-09 02:10:33','2026-05-09 02:36:12',NULL),(10,'Código de Verificación (Social)','Tu código de acceso es: 109939','warning',1,'2026-05-09 02:11:21','2026-05-09 02:36:09',NULL),(11,'Código de Verificación (Social)','Tu código de acceso es: 574086','warning',1,'2026-05-09 02:11:47','2026-05-09 02:36:06',NULL),(12,'Código de Verificación (Social)','Tu código de acceso es: 290140','warning',1,'2026-05-09 02:13:04','2026-05-09 02:36:03',NULL),(13,'Acceso Autorizado','Has verificado tu identidad correctamente.','success',1,'2026-05-09 02:18:15','2026-05-09 11:27:25',NULL),(14,'Código de Verificación (Social)','Tu código de acceso es: 118473','warning',1,'2026-05-09 03:04:43','2026-05-09 04:24:33',NULL),(15,'Acceso Autorizado','Has verificado tu identidad correctamente.','success',1,'2026-05-09 03:04:58','2026-05-09 04:24:28',NULL),(16,'Código de Verificación (Social)','Tu código de acceso es: 845471','warning',1,'2026-05-09 04:26:01','2026-05-09 11:27:11',NULL),(17,'Nueva Calificación','Se ha publicado una nueva nota en el curso de Algoritmos y Estructura de Datos','info',1,'2026-05-09 04:47:00','2026-05-09 11:27:08',NULL),(18,'Nueva Aula Creada','Se ha habilitado el aula Aula 7 con capacidad para 30 alumnos.','success',1,'2026-05-09 11:00:31','2026-05-09 11:11:41',NULL),(19,'Nueva Aula Creada','Se ha habilitado el aula Aula 7 con capacidad para 30 alumnos.','success',1,'2026-05-09 11:09:39','2026-05-09 11:11:37',NULL),(20,'Nueva Aula Creada','Se ha habilitado el aula Aula 8 con capacidad para 30 alumnos.','success',1,'2026-05-09 11:09:59','2026-05-09 11:11:43',NULL),(21,'Nueva Aula Creada','Se ha habilitado el aula Aula 9 con capacidad para 30 alumnos.','success',1,'2026-05-09 11:10:13','2026-05-09 11:11:34',NULL),(22,'Trámite Iniciado','Tu solicitud de reingreso ha sido enviada correctamente.','info',1,'2026-05-09 11:12:53','2026-05-09 11:27:04',NULL),(23,'Pago Confirmado','Tu pago por \'Derecho de Reingreso (#INS-00003)\' ha sido aprobado exitosamente.','success',1,'2026-05-09 11:17:20','2026-05-09 11:26:52',NULL),(24,'Nueva Calificación','Se ha publicado una nueva nota en el curso de Matemática Discreta','info',0,'2026-05-09 11:34:09','2026-05-09 11:34:09',2),(25,'Nueva Calificación','Se ha publicado una nueva nota en el curso de Base de Datos I','info',0,'2026-05-09 22:10:22','2026-05-09 22:10:22',3),(26,'Nuevo Docente','Se ha registrado al docente Giancarlos Barboza en el sistema.','success',0,'2026-05-10 00:07:30','2026-05-10 00:07:30',NULL),(27,'Carrera Asignada','Te has inscrito exitosamente en la carrera de Ingeniería de Sistemas.','success',0,'2026-05-10 00:59:52','2026-05-10 00:59:52',NULL),(28,'Carrera Asignada','Te has inscrito exitosamente en la carrera de Derecho y Ciencias Políticas.','success',0,'2026-05-10 01:08:17','2026-05-10 01:08:17',NULL),(29,'Acceso Autorizado','Has verificado tu identidad correctamente.','success',0,'2026-05-10 01:37:11','2026-05-10 01:37:11',10),(30,'Nuevo Código 2FA','Tu nuevo código de verificación es: 347155','info',0,'2026-05-10 01:38:25','2026-05-10 01:38:25',10),(31,'Acceso Autorizado','Has verificado tu identidad correctamente.','success',0,'2026-05-10 01:39:19','2026-05-10 01:39:19',10),(32,'Seguridad Actualizada','Tu contraseña ha sido cambiada exitosamente.','success',0,'2026-05-10 02:38:51','2026-05-10 02:38:51',NULL),(33,'Perfil Actualizado','Los datos de tu perfil han sido modificados exitosamente.','success',0,'2026-05-10 02:39:23','2026-05-10 02:39:23',NULL),(34,'Seguridad Actualizada','Tus preferencias de seguridad han sido actualizadas.','success',0,'2026-05-10 03:38:52','2026-05-10 03:38:52',NULL),(35,'Nuevo Docente','Se ha registrado al docente Mauricio Alva en el sistema.','success',0,'2026-05-10 04:28:46','2026-05-10 04:28:46',NULL),(36,'Nuevo Docente','Se ha registrado al docente Leonard vidal en el sistema.','success',0,'2026-05-10 04:32:52','2026-05-10 04:32:52',NULL),(37,'Nuevo Docente','Se ha registrado al docente Edgar Carrillo en el sistema.','success',0,'2026-05-10 04:36:46','2026-05-10 04:36:46',NULL),(38,'Seguridad Actualizada','Tus preferencias de seguridad han sido actualizadas.','success',0,'2026-05-10 04:46:11','2026-05-10 04:46:11',NULL),(39,'Perfil Actualizado','Los datos de tu perfil han sido modificados exitosamente.','success',0,'2026-05-10 04:47:15','2026-05-10 04:47:15',NULL),(40,'Perfil Actualizado','Los datos de tu perfil han sido modificados exitosamente.','success',0,'2026-05-10 04:53:31','2026-05-10 04:53:31',NULL),(41,'Trámite Iniciado','Tu solicitud de regular ha sido enviada correctamente.','info',0,'2026-05-10 08:27:43','2026-05-10 08:27:43',1),(42,'Pago Confirmado','Tu pago por \'Derecho de Regular (#INS-00004)\' ha sido aprobado exitosamente.','success',0,'2026-05-10 09:01:53','2026-05-10 09:01:53',1);
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
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_user_id_foreign` (`user_id`),
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (3,1,50.00,'Derecho de Reingreso (#INS-00003)','paid',NULL,'2026-05-09 11:12:53','2026-05-09 11:17:20'),(4,2,150.00,'Derecho de Matrícula Regular 2026-I','paid',NULL,'2026-05-09 11:20:14','2026-05-09 11:20:14'),(5,3,150.00,'Derecho de Matrícula Regular 2026-I','paid',NULL,'2026-05-09 11:20:14','2026-05-09 11:20:14'),(6,4,150.00,'Derecho de Matrícula Regular 2026-I','paid',NULL,'2026-05-09 11:20:14','2026-05-09 11:20:14'),(7,1,50.00,'Derecho de Regular (#INS-00004)','paid',NULL,'2026-05-10 08:27:43','2026-05-10 09:01:53');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `classroom_id` bigint(20) unsigned NOT NULL,
  `day_of_week` tinyint(4) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schedules_classroom_id_day_of_week_start_time_unique` (`classroom_id`,`day_of_week`,`start_time`),
  KEY `schedules_course_id_foreign` (`course_id`),
  CONSTRAINT `schedules_classroom_id_foreign` FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,3,1,1,'13:30:00','17:30:00','2026-05-10 03:19:56','2026-05-10 03:19:56'),(2,3,1,3,'13:30:00','17:30:00','2026-05-10 03:19:56','2026-05-10 03:19:56'),(3,3,1,4,'13:30:00','17:30:00','2026-05-10 03:19:56','2026-05-10 03:19:56');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('5h1LGt4T5T4J2oRGOp25Fa1g1RW6Tvdg9Etf0uXO',5,'132.191.0.46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSm9ZTjZ6S0dndjVob2pBMGZwbzBpQ2pkTkNZYkduaWdVWlZXd1lvciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8veWluLXByb3VkLXdhc2hvdXQubmdyb2stZnJlZS5kZXYiO3M6NToicm91dGUiO047fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',1778385725),('71aqrxMVhK7YMqFaw5mH7j1VxxwDzf9xRLtXpUHa',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoidTVxOGtjTkx3OHRTMktKeVBuTUhaampmY0t6MkJaOXhYc1dieUd0RCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1778384538),('EGzOAF1idZCoDhQSBQo1Zduiha04gB5bu49qJSUN',NULL,'::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSEVEbUZNRzVXeHlaT3Q5dE9GNlVpa09zZDltUTFUODNpcm80TE1ncSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3QvQXBwX0xvZ2luL3B1YmxpYy9yZWdpc3RlciI7czo1OiJyb3V0ZSI7czo4OiJyZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1778384428);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `github_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `career_id` bigint(20) unsigned DEFAULT NULL,
  `notifications_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `terms_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `two_factor_code` varchar(255) DEFAULT NULL,
  `two_factor_expires_at` datetime DEFAULT NULL,
  `two_factor_enabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_career_id_foreign` (`career_id`),
  CONSTRAINT `users_career_id_foreign` FOREIGN KEY (`career_id`) REFERENCES `careers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'114570769998682121659',NULL,'243662227','https://lh3.googleusercontent.com/a/ACg8ocKEL48FyuWa4O6iZZpae38vyOz5Olq3P6ODUIoENXSvjqGKy7MLVg=s96-c','Angel Ordaya','xdangel755@gmail.com','student',NULL,NULL,1,1,1,NULL,'2026-05-07 05:41:23','2026-05-10 03:38:52','574086','2026-05-08 21:21:47',1),(2,'115773194682015658667',NULL,NULL,'https://lh3.googleusercontent.com/a/ACg8ocJtMjgNGtR_AdcrgSnLlYCYpC9xeUYfmaluiM0SkM4e8zt9Rg=s96-c','Leo Blanck','leoblanck5@gmail.com','student',NULL,NULL,10,1,1,NULL,'2026-05-07 21:00:40','2026-05-09 01:19:50','845471','2026-05-08 23:36:01',0),(3,NULL,NULL,NULL,NULL,'Lian','Lian12@gmail.com','student',NULL,'$2y$12$iNKvpkgh5AncjmWOsKTqH.5X9QGwQBRhXpFvcOEr70KqIz8FEUczG',9,1,1,NULL,'2026-05-07 21:20:02','2026-05-07 21:20:02',NULL,NULL,0),(4,NULL,NULL,NULL,NULL,'Alex Huari','alex12@gmail.com','student',NULL,'$2y$12$rAed.yF6knfEiOyIVKRaPuolV6pMPTBK06DPVYWlSx2T8MCLd0ixa',6,1,1,NULL,'2026-05-07 21:24:35','2026-05-07 21:24:35',NULL,NULL,0),(5,NULL,'2151469258753273',NULL,'https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=2151469258753273&width=1920&ext=1780977661&hash=AfuTJZ0WKDHwuroo3NH_kzHX','Angel TR','angel1120171@hotmail.com','admin',NULL,NULL,NULL,1,1,NULL,'2026-05-08 08:51:44','2026-05-10 09:01:03',NULL,NULL,1),(9,NULL,NULL,NULL,NULL,'Giancarlos Barboza','giancarlos26@senati.pe','teacher',NULL,'$2y$12$L9REQGFPFwyicVMbPkiBOewZIt8KZVItIjSuUjpO6eQ2646UIcBJe',NULL,1,1,NULL,'2026-05-10 00:07:29','2026-05-10 02:38:51',NULL,NULL,0),(10,'115952303876328315660',NULL,NULL,'https://lh3.googleusercontent.com/a/ACg8ocIpoB9iIzhUuVaJGSOHriUi32JtNNWW5Z4RV-NLfP55mTxu0A=s96-c','Ricardo Huamanculi','ricardohuamanculi@gmail.com','student',NULL,'$2y$12$282nhf5gzDvT4Q6yoMNtK.8aybwtvk8zBRt4ifrjmG6eo/RdSSRR.',2,1,1,NULL,'2026-05-10 00:59:28','2026-05-10 01:29:47',NULL,NULL,1),(11,'106735849986725118835',NULL,NULL,'https://lh3.googleusercontent.com/a/ACg8ocLv7hiQQewD4CFzfaKggZX1bif5t02LKqGLUl5bvl5XL5GlIQ=s96-c','Ordaya Blanck','ordayablanck@gmail.com','student',NULL,NULL,7,1,1,NULL,'2026-05-10 01:06:17','2026-05-10 01:08:17',NULL,NULL,0),(12,NULL,NULL,NULL,NULL,'Mauricio Alva','maurialva33@senati.pe','teacher',NULL,'$2y$12$6z75hXj6uBIRvVs9/mye.eZg2/cV/uYDzc33515431ugwmg3vGxyi',NULL,1,1,NULL,'2026-05-10 04:28:46','2026-05-10 04:28:46',NULL,NULL,0),(13,NULL,NULL,NULL,NULL,'Leonard vidal','leovidal22@senati.pe','teacher',NULL,'$2y$12$8zmfH6KhX5Um5UpQIxjbQOpiGJfzm35QAYd2a33Z/Nl1BA6LmjVXu',NULL,1,1,NULL,'2026-05-10 04:32:52','2026-05-10 04:32:52',NULL,NULL,0),(14,NULL,NULL,NULL,NULL,'Edgar Carrillo','Eddycarrillo44@senati.pe','teacher',NULL,'$2y$12$zBp1URbVdQGZYbxHy.VBbu8cIXc/ZT8I/0sRQgTh0AAX1V/bcBRLq',NULL,1,1,NULL,'2026-05-10 04:36:46','2026-05-10 04:36:46',NULL,NULL,0);
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

-- Dump completed on 2026-05-09 23:48:18
