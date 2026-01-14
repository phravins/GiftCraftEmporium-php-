<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$db = Database::getConnection();
$user_id = $_SESSION['user']['id'];

$stmt = $db->prepare("SELECT c.*, p.name, p.price, p.image_url FROM carts c JOIN products p ON c.product_id = p.id WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
    
    <?php if (empty($cart_items)): ?>
        <p class="text-gray-600">Your cart is empty. <a href="index.php" class="text-indigo-600 underline">Continue shopping</a></p>
    <?php else: ?>
        <div class="bg-white rounded shadow p-6 mb-6">
            <?php foreach ($cart_items as $item): ?>
            <div class="flex items-center justify-between border-b py-4 last:border-0">
                <div class="flex items-center">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="w-16 h-16 object-cover rounded mr-4">
                    <div>
                        <h3 class="font-bold"><?= htmlspecialchars($item['name']) ?></h3>
                        <p class="text-sm text-gray-500">$<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?></p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="font-bold text-lg">$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                    <form action="index.php?action=remove_from_cart" method="POST">
                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
            
            <div class="mt-6 flex justify-end">
                <div class="text-right">
                    <p class="text-2xl font-bold mb-4 text-gray-800">Total: <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">$<?= number_format($total, 2) ?></span></p>
                    <a href="index.php?page=checkout" class="inline-block bg-gradient-to-r from-green-500 to-teal-500 text-white px-8 py-3 rounded-full font-bold hover:from-green-600 hover:to-teal-600 shadow-lg transform hover:-translate-y-0.5 transition-all text-lg">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
