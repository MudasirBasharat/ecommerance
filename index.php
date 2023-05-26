<?php
session_start(); // Start the session

// Retrieve form data from session variables
$dbName = $_SESSION['db_name'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
// $Database = $_SESSION['Database'];
// Establish connection to MySQL
$connection = mysqli_connect("localhost", $username, $password);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the database
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if (mysqli_query($connection, $sql)) {
    echo "Database created successfully. ";

    // Select the created database
    mysqli_select_db($connection, $dbName);

    // Create tables
    $tables = array(
        "users" => "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
        )",
        "orders" => "CREATE TABLE orders (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED,
            product VARCHAR(50) NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )",
        "products" => "CREATE TABLE products (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            price DECIMAL(10,2) NOT NULL
        )",
        "order_items" => "CREATE TABLE order_items (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            order_id INT(6) UNSIGNED,
            product_id INT(6) UNSIGNED,
            quantity INT(6) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )"
    );

    foreach ($tables as $tableName => $tableQuery) {
        if (mysqli_query($connection, $tableQuery)) {
            echo "Table '$tableName' created successfully. ";
        } else {
            echo "Error creating table '$tableName': " . mysqli_error($connection);
        }
    }
} else {
    echo "Error creating database: " . mysqli_error($connection);
}

// Close the connection
mysqli_close($connection);
?>