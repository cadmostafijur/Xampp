<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];

    // Update the status in the database
    $sql = "UPDATE bookings SET status = 'rejected' WHERE booking_id = $booking_id";

    if ($conn->query($sql) === TRUE) {
        echo "Booking rejected successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch only pending bookings
$sql = "SELECT * FROM bookings WHERE status = 'pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .reject-form {
            float: right;
            margin-bottom: 20px;
        }

        .reject-btn {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .reject-btn:hover {
            background-color: #d32f2f;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            margin-top: 20px;
        }

        .status-approved {
            color: green;
        }

        .status-rejected {
            color: red;
        }
    </style>
    
</head>
<body>
    
    <h2>Reject Ticket</h2>
    <form action="reject_ticket.php" method="post" class="reject-form">
        <label for="booking_id">Enter Booking ID to Reject:</label>
        <input type="text" id="booking_id" name="booking_id" required>
        <button type="submit" class="reject-btn">Reject Booking</button>
    </form>

    <table>
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Schedule ID</th>
            <th>Booking Date</th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Departure Time</th>
            <th>Price</th>
            <th>Status</th> 
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['booking_id'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['schedule_id'] . "</td>";
                echo "<td>" . $row['booking_date'] . "</td>";
                echo "<td>" . $row['departure_location'] . "</td>";
                echo "<td>" . $row['arrival_location'] . "</td>";
                echo "<td>" . $row['departure_time'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                // apply different colors based on status
                if ($row['status'] == 'approved') {
                    echo "<td class='status-approved'>" . $row['status'] . "</td>";
                } elseif ($row['status'] == 'rejected') {
                    echo "<td class='status-rejected'>" . $row['status'] . "</td>";
                } else {
                    echo "<td>" . $row['status'] . "</td>"; // display pending status normally
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='no-data'>No pending bookings found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
