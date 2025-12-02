<?php
require 'config.php';
ensure_logged_in();
$tests = $pdo->query("SELECT * FROM tests ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><head><title>Take Test</title><link rel="stylesheet" href="styles.css"></head><body>
<header><h1>Take Test</h1><a href="dashboard.php" class="btn">Dashboard</a></header>
<section class="section">
  <h2>Available Tests</h2>
  <?php foreach($tests as $t): ?>
    <div class="card">
      <h3><?php echo htmlspecialchars($t['title']); ?></h3>
      <p>Duration: <?php echo $t['duration_minutes']; ?> minutes</p>
      <button class="btn startTest" data-test="<?php echo $t['id']; ?>" data-duration="<?php echo $t['duration_minutes']; ?>">Start Test</button>
    </div>
  <?php endforeach; ?>
</section>

<!-- Test area -->
<div id="testArea" style="display:none;">
  <h3 id="testTitle"></h3>
  <div id="timer">Timer: <span id="timeLeft"></span></div>
  <form id="testForm">
    <div id="questionsWrap"></div>
    <button class="btn" id="submitTest" type="button">Submit</button>
  </form>
</div>

<script src="script.js"></script>
</body></html>
