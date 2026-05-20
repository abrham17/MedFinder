<?php
$page_title = 'Remove Inventory Item - Pharmacy';
$asset_path = '../../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/pharmacy-auth.php';

$pharmacy_id = $_SESSION['pharmacy_id'];
$inventory_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get inventory item
$stmt = $conn->prepare("SELECT i.*, m.medicine_name FROM inventory i JOIN medicines m ON i.medicine_id = m.medicine_id WHERE i.inventory_id = ? AND i.pharmacy_id = ?");
$stmt->bind_param("ii", $inventory_id, $pharmacy_id);
$stmt->execute();
$result = $stmt->get_result();
$inventory_item = $result->fetch_assoc();

if (!$inventory_item) {
    set_flash_message("Inventory item not found", "error");
    redirect('index.php');
}

// Process deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    $stmt = $conn->prepare("DELETE FROM inventory WHERE inventory_id = ? AND pharmacy_id = ?");
    $stmt->bind_param("ii", $inventory_id, $pharmacy_id);
    
    if ($stmt->execute()) {
        set_flash_message("Inventory item removed successfully", "success");
        redirect('index.php');
    } else {
        set_flash_message("Failed to remove inventory item", "error");
        redirect('index.php');
    }
}
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Remove item</p>
                    <h2>Remove <?php echo htmlspecialchars($inventory_item['medicine_name']); ?>?</h2>
                </div>
                <div class="alert alert-warning">This medicine will no longer appear in search results.</div>
                <form method="post">
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit" name="confirm" value="1">Confirm removal</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
