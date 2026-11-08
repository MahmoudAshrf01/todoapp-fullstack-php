# PHP & SQL Todo App

A simple todo application built to practice SQL with PHP and MySQL. This is a learning project for working with database queries and basic CRUD operations.

## Features

- Add tasks
- View all tasks
- Edit task titles
- Delete tasks

## Technologies

- PHP with MySQLi
- MySQL
- HTML and Bootstrap
- JavaScript and jQuery

## Security notice

**This code is for practice only and is not ready for production.** It may contain security vulnerabilities and should not be deployed publicly or used with sensitive data.

Task creation, updates, and deletion use prepared statements. Known limitations include missing CSRF protection, no authentication or access controls, and hardcoded local database credentials. No intentional backdoors are known, but this project has not undergone a full security audit.

## Local setup

1. Install a local PHP and MySQL environment, such as WAMP or XAMPP, with the MySQLi extension enabled.
2. Place the project in your local web server's document root.
3. Create the database and table using the SQL below. The current `database/migration.php` file contains commented examples and does not create the database automatically.

   ```sql
   CREATE DATABASE IF NOT EXISTS todoapp
       CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

   USE todoapp;

   CREATE TABLE tasks (
       id INT PRIMARY KEY AUTO_INCREMENT,
       title VARCHAR(200) NOT NULL
   );
   ```

4. Update the database connection settings in `index.php` and the PHP files under `handlers/` to match your local environment. The current defaults are `localhost`, database `todoapp`, user `root`, and an empty password. Keep real credentials out of Git.
5. Start your local web server and MySQL, then open the project's `index.php` through localhost, for example `http://localhost/todo-app/`.

Bootstrap, Font Awesome, and jQuery are loaded from external CDNs, so an internet connection is needed for those assets.
