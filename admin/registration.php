<?php
header('Content-Type: application/json'); // Set content type to JSON

$servername = "localhost"; // Replace with your server details
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "senti-shield"; // Replace with your database name

// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(array('status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error));
    exit();
}

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $conn->real_escape_string($_POST['rfid']);
    $name = $conn->real_escape_string($_POST['name']);
    $birthday = $conn->real_escape_string($_POST['Birthday']);
    $address = $conn->real_escape_string($_POST['Address']);
    $role = $conn->real_escape_string($_POST['role']);
    $pin = $conn->real_escape_string($_POST['pin']);

    // SQL query to insert data into the database
    $sql = "INSERT INTO users (rfid, name, birthday, address, role, pin) 
            VALUES ('$rfid', '$name', '$birthday', '$address', '$role', '$pin')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('status' => 'success', 'message' => 'New record created successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error: ' . $conn->error));
    }
}

$conn->close();
?>
