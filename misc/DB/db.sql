SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `album`;
DROP TABLE IF EXISTS `uploaded_songs`;
DROP TABLE IF EXISTS `song`;
DROP TABLE IF EXISTS `comment`;
DROP TABLE IF EXISTS `follow`;
DROP TABLE IF EXISTS `library`;
DROP TABLE IF EXISTS `user`;

SET FOREIGN_KEY_CHECKS=1;


CREATE TABLE `album` (
  `id_album` int(10) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_song` int(10) NOT NULL,
  `composed_by` int(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `uploaded_songs` (
  `id_song` int(10) NOT NULL,
  `u_id` int(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `song` (
  `id_song` int(10) NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `upload_date` date NOT NULL,
  `description` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `composed_by` int(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_album` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `comment` (
  `description` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_id` int(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_song` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `follow` (
  `id_user` int(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_follow` int(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `library` (
  `id_library` int(10) NOT NULL,
  `u_id` int(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_song` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user` (
  `u_id` int(10) AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(20) COLLATE utf8_unicode_ci,
  `name` varchar(50) COLLATE utf8_unicode_ci,
  `surname` varchar(50) COLLATE utf8_unicode_ci,
  `birthday` date,
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_library` int(10)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- Indici per le tabelle `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`),
  ADD KEY `id_song` (`id_song`),
  ADD KEY `composed_by` (`composed_by`);

--
-- Indici per le tabelle `uploaded_songs`
--
ALTER TABLE `uploaded_songs`
  ADD PRIMARY KEY (`id_song`,`u_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indici per le tabelle `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id_song`),
  ADD KEY `id_album` (`id_album`),
  ADD KEY `composed_by` (`composed_by`);

--
-- Indici per le tabelle `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`u_id`,`id_song`),
  ADD KEY `id_song` (`id_song`);

--
-- Indici per le tabelle `follow`
--
ALTER TABLE `follow`
  ADD PRIMARY KEY (`id_user`,`id_follow`),
  ADD KEY `id_follow` (`id_follow`);

--
-- Indici per le tabelle `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id_library`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `id_song` (`id_song`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD KEY `id_library` (`id_library`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `song`
--
ALTER TABLE `song`
  MODIFY `id_song` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `library`
--
ALTER TABLE `library`
  MODIFY `id_library` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`id_song`) REFERENCES `song` (`id_song`),
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`composed_by`) REFERENCES `user` (`u_id`);

--
-- Limiti per la tabella `uploaded_songs`
--
ALTER TABLE `uploaded_songs`
  ADD CONSTRAINT `uploaded_songs_ibfk_1` FOREIGN KEY (`id_song`) REFERENCES `song` (`id_song`),
  ADD CONSTRAINT `uploaded_songs_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Limiti per la tabella `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_ibfk_1` FOREIGN KEY (`composed_by`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `song_ibfk_2` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `song_ibfk_3` FOREIGN KEY (`composed_by`) REFERENCES `user` (`u_id`);

--
-- Limiti per la tabella `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_song`) REFERENCES `song` (`id_song`);

--
-- Limiti per la tabella `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`id_follow`) REFERENCES `user` (`u_id`);

--
-- Limiti per la tabella `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `library_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `library_ibfk_2` FOREIGN KEY (`id_song`) REFERENCES `song` (`id_song`);

--
-- Limiti per la tabella `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_library`) REFERENCES `library` (`id_library`);
