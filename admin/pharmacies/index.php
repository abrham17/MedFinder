<?php
$page_title = 'Pharmacies - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

// Get search and filter parameters
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';

// Build query
$sql = "SELECT p.*, n.name as neighborhood_name 
        FROM pharmacies p 
        LEFT JOIN neighborhoods n ON p.neighborhood_id = n.neighborhood_id 
        WHERE 1=1";

$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (p.pharmacy_name LIKE ? OR p.owner_name LIKE ? OR p.email LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if (!empty($status_filter)) {
    $sql .= " AND p.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$sql .= " ORDER BY p.created_at DESC";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$pharmacies = $result->fetch_all(MYSQLI_ASSOC);
$total_pharmacies = count($pharmacies);
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
                        <input type="text" id="pharmacy-search" placeholder="Search by pharmacy or owner" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="form-group">
                        <label for="pharmacy-status">Status</label>
                        <select id="pharmacy-status">
                            <option value="">All statuses</option>
                            <option value="active" <?php echo $status_filter === 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="pending" <?php echo $status_filter === 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="suspended" <?php echo $status_filter === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                        </select>
                    </div>
                </div>
                <span class="pill"><?php echo $total_pharmacies; ?> pharmacies</span>
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
                        <?php if ($total_pharmacies > 0): ?>
                            <?php foreach ($pharmacies as $pharmacy): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($pharmacy['pharmacy_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($pharmacy['owner_name']); ?></td>
                                    <td><?php echo htmlspecialchars($pharmacy['neighborhood_name'] ?? 'N/A'); ?></td>
                                    <td><?php echo render_status_badge($pharmacy['status']); ?></td>
                                    <td class="table-actions">
                                        <a class="btn btn-secondary" href="view.php?id=<?php echo $pharmacy['pharmacy_id']; ?>">View</a>
                                        <?php if ($pharmacy['status'] === 'pending'): ?>
                                            <a class="btn btn-link" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>">Review</a>
                                        <?php elseif ($pharmacy['status'] === 'active'): ?>
                                            <a class="btn btn-link" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>&action=suspend">Suspend</a>
                                        <?php else: ?>
                                            <a class="btn btn-link" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>&action=activate">Reactivate</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    <p>No pharmacies found.</p>
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
