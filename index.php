<?php
session_start();
require_once 'includes/db.php';

// Simple Router
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

// Handle Actions (POST requests typically)
if ($action) {
    $actionFile = "actions/{$action}.php";
    if (file_exists($actionFile)) {
        require $actionFile;
        exit;
    }
}

// Global Variables for Views
$user = $_SESSION['user'] ?? null;
$admin = $_SESSION['admin'] ?? null;
$cart_count = 0;

if ($user) {
    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT SUM(quantity) FROM carts WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $cart_count = $stmt->fetchColumn() ?: 0;
    } catch (Exception $e) {}
}
if (strpos($page, 'admin_') === 0) {
    $view = "views/admin/" . substr($page, 6) . ".php";
} else {
    $view = "views/{$page}.php";
}

if (!file_exists($view)) {
    $view = "views/404.php";
}
if (strpos($page, 'admin_') === 0 && $page !== 'admin_login') {
    require 'views/admin/layout_header.php';
    require $view;
    require 'views/admin/layout_footer.php';
} elseif ($page === 'login' || $page === 'admin_login' || $page === 'register') {
    require $view; 
} else {
    require 'views/layout_header.php';
    require $view;
    require 'views/layout_footer.php';
}
?>
