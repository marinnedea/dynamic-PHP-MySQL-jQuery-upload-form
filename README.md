
# Dynamic PHP-MySQL-jQuery Upload Form

This project is a dynamic file upload form built using PHP, MySQL, and jQuery. It allows users to upload files and view them dynamically. Additionally, it includes an admin login system for secure access to the upload area. The project uses modern practices, such as PDO for database interactions, session-based authentication, and role-based access control.

## Features

1. **Secure Admin Area**:
   - Only authorized users can access the upload functionality.
   - Admin users must log in with valid credentials.

2. **File Upload System**:
   - Supports uploading files to a dedicated `uploads/` directory.
   - Stores file information in a MySQL database.

3. **File Management**:
   - Dynamically displays a list of uploaded files.

4. **User Management**:
   - Includes a login system for admins.
   - Role-based access ensures non-admins cannot access restricted pages.

5. **Secure Code**:
   - Uses prepared statements to prevent SQL injection.
   - Passwords are hashed with `password_hash` for secure storage.

6. **Optional Admin Registration**:
   - A separate registration page allows adding new admin users.



## Installation

### Prerequisites
- A web server with PHP 7.4 or higher (e.g., Apache or Nginx).
- MySQL database.
- Basic knowledge of setting up PHP projects.

### Steps to Set Up the Project

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/marinnedea/dynamic-PHP-MySQL-jQuery-upload-form.git
   cd dynamic-PHP-MySQL-jQuery-upload-form
   ```

2. **Set Up the Database**:
   - Import the provided `accounts.sql` file into your MySQL database:
     ```bash
     mysql -u your_username -p your_database_name < accounts.sql
     ```
   - Update the database credentials in the following files:
     - `index.php`
     - `login.php`
     - `register.php` (if used)

3. **Set Directory Permissions**:
   - Ensure the `uploads/` directory is writable by the web server:
     ```bash
     mkdir uploads
     chmod 755 uploads
     ```

4. **Access the Project**:
   - Open your browser and navigate to the project:
     - `login.php`: Admin login page.
     - `register.php` (Optional): Register a new admin user.
     - `index.php`: Admin area for uploading and viewing files (accessible only after login).



## Usage

### Admin Login
1. Navigate to the `login.php` page.
2. Log in using the default admin credentials (if provided) or create a new admin user via `register.php`.

### File Upload
1. After logging in, upload files using the form on `index.php`.
2. Uploaded files are saved in the `uploads/` directory and listed dynamically.

### Logout
- Click the **Logout** link to end your session.



## File Structure

```
dynamic-PHP-MySQL-jQuery-upload-form/
│
├── index.php            # Main file upload area (admin only)
├── login.php            # Admin login page
├── register.php         # Optional admin registration page
├── logout.php           # Ends the admin session
├── uploads/             # Directory where uploaded files are stored
├── accounts.sql         # SQL file to set up the users table
├── README.md            # Project documentation
```


## Security

- **Authentication**: Only authenticated users can access the upload form.
- **Password Hashing**: Passwords are hashed before storing them in the database.
- **SQL Injection Prevention**: All database interactions use prepared statements.
- **Role-Based Access Control**: Only users with the `admin` role can access the admin area.


## Future Enhancements

1. Add a progress bar for file uploads using jQuery.
2. Implement file type and size validation on both client and server sides.
3. Add a feature for admin users to delete uploaded files.
4. Enhance the UI with modern CSS frameworks (e.g., Bootstrap or TailwindCSS).


## Contributing

Feel free to submit issues or contribute to the project. Pull requests are welcome!

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m "Description of changes"`).
4. Push to your branch (`git push origin feature-branch`).
5. Open a pull request.


## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.


## Contact

For any inquiries or support, feel free to contact [Marin Nedea](https://github.com/marinnedea).
