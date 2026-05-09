<?php
$page_title = 'Pharmacy Dashboard - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy dashboard</p>
                <h1 class="page-title">Welcome back, Unity Pharmacy</h1>
                <p class="page-subtitle">Update inventory, track stock, and reach more patients.</p>
                <div class="breadcrumb">
                    <a href="index.php">Pharmacy</a>
                    <span>/</span>
                    <span>Dashboard</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="inventory/add.php">Add medicine</a>
                <a class="btn btn-secondary" href="profile.php">Edit profile</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container stat-grid">
            <div class="stat-card reveal">
                <h3>52</h3>
                <p>Medicines in stock</p>
            </div>
            <div class="stat-card reveal delay-1">
                <h3>8</h3>
                <p>Low stock alerts</p>
            </div>
            <div class="stat-card reveal delay-2">
                <h3>120</h3>
                <p>Search views this week</p>
            </div>
            <div class="stat-card reveal delay-3">
                <h3>4.8</h3>
                <p>Average rating</p>
            </div>
        </div>
    </section>

    <section class="section section-accent">
        <div class="container page-layout">
            <div class="content-area">
                <div class="panel">
                    <h3 class="panel-title">Recent inventory updates</h3>
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
                                    <td>Metformin 500mg</td>
                                    <td><span class="badge badge-warning">Limited</span></td>
                                    <td>6</td>
                                    <td>Today</td>
                                </tr>
                                <tr>
                                    <td>Insulin (Rapid)</td>
                                    <td><span class="badge badge-success">In stock</span></td>
                                    <td>42</td>
                                    <td>15 minutes ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <h3 class="panel-title">Quick actions</h3>
                <div class="form-footer">
                    <a class="btn btn-primary" href="inventory/index.php">Manage inventory</a>
                    <a class="btn btn-secondary" href="profile.php">Update profile</a>
                    <a class="btn btn-secondary" href="logout.php">Log out</a>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>
