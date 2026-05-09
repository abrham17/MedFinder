<?php
$page_title = 'MedFinder Ethiopia - Find medicine fast';
$asset_path = '';
include 'includes/header.php';
?>

<main id="main-content">
    <section class="hero">
        <div class="container hero-inner">
            <div class="hero-content reveal">
                <p class="eyebrow">Medicine search made simple</p>
                <h1>Find real-time medicine availability across your neighborhood.</h1>
                <p class="lead">Search by medicine, compare stock status, and call verified pharmacies in minutes.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="search-results.php">Start search</a>
                    <a class="btn btn-secondary" href="pharmacy/register.php">List your pharmacy</a>
                </div>
                <div class="hero-highlights">
                    <div class="highlight-card">
                        <p class="highlight-number">120+</p>
                        <p class="highlight-label">Partner pharmacies</p>
                    </div>
                    <div class="highlight-card">
                        <p class="highlight-number">3,800+</p>
                        <p class="highlight-label">Medicines tracked</p>
                    </div>
                    <div class="highlight-card">
                        <p class="highlight-number">15</p>
                        <p class="highlight-label">Neighborhoods covered</p>
                    </div>
                </div>
            </div>
            <div class="hero-search reveal delay-1">
                <form class="search-form" action="search-results.php" method="get">
                    <div class="form-group">
                        <label for="search-medicine">Medicine name</label>
                        <input type="text" id="search-medicine" name="q" placeholder="Search Insulin, Amoxicillin, Paracetamol" required>
                    </div>
                    <div class="form-group">
                        <label for="search-neighborhood">Neighborhood</label>
                        <select id="search-neighborhood" name="neighborhood">
                            <option value="">All neighborhoods</option>
                            <option value="bole">Bole</option>
                            <option value="kirkos">Kirkos</option>
                            <option value="arada">Arada</option>
                            <option value="yeka">Yeka</option>
                            <option value="lideta">Lideta</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="search-status">Stock status</label>
                        <select id="search-status" name="status">
                            <option value="">Any status</option>
                            <option value="in_stock">In stock</option>
                            <option value="limited">Limited</option>
                            <option value="out_of_stock">Out of stock</option>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Search pharmacies</button>
                    <p class="form-note">Results update when backend search is connected.</p>
                </form>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">Featured pharmacies</p>
                    <h2>Verified local partners</h2>
                </div>
                <a class="link" href="search-results.php">View all pharmacies</a>
            </div>
            <div class="card-grid">
                <article class="card pharmacy-card reveal">
                    <div class="card-header">
                        <h3>Unity Pharmacy</h3>
                        <span class="badge badge-success">In stock</span>
                    </div>
                    <p class="card-meta">Bole, Atlas Area</p>
                    <div class="card-details">
                        <span>24 medicines listed</span>
                        <span>Open until 9:00 PM</span>
                    </div>
                    <div class="card-actions">
                        <a class="btn btn-secondary" href="pharmacy-detail.php">View details</a>
                        <a class="btn btn-link" href="tel:+251912345678">Call</a>
                    </div>
                </article>

                <article class="card pharmacy-card reveal delay-1">
                    <div class="card-header">
                        <h3>EthioCare Pharmacy</h3>
                        <span class="badge badge-warning">Limited</span>
                    </div>
                    <p class="card-meta">Kirkos, Meskel Square</p>
                    <div class="card-details">
                        <span>19 medicines listed</span>
                        <span>Open until 8:00 PM</span>
                    </div>
                    <div class="card-actions">
                        <a class="btn btn-secondary" href="pharmacy-detail.php">View details</a>
                        <a class="btn btn-link" href="tel:+251911223344">Call</a>
                    </div>
                </article>

                <article class="card pharmacy-card reveal delay-2">
                    <div class="card-header">
                        <h3>BlueCross Pharmacy</h3>
                        <span class="badge badge-danger">Out of stock</span>
                    </div>
                    <p class="card-meta">Yeka, Megenagna</p>
                    <div class="card-details">
                        <span>31 medicines listed</span>
                        <span>Opens at 8:00 AM</span>
                    </div>
                    <div class="card-actions">
                        <a class="btn btn-secondary" href="pharmacy-detail.php">View details</a>
                        <a class="btn btn-link" href="tel:+251900112233">Call</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-accent">
        <div class="container steps-grid">
            <div class="steps-header">
                <p class="eyebrow">How it works</p>
                <h2>Search, compare, and connect.</h2>
                <p class="lead">Every result is tied to real pharmacy inventory updates.</p>
            </div>
            <div class="steps-list">
                <div class="step-card reveal">
                    <span class="step-number">1</span>
                    <h3>Search a medicine</h3>
                    <p>Type a brand or generic name and choose your neighborhood.</p>
                </div>
                <div class="step-card reveal delay-1">
                    <span class="step-number">2</span>
                    <h3>Compare availability</h3>
                    <p>See stock status, price ranges, and operating hours.</p>
                </div>
                <div class="step-card reveal delay-2">
                    <span class="step-number">3</span>
                    <h3>Call and confirm</h3>
                    <p>Reach pharmacies directly to reserve medicine quickly.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-header">
                <div>
                    <p class="eyebrow">Live impact</p>
                    <h2>Helping families find medicine faster</h2>
                </div>
            </div>
            <div class="stat-grid">
                <div class="stat-card reveal">
                    <h3>6 min</h3>
                    <p>Average search time</p>
                </div>
                <div class="stat-card reveal delay-1">
                    <h3>92%</h3>
                    <p>Users find results on first search</p>
                </div>
                <div class="stat-card reveal delay-2">
                    <h3>350+</h3>
                    <p>Daily search sessions</p>
                </div>
                <div class="stat-card reveal delay-3">
                    <h3>24/7</h3>
                    <p>Search access across devices</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta">
        <div class="container cta-inner">
            <div>
                <p class="eyebrow">Pharmacy owners</p>
                <h2>Update inventory and reach more customers.</h2>
                <p class="lead">Join the verified network and publish your stock in minutes.</p>
            </div>
            <div class="cta-actions">
                <a class="btn btn-primary" href="pharmacy/register.php">Register pharmacy</a>
                <a class="btn btn-secondary" href="pharmacy/login.php">Pharmacy login</a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
