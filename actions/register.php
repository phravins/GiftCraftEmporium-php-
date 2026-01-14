<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE phone = ?");
        $stmt->execute([$phone]);
        if ($stmt->fetch()) {
            header("Location: index.php?page=register&error=Phone number already registered used");
            exit;
        }

        $stmt = $db->prepare("INSERT INTO users (name, phone, address) VALUES (?, ?, ?)");
        $stmt->execute([$name, $phone, $address]);

        header("Location: index.php?page=login&msg=Registration successful. Please login.");
        exit;

    } catch (Exception $e) {
        header("Location: index.php?page=register&error=" . urlencode($e->getMessage()));
    }
}
?>
