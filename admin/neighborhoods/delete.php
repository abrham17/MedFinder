<?php
$page_title = 'Delete Neighborhood - Admin';
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

// Process deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm'])) {
    // Check if neighborhood is in use by any pharmacies
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM pharmacies WHERE neighborhood_id = ?");
    $stmt->bind_param("i", $neighborhood_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        set_flash_message("Cannot delete neighborhood that is in use by pharmacies. Reassign pharmacies first.", "error");
        redirect('index.php');
    }
    
    // Delete neighborhood
    $stmt = $conn->prepare("DELETE FROM neighborhoods WHERE neighborhood_id = ?");
    $stmt->bind_param("i", $neighborhood_id);
    
    if ($stmt->execute()) {
        set_flash_message("Neighborhood deleted successfully", "success");
        redirect('index.php');
    } else {
        set_flash_message("Failed to delete neighborhood", "error");
        redirect('index.php');
    }
}
?>

<main id="main-content">
    <section class="section">
        <div class="container auth-layout">
            <div class="auth-card">
                <div class="auth-header">
                    <p class="eyebrow">Delete neighborhood</p>
                    <h2>Delete <?php echo htmlspecialchars($neighborhood['name']); ?>?</h2>
                </div>
                <div class="alert alert-warning">This action will remove the neighborhood from search filters.</div>
                <form method="post">
                    <div class="form-footer">
                        <button class="btn btn-primary" type="submit" name="confirm" value="1">Confirm delete</button>
                        <a class="btn btn-secondary" href="index.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include '../../includes/footer.php'; ?>
