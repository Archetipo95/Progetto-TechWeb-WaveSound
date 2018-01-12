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
  id_library int(10) DEFAULT NULL,
	PRIMARY KEY (u_id),
	FOREIGN KEY (id_library) REFERENCES library(id_library)
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

CREATE TABLE comment (
	id_comm int(10) NOT NULL AUTO_INCREMENT,
	description varchar(180) DEFAULT NULL,
	u_id int(10) NOT NULL,
	id_song int(10) NOT NULL,
	PRIMARY KEY (id_comm),
	FOREIGN KEY (id_song) REFERENCES song(id_song),
	FOREIGN KEY (u_id) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE warning_comments (
	id_comm int(11) NOT NULL,
	reason varchar(250) DEFAULT NULL,
	date_warning date NOT NULL,
	FOREIGN KEY (id_comm) REFERENCES comment(id_comm)
) ENGINE=InnoDB;

CREATE TABLE follow (
	id_fo int(10) NOT NULL,
	id_user int(10) NOT NULL,
	id_follow int(10) NOT NULL,
	PRIMARY KEY (id_fo),
	FOREIGN KEY (id_user) REFERENCES user(u_id),
	FOREIGN KEY (id_follow) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE library (
	id_library int(10) NOT NULL AUTO_INCREMENT,
	id_user int(10) NOT NULL,
	id_song int(10) NOT NULL,
	PRIMARY KEY (id_library),
	FOREIGN KEY (id_user) REFERENCES user(u_id),
	FOREIGN KEY (id_song) REFERENCES song(id_song)
) ENGINE=InnoDB;

CREATE TABLE album (
	id_album int(10) NOT NULL,
	name varchar(20) NOT NULL,
	picture varchar(500) DEFAULT NULL,
	id_song int(10) NOT NULL,
	composed_by int(10) NOT NULL,
	PRIMARY KEY (id_album),
	FOREIGN KEY (id_song) REFERENCES song(id_song)
) ENGINE=InnoDB;

CREATE TABLE song (
	id_song int(10) NOT NULL AUTO_INCREMENT,
	title varchar(50) NOT NULL,
	genre varchar(50) NOT NULL,
	description varchar(180) DEFAULT NULL,
	path varchar(250) NOT NULL,
	id_album int(10) NOT NULL,
	upload_date date NOT NULL,
	upload_by int(10) NOT NULL,
	PRIMARY KEY (id_song),
	FOREIGN KEY (id_album) REFERENCES album(id_album),
	FOREIGN KEY (upload_by) REFERENCES user(u_id)
) ENGINE=InnoDB;

CREATE TABLE likes (
	id_song int(10) NOT NULL,
	u_id int(10) NOT NULL,
	score int(10) DEFAULT NULL,
	PRIMARY KEY (id_song, u_id)
) ENGINE=InnoDB;


SET FOREIGN_KEY_CHECKS=1;

INSERT INTO user (username, password, email, user_type) VALUES ( 'admin', 'admin', 'admin@wavesound.unipd', 1);
INSERT INTO user (username, password, email) VALUES ( 'user', 'user', 'user@wavesound.unipd');



