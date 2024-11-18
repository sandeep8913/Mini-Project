<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container">
        <div class="center">
            <h1>Login</h1>
            <form method="post" action="cbtlog.php">
                <div class="txt_field">
                    <input type="text" name="roll" required>
                    <span></span>
                    <label>Roll Number</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="pass" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <input name="submit" type="Submit" value="submit">
                <br>
                &nbsp;
            </form>
            <?php
            // Check if error parameter is set and display warning message
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo "<p style='color: red;text-align:center'>Wrong credentials. Please try again.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
