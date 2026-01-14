<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user']['id'];

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $rating, $comment]);

        header("Location: index.php?page=product&id=$product_id&msg=Review added");
        exit;
    } catch (Exception $e) {
        header("Location: index.php?page=product&id=$product_id&error=Failed to add review");
    }
}
?>
