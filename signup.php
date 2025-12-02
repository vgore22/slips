<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
        $err = "Invalid input or password too short (min 6).";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) $err = "Email already registered.";
        else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->execute([$name,$email,$hash]);
            header('Location: login.php?msg=registered');
            exit;
        }
    }
}
?>
<!doctype html>
<html><head>
<title>Signup - CS Study Hub</title>
<link rel="stylesheet" href="styles.css">
</head><body>
<header><h1>CS Study Hub</h1></header>
<section class="section">
  <h2>Create Account</h2>
  <?php if(!empty($err)) echo '<p class="err">'.$err.'</p>'; ?>
  <form method="post">
    <label>Name</label><input name="name" required>
    <label>Email</label><input name="email" type="email" required>
    <label>Password</label><input name="password" type="password" required>
    <button class="btn" type="submit">Signup</button>
  </form>
  <p>Already registered? <a href="login.php">Login</a></p>
</section>
</body></html
