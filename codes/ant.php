<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "x";
$cy = date('Y');
$cys = substr((string)$cy, 2, 2);
$dy = (int)$cys - 4;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create an array of patterns to match IDs starting with less than or equal to $dy
$patterns = [];
for ($i = 0; $i < $dy; $i++) {
    $patterns[] = sprintf("%02d%%", $i);
}

// Additional pattern for the specific case where the 5th character is '5'
$special_patterns = [];
for ($i = 0; $i <= $dy; $i++) {
    $special_patterns[] = sprintf("%02d%%5%%", $i);
}

// Construct the DELETE query
$sql = "DELETE FROM std WHERE ";
$sql .= implode(" OR ", array_map(function($pattern) {
    return "roll LIKE '$pattern'";
}, $patterns));
$sql .= " OR ";
$sql .= implode(" OR ", array_map(function($pattern) {
    return "roll LIKE '$pattern'";
}, $special_patterns));

if ($conn->query($sql) === TRUE) {
    $rows_affected = $conn->affected_rows;
    echo "Successfully deleted $rows_affected rows where roll starts with less than or equal to '$dy' or has '5' as the 5th character and starts with less than or equal to '$dy'.";
} else {
    echo "Error deleting records: " . $conn->error;
}

$conn->close();
?>
