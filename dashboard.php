<?php
require 'config.php';
ensure_logged_in();

$user_id = $_SESSION['user_id'];
// user's results
$stmt = $pdo->prepare("SELECT tr.*, t.title FROM test_results tr LEFT JOIN tests t ON tr.test_id = t.id WHERE tr.user_id = ? ORDER BY taken_at DESC");
$stmt->execute([$user_id]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// user's uploaded pdfs? usually admin uploads; show downloaded history not implemented (needs more storage)
?>
<!doctype html><html><head><title>Dashboard</title><link rel="stylesheet" href="styles.css"></head><body>
<header><h1>Dashboard</h1><nav><a href="index.html">Home</a> <a href="notes.php">Notes</a> <a href="take_test.php">Take Test</a> <a href="logout.php">Logout</a></nav></header>
<section class="section">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

  <h3>Your Test Results</h3>
  <?php if(!$results) echo "<p>No test results yet.</p>"; else: ?>
    <table class="results-table">
      <thead><tr><th>Test</th><th>Score</th><th>Total</th><th>Time (s)</th><th>Taken at</th></tr></thead>
      <tbody>
        <?php foreach($results as $r): ?>
          <tr>
            <td><?php echo htmlspecialchars($r['title']); ?></td>
            <td><?php echo $r['score']; ?></td>
            <td><?php echo $r['total']; ?></td>
            <td><?php echo $r['time_taken_seconds']; ?></td>
            <td><?php echo $r['taken_at']; ?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  <?php endif; ?>
</section>
</body></html>
