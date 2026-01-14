<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - GiftShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <nav class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php?page=admin_dashboard" class="text-xl font-bold">Admin Panel</a>
            <div class="flex space-x-4">
                <span class="text-gray-300">Welcome, <?= htmlspecialchars($admin['username']) ?></span>
                <a href="index.php?page=admin_dashboard" class="hover:text-white">Dashboard</a>
                <a href="index.php?action=logout_admin" class="text-red-400 hover:text-red-300">Logout</a>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-6 py-8 flex-grow">
