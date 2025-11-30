<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
check_login();
check_role('staff');

$message = '';

// Fetch products for dropdown
$products = [];
$result = $conn->query("SELECT id, product_name, price FROM products");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if (empty($customer_name) || $product_id <= 0 || $quantity <= 0) {
        $message = "Fadlan buuxi dhammaan xogta si sax ah.";
    } else {
        // Hubi haddii customer jiro, haddii uusan jirin ku dar
        $stmt = $conn->prepare("SELECT id FROM customers WHERE customer_name = ? AND customer_phone = '' LIMIT 1");
        $stmt->bind_param("s", $customer_name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            // Halkan waxaan ku dari karnaa customer cusub haddii loo baahdo (optional)
        }
        $stmt->close();

        // Hel qiimaha product
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($price);
        $stmt->fetch();
        $stmt->close();

        $total_price = $price * $quantity;

        // Ku dar sales table (haddii aad sameysid), halkan waxaan tusaale u sameynaynaa
        // OR waxaad ku qori kartaa sales data meel kale (optional)
        $message = "Alaabta si guul leh ayaa loo iibsaday. Wadarta: $total_price";
    }
}

include '../includes/header.php';
?>

<h2>Buy Item</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form action="buy_item.php" method="POST" class="form-container">
    <label>Magaca Customer:</label><br/>
    <input type="text" name="customer_name" required /><br/><br/>

    <label>Product:</label><br/>
    <select name="product_id" required>
        <option value="">-- Dooro Product --</option>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product['id']; ?>">
                <?php echo htmlspecialchars($product['product_name'] . " - $" . $product['price']); ?>
            </option>
        <?php endforeach; ?>
    </select><br/><br/>

    <label>Quantity:</label><br/>
    <input type="number" name="quantity" min="1" value="1" required /><br/><br/>

    <button type="submit">Buy</button>
</form>

<?php include '../includes/footer.php'; ?>
