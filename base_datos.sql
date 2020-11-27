CREATE DATABASE IF NOT EXISTS albums;
USE albums;

CREATE TABLE genre(
   genre_id INT PRIMARY KEY AUTO_INCREMENT,
   genre_name VARCHAR(60) UNIQUE NOT NULL
);

CREATE TABLE artists(
    artist_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    artist_name VARCHAR(255) NOT NULL
);

CREATE TABLE albums(
    album_id INT PRIMARY KEY AUTO_INCREMENT,
    album_name VARCHAR(255) NOT NULL,
    album_date_released DATE NOT NULL,
    album_time_released TIME NOT NULL,
    artist_fk INT,
    genre_fk INT,
    FOREIGN KEY(artist_fk) REFERENCES artists(artist_id),
    FOREIGN KEY(genre_fk) REFERENCES genre(genre_id)
);

CREATE OR REPLACE VIEW albums_view AS SELECT a.*, ar.artist_name, g.genre_name FROM genre as g, albums as a, artists as ar where a.artist_fk = ar.artist_id and a.genre_fk = g.genre_id;

CREATE TABLE concerts(
    concert_id INT PRIMARY KEY AUTO_INCREMENT,
    concert_title VARCHAR(180) NOT NULL,
    concert_place VARCHAR(60) NOT NULL,
    concert_date DATE NOT NULL,
    artist_fk INT NOT NULL,
    FOREIGN KEY(artist_fk) REFERENCES artists(artist_id)
);

CREATE OR REPLACE VIEW concerts_view AS SELECT concerts.*,artists.* FROM concerts JOIN artists ON concerts.artist_fk = artists.artist_id;