-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 11, 2017 alle 14:40
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tecweb`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `album`
--

CREATE TABLE `album` (
  `id_album` int(11) NOT NULL,
  `nome` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_canzone` int(11) NOT NULL,
  `composed_by` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `brani_caricati`
--

CREATE TABLE `brani_caricati` (
  `id_canzone` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `canzone`
--

CREATE TABLE `canzone` (
  `id_canzone` int(11) NOT NULL,
  `titolo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data_publicazione` date NOT NULL,
  `descrizione` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `composed_by` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_album` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `desrizione` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_canzone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `follow`
--

CREATE TABLE `follow` (
  `id_user` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_follow` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `libreria`
--

CREATE TABLE `libreria` (
  `id_libreria` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_canzone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cognome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data_nascita` date NOT NULL,
  `email` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_utente` int(1) NOT NULL DEFAULT '0',
  `pass` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_libreria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`),
  ADD KEY `id_canzone` (`id_canzone`),
  ADD KEY `composed_by` (`composed_by`);

--
-- Indici per le tabelle `brani_caricati`
--
ALTER TABLE `brani_caricati`
  ADD PRIMARY KEY (`id_canzone`,`username`),
  ADD KEY `username` (`username`);

--
-- Indici per le tabelle `canzone`
--
ALTER TABLE `canzone`
  ADD PRIMARY KEY (`id_canzone`),
  ADD KEY `id_album` (`id_album`),
  ADD KEY `composed_by` (`composed_by`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`username`,`id_canzone`),
  ADD KEY `id_canzone` (`id_canzone`);

--
-- Indici per le tabelle `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_user`,`id_follow`),
  ADD KEY `id_follow` (`id_follow`);

--
-- Indici per le tabelle `libreria`
--
ALTER TABLE `libreria`
  ADD PRIMARY KEY (`id_libreria`),
  ADD KEY `username` (`username`),
  ADD KEY `id_canzone` (`id_canzone`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`username`),
  ADD KEY `id_libreria` (`id_libreria`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `canzone`
--
ALTER TABLE `canzone`
  MODIFY `id_canzone` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `libreria`
--
ALTER TABLE `libreria`
  MODIFY `id_libreria` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`),
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`composed_by`) REFERENCES `utente` (`username`);

--
-- Limiti per la tabella `brani_caricati`
--
ALTER TABLE `brani_caricati`
  ADD CONSTRAINT `brani_caricati_ibfk_1` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`),
  ADD CONSTRAINT `brani_caricati_ibfk_2` FOREIGN KEY (`username`) REFERENCES `utente` (`username`);

--
-- Limiti per la tabella `canzone`
--
ALTER TABLE `canzone`
  ADD CONSTRAINT `canzone_ibfk_1` FOREIGN KEY (`composed_by`) REFERENCES `utente` (`username`),
  ADD CONSTRAINT `canzone_ibfk_2` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `canzone_ibfk_3` FOREIGN KEY (`composed_by`) REFERENCES `utente` (`username`);

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utente` (`username`),
  ADD CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`);

--
-- Limiti per la tabella `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utente` (`username`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_follow`) REFERENCES `utente` (`username`);

--
-- Limiti per la tabella `libreria`
--
ALTER TABLE `libreria`
  ADD CONSTRAINT `libreria_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utente` (`username`),
  ADD CONSTRAINT `libreria_ibfk_2` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`id_libreria`) REFERENCES `libreria` (`id_libreria`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
