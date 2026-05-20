<?php
$page_title = 'Add Inventory Item - Pharmacy';
$asset_path = '../../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/pharmacy-auth.php';

$pharmacy_id = $_SESSION['pharmacy_id'];
$medicines = get_all_medicines($conn);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Sanitize inputs
    $medicine_id = (int)$_POST['medicine_id'];
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $status = sanitize_input($_POST['status']);
    $expiry_date = !empty($_POST['expiry_date']) ? sanitize_input($_POST['expiry_date']) : null;
    $notes = !empty($_POST['notes']) ? sanitize_input($_POST['notes']) : null;
    
    // Validate inputs
    if (empty($medicine_id)) $errors[] = "Medicine is required";
    if ($quantity < 0) $errors[] = "Quantity cannot be negative";
    if ($price < 0) $errors[] = "Price cannot be negative";
    if (!in_array($status, ['in_stock', 'limited', 'out_of_stock'])) {
        $errors[] = "Invalid status";
    }
    
    // Check if medicine already exists in inventory
    $stmt = $conn->prepare("SELECT inventory_id FROM inventory WHERE pharmacy_id = ? AND medicine_id = ?");
    $stmt->bind_param("ii", $pharmacy_id, $medicine_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This medicine is already in your inventory. Use update to modify it.";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO inventory (pharmacy_id, medicine_id, quantity, price, status, expiry_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iidssss", $pharmacy_id, $medicine_id, $quantity, $price, $status, $expiry_date, $notes);
        
        if ($stmt->execute()) {
            set_flash_message("Medicine added to inventory successfully", "success");
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
                <h1 class="page-title">Add medicine</h1>
                <p class="page-subtitle">Select a medicine from the catalog and set stock details.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Pharmacy</a>
                    <span>/</span>
                    <a href="index.php">Inventory</a>
                    <span>/</span>
                    <span>Add</span>
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
                <h3>Inventory details</h3>
                <!-- Backend: insert inventory record and link to medicine catalog. -->
                <form action="index.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="inventory-medicine">Medicine</label>
                            <select id="inventory-medicine" name="medicine_id" required>
                                <option value="">Select medicine</option>
                                <?php foreach ($medicines as $medicine): ?>
                                    <option value="<?php echo $medicine['medicine_id']; ?>">
                                        <?php echo htmlspecialchars($medicine['medicine_name']); ?>
                                        <?php if ($medicine['generic_name']): ?>
                                            (<?php echo htmlspecialchars($medicine['generic_name']); ?>)
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inventory-quantity">Quantity</label>
                            <input type="number" id="inventory-quantity" name="quantity" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory-price">Price (ETB)</label>
                            <input type="number" id="inventory-price" name="price" min="0" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="inventory-status">Status</label>
                            <select id="inventory-status" name="status" required>
                                <option value="in_stock">In stock</option>
                                <option value="limited">Limited</option>
                                <option value="out_of_stock">Out of stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inventory-expiry">Expiry date (optional)</label>
                            <input type="date" id="inventory-expiry" name="expiry_date">
                        </div>
                        <div class="form-group form-group-full">
                            <label for="inventory-notes">Notes</label>
                            <textarea id="inventory-notes" name="notes" placeholder="Additional notes"></textarea>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Save item</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
