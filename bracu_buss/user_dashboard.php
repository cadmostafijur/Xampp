<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}
// Logout logic
if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']); // Unset the user_id session variable
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_bus_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "User data not found.";
}

// Handle profile picture upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_name = $_FILES['profile_picture']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_exts = array("jpg", "jpeg", "png", "gif");

    if (in_array($file_ext, $allowed_exts)) {
        $upload_dir = "uploads/";
        $new_file_name = uniqid('profile_') . '.' . $file_ext;
        $dest_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $dest_path)) {
            // Update profile picture path in the database
            $update_sql = "UPDATE users SET profile_picture = '$dest_path' WHERE user_id = $user_id";
            if ($conn->query($update_sql) === TRUE) {
                // Update user data with the new profile picture path
                $user_data['profile_picture'] = $dest_path;
            } else {
                echo "Error updating profile picture: " . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file format. Allowed formats: " . implode(", ", $allowed_exts);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <style>
        /* Cool UI theme CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff; /* White container background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #000000;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2; /* Light gray header background */
            text-align: left;
        }
        td {
            vertical-align: top;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%; /* Rounded shape */
            margin: 0 auto 20px; /* Center horizontally and add some bottom margin */
            display: block; /* Ensure it's centered */
            cursor: pointer; /* Add cursor pointer */
        }
        input[type="file"] {
            display: none; /* Hide the file input by default */
        }
    </style>
</head>
<body>
    <header class="navbar" style="background-color: #5bc0de; padding: 20px 0;">
        <div class="container">
            <div class="logo" style="color: #000000; font-size: 24px; font-weight: bold;">University Bus Ticket System</div>
            <div class="menu-toggle" style="display: none;">&#9776;</div>
            <ul class="nav-menu" style="list-style: none; display: flex;">
    <li><a href="index.php" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">Home</a></li>
    <li style="margin-left: 20px;"><a href="booking_c.php" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">Book Ticket</a></li>
    <li style="margin-left: 20px;"><a href="view_bookings.php" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">View Bookings</a></li>
    <!-- <li style="margin-left: 20px;"><a href="user_dashboard.php" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">Dashboard</a></li> -->
    <li style="margin-left: 20px;"><a href="profile.php" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">Profile</a></li>
    <li style="margin-left: 20px;"><a href="user_reviews.php" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">User Reviews</a></li>
    <li style="margin-left: 20px;"><a href="?logout" class="logout-link" style="color: #000000; text-decoration: none; font-size: 18px; transition: color 0.3s;">Logout</a></li>
</ul>

        </div>
    </header>

    <div class="container">
        <h1>User Dashboard</h1>
        <!-- Display profile picture -->
        <?php
        // Display profile picture if available
        $profile_picture = 'default_profile_picture.jpg'; // Change to default profile picture path
        if (isset($user_data['profile_picture']) && !empty($user_data['profile_picture'])) {
            $profile_picture = $user_data['profile_picture'];
        }
        ?>
        <!-- Profile picture placeholder with onclick event to trigger file input -->
        <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture" onclick="document.getElementById('profile-picture-input').click()">
        <!-- File input field to upload profile picture -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" id="profile-picture-input" name="profile_picture" accept="image/*" style="display: none;">
            <input type="submit" value="Upload Profile Picture" style="background-color: #5bc0de; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 10px;">
        </form>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <?php foreach ($user_data as $key => $value) : ?>
                <?php if ($key !== 'password' && $key !== 'profile_picture') : ?>
                    <tr>
                        <td><?php echo ucwords(str_replace('_', ' ', $key)); ?></td>
                        <td><?php echo $value; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
<!-- Herem i use the css  https://necolas.github.io/normalize.css/  also some raw csss -->