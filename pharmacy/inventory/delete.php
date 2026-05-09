<?php
$page_title = 'Remove Inventory Item - Pharmacy';
$asset_path = '../../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Remove item</p>
                    <h2>Remove Metformin 500mg?</h2>
                    <!-- Backend: delete or archive the inventory item. -->
                </div>
                <div class="alert alert-warning">This medicine will no longer appear in search results.</div>
                <div class="form-footer">
                    <a class="btn btn-primary" href="index.php">Confirm removal</a>
                    <a class="btn btn-secondary" href="index.php">Cancel</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
