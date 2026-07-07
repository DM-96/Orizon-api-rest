<?php

require_once("../../config.php");

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);


if (!isset($data["nome"])) {

    http_response_code(400);

    echo json_encode([
        "errore" => "Nome mancante"
    ]);

    exit;
}

$nome = $data["nome"];

$sql = "INSERT INTO paesi(nome) VALUES(?)";

$stmt = $connessione->prepare($sql);

$stmt->bind_param("s", $nome);

if ($stmt->execute()) {

    http_response_code(201);

    echo json_encode([
        "messaggio" => "Paese creato",
        "id" => $connessione->insert_id
    ]);
} else {

    http_response_code(500);

    echo json_encode([
        "errore" => "Errore inserimento paese"
    ]);
}
