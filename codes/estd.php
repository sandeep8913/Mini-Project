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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $roll = $_POST['roll'];
        $pass = $_POST['pass'];
        $fee = $_POST['fee'];
        $lib = $_POST['lib'];
        $fine=$_POST['fine'];
        $sql = "INSERT INTO std (roll, pass, fee, lib,fine) VALUES ('$roll', '$pass', '$fee', '$lib','$fine')";
        $conn->query($sql);
    } elseif (isset($_POST['edit'])) {
        $roll = $_POST['roll'];
        $pass = $_POST['pass'];
        $fee = $_POST['fee'];
        $lib = $_POST['lib'];
        $fine=$_POST['fine'];
        $sql = "UPDATE std SET pass='$pass', fee='$fee', lib='$lib', fine='$fine' WHERE roll='$roll'";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        $roll = $_POST['roll'];
        $sql = "DELETE FROM std WHERE roll='$roll'";
        $conn->query($sql);
    }
}

// Retrieve table data
$sql = "SELECT * FROM std";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Table</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        .form-inline {
            display: inline-block;
        }
        .form-container {
            margin-top: 20px;
        }
        .back-button-container {
            margin-top:20px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <center><h2>Student Table</h2></center>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Roll</th>
                <th>Pass</th>
                <th>Fee</th>
                <th>Lib</th>
                <th>Fine</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['roll']; ?></td>
                <td><?php echo $row['pass']; ?></td>
                <td><?php echo $row['fee']; ?></td>
                <td><?php echo $row['lib']; ?></td>
                <td><?php echo $row['fine']; ?></td>
                <td>
                    <form class="form-inline" method="post" action="estd.php">
                        <input type="hidden" name="roll" value="<?php echo $row['roll']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <form class="form-inline" method="post" action="estd.php">
                        <input type="hidden" name="roll" value="<?php echo $row['roll']; ?>">
                        <input type="hidden" name="edit_form" value="1">
                        <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php
    if (isset($_POST['edit_form'])) {
        $roll = $_POST['roll'];
        $sql = "SELECT * FROM std WHERE roll='$roll'";
        $edit_result = $conn->query($sql);
        $edit_row = $edit_result->fetch_assoc();
    ?>
        <div class="form-container">
            <h2>Edit Student</h2>
            <form method="post" action="estd.php" class="form">
                <div class="form-group">
                    <label for="roll">Roll:</label>
                    <input type="text" id="roll" name="roll" value="<?php echo $edit_row['roll']; ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="pass">Pass:</label>
                    <input type="text" id="pass" name="pass" value="<?php echo $edit_row['pass']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fee">Fee:</label>
                    <input type="text" id="fee" name="fee" value="<?php echo $edit_row['fee']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lib">Lib:</label>
                    <input type="text" id="lib" name="lib" value="<?php echo $edit_row['lib']; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fine">Fine:</label>
                    <input type="text" id="fine" name="fine" value="<?php echo $edit_row['fine']; ?>" class="form-control" required>
                </div>
                <button type="submit" name="edit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    <?php
    } else {
    ?>
        <div class="form-container">
          <h2>Add New Student</h2>
            <form method="post" action="estd.php" class="form">
                <div class="form-group">
                    <label for="roll">Roll:</label>
                    <input type="text" id="roll" name="roll" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pass">Pass:</label>
                    <input type="text" id="pass" name="pass" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fee">Fee:</label>
                    <input type="text" id="fee" name="fee" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="lib">Lib:</label>
                    <input type="text" id="lib" name="lib" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fine">Fine:</label>
                    <input type="text" id="fine" name="fine" class="form-control" required>
                </div>
                <button type="submit" name="add" class="btn btn-success">Add</button>
            </form>
        </div>
    <?php
    }
    ?>
    <br>
<center><button class="btn btn-danger mt-4" id="clearDataBtn">Clear Old Data</button></center>
<div class="back-button-container text-center">
        <a href="admin.html" class="btn btn-secondary">Back</a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('clearDataBtn').addEventListener('click', function() {
        if (confirm('Are you sure you want to clear old data?')) {
            window.location.href = 'ant.php';
        }
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
