<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "y"; // Default database name

// Check if GET parameters are set
if (isset($_GET['x']) && isset($_GET['y'])) {
    $dbname = $_GET['a']; // Database name
    $tablename = $_GET['b']; // Table name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch all rows
    $result = $conn->query("SELECT * FROM $tablename");
    if (!$result) {
        die("Error: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Management</title>
    <!-- Your CSS styles here -->
</head>
<body>

<header>
    <div class="container">
        <div id="branding">
            <h1>Data Management</h1>
        </div>
    </div>
</header>

<div class="container">
    <table>
        <tr>
            <th>Subject</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php if (isset($result)): // Check if $result is set ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td class="actions">
                        <a href="yst.php?delete=<?php echo $row['subject']; ?>&x=<?php echo $dbname; ?>&y=<?php echo $tablename; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No data available</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Your form here -->
</div>

</body>
</html>

<?php
if (isset($conn)) {
    $conn->close();
}
?>
