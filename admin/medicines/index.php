<?php
$page_title = 'Medicine Catalog - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Medicine catalog</p>
                <h1 class="page-title">Manage medicines</h1>
                <p class="page-subtitle">Add, edit, or archive medicines listed across partner pharmacies.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <span>Medicines</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="add.php">Add new medicine</a>
                <a class="btn btn-secondary" href="../index.php">Back to dashboard</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="results-toolbar">
                <div class="search-inline">
                    <div class="form-group">
                        <label for="medicine-search">Search medicines</label>
                        <input type="text" id="medicine-search" placeholder="Search by name or category">
                    </div>
                    <div class="form-group">
                        <label for="medicine-category">Category</label>
                        <select id="medicine-category">
                            <option value="">All categories</option>
                            <option value="antibiotic">Antibiotic</option>
                            <option value="painkiller">Painkiller</option>
                            <option value="diabetes">Diabetes</option>
                        </select>
                    </div>
                </div>
                <span class="pill">3,820 medicines</span>
            </div>

            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Generic name</th>
                            <th>Category</th>
                            <th>Pharmacies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Amoxicillin 500mg</td>
                            <td>Amoxicillin</td>
                            <td>Antibiotic</td>
                            <td>68</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="edit.php">Edit</a>
                                <a class="btn btn-link" href="delete.php">Archive</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Paracetamol 500mg</td>
                            <td>Acetaminophen</td>
                            <td>Painkiller</td>
                            <td>110</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="edit.php">Edit</a>
                                <a class="btn btn-link" href="delete.php">Archive</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Insulin (Rapid)</td>
                            <td>Insulin</td>
                            <td>Diabetes</td>
                            <td>42</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="edit.php">Edit</a>
                                <a class="btn btn-link" href="delete.php">Archive</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
