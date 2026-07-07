# Orizon API REST

API RESTful sviluppata in PHP e MySQL per la gestione di viaggi sostenibili.

## Tecnologie

- PHP
- MySQL
- REST API
- JSON

## Funzionalità

### Paesi

- Creazione
- Lettura
- Modifica
- Eliminazione

### Viaggi

- Creazione
- Lettura
- Modifica
- Eliminazione
- Filtri per paese e posti disponibili
- Ricerca offerte last minute

## Database

Importare migrations.sql per creare la struttura.

## Endpoint API

### Paesi

GET
/api/paesi/index.php

POST
/api/paesi/create.php

PUT
/api/paesi/update.php?id={id}

DELETE
/api/paesi/delete.php?id={id}

### Viaggi

GET
/api/viaggi/index.php

Filtri:

- ?paese=nome
- ?posti=numero
- ?last_minute=1

POST
/api/viaggi/create.php

PUT
/api/viaggi/update.php?id={id}

DELETE
/api/viaggi/delete.php?id={id}
