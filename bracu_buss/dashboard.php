<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="booking_c.php">Book Ticket</a><br>
    <a href="view_bookings.php">View Bookings</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
