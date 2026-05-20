<?php
$page_title = 'Edit Neighborhood - Admin';
$asset_path = '../../';
$extra_css = array('css/admin.css');
$body_class = 'admin-body';
include '../../includes/header.php';

require_once '../../includes/config.php';
require_once '../../includes/functions.php';
require_once '../../includes/db-connect.php';
require_once '../../includes/admin-auth.php';

$neighborhood_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get neighborhood
$stmt = $conn->prepare("SELECT * FROM neighborhoods WHERE neighborhood_id = ?");
$stmt->bind_param("i", $neighborhood_id);
$stmt->execute();
$result = $stmt->get_result();
$neighborhood = $result->fetch_assoc();

if (!$neighborhood) {
    set_flash_message("Neighborhood not found", "error");
    redirect('index.php');
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Sanitize inputs
    $name = sanitize_input($_POST['name']);
    $zone = sanitize_input($_POST['zone']);
    $description = !empty($_POST['description']) ? sanitize_input($_POST['description']) : null;
    
    // Validate inputs
    if (empty($name)) $errors[] = "Neighborhood name is required";
    
    // Check if name already exists (excluding current record)
    $stmt = $conn->prepare("SELECT neighborhood_id FROM neighborhoods WHERE name = ? AND neighborhood_id != ?");
    $stmt->bind_param("si", $name, $neighborhood_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This neighborhood name already exists";
    }
    
    // If no errors, update database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE neighborhoods SET name = ?, zone = ?, description = ? WHERE neighborhood_id = ?");
        $stmt->bind_param("sssi", $name, $zone, $description, $neighborhood_id);
        
        if ($stmt->execute()) {
            set_flash_message("Neighborhood updated successfully", "success");
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
                <h1 class="page-title">Edit neighborhood</h1>
                <p class="page-subtitle">Update neighborhood labels used for pharmacy locations.</p>
                <div class="breadcrumb">
                    <a href="../index.php">Admin</a>
                    <span>/</span>
                    <a href="index.php">Neighborhoods</a>
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
                <h3>Neighborhood details</h3>
                <!-- Backend: load current values and update on save. -->
                <form action="index.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="neighborhood-name">Name</label>
                            <input type="text" id="neighborhood-name" name="name" value="<?php echo htmlspecialchars($neighborhood['name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="neighborhood-zone">Zone</label>
                            <select id="neighborhood-zone" name="zone">
                                <option value="">Select zone</option>
                                <option value="North" <?php echo $neighborhood['zone'] === 'North' ? 'selected' : ''; ?>>North</option>
                                <option value="South" <?php echo $neighborhood['zone'] === 'South' ? 'selected' : ''; ?>>South</option>
                                <option value="East" <?php echo $neighborhood['zone'] === 'East' ? 'selected' : ''; ?>>East</option>
                                <option value="West" <?php echo $neighborhood['zone'] === 'West' ? 'selected' : ''; ?>>West</option>
                                <option value="Central" <?php echo $neighborhood['zone'] === 'Central' ? 'selected' : ''; ?>>Central</option>
                            </select>
                        </div>
                        <div class="form-group form-group-full">
                            <label for="neighborhood-description">Description</label>
                            <textarea id="neighborhood-description" name="description"><?php echo htmlspecialchars($neighborhood['description'] ?? ''); ?></textarea>
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
