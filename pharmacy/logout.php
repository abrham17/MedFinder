<?php
$page_title = 'Pharmacy Logout - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../includes/header.php';
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
