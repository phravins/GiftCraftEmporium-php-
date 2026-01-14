<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$db = Database::getConnection();
$user_id = $_SESSION['user']['id'];

// Recalculate Total
$stmt = $db->prepare("SELECT SUM(quantity * price) FROM carts c JOIN products p ON c.product_id = p.id WHERE user_id = ?");
$stmt->execute([$user_id]);
$total = $stmt->fetchColumn() ?: 0;

if ($total == 0) {
    header("Location: index.php?page=cart");
    exit;
}

// Get stored address
$stmt = $db->prepare("SELECT address FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Checkout</h1>
    
    <div class="mb-6 p-4 bg-gray-50 rounded">
        <h3 class="font-bold mb-2">Order Summary</h3>
        <p class="text-xl">Total to Pay: <span class="font-bold text-indigo-600">$<?= number_format($total, 2) ?></span></p>
    </div>

    <form action="index.php?action=place_order" method="POST">
        <h3 class="text-lg font-bold mb-4">Shipping Location</h3>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Delivery Address</label>
            <textarea name="address" required class="w-full p-2 border rounded h-32" placeholder="Enter your full address..."><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
        </div>
        
        <button type="submit" class="w-full bg-green-600 text-white py-3 rounded font-bold hover:bg-green-700 transition">
            Place Order
        </button>
    </form>
</div>
