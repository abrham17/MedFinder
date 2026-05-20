<?php
$page_title = 'Pharmacy Login - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../includes/header.php';

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/db-connect.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        set_flash_message('Please fill in all fields', 'warning');
    } else {
        // Check pharmacy credentials
        $stmt = $conn->prepare("SELECT pharmacy_id, pharmacy_name, email, password, status FROM pharmacies WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $pharmacy = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $pharmacy['password'])) {
                // Check account status
                if ($pharmacy['status'] === 'active') {
                    // Set session variables
                    session_regenerate_id(true);
                    $_SESSION['pharmacy_id'] = $pharmacy['pharmacy_id'];
                    $_SESSION['pharmacy_name'] = $pharmacy['pharmacy_name'];
                    $_SESSION['pharmacy_email'] = $pharmacy['email'];
                    $_SESSION['pharmacy_last_activity'] = time();
                    
                    set_flash_message('Welcome back, ' . htmlspecialchars($pharmacy['pharmacy_name']) . '!', 'success');
                    redirect('index.php');
                } elseif ($pharmacy['status'] === 'pending') {
                    set_flash_message('Your account is pending approval. Please wait for admin approval.', 'warning');
                } else {
                    set_flash_message('Your account has been suspended. Please contact admin.', 'error');
                }
            } else {
                set_flash_message('Invalid email or password', 'error');
            }
        } else {
            set_flash_message('Invalid email or password', 'error');
        }
    }
}

// Display flash message if exists
$flash = get_flash_message();
if ($flash) {
    echo "<div class='alert alert-" . $flash['type'] . "'>" . htmlspecialchars($flash['message']) . "</div>";
}
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Pharmacy access</p>
                    <h2>Sign in to your dashboard</h2>
                    <!-- Backend: verify credentials and start the pharmacy session. -->
                </div>
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="pharmacy-email">Email address</label>
                        <input type="email" id="pharmacy-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pharmacy-password">Password</label>
                        <input type="password" id="pharmacy-password" name="password" required>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                        <a class="btn btn-link" href="#">Forgot password?</a>
                    </div>
                </form>
                <div class="auth-footer">
                    <span>New pharmacy? </span><a class="link" href="register.php">Register here</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
