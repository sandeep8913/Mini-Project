<?php
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$table="oe";
$conn = new mysqli($servername, $username, $password, "electives");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to set default value if input is empty
function setDefaultValue($value) {
    return empty($value) ? '-' : $value;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll = $_POST['roll'];
    $pe1 = setDefaultValue($_POST['pe1']);
    $pe2 = setDefaultValue($_POST['pe2']);
    $pe3 = setDefaultValue($_POST['pe3']);
    $existing_roll = isset($_POST['existing_roll']) ? $_POST['existing_roll'] : '';

    if ($existing_roll) {
        $stmt = $conn->prepare("UPDATE $table SET roll=?, oe1=?, oe2=?, oe3=? WHERE roll=?");
        $stmt->bind_param("sssss", $roll, $pe1, $pe2, $pe3, $existing_roll);
    } else {
        $stmt = $conn->prepare("INSERT INTO $table (roll, oe1, oe2, oe3) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $roll, $pe1, $pe2, $pe3);
    }

    $stmt->execute();
    $stmt->close();
    header('Location: oeedit.php');
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $roll = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM $table WHERE roll=?");
    $stmt->bind_param("s", $roll);
    $stmt->execute();
    $stmt->close();
    header('Location: oeedit.php');
    exit();
}

// Fetch all rows
$result = $conn->query("SELECT * FROM $table");
?>

<!DOCTYPE html>
<html>
<head>
    <title>OE Table Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #50b3a2;
            color: #ffffff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #e8491d 3px solid;
        }
        header h1 {
            margin: 0;
        }
        .form-container {
            background: #ffffff;
            padding: 30px;
            margin: 30px 0;
            border: #cccccc 1px solid;
            box-shadow: 0px 0px 10px #cccccc;
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="time"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .form-container button {
            background: #50b3a2;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #396d65;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #cccccc;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #50b3a2;
            color: white;
        }
        table tr:nth-child(even) {
            background: #f2f2f2;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #50b3a2;
        }
        .actions a:hover {
            color: #e8491d;
        }
        .back-button-container {
            margin-bottom: 30px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

<header>
    <div class="container">
        <h1>OE Table Management</h1>
    </div>
</header>

<div class="container">
    <table>
        <tr>
            <th>Roll</th>
            <th>OE1</th>
            <th>OE2</th>
            <th>OE3</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['roll']; ?></td>
                <td><?php echo $row['oe1']; ?></td>
                <td><?php echo $row['oe2']; ?></td>
                <td><?php echo $row['oe3']; ?></td>
                <td class="actions">
                    <a href="oeedit.php?edit=<?php echo $row['roll']; ?>">Edit</a>
                    <a href="oeedit.php?delete=<?php echo $row['roll']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // Fetch data for editing
    $edit_roll = '';
    $edit_pe1 = '';
    $edit_pe2 = '';
    $edit_pe3 = '';

    if (isset($_GET['edit'])) {
        $edit_roll = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM $table WHERE roll=?");
        $stmt->bind_param("s", $edit_roll);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $edit_roll = $row['roll'];
        $edit_pe1 = $row['oe1'];
        $edit_pe2 = $row['oe2'];
        $edit_pe3 = $row['oe3'];
        $stmt->close();
    }
    ?>

    <div class="form-container">
        <h2><?php echo $edit_roll ? 'Edit' : 'Add'; ?> Entry</h2>
        <form method="post" action="oeedit.php">
            <input type="hidden" name="existing_roll" value="<?php echo $edit_roll; ?>">
            <label for="roll">Roll:</label>
            <input type="text" name="roll" id="roll" value="<?php echo $edit_roll; ?>" required><br>
            <label for="pe1">OE1:</label>
            <input type="text" name="pe1" id="pe1" value="<?php echo $edit_pe1; ?>"><br>
            <label for="pe2">OE2:</label>
            <input type="text" name="pe2" id="pe2" value="<?php echo $edit_pe2; ?>"><br>
            <label for="pe3">OE3:</label>
            <input type="text" name="pe3" id="pe3" value="<?php echo $edit_pe3; ?>"><br>
            <button type="submit"><?php echo $edit_roll ? 'Update' : 'Add'; ?></button>
        </form>
    </div>
</div>
<div class="back-button-container text-center">
        <a href="mnge.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
