SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `album`;
DROP TABLE IF EXISTS `brani_caricati`;
DROP TABLE IF EXISTS `canzone`;
DROP TABLE IF EXISTS `commento`;
DROP TABLE IF EXISTS `follow`;
DROP TABLE IF EXISTS `libreria`;
DROP TABLE IF EXISTS `utente`;

SET FOREIGN_KEY_CHECKS=1;


CREATE TABLE `album` (
  `id_album` int(11) NOT NULL,
  `nome` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_canzone` int(11) NOT NULL,
  `composed_by` int(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `brani_caricati` (
  `id_canzone` int(11) NOT NULL,
  `u_id` int(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `canzone` (
  `id_canzone` int(11) NOT NULL,
  `titolo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `data_publicazione` date NOT NULL,
  `descrizione` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `composed_by` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `id_album` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `commento` (
  `desrizione` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_id` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `id_canzone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `follow` (
  `id_user` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `id_follow` int(11) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `libreria` (
  `id_libreria` int(11) NOT NULL,
  `u_id` int(11) COLLATE utf8_unicode_ci NOT NULL,
  `id_canzone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `utente` (
  `u_id` int(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `username` varchar(20) COLLATE utf8_unicode_ci,
  `nome` varchar(50) COLLATE utf8_unicode_ci,
  `cognome` varchar(50) COLLATE utf8_unicode_ci,
  `data_nascita` date,
  `email` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_utente` int(1) NOT NULL DEFAULT '0',
  `pass` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_libreria` int(11),
  `active` varchar(255),
  `resetToken` varchar(255) DEFAULT NULL,
  `resetComplete` varchar(3) DEFAULT 'No'  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



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
  ADD PRIMARY KEY (`id_canzone`,`u_id`),
  ADD KEY `u_id` (`u_id`);

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
  ADD PRIMARY KEY (`u_id`,`id_canzone`),
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
  ADD KEY `u_id` (`u_id`),
  ADD KEY `id_canzone` (`id_canzone`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
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
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`composed_by`) REFERENCES `utente` (`u_id`);

--
-- Limiti per la tabella `brani_caricati`
--
ALTER TABLE `brani_caricati`
  ADD CONSTRAINT `brani_caricati_ibfk_1` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`),
  ADD CONSTRAINT `brani_caricati_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `utente` (`u_id`);

--
-- Limiti per la tabella `canzone`
--
ALTER TABLE `canzone`
  ADD CONSTRAINT `canzone_ibfk_1` FOREIGN KEY (`composed_by`) REFERENCES `utente` (`u_id`),
  ADD CONSTRAINT `canzone_ibfk_2` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `canzone_ibfk_3` FOREIGN KEY (`composed_by`) REFERENCES `utente` (`u_id`);

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `utente` (`u_id`),
  ADD CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`);

--
-- Limiti per la tabella `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utente` (`u_id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_follow`) REFERENCES `utente` (`u_id`);

--
-- Limiti per la tabella `libreria`
--
ALTER TABLE `libreria`
  ADD CONSTRAINT `libreria_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `utente` (`u_id`),
  ADD CONSTRAINT `libreria_ibfk_2` FOREIGN KEY (`id_canzone`) REFERENCES `canzone` (`id_canzone`);

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`id_libreria`) REFERENCES `libreria` (`id_libreria`);
