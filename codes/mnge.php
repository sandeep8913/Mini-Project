<!DOCTYPE html>
<html>
<head>
    <title>Managing Electives</title>
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
            padding: 20px 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        .button-container {
            text-align: center;
            diplay:flex;
            margin: 100px 0;
                }
        .button-container button {
            background: #50b3a2;
            color: white;
            border: none;
            padding: 20px 40px;
            font-size: 20px;
            margin: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .button-container button:hover {
            background: #396d65;
        }
        .pe-buttons {
            diplay:flex;
            flex-direction:column;
        }
        .oe-buttons {
            diplay:flex;
            flex-direction:column;
        }
        footer {
            background: #333;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .back-button-container {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <h1>Managing Electives</h1>
    </div>
</header>
<?php
session_start();
?>
<div class="container">
    <div class="button-container">
        <div class="pe-buttons">
            <button onclick="location.href='pemap.php'">Manage PE Mapping</button>
            <button onclick="location.href='peedit.php'">Manage Students PE Selection</button>
        </div>
        <div class="oe-buttons">
            <button onclick="location.href='oemap.php'">Manage OE Mapping</button>
            <button onclick="location.href='oeedit.php'">Manage Students OE Selection</button>
        </div>
    </div>
</div>
<div class="back-button-container text-center">
        <a href="admin.html" class="btn btn-secondary">Back</a>
    </div>


<footer>
    <div class="container">
        <p>GCET</p>
    </div>
</footer>

</body>
</html>
