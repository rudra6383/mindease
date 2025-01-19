<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "mindease";  // Make sure the database name is correct
$conn = "";

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    if (!$conn) {
        throw new mysqli_sql_exception('Database connection failed: ' . mysqli_connect_error());
    }
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
