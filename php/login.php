<?php

$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "senti-shield"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);


        $sql = "SELECT * FROM account WHERE Username='$username' AND Password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {

            $row = $result->fetch_assoc();
            $role = $row['Role'];

            switch ($role) {
                case 'moderator':
                    header("Location: ../admin/index.html");
                    break;
                case 'admin':
                    header("Location: ../dashboard.html");
                    break;
                default:
                    echo "Unknown role.";
                    break;
            }
            exit;
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Username or password not provided.";
    }
}
$conn->close();

