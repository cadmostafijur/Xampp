<?php
include 'config.php';
session_start();
// Check if the user is already logged in, 
//redirect to index.php
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // query the database to check if the username and password match
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        // If the user exists
        //set session variables and redirect to homepage
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {

        // echo '<script type ="text/JavaScript">';  
        // $error = 'alert("Invalid username or password.")';
        // echo '</script>'; thiss alert not working here i try to use  sweet alert but facing somne issue
        // thing its not a better option
        echo '<script>alert("Invalid username or password.")</script>'; 
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            /* Light blue color */
            background-color: #5bc0de; 
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            color: #0d0d0c;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-menu li {
            margin-right: 20px;
        }

        .nav-menu li:last-child {
            margin-right: 0;
        }

        .nav-menu li a {
            color: #0d0d0c;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .nav-menu li a:hover {
            color: #ffcc00;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            /* background-color: #fff; */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5bc0de; /* Light blue color */
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #31b0d5; /* Darker shade of blue */
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<header class="navbar">
    <div class="container">
        <a href="#" class="logo">University Bus Ticket System</a>
        <ul class="nav-menu">
            <li><a href="index.php">Home</a></li>
            <!-- <li><a href="user_dashboard.php">Dashboard</a></li> -->
            <li><a href="book_ticket.php">Book Ticket</a></li>
            <li><a href="view_bookings.php">View Bookings</a></li>
            <li><a href="admin_login.php">Admin</a></li>
        </ul>
    </div>
</header>
<div class="container">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
        <a href="forget.php" class="forgot-password-link">Forgot Password?</a>
    </form>
    </form>
    <?php if(isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    <p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
