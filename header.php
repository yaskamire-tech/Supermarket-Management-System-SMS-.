<?php
session_start();
?>
<!DOCTYPE html>
<html lang="so">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Zahra Sacad Mini Market</title>
    <link rel="stylesheet" href="../public/css/styles.css" />
</head>
<body>
<header>
    <nav class="navbar">
        <a href="<?php echo (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') ? '../admin/dashboard.php' : '../staff/dashboard.php'; ?>">Dashboard</a>
        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="../admin/add_staff.php">Add Staff</a>
                <a href="../admin/add_product.php">Add Product</a>
                <a href="../admin/add_customer.php">Add Customer</a>
            <?php elseif ($_SESSION['role'] == 'staff'): ?>
                <a href="../staff/add_customer.php">Add Customer</a>
                <a href="../staff/buy_item.php">Buy Item</a>
            <?php endif; ?>
            <a href="<?php echo (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') ? '../admin/logout.php' : '../staff/logout.php'; ?>">Logout</a>
        <?php else: ?>
            <a href="../public/index.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>
