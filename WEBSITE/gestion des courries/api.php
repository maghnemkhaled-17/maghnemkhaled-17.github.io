<?php
// api.php
header('Content-Type: application/json');
require_once 'db.php';

$input = json_decode(file_get_contents('php://input'), true);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM courriers ORDER BY datetime DESC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;
    
    case 'POST':
        $data = $input;
        $stmt = $pdo->prepare("
            INSERT INTO courriers (type, datetime, number, destinataire, expediteur, reference, division, departement, objet, dossier, sous_dossier, fichier_pdf)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['type'],
            $data['datetime'],
            $data['number'],
            $data['to'] ?? null,
            $data['from'] ?? null,
            $data['ref'] ?? null,
            $data['division'],
            $data['dept'],
            $data['subject'],
            $data['dossier'] ?? null,
            $data['sous'] ?? null,
            $data['file'] ?? null
        ]);
        echo json_encode(['success' => true]);
        break;
    
    case 'DELETE':
        $stmt = $pdo->prepare("DELETE FROM courriers WHERE id = ?");
        $stmt->execute([$input['id']]);
        echo json_encode(['success' => true]);
        break;
}
?>