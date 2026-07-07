<?php

require_once("../../config.php");

header("Content-Type: application/json");

$id = $_GET["id"] ?? null;

if (!$id) {

    http_response_code(400);

    echo json_encode([
        "errore" => "ID mancante"
    ]);

    exit;
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

if (!isset($data["nome"])) {

    http_response_code(400);

    echo json_encode([
        "errore" => "Nome mancante"
    ]);

    exit;
}

$nome = $data["nome"];

// controllo esistenza paese

$sql = "SELECT id FROM paesi WHERE id = ?";

$stmt = $connessione->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    http_response_code(404);

    echo json_encode([
        "errore" => "Paese non trovato"
    ]);

    exit;
}

// aggiornamento

$sql = "UPDATE paesi SET nome=? WHERE id=?";

$stmt = $connessione->prepare($sql);

$stmt->bind_param(
    "si",
    $nome,
    $id
);

if ($stmt->execute()) {

    http_response_code(200);

    echo json_encode([
        "messaggio" => "Paese aggiornato"
    ]);
} else {

    http_response_code(500);

    echo json_encode([
        "errore" => "Errore aggiornamento"
    ]);
}
