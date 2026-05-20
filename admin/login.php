<?php
$page_title = 'Admin Login - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../includes/header.php';

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/db-connect.php';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        set_flash_message('Please fill in all fields', 'warning');
    } else {
        // Check admin credentials
        $stmt = $conn->prepare("SELECT admin_id, username, email, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $admin['password'])) {
                // Set session variables
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_last_activity'] = time();
                
                set_flash_message('Welcome, ' . htmlspecialchars($admin['username']) . '!', 'success');
                redirect('index.php');
            } else {
                set_flash_message('Invalid username or password', 'error');
            }
        } else {
            set_flash_message('Invalid username or password', 'error');
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
                    <p class="eyebrow">Admin access</p>
                    <h2>Sign in to the admin panel</h2>
                    <!-- Backend: authenticate using secure session checks. -->
                </div>
                <form action="index.php" method="post">
                    <div class="form-group">
                        <label for="admin-username">Username</label>
                        <input type="text" id="admin-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="admin-password">Password</label>
                        <input type="password" id="admin-password" name="password" required>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                    </div>
                </form>
                <div class="auth-footer">
                    <a class="link" href="../index.php">Back to website</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
