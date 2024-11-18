<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f2f5;
}

.login-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.login-form h2 {
    margin-bottom: 20px;
    font-size: 24px;
    text-align: center;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.signup-link {
    margin-top: 20px;
    text-align: center;
}

.signup-link a {
    color: #007bff;
    text-decoration: none;
}

.signup-link a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="feelog.php" method="post">
            <h2>Login</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        &nbsp;
        <?php
        // Check if error parameter is set and display warning message
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p style='color: red;text-align:center'>Wrong credentials. Please try again.</p>";
        }
        ?>
    </div>
</body>
</html>
