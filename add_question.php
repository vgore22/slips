<?php
require 'config.php';
ensure_logged_in();
if ($_SESSION['role'] !== 'admin') exit('Access denied.');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_test'])) {
        $title = trim($_POST['test_title']);
        $duration = (int)$_POST['duration'];
        $stmt = $pdo->prepare("INSERT INTO tests (title,duration_minutes) VALUES (?,?)");
        $stmt->execute([$title,$duration]);
        $test_id = $pdo->lastInsertId();
        $msg = "Test created. Now add questions.";
    } elseif (isset($_POST['add_q'])) {
        $test_id = (int)$_POST['test_id'];
        $q = trim($_POST['question']);
        $a = trim($_POST['opt_a']); $b = trim($_POST['opt_b']); $c = trim($_POST['opt_c']); $d = trim($_POST['opt_d']);
        $correct = $_POST['correct'];
        $stmt = $pdo->prepare("INSERT INTO questions (test_id,question,opt_a,opt_b,opt_c,opt_d,correct) VALUES (?,?,?,?,?,?,?)");
        $stmt->execute([$test_id,$q,$a,$b,$c,$d,$correct]);
        $msg = "Question added.";
    }
}
$tests = $pdo->query("SELECT * FROM tests ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><head><title>Add Questions</title><link rel="stylesheet" href="styles.css"></head><body>
<header><h1>Admin - Add Questions</h1><a href="dashboard.php" class="btn">Dashboard</a></header>
<section class="section">
  <?php if(!empty($msg)) echo '<p class="msg">'.$msg.'</p>'; ?>

  <h3>Create Test</h3>
  <form method="post">
    <label>Title</label><input name="test_title" required>
    <label>Duration (minutes)</label><input name="duration" type="number" value="10" required>
    <button class="btn" name="create_test" type="submit">Create Test</button>
  </form>

  <h3>Add Question</h3>
  <form method="post">
    <label>Choose Test</label>
    <select name="test_id" required>
      <?php foreach($tests as $t): ?>
        <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['title']); ?></option>
      <?php endforeach; ?>
    </select>

    <label>Question</label><textarea name="question" required></textarea>
    <label>Option A</label><input name="opt_a" required>
    <label>Option B</label><input name="opt_b" required>
    <label>Option C</label><input name="opt_c" required>
    <label>Option D</label><input name="opt_d" required>
    <label>Correct (a/b/c/d)</label><input name="correct" maxlength="1" pattern="[a-d]" required>

    <button class="btn" name="add_q" type="submit">Add Question</button>
  </form>
</section>
</body></html>
