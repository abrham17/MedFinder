<?php
$page_title = 'Neighborhoods - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

// Get all neighborhoods
$neighborhoods = get_all_neighborhoods($conn);
$total_neighborhoods = count($neighborhoods);
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
                        <?php if ($total_neighborhoods > 0): ?>
                            <?php foreach ($neighborhoods as $neighborhood): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($neighborhood['name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($neighborhood['description'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($neighborhood['zone'] ?? 'N/A'); ?></td>
                                    <td class="table-actions">
                                        <a class="btn btn-secondary" href="edit.php?id=<?php echo $neighborhood['neighborhood_id']; ?>">Edit</a>
                                        <a class="btn btn-link" href="delete.php?id=<?php echo $neighborhood['neighborhood_id']; ?>">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px;">
                                    <p>No neighborhoods found.</p>
                                    <a class="btn btn-primary" href="add.php">Add your first neighborhood</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
