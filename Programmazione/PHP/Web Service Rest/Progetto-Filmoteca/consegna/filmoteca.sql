-- Database: filmoteca (Verifica di Recupero)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE TABLE `regista` (
  `idRegista` int(11) NOT NULL,
  `nomeRegista` varchar(100) NOT NULL,
  `nazionalita` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `regista` VALUES
(1,'Stanley Kubrick','statunitense'),
(2,'Federico Fellini','italiano'),
(3,'Akira Kurosawa','giapponese'),
(4,'Alfred Hitchcock','britannico'),
(5,'Francis Ford Coppola','statunitense'),
(6,'Ingmar Bergman','svedese'),
(7,'Martin Scorsese','statunitense'),
(8,'Andrej Tarkovskij','russo'),
(9,'Billy Wilder','austriaco'),
(10,'Sergio Leone','italiano');

CREATE TABLE `genere` (
  `idGenere` int(11) NOT NULL,
  `nomeGenere` varchar(100) NOT NULL,
  `descrizione` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `genere` VALUES
(1,'Fantascienza','Speculazione tecnologica e futuristica'),
(2,'Drammatico','Narrazione incentrata sul conflitto interiore'),
(3,'Thriller','Tensione e suspense come motori narrativi'),
(4,'Crime','Crimini, gangster e giustizia'),
(5,'Guerra','Conflitti armati e conseguenze umane'),
(6,'Western','Frontiera americana e legge del più forte');

CREATE TABLE `film` (
  `idFilm` int(11) NOT NULL,
  `titoloFilm` varchar(100) NOT NULL,
  `anno` int(11) NOT NULL,
  `idRegista` int(11) NOT NULL,
  `idGenere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `film` VALUES
(1,'2001: Odissea nello spazio',1968,1,1),
(2,'8½',1963,2,2),
(3,'I sette samurai',1954,3,2),
(4,'La finestra sul cortile',1954,4,3),
(5,'Il Padrino',1972,5,4),
(6,'Il settimo sigillo',1957,6,2),
(7,'Taxi Driver',1976,7,4),
(8,'Stalker',1979,8,1),
(9,'A qualcuno piace caldo',1959,9,2),
(10,'C era una volta il West',1968,10,6);

CREATE TABLE `raccolta` (
  `idRaccolta` int(11) NOT NULL,
  `nomeRaccolta` varchar(100) NOT NULL,
  `tema` varchar(100) NOT NULL,
  `curatore` varchar(100) NOT NULL,
  `prezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `raccolta` VALUES
(1,'Capolavori del Novecento','Regia d\'autore classica','Cineteca Milano',25),
(2,'Maestri del noir e del crime','Crimine e societa','Midnight Club',20),
(3,'Cinema e filosofia','Esistenza e trascendenza','Universita di Parma',30),
(4,'Visioni di futuro','Fantascienza d\'autore','Fantascienza d\'autore',18),
(5,'Il cinema italiano','Produzione nazionale','Istituto Luce',22);

CREATE TABLE `include` (
  `nroProgressivo` int(11) NOT NULL,
  `idRaccolta` int(11) NOT NULL,
  `idFilm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `include` VALUES
(1,1,1),(2,1,3),(3,1,6),(4,1,10),
(5,2,4),(6,2,5),(7,2,7),
(8,3,2),(9,3,6),(10,3,8),
(11,4,1),(12,4,8),
(13,5,2),(14,5,9),(15,5,10);

ALTER TABLE `regista` ADD PRIMARY KEY (`idRegista`);
ALTER TABLE `genere`  ADD PRIMARY KEY (`idGenere`);
ALTER TABLE `film`    ADD PRIMARY KEY (`idFilm`),
  ADD KEY `FK_REGISTA` (`idRegista`), ADD KEY `FK_GENERE` (`idGenere`);
ALTER TABLE `raccolta` ADD PRIMARY KEY (`idRaccolta`);
ALTER TABLE `include`  ADD PRIMARY KEY (`nroProgressivo`),
  ADD KEY `FK_RACCOLTA` (`idRaccolta`), ADD KEY `FK_FILM` (`idFilm`);

ALTER TABLE `regista`  MODIFY `idRegista`  int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `genere`   MODIFY `idGenere`   int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `film`     MODIFY `idFilm`     int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `raccolta` MODIFY `idRaccolta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `include`  MODIFY `nroProgressivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `film`
  ADD CONSTRAINT `FK_REGISTA` FOREIGN KEY (`idRegista`) REFERENCES `regista` (`idRegista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GENERE`  FOREIGN KEY (`idGenere`)  REFERENCES `genere`  (`idGenere`)  ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `include`
  ADD CONSTRAINT `FK_RACCOLTA` FOREIGN KEY (`idRaccolta`) REFERENCES `raccolta` (`idRaccolta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_FILM`     FOREIGN KEY (`idFilm`)     REFERENCES `film`     (`idFilm`)     ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;
