<?php
session_start();
header('Content-Type: application/json'); // Ensure the response is JSON

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => "Connection failed: " . $conn->connect_error]);
    exit();
}

$outgoing_id = mysqli_real_escape_string($conn, $_GET['outgoing_id'] ?? '');
$incoming_id = mysqli_real_escape_string($conn, $_GET['incoming_id'] ?? '');
$last_message_id = mysqli_real_escape_string($conn, $_GET['last_message_id'] ?? 0);

if (empty($outgoing_id) || empty($incoming_id)) {
    echo json_encode(['error' => "Invalid outgoing_id or incoming_id"]);
    exit();
}

$sql = "SELECT * FROM messages 
        WHERE ((outgoing_msg_id = $outgoing_id AND incoming_msg_id = $incoming_id) 
        OR (outgoing_msg_id = $incoming_id AND incoming_msg_id = $outgoing_id))
        AND msg_id > $last_message_id 
        ORDER BY msg_id ASC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo json_encode(['error' => "Query error: " . mysqli_error($conn)]);
    exit();
}

$messages = [];
while ($row = mysqli_fetch_assoc($query)) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
