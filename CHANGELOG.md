# Changelog

## [Unreleased]

## [2.0.0] - 2026-04-29

### Added
- `config.php` — centralised DB connection (was duplicated across `index.php`, `login.php`, `register.php`)
- `accounts.sql` — added missing `uploads` table; without it the file insert would fail on a fresh install
- File upload validation in `index.php`: MIME type check (JPEG, PNG, GIF, PDF) and 5 MB size limit

### Fixed
- `acounts.sql` → `accounts.sql` (filename typo; the README already used the correct spelling)
- `register.php` was completely unprotected — anyone could browse to it and create an admin account; now requires an active admin session
- `int(11)` display-width syntax removed (deprecated in MySQL 8.0)
- `utf8` → `utf8mb4` for full Unicode support
- `$username` variable in `login.php` was shadowed by the PDO credential variable of the same name

### Changed
- PDO options consolidated into the constructor array instead of separate `setAttribute` calls
- Named PDO placeholders (`:param`) replaced with positional (`?`) for conciseness
- `SELECT * FROM uploads` → `SELECT filename FROM uploads ORDER BY id DESC`
- Upload feedback in `index.php` collected into `$message` and rendered in the HTML rather than echoed mid-PHP-block
- `login.php`: `$error` initialised to `''`; removed unreachable `else` branch after `header()`+`exit`

## [1.0.0] - 2020–2024

Initial development: PHP/MySQL file upload form with admin login, role-based access, and PDO prepared statements.
