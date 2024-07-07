<?php
include 'config.php';
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}
// set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="customer_data.csv"');
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
// add CSV headers
fputcsv($output, array('User ID', 'Username', 'Email'));
// retrieve customer data from the database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
// add data rows to CSV file
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array($row['user_id'], $row['username'], $row['email']));
    }
}
// close the file pointer
fclose($output);
// exit script
exit();
?>
