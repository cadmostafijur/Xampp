<?php
session_start();

// Logout logic
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "university_bus_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process admin reply form submission
if(isset($_POST['submit_reply'])) {
    $review_id = $_POST['review_id'];
    $admin_reply = $_POST['admin_reply'];

    // Update the user review with admin reply
    $sql = "UPDATE user_reviews SET admin_reply = ? WHERE review_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $admin_reply, $review_id);
    $stmt->execute();
    $stmt->close();
}

// Process review deletion
if(isset($_POST['delete_review'])) {
    $review_id = $_POST['review_id'];

    // Delete the review from the database
    $sql = "DELETE FROM user_reviews WHERE review_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews</title>
    <style>
        /* CSS for the light blue theme */
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

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .reviews {
            margin-top: 20px;
        }

        .review {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f5f5f5; /* Light gray review background */
            border-radius: 10px;
        }

        .review p {
            margin: 10px 0;
        }

        .review p strong {
            font-weight: bold;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            resize: vertical;
        }

        button {
            background-color: #5bc0de; /* Light blue button */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #4da9c9; /* Slightly darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Reviews</h2>

        <!-- Review Form -->
        <!-- Add your review form here if needed -->

        <!-- User Reviews and Admin Replies -->
        <div class="reviews">
            <?php
            // SQL command to retrieve user reviews and admin replies
            $sql = "SELECT u.full_name, r.* FROM user_reviews r JOIN users u ON r.user_id = u.user_id ORDER BY r.timestamp DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<p><strong>User:</strong> " . $row['full_name'] . "</p>";
                    echo "<p><strong>Date of Travel:</strong> " . $row['timestamp'] . "</p>";
                    echo "<p><strong>Rating:</strong> " . $row['rating'] . "</p>";
                    echo "<p><strong>Comment:</strong> " . $row['comment'] . "</p>";
                    echo "<p><strong>Admin Reply:</strong> " . $row['admin_reply'] . "</p>";

                    // Admin reply form
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='review_id' value='" . $row['review_id'] . "'>";
                    echo "<textarea name='admin_reply' rows='3' cols='50' placeholder='Enter your reply...'></textarea>";
                    echo "<br>";
                    echo "<button type='submit' name='submit_reply'>Submit Reply</button>";
                    echo "</form>";

                    // Delete button
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='review_id' value='" . $row['review_id'] . "'>";
                    echo "<button type='submit' name='delete_review'>Delete Review</button>";
                    echo "</form>";

                    echo "</div>";
                }
            } else {
                echo "No reviews yet.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
