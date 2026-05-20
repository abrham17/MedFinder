<?php
$page_title = 'Add Neighborhood - Admin';
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
    $name = sanitize_input($_POST['name']);
    $zone = sanitize_input($_POST['zone']);
    $description = !empty($_POST['description']) ? sanitize_input($_POST['description']) : null;
    
    // Validate inputs
    if (empty($name)) $errors[] = "Neighborhood name is required";
    
    // Check if neighborhood already exists
    $stmt = $conn->prepare("SELECT neighborhood_id FROM neighborhoods WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This neighborhood already exists";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO neighborhoods (name, zone, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $zone, $description);
        
        if ($stmt->execute()) {
            set_flash_message("Neighborhood added successfully", "success");
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
                <p class="eyebrow">Neighborhoods</p>
                <h1 class="page-title">Add neighborhood</h1>
                <p class="page-subtitle">Create a new search area for pharmacies.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Neighborhoods</a>
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
                <h3>Neighborhood details</h3>
                <!-- Backend: insert new neighborhood record. -->
                <form action="index.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="neighborhood-name">Name</label>
                            <input type="text" id="neighborhood-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="neighborhood-zone">Zone</label>
                            <select id="neighborhood-zone" name="zone">
                                <option value="">Select zone</option>
                                <option value="north">North</option>
                                <option value="south">South</option>
                                <option value="east">East</option>
                                <option value="west">West</option>
                            </select>
                        </div>
                        <div class="form-group form-group-full">
                            <label for="neighborhood-description">Description</label>
                            <textarea id="neighborhood-description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit">Save neighborhood</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
