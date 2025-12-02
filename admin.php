<?php
require 'config.php';
ensure_logged_in();
if ($_SESSION['role'] !== 'admin') exit('Access denied.');
?>
<!doctype html><html><head><title>Admin - Dashboard</title><link rel="stylesheet" href="styles.css"></head><body>
<header><h1>Admin Dashboard</h1><a href="logout.php" class="btn">Logout</a></header>
<section class="section">
  <div class="card">
    <h3>Manage PDFs</h3>
    <a href="upload.php" class="btn">Upload PDF</a>
    <a href="fetch_pdfs.php" class="btn">List PDFs (JSON)</a>
  </div>

  <div class="card">
    <h3>Tests & Questions</h3>
    <a href="add_question.php" class="btn">Create Test / Add Questions</a>
  </div>

  <div class="card">
    <h3>Users</h3>
    <?php
      $users = $pdo->query("SELECT id,name,email,role,created_at FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
      echo "<table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead><tbody>";
      foreach($users as $u) {
        echo "<tr><td>{$u['id']}</td><td>".htmlspecialchars($u['name'])."</td><td>".htmlspecialchars($u['email'])."</td><td>{$u['role']}</td><td>{$u['created_at']}</td></tr>";
      }
      echo "</tbody></table>";
    ?>
  </div>
</section>
</body></html>
