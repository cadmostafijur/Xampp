<?php
session_start();

// check if admin username is not set in the session, redirect to login page
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}
// db connect
include 'config.php';
// check if form is submitted
if (isset($_POST['submit'])) {
    $image = $_FILES['image'];
    // file properties
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageType = $image['type'];
    // file extension
    $imageExt = explode('.', $imageName);
    $imageActualExt = strtolower(end($imageExt));
    // allowed file types
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    // check if file type is allowed
    if (in_array($imageActualExt, $allowed)) {
        if ($imageError === 0) {
            if ($imageSize < 5000000) { // 5MB limit
                $imageNameNew = uniqid('', true) . "." . $imageActualExt;
                $imageDestination = 'uploads/' . $imageNameNew;
                move_uploaded_file($imageTmpName, $imageDestination);
                // save image path to user's profile in the session
                $_SESSION['admin_profile_image'] = $imageDestination;
                // save image path to user's profile in the database
                $sql = "UPDATE admins SET profile_image = '$imageDestination' WHERE username = '{$_SESSION['admin_username']}'";
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='message'>Profile image uploaded successfully!</div>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Your file is too large!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}

// retrieve profile image path from the database
$sql = "SELECT profile_image FROM admins WHERE username = '{$_SESSION['admin_username']}'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['admin_profile_image'] = $row['profile_image'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .sidebar {
            flex: 1;
            padding: 10px;
        }

        .content {
            flex: 3;
            padding: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        li {
            display: inline-block;
            margin: 0 15px;
        }

        a {
            text-decoration: none;
            color: #555;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #333;
        }

        .logout-btn {
            display: block;
            width: 100px;
            margin: 50px auto 0;
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #0056b3;
        }

        #profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .profile-box img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .profile-box label {
            display: block;
            margin-bottom: 5px;
        }

        .profile-box input[type="file"] {
            margin-bottom: 10px;
        }

        .profile-box button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-box button:hover {
            background-color: #0056b3;
        }

        .message {
            background-color: #ddedd3;
            color: green;
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile-box">
                <img src="<?php echo isset($_SESSION['admin_profile_image']) ? $_SESSION['admin_profile_image'] : 'default.jpg'; ?>" alt="Profile Image">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <label for="image">Change Profile Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" required><br>
                    <button type="submit" name="submit">Upload</button>
                </form>
            </div>
        </div>
        <div class="content">
            <h2>Welcome <?php echo isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : ''; ?></h2>
            <ul>
                <li><a href="add_admin.php"><i class="fas fa-user-plus"></i> Add Admin</a></li> <br><br>
                <li><a href="customer_details.php"><i class="fas fa-users"></i> Customer Details</a></li><br><br>
                <li><a href="reject_ticket.php"><i class="fas fa-times-circle"></i> Reject Ticket</a></li><br><br>
                <li><a href="export_to_excel.php"><i class="fas fa-file-excel"></i> Export to Excel</a></li><br><br>
                <li><a href="add_bus_schedule.php"><i class="fas fa-business-time"></i> Add Bus Schedule (To BRACU)</a></li><br><br>
                <li><a href="add_bus_schedule2.php"><i class="fas fa-business-time"></i> Add Bus Schedule (From BRACU)</a></li><br><br>
                <li><a href="show_bus_schedule.php"><i class="fas fa-bus"></i> Show Bus Schedule</a></li><br><br>
                <li><a href="user_feedback.php"><i class="fas fa-comment"></i> User Feedback</a></li><br><br>
            </ul>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <!-- JavaScript code to hide the message after 2 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var messageElement = document.querySelector('.message');
            if (messageElement) {
                //message after 2 seconds
                setTimeout(function() {
                    messageElement.style.display = 'none';
                }, 2000); // 2000 ms = 2 seconds
            }
        });
    </script>
</body>
</html>
