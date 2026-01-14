<?php
require_once 'includes/db.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php?page=admin_login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE orders SET status = 'dispatched' WHERE id = ?");
        $stmt->execute([$order_id]);
        
        header("Location: index.php?page=admin_dashboard&msg=Order dispatched");
        exit;
    } catch (Exception $e) {
        header("Location: index.php?page=admin_dashboard&error=Error updating order");
    }
}
?>
