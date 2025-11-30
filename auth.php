<?php
session_start();

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/index.php");
        exit();
    }
}

function check_role($role) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
        header("Location: ../public/index.php");
        exit();
    }
}
?>
