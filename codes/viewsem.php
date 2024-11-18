<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "x";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the slct table
$sql = "SELECT year,sem FROM slct";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Selected Semesters</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
        }
        table th {
            background-color: #50b3a2;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button-container {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Year and Semester Data</h1>
    <table>
        <tr>
            <th>Year</th>
            <th>Semester</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["year"]. "</td><td>" . $row["sem"]. "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No data found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>
<div class="back-button-container text-center">
        <a href="admin.html" class="btn btn-secondary">Back</a>
    </div>

</body>
</html>