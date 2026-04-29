# Dynamic PHP-MySQL Upload Form

A file upload form built with PHP and MySQL. Includes admin login, role-based access control, and file management. Uses PDO for all database interactions.

## Features

1. **Secure Admin Area** — only authenticated users with the `admin` role can access the upload functionality
2. **File Upload** — validates MIME type (JPEG, PNG, GIF, PDF) and enforces a 5 MB size limit before saving to `uploads/`
3. **File Listing** — displays uploaded files after login
4. **Admin Management** — optional registration page for creating additional admin accounts (requires an existing admin session)
5. **Secure Code** — prepared statements throughout, passwords hashed with `password_hash`

## Installation

### Prerequisites
- PHP 7.4 or higher (Apache or Nginx)
- MySQL 5.7+ / MariaDB

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/marinnedea/dynamic-PHP-MySQL-jQuery-upload-form.git
   cd dynamic-PHP-MySQL-jQuery-upload-form
   ```

2. **Set up the database**:
   ```bash
   mysql -u your_username -p your_database < accounts.sql
   ```

3. **Configure database credentials** — edit `config.php`:
   ```php
   $dsn     = 'mysql:host=your_host;dbname=your_database;charset=utf8mb4';
   $db_user = 'your_username';
   $db_pass = 'your_password';
   ```

4. **Set directory permissions**:
   ```bash
   mkdir uploads
   chmod 755 uploads
   ```

5. **Bootstrap the first admin user**:
   - Temporarily comment out the session guard in `register.php` (see the comment in that file)
   - Visit `register.php`, create your admin account
   - Uncomment the guard again

6. **Access the project**:
   - `login.php` — admin login
   - `index.php` — upload area (admin only)
   - `register.php` — create additional admin accounts (admin only)

## File Structure

```
dynamic-PHP-MySQL-jQuery-upload-form/
├── config.php           # Database connection (edit credentials here)
├── index.php            # File upload area (admin only)
├── login.php            # Admin login page
├── register.php         # Create additional admin accounts (admin only)
├── logout.php           # Ends the session
├── accounts.sql         # Creates the users and uploads tables
├── uploads/             # Uploaded files are stored here
├── CHANGELOG.md         # Version history
└── README.md
```

## Security

- **Authentication** — session-based, all protected pages redirect to `login.php` if not logged in
- **Role-based access** — only users with `role = admin` can reach `index.php` and `register.php`
- **File validation** — MIME type and size checked server-side before the file is accepted
- **SQL injection prevention** — all queries use PDO prepared statements
- **Password hashing** — `password_hash` / `password_verify` with `PASSWORD_DEFAULT`

## Future Enhancements

1. Add a progress bar for file uploads
2. Allow admin users to delete uploaded files
3. Improve the UI with a CSS framework (e.g., Bootstrap or Tailwind)

## License

MIT — see [LICENSE](LICENSE).

## Contact

[Marin Nedea](https://github.com/marinnedea)
