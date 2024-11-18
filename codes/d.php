<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "y";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add/edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if ($id) {
        $stmt = $conn->prepare("UPDATE x SET subject=?, date=?, time=? WHERE id=?");
        $stmt->bind_param("sssi", $subject, $date, $time, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO x (subject, date, time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $subject, $date, $time);
    }

    $stmt->execute();
    $stmt->close();
    header('Location: index.php');
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM x WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header('Location: index.php');
    exit();
}

// Fetch all rows
$result = $conn->query("SELECT * FROM x");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Management</title>
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
        header a {
            color: #ffffff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            display: inline;
            padding: 0 20px 0 20px;
        }
        header #branding {
            float: left;
        }
        header #branding h1 {
            margin: 0;
        }
        header nav {
            float: right;
            margin-top: 10px;
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
            background: #e8491d;
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
    </style>
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
            <th>ID</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['subject']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td class="actions">
                    <a href="index.php?edit=<?php echo $row['id']; ?>">Edit</a>
                    <a href="index.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // Fetch data for editing
    $edit_id = '';
    $edit_subject = '';
    $edit_date = '';
    $edit_time = '';

    if (isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM x WHERE id=?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $edit_subject = $row['subject'];
        $edit_date = $row['date'];
        $edit_time = $row['time'];
        $stmt->close();
    }
    ?>

    <div class="form-container">
        <h2><?php echo $edit_id ? 'Edit' : 'Add'; ?> Data</h2>
        <form method="post" action="index.php">
            <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" value="<?php echo $edit_subject; ?>" required><br>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" value="<?php echo $edit_date; ?>" required><br>
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" value="<?php echo $edit_time; ?>" required><br>
            <button type="submit"><?php echo $edit_id ? 'Update' : 'Add'; ?></button>
        </form>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
