<?php
$servername = "localhost";
$username = "root";
$password = "";
session_start();
$dbname = $_SESSION['a'];
$x = $_SESSION['b'];
$cbtdb = 'cbt' . $dbname;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn1 = new mysqli($servername, $username, $password, $cbtdb);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($conn1->connect_error) {
    die("Connection failed: " . $conn1->connect_error);
}

// Handle add/edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $conn->real_escape_string($_POST['subject']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $id = $conn->real_escape_string($_POST['id']);
    
    $existing_id = isset($_POST['existing_id']) ? $conn->real_escape_string($_POST['existing_id']) : '';

    if ($existing_id) {
        $stmt = $conn->prepare("SELECT subject FROM $x WHERE id=?");
        $stmt->bind_param("s", $existing_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $os = $row['subject'];
        $stmt->close();

        $stmt = $conn->prepare("UPDATE $x SET id=?, subject=?, date=?, time=? WHERE id=?");
        $stmt->bind_param("sssss", $id, $subject, $date, $time, $existing_id);
        $stmt1 = $conn1->prepare("ALTER TABLE `$x` CHANGE COLUMN `$os` `$subject` VARCHAR(30) DEFAULT 'no'");
    } else {
        $stmt = $conn->prepare("INSERT INTO $x (id, subject, date, time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $id, $subject, $date, $time);
        $stmt1 = $conn1->prepare("ALTER TABLE `$x` ADD COLUMN `$subject` VARCHAR(30) DEFAULT 'no'");
    }

    $stmt->execute();
    $stmt->close();
    $stmt1->execute();
    $stmt1->close();
    header('Location: index.php');
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $stmt = $conn->prepare("SELECT subject FROM $x WHERE id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $subject = $row['subject'];
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM $x WHERE id=?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();

    $stmt1 = $conn1->prepare("ALTER TABLE `$x` DROP COLUMN `$subject`");
    $stmt1->execute();
    $stmt1->close();
    header('Location: index.php');
    exit();
}

// Fetch all rows
$result = $conn->query("SELECT * FROM $x");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Management</title>
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
            margin-bottom: 30px; /* Ensure spacing before footer */
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
        $edit_id = $conn->real_escape_string($_GET['edit']);
        $stmt = $conn->prepare("SELECT * FROM $x WHERE id=?");
        $stmt->bind_param("s", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $edit_id = $row['id'];
        $edit_subject = $row['subject'];
        $edit_date = $row['date'];
        $edit_time = $row['time'];
        $stmt->close();
    }
    ?>

    <div class="form-container">
        <h2><?php echo $edit_id ? 'Edit' : 'Add'; ?> Data</h2>
        <form method="post" action="index.php">
            <input type="hidden" name="existing_id" value="<?php echo $edit_id; ?>">
            <label for="id">ID:</label>
            <input type="text" name="id" id="id" value="<?php echo $edit_id; ?>" required><br>
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" value="<?php echo $edit_subject; ?>" required><br>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" value="<?php echo $edit_date; ?>" required><br>
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" value="<?php echo $edit_time; ?>" required><br>
            <button type="submit"><?php echo $edit_id ? 'Update' : 'Add'; ?></button>
        </form>
    </div>
    <div class="back-button-container text-center">
        <a href="admin.html" class="btn btn-secondary">Back</a>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
$conn1->close();
?>
