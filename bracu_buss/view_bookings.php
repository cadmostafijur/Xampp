<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // assuming you have stored user_id in the session after login

// fetch user's booking tickets from the database in LIFO order
$sql_tickets = "SELECT * FROM bookings WHERE user_id='$user_id' ORDER BY booking_date DESC";
$result_tickets = $conn->query($sql_tickets);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking Tickets</title>
    <style>
        /* CSS styles */
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

        .booking-ticket {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .booking-info {
            margin-bottom: 5px;
        }

        .payment-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .payment-button:hover {
            background-color: #45a049;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-left: 10px;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        .rejected-message {
            color: #ff0000;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Tickets</h1>
        <?php
        // check if there are any booking tickets
        if ($result_tickets->num_rows > 0) {
            // display booking tickets
            while ($row = $result_tickets->fetch_assoc()) {
                echo '<div class="booking-ticket">';
                echo '<div class="booking-info"><strong>Booking PNR:</strong> ' . $row['booking_pnr'] . '</div>';
                echo '<div class="booking-info"><strong>Booking ID:</strong> ' . $row['booking_id'] . '</div>';
                // modified part to get the correct schedule_id
                // if ($row['departure_location'] === 'Brac University') {
                //     $schedule = $row['schedule_id_2'];
                // } elseif($row['arrival_location'] === 'Brac University')  {
                //     $schedule = $row['schedule_id'];
                // }
                // $schedule = "N/A"; 
                // if ($row['arrival_location'] === 'Brac University') {
                //     $schedule = $row['schedule_id'];
                // }
                // else{
                //     $schedule = $row['schedule_id_2'];
                // }
                if ($row['departure_location'] === 'BRAC University') {
                    $schedule_id = $row['schedule_id_2'];
                } elseif ($row['arrival_location'] === 'BRAC University') {
                    $schedule_id = $row['schedule_id'];
                } else {
                    // default schedule ID
                    $schedule_id = $row['schedule_id'];
                }
                
                echo '<div class="booking-info"><strong>Schedule ID:</strong> ' . $schedule_id . '</div>';
                echo '<div class="booking-info"><strong>Booking Date:</strong> ' . $row['booking_date'] . '</div>';
                echo '<div class="booking-info"><strong>Journey Date:</strong> ' . $row['journey_date'] . '</div>'; // Add journey_date
                echo '<div class="booking-info"><strong>Departure Location:</strong> ' . $row['departure_location'] . '</div>';
                echo '<div class="booking-info"><strong>Arrival Location:</strong> ' . $row['arrival_location'] . '</div>';
                // echo '<div class="booking-info"><strong>Departure Time:</strong> ' . $row['departure_time'] . '</div>';
                // if departure location is in bus_schedules table
$sql_departure_time = "SELECT departure_time FROM bus_schedules WHERE departure_location='" . $row['departure_location'] . "'";
$result_departure_time = $conn->query($sql_departure_time);

if ($result_departure_time->num_rows > 0) {
    $departure_time_row = $result_departure_time->fetch_assoc();
    $departure_time = $departure_time_row['departure_time'];
} else {
    // If departure location is not found in bus_schedules, check bus_schedules_2 table
    $sql_departure_time_2 = "SELECT departure_time FROM bus_schedules_2 WHERE departure_location='" . $row['departure_location'] . "'";
    $result_departure_time_2 = $conn->query($sql_departure_time_2);

    if ($result_departure_time_2->num_rows > 0) {
        $departure_time_row_2 = $result_departure_time_2->fetch_assoc();
        $departure_time = $departure_time_row_2['departure_time'];
    } else {
        $departure_time = "N/A"; // If departure location is not found in either table
    }
}

// Display the departure time
echo '<div class="booking-info"><strong>Departure Time:</strong> ' . $departure_time . '</div>';

                echo '<div class="booking-info"><strong>Price:</strong> $' . $row['price'] . '</div>';
                echo '<div class="booking-info"><strong>Status:</strong> ' . $row['status'] . '</div>';
                if ($row['status'] === 'rejected') {
                    echo '<div class="rejected-message">Admin has canceled your ticket.</div>';
                } elseif ($row['status'] === 'pending') {
                    echo '<a href="transaction.php?booking_id=' . $row['booking_id'] . '" class="payment-button">Make Payment</a>';
                    if (strtotime($row['departure_time']) - time() > 3600) {
                        echo '<a href="cancel_ticket.php?booking_id=' . $row['booking_id'] . '" class="cancel-button">Cancel Ticket</a>';
                    }
                } else {
                    // Check if payment is complete
                    $sql_check_payment = "SELECT * FROM transactions WHERE booking_id='" . $row['booking_id'] . "'";
                    $result_check_payment = $conn->query($sql_check_payment);
                    if ($result_check_payment->num_rows > 0) {
                        echo '<a href="print_ticket.php?booking_id=' . $row['booking_id'] . '" class="payment-button">Print Ticket</a>';
                        echo '<a href="cancel_ticket.php?booking_id=' . $row['booking_id'] . '" class="cancel-button">Cancel Ticket</a>';
                    }
                }                
                echo '</div>';
            }
        } else {
            echo "<p>No booking tickets found for this user.</p>";
            //echo '<script>alert(No booking tickets found for this user.)</script>';
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
