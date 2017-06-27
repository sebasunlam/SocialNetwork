-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: socialnetwork
-- ------------------------------------------------------
-- Server version	5.7.18-log

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
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acepta` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `buscando` int(10) unsigned NOT NULL,
  `ofrecida` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cita_buscando_foreign` (`buscando`),
  KEY `cita_ofrecida_foreign` (`ofrecida`),
  CONSTRAINT `cita_buscando_foreign` FOREIGN KEY (`buscando`) REFERENCES `mascota` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cita_ofrecida_foreign` FOREIGN KEY (`ofrecida`) REFERENCES `mascota` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `departamento_provincia_id_foreign` (`provincia_id`),
  CONSTRAINT `departamento_provincia_id_foreign` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `domicilio`
--

DROP TABLE IF EXISTS `domicilio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `domicilio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `calle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` int(11) DEFAULT NULL,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  `localidad_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domicilio_perfil_id_foreign` (`perfil_id`),
  KEY `domicilio_localidad_id_foreign` (`localidad_id`),
  CONSTRAINT `domicilio_localidad_id_foreign` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`) ON DELETE CASCADE,
  CONSTRAINT `domicilio_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encontrado`
--

DROP TABLE IF EXISTS `encontrado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encontrado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contacto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aceptada` tinyint(1) DEFAULT NULL,
  `imagen_id` int(10) unsigned NOT NULL,
  `perdido_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `encontrado_imagen_id_foreign` (`imagen_id`),
  KEY `encontrado_perdido_id_foreign` (`perdido_id`),
  CONSTRAINT `encontrado_imagen_id_foreign` FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`) ON DELETE CASCADE,
  CONSTRAINT `encontrado_perdido_id_foreign` FOREIGN KEY (`perdido_id`) REFERENCES `perdido` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagen`
--

DROP TABLE IF EXISTS `imagen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagen_mascota`
--

DROP TABLE IF EXISTS `imagen_mascota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagen_mascota` (
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mascota_id` int(10) unsigned NOT NULL,
  `imagen_id` int(10) unsigned NOT NULL,
  KEY `imagen_mascota_mascota_id_foreign` (`mascota_id`),
  KEY `imagen_mascota_imagen_id_foreign` (`imagen_id`),
  CONSTRAINT `imagen_mascota_imagen_id_foreign` FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`) ON DELETE CASCADE,
  CONSTRAINT `imagen_mascota_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagen_perfil`
--

DROP TABLE IF EXISTS `imagen_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagen_perfil` (
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  `imagen_id` int(10) unsigned NOT NULL,
  KEY `imagen_perfil_perfil_id_foreign` (`perfil_id`),
  KEY `imagen_perfil_imagen_id_foreign` (`imagen_id`),
  CONSTRAINT `imagen_perfil_imagen_id_foreign` FOREIGN KEY (`imagen_id`) REFERENCES `imagen` (`id`) ON DELETE CASCADE,
  CONSTRAINT `imagen_perfil_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `localidad`
--

DROP TABLE IF EXISTS `localidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localidad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departamento_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `localidad_departamento_id_foreign` (`departamento_id`),
  CONSTRAINT `localidad_departamento_id_foreign` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mascota`
--

DROP TABLE IF EXISTS `mascota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mascota` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dia` int(11) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL,
  `anio` int(11) NOT NULL,
  `adopcion` tinyint(1) NOT NULL DEFAULT '0',
  `perdido` tinyint(1) NOT NULL DEFAULT '0',
  `cita` tinyint(1) NOT NULL DEFAULT '0',
  `perfil_id` int(10) unsigned NOT NULL,
  `sexo_id` int(10) unsigned NOT NULL,
  `tamanio_id` int(10) unsigned NOT NULL,
  `raza_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mascota_perfil_id_foreign` (`perfil_id`),
  KEY `mascota_sexo_id_foreign` (`sexo_id`),
  KEY `mascota_tamanio_id_foreign` (`tamanio_id`),
  KEY `mascota_raza_id_foreign` (`raza_id`),
  CONSTRAINT `mascota_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mascota_raza_id_foreign` FOREIGN KEY (`raza_id`) REFERENCES `raza` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mascota_sexo_id_foreign` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mascota_tamanio_id_foreign` FOREIGN KEY (`tamanio_id`) REFERENCES `tamanio` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mascota_perfil`
--

DROP TABLE IF EXISTS `mascota_perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mascota_perfil` (
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mascota_id` int(10) unsigned NOT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  KEY `mascota_perfil_perfil_id_foreign` (`perfil_id`),
  KEY `mascota_perfil_mascota_id_foreign` (`mascota_id`),
  CONSTRAINT `mascota_perfil_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mascota_perfil_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perdido`
--

DROP TABLE IF EXISTS `perdido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perdido` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  `mascota_id` int(10) unsigned NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `perdido_mascota_id_foreign` (`mascota_id`),
  CONSTRAINT `perdido_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechanacimiento` date NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `sexo_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `perfil_user_id_foreign` (`user_id`),
  KEY `perfil_sexo_id_foreign` (`sexo_id`),
  CONSTRAINT `perfil_sexo_id_foreign` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perfil_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perfil_like_post`
--

DROP TABLE IF EXISTS `perfil_like_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_like_post` (
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `coment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `like` tinyint(1) NOT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  `post_id` int(10) unsigned NOT NULL,
  KEY `perfil_like_post_perfil_id_foreign` (`perfil_id`),
  KEY `perfil_like_post_post_id_foreign_idx` (`post_id`),
  CONSTRAINT `perfil_like_post_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE,
  CONSTRAINT `perfil_like_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mascota_id` int(10) unsigned NOT NULL,
  `media_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_mascota_id_foreign` (`mascota_id`),
  KEY `post_media_id_foreign` (`media_id`),
  CONSTRAINT `post_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_media_id_foreign` FOREIGN KEY (`media_id`) REFERENCES `postmedia` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `postmedia`
--

DROP TABLE IF EXISTS `postmedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `postmedia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` tinyint(1) NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `raza`
--

DROP TABLE IF EXISTS `raza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `raza` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `raza_tipo_id_foreign` (`tipo_id`),
  CONSTRAINT `raza_tipo_id_foreign` FOREIGN KEY (`tipo_id`) REFERENCES `tipo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enum` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tamanio`
--

DROP TABLE IF EXISTS `tamanio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tamanio` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enum` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipo`
--

DROP TABLE IF EXISTS `tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `like_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transferencia`
--

DROP TABLE IF EXISTS `transferencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transferencia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `aceptada` tinyint(1) DEFAULT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  `mascota_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transferencia_perfil_id_foreign` (`perfil_id`),
  KEY `transferencia_mascota_id_foreign` (`mascota_id`),
  CONSTRAINT `transferencia_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transferencia_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `facebookId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebookToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebookRefreshToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `googleId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `googleToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `googleRefreshToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visita`
--

DROP TABLE IF EXISTS `visita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visita` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `perfil_id` int(10) unsigned NOT NULL,
  `mascota_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `visita_perfil_id_foreign` (`perfil_id`),
  KEY `visita_mascota_id_foreign` (`mascota_id`),
  CONSTRAINT `visita_mascota_id_foreign` FOREIGN KEY (`mascota_id`) REFERENCES `mascota` (`id`) ON DELETE CASCADE,
  CONSTRAINT `visita_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-27 11:03:36
