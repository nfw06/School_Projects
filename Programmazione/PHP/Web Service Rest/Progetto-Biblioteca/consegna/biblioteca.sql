-- phpMyAdmin SQL Dump
-- Database: biblioteca (Verifica Gruppo B)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Database: `biblioteca`

CREATE TABLE `autore` (
  `idAutore` int(11) NOT NULL,
  `nomeAutore` varchar(100) NOT NULL,
  `nazionalita` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `autore` (`idAutore`, `nomeAutore`, `nazionalita`) VALUES
(1, 'George Orwell', 'britannico'),
(2, 'Franz Kafka', 'boemo'),
(3, 'Italo Calvino', 'italiano'),
(4, 'Dostoevskij', 'russo'),
(5, 'Gabriel García Márquez', 'colombiano'),
(6, 'Philip K. Dick', 'statunitense'),
(7, 'Umberto Eco', 'italiano'),
(8, 'Virginia Woolf', 'britannica'),
(9, 'Jorge Luis Borges', 'argentino'),
(10, 'Aldous Huxley', 'britannico');

CREATE TABLE `genere` (
  `idGenere` int(11) NOT NULL,
  `nomeGenere` varchar(100) NOT NULL,
  `descrizione` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `genere` (`idGenere`, `nomeGenere`, `descrizione`) VALUES
(1, 'Distopico', 'Romanzi ambientati in società future oppressive'),
(2, 'Esistenzialismo', 'Narrativa centrata sull alienazione e l assurdo'),
(3, 'Realismo magico', 'Fusione tra realtà e elementi fantastici'),
(4, 'Fantascienza', 'Speculazione scientifica e tecnologica'),
(5, 'Semiotica', 'Romanzi che esplorano linguaggio e significato'),
(6, 'Modernismo', 'Corrente letteraria del Novecento');

CREATE TABLE `libro` (
  `idLibro` int(11) NOT NULL,
  `titoloLibro` varchar(100) NOT NULL,
  `annoPubbl` int(11) NOT NULL,
  `idAutore` int(11) NOT NULL,
  `idGenere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `libro` (`idLibro`, `titoloLibro`, `annoPubbl`, `idAutore`, `idGenere`) VALUES
(1, '1984', 1949, 1, 1),
(2, 'La metamorfosi', 1915, 2, 2),
(3, 'Se una notte d inverno un viaggiatore', 1979, 3, 5),
(4, 'I fratelli Karamazov', 1880, 4, 2),
(5, 'Cent anni di solitudine', 1967, 5, 3),
(6, 'Il cacciatore di androidi', 1968, 6, 4),
(7, 'Il nome della rosa', 1980, 7, 5),
(8, 'Gita al faro', 1927, 8, 6),
(9, 'Finzioni', 1944, 9, 3),
(10, 'Il mondo nuovo', 1932, 10, 1);

CREATE TABLE `collana` (
  `idCollana` int(11) NOT NULL,
  `nomeCollana` varchar(100) NOT NULL,
  `editore` varchar(100) NOT NULL,
  `prezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `collana` (`idCollana`, `nomeCollana`, `editore`, `prezzo`) VALUES
(1, 'I grandi classici moderni', 'Einaudi', 18),
(2, 'Fantascienza d autore', 'Fanucci', 15),
(3, 'Il canone europeo', 'Adelphi', 22),
(4, 'Narrazioni del Novecento', 'Mondadori', 20),
(5, 'Letteratura e pensiero', 'Il Mulino', 25);

CREATE TABLE `appartiene` (
  `nroProgressivo` int(11) NOT NULL,
  `idCollana` int(11) NOT NULL,
  `idLibro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `appartiene` (`nroProgressivo`, `idCollana`, `idLibro`) VALUES
(1, 1, 1),
(2, 1, 5),
(3, 1, 10),
(4, 2, 6),
(5, 2, 10),
(6, 3, 2),
(7, 3, 4),
(8, 3, 8),
(9, 4, 3),
(10, 4, 7),
(11, 4, 9),
(12, 5, 7),
(13, 5, 3);

ALTER TABLE `autore` ADD PRIMARY KEY (`idAutore`);
ALTER TABLE `genere` ADD PRIMARY KEY (`idGenere`);
ALTER TABLE `libro` ADD PRIMARY KEY (`idLibro`), ADD KEY `FK_AUTORE` (`idAutore`), ADD KEY `FK_GENERE` (`idGenere`);
ALTER TABLE `collana` ADD PRIMARY KEY (`idCollana`);
ALTER TABLE `appartiene` ADD PRIMARY KEY (`nroProgressivo`), ADD KEY `FK_COLLANA` (`idCollana`), ADD KEY `FK_LIBRO` (`idLibro`);

ALTER TABLE `autore` MODIFY `idAutore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `genere` MODIFY `idGenere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `libro` MODIFY `idLibro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `collana` MODIFY `idCollana` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `appartiene` MODIFY `nroProgressivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `libro`
  ADD CONSTRAINT `FK_AUTORE` FOREIGN KEY (`idAutore`) REFERENCES `autore` (`idAutore`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_GENERE` FOREIGN KEY (`idGenere`) REFERENCES `genere` (`idGenere`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `appartiene`
  ADD CONSTRAINT `FK_COLLANA` FOREIGN KEY (`idCollana`) REFERENCES `collana` (`idCollana`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_LIBRO` FOREIGN KEY (`idLibro`) REFERENCES `libro` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;
