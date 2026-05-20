<?php
$page_title = 'Edit Pharmacy Profile - MedFinder Ethiopia';
$asset_path = '../';
$extra_css = array('css/pharmacy.css');
$body_class = 'pharmacy-body';
include '../includes/header.php';

require_once '../includes/config.php';
require_once '../includes/functions.php';
require_once '../includes/db-connect.php';
require_once '../includes/pharmacy-auth.php';

$pharmacy_id = $_SESSION['pharmacy_id'];

// Get pharmacy details
$stmt = $conn->prepare("SELECT p.*, n.name as neighborhood_name FROM pharmacies p LEFT JOIN neighborhoods n ON p.neighborhood_id = n.neighborhood_id WHERE p.pharmacy_id = ?");
$stmt->bind_param("i", $pharmacy_id);
$stmt->execute();
$result = $stmt->get_result();
$pharmacy = $result->fetch_assoc();

if (!$pharmacy) {
    set_flash_message("Pharmacy profile not found", "error");
    redirect('index.php');
}

// Get all neighborhoods for dropdown
$neighborhoods = get_all_neighborhoods($conn);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // Sanitize inputs
    $pharmacy_name = sanitize_input($_POST['pharmacy_name']);
    $owner_name = sanitize_input($_POST['owner_name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $neighborhood_id = (int)$_POST['neighborhood_id'];
    $operating_hours = sanitize_input($_POST['operating_hours']);
    $address = sanitize_input($_POST['address']);
    
    // Validate inputs
    if (empty($pharmacy_name)) $errors[] = "Pharmacy name is required";
    if (empty($owner_name)) $errors[] = "Owner name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (!validate_ethiopian_phone($phone)) $errors[] = "Invalid Ethiopian phone number format";
    if (empty($neighborhood_id)) $errors[] = "Neighborhood is required";
    
    // Check if email already exists (excluding current pharmacy)
    $stmt = $conn->prepare("SELECT pharmacy_id FROM pharmacies WHERE email = ? AND pharmacy_id != ?");
    $stmt->bind_param("si", $email, $pharmacy_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This email is already registered to another pharmacy";
    }
    
    // Check if phone already exists (excluding current pharmacy)
    $stmt = $conn->prepare("SELECT pharmacy_id FROM pharmacies WHERE phone = ? AND pharmacy_id != ?");
    $stmt->bind_param("si", $phone, $pharmacy_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errors[] = "This phone number is already registered to another pharmacy";
    }
    
    // Handle logo upload
    $logo_path = $pharmacy['logo'];
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        } elseif ($_FILES['logo']['size'] > 2 * 1024 * 1024) {
            $errors[] = "File size exceeds 2MB limit.";
        } else {
            $upload_dir = '../uploads/pharmacy-logos/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $new_filename = 'pharmacy_' . $pharmacy_id . '_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $upload_path)) {
                // Delete old logo if exists
                if ($pharmacy['logo'] && file_exists('../' . $pharmacy['logo'])) {
                    unlink('../' . $pharmacy['logo']);
                }
                $logo_path = 'uploads/pharmacy-logos/' . $new_filename;
            } else {
                $errors[] = "Failed to upload logo.";
            }
        }
    }
    
    // If no errors, update database
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE pharmacies SET pharmacy_name = ?, owner_name = ?, email = ?, phone = ?, neighborhood_id = ?, operating_hours = ?, address = ?, logo = ? WHERE pharmacy_id = ?");
        $stmt->bind_param("ssssisssi", $pharmacy_name, $owner_name, $email, $phone, $neighborhood_id, $operating_hours, $address, $logo_path, $pharmacy_id);
        
        if ($stmt->execute()) {
            set_flash_message("Profile updated successfully", "success");
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
                <p class="eyebrow">Pharmacy profile</p>
                <h1 class="page-title">Update your profile</h1>
                <p class="page-subtitle">Keep contact details and operating hours accurate for patients.</p>
                <div class="breadcrumb">
                    <a href="index.php">Pharmacy</a>
                    <span>/</span>
                    <span>Profile</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">Back to dashboard</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="form-card">
                <h3>Profile details</h3>
                <!-- Backend: load current profile values and save updates. -->
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="profile-name">Pharmacy name</label>
                            <input type="text" id="profile-name" name="pharmacy_name" value="<?php echo htmlspecialchars($pharmacy['pharmacy_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile-owner">Owner name</label>
                            <input type="text" id="profile-owner" name="owner_name" value="<?php echo htmlspecialchars($pharmacy['owner_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile-email">Email address</label>
                            <input type="email" id="profile-email" name="email" value="<?php echo htmlspecialchars($pharmacy['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile-phone">Phone number</label>
                            <input type="tel" id="profile-phone" name="phone" value="<?php echo htmlspecialchars($pharmacy['phone']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profile-neighborhood">Neighborhood</label>
                            <select id="profile-neighborhood" name="neighborhood_id" required>
                                <option value="">Select neighborhood</option>
                                <?php foreach ($neighborhoods as $neighborhood): ?>
                                    <option value="<?php echo $neighborhood['neighborhood_id']; ?>" <?php echo $pharmacy['neighborhood_id'] == $neighborhood['neighborhood_id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($neighborhood['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="profile-hours">Operating hours</label>
                            <input type="text" id="profile-hours" name="operating_hours" value="<?php echo htmlspecialchars($pharmacy['operating_hours'] ?? ''); ?>">
                        </div>
                        <div class="form-group form-group-full">
                            <label for="profile-address">Address</label>
                            <textarea id="profile-address" name="address"><?php echo htmlspecialchars($pharmacy['address'] ?? ''); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="profile-logo">Update logo</label>
                            <input type="file" id="profile-logo" name="logo">
                            <?php if ($pharmacy['logo']): ?>
                                <small>Current: <a href="../<?php echo $pharmacy['logo']; ?>" target="_blank">View logo</a></small>
                            <?php endif; ?>
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

<?php include '../includes/footer.php'; ?>
