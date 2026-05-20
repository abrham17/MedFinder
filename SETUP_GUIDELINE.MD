# MedFinder Ethiopia - Complete Setup Guide

This guide provides comprehensive instructions for setting up MedFinder Ethiopia from scratch, including database installation, backend configuration, and frontend deployment.

---

## Table of Contents

1. [System Requirements](#system-requirements)
2. [Prerequisites Installation](#prerequisites-installation)
3. [Database Setup](#database-setup)
4. [Backend Configuration](#backend-configuration)
5. [Frontend Setup](#frontend-setup)
6. [Running the Application](#running-the-application)
7. [Testing the Application](#testing-the-application)
8. [Troubleshooting](#troubleshooting)

---

## System Requirements

### Minimum Requirements
- **Operating System**: Ubuntu 20.04+ or equivalent Linux distribution
- **PHP**: 7.4 or higher (PHP 8.3 recommended)
- **MySQL**: 5.7 or higher (MySQL 8.0 recommended)
- **Web Server**: Apache 2.4+ or Nginx (optional for development)
- **RAM**: 2GB minimum, 4GB recommended
- **Disk Space**: 500MB minimum

### Recommended Requirements
- **Operating System**: Ubuntu 22.04 LTS
- **PHP**: 8.3
- **MySQL**: 8.0
- **Web Server**: Apache 2.4 with mod_php
- **RAM**: 4GB+
- **Disk Space**: 1GB+

---

## Prerequisites Installation

### Step 1: Update System Packages

```bash
sudo apt update
sudo apt upgrade -y
```

### Step 2: Install MySQL Server

```bash
sudo apt install mysql-server -y
```

Start MySQL service:

```bash
sudo systemctl start mysql
sudo systemctl enable mysql  ### starts mysql every time the system boots (so for me it is not recommended because we are doing this assignemtn only)
sudo systemctl enable --now mysql  ### starts mysql immediately and enables it for future boots (for both always + now)
```

Secure MySQL installation (optional but recommended):

```bash
sudo mysql_secure_installation
```

Follow the prompts to set a root password and secure the installation.

### Step 3: Install PHP and Required Extensions

```bash
sudo apt install php8.3 php8.3-mysql php8.3-curl php8.3-mbstring php8.3-xml -y
```

If using Apache web server:

```bash
sudo apt install apache2 libapache2-mod-php8.3 -y
sudo systemctl start apache2
sudo systemctl enable apache2
```

If using Nginx web server:

```bash
sudo apt install nginx php8.3-fpm -y
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl start php8.3-fpm
sudo systemctl enable php8.3-fpm
```

### Step 4: Install Git (for cloning the repository)

```bash
sudo apt install git -y
```

### Step 5: Clone the Repository

```bash
cd /var/www/html  # or your preferred web directory
sudo git clone https://github.com/abrham17/MedFinder.git
cd MedFinder
```

Set proper permissions:

```bash
sudo chown -R $USER:$USER /var/www/html/MedFinder
sudo chmod -R 755 /var/www/html/MedFinder
```

---

## Database Setup

### Step 1: Create Database

```bash
sudo mysql -u root -p
```

Enter your MySQL root password when prompted, then run:

```sql
CREATE DATABASE IF NOT EXISTS medfinder_ethiopia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Or create directly from command line:

```bash
sudo mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS medfinder_ethiopia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Step 2: Import Database Schema

Navigate to the MedFinder directory and import the schema:

```bash
cd /var/www/html/MedFinder
sudo mysql -u root -p medfinder_ethiopia < sql/database.sql
```

### Step 3: Import Seed Data (Optional but Recommended)

```bash
sudo mysql -u root -p medfinder_ethiopia < sql/seed_data.sql
```

This will populate the database with:
- 10 neighborhoods (Bole, Kirkos, Arada, Yeka, Lideta, Kolfe, Nefas Silk, Akaky Kaliti, Bole Bulbula, Gulele)
- 70+ medicines across various categories
- 3 sample pharmacies with inventory
- 1 admin user

### Step 4: Create Database User (Optional for Production)

For security, create a dedicated database user instead of using root:

```bash
sudo mysql -u root -p
```

```sql
CREATE USER 'medfinder_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON medfinder_ethiopia.* TO 'medfinder_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## Backend Configuration

### Step 1: Configure Database Credentials

Edit the configuration file:

```bash
nano includes/config.php
```

Update the database configuration section:

```php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Change to 'medfinder_user' if you created a dedicated user
define('DB_PASS', '');      // Enter your MySQL password
define('DB_NAME', 'medfinder_ethiopia');
```

### Step 2: Configure Site URL

Update the site URL in `includes/config.php`:

```php
// Site Configuration
define('SITE_NAME', 'MedFinder Ethiopia');
define('SITE_URL', 'http://localhost/MedFinder');  // Update to your actual domain
define('ADMIN_EMAIL', 'admin@medfinder.ethiopia');
```

For production:

```php
define('SITE_URL', 'https://yourdomain.com');
```

### Step 3: Configure Session Settings

```php
// Session Configuration
define('SESSION_NAME', 'medfinder_session');
define('SESSION_LIFETIME', 3600); // 1 hour in seconds
```

### Step 4: Configure File Upload Settings

```php
// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/pharmacy-logos/');
define('MAX_FILE_SIZE', 2097152); // 2MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);
```

### Step 5: Create Uploads Directory

```bash
mkdir -p uploads/pharmacy-logos
chmod 755 uploads/pharmacy-logos
```

### Step 6: Configure Error Reporting

For development (current setting):

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

For production:

```php
error_reporting(0);
ini_set('display_errors', 0);
error_log('/var/log/medfinder/error.log');
```

### Step 7: Configure Timezone

```php
date_default_timezone_set('Africa/Addis_Ababa');
```

---

## Frontend Setup

### Step 1: Configure Apache Virtual Host (If Using Apache)

Create a new virtual host configuration:

```bash
sudo nano /etc/apache2/sites-available/medfinder.conf
```

Add the following configuration:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAdmin admin@yourdomain.com
    DocumentRoot /var/www/html/MedFinder

    <Directory /var/www/html/MedFinder>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/medfinder_error.log
    CustomLog ${APACHE_LOG_DIR}/medfinder_access.log combined
</VirtualHost>
```

Enable the site:

```bash
sudo a2ensite medfinder.conf
sudo systemctl reload apache2
```

### Step 2: Configure Nginx (If Using Nginx)

Create a new server block:

```bash
sudo nano /etc/nginx/sites-available/medfinder
```

Add the following configuration:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html/MedFinder;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/medfinder /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 3: Configure SSL/HTTPS (Recommended for Production)

Using Let's Encrypt with Certbot:

```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d yourdomain.com
```

Or for Nginx:

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com
```

### Step 4: Set File Permissions

```bash
sudo chown -R www-data:www-data /var/www/html/MedFinder
sudo chmod -R 755 /var/www/html/MedFinder
sudo chmod -R 775 /var/www/html/MedFinder/uploads
```

---

## Running the Application

### Development Mode (PHP Built-in Server)

Navigate to the MedFinder directory:

```bash
cd /var/www/html/MedFinder
```

Start the PHP built-in server:

```bash
php -S localhost:8000
```

Access the application at: http://localhost:8000

To run in the background:

```bash
php -S localhost:8000 > /dev/null 2>&1 &
```

### Production Mode (Apache)

Apache should already be configured and running. Restart if needed:

```bash
sudo systemctl restart apache2
```

Access the application at: http://yourdomain.com

### Production Mode (Nginx)

Nginx should already be configured and running. Restart if needed:

```bash
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
```

Access the application at: http://yourdomain.com

---

## Testing the Application

### Step 1: Test Database Connection

Create a test file to verify database connectivity:

```bash
nano test_db.php
```

Add the following:

```php
<?php
require_once 'includes/config.php';
require_once 'includes/db-connect.php';

if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed!";
}
?>
```

Access: http://localhost:8000/test_db.php

Delete the test file after verification:

```bash
rm test_db.php
```

### Step 2: Test Admin Login

- Navigate to: http://localhost:8000/admin/login.php
- Username: `admin`
- Password: `admin123`
- Verify you can access the admin dashboard

### Step 3: Test Pharmacy Registration

- Navigate to: http://localhost:8000/pharmacy/register.php
- Fill in the registration form with test data
- Submit and verify the registration is successful
- Check the database to verify the pharmacy was created with 'pending' status

### Step 4: Test Pharmacy Login

- Navigate to: http://localhost:8000/pharmacy/login.php
- Use the pre-configured pharmacy account:
  - Email: `unity@medfinder.ethiopia`
  - Password: `pharmacy123`
- Verify you can access the pharmacy dashboard

### Step 5: Test Search Functionality

- Navigate to: http://localhost:8000/index.php
- Search for medicines (try: "Insulin", "Metformin", "Amoxicillin")
- Verify search results are displayed
- Test neighborhood filters
- Test stock status filters

### Step 6: Test Inventory Management

- Login as a pharmacy
- Navigate to: http://localhost:8000/pharmacy/inventory/index.php
- Add a new medicine to inventory
- Update an existing inventory item
- Remove an inventory item
- Verify all operations work correctly

### Step 7: Test Admin CRUD Operations

- Login as admin
- Test medicine catalog CRUD (add, edit, delete medicines)
- Test pharmacy management (approve, suspend, view pharmacies)
- Test neighborhood management (add, edit, delete neighborhoods)

### Step 8: Test Profile Update

- Login as a pharmacy
- Navigate to: http://localhost:8000/pharmacy/profile.php
- Update pharmacy details
- Upload a logo
- Verify changes are saved

---

## Troubleshooting

### Database Connection Issues

**Problem**: Cannot connect to database

**Solutions**:
1. Verify MySQL is running: `sudo systemctl status mysql`
2. Check database credentials in `includes/config.php`
3. Verify database exists: `sudo mysql -u root -p -e "SHOW DATABASES;"`
4. Check MySQL error logs: `sudo tail -f /var/log/mysql/error.log`

### Permission Issues

**Problem**: File upload or directory creation fails

**Solutions**:
1. Check directory permissions: `ls -la uploads/`
2. Set proper permissions: `sudo chmod 775 uploads/pharmacy-logos`
3. Check ownership: `ls -ld /var/www/html/MedFinder`
4. Fix ownership: `sudo chown -R www-data:www-data /var/www/html/MedFinder`

### PHP Errors

**Problem**: White screen or PHP errors

**Solutions**:
1. Enable error reporting in `includes/config.php`
2. Check PHP error logs: `tail -f /var/log/apache2/error.log` or `/var/log/nginx/error.log`
3. Verify PHP extensions are installed: `php -m | grep mysqli`
4. Check PHP version: `php -v`

### Session Issues

**Problem**: Login sessions not persisting

**Solutions**:
1. Verify session directory is writable: `ls -la /var/lib/php/sessions`
2. Check session configuration in `includes/config.php`
3. Clear browser cookies
4. Verify session lifetime setting

### Apache Issues

**Problem**: 403 Forbidden or 404 Not Found

**Solutions**:
1. Check Apache configuration: `sudo apache2ctl -S`
2. Verify DocumentRoot path
3. Check file permissions
4. Restart Apache: `sudo systemctl restart apache2`

### Nginx Issues

**Problem**: 502 Bad Gateway

**Solutions**:
1. Check if PHP-FPM is running: `sudo systemctl status php8.3-fpm`
2. Verify socket path in Nginx config matches PHP-FPM config
3. Check PHP-FPM error logs: `tail -f /var/log/php8.3-fpm.log`
4. Restart services: `sudo systemctl restart nginx php8.3-fpm`

### SSL Certificate Issues

**Problem**: HTTPS not working

**Solutions**:
1. Verify certificate is valid: `sudo certbot certificates`
2. Renew certificate: `sudo certbot renew`
3. Check Apache/Nginx SSL configuration
4. Verify firewall allows port 443: `sudo ufw status`

---

## Default Credentials

### Admin Account
- **Username**: `admin`
- **Password**: `admin123`
- **Dashboard**: `/admin/`

### Sample Pharmacy Accounts
1. **Unity Pharmacy**
   - **Email**: `unity@medfinder.ethiopia`
   - **Password**: `pharmacy123`
   - **Status**: Active

2. **BlueCross Pharmacy**
   - **Email**: `bluecross@medfinder.ethiopia`
   - **Password**: `pharmacy123`
   - **Status**: Active

3. **EthioCare Pharmacy**
   - **Email**: `ethiocare@medfinder.ethiopia`
   - **Password**: `pharmacy123`
   - **Status**: Pending

---

## Security Recommendations

1. **Change Default Passwords**: Immediately change all default passwords after first login
2. **Use HTTPS**: Always use SSL/TLS in production
3. **Disable Error Reporting**: Set `error_reporting(0)` in production
4. **Restrict File Uploads**: Validate all uploaded files
5. **Use Prepared Statements**: All database queries use prepared statements (already implemented)
6. **Implement Rate Limiting**: Add rate limiting to login forms
7. **Regular Backups**: Set up automated database backups
8. **Keep Software Updated**: Regularly update PHP, MySQL, and system packages

---

## Maintenance

### Database Backup

```bash
sudo mysqldump -u root -p medfinder_ethiopia > backup_$(date +%Y%m%d).sql
```

### Restore from Backup

```bash
sudo mysql -u root -p medfinder_ethiopia < backup_20240520.sql
```

### Log Rotation

Configure logrotate for application logs:

```bash
sudo nano /etc/logrotate.d/medfinder
```

Add:

```
/var/log/medfinder/*.log {
    daily
    rotate 7
    compress
    missingok
    notifempty
    create 0640 www-data www-data
}
```

---

## Support

For issues or questions:
- GitHub Repository: https://github.com/abrham17/MedFinder
- Email: admin@medfinder.ethiopia

---

**Last Updated**: May 20, 2026