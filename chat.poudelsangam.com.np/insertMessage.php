<?php
session_start();
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$message = mysqli_real_escape_string($conn, $_POST['message']);

$sql = "INSERT INTO messages (outgoing_msg_id, incoming_msg_id, msg) VALUES ('$outgoing_id', '$incoming_id', '$message')";
if (mysqli_query($conn, $sql)) {
    echo "Message sent";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$conn->close();
?>
