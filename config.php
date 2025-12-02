<?php
// config.php
session_start();

$db_host = 'localhost';
$db_name = 'csstudyhub';
$db_user = 'cs_user';
$db_pass = 'your_password_here';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (Exception $e) {
    exit('DB connection failed: ' . $e->getMessage());
}

// Helper: require login
function ensure_logged_in() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}
?>
