<?php
session_start();
include 'config.php';
var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['token']) && isset($_POST['password'])) {
        $token = $_POST['token'];
        $new_password = $_POST['password'];
        // check  token user
        $sql = "SELECT * FROM users WHERE reset_token='$token'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            //  token  valid, update 
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            // Update password
            $update_sql = "UPDATE users SET password='$new_password', reset_token=NULL WHERE user_id=$user_id";
            if ($conn->query($update_sql) === TRUE) {
                // password updated successfully
                header("Location: login.php");
                exit();
            } else {
                // error updating password
                echo "Error: " . $conn->error;
            }
        } else {
            // Invalid token
            echo "Invalid token";
        }
    } else {
        // handle missing form fields
        echo "Token or password is missing.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 5px;
            background-color: #f5f5f5;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #5bc0de;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #31b0d5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="token">Enter Token:</label>
            <input type="text" id="token" name="token" required>
            <label for="password">Enter New Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
