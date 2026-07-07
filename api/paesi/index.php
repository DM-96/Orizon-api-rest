<?php

require_once("../../config.php");

header("Content-Type: application/json");

$sql = "SELECT * FROM paesi";

$result = $connessione->query($sql);

if (!$result) {

    http_response_code(500);

    echo json_encode([
        "errore" => "Errore nella query"
    ]);

    exit;
}

$paesi = [];

while ($row = $result->fetch_assoc()) {
    $paesi[] = $row;
}

// nessun paese trovato

if (empty($paesi)) {

    http_response_code(404);

    echo json_encode([
        "messaggio" => "Nessun paese presente"
    ]);

    exit;
}

// risposta corretta

http_response_code(200);
header("Content-Type: application/json");
echo json_encode($paesi);
