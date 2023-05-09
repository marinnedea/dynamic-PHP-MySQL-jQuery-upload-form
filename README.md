# Dynamic PHP+MySQL+jQuery multi-upload form

The script is a sample dynamic form; basically, you get a form containing 4 fields and you have the option to add or remove rows from the form.

The general structure will look like:

## User Information

| # | First Name | Last Name | Email         | File Upload | Remove |
|---|------------|-----------|---------------|-------------|--------|
| 1 | John       | Doe       | john@example.com | [Choose File] | [Remove] |
| 2 | Jane       | Smith     | jane@example.com | [Choose File] | [Remove] |
| 3 | Bob        | Johnson   | bob@example.com  | [Choose File] | [Remove] |

<button id="add-row-btn" class="btn btn-primary">Add Row</button>


## How it works 
The script will save the First | Last | Email fields data in the database (see attached sample - `accounts.sql`) and will also save the path for the uploaded file ( e.g. `uploads/filename.jpg` ) and in the same will upload your file to the server in the upload directory ( e.g. `/uploads` )

# Requirements
- Apache2 or better
- MySQL - 5.5.x  or better
- PHP 7.x or better
- an upload directory with "chmod 755" for the files to upload.

It shouldn't be a problem running on older versions of Apache/PHP/MySQL but I didn't tested it.

# Usage
- save the script on a webserver in a directory for your project (e.g. `/var/www/my_project/`)
- create in the project directory a new directory and name it "uploads" (e.g. `/var/www/my_project/uploads`). If you chose a different name, make sure to change the name in the script too. 
- change the permissions on the "uploads" folder to 755 (`sudo chmod -R 755 /var/www/my_project/uploads` or `sudo chmod u+rwX,go+r -R /var/www/my_project/uploads`)
- create a database and inside the database import the attached accounts.sql file:
    1. Open a terminal or command prompt on your computer.
    2. Log in to MySQL using the mysql command-line tool, using the username and password for your MySQL server: `mysql -u username -p` (Replace the username with your MySQL username, and you will be prompted to enter your MySQL password)
    3. Create a new database (if it doesn't already exist) by running the following command: `CREATE DATABASE database_name;` (Replace database_name with the name of the database you want to create)
    4. Switch to the new database by running the following command: `USE database_name;`
    5. Import the SQL file into the database by running the following command: `SOURCE /path/to/accounts.sql;` (Replace `/path/to/accounts.sql` with the actuall path to the `accounts.sql` file on your machine )
- modify the script to use the credentials for your DB
- open the script via a web browser ( e.g. http://localhost/my_project/script_name.php ) and test it.


# To do
- I'll have to split everything and create a templating structure, maybe also an admin area.

Enjoy!
