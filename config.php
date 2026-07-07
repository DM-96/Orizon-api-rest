<?php

$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "orizon";

$connessione = new mysqli($host, $user, $password, $db); //Apertura DataBase

if ($connessione === false) {
    die("Errore di connessione: " . $connessione->connect_erorre);
}
