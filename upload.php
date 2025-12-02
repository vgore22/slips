<?php
require 'config.php';
ensure_logged_in();
if ($_SESSION['role'] !== 'admin') {
    exit('Access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $title = trim($_POST['title'] ?? 'Untitled');
    $file = $_FILES['pdf'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (strtolower($ext) !== 'pdf') { $err = "Only PDF allowed."; }
        else {
            $fname = time() . '_' . preg_replace('/[^a-z0-9\-_\.]/i','', $file['name']);
            $dest = __DIR__ . '/pdfs/' . $fname;
            if (move_uploaded_file($file['tmp_name'], $dest)) {
                $stmt = $pdo->prepare("INSERT INTO pdfs (title, filename, uploaded_by) VALUES (?,?,?)");
                $stmt->execute([$title, $fname, $_SESSION['user_id']]);
                $msg = "Uploaded successfully.";
            } else $err = "Upload move failed. Check folder permissions.";
        }
    } else $err = "Upload error code: " . $file['error'];
}
?>
<!doctype html>
<html><head><title>Upload PDF - Admin</title><link rel="stylesheet" href="styles.css"></head><body>
<header><h1>Admin - CS Study Hub</h1><a href="dashboard.php" class="btn">Dashboard</a></header>
<section class="section">
  <h2>Upload PDF</h2>
  <?php if(!empty($msg)) echo '<p class="msg">'.$msg.'</p>'; ?>
  <?php if(!empty($err)) echo '<p class="err">'.$err.'</p>'; ?>
  <form method="post" enctype="multipart/form-data">
    <label>Title</label><input name="title" required>
    <label>PDF File</label><input name="pdf" type="file" accept="application/pdf" required>
    <button class="btn" type="submit">Upload</button>
  </form>
</section>
</body></html>
