<?php
$page_title = 'Search Results - MedFinder Ethiopia';
$asset_path = '';
$extra_js = array('js/search.js');
include 'includes/header.php';
?>

<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-inner">
            <div>
                <p class="eyebrow">Search results</p>
                <h1 class="page-title">Insulin in Bole</h1>
                <p class="page-subtitle">Found 12 pharmacies with available stock.</p>
                <!-- Backend: replace this summary with live query results. -->
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
                        <input type="text" id="filter-medicine" name="q" placeholder="Insulin">
                    </div>
                    <div class="form-group">
                        <label for="filter-neighborhood">Neighborhood</label>
                        <select id="filter-neighborhood" name="neighborhood">
                            <option value="">All neighborhoods</option>
                            <option value="bole">Bole</option>
                            <option value="kirkos">Kirkos</option>
                            <option value="arada">Arada</option>
                            <option value="yeka">Yeka</option>
                            <option value="lideta">Lideta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stock status</label>
                        <div class="radio-list">
                            <label><input type="radio" name="status" value="" checked> Any</label>
                            <label><input type="radio" name="status" value="in_stock"> In stock</label>
                            <label><input type="radio" name="status" value="limited"> Limited</label>
                            <label><input type="radio" name="status" value="out_of_stock"> Out of stock</label>
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
                    <span class="pill pill-success">12 pharmacies</span>
                </div>

                <div class="result-list">
                    <article class="card result-card">
                        <div class="card-header">
                            <h3>Unity Pharmacy</h3>
                            <span class="badge badge-success">In stock</span>
                        </div>
                        <p class="card-meta">Bole, Atlas Area</p>
                        <div class="card-details">
                            <span>Price range: 230 - 260 ETB</span>
                            <span>Updated 15 minutes ago</span>
                            <span>Open until 9:00 PM</span>
                        </div>
                        <div class="card-actions">
                            <a class="btn btn-secondary" href="pharmacy-detail.php">View details</a>
                            <a class="btn btn-link" href="tel:+251912345678">Call</a>
                        </div>
                    </article>

                    <article class="card result-card">
                        <div class="card-header">
                            <h3>EthioCare Pharmacy</h3>
                            <span class="badge badge-warning">Limited</span>
                        </div>
                        <p class="card-meta">Kirkos, Meskel Square</p>
                        <div class="card-details">
                            <span>Price range: 240 - 275 ETB</span>
                            <span>Updated 45 minutes ago</span>
                            <span>Open until 8:00 PM</span>
                        </div>
                        <div class="card-actions">
                            <a class="btn btn-secondary" href="pharmacy-detail.php">View details</a>
                            <a class="btn btn-link" href="tel:+251911223344">Call</a>
                        </div>
                    </article>

                    <article class="card result-card">
                        <div class="card-header">
                            <h3>BlueCross Pharmacy</h3>
                            <span class="badge badge-danger">Out of stock</span>
                        </div>
                        <p class="card-meta">Yeka, Megenagna</p>
                        <div class="card-details">
                            <span>Expected restock: Tomorrow</span>
                            <span>Updated 2 hours ago</span>
                            <span>Open until 10:00 PM</span>
                        </div>
                        <div class="card-actions">
                            <a class="btn btn-secondary" href="pharmacy-detail.php">View details</a>
                            <a class="btn btn-link" href="tel:+251900112233">Call</a>
                        </div>
                    </article>
                </div>

                <!-- Backend: show this block only when no results match the filters. -->
                <div class="card empty-state">
                    <h3>No pharmacies found</h3>
                    <p>Try adjusting filters or searching by a different brand name.</p>
                    <a class="btn btn-secondary" href="index.php">Start a new search</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
