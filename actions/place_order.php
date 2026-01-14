<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $address = $_POST['address'];

    try {
        $db = Database::getConnection();
        $db->beginTransaction();

        // Calculate Total
        $stmt = $db->prepare("SELECT c.product_id, c.quantity, p.price FROM carts c JOIN products p ON c.product_id = p.id WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $items = $stmt->fetchAll();

        if (empty($items)) {
            throw new Exception("Cart is empty");
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Order
        $stmt = $db->prepare("INSERT INTO orders (user_id, total_amount, status, shipping_address) VALUES (?, ?, 'pending', ?)");
        $stmt->execute([$user_id, $total, $address]);
        $order_id = $db->lastInsertId();

        // Create Order Items
        $insertStmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($items as $item) {
            $insertStmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
        }

        // Clear Cart
        $db->prepare("DELETE FROM carts WHERE user_id = ?")->execute([$user_id]);

        // Update User Address (optional, but good for UX)
        $db->prepare("UPDATE users SET address = ? WHERE id = ?")->execute([$address, $user_id]);

        $db->commit();
        header("Location: index.php?page=orders&msg=Order Placed Successfully");
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        header("Location: index.php?page=checkout&error=" . urlencode($e->getMessage()));
    }
}
?>
