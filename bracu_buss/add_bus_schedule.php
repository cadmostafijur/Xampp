<?php
include 'config.php';
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // handle form submission
    $departure_location = $_POST['departure_location'];
    $arrival_location = $_POST['arrival_location'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $bus_capacity = $_POST['bus_capacity'];
    $price = $_POST['price'];
    // insert into the database
    $sql = "INSERT INTO bus_schedules (departure_location, arrival_location, departure_time, arrival_time, bus_capacity, price) VALUES ('$departure_location', '$arrival_location', '$departure_time', '$arrival_time', '$bus_capacity', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "Buss schedule added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Bus Schedule</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="datetime-local"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Business Schedule</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="departure_location">Departure Location:</label>
            <input type="text" id="departure_location" name="departure_location" required>
            
            <label for="arrival_location">Arrival Location:</label><br>
            <input type="text" id="arrival_location" name="arrival_location" value="BRAC University" readonly><br>
            
            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" id="departure_time" name="departure_time" required>
            
            <label for="arrival_time">Arrival Time:</label>
            <input type="datetime-local" id="arrival_time" name="arrival_time" required>

            <label for="bus_capacity">Bus Capacity:</label>
            <input type="number" id="bus_capacity" name="bus_capacity" required>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>

            <button type="submit">Add Schedule <i class="fas fa-plus-circle"></i></button>
        </form>
    </div>
</body>
</html>
