<?php
$page_title = 'Approve Pharmacy - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

$pharmacy_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$action = isset($_GET['action']) ? sanitize_input($_GET['action']) : '';

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

// Process status change
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_status = isset($_POST['action']) ? sanitize_input($_POST['action']) : '';
    
    if (!in_array($new_status, ['active', 'suspended', 'rejected'])) {
        set_flash_message("Invalid action", "error");
        redirect('index.php');
    }
    
    // Update pharmacy status
    $stmt = $conn->prepare("UPDATE pharmacies SET status = ? WHERE pharmacy_id = ?");
    $stmt->bind_param("si", $new_status, $pharmacy_id);
    
    if ($stmt->execute()) {
        $status_message = $new_status === 'active' ? 'approved' : ($new_status === 'suspended' ? 'suspended' : 'rejected');
        set_flash_message("Pharmacy $status_message successfully", "success");
        redirect('index.php');
    } else {
        set_flash_message("Failed to update pharmacy status", "error");
    }
}

// Handle quick status change from index.php
if (!empty($action) && in_array($action, ['suspend', 'activate'])) {
    $new_status = $action === 'suspend' ? 'suspended' : 'active';
    $stmt = $conn->prepare("UPDATE pharmacies SET status = ? WHERE pharmacy_id = ?");
    $stmt->bind_param("si", $new_status, $pharmacy_id);
    
    if ($stmt->execute()) {
        set_flash_message("Pharmacy " . ($new_status === 'active' ? 'activated' : 'suspended') . " successfully", "success");
        redirect('index.php');
    } else {
        set_flash_message("Failed to update pharmacy status", "error");
        redirect('index.php');
    }
}
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Pharmacy approvals</p>
                <h1 class="page-title">Review registration</h1>
                <p class="page-subtitle">Confirm details before approving the pharmacy account.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Pharmacies</a>
                    <span>/</span>
                    <span>Approve</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">Back to list</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container page-layout">
            <div class="content-area">
                <div class="panel-stack">
                    <div class="panel">
                        <h3 class="panel-title">Registration details</h3>
                        <div class="info-list">
                            <div class="info-row">
                                <span>Pharmacy</span>
                                <span><?php echo htmlspecialchars($pharmacy['pharmacy_name']); ?></span>
                            </div>
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
                                <span>License number</span>
                                <span><?php echo htmlspecialchars($pharmacy['license_number']); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Neighborhood</span>
                                <span><?php echo htmlspecialchars($pharmacy['neighborhood_name'] ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Address</span>
                                <span><?php echo htmlspecialchars($pharmacy['address']); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Submitted</span>
                                <span><?php echo time_ago($pharmacy['created_at']); ?></span>
                            </div>
                            <div class="info-row">
                                <span>Current status</span>
                                <span><?php echo render_status_badge($pharmacy['status']); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <h3 class="panel-title">Approval actions</h3>
                        <form method="post">
                            <div class="form-group">
                                <label for="approval-note">Approval note (optional)</label>
                                <textarea id="approval-note" name="note" placeholder="Add a note for the pharmacy"></textarea>
                            </div>
                            <div class="form-footer">
                                <?php if ($pharmacy['status'] === 'pending'): ?>
                                    <button class="btn btn-primary" type="submit" name="action" value="active">Approve pharmacy</button>
                                    <button class="btn btn-secondary" type="submit" name="action" value="rejected">Reject application</button>
                                <?php elseif ($pharmacy['status'] === 'active'): ?>
                                    <button class="btn btn-secondary" type="submit" name="action" value="suspended">Suspend pharmacy</button>
                                <?php elseif ($pharmacy['status'] === 'suspended'): ?>
                                    <button class="btn btn-primary" type="submit" name="action" value="active">Reactivate pharmacy</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <aside class="sidebar">
                <h3 class="panel-title">Verification checklist</h3>
                <div class="check-list">
                    <label><input type="checkbox"> License number verified</label>
                    <label><input type="checkbox"> Phone number confirmed</label>
                    <label><input type="checkbox"> Neighborhood matched</label>
                </div>
                <!-- Backend: store approval steps and status history. -->
            </aside>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
