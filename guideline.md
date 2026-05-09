# MedFinder Ethiopia - Development Guidelines

## Core Principles

1. **No Frameworks**: Pure HTML, CSS, jQuery, PHP, MySQL
2. **Simple & Stable**: Use proven, basic CSS properties (flexbox only, no grid, no CSS variables)
3. **Minimal But Scalable**: Build core features cleanly with room for expansion
4. **Sequential Development**: Build foundation → features → refinement
5. **Modular Code**: Reusable components, DRY principle

---

## Technology Stack

- **Frontend**: HTML5, CSS3 (basic), jQuery 3.6.0
- **Backend**: PHP 7.4+ (procedural with some OOP for database)
- **Database**: MySQL 5.7+
- **Server**: Apache with mod_rewrite

---

## Code Standards

### PHP Standards

```php
// File structure
<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Naming: snake_case for variables and functions
$user_name = "John";
function get_pharmacy_by_id($id) { }

// Database: Use prepared statements always
$stmt = $conn->prepare("SELECT * FROM pharmacies WHERE pharmacy_id = ?");
$stmt->bind_param("i", $pharmacy_id);

// Error handling
if (!$result) {
    error_log("Database error: " . $conn->error);
    die("An error occurred");
}

// Output escaping always
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');
```

### HTML Standards

```html
<!-- Semantic HTML5 -->
<header>, <nav>, <main>, <section>, <article>, <footer>

<!-- Form structure -->
<form method="post" action="process.php" id="formName">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <span class="error"></span>
    </div>
</form>

<!-- Class naming: lowercase with hyphens -->
<div class="search-result-card">
<button class="btn-primary">
```

### CSS Standards

```css
/* File organization:
   1. Reset/Base
   2. Layout
   3. Components
   4. Pages
   5. Utilities
*/

/* No CSS variables, no grid - use flexbox only */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Simple flexbox layouts */
.flex-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

/* Naming: component-element-modifier */
.card { }
.card-header { }
.card-header-large { }

/* Colors: Use hex values */
.primary { color: #2c5aa0; }
.success { color: #28a745; }
.warning { color: #ffc107; }
.danger { color: #dc3545; }
```

### JavaScript/jQuery Standards

```javascript
// Wrap in document ready
$(document).ready(function() {
    init();
});

function init() {
    setupEventListeners();
    loadInitialData();
}

// Naming: camelCase
function setupEventListeners() { }
var userName = "John";

// Ajax pattern
$.ajax({
    url: 'api/endpoint.php',
    method: 'POST',
    data: { key: value },
    dataType: 'json',
    success: function(response) { },
    error: function(xhr, status, error) { }
});

// Avoid inline JavaScript
// Use data attributes for dynamic values
<button class="delete-btn" data-id="123">Delete</button>
```

---

## Database Design Rules

### Naming Conventions
- Tables: plural, lowercase (e.g., `pharmacies`, `medicines`)
- Columns: singular, snake_case (e.g., `pharmacy_id`, `created_at`)
- Primary keys: `table_singular_id` (e.g., `pharmacy_id`)
- Foreign keys: match referenced table's PK name

### Standard Columns
Every table includes:
```sql
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
```

### Index Strategy
- Primary key on ID columns (automatic)
- Foreign key indexes
- Index on frequently searched columns (email, phone, medicine_name)

---

## File Organization

### Includes Pattern
```
includes/
├── config.php           # Database credentials, site settings
├── db-connect.php       # MySQLi connection object
├── functions.php        # Global helper functions
├── header.php           # HTML head + navigation
├── footer.php           # Footer HTML
├── admin-auth.php       # Admin session check
└── pharmacy-auth.php    # Pharmacy session check
```

### Page Structure Template
```php
<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
check_pharmacy_session(); // if protected

$page_title = "Dashboard";
include 'includes/header.php';
?>

<!-- Page content here -->

<?php include 'includes/footer.php'; ?>
```

---

## Sequential Build Order

### Phase 1: Foundation (Week 1)
**Goal**: Database + Basic Structure

1. **Database Setup** (Day 1)
   - Create database schema
   - Insert seed data (5 neighborhoods, 10 medicines)
   - Test all foreign key relationships

2. **Config & Connection** (Day 1-2)
   - `config.php`: DB credentials, constants
   - `db-connect.php`: MySQLi connection with error handling
   - `functions.php`: Basic helpers (sanitize, redirect, etc.)

3. **Template System** (Day 2)
   - `header.php`: Common HTML head, navigation
   - `footer.php`: Common footer
   - Base CSS structure

4. **Home Page** (Day 2-3)
   - Static HTML layout
   - Search form (no functionality yet)
   - Basic styling

### Phase 2: Search System (Week 2)
**Goal**: Core search functionality

5. **Search Backend** (Day 1-2)
   - `search-results.php`: Query builder
   - Join inventory + pharmacy + neighborhood tables
   - Filter by medicine name and neighborhood
   - Display results in simple list

6. **Search Frontend** (Day 2-3)
   - Result cards with stock indicators
   - Neighborhood filter (checkboxes + jQuery)
   - Click-to-call links
   - Empty state handling

7. **Auto-suggest** (Day 3-4)
   - AJAX medicine name suggestions
   - Debouncing (300ms delay)
   - Dropdown UI with jQuery

### Phase 3: Pharmacy Panel (Week 3)
**Goal**: Pharmacy authentication + inventory

8. **Authentication** (Day 1-2)
   - `pharmacy/register.php`: Registration form + validation
   - `pharmacy/login.php`: Login with password_verify()
   - Session management
   - Email uniqueness check

9. **Dashboard** (Day 2-3)
   - Display pharmacy info
   - Count total inventory items
   - Quick action buttons
   - Logout functionality

10. **Inventory Management** (Day 3-5)
    - `inventory/index.php`: List all inventory
    - `inventory/add.php`: Add medicine (dropdown from catalog)
    - `inventory/update.php`: Update quantity/price/status
    - `inventory/delete.php`: Remove from inventory
    - AJAX for quick updates (optional)

### Phase 4: Admin Panel (Week 4)
**Goal**: Admin controls + medicine catalog

11. **Admin Authentication** (Day 1)
    - Hardcoded admin credentials initially
    - `admin/login.php`
    - Session with role check

12. **Medicine Catalog** (Day 2-3)
    - `admin/medicines/index.php`: List with pagination
    - `admin/medicines/add.php`: Add new medicine
    - `admin/medicines/edit.php`: Update details
    - `admin/medicines/delete.php`: Soft delete

13. **Pharmacy Management** (Day 3-4)
    - List all pharmacies with status filter
    - Approve/reject pending registrations
    - View pharmacy details
    - Suspend/activate accounts

14. **Neighborhood Management** (Day 4-5)
    - CRUD operations for neighborhoods
    - Simple table interface

### Phase 5: Polish & Testing (Week 5)
**Goal**: Refinement + security

15. **Security Hardening** (Day 1-2)
    - CSRF tokens on all forms
    - Input sanitization audit
    - SQL injection testing
    - XSS prevention check

16. **Error Handling** (Day 2-3)
    - User-friendly error messages
    - 404 page
    - Database error logging
    - Form validation feedback

17. **Responsive Design** (Day 3-4)
    - Media queries for mobile (<768px)
    - Touch-friendly buttons
    - Mobile navigation

18. **Testing & Documentation** (Day 4-5)
    - Test all user flows
    - Fix bugs
    - Create README.md
    - Prepare presentation

---

## Modular Patterns

### Database Query Functions (includes/functions.php)

```php
// Pattern: get_table_by_id()
function get_pharmacy_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM pharmacies WHERE pharmacy_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Pattern: get_all_table()
function get_all_medicines($conn) {
    $sql = "SELECT * FROM medicines ORDER BY medicine_name ASC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Pattern: search_table()
function search_pharmacies_by_medicine($conn, $medicine_id, $neighborhood_id = null) {
    $sql = "SELECT p.*, i.quantity, i.price, i.status, n.name as neighborhood 
            FROM pharmacies p
            JOIN inventory i ON p.pharmacy_id = i.pharmacy_id
            JOIN neighborhoods n ON p.neighborhood_id = n.neighborhood_id
            WHERE i.medicine_id = ? AND p.status = 'active'";
    
    if ($neighborhood_id) {
        $sql .= " AND p.neighborhood_id = ?";
    }
    
    $stmt = $conn->prepare($sql);
    // Bind parameters based on condition
}
```

### Form Processing Pattern

```php
// Page: add-pharmacy.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Sanitize inputs
    $pharmacy_name = sanitize_input($_POST['pharmacy_name']);
    
    // 2. Validate
    $errors = [];
    if (empty($pharmacy_name)) {
        $errors[] = "Pharmacy name is required";
    }
    
    // 3. Process if valid
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO pharmacies (pharmacy_name, ...) VALUES (?, ...)");
        $stmt->bind_param("s...", $pharmacy_name, ...);
        
        if ($stmt->execute()) {
            set_flash_message("Pharmacy added successfully", "success");
            redirect("index.php");
        } else {
            $errors[] = "Database error occurred";
        }
    }
}
```

### AJAX Response Pattern

```php
// API endpoint: api/get-suggestions.php
header('Content-Type: application/json');

$query = sanitize_input($_POST['query']);

$stmt = $conn->prepare("SELECT medicine_name FROM medicines WHERE medicine_name LIKE ? LIMIT 10");
$search = "%$query%";
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$medicines = [];
while ($row = $result->fetch_assoc()) {
    $medicines[] = $row['medicine_name'];
}

echo json_encode(['success' => true, 'data' => $medicines]);
```

### Reusable UI Components (includes/functions.php)

```php
function render_status_badge($status) {
    $classes = [
        'in_stock' => 'badge-success',
        'limited' => 'badge-warning',
        'out_of_stock' => 'badge-danger'
    ];
    
    $labels = [
        'in_stock' => 'In Stock',
        'limited' => 'Limited',
        'out_of_stock' => 'Out of Stock'
    ];
    
    $class = $classes[$status] ?? 'badge-default';
    $label = $labels[$status] ?? $status;
    
    return "<span class='badge $class'>$label</span>";
}

function render_pagination($current_page, $total_pages, $base_url) {
    // Generate pagination HTML
}
```

---

## Security Checklist

### Every Form Must Have:
1. CSRF token validation
2. Server-side validation (never trust client)
3. Prepared statements for database queries
4. Sanitized inputs
5. Escaped outputs

### Every Protected Page Must Have:
1. Session check at top of file
2. Role verification (admin vs pharmacy)
3. Timeout handling

### File Uploads Must Have:
1. Type validation (MIME + extension)
2. Size limit check
3. Unique filename generation
4. Storage outside web root (or with .htaccess protection)

---

## Performance Guidelines

### Database Optimization
- Use LIMIT on queries
- Index foreign keys
- Avoid SELECT * (specify columns)
- Use JOIN instead of multiple queries

### Frontend Optimization
- Minify CSS/JS before production
- Optimize images (compress, proper format)
- Limit jQuery animations
- Cache static assets (headers)

### Caching Strategy
- Database connection: reuse within page
- Session data: cache user info in session
- Static dropdown data: cache in PHP variable

---

## Common Helper Functions

```php
// includes/functions.php (keep minimal)

function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function set_flash_message($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'];
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

function check_pharmacy_session() {
    if (!isset($_SESSION['pharmacy_id'])) {
        redirect('../login.php');
    }
}

function check_admin_session() {
    if (!isset($_SESSION['admin_id'])) {
        redirect('login.php');
    }
}

function format_ethiopian_phone($phone) {
    // Format: +251 91 234 5678
}

function time_ago($timestamp) {
    // Convert timestamp to "2 hours ago"
}
```

---

## Testing Approach

### Manual Testing Checklist
- [ ] All forms submit correctly
- [ ] Validation works (client + server)
- [ ] Login/logout flow works
- [ ] Search returns correct results
- [ ] Filters work independently and combined
- [ ] CRUD operations work on all entities
- [ ] Error messages display properly
- [ ] Responsive design on mobile
- [ ] Cross-browser testing (Chrome, Firefox)

### SQL Injection Testing
- Try: `' OR '1'='1` in login fields
- Try: `1'; DROP TABLE users--` in search
- All should be blocked by prepared statements

### XSS Testing
- Try: `<script>alert('XSS')</script>` in all inputs
- All should be escaped on output

---

## Deployment Checklist

### Before Launch
1. Change all default passwords
2. Remove debug code and comments
3. Set `error_reporting(0)` in production
4. Enable HTTPS
5. Backup database
6. Set proper file permissions (755 for directories, 644 for files)
7. Create .htaccess for URL rewriting
8. Test on production environment

### .htaccess Example
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Prevent directory listing
Options -Indexes

# Protect config files
<FilesMatch "^(config|db-connect)\.php$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

---

## Git Workflow (If Using Version Control)

```
main branch: stable code only
dev branch: ongoing development
feature branches: new features

Commit messages:
- "Add pharmacy registration form"
- "Fix search filter bug"
- "Update database schema"
```

---

## Final Notes

### When Stuck
1. Check error logs: `tail -f /var/log/apache2/error.log`
2. Enable mysqli error reporting: `mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);`
3. Use `var_dump()` for debugging (remove before commit)
4. Test query in phpMyAdmin first

### Scalability Hooks
- Use constants for configuration (easy to change)
- Keep business logic in functions (easy to refactor)
- Use consistent naming (easy to search/replace)
- Comment only complex logic (not obvious code)
- Separate concerns (HTML, PHP, SQL, JS in proper places)

### Documentation
- README.md: Setup instructions, requirements
- INSTALL.md: Step-by-step installation
- Database diagram (optional but helpful)
- API endpoints documentation (if needed)

---

**Remember**: Simple, working code is better than complex, broken code. Build incrementally, test often, commit frequently.