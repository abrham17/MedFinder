<?php
$page_title = 'Neighborhoods - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Neighborhoods</p>
                <h1 class="page-title">Manage areas</h1>
                <p class="page-subtitle">Create, edit, or organize neighborhoods for search filtering.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <span>Neighborhoods</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-primary" href="add.php">Add neighborhood</a>
                <a class="btn btn-secondary" href="../index.php">Back to dashboard</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Zone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bole</td>
                            <td>Airport corridor and commercial zone</td>
                            <td>East</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="edit.php">Edit</a>
                                <a class="btn btn-link" href="delete.php">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Kirkos</td>
                            <td>Central business district</td>
                            <td>Central</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="edit.php">Edit</a>
                                <a class="btn btn-link" href="delete.php">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Yeka</td>
                            <td>Residential and market areas</td>
                            <td>North</td>
                            <td class="table-actions">
                                <a class="btn btn-secondary" href="edit.php">Edit</a>
                                <a class="btn btn-link" href="delete.php">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
