<?php
// ============================================================
// TableCrown — mock_carrello_aggiungi.php
// Mock TEMPORANEO dell'endpoint Control "/carrello/aggiungi".
// Simula esattamente il contratto che dovrà rispettare
// il vero endpoint scritto da T1 (Control) + T2 (Doctrine).
//
// DA RIMUOVERE quando il vero Control sarà collegato.
// ============================================================

header('Content-Type: application/json');

// ── CONTROLLO SESSIONE (questa è la logica che T1 dovrà avere) ──
if (!isset($_SESSION['utente_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error'   => 'auth_required'
    ]);
    exit;
}

// ── DATI IN INGRESSO ──
$idProdotto = $_POST['id_prodotto'] ?? null;
$quantita   = (int)($_POST['quantita'] ?? 1);

if (!$idProdotto) {
    http_response_code(400);
    echo json_encode([
        'success'   => false,
        'messaggio' => 'ID prodotto mancante'
    ]);
    exit;
}

// ── SIMULAZIONE CARRELLO IN SESSIONE ──
// (il vero Control lo farà tramite Entity/Repository di T2)
if (!isset($_SESSION['mock_cart_count'])) {
    $_SESSION['mock_cart_count'] = 0;
}
$_SESSION['mock_cart_count'] += $quantita;

echo json_encode([
    'success'    => true,
    'cart_count' => $_SESSION['mock_cart_count']
]);
exit;