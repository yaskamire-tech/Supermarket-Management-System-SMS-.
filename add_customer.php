<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
check_login();
check_role('staff');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $customer_phone = trim($_POST['customer_phone']);

    if (empty($customer_name) || empty($customer_phone)) {
        $message = "Fadlan buuxi xogta.";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (customer_name, customer_phone) VALUES (?, ?)");
        $stmt->bind_param("ss", $customer_name, $customer_phone);

        if ($stmt->execute()) {
            $message = "Customer si guul leh ayaa loo daray.";
        } else {
            $message = "Khalad ayaa dhacay.";
        }
        $stmt->close();
    }
}

include '../includes/header.php';
?>

<h2>Ku dar Customer cusub (Staff)</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form action="add_customer.php" method="POST" class="form-container">
    <label>Magaca Customer:</label><br/>
    <input type="text" name="customer_name" required /><br/><br/>

    <label>Numberka Customer:</label><br/>
    <input type="text" name="customer_phone" required /><br/><br/>

    <button type="submit">Add Customer</button>
</form>

<?php include '../includes/footer.php'; ?>
