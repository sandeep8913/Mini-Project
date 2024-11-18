<?php
session_start();
$a = $_SESSION['roll'];
$b = $_SESSION['lib'];
$c = $_SESSION['fine'];
$con = mysqli_connect("localhost", "root", "", "x");
if (!$con) {
    header("Location: home.html");
    die("Can't connect to the database");
}
$q = "UPDATE std SET fee=0 WHERE roll='$a'";
mysqli_query($con, $q);
$q = "UPDATE std SET fine=0 WHERE roll='$a'";
mysqli_query($con, $q);

if ($b > 0) {
    $message = "Please return the $b books to the library to download your hall ticket.";
} else {
    ob_start();
    include "hd.php";
    $hdContent = ob_get_clean();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
            color: #666;
        }
        a {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($message)) : ?>
            <h1>Payment Success</h1>
            <p><?php echo $message; ?></p>
        <?php else : ?>

            <?php header("Location:hd.php"); ?>
        <?php endif; ?>
    </div>
</body>
</html>
