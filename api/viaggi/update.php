<?php

require_once("../../config.php");

header("Content-Type: application/json");

$id = $_GET["id"] ?? null;

// controllo ID

if (!$id) {

    http_response_code(400);

    echo json_encode([
        "errore" => "ID mancante"
    ]);

    exit;
}

// controllo se il viaggio esiste

$sql = "SELECT id FROM viaggi WHERE id = ?";

$stmt = $connessione->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {

    http_response_code(404);

    echo json_encode([
        "errore" => "Viaggio non trovato"
    ]);

    exit;
}

// recupero dati JSON

$data = json_decode(
    file_get_contents("php://input"),
    true
);

if (!isset($data["posti_disponibili"]) || !isset($data["paesi"])) {

    http_response_code(400);

    echo json_encode([
        "errore" => "Dati mancanti"
    ]);

    exit;
}

$posti = $data["posti_disponibili"];
$paesi = $data["paesi"];

// aggiorno viaggio

$sql = "UPDATE viaggi SET posti_disponibili = ? WHERE id = ?";

$stmt = $connessione->prepare($sql);

$stmt->bind_param(
    "ii",
    $posti,
    $id
);

if (!$stmt->execute()) {

    http_response_code(500);

    echo json_encode([
        "errore" => "Errore aggiornamento viaggio"
    ]);

    exit;
}

// elimino vecchi collegamenti

$sql = "DELETE FROM viaggi_paesi WHERE viaggio_id = ?";

$stmt = $connessione->prepare($sql);

$stmt->bind_param(
    "i",
    $id
);

$stmt->execute();

// inserisco nuovi paesi

foreach ($paesi as $paese) {

    $sql = "INSERT INTO viaggi_paesi (viaggio_id, paese_id) VALUES (?,?)";

    $stmt = $connessione->prepare($sql);

    $stmt->bind_param(
        "ii",
        $id,
        $paese
    );

    if (!$stmt->execute()) {

        http_response_code(500);

        echo json_encode([
            "errore" => "Errore collegamento paese"
        ]);

        exit;
    }
}

http_response_code(200);

echo json_encode([
    "messaggio" => "Viaggio aggiornato"
]);
