<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Your CSS styles */
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .login-container {
            width: 300px;
            margin: 1px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .password-toggle {
            position: absolute;
            right: 5px;
            top: 65%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .error-container {
            width: 300px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Your navigation bar -->
    <ul id="navbar">
        <li><a href="index.html">Home</a></li>
        <li><a href="contactinfo.html">Kontaktinformācija</a></li>
        <li><a href="ParVietni.html">Par vietni</a></li>
        <li><a href="Map.html">Laukumu karte</a></li>
        <li><a href="login.php">Rediģet</a></li>
    </ul>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost"; // or your database host
        $username = "root"; // your database username
        $password = "Bobrkurwa1488+"; // your database password
        $database = "noslegumadarbs"; // your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        //Check if the username and password match
        $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Username and password match, redirect to data.php
            header("Location: data.php");
            exit();
        } else {
            // Username and password do not match, display error
            echo "<div class='error-container'>";
            echo "<h2>Error</h2>";
            echo "<p>User not found</p>";
            echo "<a href='login.php'>Back to login</a>";
            echo "</div>";
        }

        $conn->close();
    }
    ?>

    <div class="login-container">
        <h2>Login</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                <span class="password-toggle" onclick="togglePassword()">👁️</span>
            </div>

            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>

    <!-- Your JavaScript code -->
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

</body>
</html>
