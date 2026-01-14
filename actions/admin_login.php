<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = $admin;
            header("Location: index.php?page=admin_dashboard");
            exit;
        } else {
            header("Location: index.php?page=admin_login&error=Invalid Credentials");
            exit;
        }

    } catch (Exception $e) {
        header("Location: index.php?page=admin_login&error=System Error");
    }
}
?>
