<?php
$page_title = 'Pharmacy Details - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

$pharmacy_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get pharmacy
$stmt = $conn->prepare("SELECT p.*, n.name as neighborhood_name FROM pharmacies p LEFT JOIN neighborhoods n ON p.neighborhood_id = n.neighborhood_id WHERE p.pharmacy_id = ?");
$stmt->bind_param("i", $pharmacy_id);
$stmt->execute();
$result = $stmt->get_result();
$pharmacy = $result->fetch_assoc();

if (!$pharmacy) {
    set_flash_message("Pharmacy not found", "error");
    redirect('index.php');
}

// Get pharmacy inventory
$stmt = $conn->prepare("SELECT i.*, m.medicine_name FROM inventory i JOIN medicines m ON i.medicine_id = m.medicine_id WHERE i.pharmacy_id = ? ORDER BY i.updated_at DESC LIMIT 10");
$stmt->bind_param("i", $pharmacy_id);
$stmt->execute();
$inventory = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy profile</p>
                <h1 class="page-title"><?php echo htmlspecialchars($pharmacy['pharmacy_name']); ?></h1>
                <p class="page-subtitle"><?php echo htmlspecialchars($pharmacy['neighborhood_name'] ?? 'N/A'); ?> | Status: <?php echo render_status_badge($pharmacy['status']); ?></p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Pharmacies</a>
                    <span>/</span>
                    <span>View</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">Back to list</a>
                <a class="btn btn-primary" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>">Update status</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container profile-grid">
            <div class="profile-main">
                <div class="panel">
                    <h3 class="panel-title">Pharmacy details</h3>
                    <div class="info-list">
                        <div class="info-row">
                            <span>Owner</span>
                            <span><?php echo htmlspecialchars($pharmacy['owner_name']); ?></span>
                        </div>
                        <div class="info-row">
                            <span>Phone</span>
                            <span><?php echo format_ethiopian_phone($pharmacy['phone']); ?></span>
                        </div>
                        <div class="info-row">
                            <span>Email</span>
                            <span><?php echo htmlspecialchars($pharmacy['email']); ?></span>
                        </div>
                        <div class="info-row">
                            <span>License</span>
                            <span><?php echo htmlspecialchars($pharmacy['license_number']); ?></span>
                        </div>
                        <div class="info-row">
                            <span>Address</span>
                            <span><?php echo htmlspecialchars($pharmacy['address']); ?></span>
                        </div>
                        <div class="info-row">
                            <span>Operating hours</span>
                            <span><?php echo htmlspecialchars($pharmacy['operating_hours'] ?? 'N/A'); ?></span>
                        </div>
                        <div class="info-row">
                            <span>Registered</span>
                            <span><?php echo time_ago($pharmacy['created_at']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <h3 class="panel-title">Inventory snapshot</h3>
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
                                <?php if (count($inventory) > 0): ?>
                                    <?php foreach ($inventory as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['medicine_name']); ?></td>
                                            <td><?php echo render_status_badge($item['status']); ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td><?php echo time_ago($item['updated_at']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" style="text-align: center; padding: 20px;">No inventory items</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="profile-sidebar">
                <div class="panel">
                    <h3 class="panel-title">Status history</h3>
                    <div class="info-list">
                        <div class="info-row">
                            <span>Approved</span>
                            <span>Mar 12, 2026</span>
                        </div>
                        <div class="info-row">
                            <span>Last update</span>
                            <span>Today</span>
                        </div>
                        <div class="info-row">
                            <span>Search views</span>
                            <span>240 this week</span>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <h3 class="panel-title">Admin actions</h3>
                    <div class="form-footer">
                        <a class="btn btn-primary" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>">Change status</a>
                        <?php if ($pharmacy['status'] === 'active'): ?>
                            <a class="btn btn-secondary" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>&action=suspend">Suspend pharmacy</a>
                        <?php elseif ($pharmacy['status'] === 'suspended'): ?>
                            <a class="btn btn-secondary" href="approve.php?id=<?php echo $pharmacy['pharmacy_id']; ?>&action=activate">Reactivate pharmacy</a>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
