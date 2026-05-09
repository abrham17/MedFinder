<?php
$page_title = 'Admin Dashboard - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Admin dashboard</p>
                <h1 class="page-title">System overview</h1>
                <p class="page-subtitle">Monitor pharmacy onboarding, medicine catalog updates, and search activity.</p>
                <div class="breadcrumb">
                    <a href="index.php">Admin</a>
                    <span>/</span>
                    <span>Dashboard</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="medicines/add.php">Add medicine</a>
                <a class="btn btn-secondary" href="pharmacies/index.php">Manage pharmacies</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container stat-grid">
            <div class="stat-card reveal">
                <h3>128</h3>
                <p>Total pharmacies</p>
            </div>
            <div class="stat-card reveal delay-1">
                <h3>18</h3>
                <p>Pending approvals</p>
            </div>
            <div class="stat-card reveal delay-2">
                <h3>3,820</h3>
                <p>Medicines in catalog</p>
            </div>
            <div class="stat-card reveal delay-3">
                <h3>540</h3>
                <p>Searches today</p>
            </div>
        </div>
    </section>

    <section class="section section-accent">
        <div class="container page-layout">
            <div class="content-area">
                <div class="panel">
                    <h3 class="panel-title">Pending pharmacy approvals</h3>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pharmacy</th>
                                    <th>Owner</th>
                                    <th>Neighborhood</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Unity Pharmacy</td>
                                    <td>Hana Mulu</td>
                                    <td>Bole</td>
                                    <td><span class="pill pill-warning">Pending</span></td>
                                    <td class="table-actions">
                                        <a class="btn btn-secondary" href="pharmacies/approve.php">Review</a>
                                        <a class="btn btn-link" href="pharmacies/view.php">Details</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>BlueCross Pharmacy</td>
                                    <td>Tsegaye Bekele</td>
                                    <td>Yeka</td>
                                    <td><span class="pill pill-warning">Pending</span></td>
                                    <td class="table-actions">
                                        <a class="btn btn-secondary" href="pharmacies/approve.php">Review</a>
                                        <a class="btn btn-link" href="pharmacies/view.php">Details</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <h3 class="panel-title">Quick tasks</h3>
                <div class="info-list">
                    <div class="info-row">
                        <span>New medicines</span>
                        <span>12 requests</span>
                    </div>
                    <div class="info-row">
                        <span>Suspended pharmacies</span>
                        <span>3 accounts</span>
                    </div>
                    <div class="info-row">
                        <span>Neighborhood edits</span>
                        <span>5 updates</span>
                    </div>
                </div>
                <div class="form-footer">
                    <a class="btn btn-primary" href="medicines/index.php">Review catalog</a>
                    <a class="btn btn-secondary" href="neighborhoods/index.php">Manage neighborhoods</a>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
