<?php
$page_title = 'Archive Medicine - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Archive medicine</p>
                    <h2>Archive Amoxicillin 500mg?</h2>
                    <!-- Backend: perform a soft delete or archive action. -->
                </div>
                <div class="alert alert-warning">Archived medicines will no longer appear for pharmacies.</div>
                <div class="form-footer">
                    <a class="btn btn-primary" href="index.php">Confirm archive</a>
                    <a class="btn btn-secondary" href="index.php">Cancel</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
