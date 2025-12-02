<?php
require 'config.php';
ensure_logged_in();

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) { http_response_code(400); exit; }

$test_id = (int)$input['test_id'];
$answers = $input['answers']; // {question_id: 'a'...}
$time_taken = (int)($input['time_taken'] ?? 0);

if (!$test_id || !is_array($answers)) { http_response_code(400); echo json_encode(['error'=>'bad']); exit; }

// fetch correct answers
$in = implode(',', array_map('intval', array_keys($answers)));
if (!$in) { $in = '0'; }
$stmt = $pdo->query("SELECT id, correct FROM questions WHERE id IN ($in)");
$correctMap = [];
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) $correctMap[$r['id']] = $r['correct'];

$score = 0; $total = 0;
foreach ($answers as $qid => $ans) {
    $qid = (int)$qid;
    if (!isset($correctMap[$qid])) continue;
    $total++;
    if (strtolower($ans) === strtolower($correctMap[$qid])) $score++;
}

// store
$stmt = $pdo->prepare("INSERT INTO test_results (test_id,user_id,score,total,time_taken_seconds) VALUES (?,?,?,?,?)");
$stmt->execute([$test_id, $_SESSION['user_id'], $score, $total, $time_taken]);

echo json_encode(['score'=>$score,'total'=>$total]);
