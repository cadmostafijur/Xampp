<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the user's name based on the user_id from the session
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['full_name'];
} else {
    $user_name = 'Unknown';
}

// Retrieve bus schedules from the database
$sql_schedules = "SELECT * FROM bus_schedules";
$result_schedules = $conn->query($sql_schedules);
$schedules = array();
if ($result_schedules->num_rows > 0) {
    while ($row = $result_schedules->fetch_assoc()) {
        $schedules[] = $row;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure_location = $_POST['departure_location'];
    $arrival_location = $_POST['arrival_location'];
    $journey_date = $_POST['journey_date']; // Added journey date
    
    $trip_type = $_POST['trip_type'];
    $price = ($trip_type == 'one_way') ? 90 : 180;

    // Find the schedule ID based on the selected departure and arrival locations
    $selected_schedule = array_filter($schedules, function($schedule) use ($departure_location, $arrival_location) {
        return $schedule['departure_location'] == $departure_location && $schedule['arrival_location'] == $arrival_location;
    });

    if (!empty($selected_schedule)) {
        $schedule_id = reset($selected_schedule)['schedule_id'];

        // Insert booking into database with the fetched schedule_id
        $sql_booking = "INSERT INTO bookings (user_id, schedule_id, departure_location, arrival_location,journey_date,price) VALUES ('$user_id', '$schedule_id', '$departure_location', '$arrival_location', '$journey_date', '$price')";
        
        if ($conn->query($sql_booking) === TRUE) {
            echo "Booking successful!";
            header("Location: view_bookings.php");
        } else {
            echo "Error: " . $sql_booking . "<br>" . $conn->error;
        }
    } else {
        echo "Error: No schedule found for the selected locations.";
    }
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        select, input[type="text"] {
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
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }
        /* CSS styles */
.custom-date-input {
    position: relative;
    width: 100%;
}

.custom-date-input input[type="date"] {
    /* adjust width for the icon */
    width: calc(100% - 30px); 
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
    /* include padding and border in width calculation */
    box-sizing: border-box; 
}

.custom-date-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
     /* replace with your icon */
    background-image: url('calendar-icon.png');
    background-size: cover;
    cursor: pointer;
}

    </style>
</head>
<body>
    <div class="container">
        <h2>Book Ticket</h2>
        <form action="book_ticket.php" method="post">
            <label for="user_name">User Name:</label><br>
            <input type="text" id="user_name" name="user_name" value="<?php echo $user_name; ?>" readonly><br>
            
            <label for="departure_location">Departure Location:</label><br>
            <select id="departure_location" name="departure_location" required>
                <?php foreach ($schedules as $schedule): ?>
                    <option value="<?php echo $schedule['departure_location']; ?>"><?php echo $schedule['departure_location']; ?></option>
                <?php endforeach; ?>
            </select><br>
            
            <label for="arrival_location">Arrival Location:</label><br>
            <input type="text" id="arrival_location" name="arrival_location" value="<?php echo ("BRAC University"); ?>" readonly><br>
            
            <!-- <label for="shift">Shift:</label><br>
            <select id="shift" name="shift">
                <option value="shift_1">Shift 1</option>
                <option value="shift_2">Shift 2</option>
            </select><br> -->
            <label for="journey_date">Journey Date:</label><br>
            <div class="custom-date-input">
                <input type="date" id="journey_date" name="journey_date" required>
                <span class="custom-date-icon"></span>
            </div>

            <label for="trip_type">Trip Type:</label><br>
            <select id="trip_type" name="trip_type">
                <option value="one_way">One Way ($90)</option>
                <option value="round_trip">Round Trip ($180)</option>
            </select><br>
            
            <button type="submit">Book Ticket</button>
        </form>
    </div>
</body>
</html>
