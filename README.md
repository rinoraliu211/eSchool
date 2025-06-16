# eSchool

## Description

eSchool is an online school management system built with PHP MVC, Eloquent ORM, Composer, DomPDF, and Bootstrap. It manages students, teachers, classes, attendance, grades, and generates PDF reports with role-based access for admins, teachers, and students.

## Technologies Used

- PHP (OOP, MVC)
- Eloquent ORM
- Composer
- DomPDF
- Bootstrap
- JavaScript
- MySQL

## Installation and Setup

1. Make sure you have a local server installed such as [XAMPP](https://www.apachefriends.org/index.html) or [Laragon](https://laragon.org/).
2. Clone or download the project into your local server directory (e.g., `htdocs` for XAMPP).
3. Import the database files located in the `database` folder into MySQL (using phpMyAdmin or command line).  
   You can also import via terminal with:  
   ```bash
   mysql -u root -p your_database_name < path/to/database/file.sql
