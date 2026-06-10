-- Database: videogiochi (Seconda Verifica di Recupero)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

CREATE TABLE `sviluppatore` (
  `idSviluppatore` int(11) NOT NULL,
  `nomeSviluppatore` varchar(100) NOT NULL,
  `nazione` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sviluppatore` VALUES
(1,'Nintendo','Giappone'),
(2,'FromSoftware','Giappone'),
(3,'CD Projekt Red','Polonia'),
(4,'Naughty Dog','USA'),
(5,'Valve','USA'),
(6,'Rockstar Games','USA'),
(7,'Blizzard Entertainment','USA'),
(8,'Bethesda Softworks','USA'),
(9,'Ubisoft','Francia'),
(10,'Konami','Giappone');

CREATE TABLE `genere` (
  `idGenere` int(11) NOT NULL,
  `nomeGenere` varchar(100) NOT NULL,
  `descrizione` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `genere` VALUES
(1,'Action RPG','Gioco di ruolo con combattimento in tempo reale'),
(2,'Avventura','Esplorazione e narrazione come elementi centrali'),
(3,'FPS','Sparatutto in prima persona'),
(4,'Open World','Mondo aperto con liberta di esplorazione'),
(5,'Survival Horror','Tensione, risorse limitate e atmosfera opprimente'),
(6,'Stealth','Infiltrazione e azione non rilevata');

CREATE TABLE `videogioco` (
  `idVideogioco` int(11) NOT NULL,
  `titoloGioco` varchar(100) NOT NULL,
  `anno` int(11) NOT NULL,
  `idSviluppatore` int(11) NOT NULL,
  `idGenere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `videogioco` VALUES
(1,'The Legend of Zelda: Breath of the Wild',2017,1,4),
(2,'Elden Ring',2022,2,1),
(3,'The Witcher 3: Wild Hunt',2015,3,4),
(4,'The Last of Us',2013,4,5),
(5,'Half-Life 2',2004,5,3),
(6,'Red Dead Redemption 2',2018,6,4),
(7,'Diablo II',2000,7,1),
(8,'The Elder Scrolls V: Skyrim',2011,8,4),
(9,'Assassin\'s Creed II',2009,9,6),
(10,'Metal Gear Solid',1998,10,6);

CREATE TABLE `bundle` (
  `idBundle` int(11) NOT NULL,
  `nomeBundle` varchar(100) NOT NULL,
  `tema` varchar(100) NOT NULL,
  `prezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bundle` VALUES
(1,'Mondi da esplorare','Open world e avventura',39),
(2,'Eroi e oscurita','Action RPG e fantasy',29),
(3,'Missioni impossibili','Stealth e infiltrazione',25),
(4,'Sopravvivere','Horror e tensione narrativa',22),
(5,'Sparare e vincere','FPS e azione',19);

CREATE TABLE `composizione` (
  `nroProgressivo` int(11) NOT NULL,
  `idBundle` int(11) NOT NULL,
  `idVideogioco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `composizione` VALUES
(1,1,1),(2,1,3),(3,1,6),(4,1,8),
(5,2,2),(6,2,3),(7,2,7),
(8,3,9),(9,3,10),
(10,4,4),(11,4,10),
(12,5,5),(13,5,9);

ALTER TABLE `sviluppatore` ADD PRIMARY KEY (`idSviluppatore`);
ALTER TABLE `genere`        ADD PRIMARY KEY (`idGenere`);
ALTER TABLE `videogioco`    ADD PRIMARY KEY (`idVideogioco`),
  ADD KEY `FK_SVILUPPATORE` (`idSviluppatore`), ADD KEY `FK_GENERE` (`idGenere`);
ALTER TABLE `bundle`        ADD PRIMARY KEY (`idBundle`);
ALTER TABLE `composizione`  ADD PRIMARY KEY (`nroProgressivo`),
  ADD KEY `FK_BUNDLE` (`idBundle`), ADD KEY `FK_VIDEOGIOCO` (`idVideogioco`);

ALTER TABLE `sviluppatore` MODIFY `idSviluppatore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `genere`       MODIFY `idGenere`       int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `videogioco`   MODIFY `idVideogioco`   int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `bundle`       MODIFY `idBundle`       int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `composizione` MODIFY `nroProgressivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `videogioco`
  ADD CONSTRAINT `FK_SVILUPPATORE` FOREIGN KEY (`idSviluppatore`) REFERENCES `sviluppatore` (`idSviluppatore`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GENERE`       FOREIGN KEY (`idGenere`)       REFERENCES `genere`       (`idGenere`)       ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `composizione`
  ADD CONSTRAINT `FK_BUNDLE`     FOREIGN KEY (`idBundle`)     REFERENCES `bundle`     (`idBundle`)     ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_VIDEOGIOCO` FOREIGN KEY (`idVideogioco`) REFERENCES `videogioco` (`idVideogioco`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;
