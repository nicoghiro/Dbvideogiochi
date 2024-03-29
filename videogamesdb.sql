-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 27, 2024 alle 22:35
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `videogamesdb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `giochi`
--

CREATE TABLE `giochi` (
  `IdGioco` int(11) NOT NULL,
  `Titolo` varchar(100) NOT NULL,
  `Genere` varchar(50) DEFAULT NULL,
  `AnnoLancio` int(11) DEFAULT NULL,
  `Piattaforma` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `giochi`
--

INSERT INTO `giochi` (`IdGioco`, `Titolo`, `Genere`, `AnnoLancio`, `Piattaforma`) VALUES
(1, 'The Legend of Zelda: Breath of the Wild', 'Action-Adventure', 2017, 'Nintendo Switch'),
(3, 'Minecraft', 'Sandbox', 2011, 'Multiplatform'),
(7, 'Pokemon nero 2', 'Avventura', 2012, 'Nintendo ds'),
(10, 'Pokemon Bianco 2', 'Avventura', 2012, 'Nintendo Ds');

-- --------------------------------------------------------

--
-- Struttura della tabella `giochisviluppatori`
--

CREATE TABLE `giochisviluppatori` (
  `IdGioco` int(11) NOT NULL,
  `IdSviluppatore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `giochisviluppatori`
--

INSERT INTO `giochisviluppatori` (`IdGioco`, `IdSviluppatore`) VALUES
(1, 1),
(3, 3),
(7, 1),
(10, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensioni`
--

CREATE TABLE `recensioni` (
  `IdRecensione` int(11) NOT NULL,
  `IdGioco` int(11) NOT NULL,
  `Voto` decimal(3,1) NOT NULL,
  `Commento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `recensioni`
--

INSERT INTO `recensioni` (`IdRecensione`, `IdGioco`, `Voto`, `Commento`) VALUES
(1, 7, 6.0, 'Capolavoro assoluto, grafica incredibile e gameplay avvincente.'),
(5, 7, 10.0, 'Gran giocone '),
(6, 7, 9.0, 'Bel gioco, campionessa troppo facile da battere'),
(9, 1, 8.0, 'Ciao ');

-- --------------------------------------------------------

--
-- Struttura della tabella `sede_principale`
--

CREATE TABLE `sede_principale` (
  `id_sede` int(11) NOT NULL,
  `locazione` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sede_principale`
--

INSERT INTO `sede_principale` (`id_sede`, `locazione`) VALUES
(1, 'East 45th Street, New York, Stati Uniti'),
(3, 'Inc.622 Broadway New York, NY 10012 Stati Uniti'),
(4, 'Maria Skolgata 83 118 53 Stockholm Svezia'),
(5, 'Francia'),
(6, 'New York, New York, Stati Uniti');

-- --------------------------------------------------------

--
-- Struttura della tabella `sviluppatori`
--

CREATE TABLE `sviluppatori` (
  `IdSviluppatore` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Sede_principale` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `sviluppatori`
--

INSERT INTO `sviluppatori` (`IdSviluppatore`, `Nome`, `Sede_principale`) VALUES
(1, 'Nintendo', 1),
(3, 'Mojang Studios', 4),
(8, 'Rockstar Games', 6);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `idUtente` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`idUtente`, `username`, `password`) VALUES
(1, 'Nicolas', '1C80E0C7ED76D37C55273E6A6C36D88EDD9802D7A3C6FD5AC399F9DC46B36CF5EB18E6FD304ECCE361A24312C936CB61FAF585436E4B535F4D0DF31DB6D968B1'),
(3, 'Matteo', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db'),
(4, 'Andrea', '0dc526d8c4fa04084f4b2a6433f4cd14664b93df9fb8a9e00b77ba890b83704d24944c93caa692b51085bb476f81852c27e793600f137ae3929018cd4c8f1a45'),
(5, 'Andrea', 'ba477af1e5822f3a4cfa75a56bf0f946045f11b14e7ab79379765a221d166dfaee5de0df018237e50d43a5484e99d9216b96f45b5f163e80ea3b7c9c5d2c3e77');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `giochi`
--
ALTER TABLE `giochi`
  ADD PRIMARY KEY (`IdGioco`);

--
-- Indici per le tabelle `giochisviluppatori`
--
ALTER TABLE `giochisviluppatori`
  ADD PRIMARY KEY (`IdGioco`,`IdSviluppatore`),
  ADD KEY `IdSviluppatore` (`IdSviluppatore`);

--
-- Indici per le tabelle `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`IdRecensione`),
  ADD KEY `IdGioco` (`IdGioco`);

--
-- Indici per le tabelle `sede_principale`
--
ALTER TABLE `sede_principale`
  ADD PRIMARY KEY (`id_sede`);

--
-- Indici per le tabelle `sviluppatori`
--
ALTER TABLE `sviluppatori`
  ADD PRIMARY KEY (`IdSviluppatore`),
  ADD KEY `fk:sede` (`Sede_principale`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`idUtente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `giochi`
--
ALTER TABLE `giochi`
  MODIFY `IdGioco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  MODIFY `IdRecensione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `sede_principale`
--
ALTER TABLE `sede_principale`
  MODIFY `id_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `sviluppatori`
--
ALTER TABLE `sviluppatori`
  MODIFY `IdSviluppatore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `idUtente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `giochisviluppatori`
--
ALTER TABLE `giochisviluppatori`
  ADD CONSTRAINT `giochisviluppatori_ibfk_1` FOREIGN KEY (`IdGioco`) REFERENCES `giochi` (`IdGioco`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `giochisviluppatori_ibfk_2` FOREIGN KEY (`IdSviluppatore`) REFERENCES `sviluppatori` (`IdSviluppatore`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `recensioni_ibfk_1` FOREIGN KEY (`IdGioco`) REFERENCES `giochi` (`IdGioco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `sviluppatori`
--
ALTER TABLE `sviluppatori`
  ADD CONSTRAINT `fk:sede` FOREIGN KEY (`Sede_principale`) REFERENCES `sede_principale` (`id_sede`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
