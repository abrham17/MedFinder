<?php
// MedFinder Ethiopia - Admin Authentication Check
// Verifies admin session and redirects if not authenticated

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    set_flash_message('Please login to access the admin panel', 'warning');
    redirect('login.php');
}

// Optional: Check session timeout
if (isset($_SESSION['admin_last_activity'])) {
    $inactive_time = time() - $_SESSION['admin_last_activity'];
    if ($inactive_time > SESSION_LIFETIME) {
        session_unset();
        session_destroy();
        set_flash_message('Session expired. Please login again.', 'warning');
        redirect('login.php');
    }
}

// Update last activity time
$_SESSION['admin_last_activity'] = time();
