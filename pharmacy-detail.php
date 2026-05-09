<?php
$page_title = 'Pharmacy Detail - MedFinder Ethiopia';
$asset_path = '';
include 'includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy profile</p>
                <h1 class="page-title">Unity Pharmacy</h1>
                <p class="page-subtitle">Bole, Atlas Area | License: ETH-12345</p>
                <div class="status-row">
                    <span class="badge badge-success">Open now</span>
                    <span class="pill pill-success">In stock</span>
                    <span class="pill">Updated 15 minutes ago</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="tel:+251912345678">Call pharmacy</a>
                <a class="btn btn-secondary" href="search-results.php">Back to results</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container profile-grid">
            <div class="profile-main">
                <article class="panel">
                    <h3 class="panel-title">Overview</h3>
                    <p>Unity Pharmacy serves the Atlas area with a full catalog of chronic care and daily health essentials. Verified by MedFinder with weekly inventory updates.</p>
                </article>

                <article class="panel">
                    <h3 class="panel-title">Available medicines</h3>
                    <div class="table-wrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Insulin (Rapid)</td>
                                    <td>250 ETB</td>
                                    <td><span class="badge badge-success">In stock</span></td>
                                    <td>15 minutes ago</td>
                                </tr>
                                <tr>
                                    <td>Metformin 500mg</td>
                                    <td>180 ETB</td>
                                    <td><span class="badge badge-warning">Limited</span></td>
                                    <td>1 hour ago</td>
                                </tr>
                                <tr>
                                    <td>Amoxicillin 500mg</td>
                                    <td>120 ETB</td>
                                    <td><span class="badge badge-success">In stock</span></td>
                                    <td>Today</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="panel">
                    <h3 class="panel-title">Operating hours</h3>
                    <div class="info-list">
                        <div class="info-row">
                            <span>Weekdays</span>
                            <span>8:00 AM - 9:00 PM</span>
                        </div>
                        <div class="info-row">
                            <span>Saturday</span>
                            <span>9:00 AM - 8:00 PM</span>
                        </div>
                        <div class="info-row">
                            <span>Sunday</span>
                            <span>10:00 AM - 6:00 PM</span>
                        </div>
                    </div>
                </article>
            </div>

            <aside class="profile-sidebar">
                <div class="panel">
                    <h3 class="panel-title">Contact details</h3>
                    <div class="info-list">
                        <div class="info-row">
                            <span>Phone</span>
                            <a href="tel:+251912345678">+251 91 234 5678</a>
                        </div>
                        <div class="info-row">
                            <span>Email</span>
                            <span>unity@pharmacy.et</span>
                        </div>
                        <div class="info-row">
                            <span>Neighborhood</span>
                            <span>Bole</span>
                        </div>
                        <div class="info-row">
                            <span>Delivery</span>
                            <span>Available</span>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3 class="panel-title">Location map</h3>
                    <!-- Backend: embed a map once GPS coordinates are stored. -->
                    <div class="empty-state">
                        <p>Map preview coming soon.</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
