# Dynamic PHP+MySQL+jQuery multi-upload form

The script is a sample dynamic form; basically, you get a form containing 4 fields: First | Last | Email | Browse  and you have the option to add or remove rows from the form.

The script will save the First | Last | Email fields data in the database (see attached sample - accounts.sql) and will also save the path for the uploaded file ( e.g. uploads/filename.jpg ) and in the same will upload your file to the server in the upload directory ( e.g. uploads )

# Requirements
- Apache2 or better
- MySQL - 5.5.x  or better
- PHP 5.5 or better
- an upload directory with "chmod 755" for the files to upload.

It shouldn't be a problem running on older versions of Apache/PHP/MySQL but I didn't tested it.

# Usage
- save the script on a webserver in a folder of your choice (e.g. /var/www/my_project/)
- create in the same folder a new folder and name it "uploads". If you chose a different name, make sure to change the name in the script too. 
- change the rights on the "uploads" folder to 755 (chmod -R 755 /var/www/my_project/uploads or chmod u+rwX,go+r -R /var/www/my_project/uploads)
- create a database and inside the database import the attached accounts.sql file.
- modify the script to reflect the details of your DB (so it can connect and save data to it)
- open the script via a web browser ( e.g. http://your_server_address/my_project/script_name.php ) and test it.


# To do
- I'll have to split everything and create a templating structure, maybe also an admin area.

Enjoy!
