<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form input
    $dbName = $_POST['db_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Store form data in session variables
    $_SESSION['db_name'] = $dbName;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    // Redirect to create_table.php
    header("Location: index.php");
    exit();
}
?>
