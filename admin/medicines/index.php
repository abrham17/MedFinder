<?php
$page_title = 'Medicine Catalog - Admin';
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
$category_filter = isset($_GET['category']) ? sanitize_input($_GET['category']) : '';

// Build query
$sql = "SELECT m.*, COUNT(DISTINCT i.pharmacy_id) as pharmacy_count 
        FROM medicines m 
        LEFT JOIN inventory i ON m.medicine_id = i.medicine_id 
        WHERE 1=1";

$params = [];
$types = "";

if (!empty($search)) {
    $sql .= " AND (m.medicine_name LIKE ? OR m.generic_name LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

if (!empty($category_filter)) {
    $sql .= " AND m.category = ?";
    $params[] = $category_filter;
    $types .= "s";
}

$sql .= " GROUP BY m.medicine_id ORDER BY m.medicine_name ASC";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$medicines = $result->fetch_all(MYSQLI_ASSOC);
$total_medicines = count($medicines);
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
                        <input type="text" id="medicine-search" placeholder="Search by name or category" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="form-group">
                        <label for="medicine-category">Category</label>
                        <select id="medicine-category">
                            <option value="">All categories</option>
                            <option value="Antibiotic" <?php echo $category_filter === 'Antibiotic' ? 'selected' : ''; ?>>Antibiotic</option>
                            <option value="Painkiller" <?php echo $category_filter === 'Painkiller' ? 'selected' : ''; ?>>Painkiller</option>
                            <option value="Diabetes" <?php echo $category_filter === 'Diabetes' ? 'selected' : ''; ?>>Diabetes</option>
                            <option value="Respiratory" <?php echo $category_filter === 'Respiratory' ? 'selected' : ''; ?>>Respiratory</option>
                            <option value="Cardiovascular" <?php echo $category_filter === 'Cardiovascular' ? 'selected' : ''; ?>>Cardiovascular</option>
                            <option value="Gastric" <?php echo $category_filter === 'Gastric' ? 'selected' : ''; ?>>Gastric</option>
                            <option value="Allergy" <?php echo $category_filter === 'Allergy' ? 'selected' : ''; ?>>Allergy</option>
                            <option value="Supplement" <?php echo $category_filter === 'Supplement' ? 'selected' : ''; ?>>Supplement</option>
                        </select>
                    </div>
                </div>
                <span class="pill"><?php echo $total_medicines; ?> medicines</span>
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
                        <?php if ($total_medicines > 0): ?>
                            <?php foreach ($medicines as $medicine): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($medicine['medicine_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($medicine['generic_name'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($medicine['category'] ?? 'N/A'); ?></td>
                                    <td><?php echo $medicine['pharmacy_count']; ?></td>
                                    <td class="table-actions">
                                        <a class="btn btn-secondary" href="edit.php?id=<?php echo $medicine['medicine_id']; ?>">Edit</a>
                                        <a class="btn btn-link" href="delete.php?id=<?php echo $medicine['medicine_id']; ?>">Archive</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px;">
                                    <p>No medicines found.</p>
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
