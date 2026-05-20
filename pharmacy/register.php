<?php
$page_title = 'Pharmacy Registration - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/pharmacy.css');
$extra_js = array('js/validation.js');
$body_class = 'pharmacy-body';
include '../includes/header.php';

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/db-connect.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Sanitize inputs
    $pharmacy_name = sanitize_input($_POST['pharmacy_name']);
    $owner_name = sanitize_input($_POST['owner_name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $neighborhood_id = (int)$_POST['neighborhood'];
    $license_number = sanitize_input($_POST['license_number']);
    $address = sanitize_input($_POST['address']);
    $operating_hours = sanitize_input($_POST['operating_hours']);
    
    // Validate required fields
    if (empty($pharmacy_name)) $errors[] = "Pharmacy name is required";
    if (empty($owner_name)) $errors[] = "Owner name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($password)) $errors[] = "Password is required";
    if (empty($license_number)) $errors[] = "License number is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($neighborhood_id)) $errors[] = "Neighborhood is required";
    
    // Validate email format
    if (!validate_email($email)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate phone format
    if (!validate_phone($phone)) {
        $errors[] = "Invalid phone number format (use +251 or 09 format)";
    }
    
    // Validate password
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }
    
    // Check password confirmation
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT pharmacy_id FROM pharmacies WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "Email already registered";
    }
    
    // Check if phone already exists
    $stmt = $conn->prepare("SELECT pharmacy_id FROM pharmacies WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "Phone number already registered";
    }
    
    // Handle logo upload
    $logo_filename = null;
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $upload_result = handle_file_upload($_FILES['logo'], UPLOAD_DIR, ALLOWED_EXTENSIONS);
        if ($upload_result['success']) {
            $logo_filename = $upload_result['filename'];
        } else {
            $errors[] = $upload_result['error'];
        }
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert pharmacy
        $stmt = $conn->prepare("INSERT INTO pharmacies (pharmacy_name, owner_name, email, phone, password, address, neighborhood_id, license_number, logo, operating_hours, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssssissss", $pharmacy_name, $owner_name, $email, $phone, $password_hash, $address, $neighborhood_id, $license_number, $logo_filename, $operating_hours);
        
        if ($stmt->execute()) {
            set_flash_message("Registration successful! Your account is pending approval. You will be notified when approved.", "success");
            redirect('login.php');
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
    
    // If errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}

// Get neighborhoods for dropdown
$neighborhoods = get_all_neighborhoods($conn);
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy registration</p>
                <h1 class="page-title">Join MedFinder</h1>
                <p class="page-subtitle">Submit your pharmacy details for approval and start publishing inventory.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Home</a>
                    <span>/</span>
                    <span>Register pharmacy</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="login.php">Already registered? Log in</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="form-card">
                <h3>Registration form</h3>
                <!-- Backend: validate fields, upload logo, and store pending status. -->
                <form action="login.php" method="post" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pharmacy-name">Pharmacy name</label>
                            <input type="text" id="pharmacy-name" name="pharmacy_name" required>
                        </div>
                        <div class="form-group">
                            <label for="owner-name">Owner name</label>
                            <input type="text" id="owner-name" name="owner_name" required>
                        </div>
                        <div class="form-group">
                            <label for="register-email">Email address</label>
                            <input type="email" id="register-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="register-phone">Phone number</label>
                            <input type="tel" id="register-phone" name="phone" placeholder="+251 9x xxx xxxx" required>
                        </div>
                        <div class="form-group">
                            <label for="register-password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="register-confirm">Confirm password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required>
                            <span class="form-note" id="password-help">Passwords must match.</span>
                        </div>
                        <div class="form-group">
                            <label for="register-neighborhood">Neighborhood</label>
                            <select id="register-neighborhood" name="neighborhood" required>
                                <option value="">Select neighborhood</option>
                                <option value="bole">Bole</option>
                                <option value="kirkos">Kirkos</option>
                                <option value="arada">Arada</option>
                                <option value="yeka">Yeka</option>
                                <option value="lideta">Lideta</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="register-license">License number</label>
                            <input type="text" id="register-license" name="license_number" required>
                        </div>
                        <div class="form-group form-group-full">
                            <label for="register-address">Address</label>
                            <textarea id="register-address" name="address" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="register-hours">Operating hours</label>
                            <input type="text" id="register-hours" name="operating_hours" placeholder="8:00 AM - 9:00 PM">
                        </div>
                        <div class="form-group">
                            <label for="register-logo">Upload logo (optional)</label>
                            <input type="file" id="register-logo" name="logo">
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Submit registration</button>
                        <span class="form-note">Approval required before account activation.</span>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
