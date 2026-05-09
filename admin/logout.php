<?php
$page_title = 'Admin Logout - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../includes/header.php';
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Signed out</p>
                    <h2>You have been logged out.</h2>
                    <!-- Backend: destroy admin session on logout. -->
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
