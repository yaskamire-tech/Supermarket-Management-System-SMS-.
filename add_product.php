<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
check_login();
check_role('admin');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $price = floatval($_POST['price']);

    if (empty($product_name) || $price <= 0) {
        $message = "Fadlan buuxi xogta si sax ah.";
    } else {
        $stmt = $conn->prepare("INSERT INTO products (product_name, price) VALUES (?, ?)");
        $stmt->bind_param("sd", $product_name, $price);

        if ($stmt->execute()) {
            $message = "Product si guul leh ayaa loo daray.";
        } else {
            $message = "Khalad ayaa dhacay.";
        }
        $stmt->close();
    }
}

include '../includes/header.php';
?>

<h2>Ku dar Product cusub</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form action="add_product.php" method="POST" class="form-container">
    <label>Product Name:</label><br/>
    <input type="text" name="product_name" required /><br/><br/>

    <label>Price:</label><br/>
    <input type="number" step="0.01" name="price" required /><br/><br/>

    <button type="submit">Add Product</button>
</form>

<?php include '../includes/footer.php'; ?>
