# Deploying LMS Digi Sindh to a Domain

Follow these steps to put the application on your live domain (shared hosting or VPS).

---

## 1. Server requirements

- **PHP** 8.2+ (with extensions): `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `pdo_mysql` (or `pdo_sqlite`), `tokenizer`, `xml`
- **MySQL** 5.7+ / **MariaDB** 10.3+ (or SQLite if you prefer)
- **Composer** (on the server or deploy via Git + run composer on server/CI)
- **Web server**: Apache or Nginx

---

## 2. Upload the application

### Option A: Upload via FTP/SFTP (e.g. FileZilla)

1. Connect to your host with FTP/SFTP.
2. Upload **all project files** to a folder (e.g. `lms` or `public_html/lms`).
   - Do **not** upload: `node_modules/`, `vendor/` (install on server), `.env` (create on server), `.git/`
3. If you upload `vendor/`, you can skip running Composer on the server. Otherwise upload without `vendor/` and run Composer on the server (see Option B).

### Option B: Deploy with Git (recommended on VPS)

```bash
# On server (e.g. in /var/www/ or your hosting’s repo path)
git clone <your-repo-url> lms-digi-sindh
cd lms-digi-sindh
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
# Then configure .env (see step 3) and run migrations (step 5)
```

---

## 3. Point the domain to the right folder (document root)

Laravel must run from the **`public`** folder as the web root.

### If you have a subfolder (e.g. `lms`) under `public_html`:

- **Option 1 – Subfolder as document root**  
  Set your domain’s document root to:  
  `public_html/lms/public`  
  So the site URL is: `https://yourdomain.com` (no `/lms` in the URL).

- **Option 2 – Keep files in subfolder, URL has /lms**  
  Document root stays `public_html`.  
  Then in `.env` set:
  ```env
  APP_URL=https://yourdomain.com/lms/public
  ```
  And ensure your server rewrites (e.g. `.htaccess`) work so that `https://yourdomain.com/lms/public` is the entry point.

**Recommended:** Set the domain’s document root to `.../lms/public` so the URL is clean (`https://yourdomain.com`).

### Apache (.htaccess)

The project’s `public/.htaccess` is usually enough. If the site is in a subfolder, you may need a root `.htaccess` that redirects to `public/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### Nginx (example)

```nginx
root /var/www/lms-digi-sindh/public;
index index.php;
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    include fastcgi_params;
}
```

---

## 4. Create and configure `.env` on the server

1. Copy `.env.example` to `.env` (if not already done):
   ```bash
   cp .env.example .env
   ```
2. Generate app key:
   ```bash
   php artisan key:generate
   ```
3. Edit `.env` and set at least:

```env
APP_NAME="LMS Digi Sindh"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database (use your hosting’s MySQL credentials)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

- If the app is in a subfolder (e.g. `/lms/public`), set `APP_URL` to that full URL.
- Create the MySQL database and user in your hosting panel (cPanel, Plesk, etc.) and use those values.

---

## 5. Database: import your local database on the server

If you want to use the **same data** as on your local machine (instead of a fresh install), do this:

### On your local machine (export)

**If you use MySQL/MariaDB locally:**

```bash
# Replace with your local DB name, user, and output file
mysqldump -u root -p your_database_name > lms_backup.sql
```

**If you use SQLite locally:**

- Copy the file `database/database.sqlite` to your computer (you will upload it to the server).

### On the server (import)

**MySQL/MariaDB:**

1. Create an empty database and user in your hosting panel (cPanel, Plesk, etc.).
2. In `.env` on the server, set:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=your_server_database_name
   DB_USERNAME=your_server_db_user
   DB_PASSWORD=your_server_db_password
   ```
3. Import the dump (via SSH or phpMyAdmin):
   ```bash
   mysql -u your_server_db_user -p your_server_database_name < lms_backup.sql
   ```
   Or in phpMyAdmin: select the database → **Import** → choose `lms_backup.sql` → Go.

**SQLite:**

1. In `.env` on the server, keep:
   ```env
   DB_CONNECTION=sqlite
   ```
2. Upload your local `database/database.sqlite` to the server at `database/database.sqlite` (overwrite the empty one if it exists).
3. Ensure the web server can read/write `database/database.sqlite` (e.g. `chmod 664 database/database.sqlite` and correct ownership).

After importing, **do not** run `php artisan migrate` again (your data is already there). Only create the installer lock file:

```bash
echo "Installed" > storage/installed
```

Then run the optimization commands from step 7 (config:cache, route:cache, view:cache).

---

## 6. Run installation / migrations (fresh install only)

Use this only if you are **not** importing a database and want a clean install.

**First-time install (no `storage/installed`):**

- Open in browser: `https://yourdomain.com/install`
- Complete the web installer (database + Super Admin). It will create `storage/installed` and run migrations.

**If you already have `.env` and DB and want to run migrations manually:**

```bash
php artisan migrate --force
php artisan db:seed --class=Database\\Seeders\\RoleSeeder --force
php artisan db:seed --class=Database\\Seeders\\SuperAdminSeeder --force
```

Then create the lock file so the installer is disabled:

```bash
# On Linux/macOS
echo "Installed" > storage/installed
```

---

## 7. Permissions (Linux / VPS)

```bash
# Storage and cache must be writable by the web server
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

Use the user your web server runs as (e.g. `www-data`, `nginx`, `apache`).

---

## 8. Optimize for production

Run once after deployment (and after any code/config change):

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 9. Optional: queue worker and scheduler (VPS)

If you use queues or the scheduler:

```bash
# In cron (run every minute)
* * * * * cd /path/to/lms-digi-sindh && php artisan schedule:run >> /dev/null 2>&1
```

For queue worker (if you use database queue):

```bash
php artisan queue:work --daemon
```

(Or use Supervisor to keep the worker running.)

---

## 10. SSL (HTTPS)

- Prefer **Let’s Encrypt** (free) from your hosting panel or with Certbot.
- After enabling HTTPS, set in `.env`:
  ```env
  APP_URL=https://yourdomain.com
  ```
  And ensure your app uses HTTPS (many hosts set `APP_URL` automatically).

---

## Quick checklist (with database import)

| Step | Action |
|------|--------|
| 1 | Upload code to server (FTP or Git). |
| 2 | Set document root to `public` (e.g. `public_html/lms/public`). |
| 3 | Create `.env` from `.env.example`, set `APP_URL` and `DB_*` for the server database. |
| 4 | Run `php artisan key:generate`. |
| 5 | **Export** DB on local (MySQL: `mysqldump`; SQLite: copy `database/database.sqlite`). **Import** on server (MySQL: import dump; SQLite: upload file). |
| 6 | Create `storage/installed` (so `/install` is disabled). Set permissions on `storage` and `bootstrap/cache`. |
| 7 | Run `config:cache`, `route:cache`, `view:cache`. |

After that, open `https://yourdomain.com` (or `https://yourdomain.com/install` for first-time setup).
