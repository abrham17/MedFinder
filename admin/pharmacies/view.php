<?php
$page_title = 'Pharmacy Details - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy profile</p>
                <h1 class="page-title">Unity Pharmacy</h1>
                <p class="page-subtitle">Bole, Atlas Area | Status: Active</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Pharmacies</a>
                    <span>/</span>
                    <span>View</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">Back to list</a>
                <a class="btn btn-primary" href="approve.php">Update status</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container profile-grid">
            <div class="profile-main">
                <div class="panel">
                    <h3 class="panel-title">Pharmacy details</h3>
                    <div class="info-list">
                        <div class="info-row">
                            <span>Owner</span>
                            <span>Hana Mulu</span>
                        </div>
                        <div class="info-row">
                            <span>Phone</span>
                            <span>+251 91 234 5678</span>
                        </div>
                        <div class="info-row">
                            <span>Email</span>
                            <span>unity@pharmacy.et</span>
                        </div>
                        <div class="info-row">
                            <span>License</span>
                            <span>ETH-12345</span>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3 class="panel-title">Inventory snapshot</h3>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Insulin (Rapid)</td>
                                    <td><span class="badge badge-success">In stock</span></td>
                                    <td>42</td>
                                    <td>15 minutes ago</td>
                                </tr>
                                <tr>
                                    <td>Metformin 500mg</td>
                                    <td><span class="badge badge-warning">Limited</span></td>
                                    <td>6</td>
                                    <td>1 hour ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="profile-sidebar">
                <div class="panel">
                    <h3 class="panel-title">Status history</h3>
                    <div class="info-list">
                        <div class="info-row">
                            <span>Approved</span>
                            <span>Mar 12, 2026</span>
                        </div>
                        <div class="info-row">
                            <span>Last update</span>
                            <span>Today</span>
                        </div>
                        <div class="info-row">
                            <span>Search views</span>
                            <span>240 this week</span>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <h3 class="panel-title">Admin actions</h3>
                    <div class="form-footer">
                        <a class="btn btn-primary" href="approve.php">Change status</a>
                        <a class="btn btn-secondary" href="delete.php">Suspend pharmacy</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
