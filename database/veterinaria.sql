-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: veterinaria
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `animales`
--
create database veterinaria;
use veterinaria;
DROP TABLE IF EXISTS `animales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `animales` (
  `NumHistorial` int(50) NOT NULL AUTO_INCREMENT,
  `NomAnimal` varchar(50) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`NumHistorial`),
  KEY `idTipo` (`idTipo`),
  KEY `idCliente` (`idCliente`),
  CONSTRAINT `animales_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipoanimal` (`idTipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `animales_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animales`
--

LOCK TABLES `animales` WRITE;
/*!40000 ALTER TABLE `animales` DISABLE KEYS */;
INSERT INTO `animales` VALUES (1,'África',1,1),(2,'Samba',1,2),(3,'Coronel',3,8),(4,'Lluvia',3,2),(5,'Manchado',3,10),(6,'Tod',2,9),(7,'Greñas',3,8),(8,'Selva',1,3),(9,'Tranquilo',1,4),(10,'Brandy',2,4),(11,'Bolita',1,7),(12,'Jazz',1,7),(13,'Granadina',3,4),(14,'Loco',5,10),(15,'Flaco',2,6),(16,'Blas',2,5),(17,'Homer',1,2),(18,'Peleón',1,8),(19,'Rubio',2,9),(20,'Tequila',3,10),(21,'Sirio',4,6),(22,'Bicho',1,7),(23,'Bruno',1,7),(24,'Kara',2,2),(25,'Tormenta',5,6),(26,'Miel',5,4),(27,'Lola',4,7),(28,'Pepa',4,9);
/*!40000 ALTER TABLE `animales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citas`
--

DROP TABLE IF EXISTS `citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `citas` (
  `fecha` date NOT NULL,
  `idIntervalo` int(11) NOT NULL,
  `NumHistorial` int(50) DEFAULT NULL,
  PRIMARY KEY (`idIntervalo`,`fecha`) USING BTREE,
  KEY `numHistorial` (`NumHistorial`),
  KEY `idIntervalo` (`idIntervalo`),
  KEY `numHistorial_2` (`NumHistorial`),
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idIntervalo`) REFERENCES `intervalos` (`idIntervalo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`NumHistorial`) REFERENCES `animales` (`NumHistorial`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citas`
--

LOCK TABLES `citas` WRITE;
/*!40000 ALTER TABLE `citas` DISABLE KEYS */;
INSERT INTO `citas` VALUES ('2022-04-18',1,3),('2022-04-18',8,12),('2022-04-19',3,13),('2022-04-21',6,16),('2022-04-21',8,18),('2022-04-20',10,26),('2022-04-27',1,28);
/*!40000 ALTER TABLE `citas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `NIF` varchar(50) DEFAULT NULL,
  `NomCliente` varchar(50) NOT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `foto` varchar(256) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `token` varchar(255) DEFAULT 'nada',
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'03805585-M','ANA','FERNÁNDEZ CARRASCOSO','1.jpg','ana@gmail.com',1,'nada'),(2,'05240102-N ','MANUEL','JIMÉNEZ GARCÍA','2.jpg','manuel@gmail.com',1,'nada'),(3,'50035977-Y ','LUIS','FERNÁNDEZ OLIVA','3.jpg','luis@gmail.com',1,'nada'),(4,'50717522-S ','PILAR ','ALBERT GARCÍA','4.jpg','pilar@gmail.com',1,'nada'),(5,'50303441-A','TOMÁS ','ALCUDIA MONTES','5.jpg','tomas@gmail.com',1,'nada'),(6,'50675608-F','CARMEN','MAQUEDANO GARRIDO','6.jpg','carmen@gmail.com',1,'nada'),(7,'50851663-C ','ROSARIO','MIRANZO HUERTA','7.jpg','rosario@gmail.com',1,'nada'),(8,'51907931-J ','MILAGROS','MONTES PÉREZ','8.jpg','milagros@gmail.com',1,'nada'),(9,'11909049-V','MIGUEL','RÍOS SÁNZ','9.jpg','miguel@gmail.com',1,'nada'),(10,'12360532-X','FRANCISCO','CABALLERO TALAVERA','10.jpg','francisco@gmail.com',1,'nada');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotosani`
--

DROP TABLE IF EXISTS `fotosani`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fotosani` (
  `idfoto` int(11) NOT NULL AUTO_INCREMENT,
  `NumHistorial` int(50) NOT NULL,
  `nombreFoto` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idfoto`),
  KEY `numhistorial` (`NumHistorial`),
  CONSTRAINT `fotosAnimales_ibfk_1` FOREIGN KEY (`NumHistorial`) REFERENCES `animales` (`NumHistorial`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotosani`
--

LOCK TABLES `fotosani` WRITE;
/*!40000 ALTER TABLE `fotosani` DISABLE KEYS */;
INSERT INTO `fotosani` VALUES (1,1,'africa1.jpg'),(2,1,'africa2.jpg'),(3,1,'africa3.jpg'),(4,14,'loco1.jpg'),(5,14,'loco2.jpg'),(6,15,'flaco2.jpg'),(7,15,'flaco1.jpg'),(8,28,'pepa1.jpg'),(9,22,'bicho1.jpg'),(10,16,'blas1.jpg'),(11,11,'bolita1.jpg'),(12,3,'coronel1.jpg'),(13,13,'granadina1.jpg'),(14,7,'grennas1.jpg'),(15,17,'homer1.jpg'),(16,12,'jazz1.jpg'),(17,24,'kara1.jpg'),(18,27,'lola1.jpg'),(19,4,'lluvia1.jpg'),(20,5,'manchado1.jpg'),(21,26,'miel1.jpg'),(22,18,'peleon1.jpg'),(23,19,'rubio1.jpg'),(24,20,'tequila1.jpg'),(25,2,'samba1.jpg'),(26,6,'tod1.jpg'),(27,8,'selva1.jpg'),(28,9,'tranquilo1.jpg'),(29,10,'brandy1.jpg'),(30,21,'sirio1.jpg'),(31,23,'bruno1.jpg'),(32,26,'miel2.jgp'),(33,25,'tormenta1.jpg'),(34,25,'tormenta2.jpg'),(35,19,'rubio1.jpg');
/*!40000 ALTER TABLE `fotosani` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intervalos`
--

DROP TABLE IF EXISTS `intervalos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intervalos` (
  `idIntervalo` int(11) NOT NULL AUTO_INCREMENT,
  `texto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idIntervalo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intervalos`
--

LOCK TABLES `intervalos` WRITE;
/*!40000 ALTER TABLE `intervalos` DISABLE KEYS */;
INSERT INTO `intervalos` VALUES (1,'10:00 - 10:30'),(2,'10:30 - 11:00'),(3,'11:00 - 11:30'),(4,'11:30 - 12:00'),(5,'12:00 - 12:30'),(6,'13:00 - 13:30'),(7,'13:30 - 14:00'),(8,'16:00 - 16:30'),(9,'17:00 - 17:30'),(10,'17:30 - 18:30');
/*!40000 ALTER TABLE `intervalos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoanimal`
--

DROP TABLE IF EXISTS `tipoanimal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoanimal` (
  `idTipo` int(11) NOT NULL AUTO_INCREMENT,
  `NombreTipo` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idTipo`),
  KEY `idTipo` (`idTipo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoanimal`
--

LOCK TABLES `tipoanimal` WRITE;
/*!40000 ALTER TABLE `tipoanimal` DISABLE KEYS */;
INSERT INTO `tipoanimal` VALUES (1,'Perro'),(2,'Gato'),(3,'Caballo'),(4,'Conejo'),(5,'Pájaro');
/*!40000 ALTER TABLE `tipoanimal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `validar`
--

DROP TABLE IF EXISTS `validar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validar` (
  `idcliente` int(11) NOT NULL,
  `clave` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `alias` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idcliente`),
  CONSTRAINT `validar_ibfk_1` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `validar`
--

LOCK TABLES `validar` WRITE;
/*!40000 ALTER TABLE `validar` DISABLE KEYS */;
INSERT INTO `validar` VALUES (1,'$2y$10$sOaXP.tCjNLA2h0RGwxTDeoLclq.la4h/dASLhH.B.pjjqCb9vIPm','uno'),(2,'$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu','dos'),(3,'$2y$10$MZGP/jqD/qrRirIw0bWG8OdUcXPTbcVbQa4vC7r8bFkE7NR6RrLWK','tres'),(4,'$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu','cuatro'),(5,'$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu','cinco'),(6,'$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu','seis'),(7,'$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu','siete'),(8,'$2y$10$.lZ/nIfDiHlE1WbBRA.CKesoysyRDNVQcrxDCPcrvLA4kavgt76cu','ocho'),(9,'$2y$10$FfPT4XkJRwc5qDRYeiJUduUEzd74fmxtPAi68V16PUP0VsIdMhWm2','nueve'),(10,'$2y$10$7s94vYzxYDI1Qk8TPbCGvOK8jbqCA6H4pB4TJLRgBVEj6YsDvVkNC','diez');
/*!40000 ALTER TABLE `validar` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-21 14:03:59
