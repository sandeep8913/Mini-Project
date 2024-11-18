<?php
session_start();
$un = $_POST["roll"];
$p = $_POST["pass"];
$_SESSION['roll'] = $un;

// Connect to the database
$con = new mysqli("localhost", "root", "", "x");
if ($con->connect_error) {
    header("Location: home.html");
    die("Can't connect to the database: " . $con->connect_error);
}

// Authenticate user
$q = "SELECT * FROM std WHERE roll='$un' AND pass='$p'";
$row = mysqli_query($con, $q);
if (mysqli_num_rows($row) >= 1) {
    // Determine year and semester
    $s = substr($un, 0, 2);
    $cy = date('Y');
    $cys = substr((string)$cy, 2, 2);
    $yr = (int)$cys - (int)$s;
    $s = substr($un, 4, 1);
    if ($s == '5') {
        $yr += 1;
    }

    // Retrieve semester from `slct` table
    $sql = "SELECT sem FROM slct WHERE year=$yr";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $sem = $row['sem'];

    // Determine table names
    $dbname = 'cbt' . $sem;
    $course = (substr($un, 7, 1) == '4') ? 'ece' : 'cse';

    // Connect to the correct cbt database
    $conn = new mysqli("localhost", "root", "", $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the roll number is in the cbt table
    $sql = "SELECT * FROM $course WHERE roll='$un'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Roll number not present, display all subjects as options
        $subjects_db = '1-' . substr($sem, 2); // Database name format adjustment
        $subject_conn = new mysqli("localhost", "root", "", 'x');
        $sql_subjects = "SELECT * FROM cse"; // Adjust if ece is needed
        $result_subjects = $subject_conn->query($sql_subjects);

        echo "<form action='pay.php' method='post'>";
        while ($row = $result_subjects->fetch_assoc()) {
            foreach ($row as $subject => $value) {
                if ($subject != 'id') {
                    echo "<input type='checkbox' name='subjects[]' value='$subject'>$subject<br>";
                }
            }
        }
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        // Roll number present, show selected subjects and options for unselected
        $row = $result->fetch_assoc();
        echo "<form action='pay.php' method='post'>";
        foreach ($row as $subject => $value) {
            if ($subject != 'roll') {
                if ($value == 'yes') {
                    echo "$subject (already selected)<br>";
                } else {
                    echo "<input type='checkbox' name='subjects[]' value='$subject'>$subject<br>";
                }
            }
        }
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    }
} else {
    header("Location: cbtstd.php?error=1");
}

$con->close();
$conn->close();
?>

