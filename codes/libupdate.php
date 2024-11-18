<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "x";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$roll = $_POST['roll'];
$lib = $_POST['lib'];
$fine = $_POST['fine'];

$sql = "UPDATE std SET lib='$lib', fine='$fine' WHERE roll='$roll'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>
