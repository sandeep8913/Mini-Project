<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "x";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$roll = $_GET['roll'];
$sql = "SELECT roll, fee, fine FROM std WHERE roll='$roll'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        'success' => true,
        'roll' => $row['roll'],
        'fee' => $row['fee'],
        'fine' => $row['fine']
    ]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
?>
