<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Payment</title>
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
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #333;
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
        .alert {
            background-color: #ffdddd;
            color: #d8000c;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info {
            background-color: #d9edf7;
            color: #31708f;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();
        $a = $_SESSION['fee'];
        $b = $_SESSION['lib'];
        $c = $_SESSION['roll'];
        $d = $_SESSION['fine'];
        echo "<h1>Hello, " . $c . "</h1>";
        if ($a > 0 || $d > 0) {
            echo "<div class='alert'><p>You have a due of " . ($a + $d) . " Rs (including both fee and library fine).</p>";
            echo "<a href='pay.php'>Click here to pay the due</a></div>";
        }
        if ($b > 0) {
            echo "<div class='info'><p>Please return the " . $b . " books to the library to download your hall ticket.</p></div>";
        }
        ?>
    </div>
</body>
</html>
