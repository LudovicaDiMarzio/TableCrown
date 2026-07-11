<?php
// ============================================================
// TableCrown — mock_account_password.php
// Mock dell'endpoint Control per il cambio password.
// Da sostituire con il vero Controller quando sarà pronto.
//
// Credenziali di test:
//   psw_vecchia corretta = "password123"
//   psw_nuova valida     = almeno 8 caratteri
// ============================================================

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$pswVecchia = $input['psw_vecchia'] ?? '';
$pswNuova   = $input['psw_nuova']   ?? '';

if ($pswVecchia !== 'password123') {
    echo json_encode(['status' => 'error', 'reason' => 'vecchia_errata']);
    exit;
}

if (strlen($pswNuova) < 8) {
    echo json_encode(['status' => 'error', 'reason' => 'nuova_non_valida']);
    exit;
}

echo json_encode(['status' => 'ok']);