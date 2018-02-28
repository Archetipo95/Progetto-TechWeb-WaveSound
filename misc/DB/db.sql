SET FOREIGN_KEY_CHECKS=0;
DROP DATABASE my_wavesound;

CREATE DATABASE my_wavesound
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS user_email_banned;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS warning_comments;
DROP TABLE IF EXISTS uploaded_songs;
DROP TABLE IF EXISTS follow;
DROP TABLE IF EXISTS song;
DROP TABLE IF EXISTS album;
DROP TABLE IF EXISTS library;
DROP TABLE IF EXISTS likes;
DROP TABLE IF EXISTS genre;

CREATE TABLE user (
	u_id int(10) NOT NULL AUTO_INCREMENT,
	username varchar(20) DEFAULT NULL,
	name varchar(50) DEFAULT NULL,
	surname varchar(50) DEFAULT NULL,
	birthday date DEFAULT NULL,
	email varchar(254) NOT NULL,
	user_type int(1) NOT NULL DEFAULT '0',
	password varchar(255) NOT NULL,
	avatar varchar(200) DEFAULT 'default-profile.png',
	PRIMARY KEY (u_id)
) ENGINE=InnoDB;

CREATE TABLE album (
	id_album int(10) NOT NULL AUTO_INCREMENT,
	name varchar(20) NOT NULL,
	picture varchar(500) DEFAULT NULL,
	creation_date date NOT NULL,
	PRIMARY KEY (id_album)
) ENGINE=InnoDB;

CREATE TABLE genre (
	id_genre int(10) NOT NULL AUTO_INCREMENT,
	name varchar(50) NOT NULL,
	PRIMARY KEY (id_genre)
) ENGINE=InnoDB;

CREATE TABLE song (
	id_song int(10) NOT NULL AUTO_INCREMENT,
	title varchar(50) NOT NULL,
	genre int(10) NOT NULL,
	description varchar(180) DEFAULT NULL,
	path varchar(250) NOT NULL,
	id_album int(10) DEFAULT NULL,
	upload_date date NOT NULL,
	download int(10) NOT NULL DEFAULT '0',
	picture varchar(500) DEFAULT NULL,
	PRIMARY KEY (id_song),
	FOREIGN KEY (id_album) REFERENCES album(id_album),
	FOREIGN KEY (genre) REFERENCES genre(id_genre)
) ENGINE=InnoDB;

CREATE TABLE user_email_banned (
	email_id int(10) NOT NULL AUTO_INCREMENT,
	banned_email varchar(254) NOT NULL,
	admin_id int(10) NOT NULL,
	reason varchar(250) DEFAULT NULL,
	date_ban date NOT NULL,
	PRIMARY KEY (email_id),
	FOREIGN KEY (admin_id) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE follow (
	id_fo int(10) NOT NULL AUTO_INCREMENT,
	id_user int(10) NOT NULL,
	id_follow int(10) NOT NULL,
	PRIMARY KEY (id_fo),
	FOREIGN KEY (id_user) REFERENCES user(u_id),
	FOREIGN KEY (id_follow) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE library (
	id_user int(10) NOT NULL,
	id_song int(10) NOT NULL,
	PRIMARY KEY (id_user, id_song),
	FOREIGN KEY (id_user) REFERENCES user(u_id),
	FOREIGN KEY (id_song) REFERENCES song(id_song)
) ENGINE=InnoDB;

CREATE TABLE comment (
	comm_id int(10) NOT NULL AUTO_INCREMENT,
	description varchar(180) DEFAULT NULL,
	u_id int(10) NOT NULL,
	id_song int(10) NOT NULL,
	date_comment DATETIME NOT NULL,
	PRIMARY KEY (comm_id),
	FOREIGN KEY (id_song) REFERENCES song(id_song),
	FOREIGN KEY (u_id) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE reason (
	id_reason int(10) NOT NULL AUTO_INCREMENT,
	type varchar(250) NOT NULL,
	PRIMARY KEY (id_reason)
) ENGINE=InnoDB;

CREATE TABLE reported_comments (
	id_report int(10) NOT NULL AUTO_INCREMENT,
 	com_id int(11) NOT NULL,
	reason int(10) NOT NULL,
	date_report date NOT NULL,
	id_reporter int(10) NOT NULL,
	PRIMARY KEY (id_report),
	FOREIGN KEY (com_id) REFERENCES comment(comm_id),
	FOREIGN KEY (reason) REFERENCES reason(id_reason),
	FOREIGN KEY (id_reporter) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE likes (
	id_song int(10) NOT NULL,
	u_id int(10) NOT NULL,
	score int(10) DEFAULT NULL,
	PRIMARY KEY (id_song, u_id),
	FOREIGN KEY (u_id) REFERENCES user(u_id),
	FOREIGN KEY (id_song) REFERENCES song(id_song)
) ENGINE=InnoDB;

CREATE VIEW vista_query2 AS
SELECT likes.id_song as canzone,title,genre.name,username,SUM(CASE WHEN score > 0 THEN 1 ELSE 0 END) AS somma,album.picture 
FROM likes,song,library,user,album,genre 
WHERE likes.id_song=song.id_song 
	AND library.id_song=song.id_song 
    AND song.id_album=album.id_album 
    AND library.id_user=user.u_id 
    AND song.genre=genre.id_genre 
GROUP BY likes.id_song 
ORDER BY somma DESC;

SET FOREIGN_KEY_CHECKS=1;

INSERT INTO user (username, password, email, name, surname, user_type) VALUES ( 'admin', 'admin', 'admin@wavesound.unipd', 'admin', 'admin', 1);
INSERT INTO user (username, password, email,name, surname) VALUES ( 'user', 'user', 'user@wavesound.unipd', 'user', 'user');
