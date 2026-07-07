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

// eliminazione

$sql = "DELETE FROM paesi WHERE id = ?";

$stmt = $connessione->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    http_response_code(204);
} else {

    http_response_code(500);

    echo json_encode([
        "errore" => "Errore durante la cancellazione"
    ]);
}
