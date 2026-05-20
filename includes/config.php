<?php
// MedFinder Ethiopia - Configuration File
// Database credentials and site settings

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'medfinder_ethiopia');

// Site Configuration
define('SITE_NAME', 'MedFinder Ethiopia');
define('SITE_URL', 'http://localhost/med/MedFinder');
define('ADMIN_EMAIL', 'admin@medfinder.ethiopia');

// Session Configuration
define('SESSION_NAME', 'medfinder_session');
define('SESSION_LIFETIME', 3600); // 1 hour in seconds

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/pharmacy-logos/');
define('MAX_FILE_SIZE', 2097152); // 2MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Pagination
define('ITEMS_PER_PAGE', 20);

// Error Reporting (Set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Africa/Addis_Ababa');
