<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user']['id'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM carts WHERE id = ? AND user_id = ?");
        $stmt->execute([$cart_id, $user_id]);
        
        header("Location: index.php?page=cart");
        exit;
    } catch (Exception $e) {
        header("Location: index.php?page=cart&error=Error removing item");
    }
}
?>
