<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];

    // Debugging: Output the received RFID tag
    echo "Received RFID: $rfid\n";

    // Establish a connection to the database
    $conn = new mysqli('localhost', 'root', '', 'senti-shield');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Clean the RFID input to prevent SQL injection
    $rfid = mysqli_real_escape_string($conn, trim($rfid));

    // Debugging: Output the cleaned RFID tag
    echo "Cleaned RFID: $rfid\n";

    // Prepare and execute the SQL statement to fetch the name and role associated with the RFID tag
    $sql = $conn->prepare("SELECT name, role FROM users WHERE rfid = ?");
    $sql->bind_param("s", $rfid);
    $sql->execute();
    $result = $sql->get_result();

    // Initialize default values
    $name = "Unknown";
    $role = "Unknown";

    // Check if the query returned any results
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $role = $row['role'];

        // Debugging: Output the found name and role
        echo "Found user: $name with role: $role\n";
    } else {
        // Debugging: Output if no user was found
        echo "No user found for RFID: $rfid\n";
    }

    // Insert log into access_logs table
    $logSql = $conn->prepare("INSERT INTO access_logs (rfid, name, role) VALUES (?, ?, ?)");
    $logSql->bind_param("sss", $rfid, $name, $role);
    if ($logSql->execute()) {
        echo "Log added successfully\n";
    } else {
        echo "Error: " . $logSql->error . "\n";
    }

    // Close the prepared statements and the connection
    $logSql->close();
    $sql->close();
    $conn->close();
} else {
    echo "Invalid request method";
}
?>