<?php
$un = $_POST["roll"];
$p = $_POST["pass"];
$con = mysqli_connect("localhost", "root", "", "x");
session_start();
$_SESSION['roll'] = $un;
if (!$con) {
    header("Location: home.html");
    die("Can't connect to the database");
}
$r = $un;
$q = "SELECT * FROM std WHERE roll='$un' AND pass='$p'";
$row = mysqli_query($con, $q);

if (mysqli_num_rows($row) >= 1) {
    $s = substr($r, 0, 2);
    $cy = date('Y');
    $cys = substr((string)$cy, 2, 2);
    $yr = (int)$cys - (int)$s;
    $s = substr($r, 4, 1);
    if ($s == '5') {
        $yr += 1;
    }
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = new mysqli($servername, $username, $password, 'x');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT sem FROM slct WHERE year=$yr";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $dbname = $row['sem'];
    $db = $row['sem'];
    $dbname = 'cbt' . $dbname;

    $s = substr($r, 7, 1);
    $y = "cse";
    if ($s == '4') {
        $y = "ece";
    }
    $_SESSION['odb'] = $db;
    $_SESSION['db'] = $dbname;
    $_SESSION['table'] = $y;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM $y WHERE roll='$un'";
    $con = new mysqli($servername, $username, $password, $db);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $result = mysqli_query($conn, $sql);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>CBT Log</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                width: 100%;
                text-align: center;
            }
            h2 {
                color: #333;
                margin-bottom: 20px;
            }
            form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .checkbox-group {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin: 10px 0;
                width: 100%;
            }
            .checkbox-group label {
                display: flex;
                align-items: center;
                margin: 5px 0;
            }
            .checkbox-group input[type='checkbox'] {
                margin-right: 10px;
            }
            input[type='submit'], a {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                cursor: pointer;
                margin: 10px 0;
            }
            input[type='submit']:hover, a:hover {
                background-color: #0056b3;
            }
            .selected-subjects {
                margin: 10px 0;
                font-style: italic;
                color: #555;
            }
        </style>
    </head>
    <body>
        <div class='container'>";

    if (mysqli_num_rows($result) == 0) {
        echo "<h2>You haven't applied for anything yet!</h2>";
        $ql = "SELECT * FROM $y";
        $res = mysqli_query($con, $ql);
        echo "<form action='payl.php' method='post'><div class='checkbox-group'>";
        while ($row = $res->fetch_assoc()) {
            $subject = $row['subject'];
            if ($subject != 'id') {
                echo "<label><input type='checkbox' name='subjects[]' value='$subject'>$subject</label>";
            }
        }
        echo "</div><input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        $t=1;
        $ql = "SELECT * FROM $y";
        $res = mysqli_query($con, $ql);
        $selctd = "";
        $p=0;
        echo "<form action='payl.php' method='post'><div class='checkbox-group'>";
        while ($row = $res->fetch_assoc()) {
            $subject = $row['subject'];
            $sql = "SELECT * FROM $y WHERE roll='$un'";
            $re = mysqli_query($conn, $sql);
            $rest = $re->fetch_assoc();
            if ($rest[$subject] == 'no' || $rest[$subject]==NULL) {
                if($t==1){
                    echo "<h4>Select subjects to apply CBT:</h4>";
                    $t=0;
                }
                echo "<label><input type='checkbox' name='subjects[]' value='$subject'>$subject</label>";
                $p=1;
            } else {
                if ($selctd == "") {
                    $selctd = $selctd . $subject;
                } else {
                    $selctd = $selctd . ", " . $subject;
                }
            }
        }
        echo "</div>";
        if ($selctd != "") {
            echo "<div class='selected-subjects'><h4>Already applied for:</h4> $selctd</div>";
        }
        if($p==1){
        echo "<input type='submit' value='Submit'>";
        }
        echo "<a href='cbthtd.php'>Download Hall Ticket</a>";
        echo "</form>";
    }

    echo "</div>
    </body>
    </html>";

} else {
    header("Location: cbtstd.php?error=1");
}
mysqli_close($conn);
mysqli_close($con);
?>
