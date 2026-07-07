<?php

require_once("../../config.php");

header("Content-Type: application/json");

$paese = $_GET["paese"] ?? null;
$posti = $_GET["posti"] ?? null;
$last_minute = $_GET["last_minute"] ?? null;

$sql =
    "SELECT 
    viaggi.id,
    viaggi.posti_disponibili,
    GROUP_CONCAT(paesi.nome) AS paesi

FROM viaggi

JOIN viaggi_paesi
ON viaggi.id = viaggi_paesi.viaggio_id

JOIN paesi
ON paesi.id = viaggi_paesi.paese_id

";
$condizioni = [];
$parametri = [];
$tipi = "";

// filtro paese

if ($paese) {

    $condizioni[] = "paesi.nome = ?";

    $parametri[] = $paese;

    $tipi .= "s";
}
// filtro posti

if ($posti) {

    $condizioni[] = "viaggi.posti_disponibili = ?";

    $parametri[] = $posti;

    $tipi .= "i";
}

// filtro offerte last minute

if ($last_minute) {

    $condizioni[] = "viaggi.posti_disponibili <= ?";

    $parametri[] = 10;

    $tipi .= "i";
}

// aggiungo WHERE se esistono filtri

if (count($condizioni) > 0) {

    $sql .= " WHERE " . implode(" AND ", $condizioni);
}

$sql .= " GROUP BY viaggi.id";

// preparo query

$stmt = $connessione->prepare($sql);

// se ci sono parametri li collego

if (count($parametri) > 0) {
    $stmt->bind_param(
        $tipi,
        ...$parametri
    );
}

$stmt->execute();

$result = $stmt->get_result();

$viaggi = [];

while ($row = $result->fetch_assoc()) {
    $viaggi[] = $row;
}
header("Content-Type: application/json");
echo json_encode($viaggi);
