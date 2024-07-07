<?php
include 'config.php';
session_start();

// generate a unique booking PNR number
function generateBookingPNR() {
    // generates a random string of 6 characters
    $randomString = bin2hex(random_bytes(8)); 
    // converts the string to uppercase
    return strtoupper($randomString); 
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// check if the booking_id is provided in the URL
if (!isset($_GET['booking_id'])) {
    // redirect back to view_bookings.php if booking_id is not provided
    header("Location: view_bookings.php");
    exit();
}

// get the booking ID from the URL
$booking_id = $_GET['booking_id'];

// fetch booking details from the database
$sql = "SELECT * FROM bookings WHERE booking_id = '$booking_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc(); // fetch booking details
    $departure_location = $booking['departure_location'];
    $arrival_location = $booking['arrival_location'];
    $departure_time = $booking['departure_time'];
    $price = $booking['price'];

    // fetch user details for the booking
    $user_id = $booking['user_id'];
    $sql_user = "SELECT full_name, phone_number FROM users WHERE user_id='$user_id'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
        $user_details = $result_user->fetch_assoc();
        $full_name = $user_details['full_name'];
        $phone_number = $user_details['phone_number'];
    } else {
        // set default values if user details not found
        $full_name = 'Unknown';
        $phone_number = 'Unknown';
    }
} else {
    // redirect back to view_bookings.php if booking not found
    header("Location: view_bookings.php");
    exit();
}
// if payment form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];

    // generate booking PNR
    $booking_pnr = generateBookingPNR();

    // insert booking PNR 
    $sql_update = "UPDATE bookings SET booking_pnr = '$booking_pnr', status='approved' WHERE booking_id = '$booking_id'";
    if ($conn->query($sql_update) === TRUE) {
        // insert transaction 
        $sql = "INSERT INTO transactions (booking_id, amount) VALUES ('$booking_id', '$amount')";

        if ($conn->query($sql) === TRUE) {
            // payment successful
            echo '<div id="success-message" class="success-message">Payment successful!</div>';
            // if the arrival location is "BRAC University" to
            // determine which table to update
            if ($departure_location == 'BRAC University') {
                $sql_update_seats = "UPDATE bus_schedules SET available_seats = available_seats - 1 WHERE schedule_id = (SELECT schedule_id FROM bookings WHERE booking_id = '$booking_id')";
            } elseif($arrival_location == 'BRAC University') {
                $sql_update_seats = "UPDATE bus_schedules_2 SET available_seats = available_seats - 1 WHERE schedule_id_2 = (SELECT schedule_id_2 FROM bookings WHERE booking_id = '$booking_id')";
            }
            if ($conn->query($sql_update_seats) === TRUE) {
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "print_ticket.php?booking_id=' . $booking_id . '";
                        }, 2000);
                      </script>';
                exit();
            } else {
                echo "Error updating available seats: " . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff; /* White container background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
        }

        /* Form styles */
        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="number"],
        button {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        button {
            background-color: #007bff; /* Blue */
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* Success message styles */
        .success-message {
            display: none;
            background-color: #d4edda; /* Green */
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Payment for Booking</h1>
    </header>

    <div class="container">
        <p><strong>Name:</strong> <?php echo $full_name; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
        <p><strong>Departure Location:</strong> <?php echo $departure_location; ?></p>
        <p><strong>Arrival Location:</strong> <?php echo $arrival_location; ?></p>
        <p><strong>Departure Time:</strong> <?php echo $departure_time; ?></p>
        <p><strong>Price:</strong> $<?php echo $price; ?></p>

        <!-- Payment form -->
        <form action="transaction.php?booking_id=<?php echo $booking_id; ?>" method="post">
            <label for="amount">Payment Amount:</label>
            <input type="number" id="amount" name="amount" step="0.01" min="<?php echo $price; ?>" value="<?php echo $price; ?>" readonly required>
            <button type="submit">Pay Now</button>
        </form>

        <!-- Success message -->
        <div id="success-message" class="success-message">Payment successful!</div>
    </div>

    <script>
        // Show success message for 2 seconds
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
        }, 2000);
    </script>
</body>
</html>
