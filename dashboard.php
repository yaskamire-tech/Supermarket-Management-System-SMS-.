<?php
require_once '../includes/auth.php';
check_login();
check_role('staff');
include '../includes/header.php';
?>

<h2>Staff Dashboard</h2>
<p>Ku soo dhawoow, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

<p>Dooro hawsha aad rabto:</p>
<ul>
    <li><a href="add_customer.php">Add Customer</a></li>
    <li><a href="buy_item.php">Buy Item</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<?php include '../includes/footer.php'; ?>
