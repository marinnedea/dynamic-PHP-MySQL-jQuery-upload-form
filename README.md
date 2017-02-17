# Dynamic PHP+MySQL+jQuery multi-upload form

The script is a sample dynamic form; basically, you get a form containing 4 fields: First | Last | Email | Browse  and you have the option to add or remove rows from the form.

The script will save the First | Last | Email fields data in the database (see attached sample - accounts.sql) and will also save the path for the uploaded file ( e.g. uploads/filename.jpg ) and in the same will upload your file to the server in the upload directory ( e.g. uploads )

# Requirements
- Apache2 or better
- MySQL - 5.5.x  or better
- PHP 5.5 or better
- an upload directory with "chmode 655"

It shouldn't be a problem running on older versions of Apache/PHP/MySQL but I didn't tested it.

# To do
- split everything - create a templating structure
