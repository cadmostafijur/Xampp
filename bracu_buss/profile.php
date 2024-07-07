<?php
session_start();

// Logout logic
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Check if user is logged in
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "university_bus_system"; // Your database name
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if profile is already updated
$profileUpdated = isset($_SESSION['profile_updated']);

// Check if the profile update form is submitted
if(isset($_POST['update'])) {
    // Check if the profile is not already updated
    if(!$profileUpdated) {
        // Prepare and execute the SQL SELECT statement to check if any profile fields are already filled
        $stmt_check = $conn->prepare("SELECT * FROM users WHERE username=? AND (student_id IS NOT NULL OR permanent_address IS NOT NULL OR present_address IS NOT NULL OR phone_number IS NOT NULL OR emergency_number IS NOT NULL OR blood_group IS NOT NULL)");
        $stmt_check->bind_param("s", $_SESSION['username']);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        // If any of the profile fields are already filled, mark profile as updated and redirect to profile page
        if($result_check->num_rows > 0) {
            $_SESSION['profile_updated'] = true;
            header("Location: profile.php");
            exit();
        }
        
        // Handle profile update logic here
        $studentId = $_POST['student_id'];
        $permanentAddress = $_POST['permanent_address'];
        $presentAddress = $_POST['present_address'];
        $phoneNumber = $_POST['phone_number'];
        $emergencyNumber = $_POST['emergency_number'];
        $bloodGroup = $_POST['blood_group'];
        
        // prepare and execute the SQL UPDATE statement
        $stmt = $conn->prepare("UPDATE users SET student_id=?, permanent_address=?, present_address=?, phone_number=?, emergency_number=?, blood_group=? WHERE username=?");
        $stmt->bind_param("sssssss", $studentId, $permanentAddress, $presentAddress, $phoneNumber, $emergencyNumber, $bloodGroup, $_SESSION['username']);
        $stmt->execute();
        
        // mark profile as updated
        $_SESSION['profile_updated'] = true;
        
        // redirect to profile page to prevent form resubmission
        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Bus Ticket System - Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #5bc0de; /* light blue color */
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .logo {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .menu-toggle {
            display: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            align-items: center;
        }

        .nav-menu li {
            margin-right: 20px;
        }

        .nav-menu li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s;
        }

        .nav-menu li a:hover {
            color: #ffcc00;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #5bc0de;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        button:hover {
            background-color: #4da9c9;
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="container">
            <div class="logo">University Bus Ticket System</div>
            <div class="menu-toggle">&#9776;</div>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="book_ticket.php">Book Ticket</a></li>
                <li><a href="view_bookings.php">View Bookings</a></li>
                <?php if(isset($_SESSION['username'])): ?>
                <li><a href="?logout" class="logout-link">Logout</a></li>
                <?php else: ?>
                <li><a href="admin_login.php">Admin</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <div class="container">
        <?php if($profileUpdated): ?>
        <h1>Your Profile is Already Updated</h1>
        <p>You can only update your profile once. If you need further assistance, please contact support.</p>
        <?php else: ?>
        <h1>Update Profile</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="student_id" placeholder="Student ID" required><br>
            <input type="text" name="permanent_address" placeholder="Permanent Address" required><br>
            <input type="text" name="present_address" placeholder="Present Address" required><br>
            <input type="text" name="phone_number" placeholder="Phone Number" required><br>
            <input type="text" name="emergency_number" placeholder="Emergency Number" required><br>
            <input type="text" name="blood_group" placeholder="Blood Group" required><br>
            <button type="submit" name="update">Update Profile</button>
        </form>
        <?php endif; ?>
    </div>

    <script>
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav-menu');

        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    </script>
</body>
</html>
