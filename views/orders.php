<?php
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$db = Database::getConnection();
$user_id = $_SESSION['user']['id'];

$orders = $db->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY created_at DESC")->fetchAll();

function getOrderItems($db, $order_id) {
    $stmt = $db->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE order_id = ?");
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-extrabold mb-8 text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">My Orders</h1>
    
    <?php if (isset($_GET['msg'])): ?>
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-sm border border-green-200">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <div class="text-center py-12 bg-white rounded-xl shadow-sm">
            <p class="text-gray-500 text-lg mb-4">You haven't placed any orders yet.</p>
            <a href="index.php" class="text-indigo-600 font-bold hover:underline">Start Shopping</a>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($orders as $order): ?>
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="flex justify-between items-center mb-4 border-b pb-4">
                    <div>
                        <span class="font-bold text-lg text-gray-800">Order #<?= $order['id'] ?></span>
                        <span class="text-sm text-gray-500 ml-2 block sm:inline"><?= date('M d, Y', strtotime($order['created_at'])) ?></span>
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                            <?= $order['status'] == 'completed' ? 'bg-green-100 text-green-800' : 
                                ($order['status'] == 'dispatched' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') ?>">
                            <?= ucfirst($order['status']) ?>
                        </span>
                    </div>
                </div>
                
                <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-bold text-gray-700 text-sm mb-2 uppercase tracking-wide">Items</h4>
                    <ul class="space-y-2 text-gray-600">
                        <?php foreach (getOrderItems($db, $order['id']) as $item): ?>
                            <li class="flex justify-between">
                                <span><?= htmlspecialchars($item['name']) ?> <span class="text-gray-400">x<?= $item['quantity'] ?></span></span>
                                <span class="font-medium">$<?= number_format($item['price'], 2) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="flex justify-between items-center mt-4 pt-2">
                    <span class="text-gray-600 text-sm truncate max-w-xs" title="<?= htmlspecialchars($order['shipping_address']) ?>"><span class="font-semibold">Ship to:</span> <?= htmlspecialchars($order['shipping_address']) ?></span>
                    <span class="font-extrabold text-2xl text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">$<?= number_format($order['total_amount'], 2) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
