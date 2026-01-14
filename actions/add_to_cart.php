<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] ?? 1;
    $user_id = $_SESSION['user']['id'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, quantity FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $existing = $stmt->fetch();

        if ($existing) {
            $new_qty = $existing['quantity'] + $quantity;
            $stmt = $db->prepare("UPDATE carts SET quantity = ? WHERE id = ?");
            $stmt->execute([$new_qty, $existing['id']]);
        } else {
            $stmt = $db->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $product_id, $quantity]);
        }

        header("Location: index.php?page=cart");
        exit;
    } catch (Exception $e) {
        header("Location: index.php?error=Failed to add to cart");
    }
}
?>
