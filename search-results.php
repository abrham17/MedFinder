<?php
$page_title = 'Search Results - MedFinder Ethiopia';
$asset_path = '';
$extra_js = array('js/search.js');
include 'includes/header.php';

require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/db-connect.php';

// Get search parameters
$query = isset($_GET['q']) ? sanitize_input($_GET['q']) : '';
$neighborhood_id = isset($_GET['neighborhood']) ? (int)$_GET['neighborhood'] : null;
$status_filter = isset($_GET['status']) ? sanitize_input($_GET['status']) : null;

$results = [];
$results_count = 0;
$search_performed = false;

if (!empty($query)) {
    $search_performed = true;
    $results = search_pharmacies_by_medicine($conn, $query, $neighborhood_id, $status_filter);
    $results_count = count($results);
    
    // Log search for analytics
    if ($results_count > 0) {
        $stmt = $conn->prepare("INSERT INTO search_logs (medicine_name, neighborhood_id, results_count) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $query, $neighborhood_id, $results_count);
        $stmt->execute();
    }
}
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Search results</p>
                <h1 class="page-title"><?php echo htmlspecialchars($query); ?> <?php echo $neighborhood_id ? 'in ' . htmlspecialchars($results[0]['neighborhood_name'] ?? '') : ''; ?></h1>
                <p class="page-subtitle"><?php echo $search_performed ? 'Found ' . $results_count . ' pharmacies with available stock.' : 'Enter a medicine name to search.'; ?></p>
                <div class="breadcrumb">
                    <a href="index.php">Home</a>
                    <span>/</span>
                    <span>Search results</span>
                </div>
            </div>
            <div class="page-actions">
                <a class="btn btn-secondary" href="index.php">New search</a>
                <a class="btn btn-primary" href="pharmacy/register.php">List your pharmacy</a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container page-layout">
            <aside class="sidebar">
                <h3 class="panel-title">Filter results</h3>
                <form class="filter-form" action="search-results.php" method="get">
                    <div class="form-group">
                        <label for="filter-medicine">Medicine</label>
                        <input type="text" id="filter-medicine" name="q" placeholder="Insulin" value="<?php echo htmlspecialchars($query); ?>">
                    </div>
                    <div class="form-group">
                        <label for="filter-neighborhood">Neighborhood</label>
                        <select id="filter-neighborhood" name="neighborhood">
                            <option value="">All neighborhoods</option>
                            <?php 
                            $neighborhoods = get_all_neighborhoods($conn);
                            foreach ($neighborhoods as $hood): 
                                $selected = ($neighborhood_id == $hood['neighborhood_id']) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $hood['neighborhood_id']; ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($hood['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stock status</label>
                        <div class="radio-list">
                            <label><input type="radio" name="status" value="" <?php echo $status_filter === '' ? 'checked' : ''; ?>> Any</label>
                            <label><input type="radio" name="status" value="in_stock" <?php echo $status_filter === 'in_stock' ? 'checked' : ''; ?>> In stock</label>
                            <label><input type="radio" name="status" value="limited" <?php echo $status_filter === 'limited' ? 'checked' : ''; ?>> Limited</label>
                            <label><input type="radio" name="status" value="out_of_stock" <?php echo $status_filter === 'out_of_stock' ? 'checked' : ''; ?>> Out of stock</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Services</label>
                        <div class="check-list">
                            <label><input type="checkbox" name="service[]" value="delivery"> Delivery</label>
                            <label><input type="checkbox" name="service[]" value="insurance"> Insurance accepted</label>
                            <label><input type="checkbox" name="service[]" value="24hrs"> 24 hour service</label>
                        </div>
                    </div>
                    <div class="filter-actions">
                        <button class="btn btn-primary" type="submit">Apply filters</button>
                        <button class="btn btn-link" type="button" data-reset-filters>Reset filters</button>
                    </div>
                    <!-- Backend: bind filters to the live search query. -->
                </form>
            </aside>

            <div class="content-area">
                <div class="results-toolbar">
                    <div class="search-inline">
                        <div class="form-group">
                            <label for="inline-search">Refine search</label>
                            <input type="text" id="inline-search" placeholder="Search again">
                        </div>
                        <div class="form-group">
                            <label for="sort-results">Sort by</label>
                            <select id="sort-results">
                                <option value="nearest">Nearest</option>
                                <option value="price_low">Lowest price</option>
                                <option value="updated">Recently updated</option>
                            </select>
                        </div>
                    </div>
                    <span class="pill pill-success"><?php echo $results_count; ?> pharmacies</span>
                </div>

                <div class="result-list">
                    <?php if ($search_performed && $results_count > 0): ?>
                        <?php foreach ($results as $result): ?>
                            <article class="card result-card">
                                <div class="card-header">
                                    <h3><?php echo htmlspecialchars($result['pharmacy_name']); ?></h3>
                                    <?php echo render_status_badge($result['stock_status']); ?>
                                </div>
                                <p class="card-meta"><?php echo htmlspecialchars($result['neighborhood_name']); ?>, <?php echo htmlspecialchars($result['address']); ?></p>
                                <div class="card-details">
                                    <span>Price: <?php echo $result['price'] ? number_format($result['price'], 2) . ' ETB' : 'Not specified'; ?></span>
                                    <span>Quantity: <?php echo $result['quantity']; ?></span>
                                    <span>Updated: <?php echo time_ago($result['updated_at']); ?></span>
                                </div>
                                <div class="card-actions">
                                    <a class="btn btn-secondary" href="pharmacy-detail.php?id=<?php echo $result['pharmacy_id']; ?>">View details</a>
                                    <a class="btn btn-link" href="tel:<?php echo format_ethiopian_phone($result['phone']); ?>">Call</a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php elseif ($search_performed && $results_count === 0): ?>
                        <div class="card empty-state">
                            <h3>No pharmacies found</h3>
                            <p>Try adjusting filters or searching by a different brand name.</p>
                            <a class="btn btn-secondary" href="index.php">Start a new search</a>
                        </div>
                    <?php else: ?>
                        <div class="card empty-state">
                            <h3>Enter a medicine name to search</h3>
                            <p>Search for medicines across all registered pharmacies.</p>
                            <a class="btn btn-secondary" href="index.php">Go to home page</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
