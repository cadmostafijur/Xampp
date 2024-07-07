<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

$sql = "SELECT * FROM bus_schedules";
$result = $conn->query($sql);

$sql_table2 = "SELECT * FROM bus_schedules_2";
$result_table2 = $conn->query($sql_table2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Schedules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .admin-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50; /* Green */
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Button hover effect */
        .admin-btn:hover {
            background-color: #45a049; /* Darker green */
        }

        /* Button icon */
        .admin-btn i {
            margin-right: 5px;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            text-align: left;
        }
    </style>
</head>
<body>
    <a href="admin_dashboard.php" class="admin-btn">
    <i class="fas fa-user-plus"></i> Admin Dashboard
    </a>
    <h2>Bus Schedules</h2>
    
    <table>
        <tr>
            <th>Schedule ID</th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Departure Time</th>
            <th>Arrival ime</th>
            <th>Bus Capacity</th>
            <th>Price</th>
            <th>Available seats</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['schedule_id'] . "</td>";
                echo "<td>" . $row['departure_location'] . "</td>";
                echo "<td>" . $row['arrival_location'] . "</td>";
                echo "<td>" . $row['departure_time'] . "</td>";
                echo "<td>" . $row['arrival_time'] . "</td>";
                echo "<td>" . $row['bus_capacity'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['available_seats'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No Busses found</td></tr>";
        }
        ?>
    </table>
    <table>
        <tr>
            <th>Schedule ID</th>
            <th>Departure Location</th>
            <th>Arrival Location</th>
            <th>Departure Time</th>
            <th>Arrival ime</th>
            <th>Bus Capacity</th>
            <th>Price</th>
            <th>Available seats</th>
        </tr>
        <?php
        if ($result_table2->num_rows > 0) {
            while ($row = $result_table2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['schedule_id_2'] . "</td>";
                echo "<td>" . $row['departure_location'] . "</td>";
                echo "<td>" . $row['arrival_location'] . "</td>";
                echo "<td>" . $row['departure_time'] . "</td>";
                echo "<td>" . $row['arrival_time'] . "</td>";
                echo "<td>" . $row['bus_capacity'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['available_seats'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No Busses found</td></tr>";
        }
        ?>
   
</body>
</html>
