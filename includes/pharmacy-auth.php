<?php
// MedFinder Ethiopia - Pharmacy Authentication Check
// Verifies pharmacy session and redirects if not authenticated

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Check if pharmacy is logged in
if (!isset($_SESSION['pharmacy_id'])) {
    set_flash_message('Please login to access the pharmacy panel', 'warning');
    redirect('login.php');
}

// Optional: Check session timeout
if (isset($_SESSION['pharmacy_last_activity'])) {
    $inactive_time = time() - $_SESSION['pharmacy_last_activity'];
    if ($inactive_time > SESSION_LIFETIME) {
        session_unset();
        session_destroy();
        set_flash_message('Session expired. Please login again.', 'warning');
        redirect('login.php');
    }
}

// Update last activity time
$_SESSION['pharmacy_last_activity'] = time();

// Optional: Check if pharmacy account is active
require_once __DIR__ . '/db-connect.php';
$pharmacy_id = $_SESSION['pharmacy_id'];

$stmt = $conn->prepare("SELECT status FROM pharmacies WHERE pharmacy_id = ?");
$stmt->bind_param("i", $pharmacy_id);
$stmt->execute();
$result = $stmt->get_result();
$pharmacy = $result->fetch_assoc();

if ($pharmacy && $pharmacy['status'] !== 'active') {
    session_unset();
    session_destroy();
    set_flash_message('Your account is not active. Please contact admin.', 'warning');
    redirect('login.php');
}
