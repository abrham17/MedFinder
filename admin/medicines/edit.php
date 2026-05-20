<?php
$page_title = 'Edit Medicine - Admin';
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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Sanitize inputs
    $medicine_name = sanitize_input($_POST['medicine_name']);
    $generic_name = sanitize_input($_POST['generic_name']);
    $category = sanitize_input($_POST['category']);
    $description = !empty($_POST['description']) ? sanitize_input($_POST['description']) : null;
    
    // Validate inputs
    if (empty($medicine_name)) $errors[] = "Medicine name is required";
    if (empty($category)) $errors[] = "Category is required";
    
    // If no errors, update database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE medicines SET medicine_name = ?, generic_name = ?, category = ?, description = ? WHERE medicine_id = ?");
        $stmt->bind_param("ssssi", $medicine_name, $generic_name, $category, $description, $medicine_id);
        
        if ($stmt->execute()) {
            set_flash_message("Medicine updated successfully", "success");
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
                <p class="eyebrow">Medicine catalog</p>
                <h1 class="page-title">Edit medicine</h1>
                <p class="page-subtitle">Update the catalog details shown to pharmacies.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Medicines</a>
                    <span>/</span>
                    <span>Edit</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">Back to list</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="form-card">
                <h3>Medicine details</h3>
                <!-- Backend: load current values and update on save. -->
                <form action="index.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="medicine-name">Medicine name</label>
                            <input type="text" id="medicine-name" name="medicine_name" value="<?php echo htmlspecialchars($medicine['medicine_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="generic-name">Generic name</label>
                            <input type="text" id="generic-name" name="generic_name" value="<?php echo htmlspecialchars($medicine['generic_name'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="medicine-category">Category</label>
                            <select id="medicine-category" name="category" required>
                                <option value="">Select category</option>
                                <option value="Antibiotic" <?php echo $medicine['category'] === 'Antibiotic' ? 'selected' : ''; ?>>Antibiotic</option>
                                <option value="Painkiller" <?php echo $medicine['category'] === 'Painkiller' ? 'selected' : ''; ?>>Painkiller</option>
                                <option value="Diabetes" <?php echo $medicine['category'] === 'Diabetes' ? 'selected' : ''; ?>>Diabetes</option>
                                <option value="Respiratory" <?php echo $medicine['category'] === 'Respiratory' ? 'selected' : ''; ?>>Respiratory</option>
                                <option value="Cardiovascular" <?php echo $medicine['category'] === 'Cardiovascular' ? 'selected' : ''; ?>>Cardiovascular</option>
                                <option value="Gastric" <?php echo $medicine['category'] === 'Gastric' ? 'selected' : ''; ?>>Gastric</option>
                                <option value="Allergy" <?php echo $medicine['category'] === 'Allergy' ? 'selected' : ''; ?>>Allergy</option>
                                <option value="Neurological" <?php echo $medicine['category'] === 'Neurological' ? 'selected' : ''; ?>>Neurological</option>
                                <option value="Sedative" <?php echo $medicine['category'] === 'Sedative' ? 'selected' : ''; ?>>Sedative</option>
                                <option value="Antidepressant" <?php echo $medicine['category'] === 'Antidepressant' ? 'selected' : ''; ?>>Antidepressant</option>
                                <option value="Hormone" <?php echo $medicine['category'] === 'Hormone' ? 'selected' : ''; ?>>Hormone</option>
                                <option value="Diuretic" <?php echo $medicine['category'] === 'Diuretic' ? 'selected' : ''; ?>>Diuretic</option>
                                <option value="Blood Thinner" <?php echo $medicine['category'] === 'Blood Thinner' ? 'selected' : ''; ?>>Blood Thinner</option>
                                <option value="Supplement" <?php echo $medicine['category'] === 'Supplement' ? 'selected' : ''; ?>>Supplement</option>
                                <option value="Anti-inflammatory" <?php echo $medicine['category'] === 'Anti-inflammatory' ? 'selected' : ''; ?>>Anti-inflammatory</option>
                            </select>
                        </div>
                        <div class="form-group form-group-full">
                            <label for="medicine-description">Description</label>
                            <textarea id="medicine-description" name="description"><?php echo htmlspecialchars($medicine['description'] ?? ''); ?></textarea>
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
