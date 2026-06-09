-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 01, 2021 alle 10:05
-- Versione del server: 10.4.6-MariaDB
-- Versione PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musica`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `autore`
--

CREATE TABLE `autore` (
  `idAutore` int(11) NOT NULL,
  `nomeAutore` varchar(100) NOT NULL,
  `datiAutore` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `autore`
--

INSERT INTO `autore` (`idAutore`, `nomeAutore`, `datiAutore`) VALUES
(1, 'Talking Heads', ''),
(2, 'The Who', ''),
(3, 'Bob Dylan', ''),
(4, 'The Police', ''),
(5, 'Genesis', ''),
(6, 'Derek & The Dominos', ''),
(7, 'Rainbow', ''),
(8, 'Jefferson Airplane', ''),
(9, 'Depeche Mode', ''),
(10, 'Dire Straits', ''),
(11, 'Jimi Hendrix', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `cantante`
--

CREATE TABLE `cantante` (
  `idCantante` int(11) NOT NULL,
  `nomeCantante` varchar(100) NOT NULL,
  `datiCantante` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cantante`
--

INSERT INTO `cantante` (`idCantante`, `nomeCantante`, `datiCantante`) VALUES
(1, 'Talking Heads', ''),
(2, 'The Who', ''),
(3, 'Jimi Hendrix', ''),
(4, 'The Police', ''),
(5, 'Genesis', ''),
(6, 'Derek & The Dominos', ''),
(7, 'Rainbow', ''),
(8, 'Jefferson Airplane', ''),
(9, 'Depeche Mode', ''),
(10, 'Dire Straits', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `canzone`
--

CREATE TABLE `canzone` (
  `idCanzone` int(11) NOT NULL,
  `titoloCanz` varchar(100) NOT NULL,
  `anno` int(11) NOT NULL,
  `idCantante` int(11) NOT NULL,
  `idAutore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `canzone`
--

INSERT INTO `canzone` (`idCanzone`, `titoloCanz`, `anno`, `idCantante`, `idAutore`) VALUES
(1, 'This Must Be The Place', 0, 1, 1),
(2, 'Baba O\'Riley', 0, 2, 2),
(3, 'All Along the Watchtower', 1968, 3, 3),
(4, 'Roxanne', 1978, 4, 4),
(5, 'Land Of Confusion', 1986, 5, 5),
(6, 'Layla', 1970, 6, 6),
(7, 'Man On The Silver Mountain', 1975, 7, 7),
(8, 'Somebody to Love', 1967, 8, 8),
(9, 'Policy of Truth', 0, 9, 9),
(10, 'Lady Writer', 1979, 10, 10),
(11, 'Voodoo Child', 1968, 3, 11);

-- --------------------------------------------------------

--
-- Struttura della tabella `contiene`
--

CREATE TABLE `contiene` (
  `nroSerieDisco` int(11) NOT NULL,
  `codiceReg` int(11) NOT NULL COMMENT '(corrisponde a idCanzone)',
  `nroProgressivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `contiene`
--

INSERT INTO `contiene` (`nroSerieDisco`, `codiceReg`, `nroProgressivo`) VALUES
(78572, 1, 1),
(78573, 2, 2),
(78574, 3, 3),
(78575, 4, 4),
(78576, 5, 5),
(78577, 6, 6),
(78578, 7, 7),
(78579, 8, 8),
(78580, 9, 9),
(78581, 10, 10),
(78574, 11, 11),
(78580, 6, 12);

-- --------------------------------------------------------

--
-- Struttura della tabella `disco`
--

CREATE TABLE `disco` (
  `nroSerie` int(11) NOT NULL,
  `titoloAlbum` varchar(100) NOT NULL,
  `anno` int(11) NOT NULL,
  `prezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `disco`
--

INSERT INTO `disco` (`nroSerie`, `titoloAlbum`, `anno`, `prezzo`) VALUES
(78572, 'Speaking in Tongues', 1983, 20),
(78573, 'Who\'s Next', 1971, 30),
(78574, 'Electric Ladyland', 1968, 25),
(78575, 'Outlandos D\'Amour', 1978, 15),
(78576, 'Invisible Touch', 1986, 25),
(78577, 'Layla And Other Assorted Love Songs', 1970, 40),
(78578, 'Ritchie Blackmore\'s Rainbow', 1975, 20),
(78579, 'Surrealistic Pillow', 1967, 30),
(78580, 'Violator', 1990, 20),
(78581, 'Communiqué', 1979, 35);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autore`
--
ALTER TABLE `autore`
  ADD PRIMARY KEY (`idAutore`);

--
-- Indici per le tabelle `cantante`
--
ALTER TABLE `cantante`
  ADD PRIMARY KEY (`idCantante`);

--
-- Indici per le tabelle `canzone`
--
ALTER TABLE `canzone`
  ADD PRIMARY KEY (`idCanzone`),
  ADD KEY `FK_CANTANTE` (`idCantante`),
  ADD KEY `FK_AUTORE` (`idAutore`);

--
-- Indici per le tabelle `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`nroProgressivo`),
  ADD KEY `FK_NROSERIE` (`nroSerieDisco`),
  ADD KEY `FK_IDCANZONE` (`codiceReg`);

--
-- Indici per le tabelle `disco`
--
ALTER TABLE `disco`
  ADD PRIMARY KEY (`nroSerie`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `autore`
--
ALTER TABLE `autore`
  MODIFY `idAutore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `cantante`
--
ALTER TABLE `cantante`
  MODIFY `idCantante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `canzone`
--
ALTER TABLE `canzone`
  MODIFY `idCanzone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `contiene`
--
ALTER TABLE `contiene`
  MODIFY `nroProgressivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `disco`
--
ALTER TABLE `disco`
  MODIFY `nroSerie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78582;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `canzone`
--
ALTER TABLE `canzone`
  ADD CONSTRAINT `FK_AUTORE` FOREIGN KEY (`idAutore`) REFERENCES `autore` (`idAutore`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CANTANTE` FOREIGN KEY (`idCantante`) REFERENCES `cantante` (`idCantante`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `FK_IDCANZONE` FOREIGN KEY (`codiceReg`) REFERENCES `canzone` (`idCanzone`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_NROSERIE` FOREIGN KEY (`nroSerieDisco`) REFERENCES `disco` (`nroSerie`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;