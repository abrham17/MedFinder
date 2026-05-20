<?php
$page_title = 'Archive Medicine - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

$medicine_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get medicine
$stmt = $conn->prepare("SELECT * FROM medicines WHERE medicine_id = ?");
$stmt->bind_param("i", $medicine_id);
$stmt->execute();
$result = $stmt->get_result();
$medicine = $result->fetch_assoc();

if (!$medicine) {
    set_flash_message("Medicine not found", "error");
    redirect('index.php');
}

// Process deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    // Check if medicine is in any inventory
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM inventory WHERE medicine_id = ?");
    $stmt->bind_param("i", $medicine_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        set_flash_message("Cannot archive medicine that is in pharmacy inventories. Remove from inventories first.", "error");
        redirect('index.php');
    }
    
    // Delete medicine
    $stmt = $conn->prepare("DELETE FROM medicines WHERE medicine_id = ?");
    $stmt->bind_param("i", $medicine_id);
    
    if ($stmt->execute()) {
        set_flash_message("Medicine archived successfully", "success");
        redirect('index.php');
    } else {
        set_flash_message("Failed to archive medicine", "error");
        redirect('index.php');
    }
}
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Archive medicine</p>
                    <h2>Archive <?php echo htmlspecialchars($medicine['medicine_name']); ?>?</h2>
                </div>
                <div class="alert alert-warning">Archived medicines will no longer appear for pharmacies.</div>
                <form method="post">
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit" name="confirm" value="1">Confirm archive</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
