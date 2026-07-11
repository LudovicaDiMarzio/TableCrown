<?php
// Mock dell'endpoint Control per l'eliminazione account.
// Credenziali di test: password corretta = "password123"

header('Content-Type: application/json');

$input    = json_decode(file_get_contents('php://input'), true);
$password = $input['password'] ?? '';

if ($password !== 'password123') {
    echo json_encode(['status' => 'error', 'reason' => 'password_errata']);
    exit;
}

unset($_SESSION['utente_id'], $_SESSION['utente_nickname']);
echo json_encode(['status' => 'ok']);