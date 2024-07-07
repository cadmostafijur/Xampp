<?php
include 'config.php';
session_start();

// check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the booking_id is provided in the URL
if (!isset($_GET['booking_id'])) {
    // Redirect back to view_bookings.php if booking_id is not provided
    header("Location: view_bookings.php");
    exit();
}

// get the booking ID from the URL
$booking_id = $_GET['booking_id'];

// fetch booking details from the database
$sql = "SELECT b.*, u.full_name, u.phone_number FROM bookings b 
        INNER JOIN users u ON b.user_id = u.user_id
        WHERE b.booking_id = '$booking_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    $departure_location = $booking['departure_location'];
    $arrival_location = $booking['arrival_location'];
    $departure_time = $booking['departure_time'];
    $price = $booking['price'];
    $full_name = $booking['full_name'];
    $phone_number = $booking['phone_number'];
    $booking_pnr = $booking['booking_pnr']; 
    // Fetching booking PNR from the database
} else {
    // Redirect back to view_bookings.php if booking not found
    header("Location: view_bookings.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ticket</title>
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; 
            /* Light blue background */
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff; 
            /* White container background */
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

        /* Ticket details styles */
        .ticket-details {
            margin-bottom: 20px;
        }

        .ticket-details p {
            margin: 10px 0;
        }

        .ticket-details p strong {
            font-weight: bold;
        }

        /* Print button styles */
        .print-button {
            text-align: center;
        }

        .print-button button {
            padding: 10px 20px;
            background-color: #007bff; /* Blue */
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .print-button button:hover {
            background-color: #0056b3; 
            /* Darker blue on hover */
        }

        /* Payment received stamp */
        .payment-received {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>
    <header>
        <h1>Ticket Details</h1>
    </header>

    <div class="container">
        <div class="ticket-details">
            <p><strong>Name:</strong> <?php echo $full_name; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
            <p><strong>Booking PNR:</strong> <?php echo $booking_pnr; ?></p>
            <p><strong>Departure Location:</strong> <?php echo $departure_location; ?></p>
            <p><strong>Arrival Location:</strong> <?php echo $arrival_location; ?></p>
            <p><strong>Departure Time:</strong> <?php echo $departure_time; ?></p>
            <p><strong>Price:</strong> $<?php echo $price; ?></p>
        </div>

        <!-- Payment received -->
        <div class="payment-received">
            Payment Received
        </div>

        <div class="print-button">
            <button onclick="window.print()">Print Ticket</button>
        </div>
    </div>
</body>
</html>
