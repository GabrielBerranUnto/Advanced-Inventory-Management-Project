<?php
session_start();

// Already logged in? Go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
exit;
