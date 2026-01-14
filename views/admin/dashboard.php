<?php
if (!isset($_SESSION['admin'])) {
    header("Location: index.php?page=admin_login");
    exit;
}

$db = Database::getConnection();

// 1. Number of orders at every day
$daily_orders = $db->query("SELECT date(created_at) as order_date, COUNT(*) as count FROM orders GROUP BY date(created_at) ORDER BY order_date DESC")->fetchAll();

// 2. Number of items at card (Cart)
$cart_items_count = $db->query("SELECT SUM(quantity) FROM carts")->fetchColumn() ?: 0;

// 3. What is the items to dispatch (Pending Orders)
// User wanted "Items", which usually means Order Items, but lists of Orders is more practical. 
// I will show Orders with their items.
$pending_orders = $db->query("
    SELECT o.*, u.name as user_name, u.phone as user_phone 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.status = 'pending'
    ORDER BY o.created_at ASC
")->fetchAll();

// 4. What are the item dispatched (Dispatched/Completed Orders)
$dispatched_orders = $db->query("
    SELECT o.*, u.name as user_name, u.phone as user_phone 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    WHERE o.status = 'dispatched' OR o.status = 'completed'
    ORDER BY o.created_at DESC
")->fetchAll();

function getOrderItems($db, $order_id) {
    $stmt = $db->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE order_id = ?");
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}
?>

<h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Stat 1: Daily Orders -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4">Orders Per Day</h3>
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Date</th>
                    <th class="py-2">Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daily_orders as $day): ?>
                <tr>
                    <td class="py-2"><?= htmlspecialchars($day['order_date']) ?></td>
                    <td class="py-2 font-bold"><?= $day['count'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Stat 2: Cart Items -->
    <div class="bg-white p-6 rounded shadow flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-700">Items in Active Carts</h3>
            <p class="text-gray-500">Total items currently in user carts</p>
        </div>
        <div class="text-4xl font-bold text-indigo-600">
            <?= $cart_items_count ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-8">
    <!-- To Dispatch -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4 text-orange-600">Pending Orders (To Dispatch)</h3>
        <?php if (empty($pending_orders)): ?>
            <p class="text-gray-500">No pending orders.</p>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($pending_orders as $order): ?>
                <div class="border rounded p-4">
                    <div class="flex justify-between font-bold mb-2">
                        <span>Order #<?= $order['id'] ?> - <?= htmlspecialchars($order['user_name']) ?> (<?= htmlspecialchars($order['user_phone']) ?>)</span>
                        <span>$<?= number_format($order['total_amount'], 2) ?></span>
                    </div>
                    <div class="mb-2 text-sm text-gray-600">Address: <?= htmlspecialchars($order['shipping_address']) ?></div>
                    <div class="bg-gray-50 p-2 rounded">
                        <p class="text-xs font-bold uppercase text-gray-500">Items:</p>
                        <ul class="text-sm list-disc list-inside">
                            <?php foreach (getOrderItems($db, $order['id']) as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>)</li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="mt-3 text-right">
                        <form action="index.php?action=dispatch_order" method="POST" class="inline">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">Mark as Dispatched</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Dispatched -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4 text-green-600">Dispatched Items History</h3>
        <?php if (empty($dispatched_orders)): ?>
            <p class="text-gray-500">No dispatched orders yet.</p>
        <?php else: ?>
             <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="py-2">Order ID</th>
                        <th class="py-2">User</th>
                        <th class="py-2">Items</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dispatched_orders as $order): ?>
                    <tr class="border-b last:border-0 hover:bg-gray-50">
                        <td class="py-2">#<?= $order['id'] ?></td>
                        <td class="py-2"><?= htmlspecialchars($order['user_name']) ?></td>
                        <td class="py-2 text-sm">
                             <?php 
                                $items = getOrderItems($db, $order['id']);
                                foreach ($items as $index => $item) {
                                    echo htmlspecialchars($item['name']) . " (x" . $item['quantity'] . ")";
                                    if ($index < count($items) - 1) echo ", ";
                                }
                             ?>
                        </td>
                        <td class="py-2">
                            <span class="px-2 py-1 rounded text-xs text-white <?= $order['status'] == 'completed' ? 'bg-green-500' : 'bg-blue-500' ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                         <td class="py-2 text-sm text-gray-500"><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
