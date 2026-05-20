<?php
$page_title = 'Update Inventory - Pharmacy';
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
$stmt = $conn->prepare("SELECT i.*, m.medicine_name, m.generic_name FROM inventory i JOIN medicines m ON i.medicine_id = m.medicine_id WHERE i.inventory_id = ? AND i.pharmacy_id = ?");
$stmt->bind_param("ii", $inventory_id, $pharmacy_id);
$stmt->execute();
$result = $stmt->get_result();
$inventory_item = $result->fetch_assoc();

if (!$inventory_item) {
    set_flash_message("Inventory item not found", "error");
    redirect('index.php');
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Sanitize inputs
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $status = sanitize_input($_POST['status']);
    $notes = !empty($_POST['notes']) ? sanitize_input($_POST['notes']) : null;
    
    // Validate inputs
    if ($quantity < 0) $errors[] = "Quantity cannot be negative";
    if ($price < 0) $errors[] = "Price cannot be negative";
    if (!in_array($status, ['in_stock', 'limited', 'out_of_stock'])) {
        $errors[] = "Invalid status";
    }
    
    // If no errors, update database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE inventory SET quantity = ?, price = ?, status = ?, notes = ? WHERE inventory_id = ? AND pharmacy_id = ?");
        $stmt->bind_param("idssi", $quantity, $price, $status, $notes, $inventory_id, $pharmacy_id);
        
        if ($stmt->execute()) {
            set_flash_message("Inventory updated successfully", "success");
            redirect('index.php');
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
    
    // If errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Inventory</p>
                <h1 class="page-title">Update stock</h1>
                <p class="page-subtitle">Adjust quantity, price, and status for a medicine.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Pharmacy</a>
                    <span>/</span>
                    <a href="index.php">Inventory</a>
                    <span>/</span>
                    <span>Update</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">Back to inventory</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="form-card">
                <h3>Update inventory</h3>
                <!-- Backend: load current values and save updates. -->
                <form action="index.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="inventory-medicine">Medicine</label>
                            <input type="text" id="inventory-medicine" value="<?php echo htmlspecialchars($inventory_item['medicine_name']); ?><?php echo $inventory_item['generic_name'] ? ' (' . htmlspecialchars($inventory_item['generic_name']) . ')' : ''; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="inventory-quantity">Quantity</label>
                            <input type="number" id="inventory-quantity" name="quantity" min="0" value="<?php echo $inventory_item['quantity']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory-price">Price (ETB)</label>
                            <input type="number" id="inventory-price" name="price" min="0" step="0.01" value="<?php echo $inventory_item['price']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory-status">Status</label>
                            <select id="inventory-status" name="status" required>
                                <option value="in_stock" <?php echo $inventory_item['status'] === 'in_stock' ? 'selected' : ''; ?>>In stock</option>
                                <option value="limited" <?php echo $inventory_item['status'] === 'limited' ? 'selected' : ''; ?>>Limited</option>
                                <option value="out_of_stock" <?php echo $inventory_item['status'] === 'out_of_stock' ? 'selected' : ''; ?>>Out of stock</option>
                            </select>
                        </div>
                        <div class="form-group form-group-full">
                            <label for="inventory-notes">Notes</label>
                            <textarea id="inventory-notes" name="notes"><?php echo htmlspecialchars($inventory_item['notes'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Save changes</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
