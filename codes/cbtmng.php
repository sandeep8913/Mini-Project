<?php
$servername = "localhost";
$username = "root";
$password = "";
session_start();

$dbname = 'cbt'.$_SESSION['cbta'];  // getting database name from the form
$branch = $_SESSION['cbtb'];  // getting table name from the form
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $roll = $_POST['roll'];
        $sql = "DELETE FROM $branch WHERE roll='$roll'";
        $conn->query($sql);
    } elseif (isset($_POST['edit'])) {
        $roll = $_POST['roll'];
        $updates = [];
        foreach ($_POST as $key => $value) {
            if ($key !== 'edit' && $key !== 'roll') {
                $updates[] = "$key='$value'";
            }
        }
        $updateString = implode(", ", $updates);
        $sql = "UPDATE $branch SET $updateString WHERE roll='$roll'";
        $conn->query($sql);
    } elseif (isset($_POST['add'])) {
        $columns = [];
        $values = [];
        foreach ($_POST as $key => $value) {
            if ($key !== 'add') {
                $columns[] = $key;
                $values[] = "'" . ($value !== '' ? $value : 'no') . "'";
            }
        }
        $columnString = implode(", ", $columns);
        $valueString = implode(", ", $values);
        $sql = "INSERT INTO $branch ($columnString) VALUES ($valueString)";
        $conn->query($sql);
    } elseif (isset($_POST['flush'])) {
        $sql = "TRUNCATE TABLE $branch";
        $conn->query($sql);
    }
}

$sql = "DESCRIBE $branch";
$columnsResult = $conn->query($sql);
$columns = [];
while ($row = $columnsResult->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$sql = "SELECT * FROM $branch";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage CBT Table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        table {
            background-color: white;
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            white-space: nowrap;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .form-control {
            width: 100%;
            box-sizing: border-box;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
    <script>
        function setDefaultValues(form) {
            var inputs = form.querySelectorAll('input[type="text"]');
            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    input.value = 'no';
                }
            });
        }

        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }

        function confirmFlush() {
            return confirm("Are you sure you want to delete all records?");
        }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Manage CBT Table: <?php echo htmlspecialchars($dbname . " - " . $branch); ?></h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column) { ?>
                            <th><?php echo htmlspecialchars($column); ?></th>
                        <?php } ?>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
    <?php if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) { ?>
            <tr>
                <form method="post">
                    <?php foreach ($columns as $column) { ?>
                        <td><input type="text" name="<?php echo htmlspecialchars($column); ?>" value="<?php echo htmlspecialchars($row[$column]); ?>" class="form-control" <?php echo $column === 'roll' ? 'readonly' : ''; ?>></td>
                    <?php } ?>
                    <td class="action-buttons">
                        <button type="submit" name="edit" class="btn btn-warning btn-sm">Edit</button>
                        <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                    </td>
                </form>
            </tr>
        <?php }
    } ?>
    <tr>
        <form method="post" onsubmit="setDefaultValues(this)">
            <?php foreach ($columns as $column) { ?>
                <td><input type="text" name="<?php echo htmlspecialchars($column); ?>" class="form-control"></td>
            <?php } ?>
            <td class="action-buttons">
                <button type="submit" name="add" class="btn btn-success btn-sm">Add</button>
            </td>
        </form>
    </tr>
</tbody>

            </table>
        </div>
        <div class="button-container">
            <form method="post" onsubmit="return confirmFlush()">
                <button type="submit" name="flush" class="btn btn-danger">Flush All Records</button>
            </form>
            <a href="admin.html" class="btn btn-secondary">Back</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
