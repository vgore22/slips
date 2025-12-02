<?php
require 'config.php';
$stmt = $pdo->query("SELECT p.*, u.name AS uploader FROM pdfs p LEFT JOIN users u ON p.uploaded_by = u.id ORDER BY p.uploaded_at DESC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($rows);
