<?php
$servername = "localhost";
$username = "root";
$password = "";
$electivesdb = 'electives';
$table="pes";
// Create connection
$conn = new mysqli($servername, $username, $password, $electivesdb);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $subject = $_POST['subject'];
    $existing_id = isset($_POST['existing_id']) ? $_POST['existing_id'] : '';

    if ($existing_id) {
        $stmt = $conn->prepare("UPDATE $table SET id=?, subject=? WHERE id=?");
        $stmt->bind_param("isi", $id, $subject, $existing_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO $table (id, subject) VALUES (?, ?)");
        $stmt->bind_param("is", $id, $subject);
    }

    $stmt->execute();
    $stmt->close();
    header('Location: pemap.php');
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM $table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: pemap.php');
    exit();
}

// Fetch all rows
$result = $conn->query("SELECT * FROM $table");
?>

<!DOCTYPE html>
<html>
<head>
    <title>PE Map Management</title>
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
        .form-container input[type="number"] {
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
</head>
<body>

<header>
    <div class="container">
        <h1>PE Map Management</h1>
    </div>
</header>

<div class="container">
    <table>
        <tr>
            <th>ID</th>
            <th>Subject</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['subject']; ?></td>
                <td class="actions">
                    <a href="pemap.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    <a href="pemap.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // Fetch data for editing
    $edit_id = '';
    $edit_subject = '';

    if (isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM $table WHERE id=?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $edit_id = $row['id'];
        $edit_subject = $row['subject'];
        $stmt->close();
    }
    ?>

    <div class="form-container">
        <h2><?php echo $edit_id ? 'Edit' : 'Add'; ?> Subject</h2>
        <form method="post" action="pemap.php">
            <input type="hidden" name="existing_id" value="<?php echo $edit_id; ?>">
            <label for="id">ID:</label>
            <input type="number" name="id" id="id" value="<?php echo $edit_id; ?>" required><br>
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" value="<?php echo $edit_subject; ?>" required><br>
            <button type="submit"><?php echo $edit_id ? 'Update' : 'Add'; ?></button>
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
