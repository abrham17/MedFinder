<?php
$page_title = 'Inventory - Pharmacy';
$asset_path = '../../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/pharmacy-auth.php';

$pharmacy_id = $_SESSION['pharmacy_id'];

// Get search and filter parameters
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';

// Build query
$sql = "SELECT i.*, m.medicine_name, m.generic_name, m.category 
        FROM inventory i 
        JOIN medicines m ON i.medicine_id = m.medicine_id 
        WHERE i.pharmacy_id = ?";

$params = [$pharmacy_id];
$types = "i";

if (!empty($search)) {
    $sql .= " AND (m.medicine_name LIKE ? OR m.generic_name LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

if (!empty($status_filter)) {
    $sql .= " AND i.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$sql .= " ORDER BY i.updated_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$inventory_items = $result->fetch_all(MYSQLI_ASSOC);
$total_items = count($inventory_items);
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
                        <input type="text" id="inventory-search" placeholder="Search by medicine name" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="form-group">
                        <label for="inventory-status">Status</label>
                        <select id="inventory-status">
                            <option value="">All statuses</option>
                            <option value="in_stock" <?php echo $status_filter === 'in_stock' ? 'selected' : ''; ?>>In stock</option>
                            <option value="limited" <?php echo $status_filter === 'limited' ? 'selected' : ''; ?>>Limited</option>
                            <option value="out_of_stock" <?php echo $status_filter === 'out_of_stock' ? 'selected' : ''; ?>>Out of stock</option>
                        </select>
                    </div>
                </div>
                <span class="pill"><?php echo $total_items; ?> items</span>
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
                        <?php if ($total_items > 0): ?>
                            <?php foreach ($inventory_items as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['medicine_name']); ?></strong>
                                        <?php if ($item['generic_name']): ?>
                                            <br><small><?php echo htmlspecialchars($item['generic_name']); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['price'] ? number_format($item['price'], 2) . ' ETB' : 'N/A'; ?></td>
                                    <td><?php echo render_status_badge($item['status']); ?></td>
                                    <td><?php echo time_ago($item['updated_at']); ?></td>
                                    <td class="table-actions">
                                        <a class="btn btn-secondary" href="update.php?id=<?php echo $item['inventory_id']; ?>">Update</a>
                                        <a class="btn btn-link" href="delete.php?id=<?php echo $item['inventory_id']; ?>">Remove</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <p>No inventory items found.</p>
                                    <a class="btn btn-primary" href="add.php">Add your first medicine</a>
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
