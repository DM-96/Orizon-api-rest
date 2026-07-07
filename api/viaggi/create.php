<?php

require_once("../../config.php");

header("Content-Type: application/json");

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


$sql = "INSERT INTO viaggi(posti_disponibili) VALUES(?)";

$stmt = $connessione->prepare($sql);

$stmt->bind_param("i", $posti);
if (!$stmt->execute()) {

    http_response_code(500);

    echo json_encode([
        "errore" => "Errore inserimento viaggio"
    ]);

    exit;
}
$viaggio_id = $connessione->insert_id;

foreach ($paesi as $paese_id) {

    $sql = "INSERT INTO viaggi_paesi (viaggio_id, paese_id) VALUES (?,?)";

    $stmt = $connessione->prepare($sql);

    $stmt->bind_param(
        "ii",
        $viaggio_id,
        $paese_id
    );


    if (!$stmt->execute()) {

        http_response_code(500);

        echo json_encode([
            "errore" => "Errore collegamento paesi"
        ]);

        exit;
    }
}

http_response_code(201);
echo json_encode([
    "messaggio" => "Viaggio creato",
    "id" => $viaggio_id
]);
