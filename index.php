<?php
session_start();
require_once '../config/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if (empty($username) || empty($password) || empty($role)) {
        $message = "Fadlan buuxi dhammaan xogta.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password_hash']) && $user['role'] === $role) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($role === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../staff/dashboard.php");
                }
                exit();
            } else {
                $message = "Username, password, ama role waa khalad.";
            }
        } else {
            $message = "User lama helin.";
        }
        $stmt->close();
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Login - Zahra Sacad Mini Market</h2>

<?php if ($message): ?>
    <p style="color:red;"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form method="POST" action="index.php" class="form-container">
    <label>Username:</label><br/>
    <input type="text" name="username" required /><br/><br/>

    <label>Password:</label><br/>
    <input type="password" name="password" required /><br/><br/>

    <label>Role:</label><br/>
    <select name="role" required>
        <option value="">-- Doorasho --</option>
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
    </select><br/><br/>

    <button type="submit">Login</button>
</form>

<?php include '../includes/footer.php'; ?>
