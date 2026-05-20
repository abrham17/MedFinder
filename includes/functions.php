<?php
// MedFinder Ethiopia - Helper Functions
// Common utility functions used throughout the application

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Input sanitization
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Redirect to a URL
function redirect($url) {
    header("Location: $url");
    exit();
}

// Set flash message for display on next page
function set_flash_message($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

// Get and clear flash message
function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'];
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

// Check if pharmacy is logged in
function check_pharmacy_session() {
    if (!isset($_SESSION['pharmacy_id'])) {
        set_flash_message('Please login to access this page', 'warning');
        redirect('../pharmacy/login.php');
    }
}

// Check if admin is logged in
function check_admin_session() {
    if (!isset($_SESSION['admin_id'])) {
        set_flash_message('Please login to access this page', 'warning');
        redirect('login.php');
    }
}

// Format Ethiopian phone number
function format_ethiopian_phone($phone) {
    // Remove all non-digit characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // If starts with 0, replace with +251
    if (strpos($phone, '0') === 0) {
        $phone = '251' . substr($phone, 1);
    }
    
    // Format: +251 9X XXX XXXX
    if (strlen($phone) === 12) {
        return '+' . substr($phone, 0, 3) . ' ' . substr($phone, 3, 1) . substr($phone, 4, 2) . ' ' . substr($phone, 6, 3) . ' ' . substr($phone, 9, 4);
    }
    
    return $phone;
}

// Convert timestamp to "time ago" format
function time_ago($timestamp) {
    $time = strtotime($timestamp);
    $current = time();
    $difference = $current - $time;
    
    $intervals = [
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    ];
    
    foreach ($intervals as $seconds => $label) {
        $count = floor($difference / $seconds);
        if ($count > 0) {
            return $count . ' ' . $label . ($count > 1 ? 's' : '') . ' ago';
        }
    }
    
    return 'Just now';
}

// Render status badge HTML
function render_status_badge($status) {
    $classes = [
        'in_stock' => 'badge-success',
        'limited' => 'badge-warning',
        'out_of_stock' => 'badge-danger',
        'active' => 'badge-success',
        'pending' => 'badge-warning',
        'suspended' => 'badge-danger'
    ];
    
    $labels = [
        'in_stock' => 'In Stock',
        'limited' => 'Limited',
        'out_of_stock' => 'Out of Stock',
        'active' => 'Active',
        'pending' => 'Pending',
        'suspended' => 'Suspended'
    ];
    
    $class = $classes[$status] ?? 'badge-default';
    $label = $labels[$status] ?? ucfirst(str_replace('_', ' ', $status));
    
    return "<span class='badge $class'>$label</span>";
}

// Generate CSRF token
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Validate email format
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Validate Ethiopian phone number
function validate_phone($phone) {
    // Remove all non-digit characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Check if it's 9 digits (with 0 prefix) or 12 digits (with 251 prefix)
    if (strlen($phone) === 9 && strpos($phone, '0') === 0) {
        return true;
    }
    if (strlen($phone) === 12 && strpos($phone, '251') === 0) {
        return true;
    }
    
    return false;
}

// Handle file upload
function handle_file_upload($file, $upload_dir, $allowed_extensions) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'File upload error'];
    }
    
    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'error' => 'File too large'];
    }
    
    // Get file extension
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Check if extension is allowed
    if (!in_array($file_ext, $allowed_extensions)) {
        return ['success' => false, 'error' => 'Invalid file type'];
    }
    
    // Generate unique filename
    $filename = uniqid() . '.' . $file_ext;
    $filepath = $upload_dir . $filename;
    
    // Create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file'];
}

// Database query functions
function get_pharmacy_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT p.*, n.name as neighborhood_name FROM pharmacies p LEFT JOIN neighborhoods n ON p.neighborhood_id = n.neighborhood_id WHERE p.pharmacy_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function get_all_medicines($conn) {
    $sql = "SELECT * FROM medicines ORDER BY medicine_name ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_all_neighborhoods($conn) {
    $sql = "SELECT * FROM neighborhoods ORDER BY name ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function search_pharmacies_by_medicine($conn, $medicine_name, $neighborhood_id = null, $status_filter = null) {
    $sql = "SELECT p.*, n.name as neighborhood_name, i.quantity, i.price, i.status as stock_status, m.medicine_name 
            FROM pharmacies p
            JOIN inventory i ON p.pharmacy_id = i.pharmacy_id
            JOIN medicines m ON i.medicine_id = m.medicine_id
            LEFT JOIN neighborhoods n ON p.neighborhood_id = n.neighborhood_id
            WHERE m.medicine_name LIKE ? AND p.status = 'active'";
    
    $params = ["%$medicine_name%"];
    $types = "s";
    
    if ($neighborhood_id) {
        $sql .= " AND p.neighborhood_id = ?";
        $params[] = $neighborhood_id;
        $types .= "i";
    }
    
    if ($status_filter) {
        $sql .= " AND i.status = ?";
        $params[] = $status_filter;
        $types .= "s";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
