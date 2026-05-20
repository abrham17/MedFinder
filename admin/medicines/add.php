<?php
$page_title = 'Add Medicine - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

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
    
    // Check if medicine already exists
    $stmt = $conn->prepare("SELECT medicine_id FROM medicines WHERE medicine_name = ?");
    $stmt->bind_param("s", $medicine_name);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This medicine already exists in the catalog";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO medicines (medicine_name, generic_name, category, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $medicine_name, $generic_name, $category, $description);
        
        if ($stmt->execute()) {
            set_flash_message("Medicine added to catalog successfully", "success");
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
                <h1 class="page-title">Add a new medicine</h1>
                <p class="page-subtitle">Create a catalog entry for pharmacies to use in their inventory.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Medicines</a>
                    <span>/</span>
                    <span>Add</span>
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
                <!-- Backend: validate and insert into the medicines table. -->
                <form action="index.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="medicine-name">Medicine name</label>
                            <input type="text" id="medicine-name" name="medicine_name" required>
                        </div>
                        <div class="form-group">
                            <label for="generic-name">Generic name</label>
                            <input type="text" id="generic-name" name="generic_name">
                        </div>
                        <div class="form-group">
                            <label for="medicine-category">Category</label>
                            <select id="medicine-category" name="category" required>
                                <option value="">Select category</option>
                                <option value="Antibiotic">Antibiotic</option>
                                <option value="Painkiller">Painkiller</option>
                                <option value="Diabetes">Diabetes</option>
                                <option value="Respiratory">Respiratory</option>
                                <option value="Cardiovascular">Cardiovascular</option>
                                <option value="Gastric">Gastric</option>
                                <option value="Allergy">Allergy</option>
                                <option value="Neurological">Neurological</option>
                                <option value="Sedative">Sedative</option>
                                <option value="Antidepressant">Antidepressant</option>
                                <option value="Hormone">Hormone</option>
                                <option value="Diuretic">Diuretic</option>
                                <option value="Blood Thinner">Blood Thinner</option>
                                <option value="Supplement">Supplement</option>
                                <option value="Anti-inflammatory">Anti-inflammatory</option>
                            </select>
                        </div>
                        <div class="form-group form-group-full">
                            <label for="medicine-description">Description</label>
                            <textarea id="medicine-description" name="description" placeholder="Short usage notes"></textarea>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Save medicine</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
