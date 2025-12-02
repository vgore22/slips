<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    } else $err = "Invalid credentials.";
}
?>
<!doctype html>
<html><head><title>Login - CS Study Hub</title><link rel="stylesheet" href="styles.css"></head><body>
<header><h1>CS Study Hub</h1></header>
<section class="section">
  <h2>Login</h2>
  <?php if(!empty($_GET['msg'])) echo '<p class="msg">Registered. Please login.</p>'; ?>
  <?php if(!empty($err)) echo '<p class="err">'.$err.'</p>'; ?>
  <form method="post">
    <label>Email</label><input name="email" type="email" required>
    <label>Password</label><input name="password" type="password" required>
    <button class="btn" type="submit">Login</button>
  </form>
  <p>New user? <a href="signup.php">Signup</a></p>
</section>
</body></html>
