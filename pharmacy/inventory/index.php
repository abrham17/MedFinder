<?php
$page_title = 'Inventory - Pharmacy';
$asset_path = '../../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Inventory</p>
                <h1 class="page-title">Manage inventory</h1>
                <p class="page-subtitle">Keep stock levels and pricing accurate for search results.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Pharmacy</a>
                    <span>/</span>
                    <span>Inventory</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="add.php">Add medicine</a>
                <a class="btn btn-secondary" href="../index.php">Back to dashboard</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="results-toolbar">
                <div class="search-inline">
                    <div class="form-group">
                        <label for="inventory-search">Search inventory</label>
                        <input type="text" id="inventory-search" placeholder="Search by medicine name">
                    </div>
                    <div class="form-group">
                        <label for="inventory-status">Status</label>
                        <select id="inventory-status">
                            <option value="">All statuses</option>
                            <option value="in_stock">In stock</option>
                            <option value="limited">Limited</option>
                            <option value="out_of_stock">Out of stock</option>
                        </select>
                    </div>
                </div>
                <span class="pill">52 items</span>
            </div>

            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Insulin (Rapid)</td>
                            <td>42</td>
                            <td>250 ETB</td>
                            <td><span class="badge badge-success">In stock</span></td>
                            <td>15 minutes ago</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="update.php">Update</a>
                                <a class="btn btn-link" href="delete.php">Remove</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Metformin 500mg</td>
                            <td>6</td>
                            <td>180 ETB</td>
                            <td><span class="badge badge-warning">Limited</span></td>
                            <td>Today</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="update.php">Update</a>
                                <a class="btn btn-link" href="delete.php">Remove</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Amoxicillin 500mg</td>
                            <td>0</td>
                            <td>120 ETB</td>
                            <td><span class="badge badge-danger">Out of stock</span></td>
                            <td>Yesterday</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="update.php">Update</a>
                                <a class="btn btn-link" href="delete.php">Remove</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
