<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($phone)) {
        header("Location: index.php?page=login&error=All fields required");
        exit;
    }

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$phone]);
        $user = $stmt->fetch();

        if ($user) {
            if (strcasecmp($user['name'], $name) === 0) {
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            } else {
                header("Location: index.php?page=login&error=Name does not match the phone number");
                exit;
            }
        } else {
            header("Location: index.php?page=login&error=Phone number not found. Please register.");
            exit;
        }
    } catch (Exception $e) {
        header("Location: index.php?page=login&error=System Error");
    }
}
?>
