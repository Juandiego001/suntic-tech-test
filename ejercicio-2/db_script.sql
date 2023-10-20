CREATE DATABASE `datosdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

-- datosdb.informacion definition

CREATE TABLE `informacion` (
  `codigo` int NOT NULL AUTO_INCREMENT,
  `nombrearchivo` varchar(250) NOT NULL,
  `cantlineas` int NOT NULL,
  `cantpalabras` int NOT NULL,
  `cantcaracteres` int NOT NULL,
  `fecharegistro` date NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;