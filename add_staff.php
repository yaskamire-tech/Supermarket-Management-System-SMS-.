<?php
require_once '../includes/auth.php';
require_once '../config/db.php';
check_login();
check_role('admin');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = 'staff'; // staff kaliya lagu dari karaa halkan

    if (empty($username) || empty($password)) {
        $message = "Fadlan buuxi xogta.";
    } else {
        // Hubi haddii username horay u jiro
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username hore ayaa jira.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $username, $password_hash, $role);

            if ($insert->execute()) {
                $message = "Staff si guul leh ayaa loo daray.";
            } else {
                $message = "Khalad ayaa dhacay.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}

include '../includes/header.php';
?>

<h2>Ku dar Staff cusub</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form action="add_staff.php" method="POST" class="form-container">
    <label>Username:</label><br/>
    <input type="text" name="username" required /><br/><br/>

    <label>Password:</label><br/>
    <input type="password" name="password" required /><br/><br/>

    <button type="submit">Add Staff</button>
</form>

<?php include '../includes/footer.php'; ?>
