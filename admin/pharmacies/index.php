<?php
$page_title = 'Pharmacies - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy management</p>
                <h1 class="page-title">Pharmacies</h1>
                <p class="page-subtitle">Review registrations, manage status, and monitor onboarding progress.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <span>Pharmacies</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="approve.php">Review new applications</a>
                <a class="btn btn-secondary" href="../index.php">Back to dashboard</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="results-toolbar">
                <div class="search-inline">
                    <div class="form-group">
                        <label for="pharmacy-search">Search pharmacies</label>
                        <input type="text" id="pharmacy-search" placeholder="Search by pharmacy or owner">
                    </div>
                    <div class="form-group">
                        <label for="pharmacy-status">Status</label>
                        <select id="pharmacy-status">
                            <option value="">All statuses</option>
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>
                <span class="pill">128 pharmacies</span>
            </div>

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
                            <td><span class="pill pill-success">Active</span></td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="view.php">View</a>
                                <a class="btn btn-link" href="delete.php">Suspend</a>
                            </td>
                        </tr>
                        <tr>
                            <td>BlueCross Pharmacy</td>
                            <td>Tsegaye Bekele</td>
                            <td>Yeka</td>
                            <td><span class="pill pill-warning">Pending</span></td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="approve.php">Review</a>
                                <a class="btn btn-link" href="view.php">Details</a>
                            </td>
                        </tr>
                        <tr>
                            <td>EthioCare Pharmacy</td>
                            <td>Meron Alem</td>
                            <td>Kirkos</td>
                            <td><span class="pill pill-danger">Suspended</span></td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="view.php">View</a>
                                <a class="btn btn-link" href="delete.php">Reactivate</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
