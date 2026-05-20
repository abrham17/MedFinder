<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Destroy session
session_unset();
session_destroy();

// Set flash message
set_flash_message('You have been logged out successfully', 'success');

// Redirect to login page
redirect('login.php');
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Signed out</p>
                    <h2>You are now logged out.</h2>
                    <!-- Backend: destroy pharmacy session on logout. -->
                </div>
                <div class="form-footer">
                    <a class="btn btn-primary" href="login.php">Return to login</a>
                    <a class="btn btn-secondary" href="../index.php">Go to homepage</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
