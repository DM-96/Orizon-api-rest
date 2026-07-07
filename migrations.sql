CREATE DATABASE IF NOT EXISTS orizon;

USE orizon;


-- Tabella paesi

CREATE TABLE IF NOT EXISTS paesi (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL

);



-- Tabella viaggi

CREATE TABLE IF NOT EXISTS viaggi (

    id INT AUTO_INCREMENT PRIMARY KEY,

    posti_disponibili INT NOT NULL

);



-- Tabella relazione viaggi-paesi

CREATE TABLE IF NOT EXISTS viaggi_paesi (

    viaggio_id INT NOT NULL,

    paese_id INT NOT NULL,


    PRIMARY KEY (viaggio_id, paese_id),


    FOREIGN KEY (viaggio_id)
    REFERENCES viaggi(id)
    ON DELETE CASCADE,


    FOREIGN KEY (paese_id)
    REFERENCES paesi(id)
    ON DELETE CASCADE

);