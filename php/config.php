<?php
// config.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ninja_pizza";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the database exists, if not create it
$db_selected = mysqli_select_db($con, $dbname);
if (!$db_selected) {
    $sql = "CREATE DATABASE $dbname";
    if (mysqli_query($con, $sql)) {
        echo "Database created successfully\n";
    } else {
        die("Error creating database: " . mysqli_error($con));
    }

    // Select the created database
    mysqli_select_db($con, $dbname);
} else {
    echo "Database connection successful and database exists.\n";
}

// Function to check if a table exists
function tableExists($con, $tableName)
{
    $query = "SHOW TABLES LIKE '$tableName'";
    $result = mysqli_query($con, $query);
    return mysqli_num_rows($result) > 0;
}

// Check if 'users' table exists, if not create it
if (!tableExists($con, 'users')) {
    $sql_users = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255),
        email VARCHAR(255),
        age INT,
        password VARCHAR(200)
    );";

    if (mysqli_query($con, $sql_users)) {
        echo "Table 'users' created successfully\n";
    } else {
        die("Error creating table 'users': " . mysqli_error($con));
    }
} else {
    echo "Table 'users' already exists.\n";
}

// Check if 'pizzas' table exists, if not create it
if (!tableExists($con, 'pizzas')) {
    $sql_pizzas = "CREATE TABLE pizzas (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(50) NOT NULL,
        ingredients TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

    if (mysqli_query($con, $sql_pizzas)) {
        echo "Table 'pizzas' created successfully\n";
    } else {
        die("Error creating table 'pizzas': " . mysqli_error($con));
    }
} else {
    echo "Table 'pizzas' already exists.\n";
}

// Do not close the connection here