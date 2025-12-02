<?php
require 'config.php';
$test_id = (int)($_GET['test_id'] ?? 0);
if (!$test_id) { http_response_code(400); echo json_encode([]); exit; }
$stmt = $pdo->prepare("SELECT id,question,opt_a,opt_b,opt_c,opt_d FROM questions WHERE test_id = ?");
$stmt->execute([$test_id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($rows);
